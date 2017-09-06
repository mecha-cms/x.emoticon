<?php

Hook::set('on.panel.ready', function() {
    Asset::set(__DIR__ . DS . 'lot' . DS . 'asset' . DS . 'css' . DS . 'emoticon.min.css');
});