<?php

namespace UnionSchool\Common\Tools;

use UnionSchool\Common\Exceptions\RuntimeException;

/**
 * Class Str.
 */
class Str
{
    /**
     * The cache of snake-cased words.
     *
     * @var array
     */
    protected static $snakeCache = [];

    /**
     * The cache of camel-cased words.
     *
     * @var array
     */
    protected static $camelCache = [];

    /**
     * The cache of studly-cased words.
     *
     * @var array
     */
    protected static $studlyCache = [];

    /**
     * @param $value
     * @return mixed|string
     */
    public static function camel($value)
    {
        if (isset(static::$camelCache[$value])) {
            return static::$camelCache[$value];
        }

        return static::$camelCache[$value] = lcfirst(static::studly($value));
    }


    /**
     * @param int $length
     * @return string
     * @throws RuntimeException
     */
    public static function random($length = 16)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = static::randomBytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    /**
     * Generate a more truly "random" bytes.
     *
     * @param int $length
     *
     * @return string
     *
     * @throws RuntimeException
     *
     * @codeCoverageIgnore
     *
     * @throws \Exception
     */
    public static function randomBytes($length = 16)
    {
        if (function_exists('random_bytes')) {
            $bytes = random_bytes($length);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes($length, $strong);
            if (false === $bytes || false === $strong) {
                throw new RuntimeException('Unable to generate random string.');
            }
        } else {
            throw new RuntimeException('OpenSSL extension is required for PHP 5 users.');
        }

        return $bytes;
    }

    /**
     * Generate a "random" alpha-numeric string.
     *
     * Should not be considered sufficient for cryptography, etc.
     *
     * @param int $length
     *
     * @return string
     */
    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /**
     * Convert the given string to upper-case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function upper($value)
    {
        return mb_strtoupper($value);
    }

    /**
     * Convert the given string to title case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function title($value)
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Convert a string to snake case.
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public static function snake($value, $delimiter = '_')
    {
        $key = $value.$delimiter;

        if (isset(static::$snakeCache[$key])) {
            return static::$snakeCache[$key];
        }

        if (!ctype_lower($value)) {
            $value = strtolower(preg_replace('/(.)(?=[A-Z])/', '$1'.$delimiter, $value));
        }

        return static::$snakeCache[$key] = trim($value, '_');
    }

    /**
     * Convert a value to studly caps case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function studly($value)
    {
        $key = $value;

        if (isset(static::$studlyCache[$key])) {
            return static::$studlyCache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return static::$studlyCache[$key] = str_replace(' ', '', $value);
    }
    /**
     * @param $decString 123456789
     * @return string  0x01 0x23 0x45 0x67 0x89
     */
    public function toHecString($decString)
    {
        $decString = str_replace(" ", "",$decString);
        if ((strlen($decString) % 2) != 0){
            $decString = "0".$decString;
        }
        $returnBytes = [];
        for ( $i = 0; $i < strlen($decString)/ 2;  $i++){
            $returnBytes[$i] = "0x".substr($decString,$i*2,2);
        }
        return implode(" ",$returnBytes);
    }

    /**
     * @param $hecString 0x01 0x23 0x45 0x67 0x89
     * @return string 123456789
     */
    public function toDecString($hecString)
    {
        $decString = str_replace("0x", "",$hecString);
        $decString = str_replace(" ", "",$decString);
        if (substr($decString,0,1) == "0"){
            $decString = substr($decString,1,strlen($decString)-1);
        }
        return $decString;
    }
    public function getRandChar($len)
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
    public function getRandNum($len)
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
    public static function ascii_encode($str)
    {
        $str = mb_convert_encoding($str, 'GBK');
        $asc = '';
        for ($i = 0; $i < strlen($str); $i++) {
            $temp_str = dechex(ord($str[$i]));
            $asc .= $temp_str[0].$temp_str[1];
        }
        return strtoupper($asc);
    }

    /**
     * 字符串转字符数组
     * @param $str
     * @return array
     */
    public static function strToByteArr($str)
    {
        $length = strlen($str);
        $arr = array();
        for ($i = 0; $i < $length; $i++) {
            $arr[$i] = substr($str, $i, 1);
        }
        return $arr;
    }
    /**
     * 字符串倒序
     * @param $str
     * @return string
     */
    public static function string_reverse($str){
        $length = strlen($str);
        $arr = array();
        for ($i = 0; $i < $length; $i++) {
            $arr[$i] = substr($str, $i, 1);
        }
        return implode("",array_reverse($arr));
    }
    public static function strToUtf8($str){
        $encode = mb_detect_encoding($str, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
        if($encode == 'UTF-8'){
            return $str;
        }else{
            return mb_convert_encoding($str, 'UTF-8', $encode);
        }
    }

}

