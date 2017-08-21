<?php

namespace SonarApp;

class Admin extends Controller
{
	public function index( )
	{
		$this->view( "admin/backup" );
	}
    
    public function backup( )
    {
        $this->index( );
    }
}