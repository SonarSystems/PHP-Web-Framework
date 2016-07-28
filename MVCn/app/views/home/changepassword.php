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
			"password_current" => array(
				"required" => true,
				"min" => 6
			),

			"password_new" => array(
				"required" => true,
				"min" => 6
			),

			"password_new_again" => array(
				"required" => true,
				"min" => 6,
				"matches" => "password_new"
			),
		) );

		if ( $validation->passed( ) )
		{
			// change password
			if ( !$user->verifyPassword( Input::get( "password_current", $_POST ) ) )
			{
				echo "Your current password is wrong";
			}
			else
			{
				$user->update( array(
					"password" => password_hash( Input::get( "password_new", $_POST ), PASSWORD_DEFAULT ),
				) );

				Session::flash( "home", "Your password has been changed!" );
				Redirect::to( "home/index" );
			}
		}
		else
		{
			foreach ( $validation->errors( ) as $error )
			{
				echo $error, "<br />";
			}
		}
	}
}

?>

<form action="" method="POST">
	<div class="field">
		<label for="password_current">Current password</label>
		<input type="password" name="password_current" id="password_current" />
	</div>

	<div class="field">
		<label for="password_new">New password</label>
		<input type="password" name="password_new" id="password_new" />
	</div>

	<div class="field">
		<label for="password_new_again">Confirm new password</label>
		<input type="password" name="password_new_again" id="password_new_again" />
	</div>

	<input type="submit" value="Change" />
	<input type="hidden" name="token" value="<?php echo Token::generate( ); ?>" />
</form>