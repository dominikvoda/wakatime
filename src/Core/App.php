<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 11.08.2016
 * Time: 22:06
 */

namespace WakaTime;


use WakaTime\Response\Response;

class App
{
    private $config;

    /** @var Curl $curl */
    private $curl;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->curl = new Curl($config);
    }

    public function getConfig(){
        return $this->config;
    }

    public function getCurl(){
        return $this->curl;
    }

    public function setUrlByType($type){
        $url = $this->config->get("url") . $this->generateUrlFromType($type);
        $this->curl->setUrl($url);
    }

    public function setUrlParameters($parameters){
        $this->curl->setUrlParameters($parameters);
    }

    public function run(){
        $result = $this->curl->execute();
        return $result;
    }

    private function generateUrlFromType($type){
        return $this->config->get("api_types")[$type]['url'];
    }

    public function createResponseFromType($type){
        $className = Config::getArrayValue($this->config->get("api_types")[$type], "response_class", $this->config->get("response")['class']);

        /** @var Response $class */
        $class = new $className($this->config);

        $class->setResponseType($type);

        return $class;
    }

    public function getResultUrl(){
        return $this->getCurl()->getFinalUrl();
    }

    public function getResultModel(){
        $className = Config::getArrayValue($this->config->get("results"), "model_class");
        $databaseClassName = Config::getArrayValue($this->config->get("results"), "database_class");
        $databaseClass = new $databaseClassName($this->getConfig());
        $class = new $className($databaseClass);
        return $class;
    }
}