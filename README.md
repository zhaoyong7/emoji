#QMEmoji
将emoji表情转换为自定义标签形式，如[emoji]U+xxxxx[/emoji]

##Basic Usage

```php
<?php

$testStr = "my heart is broken 💔，" ;

$emoji = new Emoji(new UnicodeConvert()) ;

echo $emoji->encode($testStr) ;

echo "<br>" ;

echo $emoji->decode($testStr) ;

##LICENSE
released under the [MIT license](https://github.com/zhaoyong7/QMEmoji/blob/master/MIT-LICENSE.txt).



