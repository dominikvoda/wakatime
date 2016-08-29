<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 11.08.2016
 * Time: 21:57
 */

namespace WakaTime;


use WakaTime\Exceptions\ConfigException;

class Config
{
    const CONFIG_FILE = "config.yml";
    const SETTINGS_FILE = "settings.yml";

    private $config;

    public function __construct()
    {
        $configFile = __DIR__ . "/../../config/" . self::CONFIG_FILE;
        $settingsFile = __DIR__ . "/../../config/" . self::SETTINGS_FILE;

        $config = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($configFile));
        $settings = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($settingsFile));

        $this->config = array_merge($config, $settings);
    }

    /**
     * @param $key
     * @return mixed
     * @throws ConfigException
     */
    public function get($key){
        if(array_key_exists($key, $this->config)){
            return $this->config[$key];
        }
        throw new ConfigException("Key \"{$key}\" not found in config");
    }

    /**
     * @param string $key
     * @param mixed $value
     * @throws ConfigException
     */
    public function set($key, $value){
        if(is_string($key)){
            $this->config[$key] = $value;
        }
        else{
            throw new ConfigException("Invalid key type");
        }
    }

    public static function getArrayValue($array, $key, $ifNotExist = false){
        if(array_key_exists($key, $array)){
            return $array[$key];
        }
        return $ifNotExist;
    }
}
