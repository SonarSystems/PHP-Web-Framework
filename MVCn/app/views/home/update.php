<?php

$user = new User( );

if ( !$user->isLoggedIn( ) )
{
	Redirect::to( "home/index" );
}

if ( Input::exists( "post" ) )
{
	if ( Token::check( Input::get( "token", $_POST ) ) )
	{
		$validate = new Validate( );
		$validation = $validate->check( $_POST, array(
			"username" => array(
				"required" => true,
				"min" => 2,
				"max" => 32,
                "numeric" => false
			)
		) );

		if ( $validation->passed( ) )
		{
			// UPDATE DETAILS
			try
			{
				$user->update( array(
					"username" => Input::get( "username", $_POST )
				) );

				Session::flash( "home", "Your details have been updated" );

				Redirect::to( "home/index" );
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
		<input type="hidden" name="token" value="<?php echo Token::generate( ); ?>" />
	</div>
</form>