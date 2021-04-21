<?php

// case
// json2phpArray('{"keywords":"","manager":[{"k1":"v1", "k2":[{"t1":"v1"}]}, {"k1":"v11", "k2":[{"t1":"v1"}]}]}');

// main function
function json2phpArray(string $json)
{
    $arr = json_decode($json, true);
    if (json_last_error()) {
        die('please input correct json format');
    }
    echo (buildArray($arr));
}

function buildArray(array $arr, string $space = "&nbsp&nbsp") :string
{
    $tmp = "";
    foreach ($arr as $k => $item) {
        if (is_array($item)) {
            $a = buildArray($item, $space . "&nbsp&nbsp");
            if (is_string($k)) {
                $tmp .= "{$space}'{$k}' => {$a}";
            } else {
                $tmp .= "{$space}{$a}";
            }
            continue;
        }
        $itemStr = "";
        if (is_int($item) || is_float($item)) {
            $itemStr .= "{$item}";
        } else {
            $itemStr .= "'{$item}'";
        }

        if (!is_string($k)) {
            $tmp .= "{$space}{$itemStr},<br/>";;
        } else {
            $tmp .= "{$space}'{$k}' => {$itemStr},<br/>";;
        }
    }
    $tmp = rtrim($tmp, "<br/>");
    return "[{$space}<br/>$tmp<br/>{$space}],<br/>";
}