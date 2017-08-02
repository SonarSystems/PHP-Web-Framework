<?php

$name = 'users';

$array = array(
    'usersTableName' => 'users',
    'usersSessionsTableName' => 'users_sessions',
    'usersResetPasswordTableName' => 'users_password_reset',
    'userPrivilegesTableName' => 'userprivileges',
    'passwordResetExpiration' => 60 * 60 * 24 * 2 // set to 0 for no time limit
);