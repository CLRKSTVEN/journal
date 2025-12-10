<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    protected $appSlug;

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'session'));
        $this->load->helper(array('url', 'form'));
        $this->load->database();
        $this->appSlug = app_slug();
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect($this->appSlug . '/admin');
            return;
        }

        $this->load->view('home_page');
    }

    public function auth()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('danger', strip_tags(validation_errors()));
            redirect('login');
            return;
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $query = $this->db->get_where('users', array('username' => $username), 1);
        $user  = $query->row();

        if (!$user || !$this->is_valid_password($password, $user->password)) {
            $this->session->set_flashdata('danger', 'Invalid username or password.');
            redirect('login');
            return;
        }

        $this->session->set_userdata(array(
            'logged_in' => TRUE,
            'userID'    => $user->userID,
            'IDNumber'  => $user->IDNumber,
            'username'  => $user->username,
            'name'      => trim($user->fName . ' ' . $user->lName),
            'fName'     => $user->fName,
            'fname'     => $user->fName, // some views expect lowercase
            'lName'     => $user->lName,
            'email'     => $user->email,
            'position'  => $user->position,
            'avatar'    => $user->avatar ?? 'default.png',
        ));

        $this->session->set_flashdata('success', 'Welcome back, ' . ($user->fName ?: $user->username) . '!');
        redirect($this->appSlug . '/admin');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    // Placeholder routes to avoid 404s from the links on the login page
    public function registration()
    {
        $this->session->set_flashdata('danger', 'Self-service registration is disabled. Please contact the administrator.');
        redirect('login');
    }

    public function forgot()
    {
        $this->session->set_flashdata('danger', 'Password reset is not enabled yet. Please contact the administrator.');
        redirect('login');
    }

    private function is_valid_password($input, $storedHash)
    {
        if (password_verify($input, $storedHash)) {
            return true;
        }

        // Graceful fallback if legacy plain-text passwords ever exist
        return hash_equals($storedHash, $input);
    }
}
