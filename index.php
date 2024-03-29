<?php namespace x\emoticon;

function from(string $content, array $any) {
    foreach ($any as $k => $v) {
        $content = \preg_replace('/\B(' . $v . ')\B/', '<span class="emoticon:' . $k . '"><b>$1</b></span>', $content);
    }
    return $content;
}

function page__content($content) {
    if (!$content) {
        return $content;
    }
    \extract(\lot(), \EXTR_SKIP);
    $state = $state->x->emoticon ?? [];
    $alter = $state->alter ?? [];
    $type = $state->type ?? 0;
    $any = [];
    if (!empty($alter)) {
        foreach ($alter as $k => $v) {
            $any[$k . '-' . $type] = ':' . $k . ':|' . \strtr(\x($v), ' ', '|');
        }
    }
    // Skip parsing process if we are in these HTML element(s)
    $parts = (array) \preg_split('/(<!--[\s\S]*?-->|' . \implode('|', (static function ($parts) {
        foreach ($parts as $k => &$v) {
            $v = '<' . \x($k) . '(?:\s[\p{L}\p{N}_:-]+(?:=(?:"[^"]*"|\'[^\']*\'|[^\/>]*))?)*>(?:(?R)|[\s\S])*?<\/' . \x($k) . '>';
        }
        unset($v);
        return $parts;
    })([
        'pre' => 1,
        'code' => 1, // Must come after `pre`
        'kbd' => 1,
        'math' => 1,
        'script' => 1,
        'style' => 1,
        'textarea' => 1
    ])) . '|<(?:"[^"]*"|\'[^\']*\'|[^>]+)*>|https?:\/\/\S+)/', $content, -1, \PREG_SPLIT_NO_EMPTY | \PREG_SPLIT_DELIM_CAPTURE);
    $content = "";
    foreach ($parts as $part) {
        if (0 === \strpos($part, 'http://') || 0 === \strpos($part, 'https://')) {
            $content .= $part; // Is an URL, skip!
            continue;
        }
        if ($part && '<' === $part[0] && '>' === \substr($part, -1)) {
            $content .= $part; // Is a HTML tag or comment, skip!
            continue;
        }
        $content .= \x\emoticon\from($part, $any);
    }
    return "" !== $content ? $content : null;
}

function page__description($description) {
    return \fire(__NAMESPACE__ . "\\page__content", [$description], $this);
}

function page__title($title) {
    return \fire(__NAMESPACE__ . "\\page__content", [$title], $this);
}

\Hook::set('page.content', __NAMESPACE__ . "\\page__content", 2.1);
\Hook::set('page.description', __NAMESPACE__ . "\\page__description", 2.1);
\Hook::set('page.title', __NAMESPACE__ . "\\page__title", 2.1);

$z = \defined("\\TEST") && \TEST ? '.' : '.min.';
\Asset::set(__DIR__ . \D . 'index' . $z . 'css');

if (\defined("\\TEST") && 'x.emoticon' === \TEST && \is_file($test = __DIR__ . \D . 'test.php')) {
    require $test;
}