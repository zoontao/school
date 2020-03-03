<?php
namespace ZoonTao\UnionSchool;
/*
 * This file is part of the ZXT.
 *
 * (c) bell <bell@microlinkiot.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */


use Illuminate\Support\Facades\DB;

class Common
{
    protected $sid;
    protected $db_zxt='zxt';
    protected $db_admin='zxt_admin';
    protected $db_card='zxt_card';
    protected $db_device='zxt_device';
    protected $db_tel='zxt_tel';
    protected $db_gps='zxt_gps';
    protected $db_data='zxt_data';
    protected $db_notice='zxt_notice';
    protected $db_logs='zxt_logs';
    public function __construct(){

    }

    /**
     * 判断数据表是否存在
     * @param $tableName
     * @param string $database
     * @return bool
     */
    protected function checkTable($tableName,$database='zhongxiaotong'){
        $tableName = config('database.prefix').$tableName;
        $isTable = Db::connection($database)->query("SHOW TABLES LIKE "."'".$tableName."'");
        if($isTable){
            return true;
        }else{
            return false;
        }
    }

    /**
     *  创建用户的openid
     * @param $CID
     * @return string
     */
    protected function __create_openid($CID){
        return hash_hmac('md5',$CID,"ZHONGXIAOTONG");
    }
    protected function __create_uniqid_md5(){
        return md5(uniqid());
    }
    protected function __create_password($password){
        return hash_hmac('md5',$password,"ZHONGXIAOTONG");
    }
    protected function __create_guid($namespace = '') {
        static $guid = '';
        $uid = uniqid("", true);
        $data = $namespace;
        $data .= $_SERVER['REQUEST_TIME_FLOAT'];
        $data .= $_SERVER['HTTP_USER_AGENT'];
        $data .= $_SERVER['SERVER_ADDR'];
        $data .= $_SERVER['SERVER_PORT'];
        $data .= $_SERVER['REMOTE_ADDR'];
        $data .= $_SERVER['REMOTE_PORT'];
        $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
        $guid = substr($hash, 0, 8) .'-' .substr($hash, 8, 4) . '-' .substr($hash, 12, 4) . '-' .substr($hash, 16, 4) . '-' .substr($hash, 20, 12);
        return $guid;
    }
    protected function __create_token(){
        return uniqid('zxt').$this->__getRandChar(4);
    }
    protected function __getRandChar($len)
    {
        $chars = array("0","1", "2","3","4","5", "6","7", "8", "9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
        $charsLen = count($chars) - 1;
        shuffle($chars);
        $output = "";
        for ($i=0; $i<$len; $i++)
        {
            $output .= $chars[mt_rand(0, $charsLen)];
        }
        return $output;
    }
    protected function __getRandNum($len)
    {
        $chars = array("0","1", "2","3","5", "6","7", "8", "9");
        $charsLen = count($chars) - 1;
        shuffle($chars);
        $output = "";
        for ($i=0; $i<$len; $i++)
        {
            $output .= $chars[mt_rand(0, $charsLen)];
        }
        return $output;
    }
    protected function __create_bill_no(){
        list($usec, $sec) = explode(" ", microtime());
        if($usec>=0.1){$nowSecond = $usec*100;}
        else{
            if($usec>=0.01){ $nowSecond=$usec*1000;}
            else{$nowSecond=$usec*10000;}
        }
        $nowSecond = intval($nowSecond);
        $billNo = date("ymdHis").$nowSecond.$this->__getRandNum(2);
        return $billNo;
    }
    protected function __create_out_trade_no(){
        list($usec, $sec) = explode(" ", microtime());
        if($usec>=0.1){$nowSecond = $usec*100;}
        else{
            if($usec>=0.01){ $nowSecond=$usec*1000;}
            else{$nowSecond=$usec*10000;}
        }
        $nowSecond = intval($nowSecond);
        $trade_no = date("ymdHis").$nowSecond.$this->__getRandNum(2);
        return $trade_no;
    }
    protected function make_SN($Char){
        list($usec, $sec) = explode(" ", microtime());
        if($usec>=0.1){$nowSecond = $usec*100;}
        else{
            if($usec>=0.01){ $nowSecond=$usec*1000;}
            else{$nowSecond=$usec*10000;}
        }
        $nowSecond = intval($nowSecond);
        return time().$Char.$nowSecond;
    }
    protected function make_No(){
        list($usec, $sec) = explode(" ", microtime());
        if($usec>=0.1){$nowSecond = $usec*100;}
        else{
            if($usec>=0.01){ $nowSecond=$usec*1000;}
            else{$nowSecond=$usec*10000;}
        }
        $nowSecond = intval($nowSecond);
        $numNo = date("ymdHis").$nowSecond.$this->__getRandNum(2);
        return $numNo;
    }
    /**
     * 计算两点地理坐标之间的距离
     * @param  float $longitude1    起点经度
     * @param  float $latitude1     起点纬度
     * @param  float $longitude2    终点经度
     * @param  float $latitude2     终点纬度
     * @param  Int   $decimal       精度 保留小数位数
     * @return float                单位 米
     */
    public function get_map_distance($longitude1, $latitude1, $longitude2, $latitude2, $decimal=2) {
        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $PI = 3.1415926;

        $radLat1 = $latitude1 * $PI / 180.0;
        $radLat2 = $latitude2 * $PI / 180.0;

        $radLng1 = $longitude1 * $PI / 180.0;
        $radLng2 = $longitude2 * $PI /180.0;

        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;

        $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
        $distance = $distance * $EARTH_RADIUS * 1000;

        return round($distance, $decimal);
    }


}
