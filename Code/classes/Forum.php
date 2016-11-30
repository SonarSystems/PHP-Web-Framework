<?php

namespace Sonar;

require_once( "Config.php" );
require_once( "Error.php" );
require_once( "User.php" );
require_once( "Comments.php" );

class Forum extends __Error
{
    private $_db,
            $_sectionsTableName,
            $_categoriesTableName,
            $_questionsTableName,
            $_questionLikesTableName,
            $_questionCommentsTableName,
            $_questionCommentLikesTableName,
            $_sections,
            $_categories,
            $_questions;
    
    public function __construct( )
    {
        if ( Config::Get( "mysql/enabled" ) )
        {
            $this->_db = DB::GetInstance( );

            $this->_sectionsTableName = Config::Get( "forum/forumSectionsTableName" );
            $this->_categoriesTableName = Config::Get( "forum/forumCategoriesTableName" );
            $this->_questionsTableName = Config::Get( "forum/forumQuestionsTableName" );
            $this->_questionLikesTableName = Config::Get( "forum/forumQuestionLikesTableName" );
            $this->_questionCommentsTableName = Config::Get( "forum/forumQuestionCommentsTableName" );
            $this->_questionCommentLikesTableName = Config::Get( "forum/forumQuestionCommentLikesTableName" );
        }
    }
    
    // load all the sections
    private function LoadSections( )
    {
        $this->_db->Query( "SELECT * From $this->_sectionsTableName" );
        
        if ( $this->_db->Count( ) )
        {
            $this->_sections = $this->_db->Results( );
                
    		return true;
    	}
        else
        {
            return false;
        }
    }
    
    // get all the sections
    public function GetSections( $forceLoad = true )
    {
        // force loads/retrieves the forum sections from the database
        if ( $forceLoad )
        {
            $this->LoadSections( );
        }
        
        // check if any sections
        if ( $this->Count( ) )
    	{
    		return $this->_sections;
    	}
        else
        {
            return false;
        }
    }
    
    // load all the categories for a section
    private function LoadCategories( $id )
    {   
        $this->_db->Get( $this->_categoriesTableName, array( "sectionid", "=", $id ) );
        
        if ( $this->_db->Count( ) )
        {
            $this->_categories = $this->_db->Results( );
                
    		return true;
    	}
        else
        {
            return false;
        }
    }
    
    // get all the categories for a section
    public function GetCategories( $id, $forceLoad = true )
    {
        // force loads/retrieves the forum categories from the database
        if ( $forceLoad )
        {
            $this->LoadCategories( $id );
        }
        
        // check if any categories exist
        if ( $this->Count( ) )
    	{
    		return $this->_categories;
    	}
        else
        {
            return false;
        }
    }
    
    // get all the questions for a category
    public function GetQuestions( $id, $forceLoad = true )
    {
        // force loads/retrieves the forum questions from the database
        if ( $forceLoad )
        {
            $this->_db->Get( $this->_questionsTableName, array( "categoryid", "=", $id ) );
        
            if ( $this->_db->Count( ) )
            {
                $this->_questions = $this->_db->Results( );
            }
            else
            {
                return false;
            }            
        }
        
        return $this->_questions;
    }
    
    // get the table row for a section
    public function GetSection( $id )
    {
        $this->_db->Get( $this->_sectionsTableName, array( "sectionid", "=", $id ) );
        
        if ( $this->_db->Count( ) )
        {
            return $this->_db->First( ); 
    	}
        else
        {
            return false;
        }
    }
    
    // get the table row for a category
    public function GetCategory( $id )
    {
        $this->_db->Get( $this->_categoriesTableName, array( "categoryid", "=", $id ) );
        
        if ( $this->_db->Count( ) )
        {
            return $this->_db->First( ); 
    	}
        else
        {
            return false;
        }
    }
    
    // get the table row for a question
    public function GetQuestion( $id )
    {
        $this->_db->Get( $this->_questionsTableName, array( "id", "=", $id ) );
        
        if ( $this->_db->Count( ) )
        {
            return $this->_db->First( ); 
    	}
        else
        {
            return false;
        }
    }
    
    // insert the question into the database
    public function InsertQuestion( $title, $description, $categoryID )
    {
        $user = new User( );
        
        if ( !$user->isLoggedIn( ) )
        {
            $this->addError( "Unable to post comment at this time, please try again later." );

            return false;
        }
        
        if ( !self::GetCategory( $categoryID ) )
        {
            $this->addError( "Unable to post comment at this time, please try again later." );

            return false;
        }
        
        $fields = array(
            "categoryid" => $categoryID,
            "userid" => $user->Data( )->id,
            "timeposted" => time( ),
            "timeedited" => 0,
            "title" => base64_encode( $title ),
            "description" => base64_encode( $description )
        );

        if ( $this->_db->insert( $this->_questionsTableName, $fields ) )
        {
            return $this->_db->GetLastInsertedID( );
        }
        else
        {
            return false;
        }
    }
    
