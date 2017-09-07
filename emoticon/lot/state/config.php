<?php

return [
    'type' => 1, // Can be `0` or `1`
    // Determine characters which should be recognized as an emoticon
    // Order does matter!
    'replace' => [
        'angry' => '>:( &gt;:( 😠', // must come before `:(`
        'baffle' => 'o_o O_o o_O 😯',
        'confuse' => ':s :S 😕',
        'cool' => 'B) 😎',
        'cry' => ':\'( T_T 😢 😭',
        'evil' => '>:) &gt;:) 😈', // must come before `:)`
        'frustrate' => '>:O &gt;:O 😫',
        'grin' => ':)) 😁', // must come before `:)`
        'happy' => ':D =D 😃',
        'hipster' => ':3',
        'neutral' => ':| 😐',
        'sad' => ':( 😞 🙁 ☹',
        'sleepy' => ':OzZ 😪', // must come before `:O`
        'shock' => ':O 😲 😨',
        'smile' => ':) 😊 ☺',
        'tongue' => ':p :P 😋 😛 😜 😝',
        'wink' => ';) 😉',
        'wonder' => ':\ :/ 🤔'
    ]
];