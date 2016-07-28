<?php ob_start( ); require_once( "../elements/HEADER.php" ); ?>

<?php

//include_once( "../application/models/ModelTemplate.php" );
//include_once( "../application/views/ViewTemplate.php" );
//include_once( "../application/controllers/ControllerTemplate.php" );

?>

<?php

$user = new User( );

if ( $user->isLoggedIn( ) )
{
	Redirect::to( "index.php" );
}

ob_end_flush( );

if ( Input::exists( ) )
{
    if ( Token::check( Input::get( "token" ) ) )
    {        
        $validate = new Validate( );
        $validation = $validate->check( $_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 32,
                'unique' => 'Users'
            ),
            'password' => array(
                'required' => true,
                'min' => 6,
                'max' => 32
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'email_address' => array(
                'required' => true,
                'min' => 2,
                'max' => 32
            )
        ) );

        if ( $validation->passed( ) )
        {
            $user = new User( );
            
            $salt = Hash::salt( 32 );

            try
            {
                $user->create( array(
                    "username" => Input::get( "username" ),
                    "password" => Hash::make( Input::get( "password" ), $salt ),
                    "emailaddress" => Input::get( "emailaddress" ),
                    "salt" => $salt,
                    "joined" => date( "Y-m-d H:i:s" )
                ) );
                
                Session::flash( "home", "You have been registered and you can now log in" );
                Redirect::to( "temp.php" );
            }
            catch ( Exception $error )
            {
                die( $error->getMessage( ) );
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

?>

<form action="" method="POST">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo Input::get( "username" ); ?>" autocomplete="off" />
    </div>
    
    <div class="field">
        <label for="password">Choose a password</label>
        <input type="password" name="password" id="password" />
    </div>
    
    <div class="field">
        <label for="password_again">Please confirm your password</label>
        <input type="password" name="password_again" id="password_again" />
    </div>
    
    <div class="field">
        <label for="name">Enter your Email Address MOFO</label>
        <input type="text" name="emailaddress" value="<?php echo Input::get( "name" ); ?>" id="name" />
    </div>
    
    <input type="hidden" name="token" value="<?php echo Token::generate( ); ?>" />
    <input type="submit" value="Register" />
</form>

<?php

/*
$model = new Model();
$controller = new Controller($model);
$view = new View($controller, $model);
echo $view->output();
*/

?>

<?php require_once( "../elements/FOOTER.php" ); ?>