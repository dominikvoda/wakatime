<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 12.08.2016
 * Time: 0:07
 */

namespace WakaTime\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class StatsCommand extends BaseApiCommand
{
    protected function configure()
    {
        $this->addArgument("project", InputArgument::OPTIONAL, "Project name", NULL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $project = $input->getArgument("project");
        if($project){
            $this->getApp()->setUrlParameters(['project' => $project]);
        }
        parent::execute($input, $output);
    }

    protected function commandType()
    {
        return CommandType::STATS_DEFAULT;
    }

}