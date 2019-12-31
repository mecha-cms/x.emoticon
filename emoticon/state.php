<?php

return [
    'type' => 1, // Can be `0` or `1`
    // Determine character(s) to be recognized as emoticon(s)
    // Order does matter!
    'alter' => [
        'angry' => '>:( &gt;:( 😠', // Must come before `:(`
        'baffle' => 'o_o O_o o_O 😯',
        'confuse' => ':s :S 😕',
        'cool' => 'B) 😎',
        'cry' => ':\'( T_T 😢 😭',
        'evil' => '>:) &gt;:) 😈', // Must come before `:)`
        'frustrate' => '>:O &gt;:O 😫',
        'grin' => ':)) 😁', // Must come before `:)`
        'happy' => ':D =D 😃',
        'hipster' => ':3',
        'neutral' => ':| 😐',
        'sad' => ':( 😞 🙁 ☹',
        'sleepy' => ':OzZ 😪', // Must come before `:O`
        'shock' => ':O 😲 😨',
        'smile' => ':) 😊 ☺',
        'tongue' => ':p :P 😋 😛 😜 😝',
        'wink' => ';) 😉',
        'wonder' => ':\ :/ 🤔'
    ]
];