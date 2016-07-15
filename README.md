#QMEmoji
将emoji表情转换为自定义标签形式，如[emoji]U+xxxxx[/emoji]

##Basic Usage

```php
<?php

$testStr = "my heart is broken 💔" ;

$emoji = new Emoji(new UnicodeConvert()) ;

$ecodeStr = $emoji->encode($testStr) ;

$decodeStr =  $emoji->decode($ecodeStr) ;

echo $ecodeStr."\n\n" ;
echo $decodeStr."\n\n" ;

```

##LICENSE
released under the [MIT license](https://github.com/zhaoyong7/QMEmoji/blob/master/MIT-LICENSE.txt).



