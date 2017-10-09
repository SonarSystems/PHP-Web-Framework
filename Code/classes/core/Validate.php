<?php

namespace Sonar;

require_once( "DB.php" );
require_once( "Error.php" );

class Validate extends __Error
{
    private $_db = null;
    
    public function __construct( )
    {
        if ( Config::Get( "mysql/enabled" ) )
        {
            $this->_db = DB::GetInstance( );
        }        
    }
    
    // Check if items match validation criteria
    public function Check( $source, $items = array( ), $errorNames = array( ) )
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
                    $this->AddError( "{$errorName} is required" );
                }
                else if ( !empty( $value ) )
                {
                    switch ( $rule )
                    {
                        case "min":
                            if ( self::Min( $value, $ruleValue ) )
                            {
                                $this->AddError( "{$errorName} must be a minimum of {$ruleValue} characters" );
                            }
                            
                            break;
                            
                        case "max":
                            if ( self::Max( $value, $ruleValue ) )
                            {
                                $this->AddError( "{$errorName} must be a maximum of {$ruleValue} characters" );
                            }
                            
                            break;
                            
                        case "matches":
                            if ( !self::Matches( $value, $source[$ruleValue] ) )
                            {
                                $this->AddError( "{$errorName}'s must match" );
                            }
                            
                            break;
                            
                        // make sure the post name is the same as the name in the database
                        case "unique":                            
                            if ( !$this->Unique( $item, $value, $ruleValue ) )
                            {
                                $this->AddError( "{$errorName} already exists" );
                            }
                            
                            break;
                            
                        case "exists":                            
                            if ( !$this->Exists( $item, $value, $ruleValue ) )
                            {
                                $this->AddError( "{$errorName} does not exist" );
                            }
                            
                            break;
                            
                        case "email":
                            if ( $ruleValue )
                            {
                                if ( !self::Email( $value ) )
                                {
                                    $this->AddError( "{$errorName} must be a valid email address" );
                                }
                            }
                            else
                            {
                                if ( self::Email( $value ) )
                                {
                                    $this->AddError( "{$errorName} must not be an email address" );
                                }
                            }
                            
                            break;
                            
                        case "url":
                            if ( $ruleValue )
                            {
                                if ( !self::URL( $value ) )
                                {
                                    $this->AddError( "{$errorName} must be a valid url" );
                                }
                            }
                            else
                            {
                                if ( self::URL( $value ) )
                                {
                                    $this->AddError( "{$errorName} must not be a url" );
                                }
                            }
                            
                            
                            break;
                            
                        case "numeric":
                            if ( $ruleValue )
                            {
                                if ( !self::Numeric( $value ) )
                                {
                                    $this->AddError( "{$errorName} must be a number" );
                                }
                            }
                            else
                            {
                                if ( self::Numeric( $value ) )
                                {
                                    $this->AddError( "{$errorName} must not be a number" );
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
    
    // Check value's minimum length
    public static function Min( $value1, $value2 )
    {
        return ( strlen( $value1 ) < $value2 );
    }
    
    // Check value's maximum length
    public static function Max( $value1, $value2 )
    {
        return ( strlen( $value1 ) > $value2 );
    }
    
    // Check if 2 values match each other (value and typ)
    public static function Matches( $value1, $value2 )
    {
        return ( $value1 === $value2 );
    }
    
    // Check if the value does not exist in the database
    public function Unique( $id, $value, $tablename )
    {
        $check = $this->_db->Get( $tablename, array( $id, "=", $value ) );
                            
        if ( $check->count( ) )
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    // Check if the value already exists in the database
    public function Exists( $id, $value, $tablename )
    {
        $check = $this->_db->Get( $tablename, array( $id, "=", $value ) );
                            
        if ( $check->count( ) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    // Check if the value is an email
    public static function Email( $value )
    {
        return filter_var( $value, FILTER_VALIDATE_EMAIL );
    }
    
    // Check if the value is a URL
    public static function URL( $value )
    {
        return filter_var( $value, FILTER_VALIDATE_URL );
    }
    
    // Check if the value is a number
    public static function Numeric( $value )
    {
        return is_numeric( $value );
    }
}