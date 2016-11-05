<?php

namespace Sonar;

require_once( "Config.php" );
require_once( "Error.php" );

class Commenting extends __Error
{
    private $_db,
            $_commentsTable,
            $_maxLevel,
            $_comments;
    
    public function __construct( $tableName )
    {
        if ( Config::get( "mysql/enabled" ) )
        {
            $this->_db = DB::getInstance( );
            
            $this->_commentsTable = $tableName;
        }
        
        $this->_maxLevel = 1;
    }
    
    public function SetMaxNestingLevel( $maxLevel )
    {
        $this->_maxLevel = $maxLevel;
    }
    
    public function GetMaxNestingLevel( )
    {
        return $this->_maxLevel;
    }
    
    private function LoadComments( $column, $id )
    {
        $this->_db->get( $this->_commentsTable, array( $column, "=", $id ) );
        
        // check if comments exist for the requested id
        if ( $this->_db->Count( ) )
    	{
    		$this->_comments = $this->_db->Results( );

    		return true;
    	}
        else
        {
            return false;
        }
    }
    
    private function GetComments( $column, $id, $forceLoad )
    {
        // force loads/retrieves the comments from the database
        if ( $forceLoad )
        {
            $this->LoadComments( $column, $id );
        }
        
        // check if comments exist for the requested id
        if ( $this->Count( ) )
    	{
    		return $this->_comments;
    	}
        else
        {
            return false;
        }
    }
    
    public function GetCommentsForPostID( $postID, $forceLoad = true )
    {
        return $this->GetComments( "postid", $postID, $forceLoad );
    }
    
    public function GetCommentsForUserID( $userID, $forceLoad = true )
    {
        return $this->GetComments( "userid", $userID, $forceLoad );
    }
    
    public function GetCommentsForParentID( $parentID, $forceLoad = true )
    {
        return $this->GetComments( "parentid", $parentID, $forceLoad );
    }
    
    public function GetCommentsForID( $id, $forceLoad = true )
    {
        return $this->GetComments( "id", $id, $forceLoad );
    }
    
    // get number of comments for post
    public function Count( )
    {
        return $this->_db->Count( );
    }
}