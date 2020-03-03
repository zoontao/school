<?php
namespace ZoonTao\School\App\Info;
use ZoonTao\School\Common\Exceptions\Exception;
use ZoonTao\School\App\Common;

Class Add extends Common
{

    /**
     * Edit constructor.
     * @param $sid
     */
    public function __construct($sid){
        parent::__construct($sid);
    }

    /**
     * @param $APP_Name
     * @return mixed
     * @throws Exception
     */
    public function insert($APP_Name){
        try{
            if(!$APP_Name){
                throw new Exception('Not submitted APP_Name');
            }
            $check = db("app")->where(['sid'=>$this->sid,"APP_Name"=>$APP_Name,'delete_time'=>0])->find();
            if($check){
                throw new Exception('APP_Name already exists');
            }
            else{
                $APP_ID = $this->make_APP_ID();
                $APP_KEY = $this->make_APP_Key($APP_ID);
                $id = db("app")->strict(false)->insert([
                    "sid"=>$this->sid,
                    "APP_ID"=>$APP_ID,
                    "APP_KEY"=>$APP_KEY,
                    "APP_Name"=>$APP_Name,
                    "addtime"=>date("Y-d-m H:i:s",time())
                ]);
                return db("app")->where('id',$id)->find();
            }
        }catch (\Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}
