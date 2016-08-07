<?php

require_once( "DB.php" );
require_once( "Error.php" );

require_once( "../libs/PHPMailer/PHPMailerAutoload.php" );

class Email extends __Error
{   
    public function __construct( )
    {
        
    }
    
    public function send( $to = array( ), $from = array( ), $replyTo = array( ), $subject, $body )
    {
        $mail = new PHPMailer;
        
        // Set PHPMailer to use the sendmail transport
        $mail->isSendmail( );

        // check if the name is present in the from email
        if ( !empty( $from[1] ) )
        {
            $mail->setFrom( $from[0], $from[1] );
        }
        else
        {
            $mail->setFrom( $from[0] );
        }
        
        // check if the name is present in the reply to email
        if ( !empty( $replyTo[1] ) )
        {
            $mail->addReplyTo( $replyTo[0], $replyTo[1] );
        }
        else
        {
            $mail->addReplyTo( $replyTo[0] );
        }
        
        foreach( $to as $email )
        {
            if ( !empty( $email[1] ) )
            {
                $mail->addAddress( $email[0], $email[1] );
            }
            else
            {
                $mail->addAddress( $email[0] );
            }
        }
        
        $mail->Subject = $subject;
        $mail->msgHTML( $body );
        
        if ( !$mail->send( ) )
        {
            return false;
        }
        else
        {
            return true;
        }
        
    }
}

?>