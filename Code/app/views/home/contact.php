<?php

$sent = false;

$name = Sonar\Input::get( "name", $_POST );
$emailAddress = Sonar\Input::get( "email_address", $_POST );
$message = Sonar\Input::get( "message", $_POST );

if ( Sonar\Input::exists( "post" ) )
{
    if ( Sonar\Token::check( Sonar\Input::get( "token", $_POST ) ) )
    {
        $validate = new Sonar\Validate( );
        $validation = $validate->check( $_POST, array(
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

        if ( $validation->passed( ) )
        {   
            try
            {        
                $email = new Sonar\Email( );
                
                $email = $email->send(
                    array(
                        array( $emailAddress, $name )
                    ),
                    array( Sonar\Config::get( "website/contactEmailAddress" ), Sonar\Config::get( "website/contactName" ) ),
                    array( Sonar\Config::get( "website/contactEmailAddress" ), Sonar\Config::get( "website/contactName" ) ),
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
    
    <input type="hidden" name="token" value="<?php echo Sonar\Token::generate( ); ?>" />
    <input type="submit" value="Submit" />
</form>



