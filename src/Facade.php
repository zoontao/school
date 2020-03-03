<?php

/*
 * This file is part of the zoontao/school.
 *
 * (c) bell <zzz@zoontao.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ZoonTaotao\School;

use Illuminate\Support\Facades\Facade as LaravelFacade;

/**
 * Class Facade.
 *
 * @author overtrue <i@overtrue.me>
 */
class Facade extends LaravelFacade
{
    /**
     * 默认为 Server.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'school.official_account';
    }

    /**
     * @return \ZoonTaotao\School\App\Application
     */
    public static function app($sid = '')
    {
        return $sid ? app('school.official_account.'.$sid) : app('school.official_account');
    }

    /**
     * @return \Easyschool\Work\Application
     */
    public static function work($name = '')
    {
        return $name ? app('school.work.'.$name) : app('school.work');
    }

    /**
     * @return \Easyschool\Payment\Application
     */
    public static function payment($name = '')
    {
        return $name ? app('school.payment.'.$name) : app('school.payment');
    }

    /**
     * @return \Easyschool\MiniProgram\Application
     */
    public static function miniProgram($name = '')
    {
        return $name ? app('school.mini_program.'.$name) : app('school.mini_program');
    }

    /**
     * @return \Easyschool\OpenPlatform\Application
     */
    public static function openPlatform($name = '')
    {
        return $name ? app('school.open_platform.'.$name) : app('school.open_platform');
    }
}
