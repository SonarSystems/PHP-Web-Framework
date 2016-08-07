<?php

Misc::changeWebsiteTitle( "Login" );

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
			"username" => array(
				"required" => true
			),
			"password" => array(
				"required" => true
			)
		), array(
            "Usernamed",
            "Password8"
        ) );

		if ( $validation->passed( ) )
		{
			// log user in
			$user = new User( );

			$remember = ( Input::get( "remember", $_POST ) === "on" ) ? true : false;
			$login = $user->login( Input::get( "username", $_POST ), Input::get( "password", $_POST ), $remember );

			if ( $login )
			{
				Redirect::to( "home/index" );
			}
			else
			{
                foreach( $user->errors( ) as $error )
                {
                    echo $error, "<br />";
                }
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
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo Input::get( "username", $_POST ); ?>" />
	</div>

	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" autocomplete="off" />
	</div>

	<div class="field">
		<label for="remember">
			<input type="checkbox" name="remember" id="remember" checked />Remember Me
		</label>
	</div>

	<input type="hidden" name="token" value="<?php echo Token::generate( ); ?>" />
	<input type="submit" value="Login" />
    
    <br />
    
    <a href="<?= Path::to( "home/forgotpassword" ); ?>">Forgot Password</a>
</form>




<ul>
    <li><a href="<?= Path::to( "home/index" ); ?>">index</a></li>
    <li><a href="<?= Path::to( "home/register" ); ?>">register</a></li>
</ul>

