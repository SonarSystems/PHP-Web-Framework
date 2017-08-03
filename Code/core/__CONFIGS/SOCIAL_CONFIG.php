<?php

$name = 'social';

$array = array(
    'tableNames' => array(
        'google' => 'googleusers',
        'facebook' => 'facebookusers'
    ),
    'isEnabled' => array(
        'hybridAuth' => true, // this disables all social login functionality
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