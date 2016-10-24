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
		$validation = $validate->check( $_POST,
            array(
                "password_current" => array(
                    "required" => true
                ),

                "password_new" => array(
                    "required" => true,
                    "min" => 6,
                    "max" => 32
                ),

                "password_new_again" => array(
                    "required" => true,
                    "matches" => "password_new"
                )
            ),
            array(
                "Current Password",
                "New Password",
                "Password Confirmation"
            )
        );

		if ( $validation->passed( ) )
		{
			// change password
			if ( !$user->verifyPassword( Sonar\Input::get( "password_current", $_POST ) ) )
			{
				echo "Your current password is wrong";
			}
			else
			{
				$result = $user->update( array(
					"password" => password_hash( Sonar\Input::get( "password_new", $_POST ), PASSWORD_DEFAULT ),
				) );
                
                if ( $result )
                {
				    Sonar\Session::flash( "home", "Your password has been changed!" );
				    Sonar\Redirect::to( "home/index" );
                }
                else
                {
                    echo "Problem occured during password update, please try again.";
                }
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
	<input type="hidden" name="token" value="<?php echo Sonar\Token::generate( ); ?>" />
</form>