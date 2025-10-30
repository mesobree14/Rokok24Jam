<?php

  include_once("../../../backend/config.php");
  if(!$conn){
    die("not conn");
    
  }
   header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");	
   header("Cache-Control: post-check=0, pre-check=0", false);	
    header("Pragma: no-cache");
    date_default_timezone_set("Asia/Bangkok");
    if($_SERVER['REQUEST_METHOD'] === "GET"){
      $sql_select = "SELECT * FROM peple_groups ORDER BY create_at DESC";
      $query_ql = mysqli_query($conn,$sql_select)or die(mysqli_error($conn));
      $data_res = [];
      while($row = mysqli_fetch_assoc($query_ql)){
        $data_res[] = $row;
      }
      print json_encode([
        'status'=> 201,
        'message' => 'get api customer is success',
        'data' => $data_res
      ],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
      mysqli_close($conn);
    }
?>