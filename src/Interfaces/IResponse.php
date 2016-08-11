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

interface IResponse
{
    public function process($result, OutputInterface $output);

    public function beforeProcess(OutputInterface $output);

    public function afterProcess(OutputInterface $output);
}