<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 12.08.2016
 * Time: 22:00
 */

namespace WakaTime\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class SummaryCommand extends BaseApiCommand
{
    protected function configure(){
        $this->addOption("current", "c");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->ioInit($input, $output);
        $from = $this->getFrom($input)->format("Y-m-d");
        $to = $this->getTo($input)->format("Y-m-d");
        
        $this->getIo()->title("Running WakaTime summary command");

        $this->getIo()->section("Command parameters:");
        $this->getIo()->text("START: {$from}");
        $this->getIo()->text("END: \t{$to}");
        
        $this->getApp()->setUrlParameters(['start' => $from, 'end' => $to]);

        parent::execute($input, $output);
    }

    protected function commandType()
    {
        return CommandType::SUMMARY;
    }

    /**
     * @param InputInterface $input
     * @return \DateTime
     */
    abstract protected function getFrom(InputInterface $input);

    /**
     * @param InputInterface $input
     * @return \DateTime
     */
    abstract protected function getTo(InputInterface $input);
}