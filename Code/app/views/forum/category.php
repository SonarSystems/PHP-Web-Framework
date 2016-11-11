<?php

$categoryID = $data["id"];

$forum = new Sonar\Forum( );
$categoryResult = $forum->GetCategory( $categoryID );


if ( $categoryResult )
{
    echo "<h1>$categoryResult->title Category</h1>";
}
else
{
    Sonar\Redirect::To( "forum" );
}

?>


<form action="" method="POST">
    <div class="field">
        <label for="TitleInput">Title</label>
        <br />
        <input type="text" name="TitleInput" id="TitleInput" />
    </div>
    
    <div class="field">
        <label for="DescriptionTextArea">Description</label>
        <br />
        <textarea name="DescriptionTextArea" id="DescriptionTextArea"></textarea>
    </div>
    
    <input type="hidden" name="token" value="<?= Sonar\Token::Generate( ); ?>" />
    <input type="submit" name="Post" id="Post" value="Post" />
</form>