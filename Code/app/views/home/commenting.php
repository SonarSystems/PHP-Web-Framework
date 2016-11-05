<?php

$comments = new Sonar\Commenting( "comments" );
$comments->SetMaxNestingLevel( 3 );
$user = new Sonar\User( );

$data = $comments->GetCommentsForPostID( 3 );

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