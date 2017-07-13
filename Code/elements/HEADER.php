<?php

ob_start( );

require_once( "../core/init.php" );

if ( Sonar\Config::get( "mysql/enabled" ) )
{
    Sonar\DB::getInstance( );
}

?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once( "SUB/METATAGS.php" ); ?>
        
        <?php require_once( "SUB/FAVICON.php" ); ?>

        <title><?php echo Sonar\Config::get( "website/title" ); ?></title>
  
        <?php
        
        foreach ( $LIBS_BUILT_IN as $file )
        {
            if ( 1 === $file[1] )
            {
                foreach ( $__CSS_BIL_LIBS as $iFile )
                {
                    if ( $file[0] === $iFile[0] )
                    {
                        echo $iFile[1];
                    }
                }
            }
        }
        
        foreach ( $CSS_CDN_LIBS as $file )
        {
            echo $file;
        }
        
        foreach ( $CSS_LOCAL_LIBS as $file )
        {
            echo $file;
        }
        
        foreach ( $CSS_INTERNAL_FILES as $file )
        {
            if ( Sonar\Config::get( "website/debug" ) )
            {
                $version = time( );
            }
            else
            {
                $version = $file[1];
            }
            
            $path = Sonar\Path::PrependRoot( "css/$file[0].css?v=$version" );
            
            echo "<link rel='stylesheet' type='text/css' href='$path' />";
        }
        
        foreach ( $PHP_CSS_INTERNAL_FILES as $file )
        {
            if ( Sonar\Config::get( "website/debug" ) )
            {
                $version = time( );
            }
            else
            {
                $version = $file[1];
            }
            
            $path = Sonar\Path::PrependRoot( "css/$file[0].php?v=$version" );
            
            echo "<link rel='stylesheet' type='text/css' href='$path' />";
        }
        
        ?>
    </head>
    
    <body>
        <?php
        
        if ( Sonar\Config::get( "website/debug" ) )
        {
            $version = "?v=" . time( );
        }
        else
        {
            $version = "";
        }
        
        ?>
        <script src="<?= Sonar\Path::PrependRoot( "../elements/SUB/JavaScript/START_OF_BODY.js$version" ); ?>"></script>