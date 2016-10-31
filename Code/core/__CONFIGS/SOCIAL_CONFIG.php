<?php

$name = 'social';

$array = array(
    'tableNames' => array(
        'google' => 'google_users',
        'facebook' => 'facebook_users'
    ),
    'isEnabled' => array(
        'google' => true,
        'facebook' => true
    ),
    'keys' => array(
        'google' => array(
            'id' => "",
            'secret' => ""
        ),
        'facebook' => array(
            'id' => "",
            'secret' => ""
        )
    )
);