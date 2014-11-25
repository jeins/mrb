<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 13.11.14
 * Time: 16:02
 */

namespace mrb\portal;

use mrb\portal\Controller\Admin\NewUserAction;
use mrb\portal\Model\MRBConfig;
use mrb\portal\Model\MRBModel;
use Slim\Slim;
use Slim\Views\Twig as Twig;
use Slim\Views\TwigExtension as TwigExtension;
use mrb\portal\Controller\MainAction;
use Symfony\Component\Yaml\Yaml as Yaml;


class Portal extends Slim
{
    public function __construct()
    {
        $this->twigView = new Twig();
        $this->twigView->parserExtensions = array(new TwigExtension());
        $this->config = Yaml::parse(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/../etc/config.yml', true));

        parent::__construct(
            [
                'view' => $this->twigView,
                'mode' => 'development',
                'debug' => true,
                'templates.path' => $_SERVER['DOCUMENT_ROOT'] . '/../etc/templates',
                'cookies.encrypt' => true,
                'cookies.secret_key' => $this->config['security']['key'],
                'cookies.cipher' => MCRYPT_RIJNDAEL_256,
                'cookies.cipher_mode' => MCRYPT_MODE_CBC
            ]
        );

        date_default_timezone_set('Europe/Berlin');
        $this->setupRouting();
    }

    private function setupRouting()
    {
        $main = new MainAction($this);

        $this->get('/', function() use($main){
            $main->pageRendering(MRBConfig::PAGE_LOGIN);
        });

        $this->get('/:page', function($page) use($main){
            $main->pageRendering($page);
        });
        $this->post('/:page', function($page) use ($main){
            $main->pageAction($page);
        });

        //ADMIN
        //Create New User
        $this->get('/tambahjamaah', function(){
            $user = new NewUserAction($this);
            $user->action();
        });
    }
}