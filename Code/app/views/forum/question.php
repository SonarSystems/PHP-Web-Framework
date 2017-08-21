<?php

$questionID = $data["id"];

$user = new Sonar\User( );
$forum = new Sonar\Forum( );

$questionResult = $forum->GetQuestion( $questionID );

// check if the question exists
if ( !$questionResult )
{
    Sonar\Redirect::To( "forum" );
    
    exit( );
}

// check if a form has been submitted
if ( Sonar\Input::Exists( "post" ) )
{
    $sessionToken = Sonar\Input::Get( "token", $_POST );

    if ( Sonar\Token::Check( $sessionToken ) )
    {
        if ( Sonar\Input::Get( "likeQuestion", $_POST ) )
        {
            $id = Sonar\Input::Get( "id", $_POST );
            
            $forum->LikeQuestion( $id );
        }
        else if ( Sonar\Input::Get( "dislikeQuestion", $_POST ) )
        {
            $id = Sonar\Input::Get( "id", $_POST );
            
            $forum->DislikeQuestion( $id );
        }
        else if ( Sonar\Input::Get( "favouriteQuestion", $_POST ) )
        {
            $id = Sonar\Input::Get( "id", $_POST );

            $forum->FavouriteQuestion( $id );
        }
    }
}

$questionArray["id"] = $questionResult->id;

$questionArray["userid"] = $questionResult->userid;
$user->Find( $questionArray["userid"] );
$questionArray["username"] = $user->Data( )->username;

$questionArray["timeposted"] = Sonar\Time::EpochToDateTime( $questionResult->timeposted );
$questionArray["timeedited"] = $questionResult->timeedited;
$questionArray["title"] = htmlspecialchars( base64_decode( $questionResult->title ) );
$questionArray["description"] = nl2br( htmlspecialchars( base64_decode( $questionResult->description ) ) );

Sonar\Misc::ChangeWebsiteTitle( "Forum - " . $questionArray["title"] );

$token = Sonar\Token::Generate( );

if ( $user->IsLoggedIn( ) )
{
    $likedButtonText = "Like";
    $dislikedButtonText = "Dislike";
    $favouriteButtonText = "Favourite";

    if ( $forum->IsQuestionLiked( $questionArray["id"] ) )
    {
        $likedButtonText = "Liked";
    }

    if ( $forum->IsQuestionDisliked( $questionArray["id"] ) )
    {
        $dislikedButtonText = "Disliked";
    }
    
    if ( $forum->IsQuestionFavourited( $questionArray["id"] ) )
    {
        $favouriteButtonText = "Favourited";
    }
}

$questionLikes = $forum->CountQuestionOverallLikes( $questionArray["id"] );
    
?>

<div class='alert alert-danger' role='alert'>
    <h1><strong><?= $questionArray["title"]; ?></strong></h1>
        
    <h3><?= $questionArray["username"]; ?></h3>
    <h6>Time Posted: <?= $questionArray["timeposted"]; ?></h6>
    
    <hr />
    
    <?= $questionArray["description"]; ?>
    
    <form action='' method='POST'>
        <input type='hidden' name='id' value='<?= $questionArray["id"]; ?>' />
        <input type='hidden' name='token' value='<?= $token; ?>' />
        <?php
        
        if ( $user->IsLoggedIn( ) )
        {
        
        ?>
        
            <input type='submit' name='likeQuestion' class='likeQuestion' value='<?= $likedButtonText; ?>' />
            <input type='submit' name='dislikeQuestion' class='dislikeQuestion' value='<?= $dislikedButtonText; ?>' />
            <input type='submit' name='favouriteQuestion' class='favouriteQuestion' value='<?= $favouriteButtonText; ?>' />
        
        <?php
            
        }
        
        ?>
    </form>
    
    (<?= $questionLikes; ?> likes)
    
    <?php
    
    if ( $questionArray["timeedited"] > 0 )
    {
        echo "<hr />";
        echo "Time Edited: " . Sonar\Time::EpochToDateTime( $questionArray["timeedited"] );
    }
    
    ?>
</div>

<?php

$templateCommentsTableName = Sonar\Config::Get( "forum/forumQuestionCommentsTableName" );
$templateCommentLikesTableName = Sonar\Config::Get( "forum/forumQuestionCommentLikesTableName" );
$templateCommentsPostID = $questionID;

// load in the template for showing comments on the forum
require_once( "../templates/views/_templateForumComments.php" );