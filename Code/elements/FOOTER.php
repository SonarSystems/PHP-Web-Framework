<?php

if ( !Sonar\Config::get( "website/isAMPEnabled" ) )
{
    foreach ( $LIBS_BUILT_IN as $file )
    {
        if ( 1 === $file[1] )
        {
            foreach ( $__JS_BIL_LIBS as $iFile )
            {
                if ( $file[0] === $iFile[0] )
                {
                    echo $iFile[1];
                }
            }
        }
    }

    foreach ( $JS_CDN_LIBS as $file )
    {
        echo $file;
    }

    foreach ( $JS_LOCAL_LIBS as $file )
    {
        echo $file;
    }

    foreach ( $JS_INTERNAL_FILES as $file )
    {   
        if ( Sonar\Config::get( "website/debug" ) )
        {
            $version = time( );
        }
        else
        {
            $version = $file[1];
        }

        $path = Sonar\Path::To( "js/$file[0].js?v=$version" );

        echo "<script src='$path'></script>";
    }

    if ( Sonar\Config::Get( "security/GooglereCAPTCHA/" )["enabled"] )
    {
    ?>

        <script src='https://www.google.com/recaptcha/api.js'></script>

    <?php
    }

    if ( Sonar\Config::get( "website/debug" ) )
    {
        $version = "?v=" . time( );
    }
    else
    {
        $version = "";
    }
    ?>
            <script src="<?= Sonar\Path::PrependRoot( "../elements/SUB/JavaScript/END_OF_BODY.js$version" ); ?>"></script>
<?php
}
?>
    </body>
</html>

<?php ob_end_flush( );