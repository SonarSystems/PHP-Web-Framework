<?php

namespace Sonar;

class __Error
{
    protected   $_passed = false,
                $_errors = array( );
    
    public function __construct( )
    {
        
    }
    
    public function AddError( $error )
    {
        $this->_errors[] = $error;
    }
    
    public function Errors( )
    {
        return $this->_errors;
    }
    
    public function passed( )
    {
        return $this->_passed;
    }
}