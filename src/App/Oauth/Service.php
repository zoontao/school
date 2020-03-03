<?php

/*
 * This file is part of the ZXT.
 *
 * (c) bell <bell@microlinkiot.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ZoonTao\School\App\Oauth;

use ZoonTao\School\Common\Exceptions\Exception;
use ZoonTao\School\App\Common;
use ZoonTao\School\Common\Tools\Str;

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
     * @param $appkey
     * @return mixed
     * @throws Exception
     */
    public function access_token($appid,$appkey){
        try{
            if(!$appid){
                throw new Exception("Not submitted appid",1000);
            }
            if(!$appkey){
                throw new Exception("Not submitted appkey",1000);
            }
            $school = db("school")->where("sid",$this->sid)->cache(60)->find();
            if(!$school){
                throw new Exception("school not exist",1000);
            }
            if($school['allow']!=1){
                throw new Exception("school not allow",1000);
            }
            $item = db("app")->where(["sid"=>$this->sid,"APP_ID"=>$appid,"delete_time"=>0,"allow"=>1])->find();
            if(!$item){
                throw new Exception("appid not exist",1000);
            }
            if($appkey != $item["APP_KEY"]){
                throw new Exception("appkey incorrect",1000);
            }
            $access_token = $this->make_token($this->sid.$appid);
            $refresh_token = $this->make_token($access_token);
            $expires_in = time();
            $check = db("app_oauth")->where(['access_token'=>$access_token])->find();
            if($check){
                db("app_oauth")->where('id',$check["id"])->update(["expires_in"=>$expires_in]);
            }
            else{
                db("app_oauth")->strict(false)->insert([
                    "APP_ID"=>$appid,
                    "access_token"=>$access_token,
                    "refresh_token"=>$refresh_token,
                    "expires_in"=>$expires_in
                ]);
            }
            $token["access_token"] = $access_token;
            $token["refresh_token"] = $refresh_token;
            $token["expires_in"] = $expires_in;
            db("app_oauth")->where("expires_in","<",time()-2592000)->strict(false)->delete();
            return $token;
        }
        catch (\Exception $e){
            throw new Exception($e->getMessage(),1000);
        }
    }

    /**
     * @param $refresh_token
     * @return mixed
     * @throws Exception
     */
    public function refresh_token($refresh_token){
        try{
            if(!$refresh_token){
                throw new Exception("Not submitted refresh_token",1000);
            }
            $school = db("school")->where("sid",$this->sid)->cache(60)->find();
            if(!$school){
                throw new Exception("school not exist",1000);
            }
            if($school['allow']!=1){
                throw new Exception("school not allow",1000);
            }
            $item = db("app_oauth")->where("refresh_token",$refresh_token)->find();
            if(!$item){
                throw new Exception("refresh_token not exist",1000);
            }
            $expires_in = isset($item["expires_in"])?$item["expires_in"]:0;
            $passtime = time() - $expires_in;
            if($passtime > 2592000){
                throw new Exception("refresh_token invalid",1000);
            }
            $access_token = $this->make_token($this->sid.$item['APP_ID']);
            $refresh_token = $this->make_token($access_token);
            db("app_oauth")->where('id',$item['id'])->strict(false)->update(['access_token'=>$access_token,'refresh_token'=>$refresh_token,'expires_in'=>time()]);
            $token["access_token"] = $access_token;
            $token["refresh_token"] = $refresh_token;
            $token["expires_in"] = time();
            return $token;
        }
        catch (\Exception $e){
            throw new Exception($e->getMessage(),1000);
        }
    }

    /**
     * @param $access_token
     * @return mixed
     * @throws Exception
     */
    public function check_access_token($access_token){
        try{
            if(!$access_token){
                throw new Exception("Not submitted access_token",1000);
            }
            $school = db("school")->where("sid",$this->sid)->cache(60)->find();
            if(!$school){
                throw new Exception("school not exist",1000);
            }
            if($school['allow']!=1){
                throw new Exception("school not allow",1000);
            }
            $item = db('app_oauth')
                ->where('access_token',$access_token)
                ->cache(60)
                ->find();
            if(!$item){
                throw new Exception("access_token not exist",1001);
            }
            $expires_in = isset($item["expires_in"])?$item["expires_in"]:0;
            $passtime = time() - $expires_in;
            if($passtime >86400){
                throw new Exception("access_token already expired",1001);
            }
            db('app_oauth')
                ->where('access_token',$access_token)
                ->setField('expires_in',time());
            $token["access_token"] = $item["access_token"];
            $token["refresh_token"] = $item["refresh_token"];
            $token["expires_in"] = time();
            return $token;
        }
        catch (\Exception $e){
            throw new Exception($e->getMessage());
        }
    }

}
