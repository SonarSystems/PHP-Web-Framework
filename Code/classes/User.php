<?php

namespace Sonar;

require_once( "Config.php" );
require_once( "Cookie.php" );
require_once( "Error.php" );

class User extends __Error
{
    private $_db,
    		$_data,
    		$_sessionName,
    		$_cookieName,
    		$_isLoggedIn,
            $_usersTable,
            $_usersResetPasswordTableName,
            $_socialConfig,
            $_hybridAuth;

    public function __construct( $user = null )
	{
        if ( Config::get( "mysql/enabled" ) )
        {
            $this->_db = DB::getInstance( );

            $this->_sessionName = Config::get( "session/sessionName" );
            $this->_cookieName = Config::get( "remember/cookieName" );

            $this->_usersTable = Config::get( "mysql/usersTableName" );
            $this->_usersResetPasswordTableName = Config::get( "mysql/usersResetPasswordTableName" );
            
            $this->_socialConfig = array(
                "base_url" => "http://".Config::get( "website/domainName" ).substr( Config::get( "website/root" ), 0, -6 )."libs/hybridauth/hybridauth/index.php",
                "providers" => array (
                    "Google" => array (
                        "enabled" => Config::get( "social/isEnabled/google" ),
                        "keys"    => array ( "id" => Config::get( "social/keys/google/id" ), "secret" => Config::get( "social/keys/google/secret" ) ),
                    ),
                    "Facebook" => array (
                        "enabled" => Config::get( "social/isEnabled/facebook" ),
                        "keys" => array ( "id" => Config::get( "social/keys/facebook/id" ), "secret" => Config::get( "social/keys/facebook/secret" ) )
                    )
                )
            );
            

            $this->_hybridAuth = new \Hybrid_Auth( $this->_socialConfig );
            
            foreach ( Config::get( "social/isEnabled" ) as $provider => $value )
            {
                // check if social login for a particular provider is enabled
                if ( $value )
                {
                    // loop through the providors from _socialConfig
                    if ( $this->_hybridAuth->isConnectedWith( $provider ) )
                    {
                        $adapter = $this->_hybridAuth->authenticate( $provider );

                        try
                        {
                            $user_profile = $adapter->getUserProfile( );

                            $this->socialLogin( $user_profile->identifier, $user_profile->email, $provider );
                        }
                        catch( Exception $e )
                        {
                            $this->_hybridAuth->logoutAllProviders( );
                        }
                    }
                }
            }

            if ( !$user )
            {
                if ( Session::exists( $this->_sessionName ) )
                {
                    $user = Session::get( $this->_sessionName );

                    if ( $this->find( $user ) )
                    {
                        $this->_isLoggedIn = true;
                    }
                    else
                    {
                        // process logout
                        $this->logout( );
                    }
                }
            }
            else
            {
                $this->find( $user );
            }
        }
	}

	public function update( $fields = array( ), $id = null )
	{
		if ( !$id && $this->isLoggedIn( ) )
		{
			$id = $this->data( )->id;
		}

		if ( !$this->_db->update( $this->_usersTable, $id, $fields ) )
		{
			return false;
		}
        else
        {
            return true;
        }
	}

    public function create( $fields = array( ) )
    {
        if ( !$this->_db->insert( $this->_usersTable, $fields ) )
        {
            throw new Exception( "There was a problem creating an account." );
        }
    }

    public function find( $user = null )
    {
    	if ( $user )
    	{
            if ( is_numeric( $user ) )
            {
                $field = "id";
            }
            else if ( filter_var( $user, FILTER_VALIDATE_EMAIL ) )
            {
                $field = "email_address";
            }
            else
            {
                $field = "username";
            }

    		$data = $this->_db->get( $this->_usersTable, array( $field, "=", $user ) );

    		if ( $data->count( ) )
    		{
    			$this->_data = $data->first( );

    			return true;
    		}
    	}

    	return false;
    }

    public function findUsingEmail( $email = null )
    {
        if ( $email )
    	{
    		$data = $this->_db->get( $this->_usersTable, array( "email_address", "=", $email ) );

    		if ( $data->count( ) )
    		{
    			$this->_data = $data->first( );

    			return true;
    		}
    	}

    	return false;
    }

    public function verifyPassword( $passwordToVerify )
    {
        return password_verify( $passwordToVerify, $this->data( )->password );
    }

    public function login( $username = null, $password = null, $remember = false )
    {
    	if ( !$username && !$password && $this->exists( ) )
    	{
    		Session::put( $this->_sessionName, $this->data( )->id );
    	}
    	else
    	{
    		$user = $this->find( $username );

	    	if ( $user )
	    	{
	    		if ( password_verify( $password, $this->data( )->password ) )
	    		{
                    if ( $this->isActivated( $username ) )
                    {
                        return $this->loginWithOutChecks( $remember );
                    }
                    else
                    {
                        $this->addError( "Your account needs to be activated, please check your email for an activation email." );
                    }
	    		}

                $this->addError( "Password is incorrect." );
	    	}
            else
            {
                $this->addError( "User does not exist." );
            }
    	}

    	return false;
    }
    
