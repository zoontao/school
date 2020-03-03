<?php

/*
 * This file is part of the ZXT.
 *
 * (c) bell <bell@microlinkiot.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace ZoonTao\UnionSchool\App;



use ZoonTao\UnionSchool\Common\Tools\Str;

class Application
{
    protected $sid;
    /**
     * Application constructor.
     * @param $sid
     */
    public function __construct($sid)
    {
        $this->sid = $sid;
    }

    public function test(){

        return "app tests";
    }
    /**
     * @return Info\Service
     */
    public function Info()
    {
        return new Info\Service($this->sid);
    }

    /**
     * @return Oauth\Service
     */
    public function Oauth()
    {
        return new Oauth\Service($this->sid);
    }



    /**
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        $namespace = Str::studly($method);
        $Service = "\\ZoonTao\UnionSchool\\APP\\{$namespace}\\Service";
        return new $Service($this->sid);
    }
}
