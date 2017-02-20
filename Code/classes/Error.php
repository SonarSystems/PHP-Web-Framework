<?php

namespace Sonar;

class __Error
{
    protected   $_passed = false,
                $_errors = array( );
    
    public function __construct( )
    {
        
    }
    
    // Add an error onto the error array
    public function AddError( $error )
    {
        $this->_errors[] = $error;
    }
    
    // Get all errors
    public function Errors( )
    {
        return $this->_errors;
    }
    
    // Check if the desired function is successful
    public function Passed( )
    {
        return $this->_passed;
    }
}