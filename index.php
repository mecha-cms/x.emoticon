<?php namespace x;

function emoticon($content) {
    if (!$content) {
        return $content;
    }
    \extract($GLOBALS, \EXTR_SKIP);
    $state = $state->x->emoticon ?? [];
    $alter = $state->alter ?? [];
    $type = $state->type ?? 0;
    $any = [];
    $replace = static function ($content, $any) {
        foreach ($any as $k => $v) {
            $content = \preg_replace('/\B(' . $v . ')\B/', '<span class="emoticon:' . $k . '"><b>$1</b></span>', $content);
        }
        return $content;
    };
    if (!empty($alter)) {
        foreach ($alter as $k => $v) {
            $any[$k . '-' . $type] = ':' . $k . ':|' . \strtr(\x($v), ' ', '|');
        }
    }
    // Skip parsing process if we are in these HTML element(s)
    $parts = (array) \preg_split('/(<!--[\s\S]*?-->|' . \implode('|', (static function ($tags) {
        foreach ($tags as $k => &$v) {
            $v = '<' . $k . '(?:\s[\p{L}\p{N}_:-]+(?:=(?:"[^"]*"|\'[^\']*\'|[^\/>]*))?)*>(?:(?R)|[\s\S])*?<\/' . $k . '>';
        }
        return $tags;
    })([
        'pre' => 1,
        'code' => 1, // Must come after `pre`
        'kbd' => 1,
        'math' => 1,
        'script' => 1,
        'style' => 1,
        'textarea' => 1
    ])) . '|<(?:"[^"]*"|\'[^\']*\'|[^>])*>|https?:\/\/\S+)/', $content, -1, \PREG_SPLIT_NO_EMPTY | \PREG_SPLIT_DELIM_CAPTURE);
    $out = "";
    foreach ($parts as $v) {
        if (0 === \strpos($v, 'http://') || 0 === \strpos($v, 'https://')) {
            $out .= $v; // Is an URL, skip!
        } else if ($v && '<' === $v[0] && '>' === \substr($v, -1)) {
            $out .= $v; // Is a HTML tag or comment, skip!
        } else {
            $out .= $replace($v, $any);
        }
    }
    return "" !== $out ? $out : null;
}

$z = \defined("\\TEST") && \TEST ? '.' : '.min.';
\Asset::set(__DIR__ . \D . 'index' . $z . 'css');
\Hook::set([
    'page.content',
    'page.description',
    'page.title'
], __NAMESPACE__ . "\\emoticon", 2.1);

if (\defined("\\TEST") && 'x.emoticon' === \TEST && \is_file($test = __DIR__ . \D . 'test.php')) {
    require $test;
}