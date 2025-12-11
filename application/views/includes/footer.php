<link rel="stylesheet" href="<?= base_url('assets/css/request-bell.css'); ?>">
<script src="<?= base_url('assets/js/req-bell.js'); ?>"></script>
<script src="<?= base_url('assets/js/masterlist-mobile.js'); ?>"></script>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <p class="mb-0"
                    style="cursor:pointer"
                    data-toggle="modal"
                    data-target="#fbmsoVisionMissionModal">
                    <b>Davao Oriental Journalism Contest. © 2025</b> All rights reserved.
                </p>
            </div>
        </div>
    </div>

</footer>

<style>
    :root {
        --fbm-black: #101214;
        --fbm-yellow: #ffcc00;
        --fbm-yellow-soft: #fff6cc;
        --fbm-gray: #6c757d;
    }

    #fbmsoVisionMissionModal.modal {
        z-index: 20000;
    }

    #fbmsoVisionMissionModal.modal {
        z-index: 20000;
    }

    #fbmsoVisionMissionModal .modal-header {
        border-bottom: 0;
        background: linear-gradient(90deg, var(--fbm-black) 0%, var(--fbm-yellow) 100%);
        color: #fff;
        padding: 0.85rem 1rem;
    }

    #fbmsoVisionMissionModal .modal-title {
        color: #fff;
    }

    #fbmsoVisionMissionModal .brand-wrap small {
        color: rgba(255, 255, 255, .9);
    }

    #fbmsoVisionMissionModal .brand-wrap img {
        width: 54px;
        height: 54px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, .22);
        border: 2px solid rgba(255, 255, 255, .7);
        transition: transform .15s ease, box-shadow .15s ease;
    }

    #fbmsoVisionMissionModal .brand-wrap a:hover img {
        transform: translateY(-1px) scale(1.02);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .28);
    }

    #fbmsoVisionMissionModal .section-title {
        letter-spacing: .08em;
        font-weight: 800;
        font-size: .78rem;
        color: var(--fbm-black);
    }

    #fbmsoVisionMissionModal .lead-vision {
        font-style: italic;
        background: var(--fbm-yellow-soft);
        border-left: 4px solid var(--fbm-yellow);
        padding: .8rem 1rem;
        border-radius: .35rem;
    }

    #fbmsoVisionMissionModal .mission-wrap {
        border-left: 3px solid rgba(16, 18, 20, .08);
        padding-left: .9rem;
    }

    #fbmsoVisionMissionModal ol>li {
        margin-bottom: .45rem;
    }

    #fbmsoVisionMissionModal .btn-close-fbm {
        background: var(--fbm-yellow);
        border-color: var(--fbm-yellow);
        color: #101214;
        font-weight: 600;
    }

    #fbmsoVisionMissionModal .btn-close-fbm:hover {
        filter: brightness(.95);
        color: #101214;
    }
</style>