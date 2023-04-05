<html>
<head>
  <title>Laporan Transaksi Penjualan yang belum dibayar per NOTA</title>
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
    <h4 style="margin-bottom: 5px;">Laporan Transaksi Penjualan yang belum dibayar per NOTA</h4>
  <?php echo $label ?>
  <table class="table" width="100%"  style="margin-top: 5px;">
  <tr>
    <th style="width: 5%;">No</th>
<!-- 
      <th style="width: 6%;">Kode Transaksi</th> -->
      <th style="width: 32%;">Nama Barang</th>
      <th style="width: 6%;">Harga</th>

      <th style="width: 5%;">Jumlah</th>
      <th style="width: 10%;">Subtotal</th>
      <!-- <th style="width: 10%;">Total</th> -->

      <!-- <th>Total Harga</th> -->
    </tr>
    <?php
    // error_reporting(0);
        if(empty($transak)){ // Jika data tidak ada
            echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
        }else{ // Jika jumlah data lebih dari 0 (Berart i jika data ada)
          $subtotal = 0;
         
            $nota = array(); // initialize array which will contain the categories
            $sub = array();
            $no = 1;
            $total = 0;
            $totalqty = 0;
   
            $notta = '';
            foreach($transak as $data){ // Looping hasil data transaksi       
         
          
                 if($notta !== $data->NOTA){
                     $notta = $data->NOTA;
                     if($no > 1){
                         echo "<tr>";
                         echo "<td class='num' align='right' colspan=3><b>Subtotal</td>";
                         echo "<td class='num' align='right'><b>".number_format($totalqty, 0, ',', '.')."</td>";
                         echo "<td class='num' align='right'><b>".number_format($total, 0, ',', '.')."</td>";
                         echo "</tr>";
                 
     
                         $total = 0;
                         $totalqty = 0;
                         
                     }
                 } 
                 if(!in_array($data->NOTA, $nota)){ // check if category exists in the array
              
                  $nota[] = $data->NOTA; // insert the value in the array and show it as a heading
              
              
                
          
          ?>
            
                  <tr>
                
                      <td colspan="2" class="td_table" height style="text-align: left;"> NOTA <b># <?= $data->NOTA?> </b></td>
                      <td></td>
                      <td></td>
                      <td></td>
  
             
             
            
                  </tr>
          <?php
                  }
                 $total += $data->TOTAL;
                 $totalqty += $data->JMLBRG;
                echo "<tr>";
                echo "<td class='text' align='center'>".number_format($no,0,',','.')."</td>";
                echo "<td style='width: 500px;'>".$data->NAMABRG."</td>";
                echo "<td style=' text-align: right;'>".number_format($data->HARGA ,0, ',', '.')."</td>";
                echo "<td style='text-align: right;'>".number_format($data->JMLBRG,0, ',', '.')."</td>";
                echo "<td style='text-align: right;'>".number_format($data->TOTAL,0, ',', '.')."</td>";
            
                // $totalQty=0;
                // $total=0;
            
                  // $totalQty +=($data->JMLBRG);
                  // $total +=($data->TOTAL);
                  // echo "<td style='text-align: right;'>".number_format($total)."</td>";
                echo "</tr>";
          //       echo "<tr>";
          //       echo " <th></th>";
          //       echo " <th>NO</th>";
          //       echo " <th>Nama Brg</th>";
          //       echo " <th>HARGA</th>";
          //       echo " <th>JUMLAH</th>";
          //       echo " <th>SUBTOTAL</th>";
          //       echo "</tr>";
          
          //   if(empty($det)){ // Jika data tidak ada
          //     echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
          // }else{ // Jika jumlah data lebih dari 0 (Berarti jika data ada)
          //     $countD = 1;
          $no++;
            }
     
       
              // $total+= $sum;
            // }
          
            echo "<tr>";
            echo "<td class='num' align='right' colspan=3><b>Subtotal</td>";
            echo "<td class='num' align='right'><b>".number_format($totalqty, 0, ',', '.')."</td>";
            echo "<td class='num' align='right'><b>".number_format($total, 0, ',', '.')."</td>";
            echo "</tr>";
                
            
          //     }  
          $totalQty=0;
          $total=0;
          foreach($transak as $val){
            $totalQty +=($val->JMLBRG);
            $total +=($val->TOTAL);
          }
          echo "<tr>";
          echo "<td class='footer text' align='right' colspan=5><b></td>";
          echo "</tr>";
          echo "<tr>";
            echo "<td class='num' align='right' colspan=3><b>Grand Total</td>";
            echo "<td class='num' align='right'><b>".number_format($totalQty, 0, ',', '.')."</td>";
            echo "<td class='num' align='right'><b>".number_format($total, 0, ',', '.')."</td>";
            echo "</tr>";
         

            
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