<?php

/*
 * This file is part of the microlink.
 *
 * (c) School <bell@microlinkiot.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ZoonTao\School;

use ZoonTao\School\Common\Tools\Str;

//if (!defined('UNION_SCHOOL_ROOT')) {
//    define('UNION_SCHOOL_ROOT', dirname(__FILE__) . '/');
//    require(UNION_SCHOOL_ROOT . 'Autoloader.php');
//}
/**
 * Class ZXT.
 *
 * @method static \ZoonTao\School\App\Application            app(string $sid)
// * @method static \ZoonTao\School\System\Application         system(string $sid)
// * @method static \ZoonTao\School\Admin\Application          admin(string $sid)
// * @method static \ZoonTao\School\School\Application         school(string $sid)
// * @method static \ZoonTao\School\Teacher\Application        teacher(string $sid)
// * @method static \ZoonTao\School\Student\Application        student(string $sid)
// * @method static \ZoonTao\School\Parents\Application        parents(string $sid)
// *
// * @method static \ZoonTao\School\Weixin\Application         weixin(string $sid)
// * @method static \ZoonTao\School\Shop\Application           shop(string $sid)
// * @method static \ZoonTao\School\Notify\Application         notify(string $sid)
// *
// * @method static \ZoonTao\School\Apply\Application          apply(string $sid)
// * @method static \ZoonTao\School\Finance\Application        finance(string $sid)
// * @method static \ZoonTao\School\Bill\Application           bill(string $sid)
// *
// * @method static \ZoonTao\School\Device\Application         device(string $sid)
// * @method static \ZoonTao\School\Tel\Application            tel(string $sid)
// *
// * @method static \ZoonTao\School\Aliyun\Application         aliyun(string $sid)
// * @method static \ZoonTao\School\Email\Application          email(string $sid)
// * @method static \ZoonTao\School\Sms\Application            sms(string $sid)
// *
// * @method static \ZoonTao\School\Auto\Application           auto(string $sid)
// *
// * @method static \ZoonTao\School\Iot\Application            iot(string $sid)
// * @method static \ZoonTao\School\Lesson\Application         lesson(string $sid)
// * @method static \ZoonTao\School\Homework\Application       homework(string $sid)
// * @method static \ZoonTao\School\Score\Application          score(string $sid)
// * @method static \ZoonTao\School\Health\Application         health(string $sid)
// *
// * @method static \ZoonTao\School\Customization\Application customization(string $sid) //客制化
 *
 *
 */
class ZXT
{

    public static function make($name, string $sid)
    {
        $namespace = Str::studly($name);
        $application = "\\ZoonTao\\School\\{$namespace}\\Application";
        return new $application($sid);
    }

    
    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}
