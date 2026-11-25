<?php
namespace src\app\view\admin;

use src\app\view\Page;
class AdminCourseSessionEdit extends Page{
    public function render(): string{
        return $this->template->render('admin/course_edit.html.twig' ,['data' => $this->data]);
    }
}