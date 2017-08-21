<?php

namespace SonarApp;

class Blog extends Controller
{
	public function index( )
	{
		$this->view( "blog/home" );
	}
    
    public function home( )
    {
        $this->index( );
    }
    
    public function admin( )
	{
		$this->view( "blog/admin" );
	}
}