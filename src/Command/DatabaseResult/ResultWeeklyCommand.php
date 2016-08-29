<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 14.08.2016
 * Time: 0:22
 */

namespace WakaTime\Command\Result;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

class ResultWeeklyCommand extends ResultCommand
{
    protected function configure()
    {
        $this->setName("result:weekly");
        $this->setDescription("Default week is prev");
        $this->addArgument("date", InputArgument::OPTIONAL, "day date in week");
        parent::configure();
    }

    protected function getFrom(InputInterface $input)
    {
        $arguments = $input->getArguments();
        if($arguments['date']){
            $from = new \DateTime($arguments['date']);
            $from->modify("last monday");
            return $from;
        }
        elseif ($input->getOption("current")){
            $from = new \DateTime("last monday");
            return $from;
        }
        $from = new \DateTime("last monday");
        $from->modify("-7 days");
        return $from;
    }

    protected function getTo(InputInterface $input)
    {
        $from = $this->getFrom($input);
        $to = new \DateTime();
        $to->setTimestamp($from->getTimestamp());
        $to->modify("+6 days");
        return $to;
    }
}