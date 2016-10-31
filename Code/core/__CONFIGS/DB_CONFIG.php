<?php

$name = 'mysql';

$array = array(
    'enabled' => true,
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'dbName' => 'PHPWebFramework',
    'usersTableName' => 'users',
    'usersSessionsTableName' => 'users_sessions',
    'usersResetPasswordTableName' => 'users_password_reset',
    'passwordResetExpiration' => 60 * 60 * 24 * 2 // set how long the password expiration email is valid for
);