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
}