<?php

/** 参数不存在则退出 */
if (!isset($argv[1])) {
    echo 'no args';
    exit(1);
}

// transfer [] to array()

$file = $argv[1];
$text = file_get_contents($file);

$text = preg_replace("/= \[([^;]*)\];/s", "= array(\\1);", $text);
$text = preg_replace("/(\(| )\[([^\n]*?)\]\)/", "\\1array(\\2))", $text);
$text = preg_replace("/(\(| )\[([^\n]*?)\],/", "\\1array(\\2),", $text);

file_put_contents($file, $text);

