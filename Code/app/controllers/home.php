<?php

namespace Sonar;

class CONTROLLER_Home extends Controller
{
	public function index( )
	{
		$this->view( "home/index" );
	}
    
    public function changepassword( )
	{
		$this->view( "home/user/changepassword" );
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
		$this->view( "home/user/update" );
	}
    
    public function temp( )
	{	
		$this->view( "home/temp" );
	}
    
    public function test( )
	{	
		$this->view( "home/test" );
	}
    
    public function activate( $code = "", $username = "" )
	{	
        $model = $this->model( "Activate" );
		$model->activationCode = $code;
		$model->username = $username;
                		
		$this->view( "home/user/activate", ["code" => $model->activationCode, "username" => $model->username] );        
	}
    
    public function forgotpassword( )
	{	
		$this->view( "home/user/forgotpassword" );
	}
    
    public function contact( )
	{	
		$this->view( "home/contact" );
	}
    
    public function resetpassword( $code = "", $username = "" )
    {
        $model = $this->model( "ResetPassword" );
		$model->resetCode = $code;
		$model->username = $username;
                		
		$this->view( "home/user/resetpassword", ["code" => $model->resetCode, "username" => $model->username] );
    }
    
    public function adduserdetails( )
	{	
		$this->view( "home/adduserdetails" );
	}
    
    public function commenting( )
    {
        $this->view( "home/commenting" );
    }
}