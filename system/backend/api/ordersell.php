<?php

include_once("../../../backend/config.php");
  if(!$conn){
    die("not conn");
    
  }
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");	
   header("Cache-Control: post-check=0, pre-check=0", false);	
    header("Pragma: no-cache");
    date_default_timezone_set("Asia/Bangkok");
    if($_SERVER['REQUEST_METHOD'] == "GET"){
      $id_ordersell = $_GET['ordersell_id'];
      
      $query_product = mysqli_query($conn,
      "SELECT OS.id_ordersell,OS.ordersell_name,OS.is_totalprice,OS.custome_name,OS.date_time_sell,OS.sell_idpeplegroup,OS.slip_ordersell,
        OS.count_totalpays,OS.count_stuck,OS.adder_id,OS.create_at,ST.list_typepay,ST.typepay_id,ST.ordersell_id,PG.name_peplegroup
        FROM orders_sell OS 
        LEFT JOIN sell_typepay ST ON OS.id_ordersell = ST.ordersell_id 
        LEFT JOIN peple_groups PG ON OS.sell_idpeplegroup = PG.id_peplegroup 
        WHERE id_ordersell=$id_ordersell");
      $num_row = mysqli_num_rows($query_product);

      $count_query = mysqli_query($conn, "SELECT COUNT(*) AS count, SUM(tatol_product) AS totalproduct FROM list_productsell WHERE ordersell_id='$id_ordersell'");
      $count_row = mysqli_fetch_assoc($count_query);

      $res_acc = [];
      while($row = mysqli_fetch_assoc($query_product)){
        $res_acc[] = $row;
      }
      $order = null;
      $sell_type = [];
      foreach($res_acc as $rows){
        if(!$order){
          $order = [
            'id_ordersell' => $rows['id_ordersell'],
            'ordersell_name' => $rows['ordersell_name'],
            'is_totalprice' => $rows['is_totalprice'],
            'sell_idpeplegroup' => $rows['sell_idpeplegroup'],
            'custome_name' => $rows['custome_name'],
            //'tell_custome' => $rows['tell_custome'],
            'date_time_sell' => $rows['date_time_sell'],
            //'shipping_note' => $rows['shipping_note'],
            'count_totalpays' => $rows['count_totalpays'],
            'count_stuck' => $rows['count_stuck'],
            //'sender' => $rows['sender'],
            //'tell_sender' => $rows['tell_sender'],
            //'location_send' => $rows['location_send'],
            //'wages' => $rows['wages'],
            //'reason' => $rows['reason'],
            'slip_ordersell' => $rows['slip_ordersell'],
            'adder_id' => $rows['adder_id'],
            'create_at' => $rows['create_at'],
            'countproduct' => $count_row['count'],
            'totalproduct' => $count_row['totalproduct'],
            'name_peplegroup' => $rows['name_peplegroup']
          ];
        }
        $sell_type[] = [
          'typepay_id' => $rows['typepay_id'],
          'ordersell_id' => $rows['ordersell_id'],
          'list_typepay' => $rows['list_typepay'],
        ];
      }

      $result = [
        'orersell' => $order,
        'sell_type' => $sell_type
      ];
      header('Content-Type: application/json');
        print json_encode([
          'status'=> 201,
          'message'=> 'get data is success',
          'data'=> $result
        ],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        mysqli_close($conn);

    }

?>