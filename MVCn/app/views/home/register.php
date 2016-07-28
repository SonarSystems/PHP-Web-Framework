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
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 32,
                'unique' => 'users',
                'numeric' => false
            ),
            'password' => array(
                'required' => true,
                'min' => 6,
                'max' => 32,
                'matches' => 'password_again'
            ),
            'password_again' => array(
                'required' => true
            ),
            'email_address' => array(
                'required' => true,
                'email' => true,
                'min' => 2,
                'max' => 32,
                'unique' => 'users'
            )
        ), array(
            "User",
            "Password",
            "Password Confirmation",
            "Email Address"
        ) );

        if ( $validation->passed( ) )
        {
            $user = new User( );
            
            try
            {
                $user->create( array(
                    "username" => Input::get( "username", $_POST ),
                    "password" => password_hash( Input::get( "password", $_POST ), PASSWORD_DEFAULT ),
                    "email_address" => Input::get( "email_address", $_POST ),
                    "salt" => Hash::salt( 128 ),
                    "joined" => time( )
                ) );
                
                Session::flash( "home", "You have been registered, please check your email for an activation email." );
                Redirect::to( "home/temp" );
            }
            catch ( Exception $error )
            {
                die( $error->getMessage( ) );
            }
        }
        else
        {
            foreach( $validation->errors( ) as $error )
            {
                echo $error."<br />";
            }
        }
    }
}

?>

<form action="" method="POST">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo Input::get( "username", $_POST ); ?>" autocomplete="off" />
    </div>
    
    <div class="field">
        <label for="password">Choose a password</label>
        <input type="password" name="password" id="password" />
    </div>
    
    <div class="field">
        <label for="password_again">Please confirm your password</label>
        <input type="password" name="password_again" id="password_again" />
    </div>
    
    <div class="field">
        <label for="email_address">Enter your Email Address MOFO</label>
        <input type="text" name="email_address" id="email_address" value="<?php echo Input::get( "email_address", $_POST ); ?>" />
    </div>
    
    <input type="hidden" name="token" value="<?php echo Token::generate( ); ?>" />
    <input type="submit" value="Register" />
</form>
