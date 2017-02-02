<?php

Sonar\Misc::ChangeWebsiteTitle( "Forgot Password" );

$user = new Sonar\User( );

if ( $user->IsLoggedIn( ) )
{
	Sonar\Redirect::To( "home/index" );
    
    exit( );
}

if ( Sonar\Input::Exists( "post" ) )
{
	if ( Sonar\Token::Check( Sonar\Input::Get( "token", $_POST ) ) )
	{
		$validate = new Sonar\Validate( );
		$validation = $validate->Check( $_POST, array(
			"email_address" => array(
				"required" => true,
                "email" => true,
                'exists' => Sonar\Config::Get( "mysql/usersTableName" )
			)
		), array(
            "Email Address"
        ) );

        // check if the email actually exists in the database
		if ( $validation->Passed( ) )
		{
            $emailAddress = Sonar\Input::Get( "email_address", $_POST );
            
            if ( $user->FindUsingEmail( $emailAddress ) )
            {
                $username = $user->Data( )->username;
                $salt = Sonar\Hash::Salt( 128 );
                
                if ( $user->CreatePasswordResetSalt( $username, $salt ) )
                {
                    $email = new Sonar\Email( );

                    $email = $email->Send(
                        array(
                            array( $emailAddress, $username )
                        ),
                        array( "name@email.com", "Sonar" ),
                        array( "name@email.com", "Sonar" ),
                        "Reset Password", // subject,
                        "_ForgotPasswordTemplate.php", // body/template
                        true,
                        array( // should only be a 1D array
                            "&&resetURL&&" => Sonar\Config::Get( "website/domainName" ).Sonar\Config::Get( "website/root" )."/home/resetpassword/".$salt."/".$username
                        )
                    );

                    if ( $email )
                    {
                        echo "Please check your emails for instructions to reset your password.";
                    }
                    else
                    {
                        echo "Error occured, please try again later.";
                    }
                }
                else
                {
                    echo "Error occured, please try again later.";
                }   
            }
            else
            {
                echo "Error occured, please try again later.";
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

?>

<form action="" method="POST">
	<div class="field">
		<label for="username">Email Address</label>
		<input type="text" name="email_address" id="email_address" />
	</div>

	<input type="hidden" name="token" value="<?php echo Sonar\Token::Generate( ); ?>" />
	<input type="submit" value="Submit" />
</form>