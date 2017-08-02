<?php

namespace Sonar;

require_once( "Config.php" );
require_once( "Error.php" );
require_once( "User.php" );

class Notifications extends __Error
{
    private $_db,
            $_notificationsTableName,
            $_notificationTypesTableName,
            $_notifications,
            $_notificationTypes;
    
    public function __construct( $notificationsTableName, $notificationTypesTableName )
    {
        if ( Config::get( "mysql/enabled" ) )
        {
            $this->_db = DB::getInstance( );
            
            $this->_notificationsTableName = $notificationsTableName;
            $this->_notificationTypesTableName = $notificationTypesTableName;
            
            $this->_db->Query( "SELECT * From $this->_notificationTypesTableName" );
            
            $this->_notificationTypes = $this->_db->Results( );
            
            $this->_db->Flush( );
        }
    }
    
    // Create/insert the notification into the database
    public function Create( $type, $userid, $title )
    {
        $user = new User( );
        
        if ( $user->Find( $userid ) )
        {
            $fields = array(
                "type" => $type,
                "userid" => $user->Data( )->id,
                "title" => base64_encode( $title ),
                "timestamp" => time( )
            );

            if ( $this->_db->insert( $this->_notificationsTableName, $fields ) )
            {
                return true;
            }
            else
            {
                $this->addError( "Unable to insert notification." );
                
                return false;
            }
        }
        else
        {
            $this->addError( "Unable to find user, please check their id is valid." );

            return false;
        }
    }
    
    // Check if the notification is a valid type from the notification types tables
    private function IsNotificationTypeValid( $notificationType )
    {
        foreach ( $this->_notificationTypes as $type )
        {
            if ( strtolower( $type->type ) === strtolower( $notificationType ) )
            {
                return true;
            }
        }
        
        return false;
    }
    
    // Splits the where array into columns and values
    private function ExplodeWhereArray( $where = array( ), &$whereCondition, &$whereArray )
    {
        $i = 0;
        
        // loop over the where array to check for conditions
        foreach( $where as $key => $data )
        {
            if ( $i === 0 )
            {
                $whereCondition .= " WHERE ";
            }
            else
            {
                $whereCondition .= " AND ";
            }
            
            $whereCondition .= $key;
            $whereCondition .= " = ";
            $whereCondition .= "?";
            
            array_push( $whereArray, $data );
            
            $i++;
        }
    }
    
    // Get all notifications based on a specific condition
    private function LoadNotifications( $where = array( ), $order = "asc", $forceLoad = true )
    {
        // check if the notifications are to be retrieved again from the database
        if ( $forceLoad )
        {
            if ( "desc" !== strtolower( $order ) && "asc" !== strtolower( $order ) )
            {
                $order = "asc";
            }
            
            $whereCondition = "";
            $whereArray = array( );
            
            $this->ExplodeWhereArray( $where, $whereCondition, $whereArray );
                                                
            $this->_db->Query( "SELECT * From $this->_notificationsTableName $whereCondition ORDER BY timestamp $order", $whereArray );

            if ( $this->_db->Count( ) )
            {
                $this->_notifications = $this->_db->Results( );
            }
            else
            {
                return false;
            }
        }
        
        return $this->_notifications;
    }
    
    // Mark notification(s) as read or viewed
    private function MarkAsViewedOrRead( $where = array( ), $column, $markValue = true )
    {
        if ( !$column )
        {
            return;
        }
        
        $whereCondition = "";
        $whereArray = array( );
            
        $this->ExplodeWhereArray( $where, $whereCondition, $whereArray );
        
        $this->_db->Query( "UPDATE $this->_notificationsTableName SET $column = $markValue $whereCondition", $whereArray );
    }
    
    // Get all notifications (most likely only for admins and testing)
    public function GetAll( $order = "asc", $forceLoad = true )
    {
        return $this->LoadNotifications( array( ), $order, $forceLoad );
    }
    
    // Get all notifications for a particular user
    public function GetAllForUser( $userid, $order = "asc", $forceLoad = true )
    {
        $user = new User( $userid );
        
        if ( !$user->Data( ) )
        {
            $this->addError( "Unable to retrieve notifications at this time due to an invalid user id, please try again later." );

            return false;
        }
        
        return $this->LoadNotifications( array( "userid" => $userid ), $order, $forceLoad );
    }
    
