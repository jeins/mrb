<?php
/**
 * Created by PhpStorm.
 * User: akbar
 * Date: 17.11.14
 * Time: 16:25
 */

namespace mrb\portal\Controller;

class Functions{
    public function getWeeks($timestamp){
        $maxday    = date("t",$timestamp);
        $thismonth = getdate($timestamp);
        $timeStamp = mktime(0,0,0,$thismonth['mon'],1,$thismonth['year']);
        $startday  = date('w',$timeStamp);
        $day = $thismonth['mday'];
        $weeks = 0;
        $week_num = 0;

        for ($i=0; $i<($maxday+$startday); $i++) {
            if(($i % 7) == 0){
                $weeks++;
            }
            if($day == ($i - $startday + 1)){
                $week_num = $weeks;
            }
        }
        return $week_num;
    }
}