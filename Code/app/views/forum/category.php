<?php

$categoryID = $data["id"];

$user = new Sonar\User( );
$forum = new Sonar\Forum( );

$categoryResult = $forum->GetCategory( $categoryID );

if ( $categoryResult )
{
    echo "<h1>$categoryResult->title Category</h1>";
    
    Sonar\Misc::ChangeWebsiteTitle( "Forum - $categoryResult->title" );
}
else
{
    Sonar\Redirect::To( "forum" );
    
    exit( );
}

$title = "";
$description = "";

// check if form has been submitted
if ( Sonar\Input::Exists( "post" ) )
{
    if ( Sonar\Token::Check( Sonar\Input::Get( "token", $_POST ) ) )
    {       
        if ( Sonar\Input::Get( "PostQuestion", $_POST ) )
        {
            $validate = new Sonar\Validate( );
            $validation = $validate->Check( $_POST, array(
                'TitleInput' => array(
                    'required' => true,
                    'min' => 5,
                    'max' => 128
                ),
                'DescriptionTextArea' => array(
                    'required' => true,
                    'min' => 10,
                    'max' => 65535
                )
            ), array(
                "Title",
                "Description"
            ) );
            
            $title = Sonar\Input::Get( "TitleInput", $_POST );
            $description = Sonar\Input::Get( "DescriptionTextArea", $_POST );

            if ( $validation->Passed( ) )
            {         
                $result = $forum->InsertQuestion( $title, $description, $categoryID );

                if ( !$result )
                {
                    foreach( $forum->Errors( ) as $error )
                    {
                        echo $error."<br />";
                    }
                }
                else
                {
                    Sonar\Redirect::To( "forum/question/" . $result );
                }
            }
            else
            {
                foreach( $validation->Errors( ) as $error )
                {
                    echo $error."<br />";
                }
            }
        }
    }
}

// if user is logged in, show form to post questions
if ( $user->IsLoggedIn( ) )
{
?>


<form action="" method="POST">
    <div class="field">
        <label for="TitleInput">Title</label>
        <br />
        <input type="text" name="TitleInput" id="TitleInput" value="<?= $title; ?>" />
    </div>
    
    <div class="field">
        <label for="DescriptionTextArea">Description</label>
        <br />
        <textarea name="DescriptionTextArea" id="DescriptionTextArea"><?= $description; ?></textarea>
    </div>
    
    <input type="hidden" name="token" value="<?= Sonar\Token::Generate( ); ?>" />
    <input type="submit" name="PostQuestion" id="PostQuestion" value="Post" />
</form>
<?php
}
else
{
?>

<div>Please login to post a question in the forum.</div>

<?php    
}

echo "<br />";

$questions = $forum->GetQuestions( $categoryID );

if ( !$questions )
{
    echo "<div>No questions have been posted for this category.</div>";
}
else
{
    // loop over all the questions for this category and print them out
    for ( $i = count( $questions ) - 1; $i >= 0; $i-- )
    {
        $questionID = $questions[$i]->id;
        $title = htmlspecialchars( base64_decode( $questions[$i]->title ) );
        $timePosted = Sonar\Time::EpochToDateTime( $questions[$i]->timeposted );
?>

<div class='alert alert-info' role='alert'>
    <a href="<?= Sonar\Path::To( "forum/question/" . $questionID ); ?>"><strong><?= $title; ?></strong></a>
    
    <br />
    
    <?= $timePosted; ?>
</div>

<?php
    }
}
