<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 13.08.2016
 * Time: 1:10
 */

namespace WakaTime\Command\Result;


use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use WakaTime\App;
use WakaTime\Command\FromToCommand;
use WakaTime\Interfaces\IResultModel;
use WakaTime\Model\ResultModel;

abstract class ResultCommand extends FromToCommand
{
    const DIRECTION_ASC = "asc";
    const DIRECTION_DESC = "desc";
    const COLUMN_TITLE = "title";
    const COLUMN_TIME = "time";

    private $app;

    /** @var IResultModel $resultModel */
    private $resultModel;

    /** @var  SymfonyStyle */
    private $io;

    public function __construct(App $app)
    {
        parent::__construct("WakaTime");
        $this->app = $app;
        $this->resultModel = $app->getResultModel();
        $this->sortConfiguration();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        $from = $this->getFrom($input)->format("Y-m-d");
        $to = $this->getTo($input)->format("Y-m-d");

        $projects = $this->resultModel->getDataRangeProjectsData($from, $to);
        $filteredProjects = $this->filterResult($projects, $input);
        $table = $this->createTable($filteredProjects, $output);

        $this->getIo()->title("Running WakaTime result command");

        $this->getIo()->section("Command parameters:");
        $this->getIo()->text("START: {$from}");
        $this->getIo()->text("END: \t{$to}");

        $this->getIo()->section("Result table::");
        $table->render();

        $this->getIo()->success("Done without errors");
    }

    protected function createTable($projects, OutputInterface $output)
    {
        $totalTime = 0;

        $table = new Table($output);
        $table->setHeaders(['Project', 'Time']);

        foreach ($projects as $project) {
            $totalTime += $project['time'];
            $table->addRow([
                $project['title'],
                ResultModel::formatTime($project['time']),
            ]);
        }

        $table->addRow(new TableSeparator());
        $table->addRow(["TOTAL", ResultModel::formatTime($totalTime)]);
        return $table;
    }

    protected function filterResult($projects, InputInterface $input)
    {
        $title = $input->getOption("project");
        $column = $input->getOption("sort");
        $direction = strtolower($input->getOption("direction"));
        if ($title) {
            $filter = function ($project) use ($title) {
                return $project['title'] == $title;
            };
            $projects = array_filter($projects, $filter);
        }
        $sort = function ($projectA, $projectB) use ($column, $direction) {
            if($column == self::COLUMN_TITLE){
                if($direction === self::DIRECTION_ASC){
                    return strcasecmp($projectA[$column], $projectB[$column]);
                }
                return strcasecmp($projectB[$column], $projectA[$column]);
            }
            else{
                if($direction === self::DIRECTION_ASC){
                    return ($projectA[$column] > $projectB[$column]) ? -1 : 1;
                }
                return ($projectA[$column] > $projectB[$column]) ? 1 : -1;
            }
        };
        usort($projects, $sort);
        return $projects;
    }

    protected function sortConfiguration()
    {
        $this->addOption("sort", "s", InputOption::VALUE_OPTIONAL, "Sorted column", self::COLUMN_TITLE);
        $this->addOption("direction", "d", InputOption::VALUE_OPTIONAL, "Sort direction", self::DIRECTION_ASC);
        $this->addOption("project", "p", InputOption::VALUE_REQUIRED, "Filter project", NULL);
    }

    protected function getIo(){
        return $this->io;
    }
}