<?php

Sonar\Misc::ChangeWebsiteTitle( "Login" );

$user = new Sonar\User( );

if ( $user->IsLoggedIn( ) )
{
	Sonar\Redirect::To( "home/index" );
}

if ( Sonar\Input::Exists( "post" ) )
{
	if ( Sonar\Token::Check( Sonar\Input::get( "token", $_POST ) ) )
	{
        if ( Sonar\Input::Get( "Login", $_POST ) )
        {
            if ( Sonar\Input::Get( "remember", $_POST ) )
            {
                $remember = true;
            }
            else
            {
                $remember = false;
            }
            
            $validate = new Sonar\Validate( );
            $validation = $validate->Check( $_POST, array(
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

            if ( $validation->Passed( ) )
            {
                // log user in
                $user = new Sonar\User( );

                $login = $user->Login( Sonar\Input::Get( "username", $_POST ), Sonar\Input::Get( "password", $_POST ), $remember );

                if ( $login )
                {
                    Sonar\Redirect::To( "home/index" );
                }
                else
                {
                    foreach( $user->Errors( ) as $error )
                    {
                        echo $error, "<br />";
                    }
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
        else
        {
            if ( Sonar\Input::Get( "Google", $_POST ) )
            {
                $user->HybridAuth( )->Authenticate( "Google" );
            }
            else if ( Sonar\Input::Get( "Facebook", $_POST ) )
            {
                $user->HybridAuth( )->Authenticate( "Facebook" );
            }
        }
	}
}

?>

<form action="" method="POST">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo Sonar\Input::Get( "username", $_POST ); ?>" />
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

	<input type="hidden" name="token" value="<?php echo Sonar\Token::Generate( ); ?>" />
	<input type="submit" name="Login" id="Login" value="Login" />
    <input type="submit" name="Google" id="Google" value="Google" />
    <input type="submit" name="Facebook" id="Facebook" value="Facebook" />
    
    <br />

    <a href="<?= Sonar\Path::To( "home/forgotpassword" ); ?>">Forgot Password</a>
</form>

<ul>
    <li><a href="<?= Sonar\Path::To( "home/index" ); ?>">index</a></li>
    <li><a href="<?= Sonar\Path::To( "home/register" ); ?>">register</a></li>
</ul>