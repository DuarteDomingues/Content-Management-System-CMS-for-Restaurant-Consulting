<!DOCTYPE html>
<?php

   require_once( "../Lib/lib.php" );
   require_once( "../Lib/db.php" );
    
    
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    /*
    $insertQuery = "INSERT INTO user_table (auth_role_id, name, nationality,birthdate,gender,email,user_hash,isActive)\n"

    . "                    VALUES (1, \'Doe\', \'bronzil\',\'100\',1,\"@gmail.com\",\"32323232\",0)";
    
    
    $insert=mysqli_query( $GLOBALS['ligacao'], $insertQuery );*/
    
    session_start();

    
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $password = $_POST['password'];
  
        echo $username;
    echo "<br>";
    echo $gender;
    echo "<br>";
    echo $birthday;
    echo "<br>";
    echo $email;
    echo "<br>";
    echo $password;
    
    /*
    $insertQuery = "INSERT INTO user_table (auth_role_id, name, nationality,birthdate,gender,email,user_hash,isActive)\n"

    . "                    VALUES (1, \'$username\', \'bronzil\',\'$birthday\',$gender,\"$email\",\"32323232\",0)";
    */
    
    $sql = "INSERT INTO `smi`.`user_table` (auth_role_id, name, nationality,birthdate,gender,email,user_hash,isActive,pass) \n"

    . "VALUES (1, \'Doe\', \'bronzil\',\'2021-06-08\',1,\"@gmail.com\",\"32323232\",0,\"pass\")";
    
    
    $insert=mysqli_query( $GLOBALS['ligacao'], $sql );

?>
