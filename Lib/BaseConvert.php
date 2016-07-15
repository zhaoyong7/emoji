<?php
/**
 * Created by PhpStorm.
 * User: Qmore
 * Date: 16-7-14
 * Time: 下午2:01
 */

namespace QmEmoji\Lib ;

abstract class BaseConvert{

    public $prefix = 'Qmore-' ;

    protected $tagTemplate = "[emoji]{{}}[/emoji]" ;

    abstract function encode($text) ;

    abstract function decode($text) ;

}