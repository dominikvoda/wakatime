<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 14.08.2016
 * Time: 0:52
 */

namespace WakaTime\Command\Result;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

class ResultRangeCommand extends ResultCommand
{
    protected function configure()
    {
        $this->setName("result:range");
        $this->addArgument("start", InputArgument::REQUIRED, "Start date");
        $this->addArgument("end", InputArgument::OPTIONAL, "End date");
    }

    protected function getFrom(InputInterface $input)
    {
        return new \DateTime($input->getArgument("start"));
    }

    protected function getTo(InputInterface $input)
    {
        if($input->getArgument("end")){
            return new \DateTime($input->getArgument("end"));
        }
        return new \DateTime();
    }
}