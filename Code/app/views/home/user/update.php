<?php

$user = new Sonar\User( );

if ( !$user->isLoggedIn( ) )
{
	Sonar\Redirect::to( "home/index" );
}

if ( Sonar\Input::exists( "post" ) )
{
	if ( Sonar\Token::check( Sonar\Input::get( "token", $_POST ) ) )
	{
		$validate = new Sonar\Validate( );
		$validation = $validate->check( $_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 32,
                'unique' => Sonar\Config::get( "mysql/usersTableName" ),
                'numeric' => false,
                'email' => false
            ),
		) );

		if ( $validation->passed( ) )
		{
			// UPDATE DETAILS
			try
			{
				$user->update( array(
					"username" => Sonar\Input::get( "username", $_POST )
				) );

				Sonar\Session::flash( "home", "Your details have been updated" );

				Sonar\Redirect::to( "home/index" );
			}
			catch( Exception $error )
			{
				die( $error->getMessage( ) );
			}
		}
		else
		{
			foreach( $validation->errors( ) as $error )
			{
				echo $error, "<br />";
			}
		}
	}
}

?>

<form action="" method="POST">
	<div class="field">
		<label for="name">Username</label>
		<input type="text" name="username" id="username" value="<?php echo $user->data( )->username; ?>" />

		<input type="submit" value="Update" />
		<input type="hidden" name="token" value="<?php echo Sonar\Token::generate( ); ?>" />
	</div>
</form>