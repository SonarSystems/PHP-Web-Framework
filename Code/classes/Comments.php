<?php

namespace Sonar;

require_once( "Config.php" );
require_once( "Error.php" );
require_once( "User.php" );

class Comments extends __Error
{
    private $_db,
            $_commentsTableName,
            $_likesTableName,
            $_maxLevel,
            $_comments,
            $_postID;
    
    public function __construct( $commentsTableName, $likesTableName, $postID )
    {
        if ( Config::get( "mysql/enabled" ) )
        {
            $this->_db = DB::getInstance( );
            
            $this->_commentsTableName = $commentsTableName;
            $this->_likesTableName = $likesTableName;
        }
        
        $this->_postID = $postID;
        
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
        $this->_db->Get( $this->_commentsTableName, array( $column, "=", $id ) );
        
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
    
    public function InsertComment( $comment, $parentID = 0 )
    {
        $user = new User( );
        $nestingLevel = 1;
        
        if ( !$user->isLoggedIn( ) )
        {
            $this->addError( "Unable to post comment at this time, please try again later." );

            return false;
        }
        else if ( 0 !== $parentID )
        {
            $parentPostResult = $this->_db->Query( "SELECT * From $this->_commentsTableName WHERE id = ? AND postid = ? AND currentnestedlevel < ?", array( $parentID, $this->_postID, $this->_maxLevel ) );
            
            if ( !$parentPostResult->Count( ) )
            {
                $this->addError( "Unable to post comment at this time, please try again later." );
                
                return false;
            }
            else
            {
                $nestingLevel = $parentPostResult->First( )->currentnestedlevel + 1;
            }
        }
        
        $fields = array(
            "postid" => $this->_postID,
            "parentid" => $parentID,
            "userid" => $user->Data( )->id,
            "timeposted" => time( ),
            "timeedited" => 0,
            "description" => base64_encode( $comment ),
            "currentnestedlevel" => $nestingLevel
        );

        return $this->_db->insert( $this->_commentsTableName, $fields );
    }
    
    public function EditComment( $id, $comment )
    {
        return $this->_db->Update( $this->_commentsTableName, $id, array(
            "timeedited" => time( ),
            "description" => base64_encode( $comment )
        ) );   
    }
    
    // check if the comment has been liked
    public function IsCommentLiked( $id )
    {
        $user = new User( );
        
        $likeResult = $this->_db->Query( "SELECT * From $this->_likesTableName WHERE commentid = ? AND userid = ? AND type = ?", array( $id, $user->Data( )->id, "like" ) );
        
        // checks if the comments has been liked
        if ( $likeResult->Count( ) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    // check if the comment has been disliked
    public function IsCommentDisliked( $id )
    {
        $user = new User( );
        
        $dislikeResult = $this->_db->Query( "SELECT * From $this->_likesTableName WHERE commentid = ? AND userid = ? AND type = ?", array( $id, $user->Data( )->id, "dislike" ) );
        
        // checks if the comments has been liked
        if ( $dislikeResult->Count( ) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function LikeComment( $id )
    {
        $user = new User( );
        
        if ( !$user->isLoggedIn( ) )
        {
            $this->addError( "Unable to like comment at this time, please try again later." );

            return false;
        }
        
        if ( !$this->GetCommentsForID( $id ) )
        {
            $this->addError( "Unable to like comment at this time, please try again later." );

            return false;
        }
        
        $dislikeResult = $this->_db->Query( "SELECT * From $this->_likesTableName WHERE commentid = ? AND userid = ? AND type = ?", array( $id, $user->Data( )->id, "dislike" ) );
        
        $fields = array(
            "commentid" => $id,
            "userid" => $user->Data( )->id,
            "timestamp" => time( ),
            "type" => "like"
        );
        
        if ( $dislikeResult->Count( ) ) // remove comment dislike
        {
            $id = $dislikeResult->First( )->id;
            
            $this->_db->Delete( $this->_likesTableName, array( "id", "=", $id ) );
            
            $this->_db->insert( $this->_likesTableName, $fields );
        }
        else // like comment
        {
            $likeResult = $this->_db->Query( "SELECT * From $this->_likesTableName WHERE commentid = ? AND userid = ? AND type = ?", array( $id, $user->Data( )->id, "like" ) );
            
            if ( $likeResult->Count( ) ) // remove comment like
            {
                $id = $likeResult->First( )->id;
            
                $this->_db->Delete( $this->_likesTableName, array( "id", "=", $id ) );
            }
            else
            {
                $this->_db->insert( $this->_likesTableName, $fields );
            }
        }
    }
    
    public function DislikeComment( $id )
    {
        $user = new User( );
        
        if ( !$user->isLoggedIn( ) )
        {
            $this->addError( "Unable to dislike comment at this time, please try again later." );

            return false;
        }
        
        if ( !$this->GetCommentsForID( $id ) )
        {
            $this->addError( "Unable to dislike comment at this time, please try again later." );

            return false;
        }
        
        $likeResult = $this->_db->Query( "SELECT * From $this->_likesTableName WHERE commentid = ? AND userid = ? AND type = ?", array( $id, $user->Data( )->id, "like" ) );
        
        $fields = array(
            "commentid" => $id,
            "userid" => $user->Data( )->id,
            "timestamp" => time( ),
            "type" => "dislike"
        );
        
        if ( $likeResult->Count( ) ) // remove comment like
        {
            $id = $likeResult->First( )->id;
            
            $this->_db->Delete( $this->_likesTableName, array( "id", "=", $id ) );
            
            $this->_db->insert( $this->_likesTableName, $fields );
        }
        else // like comment
        {
            $disLikeResult = $this->_db->Query( "SELECT * From $this->_likesTableName WHERE commentid = ? AND userid = ? AND type = ?", array( $id, $user->Data( )->id, "dislike" ) );
            
            if ( $disLikeResult->Count( ) ) // remove comment dislike
            {
                $id = $disLikeResult->First( )->id;
            
                $this->_db->Delete( $this->_likesTableName, array( "id", "=", $id ) );
            }
            else
            {
                $this->_db->insert( $this->_likesTableName, $fields );
            }
        }
    }
    
    // counts how many times a comment has been liked
    public function CountCommentLikes( $id )
    {
        $likesResult = $this->_db->Query( "SELECT * From $this->_likesTableName WHERE commentid = ? AND type = ?", array( $id, "like" ) );
        
        return $likesResult->Count( );
    }
    
    // counts how many times a comment has been disliked
    public function CountCommentDislikes( $id )
    {
        $dislikeResult = $this->_db->Query( "SELECT * From $this->_likesTableName WHERE commentid = ? AND type = ?", array( $id, "dislike" ) );
        
        return $dislikeResult->Count( );
    }
    
    // count how many times a comment has been liked minus the dislikes
    public function CountCommentOverallLikes( $id )
    {
        return $this->CountCommentLikes( $id ) - $this->CountCommentDislikes( $id );
    }
}