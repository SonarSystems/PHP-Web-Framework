<?php

require_once( "Config.php" );
require_once( "Cookie.php" );

class User
{
    private $_db,
    		$_data,
    		$_sessionName,
    		$_cookieName,
    		$_isLoggedIn;
    
    public function __construct( $user = null )
	{
        if ( Config::get( "mysql/enabled" ) )
        {
            $this->_db = DB::getInstance( );

            $this->_sessionName = Config::get( "session/sessionName" );
            $this->_cookieName = Config::get( "remember/cookieName" );

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

		if ( !$this->_db->update( "users", $id, $fields ) )
		{
			throw new Exception( "There was a problem updating" );
		}
	}

    public function create( $fields = array( ) )
    {
        if ( !$this->_db->insert( "users", $fields ) )
        {
            throw new Exception( "There was a problem creating an account." );
        }
    }

    public function find( $user = null )
    {
    	if ( $user )
    	{
    		$field = ( is_numeric( $user ) ) ? "id" : "username";
    		$data = $this->_db->get( "users", array( $field, "=", $user ) );

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

                        return true;
                    }
	    		}
	    	}
    	}

    	return false;
    }
    
    public function isActivated( $user = null )
    {
        if ( $user )
    	{
    		$field = ( is_numeric( $user ) ) ? "id" : "username";
    		$data = $this->_db->get( "users", array( $field, "=", $user ) );

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
}

?>