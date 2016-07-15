<?php
header('Content-type: text/html; charset=UTF-8');
require_once "../Autoloader.php" ;

$testStr = "my heart is broken 💔" ;

use QmEmoji\Emoji ;
use QmEmoji\Lib\UnicodeConvert ;

$emoji = new Emoji(new UnicodeConvert()) ;

$ecodeStr = $emoji->encode($testStr) ;

$decodeStr =  $emoji->decode($ecodeStr) ;

echo $ecodeStr."\n\n" ;
echo $decodeStr."\n\n" ;