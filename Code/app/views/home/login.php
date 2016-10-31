<?php

Sonar\Misc::changeWebsiteTitle( "Login" );

$user = new Sonar\User( );

if ( $user->isLoggedIn( ) )
{
	Sonar\Redirect::to( "home/index" );
}

if ( Sonar\Input::exists( "post" ) )
{
	if ( Sonar\Token::check( Sonar\Input::get( "token", $_POST ) ) )
	{
        if ( Sonar\Input::get( "Login", $_POST ) )
        {
            if ( Sonar\Input::get( "remember", $_POST ) )
            {
                $remember = true;
            }
            else
            {
                $remember = false;
            }
            
            $validate = new Sonar\Validate( );
            $validation = $validate->check( $_POST, array(
                "username" => array(
                    "required" => true
                ),
                "password" => array(
                    "required" => true
                )
            ), array(
                "Username",
                "Password"
            ) );

            if ( $validation->passed( ) )
            {
                // log user in
                $user = new Sonar\User( );

                $login = $user->login( Sonar\Input::get( "username", $_POST ), Sonar\Input::get( "password", $_POST ), $remember );

                if ( $login )
                {
                    Sonar\Redirect::to( "home/index" );
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
        else
        {
            if ( Sonar\Input::get( "Google", $_POST ) )
            {
                $user->hybridAuth( )->authenticate( "Google" );
            }
            else if ( Sonar\Input::get( "Facebook", $_POST ) )
            {
                $user->hybridAuth( )->authenticate( "Facebook" );
            }
        }
	}
}

?>

<form action="" method="POST">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo Sonar\Input::get( "username", $_POST ); ?>" />
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

	<input type="hidden" name="token" value="<?php echo Sonar\Token::generate( ); ?>" />
	<input type="submit" name="Login" id="Login" value="Login" />
    <input type="submit" name="Google" id="Google" value="Google" />
    <input type="submit" name="Facebook" id="Facebook" value="Facebook" />
    
    <br />

    <a href="<?= Sonar\Path::to( "home/forgotpassword" ); ?>">Forgot Password</a>
</form>



<ul>
    <li><a href="<?= Sonar\Path::to( "home/index" ); ?>">index</a></li>
    <li><a href="<?= Sonar\Path::to( "home/register" ); ?>">register</a></li>
</ul>