    private function loginWithOutChecks( $remember = true )
    {
        Session::put( $this->_sessionName, $this->data( )->id );

        if ( $remember )
        {
            $hash = Hash::unique( );
            $hashCheck = $this->_db->get( "users_sessions", array( "user_id", "=", $this->data( )->id ) );

            if ( !$hashCheck->count( ) )
            {
                $this->_db->insert( "users_sessions", array(
                    "user_id" => $this->data( )->id,
                    "hash" => $hash
                ) );
            }
            else
            {
                $hash = $hashCheck->first( )->hash;
            }

            Cookie::put( $this->_cookieName, $hash, Config::get( "remember/cookieExpiry" ) );
        }

        if ( empty( $this->_errors ) )
        {
            $this->_passed = true;
        }

        return true;
    }

    public function verifyActivationCode( $user, $code )
    {
        if ( is_numeric( $user ) )
        {
            $field = "id";
        }
        else if ( filter_var( $user, FILTER_VALIDATE_EMAIL ) )
        {
            $field = "email_address";
        }
        else
        {
            $field = "username";
        }

        $data = $this->_db->get( $this->_usersTable, array( $field, "=", $user ) );

        if ( $data->first( )->salt === $code )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function verifyResetCode( $user, $code )
    {
        $data = $this->_db->get( $this->_usersResetPasswordTableName, array( "username", "=", $user ) );

        if ( $data->count( ) )
        {
            if ( $data->first( )->salt === $code )
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    public function isActivated( $user = null )
    {
        if ( $user )
    	{
    		if ( is_numeric( $user ) )
            {
                $field = "id";
            }
            else if ( filter_var( $user, FILTER_VALIDATE_EMAIL ) )
            {
                $field = "email_address";
            }
            else
            {
                $field = "username";
            }

    		$data = $this->_db->get( $this->_usersTable, array( $field, "=", $user ) );

    		if ( $data->count( ) )
    		{
    			if ( $data->first( )->activated )
                {
                    return true;
                }
    		}
    	}

    	return false;
    }

    public function activateUser( $user )
    {
        if ( is_numeric( $user ) )
        {
            $field = "id";
        }
        else if ( filter_var( $user, FILTER_VALIDATE_EMAIL ) )
        {
            $field = "email_address";
        }
        else
        {
            $field = "username";
        }

        $data = $this->_db->get( $this->_usersTable, array( $field, "=", $user ) );
        $id = $data->first( )->id;

        $result = $this->_db->update( $this->_usersTable, $id, array( "activated" => "1" ) );

        if ( $result )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function exists( )
    {
    	return ( !empty( $this->_data ) ) ? true : false;
    }

    public function logout( )
    {
        $this->_hybridAuth->logoutAllProviders( );

        $this->_db->delete( "users_sessions", array( "user_id", "=", $this->data( )->id ) );

        Session::delete( $this->_sessionName );
        Cookie::delete( $this->_cookieName );
    }

    public function data( )
    {
    	return $this->_data;
    }

    public function isLoggedIn( )
    {
        if ( $this->_isLoggedIn )
        {
            if ( $this->isOnlySociallyLoggedIn( ) )
            {
                Redirect::to( "home/adduserdetails" );
            }
        }
        
    	return $this->_isLoggedIn;
    }
    
    public function isOnlySociallyLoggedIn( )
    {
        if ( $this->_isLoggedIn )
        {
            if ( empty( $this->_data->username ) || empty( $this->_data->password ) )
            {
                return true;
            }
        }
        
        return false;
    }

    public function checkPasswordSaltExists( $username )
    {
        $data = $this->_db->get( $this->_usersResetPasswordTableName, array( "username", "=", $username ) );

        if ( count( $data ) )
        {
            return $data->first( );
        }
        else
        {
            return false;
        }
    }

    public function createPasswordResetSalt( $username, $salt )
    {
        $this->_db->delete( $this->_usersResetPasswordTableName, array( "username", "=", $username ) );

        $fields = array(
            "username" => $username,
            "salt" => $salt,
            "starttime" => time( )
        );

        if ( !$this->_db->insert( $this->_usersResetPasswordTableName, $fields ) )
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function clearPasswordResetTable( $username )
    {
        $this->_db->delete( $this->_usersResetPasswordTableName, array( "username", "=", $username ) );
    }

    public function socialLogin( $id, $emailAddress, $serviceName )
    {
        $serviceName = strtolower( $serviceName );
        
        // check if user exists in social database (if not add)
        $socialResult = $this->_db->get( Config::get( "social/tableNames/".$serviceName ), array( "email_address", "=", $emailAddress ) );
        
        if ( !$socialResult->count( ) )
        {
            $this->_db->insert( Config::get( "social/tableNames/".$serviceName ), array(
                "auth_id" => $id,
                "email_address" => $emailAddress,
                "joined" => time( )
            ) );
        }
        
        // check if user exists in regular database (if not add)
        if ( !$this->find( $emailAddress ) )
        {
            $salt = Hash::salt( 128 );

            $this->create( array(
                "username" => '',
                "password" => '',
                "email_address" => $emailAddress,
                "salt" => $salt,
                "joined" => time( ),
                "activated" => 1
            ) );
        }
        
        // log user in (if username and password do not exist then show user submission detail page)
        $this->find( $emailAddress );
        $this->loginWithOutChecks( true );
        
        //Redirect::to( "home/index" );
    }
    
    public function hybridAuth( )
    {
        return $this->_hybridAuth;
    }
}