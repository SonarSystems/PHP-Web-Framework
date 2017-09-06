<?php

namespace SonarApp;

class Admin extends Controller
{
	public function index( )
	{
		$this->view( "admin/index" );
	}
    
    public function backup( )
    {
        $this->view( "admin/backup" );
    }
}