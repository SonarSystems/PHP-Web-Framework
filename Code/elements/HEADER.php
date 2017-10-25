<?php

ob_start( );

require_once( "../core/init.php" );

if ( Sonar\Config::get( "mysql/enabled" ) )
{
    Sonar\DB::getInstance( );
}

?>

<!doctype html>
<?php

if ( Sonar\Config::get( "website/isAMPEnabled" ) )
{
    
?>

<html amp lang="en">
    
<?php
    
}
else
{
    
?>
    
<html>

<?php

}

?>
    <head>
        <?php require_once( "SUB/METATAGS.php" ); ?>
        
        <?php require_once( "SUB/FAVICON.php" ); ?>

        <title><?php echo Sonar\Config::get( "website/title" ); ?></title>
        
        <?php
        
        if ( Sonar\Config::get( "website/isAMPEnabled" ) )
        {
            $URL = ( isset( $_SERVER['HTTPS'] ) ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            
        ?>
        
        <link rel="canonical" href="<?= $URL ?>">
        
        <?php
        }
        else
        {
            foreach ( $LIBS_BUILT_IN as $file )
            {
                if ( 1 === $file[1] )
                {
                    foreach ( $__CSS_BIL_LIBS as $iFile )
                    {
                        if ( $file[0] === $iFile[0] )
                        {
                            if ( Sonar\Config::get( "website/isAMPEnabled" ) )
                            {
                                preg_match('/href=(["\'])([^\1]*)\1/i', $iFile[1], $result);
                                echo $result[2] . "\n";
                                $cssFile = file_get_contents( $result[0] );

                                echo "<style amp-custom>$cssFile</style>";
                            }
                            else
                            {
                                echo $iFile[1];
                            }
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
        }
        if ( Sonar\Config::get( "website/isAMPEnabled" ) )
        {
        
        ?>
        
            <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
        
        <?php
            
        }
        
        ?>

    </head>
    
    <body>
        <?php
        
        if ( !Sonar\Config::get( "website/isAMPEnabled" ) )
        {
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
        
        <?php
        
        }