<?php

namespace Sonar;

class CSS
{   
    public function __construct( )
    {
        
    }
    
    // Imports a css font from a URL
    public function Import( $url )
    {
        echo "@import url($url);";
    }
}