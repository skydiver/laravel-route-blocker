<?php

    return [

        # WHITELIST EXAMPLE
        'whitelist' => [

            'group1' => [
                '127.0.0.1',
                '127.0.0.2',
                '192.168.17.0',
                '10.0.0.*'
            ],

            'group2' => [
                '8.8.8.8',
                '8.8.8.*',
                '8.8.4.4',
            ],

        ],

        # RESPONSE SETTINGS
        'redirect_to' => '',
        'response_status'  => 403,
        'response_message' => ''

    ];

?>
