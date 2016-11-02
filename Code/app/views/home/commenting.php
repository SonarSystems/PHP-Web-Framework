<?php

$comments = new Sonar\Commenting( "comments" );
$user = new Sonar\User( );

//print_r( $comments->GetComments( 3 ) );

$data = $comments->GetCommentsForPostID( 3 );

foreach ( $data as $row )
{
    $user->Find( $row->userid );
?>
    <hr />

    <strong><?= $user->Data( )->username; ?></strong> <?= Sonar\Time::EpochToDateTime( $row->timeposted ); ?>
    <div>
        <?= $row->description; ?>
    </div>
<?php
    if ( $row->currentnestedlevel < $comments->GetMaxNestingLevel( ) )
    {
?>
        <input type="button" value="Reply" />
<?php
    }
}

?>