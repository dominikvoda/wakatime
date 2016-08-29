<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 13.08.2016
 * Time: 1:13
 */

namespace WakaTime\Model;


use WakaTime\Database;
use WakaTime\Interfaces\IDatabase;

class ResultModel
{
    /** @var Database $database */
    private $database;

    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    public function getDataRangeProjectsData($start, $end){
        $projects = [];
        foreach ($this->getDatabase()->getDateRangeProjectDays($start, $end) as $projectDay){
            $projectId = $projectDay['project_id'];
            if(array_key_exists($projectDay['project_id'], $projects)){
                $projects[$projectId]['time'] += $projectDay['hours'];
            }
            else{
                $projects[$projectId] = ['time' => $projectDay['hours']];
                $projects[$projectId]['title'] = $this->getDatabase()->getProject($projectId)['title'];
            }
        }
        return $projects;
    }

    protected function getDatabase(){
        return $this->database;
    }

    public static function formatTime($time){
        $hours = floor($time / 3600);
        $time %= 3600;
        $minutes = floor($time / 60);
        $seconds = $time % 60;
        return str_pad($hours, 3, " ", STR_PAD_LEFT) . ":" . str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0", STR_PAD_LEFT);
    }
}