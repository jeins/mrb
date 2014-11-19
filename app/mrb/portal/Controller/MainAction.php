<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 12.11.14
 * Time: 16:41
 */

namespace mrb\portal\Controller;

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

    public function homeRendering(){
        $dashboard = new DashboardAction($this->model);
        $dashboard->simpanAmalan();
        $statusAmalan = $dashboard->getAmalanToday();
        $statusChart = $dashboard->calcChart();

        $this->portal->render(
            'Home/home.twig',
            [
                'status' => $statusAmalan,
                'chart' => $statusChart
            ]
        );
    }

    public function pageRendering(){
        $this->portal->render(
            'Login/login.twig',
            [
            ]
        );
    }

    public function statistikAmalan()
    {
        $this->portal->render(
            'Home/statistik.twig',
            [

            ]);
    }
}