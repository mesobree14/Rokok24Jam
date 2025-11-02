<?php

  include_once("../../../backend/config.php");
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  if(!$conn){
    die("not conn");
  }
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");	
   header("Cache-Control: post-check=0, pre-check=0", false);	
    header("Pragma: no-cache");
    date_default_timezone_set("Asia/Bangkok");
    if($_SERVER['REQUEST_METHOD'] === "GET"){
      $sql = "SELECT COUNT(*) AS total_lot FROM order_box";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();

      $next = $row['total_lot'] + 1;
      $lot_code = 'LOT-A' . str_pad($next, 4, '0', STR_PAD_LEFT);
      echo json_encode(['lot_code' => $lot_code]);
    }

?>