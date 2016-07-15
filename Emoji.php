<?php

namespace QmEmoji ;

use QmEmoji\Lib\BaseConvert;

class Emoji{

    private $convert = null ;

    function __construct(BaseConvert $convert){
        $this->convert = $convert ;
    }

    public function encode($text){
        return $this->convert->encode($text) ;
    }

    public function decode($text){
        return $this->convert->decode($text) ;
    }

}