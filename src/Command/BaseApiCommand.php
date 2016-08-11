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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WakaTime\App;
use WakaTime\Response\Response;

abstract class BaseApiCommand extends Command
{
    protected $app;

    public function __construct(App $app)
    {
        parent::__construct("WakaTime");
        $this->app = $app;
        $this->app->setUrlByType($this->commandType());
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Response $response */
        $response = $this->createResponse();
        $response->beforeProcess($output);
        $result = $this->app->run();
        $response->process($result, $output);
        $response->afterProcess($output);
    }

    private function createResponse(){
        return $this->app->createResponseFromType($this->commandType());
    }

    abstract protected function commandType();
}