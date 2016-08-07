<?php

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
            $_usersResetPasswordTableName;
    
    public function __construct( $user = null )
	{
        if ( Config::get( "mysql/enabled" ) )
        {
            $this->_db = DB::getInstance( );

            $this->_sessionName = Config::get( "session/sessionName" );
            $this->_cookieName = Config::get( "remember/cookieName" );
            
            $this->_usersTable = Config::get( "mysql/usersTableName" );
            $this->_usersResetPasswordTableName = Config::get( "mysql/usersResetPasswordTableName" );
            
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
    	return $this->_isLoggedIn;
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
}

?>