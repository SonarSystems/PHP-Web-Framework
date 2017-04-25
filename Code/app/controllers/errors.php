<?php

namespace SonarApp;

class Errors extends Controller
{
	public function index( )
	{
		$this->code404( );
	}
    
    public function code404( )
	{
		$this->view( "errors/404" );
	}
}