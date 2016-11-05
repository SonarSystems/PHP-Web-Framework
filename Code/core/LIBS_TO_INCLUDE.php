<?php

/*
*   CSS libraries from a CDN (Content Delivery Network)
*   Must be in the form <link rel="stylesheet" href="https://example.com/example.css">
*/
$CSS_CDN_LIBS = array
(
    
);

/*
*   CSS libraries stored locally
*   Must be in the form <link rel="stylesheet" href="folder/example.css">
*/
$CSS_LOCAL_LIBS = array
(
    
);

/*
*   JavaScript libraries from a CDN (Content Delivery Network)
*   Must be in the form <script src="https://example.com/example.js"></script>
*/
$JS_CDN_LIBS = array
(
    
);

/*
*   JavaScript libraries stored locally
*   Must be in the form <script src="folder/example.js"></script>
*/
$JS_LOCAL_LIBS = array
(
    
);

/*
*   Libraries that are already setup locally or via a CDN to be included.
*   By default all libraries are disabled, change to 1 to enable lib
*   DO NOT CHANGE THE LIBRARY FILENAME
*   ALL FILES ARE MINIFIED VERSIONS WHERE POSSIBLE
*/
$LIBS_BUILT_IN = array
(
    array( "jQuery-V3-1-0", 0 ),
    array( "jQuery-V2-2-4", 0 ),
    array( "jQuery-V1-12-4", 0 ),
    
    array( "Bootstrap-V3-3-7", 1 ),
    
    array( "Skeleton-V2-0-4", 0 ),
    
    array( "Foundation-V6-2-3", 0 ),
    
    array( "W3.CSS", 0 ),
    
    array( "Materialize-V0-97-7", 0 )
);

require_once( "misc/BUILT_IN_LIBS.php" );