<?php

$content = file_get_contents(__DIR__ . D . 'test');

echo '<pre style="background:#ccc;border:1px solid rgba(0,0,0,.25);color:#000;font:normal normal 100%/1.25 monospace;padding:.5em .75em;white-space:pre-wrap;word-wrap:break-word;">' . htmlspecialchars($content) . '</pre>';
echo '<pre style="background:#cfc;border:1px solid rgba(0,0,0,.25);color:#000;font:normal normal 100%/1.25 monospace;padding:.5em .75em;white-space:pre-wrap;word-wrap:break-word;">' . htmlspecialchars(fire("x\\emoticon", [$content], (object) [])) . '</pre>';

exit;