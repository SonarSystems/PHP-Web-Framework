<?php

namespace Sonar;

class __Error
{
    protected $_passed = false,
            $_errors = array( );
    
    public function __construct( )
    {
        
    }
    
    public function addError( $error )
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