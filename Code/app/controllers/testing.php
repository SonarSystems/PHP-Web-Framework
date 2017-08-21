<?php

namespace SonarApp;

class Testing extends Controller
{
	public function noelements( )
	{
		$this->view( "testing/noelements" );
	}
    
    public function misc( )
	{
		$this->view( "testing/misc" );
	}
}