<?php

namespace _ {
    $state = \plugin('emoticon');
    $replace = [];
    $i = $state['type'] ?? 0;
    if (!empty($state['replace'])) {
        foreach ($state['replace'] as $k => $v) {
            $replace[$k . '-' . $i] = \array_merge(\explode(' ', \trim($v)), [':' . $k . ':']);
        }
    }
    $GLOBALS['_emoticon'] = $replace;
    function emoticon($content, array $lot = []) {
        $out = "";
        $replace = $GLOBALS['_emoticon'];
        foreach (\preg_split('#(<pre(?:\s[^>]*)?>[\s\S]*?</pre>|<code(?:\s[^>]*)?>[\s\S]*?</code>|<kbd(?:\s[^>]*)?>[\s\S]*?</kbd>|<script(?:\s[^>]*)?>[\s\S]*?</script>|<style(?:\s[^>]*)?>[\s\S]*?</style>|<textarea(?:\s[^>]*)?>[\s\S]*?</textarea>|<[^>]+>)#', $content, null, \PREG_SPLIT_NO_EMPTY | \PREG_SPLIT_DELIM_CAPTURE) as $v) {
            if ($v && $v[0] === '<' && \substr($v, -1) === '>') {
                $out .= $v; // Is a HTML tag, skip!
            } else {
                $out .= emoticon\replace($v, $replace);
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

namespace _\emoticon {
    function replace($in, $lot) {
        $in = \str_replace('://', ':' . X . '//', $in); // Maybe an URL protocol?
        foreach ($lot as $k => $v) {
            $in = \str_replace($v, '<i class="emoticon:' . $k . '"></i>', $in);
        }
        return \str_replace(':' . X . '//', '://', $in);
    }
}