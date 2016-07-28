<?php

class Home extends Controller
{
	public function index( $name = "" )
	{
		//$user = $this->model( "User" );
		//$user->name = $name;
		
		$this->view( "home/index"/*, ["name" => $user->name]*/ );
	}
    
    public function changepassword( )
	{	
		$this->view( "home/changepassword" );
	}
    
    public function login( )
	{	
		$this->view( "home/login" );
	}
    
    public function logout( )
	{	
		$this->view( "home/logout" );
	}
    
    public function register( )
	{	
		$this->view( "home/register" );
	}
    
    public function update( )
	{	
		$this->view( "home/update" );
	}
    
    public function temp( )
	{	
		$this->view( "home/temp" );
	}
    
    public function test( )
	{	
		$this->view( "home/test" );
	}
}

?>