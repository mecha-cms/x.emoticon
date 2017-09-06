<?php

$state = Plugin::state(__DIR__);

$replaces = [];
$i = isset($state['type']) ? $state['type'] : 0;
if (!empty($state['replace'])) {
    foreach ($state['replace'] as $k => $v) {
        $replaces[$k . '-' . $i] = array_merge(explode(' ', trim($v)), [':' . $k . ':']);
    }
}

Lot::set('emoticon', $replaces, __DIR__);

function fn_emoticon($content, $lot = [], $that = null, $key = null) {
    $a = preg_split('#(<[^<>]+?>)#', $content, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    $s = "";
    $skip = 0;
    foreach ($a as $v) {
        if ($v && $v[0] === '<' && substr($v, -1) === '>') {
            $s .= $v; // Is a HTML tag, skip!
            if (preg_match('#^<(?:code|kbd|pre|script|style|textarea)\b#', $v)) {
                $skip = 1;
            } else if ($v[1] === '/') {
                $skip = 0;
            }
        } else {
            $s .= $skip ? $v : fn_emot_replace($v);
        }
    }
    return $s;
}

function fn_emot_replace($s) {
    foreach ((array) Lot::get('emoticon', [], __DIR__) as $k => $v) {
        $s = str_replace($v, '<i class="emoticon:' . $k . '"></i>', $s);
    }
    return $s;
}

if (!empty($state['hooks'])) {
    Hook::set($state['hooks'], 'fn_emoticon', 2.1);
}

// Load the asset!
Asset::set(__DIR__ . DS . 'lot' . DS . 'asset' . DS . 'css' . DS . 'emoticon.min.css');