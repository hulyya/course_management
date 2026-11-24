<?php
namespace src\app\view\auth;

use src\app\view\Page;

class Login extends Page{
    public function render(): string{
        return $this->template->render('auth/login.html.twig',['data' => $this->data]);
    }
}
?>