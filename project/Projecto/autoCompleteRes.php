<?php

require_once( "../Lib/lib.php" );
   require_once( "../Lib/db.php" );
    
  
            
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
      $local=$_POST['name'];
      
      $sql = "SELECT `name` FROM `restaurant_location` INNER JOIN `restaurant` ON `restaurant_location`.`idRestaurant` = `restaurant`.`id`\n"

    . "WHERE `restaurant_location`.`City` LIKE '$local%'";
      
      $resultRes= mysqli_query( $GLOBALS['ligacao'], $sql );
      $arrayRes=array();
     
      while ($row = $resultRes->fetch_assoc()) {
          array_push($arrayRes,$row['name']);
      }
      
      $sqlType = "select * from `type` inner join `restaurant_type` on `type`.`id`=`restaurant_type`.`type_id` \n"

    . "inner join `restaurant_location` on `restaurant_type`.`restaurant_id`=`restaurant_location`.`idRestaurant`\n"

    . "where `City` like  '$local%'";
      
       $resultType= mysqli_query( $GLOBALS['ligacao'], $sqlType );
     
      while ($row = $resultType->fetch_assoc()) {
          array_push($arrayRes,$row['name_type']);
      }
      
    $arrayRes=array_unique($arrayRes);

      
      ?>
        
<script>

      var res = <?php echo '["' . implode('", "', $arrayRes) . '"]' ?>;
      autocomplete(document.getElementById("myInputName"), res);

      
    </script>  
