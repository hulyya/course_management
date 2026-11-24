<?php
namespace src\app\view;

abstract class Page{
    protected Template $template;
    protected array $data = [];
    public function __construct(){
        $this->template = Template::getInstance();
    }
    public function setData(array $data):void {
        $this->data = $data;
    }
    abstract public function render():string;
}
?>