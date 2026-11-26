<?php
namespace src\app\view\admin;

use src\app\view\Page;

class AdminUser extends Page{
    public function render():string{
        return $this->template->render('admin/user.html.twig',['data' => $this->data]);
    }
}
?>