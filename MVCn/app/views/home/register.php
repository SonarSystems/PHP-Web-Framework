<?php

$user = new User( );
$recaptcha = new ReCAPTCHA( );

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
            ),
            'email_address' => array(
                'required' => true,
                'email' => true,
                'min' => 2,
                'max' => 32,
                'unique' => Config::get( "mysql/usersTableName" )
            )
        ), array(
            "User",
            "Password",
            "Password Confirmation",
            "Email Address"
        ) );

        if ( $validation->passed( ) )
        {
            if ( $recaptcha->check( ) && $recaptcha->passed( ) )
            {
                try
                {
                    $username = Input::get( "username", $_POST );
                    $emailAddress = Input::get( "email_address", $_POST );
                    $salt = Hash::salt( 128 );

                    $user->create( array(
                        "username" => $username,
                        "password" => password_hash( Input::get( "password", $_POST ), PASSWORD_DEFAULT ),
                        "email_address" => $emailAddress,
                        "salt" => $salt,
                        "joined" => time( )
                    ) );

                    $email = new Email( );

                    $email = $email->send(
                        array(
                            array( $emailAddress, $username )
                        ),
                        array( "f.hussain@gymshark.com", "Gymshark" ),
                        array( "f.hussain@gymshark.com", "Gymshark" ),
                        "Activation Email",
                        Config::get( "website/domainName" ).Config::get( "website/root" )."/home/activate/".$salt."/".$username
                    );

                    if ( $email )
                    {
                        echo "Account created, please check your emails for an activation email.";
                    }
                    else
                    {
                        echo "Error creating account please try again later.";
                    }

                    //Session::flash( "home", "You have been registered, please check your email for an activation email." );
                    //Redirect::to( "home/temp" );
                }
                catch ( Exception $error )
                {
                    die( $error->getMessage( ) );
                }
            }
            else
            {
                foreach( $recaptcha->errors( ) as $error )
                {
                    echo $error."<br />";
                }
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
        <input type="text" name="username" id="username" value="<?php echo Input::get( "username", $_POST ); ?>" />
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
        <input type="email" name="email_address" id="email_address" value="<?php echo Input::get( "email_address", $_POST ); ?>" />
    </div>
    
    <input type="hidden" name="token" value="<?php echo Token::generate( ); ?>" />
    <input type="submit" value="Register" />
    
    <div class="g-recaptcha" data-sitekey="<?= Config::get( "security/GooglereCAPTCHA" )["sitekey"]; ?>"></div>
</form>
