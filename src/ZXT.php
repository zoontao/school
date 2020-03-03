<?php

/*
 * This file is part of the microlink.
 *
 * (c) UnionSchool <bell@microlinkiot.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ZoonTao\UnionSchool;

use ZoonTao\UnionSchool\Common\Tools\Str;

//if (!defined('UNION_SCHOOL_ROOT')) {
//    define('UNION_SCHOOL_ROOT', dirname(__FILE__) . '/');
//    require(UNION_SCHOOL_ROOT . 'Autoloader.php');
//}
/**
 * Class ZXT.
 *
 * @method static \ZoonTao\UnionSchool\App\Application            app(string $sid)
// * @method static \ZoonTao\UnionSchool\System\Application         system(string $sid)
// * @method static \ZoonTao\UnionSchool\Admin\Application          admin(string $sid)
// * @method static \ZoonTao\UnionSchool\School\Application         school(string $sid)
// * @method static \ZoonTao\UnionSchool\Teacher\Application        teacher(string $sid)
// * @method static \ZoonTao\UnionSchool\Student\Application        student(string $sid)
// * @method static \ZoonTao\UnionSchool\Parents\Application        parents(string $sid)
// *
// * @method static \ZoonTao\UnionSchool\Weixin\Application         weixin(string $sid)
// * @method static \ZoonTao\UnionSchool\Shop\Application           shop(string $sid)
// * @method static \ZoonTao\UnionSchool\Notify\Application         notify(string $sid)
// *
// * @method static \ZoonTao\UnionSchool\Apply\Application          apply(string $sid)
// * @method static \ZoonTao\UnionSchool\Finance\Application        finance(string $sid)
// * @method static \ZoonTao\UnionSchool\Bill\Application           bill(string $sid)
// *
// * @method static \ZoonTao\UnionSchool\Device\Application         device(string $sid)
// * @method static \ZoonTao\UnionSchool\Tel\Application            tel(string $sid)
// *
// * @method static \ZoonTao\UnionSchool\Aliyun\Application         aliyun(string $sid)
// * @method static \ZoonTao\UnionSchool\Email\Application          email(string $sid)
// * @method static \ZoonTao\UnionSchool\Sms\Application            sms(string $sid)
// *
// * @method static \ZoonTao\UnionSchool\Auto\Application           auto(string $sid)
// *
// * @method static \ZoonTao\UnionSchool\Iot\Application            iot(string $sid)
// * @method static \ZoonTao\UnionSchool\Lesson\Application         lesson(string $sid)
// * @method static \ZoonTao\UnionSchool\Homework\Application       homework(string $sid)
// * @method static \ZoonTao\UnionSchool\Score\Application          score(string $sid)
// * @method static \ZoonTao\UnionSchool\Health\Application         health(string $sid)
// *
// * @method static \ZoonTao\UnionSchool\Customization\Application customization(string $sid) //客制化
 *
 *
 */
class ZXT
{

    public static function make($name, string $sid)
    {
        $namespace = Str::studly($name);
        $application = "\\ZoonTao\\UnionSchool\\{$namespace}\\Application";
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