    // Get all notifications for the user that is signed in
    public function GetAllForUserSignedIn( $order = "asc", $forceLoad = true )
    {
        $user = new User( );
        
        if ( !$user->isLoggedIn( ) )
        {
            $this->addError( "Unable to retrieve notifications at this time due to the user not being logged in, please try again later." );

            return false;
        }
        
        $userid = $user->Data( )->id;
        
        return $this->LoadNotifications( array( "userid" => $userid ), $order, $forceLoad );
    }
    
    // Get all notifications of a particular type
    public function GetAllForType( $notificationType, $order = "asc", $forceLoad = true )
    {
        if ( !$this->IsNotificationTypeValid( $notificationType ) )
        {
            $this->addError( "Not a valid notification type, please try again." );
            
            return false;
        }
        
        return $this->LoadNotifications( array( "type" => $notificationType ), $order, $forceLoad );
    }
    
    // Get all notifications of a particular type for a specific user
    public function GetAllForUserAndType( $userid, $notificationType, $order = "asc", $forceLoad = true )
    {
        $user = new User( $userid );
        
        if ( !$user->Data( ) )
        {
            $this->addError( "Unable to retrieve notifications at this time due to an invalid user id, please try again later." );

            return false;
        }
        
        if ( !$this->IsNotificationTypeValid( $notificationType ) )
        {
            $this->addError( "Not a valid notification type, please try again." );
            
            return false;
        }
        
        return $this->LoadNotifications( array( "type" => $notificationType, "userid" => $userid ), $order, $forceLoad );
    }
    
    // Get all notifications of a particular type for a specific user
    public function GetAllForUserSignedInAndType( $notificationType, $order = "asc", $forceLoad = true )
    {
        $user = new User( );
        
        if ( !$user->isLoggedIn( ) )
        {
            $this->addError( "Unable to retrieve notifications at this time due to the user not being logged in, please try again later." );

            return false;
        }
        
        $userid = $user->Data( )->id;
        
        if ( !$this->IsNotificationTypeValid( $notificationType ) )
        {
            $this->addError( "Not a valid notification type, please try again." );
            
            return false;
        }
        
        return $this->LoadNotifications( array( "type" => $notificationType, "userid" => $userid ), $order, $forceLoad );
    }
    
    // Marks all notifications as viewed for a particular user
    public function MarkAllAsViewedForUser( $userid )
    {
        $this->MarkAsViewedOrRead( array( "userid" => $userid ), "isviewed", 1 );
    }
    
    // Unmarks all notifications as viewed for a particular user
    public function UnmarkAllAsViewedForUser( $userid )
    {
        $this->MarkAsViewedOrRead( array( "userid" => $userid ), "isviewed", 0 );
    }
    
    // Marks all notifications as opened for a particular user
    public function MarkAllAsOpenedForUser( $userid )
    {
        $this->MarkAsViewedOrRead( array( "userid" => $userid ), "isopened", 1 );
    }
    
    // Unmarks all notifications as opened for a particular user
    public function UnmarkAllAsOpenedForUser( $userid )
    {
        $this->MarkAsViewedOrRead( array( "userid" => $userid ), "isopened", 0 );
    }
    
    // Mark a particular notification as viewed
    public function MarkAsViewed( $notificationid )
    {
        $this->MarkAsViewedOrRead( array( "id" => $notificationid ), "isviewed", 1 );
    }
    
    // Unmark a particular notification as viewed
    public function UnmarkAsViewed( $notificationid )
    {
        $this->MarkAsViewedOrRead( array( "id" => $notificationid ), "isviewed", 0 );
    }
    
    // Mark a particular notification as opened
    public function MarkAsOpened( $notificationid )
    {
        $this->MarkAsViewedOrRead( array( "id" => $notificationid ), "isopened", 1 );
    }
    
    // Unmark a particular notification as opened
    public function UnmarkAsOpened( $notificationid )
    {
        $this->MarkAsViewedOrRead( array( "id" => $notificationid ), "isopened", 0 );
    }
}