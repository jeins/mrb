<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 12.11.14
 * Time: 16:41
 */

namespace mrb\portal\Controller;

use mrb\portal\Controller\Admin\NewUserAction;
use mrb\portal\Controller\Home\StatistikAction;
use mrb\portal\Model\MRBConfig;
use mrb\portal\Model\MRBModel;
use mrb\portal\Portal;
use mrb\portal\Controller\Home\DashboardAction;
use mrb\portal\Controller\LoginAction;

class MainAction
{
    public function __construct(Portal $portal, MRBModel $model){
        $this->portal = $portal;
        $this->model = $model;
    }

    public function pageRendering($page){
        $template = "";
        $params = [];
        switch($page){
            case MRBConfig::PAGE_HOME:
                $dashboard = new DashboardAction($this->model);
                $template = "Home/home.twig";
                $params = [
                    'status' => $dashboard->getAmalanToday(),
                    'chart' => $dashboard->calcChart()
                ];
                break;

            case MRBConfig::PAGE_STATISTIK:
                $template = "Home/statistik.twig";
                break;

            case MRBConfig::PAGE_LOGIN:
                $template = "Login/login.twig";
                break;

            case MRBConfig::PAGE_NEWUSER:
                $newUser = new NewUserAction($this->portal);
                $newUser->action();
                break;
        }
        $this->portal->render($template, $params);
    }

    public function pageAction($page){
        switch($page){
            case MRBConfig::PAGE_HOME:
                $dashboard = new DashboardAction($this->model);
                $dashboard->simpanAmalan();
                $this->pageRendering($page);
                break;

            case MRBConfig::PAGE_LOGIN:
                $login = new LoginAction($this->portal);
                $login->forwardUrl();
                break;

            case MRBConfig::PAGE_GETJSON:
                $getJson = new StatistikAction($this->portal);
                $getJson->generateJSON();
                break;
        }
    }
}