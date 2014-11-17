<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 12.11.14
 * Time: 16:41
 */

namespace mrb\portal\Controller;

use mrb\portal\Portal;

class MainAction
{
    public function __construct(Portal $portal){
        $this->portal = $portal;
    }

    public function pageRendering(){
        $this->portal->render(
          'Home/home.twig',
            [
                'params' => [
                    'page' => "aw"
                ]
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