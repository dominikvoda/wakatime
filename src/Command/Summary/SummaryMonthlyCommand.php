<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 14.08.2016
 * Time: 14:25
 */

namespace WakaTime\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

class SummaryMonthlyCommand extends SummaryCommand
{
    protected function configure()
    {
        $this->setName("summary:monthly");
        $this->setDescription("Default month is prev");
        $this->addOption("month-number", "m", InputOption::VALUE_OPTIONAL, "Number of month");
        $this->addOption("year", "y", InputOption::VALUE_OPTIONAL, "Year");
        parent::configure();
    }

    protected function getFrom(InputInterface $input)
    {
        $options = $input->getOptions();
        if($options['month-number']){
            $year = ($options['year']) ? $options['year'] : date("Y");
            return new \DateTime($year . "-" . $options['month-number'] . "-01");
        }
        elseif ($input->getOption("current")){
            return new \DateTime("first day of this month");
        }
        $from = new \DateTime("first day of this month");
        $from->modify("-1 month");
        return $from;
    }

    protected function getTo(InputInterface $input){
        $to = new \DateTime();
        $to->setTimestamp($this->getFrom($input)->getTimestamp());
        $to->modify("last day of this month");
        return $to;
    }
}