<?php

$user = new User( );

if ( $user->isLoggedIn( ) )
{
	Redirect::to( "home/index" );
}

if ( Input::exists( "post" ) )
{
	if ( Token::check( Input::get( "token", $_POST ) ) )
	{
		$validate = new Validate( );
		$validation = $validate->check( $_POST, array(
			"email_address" => array(
				"required" => true,
                "email" => true,
                'exists' => Config::get( "mysql/usersTableName" )
			)
		), array(
            "Email Address"
        ) );

        // check if the email actually exists in the database
		if ( $validation->passed( ) )
		{
            $emailAddress = Input::get( "email_address", $_POST );
            
            if ( $user->findUsingEmail( $emailAddress ) )
            {
                $username = $user->data( )->username;
                $salt = Hash::salt( 128 );
                
                if ( $user->createPasswordResetSalt( $username, $salt ) )
                {
                    $email = new Email( );

                    $email = $email->send(
                        array(
                            array( $emailAddress, $username )
                        ),
                        array( "f.hussain@gymshark.com", "Gymshark" ),
                        array( "f.hussain@gymshark.com", "Gymshark" ),
                        "Reset Password",
                        Config::get( "website/domainName" ).Config::get( "website/root" )."/home/resetpassword/".$salt."/".$username
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

	<input type="hidden" name="token" value="<?php echo Token::generate( ); ?>" />
	<input type="submit" value="Submit" />
</form>