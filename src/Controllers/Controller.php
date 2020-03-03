<?php

/*
 * This file is part of the zoontao/school.
 *
 * (c) bell <zzz@zoontao.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ZoonTao\UnionSchool\Controllers;

use Barryvdh\Debugbar\LaravelDebugbar;

class Controller
{
    public function __construct()
    {
        if (class_exists(LaravelDebugbar::class)) {
            resolve(LaravelDebugbar::class)->disable();
        }
    }
}
