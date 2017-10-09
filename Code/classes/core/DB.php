<?php

namespace Sonar;

require_once( "Config.php" );

if ( Config::Get( "mysql/dbBackup" ) )
{
    require_once( "../libs/DBBackup/db.backup.class.php" );
}

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
    
    // Get the singleton instance of this class
    public static function GetInstance( )
    {
        if ( !isset( self::$_instance ) )
        {
            self::$_instance = new DB( );
        }
        
        return self::$_instance;
    }
    
    /*
    *   Run a raw SQL query
    *   Example Call
    *   DB::getInstance( )->Query( "SELECT * From TableName WHERE id = ?", array( '18' ) );
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
    *   Run a defined action
    *   Example Call
    *   DB::getInstance( )->Action( "SELECT *", "TableName", array( "id", "=", "3" ) );
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
    *   Select data call
    *   Example Call
    *   DB::getInstance( )->Get( "TableName", array( "id", "=", "3" ) );
    */
    public function Get( $table, $where )
    {
        return $this->Action( 'SELECT *', $table, $where );
    }
    
    // Get the ID of the last insert into the database
    public function GetLastInsertedID( )
    {
        return $this->_lastInsertedId;
    }
    
    /*
    *   Delete a row
    *   Example Call
    *   DB::getInstance( )->Delete( "TableName", array( "id", "=", "3" ) );
    */
    public function Delete( $table, $where )
    {
        return $this->Action( 'DELETE', $table, $where );
    }
    
    /*
    *   Insert a row
    *   Example Call
    *   DB::getInstance( )->Insert( "TableName", array(
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
    *   Update a row
    *   Example Call
    *   DB::getInstance( )->Update( "TableName", 3, array(
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
    
    // Get the data from the last successful database call
    public function Results( )
    {
        return $this->_results;
    }
    
    // Get the first item from the the data
    public function First( )
    {
        return $this->Results( )[0];
    }
    
    // Get any errors
    public function Error( )
    {
        return $this->_error;
    }
    
    // Get the count of the number of rows retrieved
    public function Count( )
    {
        return $this->_count;
    }
    
    // Remove all results
    public function Flush( )
    {
        $this->_results = null;
    }
    
    /*
    *   Exports the entire Database into an SQL file in the public directory
    *   Example Call
    *   DB::getInstance( )->Backup( "Location/Filename");
    */
    public function Backup( $saveLocation )
    {
        $dbBackup = new \DBBackup( array
        (
            'driver' => 'mysql',
            'host' => Config::Get( "mysql/host" ),
            'user' => Config::Get( "mysql/username" ),
            'password' => Config::Get( "mysql/password" ),
            'database' => Config::Get( "mysql/dbName" )
        ) );
        
        $backup = $dbBackup->backup( );
        
        if( !$backup['error'] )
        {
            $filepath = fopen( $saveLocation . ".sql", 'w+' );
            fwrite( $filepath, $backup['msg']);
            fclose( $filepath );
            
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /*
    *   Downloads the Database backup
    *   Example Call
    *   DB::getInstance( )->DownloadBackup( "Location/Filename");
    */
    public function DownloadBackup( $location )
    {
        $location .= ".sql";
        
        header( 'Content-Description: File Transfer' );
        header( 'Content-Type: application/octet-stream' );
        header( 'Content-Disposition: attachment; filename=' . basename( $location ) );
        header( 'Content-Transfer-Encoding: binary' );
        header( 'Expires: 0' );
        header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
        header( 'Pragma: public' );
        header( 'Content-Length: ' . filesize( $location ) );
        
        ob_clean( );
        flush( );
        readfile( $location );
    }
}