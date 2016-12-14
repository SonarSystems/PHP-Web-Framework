<?php

Sonar\Misc::changeWebsiteTitle( "Finish Signup Process" );

$user = new Sonar\User( );

if ( !$user->isOnlySociallyLoggedIn( ) )
{
	Sonar\Redirect::to( "home/index" );
}

if ( Sonar\Input::exists( "post" ) )
{
	if ( Sonar\Token::check( Sonar\Input::get( "token", $_POST ) ) )
	{
		$validate = new Sonar\Validate( );
        $validation = $validate->check( $_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 32,
                'unique' => Sonar\Config::get( "users/usersTableName" ),
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

        if ( $validation->passed( ) )
		{
			// UPDATE DETAILS
			try
			{
				$user->update( array(
					"username" => Sonar\Input::get( "username", $_POST ),
                    "password" => password_hash( Sonar\Input::get( "password", $_POST ), PASSWORD_DEFAULT )
				), $user->data( )->id );

				Sonar\Session::flash( "home", "You have now completed the signup process." );

                Sonar\Redirect::to( "home/index" );                
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

<h1>It appears you used social login. Just one more step to complete your signup process.</h1>

<form action="" method="POST">
	<div class="field">
        <div class="field">
            <label for="name">Username</label>
            <input type="text" name="username" id="username" value="<?php echo Sonar\Input::get( "username", $_POST ); ?>" />
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
		<input type="hidden" name="token" value="<?php echo Sonar\Token::generate( ); ?>" />
	</div>
</form>