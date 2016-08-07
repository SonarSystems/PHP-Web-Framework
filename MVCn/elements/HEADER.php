<?php

ob_start( );

require_once( "../core/init.php" );

if ( Config::get( "mysql/enabled" ) )
{
    DB::getInstance( );
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?= Config::get( "meta/charset" ); ?>" />
        <meta name="description" content="<?= Config::get( "meta/description" ); ?>" />
        <meta name="keywords" content="<?php
                                       $index = 0;
                                       
                                       foreach( Config::get( "meta/keywords" ) as $keyword )
                                       {
                                           $index++;
                                           
                                           echo $keyword;
                                           
                                           if ( $index < count( Config::get( "meta/keywords" ) ) )
                                           {
                                            echo ", ";
                                           }
                                       }
                                       ?>" />
        <meta name="author" content="<?= Config::get( "meta/author" ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <?php require_once( "SUB/FAVICON.php" ); ?>

        <title><?php echo Config::get( "website/title" ); ?></title>
  
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
            if ( Config::get( "debug" ) )
            {
                $version = time( );
            }
            else
            {
                $version = $file[1];
            }
            
            $path = Misc::prependRoot( "css/$file[0].css?v=$version" );
            
            echo "<link rel='stylesheet' type='text/css' href='$path' />";
        }
        
        ?>
    </head>
    
    <body>
        