<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 13.11.14
 * Time: 16:02
 */

namespace mrb\portal;

use mrb\portal\Controller\StatistikAction;
use mrb\portal\Model\MRBModel;
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

        date_default_timezone_set('Europe/Berlin');

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
        $main = new MainAction($this, new MRBModel($app->request()));

        $this->get('/', function() use ($app, $main){
            $main->homeRendering();
        });
        $this->post('/', function() use ($app, $main){
            $main->homeRendering();
        });

        $this->get('/getjson', function() {
           $getJSON = new StatistikAction($this);
            $getJSON->generateJSON();
        });

        $this->get('/statistik', function() use($main){
            $main->statistikAmalan();
        });
    }
}