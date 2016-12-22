<?php

Sonar\Misc::changeWebsiteTitle( "Register" );

$user = new Sonar\User( );
$recaptcha = new Sonar\ReCAPTCHA( );

if ( $user->isLoggedIn( ) )
{
	Sonar\Redirect::to( "home/index" );
}

if ( Sonar\Input::exists( "post" ) )
{
    if ( Sonar\Token::check( Sonar\Input::get( "token", $_POST ) ) )
    {       
        if ( Sonar\Input::get( "Register", $_POST ) )
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
                ),
                'email_address' => array(
                    'required' => true,
                    'email' => true,
                    'min' => 2,
                    'max' => 32,
                    'unique' => Sonar\Config::get( "users/usersTableName" )
                )
            ), array(
                "Username",
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
                        $username = Sonar\Input::get( "username", $_POST );
                        $emailAddress = Sonar\Input::get( "email_address", $_POST );
                        $salt = Sonar\Hash::salt( 128 );

                        $email = new Sonar\Email( );

                        $email = $email->send(
                            array(
                                array( $emailAddress, $username )
                            ),
                            array( "support@sonarsystems.co.uk", "Sonar Systems" ), // from
                            array( "support@sonarsystems.co.uk", "Sonar Systems" ), // reply to
                            "Activation Email", // subjects
                            "_ActivationTemplate.php", // body/template
                            true,
                            array( // should only be a 1D array
                                "&&activationURL&&" => Sonar\Config::get( "website/domainName" ).Sonar\Config::get( "website/root" )."/home/activate/".$salt."/".$username
                            )
                        );

                        if ( $email )
                        {
                            echo "Account created, please check your emails for an activation email.";
                            
                            $user->create( array(
                                "privilege" => 'user',
                                "username" => $username,
                                "password" => password_hash( Sonar\Input::get( "password", $_POST ), PASSWORD_DEFAULT ),
                                "email_address" => $emailAddress,
                                "salt" => $salt,
                                "joined" => time( )
                            ) );
                            
                            Sonar\Session::flash( "home", "You have been registered, please check your email for an activation email." );
                            Sonar\Redirect::To( "home" );
                        }
                        else
                        {
                            echo "Error creating account please try again later.";
                        }
                    }
                    catch ( Exception $error )
                    {
                        echo "Error has occured creating your account, please try again later.";
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
        <label for="password">Choose a password</label>
        <input type="password" name="password" id="password" />
    </div>
    
    <div class="field">
        <label for="password_again">Please confirm your password</label>
        <input type="password" name="password_again" id="password_again" />
    </div>
    
    <div class="field">
        <label for="email_address">Enter your Email Address MOFO</label>
        <input type="email" name="email_address" id="email_address" value="<?php echo Sonar\Input::get( "email_address", $_POST ); ?>" />
    </div>
    
    <input type="hidden" name="token" value="<?php echo Sonar\Token::generate( ); ?>" />
    <input type="submit" name="Register" id="Register" value="Register" />
    <input type="submit" name="Google" id="Google" value="Google" />
    <input type="submit" name="Facebook" id="Facebook" value="Facebook" />
    
    <div class="g-recaptcha" data-sitekey="<?= Sonar\Config::get( "security/GooglereCAPTCHA" )["sitekey"]; ?>"></div>
</form>
