<?php namespace designpond\newsletter\Newsletter\Worker;

class StatsWorker{

    public function getTotalCount($data){

        return $stats = $data->Count;
    }

    public function filterResponseStatistics($data){

        $stats = (isset($data->Data[0]) ? $data->Data[0] : false);

        return $stats;
    }

    public function filterResponseStatisticsMany($data){

        $stats = ($data->Data ? $data->Data : false);

        return $stats;
    }

    public function aggregateStatsClicksLinks($data){

        $clicks = array();

        if(!empty($data))
        {
            foreach($data as $click)
            {
                $url = trim($click->Url);
                $clicks[$url][] = $click->ContactID;
            }
        }

        return $clicks;
    }

    public function statsClicksLinks($datas){

        $clicks = array();

        if(!empty($datas))
        {
            foreach($datas as $data)
            {
                foreach($data as $click)
                {
                    foreach($click as $urlclick)
                    {
                        $url = trim($urlclick->Url);
                        $clicks[$url][] = $urlclick->ContactID;
                    }
                }
            }
        }

        return $clicks;
    }

}