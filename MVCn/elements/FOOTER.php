<?php

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
    if ( Config::get( "debug" ) )
    {
        $version = time( );
    }
    else
    {
        $version = $file[1];
    }
    
    $path = Misc::prependRoot( "js/$file[0].js?v=$version" );
    
    echo "<script src='$path'></script>";
}
        
?>
    </body>
</html>

<?php ob_end_flush( ); ?>