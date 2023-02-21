<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 require_once( "../Lib/lib.php" );
   require_once( "../Lib/db.php" );
    
    
dbConnect( ConfigFile );
$dataBaseName = $GLOBALS['configDataBase']->db;
mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    

function getUserNameById($id){
    
    $query = "select `name` from `user_table` where `userId` = $id ";
    $insert=mysqli_query( $GLOBALS['ligacao'], $query );
    $username = "";
    
      while($row = $insert->fetch_assoc()) {
          
          $username =$row["name"];
          
          
      }

    return  $username ;
    
    
    
    
}

function avgRatingRestaurant($id){
    
    $query = "SELECT avg(`class`) FROM `comment` WHERE `restaurant_id` = $id";
    $insert=mysqli_query( $GLOBALS['ligacao'], $query );
    $avg = 0;
    
    while($row = $insert->fetch_assoc()) {
        
        if ($row["avg(`class`)"]!=null){
            
            $avg =$row["avg(`class`)"];
        }          
          
      }
return  $avg;
    
   
}



function checkUserCommented($userId,$resId){
    
    $query = "select count(`text`) from `comment` where `user_id` = $userId AND `restaurant_id`= $resId ";
    $insert=mysqli_query( $GLOBALS['ligacao'], $query );
    $c = 0;
    
      while($row = $insert->fetch_assoc()) {
        
        if ($row["count(`text`)"]!=0){
            
            $c =$row["count(`text`)"];
        }          
          
      }
return  $c;
    
  
}


function insertFavoriteRestaurant($restaurantId, $userId){
    
   $query =  "insert into `user_favorite_restaurant`(`restaurant_id`,`user_id`) values ($restaurantId,$userId) ";
   $insert=mysqli_query( $GLOBALS['ligacao'], $query );

 
}

function checkIfRestaurantFavorite($restaurantId, $userId){
    
    $query = "SELECT count(`restaurant_id`) from `user_favorite_restaurant` where `restaurant_id`=$restaurantId and `user_id`=$userId ";
     $insert=mysqli_query( $GLOBALS['ligacao'], $query );
    $c = 0;
     while($row = $insert->fetch_assoc()) {
        
        if ($row["count(`restaurant_id`)"]!=0){
            
            $c =$row["count(`restaurant_id`)"];
        }          
          
      }
return  $c;
    
}


function getUserAuthRole($userId){
    
    $query = "select `auth_role_id` from `user_table` where `userId` = $userId ";
    $insert=mysqli_query( $GLOBALS['ligacao'], $query );
    $roleType = 0;
    
    while($row = $insert->fetch_assoc()) {
        
        $roleType = $row["auth_role_id"];
        
        

    }
    
    return $roleType;
    
    
    
    
    
    
}




