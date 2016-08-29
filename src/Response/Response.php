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


use Symfony\Component\Console\Style\SymfonyStyle;
use WakaTime\Config;
use WakaTime\Exceptions\ResponseException;
use WakaTime\Interfaces\IResponse;

abstract class Response implements IResponse
{
    protected $config;

    protected $name;

    protected $type;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function beforeProcess(SymfonyStyle $io)
    {
        $io->writeln("\n<info>--- Process START ---</info>\n");
    }

    public function afterProcess(SymfonyStyle $io)
    {
        $io->writeln("<info>\n--- Process FINISH ---\n</info>");
    }

    public function verifyResponse($result, SymfonyStyle $io){
        if(isset($result->error)){
            throw new ResponseException($result->error);
        }
        $io->success("Connected");
    }

    public function successFinish(SymfonyStyle $io){
        $io->success("Finished");
    }

    abstract public function process($result, SymfonyStyle $io);

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