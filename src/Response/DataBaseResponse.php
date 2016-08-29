<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 12.08.2016
 * Time: 20:34
 */

namespace WakaTime\Response;


use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Style\SymfonyStyle;
use WakaTime\Config;
use WakaTime\Database;
use WakaTime\Interfaces\IDatabase;
use WakaTime\Model\ResultModel;

class DataBaseResponse extends Response
{
    /** @var  IDatabase */
    private $database;

    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->database = new Database($config);

    }

    public function process($result, SymfonyStyle $io)
    {
        $results = [];
        foreach ($result->data as $day) {
            foreach ($day->projects as $project) {
                $status = $this->getDatabase()->updateProjectDay($project, $day->range->date);
                if (array_key_exists($project->name, $results)) {
                    $results[$project->name]['time'] += $project->total_seconds;
                    $results[$project->name][($status == Database::ENTITY_CREATED) ? "created" : "updated"] += $project->total_seconds;
                } else {
                    $results[$project->name] = [
                        'time' => $project->total_seconds,
                        'created' => ($status == Database::ENTITY_CREATED) ? $project->total_seconds : 0,
                        'updated' => ($status == Database::ENTITY_UPDATED) ? $project->total_seconds : 0,
                    ];
                }
            }
        }
        $this->renderResultTable($io, $results);
    }

    private function renderResultTable(SymfonyStyle $io, $data)
    {
        $table = new Table($io);
        $table->setHeaders(["Project", "Time", "New tracked"]);

        foreach ($data as $title => $row) {
            $table->addRow([
                $title,
                ResultModel::formatTime($row['time']),
                ResultModel::formatTime($row['created']),
            ]);
        }

        $table->render();
    }

    public function getDatabase()
    {
        return $this->database;
    }
}