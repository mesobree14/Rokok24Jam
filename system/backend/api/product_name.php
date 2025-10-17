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
     if($_SERVER['REQUEST_METHOD'] == "GET"){
        $sql_get = "SELECT name_product.id_name,name_product.product_name,name_product.price,name_product.price_center,name_product.count_cord,name_product.shipping_cost, SUM(stock_product.count_cord) as countcord_product
          FROM name_product LEFT JOIN stock_product ON name_product.id_name = stock_product.product_name 
          GROUP BY name_product.id_name,name_product.product_name";
        $query = mysqli_query($conn,$sql_get);
        $num_rows = mysqli_num_rows($query);
        if($num_rows > 0){
          $get_productlist = array();
          foreach($query as $list_data){
            $get_productlist[] = $list_data;
          }
          header('Content-Type: application/json');
          print json_encode(array(
                'status'=> 201,
                'message'=> 'get data is success',
                'data'=> $get_productlist
              ));
              mysqli_close($conn);
        }else{
          print json_encode(array(
               'status'=> 201,
               'message'=> 'get data is success',
               'data'=> []
             ));
        }
     }
?>