<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 11.08.2016
 * Time: 23:30
 */

namespace WakaTime\Response;


use Symfony\Component\Console\Output\OutputInterface;
use WakaTime\Config;

abstract class Response implements IResponse
{
    protected $config;

    protected $name;

    protected $type;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function beforeProcess(OutputInterface $output)
    {
        $output->writeln("Process START");
    }

    public function afterProcess(OutputInterface $output)
    {
        $output->writeln("Process END");
    }

    abstract public function process($result, OutputInterface $output);

    public function setResponseName($name)
    {
        $this->name = $name;
    }

    public function setResponseType($type){
        $this->type = $type;
    }

    public function getResponseType(){
        return $this->type;
    }

    public function getResponseName(){
        return $this->name;
    }
}