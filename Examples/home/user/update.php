<?php

Sonar\Misc::ChangeWebsiteTitle( "Update User Details" );

$user = new Sonar\User( );

if ( !$user->IsLoggedIn( ) )
{
	Sonar\Redirect::To( "home/index" );
}

if ( Sonar\Input::Exists( "post" ) )
{
	if ( Sonar\Token::Check( Sonar\Input::Get( "token", $_POST ) ) )
	{
		$validate = new Sonar\Validate( );
		$validation = $validate->Check( $_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 32,
                'unique' => Sonar\Config::Get( "users/usersTableName" ),
                'numeric' => false,
                'email' => false
            ),
		) );

		if ( $validation->Passed( ) )
		{
			// UPDATE DETAILS
			try
			{
				$user->Update( array(
					"username" => Sonar\Input::Get( "username", $_POST )
				) );

				Sonar\Session::Flash( "home", "Your details have been updated" );

				Sonar\Redirect::To( "home/index" );
			}
			catch( Exception $error )
			{
				die( $error->GetMessage( ) );
			}
		}
		else
		{
			foreach( $validation->Errors( ) as $error )
			{
				echo $error, "<br />";
			}
		}
	}
}

?>

<form action="" method="POST">
	<div class="field">
		<label for="name">Username</label>
		<input type="text" name="username" id="username" value="<?php echo $user->Data( )->username; ?>" />

		<input type="submit" value="Update" />
		<input type="hidden" name="token" value="<?php echo Sonar\Token::Generate( ); ?>" />
	</div>
</form>