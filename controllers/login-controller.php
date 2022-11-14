<?php
    class LoginController extends MainController
    {
        public function index()
        {
            // /views/login/login-view.php
            require ABSPATH.'/views/login/login-view.html';

        }// index

        public function getTitle(){
            return 'Login';
        }

        public function getJsFile(){
            return HOME_URI.'/views/_js/login.js';
        }

    }// class LoginController
?>
