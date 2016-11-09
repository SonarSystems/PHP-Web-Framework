<?php

namespace Sonar;

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
    public static function EpochToDateTime( $epoch, $type = "fulldatetime" )
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
    
    /*
    *   Convert a unit of time to seconds
    *   For Example
    *   convertToSeconds( 10, "minutes" ); => 10 * 60 => 600
    *   convertToSeconds( 10, "hours" ); => 10 * 60 * 60 => 36000
    *   convertToSeconds( 10, "days" ); => 10 * 24 * 60 * 60 => 864000
    *   convertToSeconds( 10, "weeks" ); => 10 * 7 * 24 * 60 * 60 => 6048000
    *   convertToSeconds( 10, "months" ); => 10 * 30 * 24 * 60 * 60 => 25920000
    *   convertToSeconds( 10, "years" ); => 10 * 365 * 24 * 60 * 60 => 315360000
    */
    public static function ConvertToSeconds( $unit, $type )
    {
        $time = null;
        
        switch ( strtolower( $type ) )
        {
            case "seconds":
                $time = $unit;
                
                break;
                
            case "minutes":
                $time = $unit * 60;
                
                break;
                
            case "hours":
                $time = $unit * 60 * 60;
                
                break;
                
            case "days":
                $time = $unit * 24 * 60 * 60;
                
                break;
                
            case "weeks":
                $time = $unit * 7 * 24 * 60 * 60;
                
                break;
                
            case "months":
                $time = $unit * 30 * 24 * 60 * 60;
                
                break;
                
            case "years":
                $time = $unit * 365 * 24 * 60 * 60;
                
                break;
        }
        
        return $time;
    }
    
    /*
    *   Convert a unit of time to milliseconds
    *   For Example
    *   convertToMilliseconds( 10, "minutes" ); => 10 * 60 * 1000 => 600000
    *   convertToMilliseconds( 10, "hours" ); => 10 * 60 * 60 * 1000 => 36000000
    *   convertToMilliseconds( 10, "days" ); => 10 * 24 * 60 * 60 * 1000 => 864000000
    *   convertToMilliseconds( 10, "weeks" ); => 10 * 7 * 24 * 60 * 60 * 1000 => 6048000000
    *   convertToMilliseconds( 10, "months" ); => 10 * 30 * 24 * 60 * 60 * 1000 => 25920000000
    *   convertToMilliseconds( 10, "years" ); => 10 * 365 * 24 * 60 * 60 * 1000 => 315360000000
    */
    public static function ConvertToMilliseconds( $unit, $type )
    {
        $time = self::ConvertToSeconds( $unit, $type ) * 1000;
        
        return $time;
    }
    
    // Convert a value below 10 such as 9 to 09
    private static function AddZero( $number )
    {
        if ( $number < 10 )
        {
            return "0" . $number;
        }
        
        return $number;
    }
}