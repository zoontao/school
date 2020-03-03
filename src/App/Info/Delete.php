<?php

namespace UnionSchool\App\Info;

use UnionSchool\Common\Exceptions\Exception;
use UnionSchool\App\Common;
use think\Db;

class Delete extends Common
{
    /**
     * Delete constructor.
     * @param $sid
     */
    public function __construct($sid){
        parent::__construct($sid);
    }

    /**
     * @param string $appid
     * @return $this
     */
    public function where(string $appid){
        $this->APP_ID= $appid;
        return $this;
    }

    /**
     * @param int $id
     * @return $this
     * @throws Exception
     */
    public function where_id(int $id){
        if(!$id){
            throw new Exception('记录编号不能为空');
        }
        try{
            $check = db('app')->where('id',$id)->find();
            if(!$check){
                throw new Exception('设备不存在');
            }
            $this->APP_ID = $check['APP_ID'];
            return $this;
        }catch (\Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return int
     * @throws Exception
     */
    public function delete(){
        if(!$this->APP_ID){
            throw new Exception('APP_ID不能为空');
        }
        try{
            $check = db('app')->where(['sid'=>$this->sid,"APP_ID"=>$this->APP_ID,'delete_time'=>0])->find();
            if(!$check){
                throw new Exception('应用不存在');
            }
            return db('app')->where(['sid'=>$this->sid,"APP_ID"=>$this->APP_ID,'delete_time'=>0])->update(['delete_time'=>time()]);
        }catch (\Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}
