<?php

namespace Sonar;

class Controller
{
	public function model( $model )
	{
		require_once( "../app/models/" . $model . ".php" );

		$model = "Sonar\\".$model;
		
		return new $model( );
	}

	public function view( $view, $data = [] )
	{
		require_once( "../app/views/" . $view . ".php" );
	}
}