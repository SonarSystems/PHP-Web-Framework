<?php

class Time
{
    /*
    *   Convert epoch time (with milliseconds) to a human readable format
    *   To use this method to convert an epoch time with milliseconds, divide it by 1000 first
    *   DEFAULT TYPE IS fullDateTime and is an optional argument
    *   fullDateTime    =   Fri Jul 22 2016 10:41:50 GMT+0100 (BST)
    *   fullTime        =   10:41:50
    *   fullDate        =   22 July 2016
    *   day             =   22
    *   month           =   July
    *   year            =   2016
    *   hour            =   10
    *   minute          =   41
    *   second          =   50
    */
    public static function epochToDateTime( $epoch, $type = "fulldatetime" )
    {
        $time = "";
        
        switch ( strtolower( $type ) )
        { 
            case "fulldatetime":
            default:
                $time = "<script>var date = new Date( $epoch * 1000 ); document.write( date ); </script>";
                
                break;
                
            case "fulltime":
                $time = "
                <script>
                    var date = new Date( $epoch * 1000 );
                    document.write( ( '0' + date.getHours( ) ).slice( -2 ) + ':' + 
                                    ( '0' + date.getMinutes( ) ).slice( -2 ) + ':' + 
                                    ( '0' + date.getSeconds( ) ).slice( -2 ) );</script>
                ";
                
                break;
                
            case "fulldate":
                $time = "
                <script>
                    var month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    var date = new Date( $epoch * 1000 );
                    document.write( date.getDate( ) + ' ' +
                                    month[date.getMonth( )] + ' ' +
                                    date.getFullYear( ) );</script>
                ";
                
                break;
                
            case "day":
                $time = "
                <script>
                    var date = new Date( $epoch * 1000 );
                    document.write( date.getDate( ) );</script>
                ";
                
                break;
                
            case "month":
                $time = "
                <script>
                    var month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    document.write( month[date.getMonth( )] );</script>
                ";
                
                break;
                
            case "year":
                $time = "
                <script>
                    var date = new Date( $epoch * 1000 );
                    document.write( date.getFullYear( ) );</script>
                ";
                
                break;
            
            case "hour":
                $time = "
                <script>
                    var date = new Date( $epoch * 1000 );
                    document.write( date.getHours( ) );</script>
                ";
                
                break;
                
            case "minute":
                $time = "
                <script>
                    var date = new Date( $epoch * 1000 );
                    document.write( date.getMinutes( ) );</script>
                ";
                
                break;
                
            case "second":
                $time = "
                <script>
                    var date = new Date( $epoch * 1000 );
                    document.write( date.getSeconds( ) );</script>
                ";
                
                break;
        }
        
        return $time;
    }
    
    // Convert a value below 10 such as 9 to 09
    private static function addZero( $number )
    {
        if ( $number < 10 )
        {
            return "0" . $number;
        }
        
        return $number;
    }
}

?>