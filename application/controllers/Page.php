<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{
    protected $appSlug;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->database();
        $this->appSlug = app_slug();
    }

    public function admin()
    {
        // Reuse the journalism admin console to keep a single source of truth
        redirect(app_url('admin'));
    }

    public function change_password()
    {
        $this->require_login();

        $userID = $this->session->userdata('userID');
        $user = $this->User_model->get_by_id($userID);
        if (!$user) {
            $this->session->set_flashdata('danger', 'Account not found. Please log in again.');
            redirect('login');
            return;
        }

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]|trim');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]|trim');

            if ($this->form_validation->run()) {
                $current = $this->input->post('current_password', TRUE);
                $newPass = $this->input->post('new_password', TRUE);

                if (!$user || !$this->verify_password($current, $user->password)) {
                    $this->session->set_flashdata('danger', 'Current password is incorrect.');
                    redirect('Page/change_password');
                    return;
                }

                $hash = password_hash($newPass, PASSWORD_BCRYPT);
                $this->User_model->reset_password($userID, $hash);
                $this->session->set_flashdata('success', 'Password updated successfully.');
                redirect('Page/change_password');
                return;
            }
        }

        $data['user'] = $user;
        $this->load->view('account_change_password', $data);
    }

    public function profile()
    {
        $this->require_login();

        $userID = $this->session->userdata('userID');
        $user = $this->User_model->get_by_id($userID);
        if (!$user) {
            $this->session->set_flashdata('danger', 'Account not found. Please log in again.');
            redirect('login');
            return;
        }

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('fName', 'First Name', 'required|trim');
            $this->form_validation->set_rules('lName', 'Last Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
            $this->form_validation->set_rules('position', 'Position', 'required|trim');

            if ($this->form_validation->run()) {
                $update = array(
                    'fName'    => $this->input->post('fName', TRUE),
                    'mName'    => $this->input->post('mName', TRUE),
                    'lName'    => $this->input->post('lName', TRUE),
                    'email'    => $this->input->post('email', TRUE),
                    'position' => $this->input->post('position', TRUE),
                    'IDNumber' => $this->input->post('IDNumber', TRUE),
                );

                if (!empty($_FILES['avatar']['name'])) {
                    $upload = $this->handle_avatar_upload($user->username);
                    if ($upload['success']) {
                        $update['avatar'] = $upload['file_name'];
                        $this->session->set_userdata('avatar', $upload['file_name']);
                    } else {
                        $this->session->set_flashdata('danger', $upload['error']);
                        redirect('Page/profile');
                        return;
                    }
                }

                $this->User_model->update($userID, $update);

                // refresh session data for displayed name/email
                $this->session->set_userdata(array(
                    'username' => $user->username,
                    'fName'    => $update['fName'],
                    'fname'    => $update['fName'],
                    'lName'    => $update['lName'],
                    'email'    => $update['email'],
                    'position' => $update['position'],
                    'IDNumber' => $update['IDNumber'],
                    'avatar'   => $update['avatar'] ?? $this->session->userdata('avatar'),
                ));

                $this->session->set_flashdata('success', 'Profile updated successfully.');
                redirect('Page/profile');
                return;
            }
        }

        $data['user'] = $user;
        $this->load->view('account_profile', $data);
    }

    public function manage_users()
    {
        $this->require_login();

        $hasStatus = $this->db->field_exists('is_active', 'users');

        if ($this->input->post('action')) {
            $action = $this->input->post('action', TRUE);
            $currentUserId = $this->session->userdata('userID');

            switch ($action) {
                case 'add':
                    $this->form_validation->set_rules('username', 'Username', 'required|trim');
                    $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|trim');
                    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]|trim');
                    $this->form_validation->set_rules('fName', 'First Name', 'required|trim');
                    $this->form_validation->set_rules('lName', 'Last Name', 'required|trim');

                    if ($this->form_validation->run()) {
                        $username = $this->input->post('username', TRUE);
                        $existing = $this->User_model->get_by_username($username);
                        if ($existing) {
                            $this->session->set_flashdata('danger', 'Username already exists.');
                            redirect('Page/manage_users');
                            return;
                        }

                        $email = $this->input->post('email', TRUE);
                        if (!empty($email)) {
                            $existingEmail = $this->User_model->get_by_email($email);
                            if ($existingEmail) {
                                $this->session->set_flashdata('danger', 'Email already exists.');
                                redirect('Page/manage_users');
                                return;
                            }
                        }

                        $idNumber = $this->input->post('IDNumber', TRUE);
                        if (!empty($idNumber)) {
                            $existingId = $this->User_model->get_by_idnumber($idNumber);
                            if ($existingId) {
                                $this->session->set_flashdata('danger', 'ID Number already exists.');
                                redirect('Page/manage_users');
                                return;
                            }
                        }

                        $avatarFile = null;
                        if (!empty($_FILES['avatar']['name'])) {
                            $upload = $this->handle_avatar_upload($username);
                            if ($upload['success']) {
                                $avatarFile = $upload['file_name'];
                            } else {
                                $this->session->set_flashdata('danger', $upload['error']);
                                redirect('Page/manage_users');
                                return;
                            }
                        }

                        $data = array(
                            'username'  => $username,
                            'password'  => password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT),
                            'fName'     => $this->input->post('fName', TRUE),
                            'mName'     => $this->input->post('mName', TRUE),
                            'lName'     => $this->input->post('lName', TRUE),
                            'email'     => $this->input->post('email', TRUE),
                            'position'  => $this->input->post('position', TRUE),
                            'IDNumber'  => $this->input->post('IDNumber', TRUE),
                            'avatar'    => $avatarFile ?: 'default.png',
                            'dateCreated' => date('Y-m-d H:i:s'),
                        );
                        if ($hasStatus) {
                            $data['is_active'] = 1;
                        }

                        $this->User_model->create($data);
                        $this->session->set_flashdata('success', 'User added successfully.');
                        redirect('Page/manage_users');
                        return;
                    }
                    break;

                case 'reset':
                    $userId = (int)$this->input->post('user_id');
                    $target = $this->User_model->get_by_id($userId);
                    if (!$target) {
                        $this->session->set_flashdata('danger', 'User not found.');
                        redirect('Page/manage_users');
                        return;
                    }
                    $target = $this->User_model->get_by_id($userId);
                    if (!$target) {
                        $this->session->set_flashdata('danger', 'User not found.');
                        redirect('Page/manage_users');
                        return;
                    }
                    $newPassword = $this->generate_password(10);
                    $hash = password_hash($newPassword, PASSWORD_BCRYPT);
                    $this->User_model->reset_password($userId, $hash);
                    $this->session->set_flashdata('success', 'Password reset successfully. New password: ' . $newPassword);
                    redirect('Page/manage_users');
                    return;

                case 'delete':
                    $userId = (int)$this->input->post('user_id');
                    $target = $this->User_model->get_by_id($userId);
                    if (!$target) {
                        $this->session->set_flashdata('danger', 'User not found.');
                        redirect('Page/manage_users');
                        return;
                    }
                    if ($userId === (int)$currentUserId) {
                        $this->session->set_flashdata('danger', 'You cannot delete your own account.');
                        redirect('Page/manage_users');
                        return;
                    }
                    $this->User_model->delete($userId);
                    $this->session->set_flashdata('success', 'User deleted.');
                    redirect('Page/manage_users');
                    return;

                case 'toggle':
                    $userId = (int)$this->input->post('user_id');
                    $active = (bool)$this->input->post('active');
                    $target = $this->User_model->get_by_id($userId);
                    if (!$target) {
                        $this->session->set_flashdata('danger', 'User not found.');
                        redirect('Page/manage_users');
                        return;
                    }
                    if (!$hasStatus) {
                        $this->session->set_flashdata('danger', 'Activation is not available (missing is_active column).');
                        redirect('Page/manage_users');
                        return;
                    }
                    $this->User_model->toggle_active($userId, $active);
                    $this->session->set_flashdata('success', $active ? 'User activated.' : 'User deactivated.');
                    redirect('Page/manage_users');
                    return;
            }
        }

        $data['users'] = $this->User_model->get_all();
        $data['has_status'] = $hasStatus;
        $data['open_modal'] = ($this->input->post('action') === 'add' && !empty(validation_errors())) ? 'addUserModal' : null;
        $this->load->view('account_manage_users', $data);
    }

    public function check_username()
    {
        $this->require_login();
        $username = $this->input->get_post('username', TRUE);
        $exists = false;

        if ($username) {
            $exists = $this->User_model->get_by_username($username) ? true : false;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'username' => $username,
                'exists'   => $exists
            )));
    }

    public function check_email()
    {
        $this->require_login();
        $email = $this->input->get_post('email', TRUE);
        $exists = false;

        if ($email) {
            $exists = $this->User_model->get_by_email($email) ? true : false;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'email'  => $email,
                'exists' => $exists
            )));
    }

    public function check_idnumber()
    {
        $this->require_login();
        $idNumber = $this->input->get_post('idNumber', TRUE);
        $exists = false;

        if ($idNumber) {
            $exists = $this->User_model->get_by_idnumber($idNumber) ? true : false;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'idNumber' => $idNumber,
                'exists'   => $exists
            )));
    }

    private function verify_password($input, $storedHash)
    {
        if (password_verify($input, $storedHash)) {
            return true;
        }

        return hash_equals((string)$storedHash, (string)$input);
    }

    private function require_login()
    {
        if (!$this->session->userdata('userID')) {
            $this->session->set_flashdata('danger', 'Please log in to continue.');
            redirect('login');
            exit;
        }
    }

    private function generate_password($length = 10)
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%^&*';
        $bytes = random_bytes($length);
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[ord($bytes[$i]) % strlen($chars)];
        }
        return $password;
    }

    private function handle_avatar_upload($username)
    {
        $uploadDir = rtrim(FCPATH, '/\\') . '/upload/profile/';
        $config['upload_path']      = $uploadDir;
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']         = 2048;
        $config['file_ext_tolower'] = TRUE;
        $config['overwrite']        = FALSE;
        $config['file_name']        = 'avatar_' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $username) . '_' . time();

        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
            return array(
                'success' => false,
                'error'   => 'Upload directory is not writable: ' . $uploadDir . '. Please check folder permissions.'
            );
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('avatar')) {
            return array('success' => false, 'error' => $this->upload->display_errors('', ''));
        }

        $data = $this->upload->data();
        return array('success' => true, 'file_name' => $data['file_name']);
    }
}
