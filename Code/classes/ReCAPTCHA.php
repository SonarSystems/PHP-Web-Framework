<?php

namespace Sonar;

require_once( "Config.php" );
require_once( "Input.php" );
require_once( "Error.php" );

class ReCAPTCHA extends __Error
{
    private $_recaptcha,
            $_response,
            $_remoteIP;
    
    public function __construct( )
	{
        $this->_recaptcha = new \ReCaptcha\ReCaptcha( Config::get( "security/GooglereCAPTCHA" )["secretkey"] );
        $this->_response = Input::Get( "g-recaptcha-response", $_POST );
        $this->_remoteIP = $_SERVER['REMOTE_ADDR'];
    }
    
    // Check if the ReCAPTCHA was successful
    public function Check( )
    {
        $resp = $this->_recaptcha->verify( $this->_response, $this->_remoteIP );
        
        if ( $resp->isSuccess( ) )
        {
            if ( empty( $this->_errors ) )
            {
                $this->_passed = true;
            }

            return true;
        }
        else
        {            
            $this->AddError( "Error occured with reCAPTCHA, please try again later." );
            
            return false;
        }
    }
}