<?php

namespace Sonar;

class CONTROLLER_Extra extends Controller
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