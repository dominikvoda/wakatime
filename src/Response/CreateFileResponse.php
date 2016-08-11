<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 11.08.2016
 * Time: 23:39
 */

namespace WakaTime\Response;

use Symfony\Component\Console\Output\OutputInterface;
use WakaTime\Config;

class CreateFileResponse extends Response
{
    public function process($result, OutputInterface $output)
    {
        $fileName = $this->getFileName();
        $filePath = $this->getFilePath();
        $file = fopen($filePath, "w");
        fwrite($file, $result);
        fclose($file);
        $output->writeln($fileName . " was created.");
    }

    private function getFilePath(){
        $typeDir = Config::getArrayValue($this->config->get("api_types")[$this->getResponseType()], "dir", "/");
        $folder = __DIR__ . "/../../" . $this->config->get("response")['dir'] . $typeDir;
        return $folder . $this->getFileName();
    }

    private function getFileName(){
        return $this->getResponseType() . date("-Y-m-d__h-i-s") . ".json";
    }
}