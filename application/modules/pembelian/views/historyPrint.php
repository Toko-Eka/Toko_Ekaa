histor<html>
<head>
  <title>Cetak Laporan Pembelian</title>
  <style>
    .table {
        border-collapse:collapse;
       width:100%;
    }
    .table th,td {
      padding: 8px;
  text-align: left;
  border-bottom: 1px solid black;
    }
  
    .num{
      text-align: right;
    }
    @page {
      size: lanscape;
        margin: 15px;
    }
    body, h1, h2, h3, h4, h5, h6  {
  font-family: "Segoe UI", Arial, sans-serif;
}
  </style>
</head>
<body>
    <h4 style="margin-bottom: 5px;">Laporan Transaksi Pembelian</h4>
  <?php echo $label ?>
  <table class="table"  width="100%"d style="margin-top: 5px;">
    <tr>
    <th style="width: 3%;">No</th>
      <th style="width: 15%;">Tanggal</th>
      <th style="width: 15%;">Kode Transaksi</th>
      <th style="width: 8%;">Status</th>
      <th style="width: 6%;">Kasir</th>
   
      <th style="width: 6%;">Total Qty</th>
      <th style="width: 10%;">Total</th>
     

      <!-- <th>Total Harga</th> -->
    </tr>
    <?php
        if(empty($transak)){ // Jika data tidak ada
            echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
        }else{ // Jika jumlah data lebih dari 0 (Berarti jika data ada)
            $count = 1;
  $sub=0;
  error_reporting(0);
$group = array();
            foreach($transak as $data){ // Looping hasil data transaksi
        
              $group[$data->notaa][] = $data;
              var_dump($group);
                $tgl = date('d-m-Y', strtotime($data->tgll)); // Ubah format tanggal jadi dd-mm-yyyy
                echo "<tr>";
                echo "<td style='width: 40px;'>".$count++."</td>";
                echo "<td style='width: 80px;'>".$tgl."</td>";
               

 
                echo "<td style='width: 100px;'>".$data->notaa."</td>";
                 
            $unpaid = '';
            if ($data->paidd == 0) {
                $unpaid = 'Belum Dibayar';
            } else {
                $unpaid = 'Sudah Dibayar';
            }

            $row[] = $unpaid;
                echo "<td style='width: 100px;'>".$unpaid."</td>";
                echo "<td style='width: 100px;'>".$data->kasirr."</td>";
                echo "<td style='text-align:right;width: 100px;'>".number_format($data->qty)."</td>";
                echo "<td style='text-align:right;width: 100px;'>".number_format($data->subtotal)."</td>";
                // echo "</tr>";
                //       echo "<tr>";
                //       echo " <th></th>";
                //       echo " <th>Nama Brg</th>";
                //       echo " <th></th>";
                //       echo "</tr>";
                //         echo "<tr>";
                //         echo"<td></td>";
         
            }
          
            $total=0;
            foreach($transak as $val){
              $totalQty +=($val->qty);
              $total +=($val->TOTAL);
          
       
              // $total+= $sum;
            }
              echo "<tr>";
            echo "<td style='text-align:right;width: 100px;'></td>";
            echo "<td style='text-align:right;width: 100px;'></td>";
            echo "<td style='text-align:right;width: 100px;'></td>";
            echo "<td style='text-align:right;width: 100px;'></td>";
            echo "<td style='text-align:right;width: 100px;'></td>";
            echo "<td style='text-align:right;width: 100px;'>".number_format($totalQty)."</td>";
          
            echo "<td style='text-align:right;width: 100px;'>".number_format($total)."</td>";
       
          
          }
          
    ?>
  </table>
</body>
</html>
<script>
   function number_format (number, decimals, decPoint, thousandsSep) { 
      number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
      var n = !isFinite(+number) ? 0 : +number
      var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
      var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
      var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
      var s = ''

      var toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec)
        return '' + (Math.round(n * k)/k)
          .toFixed(prec)
      }

      // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
      }
      if ((s[1] || '').length < prec) {
        s[1] = s[1] || ''
        s[1] += new Array(prec - s[1].length + 1).join('0')
      }

      return s.join(dec)
}
</script>