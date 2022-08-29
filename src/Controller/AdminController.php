<?php

namespace App\Controller;

use Exception;

/**
 * Class AdminController controller for Admin
 */
class AdminController extends FrontController
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->get('auth')) {
            $this->session->set('warning', "Connectez-vous pour accéder à cette page");
            try {
                FrontController::connect();
            } catch (Exception $e) {
            }
        }

        if ($this->session->get('auth')) {
            if ($this->session->get('auth')->getUserstatus() != 1) {
                FrontController::home();
            }
        }
    }

    public function __destruct()
    {
        $this->session->remove('warning');
        $this->session->remove('success');
    }
}
