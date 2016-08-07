<?php

$GLOBALS['config'] = array(
    'debug' => true,
    
    'mysql' => array(
        'enabled' => true,
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbName' => 'mvc_test_db',
        'usersTableName' => 'users',
        'usersSessionsTableName' => 'users_sessions',
        'usersResetPasswordTableName' => 'users_password_reset',
        'passwordResetExpiration' => 60 * 60 * 24 * 2 // set how long the password expiration email is valid for
    ),
    
    'remember' => array(
        'cookieName' => 'hash',
        'cookieExpiry' => '604800' // in seconds
    ),
    
    'session' => array(
        'sessionName' => 'user',
        'tokenName' => 'token'
    ),
    
    'website' => array(
        'version' => '1', // website version
        'title' => 'Awesome Site Title',
        'contactEmailAddress' => 'contact@domain.com', // INSERT contact email address here
        'contactName' => 'Name',
        'root' => dirname( $_SERVER["SCRIPT_NAME"] ),
        'domainName' => $_SERVER['HTTP_HOST']
    ),
    
    'meta' => array(
        'charset' => 'UTF-8',
        'author' => 'Author Name',
        'description' => 'Description Of This Website',
        'keywords' => array(
            '1',
            '2',
            '3',
            '4',
            '5'
        )
    ),
    
    'security' => array(
        'GooglereCAPTCHA' => array(
            'sitekey' => '6Lfr_SYTAAAAAEH0RZRaAjMN8f8vQp6og_WjmVq_',
            'secretkey' => '6Lfr_SYTAAAAAJfpEX3FwHb3ek6m1orOjWtBAEI5'
        )
    )
);

class Config
{
	public static function get( $path = null )
	{
		if ( $path )
		{
			$config = $GLOBALS['config'];
			$path = explode( '/', $path );

			foreach( $path as $bit )
			{
				if ( isset( $config[$bit] ) )
				{
					$config = $config[$bit];
				}
			}

			return $config;
		}

		return false;
	}
}

?>