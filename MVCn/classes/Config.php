<?php

$GLOBALS['config'] = array(
    'debug' => true,
    
    'mysql' => array(
        'enabled' => true,
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbName' => 'mvc_test_db'
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
        'root' => dirname( $_SERVER["SCRIPT_NAME"] )
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