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
        <meta charset="<?= Sonar\Config::get( "meta/charset" ); ?>" />
        <meta name="description" content="<?= Sonar\Config::get( "meta/description" ); ?>" />
        <meta name="keywords" content="<?php
                                       $index = 0;
                                       
                                       foreach( Sonar\Config::get( "meta/keywords" ) as $keyword )
                                       {
                                           $index++;
                                           
                                           echo $keyword;
                                           
                                           if ( $index < count( Sonar\Config::get( "meta/keywords" ) ) )
                                           {
                                            echo ", ";
                                           }
                                       }
                                       ?>" />
        <meta name="author" content="<?= Sonar\Config::get( "meta/author" ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
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
            
            $path = Sonar\Misc::prependRoot( "css/$file[0].css?v=$version" );
            
            echo "<link rel='stylesheet' type='text/css' href='$path' />";
        }
        
        ?>
    </head>
    
    <body>
