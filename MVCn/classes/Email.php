<?php

require_once( "DB.php" );

class Email
{
    private $_passed = false,
            $_errors = array( ),
            $_db = null;
    
    public function __construct( )
    {
        if ( Config::get( "mysql/enabled" ) )
        {
            $this->_db = DB::getInstance( );
        }
    }
    
    public function send( $to = array( ), $subject, $body, $headers = array( ) )
    {
        $headersString = "";
        
        $headersString .= "MIME-Version: 1.0" . "\r\n";
        $headersString .= "Content-type: text/html;charset=UTF-8" . "\r\n";

        foreach( $headers as $header  )
        {
            $headersString .= $header . "\r\n";
        }
        
        $emails = "";
        
        foreach( $to as $email )
        {
            $emails .= $email;
            $emails .= ", ";
        }
        
        if ( file_exists( "../templates/email/" . $body ) )
		{
			$body = file_get_contents( "../templates/email/" . $body );
		}
        
        mail( $emails, $subject, $body, $headersString );
        
        if ( empty( $this->_errors ) )
        {
            $this->_passed = true;
        }
        
        return $this;
    }
    
    private function addError( $error )
    {
        $this->_errors[] = $error;
    }
    
    public function errors( )
    {
        return $this->_errors;
    }
    
    public function passed( )
    {
        return $this->_passed;
    }
}

?>