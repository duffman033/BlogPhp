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

        if (!self::$session->get('auth')) {
            self::$session->set('warning', "Connectez-vous pour accéder à cette page");
            try {
                $this->app->get('App\Controller\FrontController')->login();
            } catch (Exception $e) {
            }
        }

        if (self::$session->get('auth')) {
            if (self::$session->get('auth')->getUserstatus() != 1) {
                $this->app->get('App\Controller\FrontController')->home();
            }
        }
    }
}
