<?php
/**
 * Created by PhpStorm.
 * User: Qmore
 * Date: 16-7-14
 * Time: 下午2:01
 * unicode转换器
 */

namespace QmEmoji\Lib ;

 class UnicodeConvert extends BaseConvert{

     public $prefix = "U+" ;

     private $tagArray = array();

     public function __construct(){
         $this->tagArray = explode("{{}}",$this->tagTemplate) ;
         if(empty($this->tagArray) || count($this->tagArray) !== 2){
             throw new \InvalidArgumentException('Invalid tagTemplate string given.i.e "[tag]{{}}[/tag]"');
         }
     }

     /**
      *
      * 转换接口 （含有表情字符串转化为形如 [tag]$prefix.UNICODE[tag]形式）
      *
      * @param $text
      * @return string
      */
     public function encode($text)
     {
         $text = preg_replace_callback("/./us",function($match){
             if(strlen($match[0])>3)
                 return $this->tagArray[0].$this->prefix.$this->bin_to_unicode($match[0]). $this->tagArray[1] ;
             return $match[0] ;
         },$text) ;
         return $text ;
     }

     /**
      *
      * 解码
      *
      * @param $text
      * @return mixed|void
      */
     public function decode($text)
     {
         $tagPrefix = preg_quote($this->tagArray[0],"/") ;
         $tagSuffix = preg_quote($this->tagArray[1],"/") ;
         $text = preg_replace_callback("/$tagPrefix([\s\S]*?)$tagSuffix/i",function($match){
             $unicode_str = substr($match[1],count($this->prefix));
             return $this->unicode_to_bin($unicode_str);
         },$text) ;
         return $text ;
     }


     /**
      *
      * 16进制字符串 转为 数字
      *
      * @param $unicode_str
      * @return mixed
      */
     private function hexStr_to_num($unicode_str){
         sscanf($unicode_str,"%x",$unicode_num) ;
         return $unicode_num ;
     }

     /**
      * 表情（二进制字符）转化为对应unicode字符串
      *
      * @param $bin
      * @return string|void
      */
     private function bin_to_unicode($bin){
         $hex = bin2hex($bin) ;
         $num =  $this->hexStr_to_num($hex) ;
         if($num > 0xffffff){
             #四个字节
             $unicode_num =  ( ( ord($bin[0]) & 0x7 ) << 18 ) |
                 ( ( ord($bin[1]) & 0x3f ) << 12) |
                 ( ( ord($bin[2]) & 0x3f ) << 6) |
                 ( ord($bin[3]) & 0x3f );
         }else if($num > 0xffff){
             #三个字节
             $unicode_num = ( ( ord($bin[0]) & 0xf ) << 12 ) |
                 ( ( ord($bin[1]) & 0x3f) << 6 ) |
                 ( ord($bin[2]) & 0x3f ) ;
         }else if($num > 0xff){
             #两个字节
             $unicode_num = ( ( ord($bin[0]) & 0x1f) << 6 ) |
                 ( ord($bin[1]) & 0x3f ) ;
         }else{
             $unicode_num = ord($bin) ;
         }
         return dechex($unicode_num) ;
     }

     /**
      *
      * unicode字符串转化为 对应二进制字符bin
      *
      * @param $unicode
      * @return string|void
      */
     private function unicode_to_bin($unicode){
         if(is_string($unicode))
             $unicode_num = $this->hexStr_to_num($unicode) ;
         else
             $unicode_num = $unicode ;

         if ($unicode_num > 0x10000){
             # 四个字节转换
             return	chr(0xF0 | (($unicode_num & 0x1C0000) >> 18)).
             chr(0x80 | (($unicode_num & 0x3F000) >> 12)).
             chr(0x80 | (($unicode_num & 0xFC0) >> 6)).
             chr(0x80 | ($unicode_num & 0x3F));
         }else if ($unicode_num > 0x800){
             # 三个字节转换
             return	chr(0xE0 | (($unicode_num & 0xF000) >> 12)).
             chr(0x80 | (($unicode_num & 0xFC0) >> 6)).
             chr(0x80 | ($unicode_num & 0x3F));
         }else if ($unicode_num > 0x80){
             # 二和字节转换
             return	chr(0xC0 | (($unicode_num & 0x7C0) >> 6)).
             chr(0x80 | ($unicode_num & 0x3F));
         }else{
             return chr($unicode_num);
         }
     }

 }
