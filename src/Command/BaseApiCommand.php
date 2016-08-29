<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 11.08.2016
 * Time: 20:25
 */

namespace WakaTime\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use WakaTime\App;
use WakaTime\Exceptions\WakaTimeException;
use WakaTime\Response\Response;

abstract class BaseApiCommand extends Command
{
    private $app;

    /** @var SymfonyStyle */
    private $io;

    private $ioInitialized;

    public function __construct(App $app)
    {
        parent::__construct("WakaTime");
        $this->app = $app;
        $this->app->setUrlByType($this->commandType());
        $this->ioInitialized = false;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(!$this->ioInitialized()){
            $this->ioInit($input, $output);
        }
        try{
            $this->getIo()->writeln("\n<info>Targeting endpoint: </info>\n" . $this->getApp()->getResultUrl() . "\n");
            /** @var Response $response */
            $response = $this->createResponse();
            $response->beforeProcess($this->getIo());
            $result = json_decode($this->getApp()->run());
            $response->verifyResponse($result, $this->getIo());
            $response->process($result, $this->getIo());
            $response->afterProcess($this->getIo());
            $response->successFinish($this->getIo());
        }
        catch (WakaTimeException $e){
            $this->getIo()->error($e->getMessage());
            $this->getIo()->newLine();
            $this->getIo()->warning("Proccess finish with errors");
        }
    }

    private function createResponse(){
        return $this->app->createResponseFromType($this->commandType());
    }

    protected function getApp(){
        return $this->app;
    }

    abstract protected function commandType();

    protected function ioInit(InputInterface $input, OutputInterface $output){
        $io = new SymfonyStyle($input, $output);
        $this->io = $io;
        $this->ioInitialized = true;
    }

    protected function ioInitialized(){
        return $this->io;
    }

    protected function getIo(){
        return $this->io;
    }
}