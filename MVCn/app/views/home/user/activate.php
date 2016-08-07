<?php

$user = new User( );

$username = $data["username"];
$activationCode = $data["code"];

// check if username and activation code are present
if ( empty( $username ) || empty( $activationCode ) )
{
    echo "Activation code and username must be present to activate your account.";
}
else
{
    if ( $user->find( $username ) )
    {
        echo "Valid user";
        
        if ( $user->isActivated( $username ) )
        {
            echo "User already activated. Please login to continue.";
        }
        else
        {   
            if ( $user->verifyActivationCode( $username, $activationCode ) )
            {   
                if ( $user->activateUser( $username ) )
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

?>