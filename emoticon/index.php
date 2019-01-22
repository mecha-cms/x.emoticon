<?php

namespace fn {
    $state = \Plugin::state('emoticon');
    $replace = [];
    $i = $state['type'] ?? 0;
    if (!empty($state['replace'])) {
        foreach ($state['replace'] as $k => $v) {
            $replace[$k . '-' . $i] = \array_merge(\explode(' ', \trim($v)), [':' . $k . ':']);
        }
    }
    \Lot::set('_emoticon', $replace);
    function emoticon($content, array $lot = []) {
        $out = "";
        $skip = 0;
        $replace = \Lot::get('_emoticon');
        foreach (\preg_split('#(<[^<>]+?>)#', $content, null, \PREG_SPLIT_NO_EMPTY | \PREG_SPLIT_DELIM_CAPTURE) as $v) {
            if ($v && $v[0] === '<' && \substr($v, -1) === '>') {
                $out .= $v; // Is a HTML tag, skip!
                if (\preg_match('#^<(?:code|kbd|pre|script|style|textarea)\b#', $v)) {
                    $skip = 1;
                } else if ($v[1] === '/') {
                    $skip = 0;
                }
            } else {
                $out .= $skip ? $v : emoticon\replace($v, $replace);
            }
        }
        return $out;
    }
    \Hook::set([
        '*.content',
        '*.description',
        '*.title'
    ], __NAMESPACE__ . "\\emoticon", 2.1);
    // Load the asset!
    \Asset::set(__DIR__ . DS . 'lot' . DS . 'asset' . DS . 'css' . DS . 'emoticon.min.css');
}

namespace fn\emoticon {
    function replace($in, $lot) {
        $in = \str_replace('://', ':' . X . '//', $in); // Maybe an URL protocol?
        foreach ($lot as $k => $v) {
            $in = \str_replace($v, '<i class="emoticon:' . $k . '"></i>', $in);
        }
        return \str_replace(':' . X . '//', '://', $in);
    }
}