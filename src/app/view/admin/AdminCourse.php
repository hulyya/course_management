<?php
namespace src\app\view\admin;

use src\app\view\Page;

class AdminCourse extends Page{
    public function render():string{
        return $this->template->render('admin/course.html.twig',['data' => $this->data]);
    }
}