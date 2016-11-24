<?php

$questionID = $data["id"];

$user = new Sonar\User( );

$forum = new Sonar\Forum( );
$questionResult = $forum->GetQuestion( $questionID );

if ( !$questionResult )
{
    Sonar\Redirect::To( "forum" );
}

$questionArray["userid"] = $questionResult->userid;
$user->Find( $questionArray["userid"] );
$questionArray["username"] = $user->Data( )->username;

$questionArray["timeposted"] = Sonar\Time::EpochToDateTime( $questionResult->timeposted );
$questionArray["timeedited"] = $questionResult->timeedited;
$questionArray["title"] = htmlspecialchars( base64_decode( $questionResult->title ) );
$questionArray["description"] = nl2br( htmlspecialchars( base64_decode( $questionResult->description ) ) );


    
?>

<div class='alert alert-danger' role='alert'>
    <h1><strong><?= $questionArray["title"]; ?></strong></h1>
        
    <h3><?= $questionArray["username"]; ?></h3>
    <h6>Time Posted: <?= $questionArray["timeposted"]; ?></h6>
    
    <hr />
    
    <?= $questionArray["description"]; ?>
    
    <?php
    
    if ( $questionArray["timeedited"] > 0 )
    {
        echo "<hr />";
        echo "Time Edited: " . Sonar\Time::EpochToDateTime( $questionArray["timeedited"] );
    }
    
    ?>
</div>

<?php

$templateCommentsTableName = "forumcomments";
$templateCommentsPostID = $questionID;

require_once( "../templates/views/_templateForumComments.php" );