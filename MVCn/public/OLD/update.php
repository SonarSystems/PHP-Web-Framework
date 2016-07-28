<?php require_once( "../elements/HEADER.php" ); ?>

<?php

$user = new User( );

if ( !$user->isLoggedIn( ) )
{
	Redirect::to( "index.php" );
}

if ( Input::exists( ) )
{
	if ( Token::check( Input::get( "token" ) ) )
	{
		$validate = new Validate( );
		$validation = $validate->check( $_POST, array(
			"username" => array(
				"required" => true,
				"min" => 2,
				"max" => 32
			)
		) );

		if ( $validation->passed( ) )
		{
			// UPDATE DETAILS
			try
			{
				$user->update( array(
					"username" => Input::get( "username" )
				) );

				Session::flash( "home", "Your details have been updated" );

				Redirect::to( "index.php" );
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

<?php require_once( "../elements/FOOTER.php" ); ?>