<?php

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
        $this->_response = Input::get( "g-recaptcha-response", $_POST );
        $this->_remoteIP = $_SERVER['REMOTE_ADDR'];
    }
    
    public function check( )
    {
        //$recaptchaErrors = '';
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
            //$recaptchaErrors = $resp->getErrorCodes(); // set the error in varible
            
            $this->addError( "Error occured with reCAPTCHA, please try again later." );
            
            return false;
        }
    }
}

?>