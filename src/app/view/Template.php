<?php
namespace src\app\view;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class Template{
    private static ?Template $instance = null;
    protected Environment $twig;

private const TEMPLATE_PATH = __DIR__ . '/../../templates';

    function __construct(){
        $loader = new FilesystemLoader(self::TEMPLATE_PATH);
        $this->twig = new Environment($loader);
    }

    public function render(string $template, array $context = []): String{
        return $this->twig->render($template, $context);
    }

    public static function getInstance():Template{
        if(!self::$instance){
            self::$instance =new Template();
        }
        return self::$instance;
    }
}
?>