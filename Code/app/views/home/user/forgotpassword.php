<?php

$user = new Sonar\User( );

if ( $user->isLoggedIn( ) )
{
	Sonar\Redirect::to( "home/index" );
}

if ( Sonar\Input::exists( "post" ) )
{
	if ( Sonar\Token::check( Sonar\Input::get( "token", $_POST ) ) )
	{
		$validate = new Sonar\Validate( );
		$validation = $validate->check( $_POST, array(
			"email_address" => array(
				"required" => true,
                "email" => true,
                'exists' => Sonar\Config::get( "mysql/usersTableName" )
			)
		), array(
            "Email Address"
        ) );

        // check if the email actually exists in the database
		if ( $validation->passed( ) )
		{
            $emailAddress = Sonar\Input::get( "email_address", $_POST );
            
            if ( $user->findUsingEmail( $emailAddress ) )
            {
                $username = $user->data( )->username;
                $salt = Sonar\Hash::salt( 128 );
                
                if ( $user->createPasswordResetSalt( $username, $salt ) )
                {
                    $email = new Sonar\Email( );

                    $email = $email->send(
                        array(
                            array( $emailAddress, $username )
                        ),
                        array( "name@email.com", "Sonar" ),
                        array( "name@email.com", "Sonar" ),
                        "Reset Password", // subject,
                        "_ForgotPasswordTemplate.php", // body/template
                        true,
                        array( // should only be a 1D array
                            "&&resetURL&&" => Sonar\Config::get( "website/domainName" ).Sonar\Config::get( "website/root" )."/home/resetpassword/".$salt."/".$username
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
		<label for="username">Email Address</label>
		<input type="text" name="email_address" id="email_address" />
	</div>

	<input type="hidden" name="token" value="<?php echo Sonar\Token::generate( ); ?>" />
	<input type="submit" value="Submit" />
</form>