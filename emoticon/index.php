<?php namespace x;

function emoticon($content) {
    if (!$content) {
        return $content;
    }
    extract($GLOBALS, \EXTR_SKIP);
    $state = $state->x->emoticon ?? [];
    $i = $state->type ?? 0;
    $alter = $state->alter ?? [];
    $any = [];
    $emoticon = function($in, $any) {
        foreach ($any as $k => $v) {
            $in = \preg_replace('/\B(' . $v . ')\B/', '<span class="emoticon:' . $k . '"><span>$1</span></span>', $in);
        }
        return $in;
    };
    if (!empty($alter)) {
        foreach ($alter as $k => $v) {
            $any[$k . '-' . $i] = ':' . $k . ':|' . \strtr(\x($v), ' ', '|');
        }
    }
    // Skip parsing process if we are in these HTML element(s)
    $tags = [
        'pre' => 1,
        'code' => 1, // Must come after `pre`
        'kbd' => 1,
        'math' => 1,
        'script' => 1,
        'style' => 1,
        'textarea' => 1
    ];
    $parts = \preg_split('/(<!--[\s\S]*?-->|' . \implode('|', (static function($tags) {
        foreach ($tags as $k => &$v) {
            $v = '<' . $k . '(?:\s[^>]*)?>[\s\S]*?<\/' . $k . '>';
        }
        return $tags;
    })($tags)) . '|<[^>\s]+(?:\s[^>]*)?>|https?:\/\/\S+)/', $content, null, \PREG_SPLIT_NO_EMPTY | \PREG_SPLIT_DELIM_CAPTURE);
    $out = "";
    foreach ($parts as $v) {
        if (0 === \strpos($v, 'http://') || 0 === \strpos($v, 'https://')) {
            $out .= $v; // Is an URL, skip!
        } else if ($v && '<' === $v[0] && '>' === \substr($v, -1)) {
            $out .= $v; // Is a HTML tag or comment, skip!
        } else {
            $out .= $emoticon($v, $any);
        }
    }
    return "" !== $out ? $out : null;
}

$z = \defined("\\DEBUG") && \DEBUG ? '.' : '.min.';
\Asset::set(__DIR__ . \DS . 'lot' . \DS . 'asset' . \DS . 'css' . \DS . 'index' . $z . 'css');
\Hook::set([
    'page.content',
    'page.description',
    'page.title'
], __NAMESPACE__ . "\\emoticon", 2.1);
