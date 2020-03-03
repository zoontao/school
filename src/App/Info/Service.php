<?php

/*
 * This file is part of the ZXT.
 *
 * (c) bell <bell@microlinkiot.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace UnionSchool\App\Info;

use UnionSchool\Common\Exceptions\Exception;
use UnionSchool\App\Common;
use UnionSchool\Common\Tools\Str;
use think\Db;

class Service extends Common
{
    /**
     * Service constructor.
     * @param $sid
     */
    public function __construct($sid){
        parent::__construct($sid);
    }


    /**
     * @param $appid
     * @return bool|mixed
     */
    public function detail($appid){
        try{
            if(!$appid){
                throw new Exception("Not submitted appid",1000);
            }
            return db("app")->where(["sid"=>$this->sid,"APP_ID"=>$appid,"delete_time"=>0,"allow"=>1])->cache(60)->find();
        }
        catch (\Exception $e){
            return false;
        }
    }

    /**
     * @return Add
     */
    public function Add()
    {
        return new Add($this->sid);
    }

    /**
     * @return Edit
     */
    public function Edit()
    {
        return new Edit($this->sid);
    }

    /**
     * @return Delete
     */
    public function Delete()
    {
        return new Delete($this->sid);
    }

    /**
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        $namespace = Str::studly($method);
        $Service = "\\UnionSchool\\APP\\Info\\{$namespace}";
        return new $Service($this->sid);
    }
}
