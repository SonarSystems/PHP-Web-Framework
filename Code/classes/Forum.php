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
            $_categories;
    
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
    
    // get number of items loaded from the database
    public function Count( )
    {
        return $this->_db->Count( );
    }
}