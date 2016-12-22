<?php

$user = new Sonar\User( );
$blog = new Sonar\Blog( );

if ( !$user->IsLoggedIn( ) )
{
    Sonar\Redirect::to( "blog/home" );
    
    exit( );
}
else if ( !$user->IsAdmin( $user->Data( )->username ) )
{
    Sonar\Redirect::to( "blog/home" );
    
    exit( );
}

$title = "";
$highlight = "";
$body = "";

if ( Sonar\Input::exists( "post" ) )
{
    if ( Sonar\Token::check( Sonar\Input::get( "token", $_POST ) ) )
    {       
        if ( Sonar\Input::get( "InsertPost", $_POST ) )
        {
            $validate = new Sonar\Validate( );
            $validation = $validate->check( $_POST, array(
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
            
            $title = Sonar\Input::get( "Title", $_POST );
            $highlight = Sonar\Input::get( "Highlight", $_POST );
            $body = Sonar\Input::get( "Body", $_POST );

            if ( $validation->passed( ) )
            {
                if ( !$blog->InsertPost( $title, $highlight, $body ) )
                {
                    foreach( $blog->errors( ) as $error )
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
    
    <input type="hidden" name="token" value="<?php echo Sonar\Token::generate( ); ?>" />
    <input type="submit" name="InsertPost" id="InsertPost" value="Insert Post" />
</form>