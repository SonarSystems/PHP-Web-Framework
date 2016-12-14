<?php

namespace SonarApp;

class Extra extends Controller
{
	public function index( )
	{
		$this->policy( );
	}
    
    public function policy( )
	{
		$this->view( "extra/policy" );
	}
    
    public function changelog( )
	{
		$this->view( "extra/changelog" );
	}
}