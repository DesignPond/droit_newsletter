<?php

namespace designpond\newsletter\Newsletter\Worker;

class Charts{

    public $colors;
    public $labels;

    public function __construct()
    {
        $this->colors = array('#4f5259','#34495e','#4f8edc','#85c744','#f1c40f','#4f8edc','#85c744','#2bbce0','#76c4ed','#34495e','#16a085','#e73c68','#b8c6d5');
        $this->labels = array(
            1  => "Janvier",
            2  => "Février",
            3  => "Mars",
            4  => "Avril",
            5  => "Mai",
            6  => "Juin",
            7  => "Juillet",
            8  => "Août",
            9  => "Septembre",
            10 => "Octobre",
            11 => "Novembre",
            12 => "Décembre");
    }

    public function compileStats($stats)
    {
        if(!empty($stats))
        {
            // Datas
            $sent    =  $stats->DeliveredCount;
            $clic    =  $stats->ClickedCount;
            $open    =  $stats->OpenedCount;
            $bounce  =  $stats->BouncedCount;

            $openclic = 0;
            $onlyopen = 0;
            $nonopen  = 0;

            if($sent > 0){
                // Calculations
                $nonopen  = ($sent - ($open + $bounce))/$sent;
                $openclic = ($clic)/$sent;
                $onlyopen = $open/$sent;
                $bounce   = $bounce/$sent;
            }

            $data['total']     = $sent;
            $data['clicked']   = round($openclic * 100, 2);
            $data['opened']    = round($onlyopen * 100, 2);
            $data['bounced']   = round($bounce * 100, 2);
            $data['nonopened'] = round($nonopen * 100, 2);
        }

        return $data;

    }

}