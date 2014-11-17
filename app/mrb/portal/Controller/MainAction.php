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
use mrb\portal\Controller\DashboardAction;

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
                'status' => $statusAmalan
            ]
        );
    }

    public function pageRendering(){

    }

    public function statistikAmalan()
    {
        $this->portal->render(
            'Home/statistik.twig',
            [

            ]);
    }
}