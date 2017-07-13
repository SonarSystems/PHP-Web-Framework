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