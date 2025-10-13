<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../../../vendor/autoload.php';
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

if (!class_exists(\Mpdf\Mpdf::class)) {
    die("mPDF ไม่เจอ ลองเช็ค path vendor/autoload.php");
}

$mpdf = new \Mpdf\Mpdf([
  'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/../../../font',
    ]),
    'fontdata' => $fontData + [
        'thsarabunnew' => [
            'R' => 'THSarabunNew.ttf',
            'B' => 'THSarabunNew-Bold.ttf',
            'I' => 'THSarabunNew-Italic.ttf',
            'BI' => 'THSarabunNew-BoldItalic.ttf',
        ]
    ],
    'default_font' => 'thsarabunnew',
    'tempDir' => __DIR__ . '/../../../tmp',
    'mode' => 'utf-8',
    'format' => [140, 190],
    'margin_left' => 5,
    'margin_right' => 5,
    'margin_top' => 5,
]);

$svgqr = file_get_contents(__DIR__ . '/../../../db/QR-code.svg');

$conn = new mysqli("localhost", "root", "", "rokok_stock");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_id = $_GET['order_id'];
$sql_query = $conn->query("SELECT * FROM order_box WHERE order_id=$order_id");
$order = $sql_query->fetch_assoc();
$sql_product = $conn->query("SELECT product_name,product_count,product_price,expenses,id_order FROM stock_product WHERE id_order=$order_id");
$sql_count = $conn->query("SELECT COUNT(*) AS total, SUM(product_count) AS product_count, SUM(expenses) AS count_expenses FROM stock_product WHERE id_order=$order_id");
$count_rows = $sql_count->fetch_assoc();

$html =' 
<style>
  body { font-family: "THSarabunNew"; font-size: 14pt; }
.component {
    width: 100%;
    font-family: "THSarabunNew";
    font-size: 14pt;
    margin-bottom: 1px;
    overflow: hidden; /* เคลียร์ float */
}
.left {
    float: left;
    width: 57%;
    padding: 4px;
    box-sizing: border-box;
}
.right {
    float: right;
    width: 40%;
    box-sizing: border-box;
    
}

.left-qr {
    float: left;
    width: 30%;
    padding-top: 14px;
    box-sizing: border-box;
}
.right-qr {
    float: right;
    width: 70%;
    box-sizing: border-box;
    
}

.left-custom {
    float: left;
    width: 47%;
    padding: 4px;
    box-sizing: border-box;
}
.right-custom {
    float: right;
    width: 50%;
    box-sizing: border-box;
}

.doc {
    width: 100%;
    overflow: hidden;
    margin-left: 10px;
}
.doc span.label {
    float: left;
    font-weight: 900;
}
.doc span.value {
    float: right;
}

  table.slip-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
  }
  table.slip-table th,
  table.slip-table td {
    border: 1px solid #000;
    padding: 6px;
    text-align: center;
  }

  table.slip-table th.name,
  table.slip-table td.name {
    width: 35%;
    text-align: left;
  }

  table.slip-table th.price,
  table.slip-table td.price,
  table.slip-table th.qty,
  table.slip-table td.qty,
  table.slip-table th.total,
  table.slip-table td.total {
    width: 15%;
  }
  .footer {
    font-size:20px;
    font-weight: bold;
    margin-top:5px;
  }
</style>';

$html .='
<div>
  <div class="" style="">
    <div style="float: left; width: 55%; margin-left:5px">
      <img src="../../../assets/img/Jbox-logo.jpg" width="40" height="40" />
    </div>
    <div style="float: right; width: 40%;">
      <h3 style="text-align: right;">ใบเสร็จคำสั่งซื้อ</h3>
    </div>
  </div>
  <div style="width:100%">
    <div class="component">
        <div class="left">
          <div class="doc">
              <b class="label" style="font-size:17px;">ผู้ออกใบเสร็จ :</b>
              <small class="value">JBok จำหน่ายกล่องพัศดุราคาโรงงาน</small>
          </div>
          <div class="doc">
              <b class="label" style="font-size:17px;">เบอร์โทร :</b>
              <small class="value">081-189-9578</small>
          </div>
        </div>
        <div class="right" style="background-color:#ffb3ff;">
          <div class="doc">
              <b class="label" style="font-size:17px;">รหัสคำสั่งซื้อ :</b>
              <small class="value">'.$order['order_name'].'</small>
          </div>
          <div class="doc">
              <b class="label" style="font-size:17px;">วันที่ออก :</b>
              <small class="value">'.$order['date_time_order'].'</small>
          </div>
        </div>
    </div>
  </div>
  <div style="height: 150px;">
    <table class="slip-table">
      <thead>
        <tr style="background-color:#ffb3ff;">
          <th class="name">รายการสินค้า</th>
          <th class="price">ราคาต้นทุนต่อชิ้น</th>
          <th class="qty">จำนวน</th>
          <th class="total">ราคารวม</th>
        </tr>
      </thead>
    ';
  $x = 1;
  while($rows = $sql_product->fetch_assoc()){
    $html .= "
    <tr>
        <td class=\"name\">{$rows['product_name']}</td>
        <td class=\"price\">".number_format($rows['product_price'] ?? 0,2,'.',',')."</td>
        <td class=\"qty\">{$rows['product_count']}</td>
        <td class=\"total\">".number_format($rows['expenses'] ?? 0,2,'.',',')."</td>
      </tr>
  ";
  }
$html .= '
      <tbody>
      </tbody>
    </table>
  </div>
  <b class="footer">รวม</b>
  <table style="width:100%;border:1px solid gray;">
      <tr>
        <td class="" style="width:50%;border:none;">
          <b>'.$count_rows['total'].' รายการ</b>
        </td>
        <td class="qty" style="width:25%;border:none;">
          <b>'.$count_rows['product_count'].' ชิ้น</b>
        </td>
        <td class="total" style="width:25%;border:none;">
          <b>'.$count_rows['count_expenses'].' บาท</b>
        </td>
      </tr>
    </table>
</div>
';

$mpdf->WriteHTML($html);
$mpdf->Output();

?>