<?php

namespace Sonar;

require_once( "Config.php" );
require_once( "Error.php" );

class Image extends __Error
{
    private $_giphyJSONResult,
            $_multipleResults;
    
    public function __construct( )
    {
        $this->_giphyJSONResult = NULL;
        $this->_multipleResults = true;
    }
    
    // formats the search query so it works with GIPHY's api
    private function FormatSearchQuery( $searchQuery )
    {
        $searchQuery = trim( $searchQuery );
        $searchQuery = preg_replace( '/\s+/', '+', $searchQuery );
        
        return $searchQuery;
    }
    
    // generic GIF search
    public function GifSearch( $searchQuery, $limit = 5 )
    {
        $searchQuery = $this->FormatSearchQuery( $searchQuery );
        
        $this->_giphyJSONResult = json_decode( file_get_contents( "http://api.giphy.com/v1/gifs/search?q=$searchQuery&api_key=".Config::get( "image/keys/giphy/apiKey" )."&limit=$limit" ) );
        
        $this->_multipleResults = true;
            
        return $this->_giphyJSONResult;
    }
    
    // get trending GIF's
    public function GifTrendingSearch( $limit = 5 )
    {        
        $this->_giphyJSONResult = json_decode( file_get_contents( "http://api.giphy.com/v1/gifs/trending?api_key=".Config::get( "image/keys/giphy/apiKey" )."&limit=$limit" ) );
        
        $this->_multipleResults = true;
            
        return $this->_giphyJSONResult;
    }
    
    // get random GIF's
    public function GifRandomSearch( $tag = "" )
    {        
        $this->_giphyJSONResult = json_decode( file_get_contents( "http://api.giphy.com/v1/gifs/random?api_key=".Config::get( "image/keys/giphy/apiKey" )."&tag=$tag" ) );
        
        $this->_multipleResults = false;
            
        return $this->_giphyJSONResult;
    }
    
    // get a decoded JSON array of the last successful GIPHY search
    public function GetAllGifResults( )
    {
        if ( NULL === $this->_giphyJSONResult )
        {
            return false;
        }
        else
        {
            return $this->_giphyJSONResult;
        }
    }
    
    public function GetAllGifURLs( $size = "original" )
    {
        if ( NULL === $this->_giphyJSONResult )
        {
            return false;
        }
        
        $size = trim( strtolower( $size ) );
        
        if ( "small" === $size )
        {
            $size = "100";
        }
        else
        {
            $size = "giphy";
        }
        
        $gifURLs = array( );
        
        if ( $this->_multipleResults )
        {
            foreach ( $this->_giphyJSONResult->data as $image )
            {   
                array_push( $gifURLs, "https://media1.giphy.com/media/$image->id/$size.gif" );
            }
        }
        else
        {
            $image = $this->_giphyJSONResult->data;
            
            array_push( $gifURLs, "https://media1.giphy.com/media/$image->id/$size.gif" );
        }
        
        return $gifURLs;
    }
}