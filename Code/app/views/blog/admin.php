<?php

Sonar\Misc::ChangeWebsiteTitle( "Blog Admin Panel" );

// create user and blog objects
$user = new Sonar\User( );
$blog = new Sonar\Blog( );

// if the user is not logged in then redirect to blog homepage
if ( !$user->IsLoggedIn( ) )
{
    Sonar\Redirect::To( "blog/home" );
    
    exit( );
}
else if ( !$user->IsAdmin( $user->Data( )->username ) ) // if user is not an admin redirect to blog homepage
{
    Sonar\Redirect::To( "blog/home" );
    
    exit( );
}

$title = "";
$highlight = "";
$body = "";

// check if form has been submitted for inserting a new blog post
if ( Sonar\Input::Exists( "post" ) )
{
    if ( Sonar\Token::Check( Sonar\Input::Get( "token", $_POST ) ) )
    {       
        if ( Sonar\Input::Get( "InsertPost", $_POST ) )
        {
            $validate = new Sonar\Validate( );
            $validation = $validate->Check( $_POST, array(
                'Title' => array(
                    'required' => true,
                    'min' => 1,
                    'max' => 64
                ),
                'Body' => array(
                    'required' => true,
                    'min' => 1,
                    'max' => 65535
                ),
            ), array(
                "Title",
                "Body"
            ) );
            
            $title = Sonar\Input::Get( "Title", $_POST );
            $highlight = Sonar\Input::Get( "Highlight", $_POST );
            $body = Sonar\Input::Get( "Body", $_POST );

            if ( $validation->Passed( ) )
            {
                if ( !$blog->InsertPost( $title, $highlight, $body ) )
                {
                    foreach( $blog->Errors( ) as $error )
                    {
                        echo $error."<br />";
                    }
                }
                else
                {
                    $title = "";
                    $highlight = "";
                    $body = "";
                    
                    echo "Post Inserted";
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

?>

<!-- Form for Blog post creation -->
<form action="" method="POST">
    <div class="field">
        <label for="Title">Title</label>
        <input type="text" name="Title" id="Title" value="<?php echo $title; ?>" />
    </div>
    
    <div class='field'>
        <label for='Highlight'>Highlight (optional)</label>
        <div>
            <textarea name='Highlight' id='Highlight'><?php echo $highlight; ?></textarea>
        </div>
    </div>
    
    <div class='field'>
        <label for='Body'>Body</label>
        <div>
            <textarea name='Body' id='Body'><?php echo $body; ?></textarea>
        </div>
    </div>
    
    <input type="hidden" name="token" value="<?php echo Sonar\Token::Generate( ); ?>" />
    <input type="submit" name="InsertPost" id="InsertPost" value="Insert Post" />
</form>