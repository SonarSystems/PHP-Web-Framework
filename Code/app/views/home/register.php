<?php

Sonar\Misc::ChangeWebsiteTitle( "Register" );

$user = new Sonar\User( );
$recaptcha = new Sonar\ReCAPTCHA( );

if ( $user->IsLoggedIn( ) )
{
	Sonar\Redirect::To( "home/index" );
}

if ( Sonar\Input::Exists( "post" ) )
{
    if ( Sonar\Token::Check( Sonar\Input::Get( "token", $_POST ) ) )
    {       
        if ( Sonar\Input::Get( "Register", $_POST ) )
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
                ),
                'email_address' => array(
                    'required' => true,
                    'email' => true,
                    'min' => 2,
                    'max' => 767,
                    'unique' => Sonar\Config::Get( "users/usersTableName" )
                )
            ), array(
                "Username",
                "Password",
                "Password Confirmation",
                "Email Address"
            ) );

            if ( $validation->Passed( ) )
            {
                if ( $recaptcha->Check( ) && $recaptcha->Passed( ) )
                {
                    try
                    {
                        $username = Sonar\Input::Get( "username", $_POST );
                        $emailAddress = Sonar\Input::Get( "email_address", $_POST );
                        $salt = Sonar\Hash::Salt( 128 );

                        $email = new Sonar\Email( );

                        $email = $email->Send(
                            array(
                                array( $emailAddress, $username )
                            ),
                            array( "support@sonarsystems.co.uk", "Sonar Systems" ), // from
                            array( "support@sonarsystems.co.uk", "Sonar Systems" ), // reply to
                            "Activation Email", // subjects
                            "_ActivationTemplate.php", // body/template
                            true,
                            array( // should only be a 1D array
                                "&&activationURL&&" => Sonar\Config::Get( "website/domainName" ).Sonar\Config::Get( "website/root" )."/home/activate/".$salt."/".$username
                            )
                        );

                        if ( $email )
                        {
                            echo "Account created, please check your emails for an activation email.";
                            
                            $user->Create( array(
                                "privilege" => 'user',
                                "username" => $username,
                                "password" => password_hash( Sonar\Input::Get( "password", $_POST ), PASSWORD_DEFAULT ),
                                "email_address" => $emailAddress,
                                "salt" => $salt,
                                "joined" => time( )
                            ) );
                            
                            Sonar\Session::Flash( "home", "You have been registered, please check your email for an activation email." );
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
                    foreach( $recaptcha->Errors( ) as $error )
                    {
                        echo $error."<br />";
                    }
                }
            }
            else
            {
                foreach( $validation->Errors( ) as $error )
                {
                    echo $error."<br />";
                }
            }
        }
        else
        {
            if ( Sonar\Input::Get( "Google", $_POST ) )
            {
                $user->HybridAuth( )->Authenticate( "Google" );
            }
            else if ( Sonar\Input::get( "Facebook", $_POST ) )
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
        <label for="password">Choose a password</label>
        <input type="password" name="password" id="password" />
    </div>
    
    <div class="field">
        <label for="password_again">Please confirm your password</label>
        <input type="password" name="password_again" id="password_again" />
    </div>
    
    <div class="field">
        <label for="email_address">Enter your Email Address MOFO</label>
        <input type="email" name="email_address" id="email_address" value="<?php echo Sonar\Input::Get( "email_address", $_POST ); ?>" />
    </div>
    
    <input type="hidden" name="token" value="<?php echo Sonar\Token::Generate( ); ?>" />
    <input type="submit" name="Register" id="Register" value="Register" />
    <input type="submit" name="Google" id="Google" value="Google" />
    <input type="submit" name="Facebook" id="Facebook" value="Facebook" />
    
    <div class="g-recaptcha" data-sitekey="<?= Sonar\Config::Get( "security/GooglereCAPTCHA" )["sitekey"]; ?>"></div>
</form>
