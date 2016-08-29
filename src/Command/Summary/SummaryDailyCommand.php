<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 14.08.2016
 * Time: 0:09
 */

namespace WakaTime\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

class SummaryDailyCommand extends SummaryCommand
{
    public function configure()
    {
        $this->setName("summary:daily");
        $this->setDescription("Default day is yesterday");
        $this->addArgument("date", InputArgument::OPTIONAL, "Set day date");
        parent::configure();
    }

    protected function getFrom(InputInterface $input)
    {
        if($input->getArgument("date")){
            return new \DateTime($input->getArgument("date"));
        }
        elseif($input->getOption("current")){
            return new \DateTime();
        }
        return new \DateTime("-1 day");
    }

    protected function getTo(InputInterface $input)
    {
        return $this->getFrom($input);
    }
}