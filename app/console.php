<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 11.08.2016
 * Time: 20:22
 */

require __DIR__ . "/../vendor/autoload.php";

$config = new \WakaTime\Config();
$wakaTimeApp = new \WakaTime\App($config);

$application = new \Symfony\Component\Console\Application("WakaTime console application");

$application->add(new \WakaTime\Command\CurrentUserCommand($wakaTimeApp));

$application->add(new \WakaTime\Command\StatsLast7DaysCommand($wakaTimeApp));
$application->add(new \WakaTime\Command\StatsLast30DaysCommand($wakaTimeApp));
$application->add(new \WakaTime\Command\StatsLast6MonthsCommand($wakaTimeApp));
$application->add(new \WakaTime\Command\StatsLastYear($wakaTimeApp));

$application->add(new \WakaTime\Command\SummaryDailyCommand($wakaTimeApp));
$application->add(new \WakaTime\Command\SummaryWeeklyCommand($wakaTimeApp));
$application->add(new \WakaTime\Command\SummaryMonthlyCommand($wakaTimeApp));
$application->add(new \WakaTime\Command\SummaryRangeCommand($wakaTimeApp));


$application->add(new \WakaTime\Command\Result\ResultDailyCommand($wakaTimeApp));
$application->add(new \WakaTime\Command\Result\ResultWeeklyCommand($wakaTimeApp));
$application->add(new \WakaTime\Command\Result\ResultMonthlyCommand($wakaTimeApp));
$application->add(new \WakaTime\Command\Result\ResultRangeCommand($wakaTimeApp));

$application->run();