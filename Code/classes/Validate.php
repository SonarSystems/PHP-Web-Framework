<?php

namespace Sonar;

require_once( "DB.php" );
require_once( "Error.php" );

class Validate extends __Error
{
    private $_db = null;
    
    public function __construct( )
    {
        if ( Config::get( "mysql/enabled" ) )
        {
            $this->_db = DB::getInstance( );
        }        
    }
    
    public function check( $source, $items = array( ), $errorNames = array( ) )
    {
        $i = 0;
        
        foreach( $items as $item => $rules )
        {
            foreach( $rules as $rule => $ruleValue )
            {
                $value = trim( $source[$item] );
                $rule = strtolower( $rule );
                
                // check if a specific error name exists, if not use variable name
                if ( !isset( $errorNames[$i] ) )
                {
                    $errorName = $item;
                }
                else
                {
                    $errorName = $errorNames[$i];
                }
                
                if ( 'required' === $rule && empty( $value ) )
                {
                    $this->addError( "{$errorName} is required" );
                }
                else if ( !empty( $value ) )
                {
                    switch ( $rule )
                    {
                        case "min":
                            if ( strlen( $value ) < $ruleValue )
                            {
                                $this->addError( "{$errorName} must be a minimum of {$ruleValue} characters" );
                            }
                            
                            break;
                            
                        case "max":
                            if ( strlen( $value ) > $ruleValue )
                            {
                                $this->addError( "{$errorName} must be a maximum of {$ruleValue} characters" );
                            }
                            
                            break;
                            
                        case "matches":
                            if ( $value !== $source[$ruleValue] )
                            {
                                $this->addError( "{$errorName}'s must match" );
                            }
                            
                            break;
                            
                        // make sure the post name is the same as the name in the database
                        case "unique":
                            $check = $this->_db->get( $ruleValue, array( $item, "=", $value ) );
                            
                            if ( $check->count( ) )
                            {
                                $this->addError( "{$errorName} already exists" );
                            }
                            
                            break;
                            
                        case "exists":
                            $check = $this->_db->get( $ruleValue, array( $item, "=", $value ) );
                            
                            if ( !$check->count( ) )
                            {
                                $this->addError( "{$errorName} does not exist" );
                            }
                            
                            break;
                            
                        case "email":
                            if ( $ruleValue )
                            {
                                if ( !filter_var( $value, FILTER_VALIDATE_EMAIL ) )
                                {
                                    $this->addError( "{$errorName} must be a valid email address" );
                                }
                            }
                            else
                            {
                                if ( filter_var( $value, FILTER_VALIDATE_EMAIL ) )
                                {
                                    $this->addError( "{$errorName} must not be an email address" );
                                }
                            }
                            
                            break;
                            
                        case "url":
                            if ( !filter_var( $value, FILTER_VALIDATE_URL ) )
                            {
                                $this->addError( "{$errorName} must be a valid url" );
                            }
                            
                            break;
                            
                        case "numeric":
                            if ( $ruleValue )
                            {
                                if ( !is_numeric( $value ) )
                                {
                                    $this->addError( "{$errorName} must be a number" );
                                }
                            }
                            else
                            {
                                if ( is_numeric( $value ) )
                                {
                                    $this->addError( "{$errorName} must not be a number" );
                                }
                            }
                            
                            break;       
                    }
                }
            }
            
            $i++;
        }
        
        if ( empty( $this->_errors ) )
        {
            $this->_passed = true;
        }
        
        return $this;
    }
}

?>