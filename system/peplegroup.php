<?php
session_name("session_rokok");
  session_start();
include_once("../backend/config.php");
include_once("../link/link-2.php");
include_once("../components/component.php");
error_reporting(E_ALL);
  ini_set('display_errors', 1);
if(!isset($_SESSION['users_data'])){
  echo "
          <script>
              alert('pless your login');
              window.location = '../index.php';
          </script>
      ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/css/uikit.css">
    <link rel="stylesheet" href="../assets/scripts/module/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
    <link rel="stylesheet" href="../assets/scss/navigationTrue-a-j.scss">
    <link rel="stylesheet" href="../assets/scss/revenue.scss">
    <link rel="stylesheet" href="../assets/scripts/module/test/test.scss">
    <script src="../assets/scripts/module/test/test.js"></script>
    <script src="../assets/scripts/script-bash.js"></script>
    <link rel="stylesheet" href="../assets/scripts/module/select-picker/select.scss">
  <title>Document</title>
</head>
<body>
  <div class="page-wrapper chiller-theme toggled">
    <?php  navigationOfiicer(); ?>
    <main class="page-content mt-0">
      <?php navbar("ข้อมูลสมาชิก"); ?>
      <div class="container-fluid row">
        <div class="ml-auto">
            <button class="bd-none au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" 
                data-target="#modalFormPepleGroup" id="openModalFormPepleGroup"
            >
                <i class="fa-solid fa-user-plus"></i>
                  เพิ่มข้อมูลสมาชิก
            </button>
          </div>
        <div class="col-12 row mt-2">
          <div class="col-lg-12 col-xl-11 border-right">
            <div class="table-responsive table-responsive-data2 mt-2">
                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th style="width:30%">ชื่อสมาชิก</th>
                            <th style="width:12%">จำนวนครั้งที่ขาย</th>
                            <th style="width:15%">รายได้ทั้งหมดที่ขาย</th>
                            <th style="width:15%">กำไรที่ขายได้</th>
                            <th style="width:13%">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        // $get_peplegroup = "SELECT 
                        //   PG.id_peplegroup,PG.name_peplegroup,PG.phone_group,PG.status_group,
                        //   COALESCE(OS_SUM.itemcount, 0)AS item_count,
                        //   COALESCE(OS_SUM.totalprice, 0)AS total_prices
                        //   FROM peple_groups PG 
                        //   LEFT JOIN (
                        //     SELECT sell_idpeplegroup,COUNT(DISTINCT id_ordersell) AS itemcount,SUM(is_totalprice) AS totalprice FROM orders_sell GROUP BY sell_idpeplegroup
                        //   ) OS_SUM ON OS_SUM.sell_idpeplegroup = PG.id_peplegroup
                        //   LEFT JOIN (
                        //     SELECT OS_SUM.sell_idpeplegroup, SUM(tatol_product) AS total_product
                        //     FROM (
                        //     SELECT ordersell_id, COUNT(*) AS productcount,sell_idpeplegroup FROM list_productsell
                        //     )
                        //   )";
                        // $query_peplegroup = mysqli_query($conn,$get_peplegroup);
                        // foreach($query_peplegroup as $key => $res){
                        //   listPepleGroup($key+1,$res['id_peplegroup'],$res['name_peplegroup'],$res['phone_group'],$res['status_group'],$res['item_count'],$res['total_prices'],0);
                        // }
                        $get_peplegroup = "SELECT id_peplegroup,name_peplegroup,phone_group,status_group FROM peple_groups";
                        $query_peplegroup = mysqli_query($conn,$get_peplegroup);
                        foreach($query_peplegroup as $key => $res){
                          listPepleGroup($key+1,$res['id_peplegroup'],$res['name_peplegroup'],$res['phone_group'],$res['status_group'],0,0,0);
                        }

                      ?>
                    </tbody>
                </table>
            </div>
          </div>

        </div>
      </div>
      <main-form-peplegroup></main-form-peplegroup>
    </main>
  </div>
  <script src="../assets/scripts/ui-peplegroup.js"></script>
</body>
</html>