<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 11.08.2016
 * Time: 21:11
 */

namespace WakaTime;


class Curl
{
    private $config;

    private $headers;

    private $url;

    private $urlParameters;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->loadDefaultHeaders();
    }

    private function loadDefaultHeaders()
    {
        $this->headers[] = "Cache-Control: no-cache";
        $this->headers[] = "Authorization: Basic " . base64_encode($this->config->get("apikey"));
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setUrlParameters($parameters)
    {
        $this->urlParameters = $parameters;
    }

    public function execute()
    {
        $ch = $this->initCurl();
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private function initCurl()
    {
        $ch = curl_init();

        $url = $this->generateUrl($this->url, $this->urlParameters);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->config->get("request")['timeout']);

        return $ch;
    }

    private function generateUrl($url, $parameters)
    {
        $result = $url;
        if (is_array($parameters)) {
            if (count($parameters) > 0) {
                $result .= "?";
                foreach ($parameters as $key => $value) {
                    $result .= $key . "=" . $value;
                }
            }
        }
        return $result;
    }
}