    // get number of items loaded from the database
    public function Count( )
    {
        return $this->_db->Count( );
    }
    
    // check if the question has been liked
    public function IsQuestionLiked( $id )
    {
        $user = new User( );
        
        $likeResult = $this->_db->Query( "SELECT * From $this->_questionLikesTableName WHERE questionid = ? AND userid = ? AND type = ?", array( $id, $user->Data( )->id, "like" ) );
        
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
    
    // check if the question has been disliked
    public function IsQuestionDisliked( $id )
    {
        $user = new User( );
        
        $dislikeResult = $this->_db->Query( "SELECT * From $this->_questionLikesTableName WHERE questionid = ? AND userid = ? AND type = ?", array( $id, $user->Data( )->id, "dislike" ) );
        
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
    
    public function LikeQuestion( $id )
    {
        $user = new User( );
        
        if ( !$user->isLoggedIn( ) )
        {
            $this->addError( "Unable to like comment at this time, please try again later." );

            return false;
        }
        
        if ( !$this->GetQuestion( $id ) )
        {
            $this->addError( "Unable to like comment at this time, please try again later." );

            return false;
        }
        
        $dislikeResult = $this->_db->Query( "SELECT * From $this->_questionLikesTableName WHERE questionid = ? AND userid = ? AND type = ?", array( $id, $user->Data( )->id, "dislike" ) );
        
        $fields = array(
            "questionid" => $id,
            "userid" => $user->Data( )->id,
            "timestamp" => time( ),
            "type" => "like"
        );
        
        if ( $dislikeResult->Count( ) ) // remove question dislike
        {
            $id = $dislikeResult->First( )->id;
            
            $this->_db->Delete( $this->_questionLikesTableName, array( "id", "=", $id ) );
            
            $this->_db->insert( $this->_questionLikesTableName, $fields );
        }
        else // like comment
        {
            $likeResult = $this->_db->Query( "SELECT * From $this->_questionLikesTableName WHERE questionid = ? AND userid = ? AND type = ?", array( $id, $user->Data( )->id, "like" ) );
            
            if ( $likeResult->Count( ) ) // remove question like
            {
                $id = $likeResult->First( )->id;
            
                $this->_db->Delete( $this->_questionLikesTableName, array( "id", "=", $id ) );
            }
            else
            {
                $this->_db->insert( $this->_questionLikesTableName, $fields );
            }
        }
    }
    
    public function DislikeQuestion( $id )
    {
        $user = new User( );
        
        if ( !$user->isLoggedIn( ) )
        {
            $this->addError( "Unable to dislike comment at this time, please try again later." );

            return false;
        }
        
        if ( !$this->GetQuestion( $id ) )
        {
            $this->addError( "Unable to dislike comment at this time, please try again later." );

            return false;
        }
        
        $likeResult = $this->_db->Query( "SELECT * From $this->_questionLikesTableName WHERE questionid = ? AND userid = ? AND type = ?", array( $id, $user->Data( )->id, "like" ) );
        
        $fields = array(
            "questionid" => $id,
            "userid" => $user->Data( )->id,
            "timestamp" => time( ),
            "type" => "dislike"
        );
        
        if ( $likeResult->Count( ) ) // remove comment like
        {
            $id = $likeResult->First( )->id;
            
            $this->_db->Delete( $this->_questionLikesTableName, array( "id", "=", $id ) );
            
            $this->_db->insert( $this->_questionLikesTableName, $fields );
        }
        else // like comment
        {
            $disLikeResult = $this->_db->Query( "SELECT * From $this->_questionLikesTableName WHERE questionid = ? AND userid = ? AND type = ?", array( $id, $user->Data( )->id, "dislike" ) );
            
            if ( $disLikeResult->Count( ) ) // remove comment dislike
            {
                $id = $disLikeResult->First( )->id;
            
                $this->_db->Delete( $this->_questionLikesTableName, array( "id", "=", $id ) );
            }
            else
            {
                $this->_db->insert( $this->_questionLikesTableName, $fields );
            }
        }
    }
    
    // counts how many times a question has been liked
    public function CountQuestionLikes( $id )
    {
        $likesResult = $this->_db->Query( "SELECT * From $this->_questionLikesTableName WHERE questionid = ? AND type = ?", array( $id, "like" ) );
        
        return $likesResult->Count( );
    }
    
    // counts how many times a question has been disliked
    public function CountQuestionDislikes( $id )
    {
        $dislikeResult = $this->_db->Query( "SELECT * From $this->_questionLikesTableName WHERE questionid = ? AND type = ?", array( $id, "dislike" ) );
        
        return $dislikeResult->Count( );
    }
    
    // count how many times a question has been liked minus the dislikes
    public function CountQuestionOverallLikes( $id )
    {
        return $this->CountQuestionLikes( $id ) - $this->CountQuestionDislikes( $id );
    }
}