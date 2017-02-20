<?php

Sonar\Misc::ChangeWebsiteTitle( "Contact Us" );

$sent = false;

$name = Sonar\Input::Get( "name", $_POST );
$emailAddress = Sonar\Input::Get( "email_address", $_POST );
$message = Sonar\Input::Get( "message", $_POST );

if ( Sonar\Input::Exists( "post" ) )
{
    if ( Sonar\Token::Check( Sonar\Input::Get( "token", $_POST ) ) )
    {
        $validate = new Sonar\Validate( );
        $validation = $validate->Check( $_POST, array(
            'name' => array(
                'required' => true
            ),
            'email_address' => array(
                'required' => true,
                'email' => true
            ),
            'message' => array(
                'required' => true
            ),
        ), array(
            "Name",
            "Email Address",
            "Message"
        ) );

        if ( $validation->Passed( ) )
        {   
            try
            {        
                $email = new Sonar\Email( );
                
                $email = $email->Send(
                    array(
                        array( $emailAddress, $name )
                    ),
                    array( Sonar\Config::Get( "website/contactEmailAddress" ), Sonar\Config::Get( "website/contactName" ) ),
                    array( Sonar\Config::Get( "website/contactEmailAddress" ), Sonar\Config::Get( "website/contactName" ) ),
                    "Contact Form Message",
                    $message
                );
                
                if ( $email )
                {
                    $sent = true;
                    echo "We have received your message, we will get back to you shortly.";
                }
                else
                {
                    echo "Error sending message, please try again later.";
                }
            }
            catch ( Exception $error )
            {
                die( $error->GetMessage( ) );
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
}

if ( $sent )
{
    $name = "";
    $emailAddress = "";
    $message = "";
}

?>

<form action="" method="POST" id="contactForm">
    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?= $name; ?>" />
    </div>
    
    <div class="field">
        <label for="email_address">Email Address</label>
        <input type="email" name="email_address" id="email_address" value="<?= $emailAddress; ?>"  />
    </div>
    
    <div class="field">
        <label for="message">Message</label>
        <br />
        <textarea name="message" id="message" form="contactForm"><?= $message; ?></textarea>
    </div>
    
    <input type="hidden" name="token" value="<?php echo Sonar\Token::Generate( ); ?>" />
    <input type="submit" value="Submit" />
</form>



