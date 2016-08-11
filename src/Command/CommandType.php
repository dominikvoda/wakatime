<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 11.08.2016
 * Time: 23:08
 */

namespace WakaTime\Command;


class CommandType
{
    const CURRENT_USER = "current-user";
    const STATS_DEFAULT = "stats-last-7-days";
    const STATS_LAST_7_DAYS = "stats-last-7-days";
    const STATS_LAST_30_DAYS = "stats-last-30-days";
    const STATS_LAST_6_MONTH = "stats-last-6-months";
    const STATS_LAST_YEAR = "stats-last-year";
}