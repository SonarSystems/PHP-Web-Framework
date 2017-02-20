<?php

Sonar\Misc::ChangeWebsiteTitle( "Reset Password" );

$user = new Sonar\User( );

if ( $user->IsLoggedIn( ) )
{
	Sonar\Redirect::To( "home/index" );
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
    if ( $user->Find( $username ) )
    {  
        if ( $user->VerifyResetCode( $username, $resetCode ) )
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

if ( Sonar\Input::Exists( "post" ) )
{
	if ( Sonar\Token::Check( Sonar\Input::Get( "token", $_POST ) ) )
	{
		$validate = new Sonar\Validate( );
		$validation = $validate->Check( $_POST, array(
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
		if ( $validation->Passed( ) )
		{
            // update password in database
            $result = $user->Update( array(
                "password" => password_hash( Sonar\Input::Get( "password", $_POST ), PASSWORD_DEFAULT ),
            ), $user->Data( )->id );
            
            if ( $result )
            {
                $user->ClearPasswordResetTable( $username );
                
			    Sonar\Session::Flash( "home", "Your password has been reset. You can now login." );
			    Sonar\Redirect::To( "home/index" );
            }
            else
            {
                echo "Problem occured during password reset, please try again.";
            }
		}
		else
		{
			foreach( $validation->Errors( ) as $error )
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

	<input type="hidden" name="token" value="<?php echo Sonar\Token::Generate( ); ?>" />
	<input type="submit" value="Submit" />
</form>
<?php
}