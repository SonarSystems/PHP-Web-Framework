<?php

namespace Sonar;

require_once( "Config.php" );
require_once( "Error.php" );
require_once( "User.php" );

class Blog extends __Error
{
    private $_db,
            $_postsTableName,
            $_commentsTableName,
            $_blogPosts;
    
    public function __construct( )
    {
        if ( Config::get( "mysql/enabled" ) )
        {
            $this->_db = DB::getInstance( );
            
            $this->_postsTableName = Config::get( "blog/blogPostsTableName" );
            $this->_commentsTableName = Config::get( "blog/blogCommentsTableName" );
        }
    }
    
    // Insert a blog post
    public function InsertPost( $title, $highlight, $body )
    {
        $user = new User( );
        
        if ( !$user->IsLoggedIn( ) )
        {
            $this->addError( "Unable to post at this time, please try again later." );

            return false;
        }
        else if ( !$user->IsAdmin( $user->Data( )->username ) )
        {
            $this->addError( "Unable to post at this time, please try again later." );

            return false;
        }
        
        $fields = array(
            "title" => base64_encode( $title ),
            "highlight" => base64_encode( $highlight ),
            "body" => base64_encode( $body ),
            "timestamp" => time( ),
        );

        if ( $this->_db->insert( $this->_postsTableName, $fields ) )
        {
            return true;
        }
        else
        {
            $this->addError( "Unable to post at this time, please try again later." );
            
            return false;
        }
    }
    
    // Get all the blog posts
    public function GetAllPosts( $order, $forceLoad = true )
    {
        if ( "desc" !== strtolower( $order ) && "asc" !== strtolower( $order ) )
        {
            $order = "asc";
        }
        
        // force loads/retrieves the blog posts from the database
        if ( $forceLoad )
        {
            $this->_db->Query( "SELECT * From $this->_postsTableName ORDER BY timestamp $order" );

            if ( $this->_db->Count( ) )
            {
                $this->_blogPosts = $this->_db->Results( );
            }
            else
            {
                return false;
            }            
        }
        
        return $this->_blogPosts;
    }
}