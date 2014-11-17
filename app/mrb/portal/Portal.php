<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 13.11.14
 * Time: 16:02
 */

namespace mrb\portal;

use Slim\Slim;
use Slim\Views\Twig as Twig;
use Slim\Views\TwigExtension as TwigExtension;
use mrb\portal\Controller\MainAction;


class Portal extends Slim
{
    public function __construct()
    {
        $this->twigView = new Twig();
        $this->twigView->parserExtensions = array(new TwigExtension());

        parent::__construct(
            [
                'view' => $this->twigView,
                'mode' => 'development',
                'debug' => true,
                'templates.path' => $_SERVER['DOCUMENT_ROOT'] . '/../etc/templates'
            ]
        );
        $this->setupRouting();
    }

    private function setupRouting()
    {
        $app = Portal::getInstance();
        $main = new MainAction($this);
        $this->get('/', function() use ($app, $main){
            $main->pageRendering();
        });

        $this->get('/statistik', function() use($main){
            $main->statistikAmalan();
        });
    }
}