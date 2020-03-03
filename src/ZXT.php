<?php

/*
 * This file is part of the microlink.
 *
 * (c) UnionSchool <bell@microlinkiot.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace UnionSchool;

use UnionSchool\Common\Tools\Str;

//if (!defined('UNION_SCHOOL_ROOT')) {
//    define('UNION_SCHOOL_ROOT', dirname(__FILE__) . '/');
//    require(UNION_SCHOOL_ROOT . 'Autoloader.php');
//}
/**
 * Class ZXT.
 *
 * @method static \UnionSchool\App\Application            app(string $sid)
 * @method static \UnionSchool\System\Application         system(string $sid)
 * @method static \UnionSchool\Admin\Application          admin(string $sid)
 * @method static \UnionSchool\School\Application         school(string $sid)
 * @method static \UnionSchool\Teacher\Application        teacher(string $sid)
 * @method static \UnionSchool\Student\Application        student(string $sid)
 * @method static \UnionSchool\Parents\Application        parents(string $sid)
 *
 * @method static \UnionSchool\Weixin\Application         weixin(string $sid)
 * @method static \UnionSchool\Shop\Application           shop(string $sid)
 * @method static \UnionSchool\Notify\Application         notify(string $sid)
 *
 * @method static \UnionSchool\Apply\Application          apply(string $sid)
 * @method static \UnionSchool\Finance\Application        finance(string $sid)
 * @method static \UnionSchool\Bill\Application           bill(string $sid)
 *
 * @method static \UnionSchool\Device\Application         device(string $sid)
 * @method static \UnionSchool\Tel\Application            tel(string $sid)
 *
 * @method static \UnionSchool\Aliyun\Application         aliyun(string $sid)
 * @method static \UnionSchool\Email\Application          email(string $sid)
 * @method static \UnionSchool\Sms\Application            sms(string $sid)
 *
 * @method static \UnionSchool\Auto\Application           auto(string $sid)
 *
 * @method static \UnionSchool\Iot\Application            iot(string $sid)
 * @method static \UnionSchool\Lesson\Application         lesson(string $sid)
 * @method static \UnionSchool\Homework\Application       homework(string $sid)
 * @method static \UnionSchool\Score\Application          score(string $sid)
 * @method static \UnionSchool\Health\Application         health(string $sid)
 *
 * @method static \UnionSchool\Customization\Application customization(string $sid) //客制化
 *
 *
 */
class ZXT
{

    public static function make($name, string $sid)
    {
        $namespace = Str::studly($name);
        $application = "\\UnionSchool\\{$namespace}\\Application";
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
