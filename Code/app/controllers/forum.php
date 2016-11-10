<?php

namespace Sonar;

class CONTROLLER_Forum extends Controller
{
	public function index( )
	{
		$this->view( "forum/home" );
	}
    
    public function home( )
    {
        $this->index( );
    }
    
    public function sections( )
    {
        $this->index( );
    }
    
    public function section( )
    {
        $this->index( );
    }
    
    public function category( )
	{
		$this->view( "forum/category" );
	}
    
    public function topic( )
    {
        $this->category( );
    }
    
    public function question( )
	{
		$this->view( "forum/question" );
	}
    
    public function post( )
    {
        $this->question( );
    }
}