<?php
namespace UnionSchool\App\Info;
use UnionSchool\Common\Exceptions\Exception;
use UnionSchool\App\Common;

Class Edit extends Common
{
    /**
     * @var
     */

    /**
     * Edit constructor.
     * @param $sid
     */
    public function __construct($sid){
        parent::__construct($sid);
        $this->sid = $sid;
    }

    /**
     * @param string $APP_ID
     * @return $this
     */
    public function where(string $APP_ID){
        $this->APP_ID=$APP_ID;
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
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function update(Array $data){
        if(!$data){
            throw new Exception('没有提交应用信息');
        }
        else if(!$this->APP_ID){
            throw new Exception('没有提交应用编号');
        }
        try{
            $check = db('app')->where(['sid'=>$this->sid,'APP_ID'=>$this->APP_ID,'delete_time'=>0])->find();
            if(!$check){
                throw new Exception('应用不存在');
            }
            if(isset($data['id'])){
                unset($data['id']);
            }
            return db('app')->where('id',$check['id'])->strict(false)->update($data);
        }catch (\Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function update_key(){
        if(!$this->APP_ID){
            throw new Exception('没有提交应用编号');
        }
        try{
            $check = db('app')->where(['sid'=>$this->sid,'APP_ID'=>$this->APP_ID,'delete_time'=>0])->find();
            if(!$check){
                throw new Exception('应用不存在');
            }
            $app_key = $this->make_APP_Key($this->APP_ID);
            return db('app')->where('id',$check['id'])->strict(false)->update([
                "APP_KEY" => $app_key
            ]);
        }catch (\Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function visit(){
        if(!$this->APP_ID){
            throw new Exception('没有提交应用编号');
        }
        try{
            $check = db('app')->where(['sid'=>$this->sid,'APP_ID'=>$this->APP_ID,'delete_time'=>0])->find();
            if(!$check){
                throw new Exception('应用不存在');
            }
            return db('app')->where('id',$check['id'])->strict(false)->setInc('visit');
        }catch (\Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}
