<?php

Sonar\Misc::ChangeWebsiteTitle( "Account Activation" );

$user = new Sonar\User( );

$username = $data["username"];
$activationCode = $data["code"];

// check if username and activation code are present
if ( empty( $username ) || empty( $activationCode ) )
{
    echo "Activation code and username must be present to activate your account.";
}
else
{
    // check if user exists
    if ( $user->Find( $username ) )
    {
        echo "Valid user";
        
        // check if user is already activated
        if ( $user->IsActivated( $username ) )
        {
            echo "User already activated. Please login to continue.";
        }
        else
        {   
            // check if activation code matches code in database for user
            if ( $user->VerifyActivationCode( $username, $activationCode ) )
            {   
                // try to activate account
                if ( $user->ActivateUser( $username ) )
                {
                    echo "Account activated, you can now login to your account.";
                }
                else
                {
                    echo "Activation failed, please try again later.";
                }
            }
            else
            {
                echo "Invalid activation code.";
            }
        }
    }
    else
    {
        echo "User does not exist.";
    }
}
