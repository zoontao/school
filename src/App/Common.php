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

use ZoonTao\UnionSchool;

class Common extends ZoonTao\UnionSchool\Common
{
    protected $APP_ID;
    protected $APP_KEY;
    protected $access_token;
    public function __construct($sid){
        parent::__construct();
        $this->sid = $sid;
    }

    protected function make_token($string){
        return hash_hmac('md5',$string,time());
    }

    //产生新的应用ID
    protected function make_APP_ID(){
        list($usec, $sec) = explode(" ", microtime());
        if($usec>=0.1){$Nowsecond = $usec*100;}
        else{
            if($usec>=0.01){ $Nowsecond=$usec*1000;}
            else{$Nowsecond=$usec*10000;}
        }
        $Nowsecond = intval($Nowsecond);
        return 'ZXT'.time().'CN'.$Nowsecond;
    }
    //产生新的应用密钥
    protected function make_APP_Key($APP_ID){
        return hash_hmac('md5',$APP_ID,time());
    }



}
