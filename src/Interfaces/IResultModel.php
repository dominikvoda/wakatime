<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 13.08.2016
 * Time: 1:18
 */

namespace WakaTime\Interfaces;


interface IResultModel
{
    public function getDataRangeProjectsData($start, $end);
}