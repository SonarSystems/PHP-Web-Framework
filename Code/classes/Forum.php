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
            $_sections;
    
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
    
    private function LoadSections( )
    {
        $sectionResults = $this->_db->Query( "SELECT * From $this->_sectionsTableName" );
        
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
    
    public function GetSections( $forceLoad = true )
    {
        // force loads/retrieves the comments from the database
        if ( $forceLoad )
        {
            $this->LoadSections( );
        }
        
        // check if comments exist for the requested id
        if ( $this->Count( ) )
    	{
    		return $this->_sections;
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