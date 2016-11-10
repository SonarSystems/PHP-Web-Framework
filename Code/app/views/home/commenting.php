<?php

$comments = new Sonar\Comments( "comments", 3 );
$comments->SetMaxNestingLevel( 3 );
$user = new Sonar\User( );

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
                    $comment = Sonar\Input::get( "CommentTextArea", $_POST );
                    
                    if ( !$comments->InsertComment( $comment ) )
                    {
                        foreach( $comments->errors( ) as $error )
                        {
                            echo $error."<br />";
                        }
                    }
                }
                catch ( Exception $error )
                {
                    echo "Unable to post comment at this time, please try again later.";
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
        else if ( Sonar\Input::get( "replyComment", $_POST ) )
        {
            $validate = new Sonar\Validate( );
            $validation = $validate->check( $_POST, array(
                'replyTextArea' => array(
                    'required' => true,
                    'min' => 1,
                    'max' => 65535
                )
            ), array(
                "Response"
            ) );

            if ( $validation->passed( ) )
            {
                try
                {
                    $comment = Sonar\Input::get( "replyTextArea", $_POST );
                    $id = Sonar\Input::get( "id", $_POST );
                    
                    if ( !$comments->InsertComment( $comment, $id ) )
                    {
                        foreach( $comments->errors( ) as $error )
                        {
                            echo $error."<br />";
                        }
                    }
                }
                catch ( Exception $error )
                {
                    echo "Unable to post response at this time, please try again later.";
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

$data = $comments->GetCommentsForPostID( 3 );
$commentsCount = $comments->Count( );
$token = Sonar\Token::generate( );

if ( $user->IsLoggedIn( ) )
{

?>

<form action="" method="POST">
    <div class="field">
        <label for="CommentTextArea">Comment</label>
        <div>
            <textarea name="CommentTextArea" id="CommentTextArea"></textarea>
        </div>
    </div>
    
    <input type="hidden" name="token" value="<?= $token; ?>" />
    <input type="submit" name="PostComment" id="PostComment" value="Post Comment" />
</form>

<?php
}
else
{
    echo "Please login to comment.<br />";
}

// Front end code for beginning of a comment
function CommentingStart( $data, $user, $comments, $token )
{
    $user->Find( $data->userid );  
    $username = $user->Data( )->username;
    $description = nl2br( htmlspecialchars( base64_decode( $data->description ) ) );
    $timePosted = Sonar\Time::EpochToDateTime( $data->timeposted );
    $button = "";
    $edited = "";
    
    if ( $data->currentnestedlevel < $comments->GetMaxNestingLevel( ) )
    {
        if ( $user->IsLoggedIn( ) )
        {
            $postID = $data->id;
            
            $button = "
            <form action='' method='POST'>
                <div class='field'>
                    <label for='replyTextArea'>Comment</label>
                    <div>
                        <textarea name='replyTextArea' class='replyTextArea'></textarea>
                    </div>
                </div>

                <input type='hidden' name='id' value='$postID' />
                <input type='hidden' name='token' value='$token' />
                <input type='submit' name='replyComment' class='replyComment' value='Reply' />
            </form>
            ";
        }
    }
    
    if ( $data->timeedited > 0 )
    {
        $edited = "Edited: " . Sonar\Time::EpochToDateTime( $data->timeedited );
    }
    
    echo "
    
    <div class='alert alert-success' role='alert'>
        <strong>$username</strong> $timePosted
        
        <div>
            $description
        </div>
        
        $button $edited
    ";
}

// Front end code for ending of a comment
function CommentingEnd( $data, $user, $comments )
{
    echo "</div>";
}

function ProcessPosts( $data, $user, $comments, $token )
{
    CommentingStart( $data, $user, $comments, $token );
    
    if ( $data->currentnestedlevel < $comments->GetMaxNestingLevel( ) )
    {
        $data = $comments->GetCommentsForParentID( $data->id );

        if ( $comments->Count( ) )
        {
            foreach ( $data as $row )
            {
                ProcessPosts( $row, $user, $comments, $token );
            }
        }
    }
    
    CommentingEnd( $data, $user, $comments );
}

if ( $commentsCount )
{
    foreach ( $data as $row )
    {
        if ( $row->currentnestedlevel == 1 )
        {
            ProcessPosts( $row, $user, $comments, $token );
        }
    }
}
else
{
    echo "No comments.";
}