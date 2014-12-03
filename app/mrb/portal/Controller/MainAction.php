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
use mrb\portal\Controller\Profile\ProfileAction;
use mrb\portal\Model\MRBConfig;
use mrb\portal\Model\MRBModel;
use mrb\portal\Portal;
use mrb\portal\Controller\Home\DashboardAction;

class MainAction
{
    public function __construct(Portal $portal){
        $this->portal = $portal;

        $this->model = new MRBModel();
        $this->model->setQueries($portal->request->params());
        $this->model->setKeyDoc($portal->getCookie(MRBConfig::COOKIE_KEYDOC));
        $this->model->setUsername($portal->getCookie(MRBConfig::COOKIE_USERNAME));
    }

    public function pageRendering($page){
        $template = "";
        $params = [];
        if($page == "" || !(isset($_SERVER['HTTP_COOKIE']))) $page = MRBConfig::PAGE_LOGIN;
        switch($page){
            case MRBConfig::PAGE_HOME:
                $dashboard = new DashboardAction($this->model);
                if(isset($_GET['prevdate']) || isset($_GET['nextdate'])){
                    $dashboard->setPrevNextDate();
                }
                $template = "Home/home.twig";
                $params = [
                    'date' => $dashboard->getDate(),
                    'status' => $dashboard->getAmalanToday(),
                    'chart' => $dashboard->calcChart(),
                    'isJdwlPuasa' => $dashboard->isJdwlPuasa()
                ];
                break;

            case MRBConfig::PAGE_STATISTIK:
                $template = "Home/statistik.twig";
                $params = [
                    'filename' => $this->portal->getCookie(MRBConfig::COOKIE_KEYDOC)
                ];
                break;

            case MRBConfig::PAGE_LOGIN:
                $template = "Login/login.twig";
                break;

            case MRBConfig::PAGE_LOGOUT:
                $this->model->removedAllCookies();
                $template = "Login/login.twig";
                break;

            case MRBConfig::PAGE_NEWUSER:
                $newUser = new NewUserAction($this->portal);
                $newUser->action();
                $template = "Login/login.twig";
                break;

            case MRBConfig::PAGE_PROFILE:
                $profile = new ProfileAction($this->model);
                $params = [
                    'logininfo' => $profile->getLoginData()
                ];
                $template = "Profile/profile.twig";
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
                $login = new LoginAction($this->model);
                $this->portal->setCookie(MRBConfig::COOKIE_KEYDOC, $login->setKeyDoc(), '1 day');
                $this->portal->setCookie(MRBConfig::COOKIE_USERNAME, $login->setUsername(), '1 day');
                $this->portal->redirect($login->forwardUrl());
                break;

            case MRBConfig::PAGE_GETJSON:
                $getJson = new StatistikAction($this->model);

                $response = $this->portal->response();
                $response['Content-type'] = 'application/json';
                $response->body($getJson->generateJSON());
                break;

            case MRBConfig::PAGE_PROFILE:
                $profile = new ProfileAction($this->model);
                $profile->getAction($this->model->getQueryFromKey('action'));

                $this->pageRendering($page);
                break;
        }
    }
}