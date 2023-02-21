<?php

 session_start();
    require_once( "../Lib/lib.php" );
   require_once( "../Lib/db.php" );
    
 
    
if (isset($_GET['hash'])){
    $hash = $_GET['hash'];
    
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    $insertQuery = "SELECT isActive, user_hash FROM `smi`.`user_table` WHERE isActive=0 AND user_hash ='$hash' LIMIT 1";
    $insert=mysqli_query( $GLOBALS['ligacao'], $insertQuery );
    
    if($insert->num_rows==1){
        //validate
        $updateQuery = "UPDATE `smi`.`user_table` set isActive=1 WHERE user_hash ='$hash' LIMIT 1";
        $update=mysqli_query( $GLOBALS['ligacao'], $updateQuery );
        
        if($update){
            echo"Your account has been veriefied.";
            
        }else{
            echo"ERROR";
        }
        
    }else{
        echo("This account is invalid or alredy verified");
    }
    
    
    
}else{
    die("SOMETHING WRONG");
}

?>
<html>
    <head>
      
    </head>
    <body>
      <p class="loginhere">
                            You can login now!
                            <a href="TemplateLogIn.php" class="loginhere-link">Login here</a>
                        </p>
    </body>
</html>

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 
