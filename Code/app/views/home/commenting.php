<?php

$comments = new Sonar\Commenting( "comments", 3 );
$comments->SetMaxNestingLevel( 3 );
$user = new Sonar\User( );

$data = $comments->GetCommentsForPostID( 3 );

echo $comments->InsertComment( "weewew" );

echo "<br />";

if ( Sonar\Input::exists( "post" ) )
{
    if ( Sonar\Token::check( Sonar\Input::get( "token", $_POST ) ) )
    {       
        if ( Sonar\Input::get( "PostComment", $_POST ) )
        {
            $validate = new Sonar\Validate( );
            $validation = $validate->check( $_POST, array(
                'CommentTextArea' => array(
                    'required' => true,
                    'min' => 1,
                    'max' => 65535
                )
            ), array(
                "Comment"
            ) );

            if ( $validation->passed( ) )
            {
                try
                {
                    $username = Sonar\Input::get( "CommentTextArea", $_POST );

                    if ( $email )
                    {
                        echo "Account created, please check your emails for an activation email.";

                        $user->create( array(
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
                foreach( $validation->errors( ) as $error )
                {
                    echo $error."<br />";
                }
            }
        }
    }
}


?>

<form action="" method="POST">
    <div class="field">
        <label for="CommentTextArea">Comment</label>
        <div>
            <textarea name="CommentTextArea" id="CommentTextArea"></textarea>
        </div>
    </div>
    
    <input type="hidden" name="token" value="<?php echo Sonar\Token::generate( ); ?>" />
    <input type="submit" name="PostComment" id="PostComment" value="Post Comment" />
</form>
<?php

// Front end code for beginning of a comment
function CommentingStart( $data, $user, $comments )
{
    $user->Find( $data->userid );  
    $username = $user->Data( )->username;;
    $description = $data->description;
    $timePosted = Sonar\Time::EpochToDateTime( $data->timeposted );
    $button = "";
    
    if ( $data->currentnestedlevel < $comments->GetMaxNestingLevel( ) )
    {
        $button = "<input type='button' value='Reply' />";
    }
    
    echo "
    
    <div class='alert alert-success' role='alert'>
        <strong>$username</strong> $timePosted
        
        <div>
            $description
        </div>
        
        $button
    ";
}

// Front end code for ending of a comment
function CommentingEnd( $data, $user, $comments )
{
    echo "</div>";
}

function ProcessPosts( $data, $user, $comments )
{
    CommentingStart( $data, $user, $comments );
    
    if ( $data->currentnestedlevel < $comments->GetMaxNestingLevel( ) )
    {
        $data = $comments->GetCommentsForParentID( $data->id );

        if ( $comments->Count( ) )
        {
            foreach ( $data as $row )
            {
                ProcessPosts( $row, $user, $comments );
            }
        }
    }
    
    CommentingEnd( $data, $user, $comments );
}

foreach ( $data as $row )
{
    if ( $row->currentnestedlevel == 1 )
    {
        ProcessPosts( $row, $user, $comments );
    }
}