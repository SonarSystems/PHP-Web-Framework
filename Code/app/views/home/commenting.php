<?php

$comments = new Sonar\Comments( "comments", "commentlikes", 3 );
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
                $comment = Sonar\Input::get( "CommentTextArea", $_POST );

                if ( !$comments->InsertComment( $comment ) )
                {
                    foreach( $comments->errors( ) as $error )
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
            else
            {
                foreach( $validation->errors( ) as $error )
                {
                    echo $error."<br />";
                }
            }
        }
        else if ( Sonar\Input::get( "likeComment", $_POST ) )
        {
            $id = Sonar\Input::get( "id", $_POST );
            
            $comments->LikeComment( $id );
        }
        else if ( Sonar\Input::get( "dislikeComment", $_POST ) )
        {
            $id = Sonar\Input::get( "id", $_POST );
            
            $comments->DislikeComment( $id );
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
    $postID = $data->id;
    
    if ( $user->IsLoggedIn( ) )
    { 
        $likedButtonText = "Like";
        $dislikedButtonText = "Dislike";

        if ( $comments->IsCommentLiked( $postID ) )
        {
            $likedButtonText = "Liked";
        }
        
        if ( $comments->IsCommentDisliked( $postID ) )
        {
            $dislikedButtonText = "Disliked";
        }
        
        if ( $data->currentnestedlevel < $comments->GetMaxNestingLevel( ) )
        {
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
                <input type='submit' name='likeComment' class='likeComment' value='$likedButtonText' />
                <input type='submit' name='dislikeComment' class='dislikeComment' value='$dislikedButtonText' />
            </form>
            ";
        }
        else
        {
            $button = "
            <form action='' method='POST'>
                <input type='hidden' name='id' value='$postID' />
                <input type='hidden' name='token' value='$token' />
                <input type='submit' name='likeComment' class='likeComment' value='$likedButtonText' />
                <input type='submit' name='dislikeComment' class='dislikeComment' value='$dislikedButtonText' />
            </form>
            ";
        }
    }
    
    if ( $data->timeedited > 0 )
    {
        $edited = "Edited: " . Sonar\Time::EpochToDateTime( $data->timeedited );
    }
    
    $commentLikes = $comments->CountCommentOverallLikes( $postID );
    
    echo "
    
    <div class='alert alert-success' role='alert'>
        <strong>$username</strong> $timePosted
        
        <div>
            $description
        </div>
        
        $button ($commentLikes Likes)
        <br />$edited
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