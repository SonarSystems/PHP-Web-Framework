<?php

namespace SonarApp;

class Forum extends Controller
{
	public function index( )
	{
		$this->view( "forum/home" );
	}
    
    public function home( )
    {
        $this->index( );
    }
    
    public function categories( $id = "" )
	{
        $model = $this->model( "ForumCategories" );
		$model->id = $id;
                		
		$this->view( "forum/categories", ["id" => $model->id] );        
	}
    
    public function category( $id = "" )
	{
        $model = $this->model( "ForumCategory" );
		$model->id = $id;
                		
		$this->view( "forum/category", ["id" => $model->id] );        
	}
    
    public function question( $id = "" )
	{
        $model = $this->model( "ForumQuestion" );
		$model->id = $id;
        
		$this->view( "forum/question", ["id" => $model->id] );
	}
    
    public function favourites( )
    {
        $this->view( "forum/favourites" );
    }
}