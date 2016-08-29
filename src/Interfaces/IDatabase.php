<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 12.08.2016
 * Time: 20:36
 */

namespace WakaTime\Interfaces;


interface IDatabase
{
    public function getProject($id);

    public function getProjectDay($projectId, \DateTime $day);

    public function createProject($data);

    public function updateProject($id, $data);

    public function createProjectDay($data, $day);

    public function updateProjectDay($data, $date);
}