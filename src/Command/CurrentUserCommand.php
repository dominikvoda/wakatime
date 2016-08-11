<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 11.08.2016
 * Time: 21:09
 */

namespace WakaTime\Command;


class CurrentUserCommand extends BaseApiCommand
{
    protected function configure()
    {
        $this->setName("current-user:default");
    }

    protected function commandType()
    {
        return CommandType::CURRENT_USER;
    }
}