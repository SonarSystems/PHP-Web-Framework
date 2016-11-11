<?php

namespace Sonar;

class Controller
{
	public function model( $model )
	{
		require_once( "../app/models/" . $model . ".php" );

		$model = "Sonar\\MODEL_".$model;
		
		return new $model( );
	}

	public function view( $view, $data = [] )
	{
		require_once( "../app/views/" . $view . ".php" );
	}
}