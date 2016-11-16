<?php

namespace Sonar;

require_once( "Config.php" );

class DB
{
    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0,
            $_lastInsertedId;
    
    private function __construct( )
    {
        try
        {
            if ( Config::Get( "mysql/enabled" ) )
            {
                $this->_pdo = new \PDO( "mysql:host=".Config::Get( 'mysql/host' ).";dbname=".Config::Get( 'mysql/dbName' )."", Config::Get( 'mysql/username' ), Config::Get( 'mysql/password' ) );
            }
            
            // set the PDO error mode to exception
            //$this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch( PDOException $error )
        {
            die( "Connection failed: " . $error->GetMessage( ) );
        }
    }
    
    public static function GetInstance( )
    {
        if ( !isset( self::$_instance ) )
        {
            self::$_instance = new DB( );
        }
        
        return self::$_instance;
    }
    
    /*
    *   Example Call
    *   DB::getInstance( )->query( "SELECT * From TableName WHERE id = ?", array( '18' ) );
    */
    public function Query( $sql, $params = array( ) )
    {
        $this->_error = false;
        
        if ( $this->_query = $this->_pdo->prepare( $sql ) )
        {
            $x = 1;
            
            if ( count( $params ) )
            {
                foreach( $params as $param )
                {
                    $this->_query->bindValue( $x, $param );
                    $x++;
                }
            }
            
            if ( $this->_query->execute( ) )
            {
                $this->_results = $this->_query->fetchAll( \PDO::FETCH_OBJ );
                $this->_count = $this->_query->rowCount( );
            }
            else
            {
                $this->_error = true;
            }
        }
        
        return $this;
    }
    
    /*
    *   Example Call
    *   DB::getInstance( )->query( "SELECT *", "TableName", array( "id", "=", "3" ) );
    */
    public function Action( $action, $table, $where = array( ) )
    {
        if ( 3 === count( $where ) )
        {
            $operators = array( '=', '>', '<', '>=', '<=' );
            
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            
            if ( in_array( $operator, $operators ) )
            {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                
                if ( !$this->Query( $sql, array( $value ) )->Error( ) )
                {
                    return $this;
                }
            }
        }
        
        return false;
    }
    
    /*
    *   Example Call
    *   DB::getInstance( )->get( "TableName", array( "id", "=", "3" ) );
    */
    public function Get( $table, $where )
    {
        return $this->Action( 'SELECT *', $table, $where );
    }
    
    public function GetLastInsertedID( )
    {
        return $this->_lastInsertedId;
    }
    
    /*
    *   Example Call
    *   DB::getInstance( )->delete( "TableName", array( "id", "=", "3" ) );
    */
    public function Delete( $table, $where )
    {
        return $this->Action( 'DELETE', $table, $where );
    }
    
    /*
    *   Example Call
    *   DB::getInstance( )->insert( "TableName", array(
    *   "username" => "newusername",
    *   "password" => "newpassword"
    *   ) );
    */
    public function Insert( $table, $fields = array( ) )
    {
        if ( count( $fields ) )
        {
            $keys = array_keys( $fields );
            $values = null;
            $x = 1;
            
            foreach( $fields as $field )
            {
                $values .= "?";
                
                if ( $x < count( $fields ) )
                {
                    $values .= ', ';
                }
                
                $x++;
            }
            
            $sql = "INSERT INTO {$table} (`" . implode( '`, `', $keys ) . "`) VALUES ({$values})";
            
            if ( !$this->Query( $sql, $fields )->Error( ) )
            {
                $this->_lastInsertedId = $this->_pdo->lastInsertId();
                
                return true;
            }
        }
        
        return false;
    }
    
    /*
    *   Example Call
    *   DB::getInstance( )->update( "TableName", 3, array(
    *   "username" => "newusername",
    *   "password" => "newpassword"
    *   ) );
    *
    *   ASSUMES the tables PRIMARY key is called 'id'
    */
    public function Update( $table, $id, $fields )
    {
        $set = '';
        $x = 1;
        
        foreach( $fields as $name => $value )
        {
            $set .= "{$name} = ?";
            
            if ( $x < count( $fields ) )
            {
                $set .= ', ';
            }
            
            $x++;
        }
                
        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        
        if ( !$this->Query( $sql, $fields )->Error( ) )
        {
            return true;
        }
        
        return false;
    }
    
    public function Results( )
    {
        return $this->_results;
    }
    
    public function First( )
    {
        return $this->Results( )[0];
    }
    
    public function Error( )
    {
        return $this->_error;
    }
    
    public function Count( )
    {
        return $this->_count;
    }
}