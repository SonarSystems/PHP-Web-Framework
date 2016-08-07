<?php

class Extra extends Controller
{
	public function index( )
	{
		Extra::policy( );
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

?>