<?php

Sonar\Misc::ChangeWebsiteTitle( "Finish Signup Process" );

$user = new Sonar\User( );

// if the user has already setup their account fully, redirect to homepage
if ( !$user->IsOnlySociallyLoggedIn( ) )
{
	Sonar\Redirect::To( "home/index" );
}

// check if a form has been submitted
if ( Sonar\Input::Exists( "post" ) )
{
	if ( Sonar\Token::Check( Sonar\Input::Get( "token", $_POST ) ) )
	{
		$validate = new Sonar\Validate( );
        $validation = $validate->Check( $_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 32,
                'unique' => Sonar\Config::Get( "users/usersTableName" ),
                'numeric' => false,
                'email' => false
            ),
            'password' => array(
                'required' => true,
                'min' => 6,
                'max' => 32,
                'matches' => 'password_again'
            ),
            'password_again' => array(
                'required' => true
            )
        ), array(
            "User",
            "Password",
            "Password Confirmation",
        ) );

        if ( $validation->Passed( ) )
		{
			// UPDATE DETAILS
			try
			{
				$user->Update( array(
					"username" => Sonar\Input::Get( "username", $_POST ),
                    "password" => password_hash( Sonar\Input::Get( "password", $_POST ), PASSWORD_DEFAULT )
				), $user->Data( )->id );

				Sonar\Session::Flash( "home", "You have now completed the signup process." );

                Sonar\Redirect::To( "home/index" );                
			}
			catch( Exception $error )
			{
				die( $error->GetMessage( ) );
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

<h1>It appears you used social login. Just one more step to complete your signup process.</h1>

<form action="" method="POST">
	<div class="field">
        <div class="field">
            <label for="name">Username</label>
            <input type="text" name="username" id="username" value="<?php echo Sonar\Input::Get( "username", $_POST ); ?>" />
        </div>
        
        <div class="field">
            <label for="password">Choose a password</label>
            <input type="password" name="password" id="password" />
        </div>

        <div class="field">
            <label for="password_again">Please confirm your password</label>
            <input type="password" name="password_again" id="password_again" />
        </div>

		<input type="submit" value="Update" />
		<input type="hidden" name="token" value="<?php echo Sonar\Token::Generate( ); ?>" />
	</div>
</form>