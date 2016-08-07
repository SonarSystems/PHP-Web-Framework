<?php

$user = new User( );

if ( $user->isLoggedIn( ) )
{
	Redirect::to( "home/index" );
}

$username = $data["username"];
$resetCode = $data["code"];

$resetCodeValid = false;

// check if username and activation code are present
if ( empty( $username ) || empty( $resetCode ) )
{
    echo "Reset code and username must be present to activate your account.";
}
else
{
    if ( $user->find( $username ) )
    {  
        if ( $user->verifyResetCode( $username, $resetCode ) )
        {
            $resetCodeValid = true;
        }
        else
        {
            echo "Invalid reset code.";
        }
    }
    else
    {
        echo "User does not exist.";
    }
}

if ( Input::exists( "post" ) )
{
	if ( Token::check( Input::get( "token", $_POST ) ) )
	{
		$validate = new Validate( );
		$validation = $validate->check( $_POST, array(
			"password" => array(
				"required" => true,
                "min" => 6,
                "max" => 32
			),
            
            "password_confirmation" => array(
                "required" => true,
                'matches' => 'password'
            )
		), array(
            "Password",
            "Confirmation password"
        ) );

        // check if the password reset submission actually exists in the database
		if ( $validation->passed( ) )
		{
            // update password in database
            $result = $user->update( array(
                "password" => password_hash( Input::get( "password", $_POST ), PASSWORD_DEFAULT ),
            ), $user->data( )->id );
            
            if ( $result )
            {
                $user->clearPasswordResetTable( $username );
                
			    Session::flash( "home", "Your password has been reset. You can now login." );
			    Redirect::to( "home/index" );
            }
            else
            {
                echo "Problem occured during password reset, please try again.";
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

if ( $resetCodeValid )
{
?>
<form action="" method="POST">
	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" />
	</div>
    
    <div class="field">
		<label for="password_confirmation">Password Confirmation</label>
		<input type="password" name="password_confirmation" id="password_confirmation" />
	</div>

	<input type="hidden" name="token" value="<?php echo Token::generate( ); ?>" />
	<input type="submit" value="Submit" />
</form>
<?php
}
?>