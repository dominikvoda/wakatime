<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 14.08.2016
 * Time: 14:14
 */

namespace WakaTime\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;

abstract class FromToCommand extends Command
{
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

    protected function configure(){
        $this->addOption("current", "c");
    }
}