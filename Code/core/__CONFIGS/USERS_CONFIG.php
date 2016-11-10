<?php

$name = 'users';

$array = array(
    'usersTableName' => 'users',
    'usersSessionsTableName' => 'users_sessions',
    'usersResetPasswordTableName' => 'users_password_reset',
    'passwordResetExpiration' => 60 * 60 * 24 * 2 // (NEEDS TO BE IMPLEMENTED) set how long the password expiration email is valid for
);