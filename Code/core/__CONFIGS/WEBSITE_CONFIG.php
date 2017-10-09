<?php

$name = 'website';

$array = array(
    'debug' => true,
    'version' => '1', // website version
    'title' => 'Awesome Site Title',
    'contactEmailAddress' => 'contact@domain.com', // INSERT contact email address here
    'contactName' => 'Name',
    'companyName' => 'Microsoft',
    'root' => dirname( $_SERVER["SCRIPT_NAME"] ),
    'domainName' => $_SERVER['HTTP_HOST']
);