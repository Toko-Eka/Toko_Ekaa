<html>
<head>
  <title>Laporan Transaksi Penjualan yang belum dibayar per NOTA</title>
  <style>
    .table {
        border-collapse:collapse;
        table-layout:fixed;width:100%;
    }
    .table th {
        padding: 5px;
    }
    .table td {
        /* word-wrap:break-word; */
        width: 20%;
        padding: 5px;
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
  <table class="table" id="tab" border="1" width="100%"  style="margin-top: 5px;">
  <tr>
    <th style="width: 3%;">No</th>
<!-- 
      <th style="width: 6%;">Kode Transaksi</th> -->
      <th style="width: 32%;">Nama Barang</th>
      <th style="width: 6%;">Harga</th>

      <th style="width: 5%;">Jumlah</th>
      <th style="width: 10%;">Subtotal</th>

      <!-- <th>Total Harga</th> -->
    </tr>
    <?php
    error_reporting(0);
        if(empty($transak)){ // Jika data tidak ada
            echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
        }else{ // Jika jumlah data lebih dari 0 (Berart i jika data ada)
          $subtotal = 0;
            $count = 1;
            $nota = array(); // initialize array which will contain the categories
            $sub = array();
       
            foreach($transak as $data){ // Looping hasil data transaksi
            
              if(!in_array($data->NOTA, $nota)){ // check if category exists in the array
              
                $nota[] = $data->NOTA; // insert the value in the array and show it as a heading
                $sub[] = $data->TOTAL;
             
        ?>
                <tr>
              
                    <td colspan="3" class="td_table" height style="text-align: left;"> Nota #<b> <?= $data->NOTA?> </b></td>
                    <span id="val"></span>
                    <!-- <td class="td_table" style="text-align: center;">Nota : <?= $sub?></td> -->
                </tr>
        <?php
                }
            
          
              // $group[$data->KDSUP][] = $data;
   
                echo "<tr>";
                echo "<td style='width: 40px;'>".$count++."</td>";
       
               

 
                // echo "<td style='width: 100px;'>".$data->NOTA."</td>";
                 
          
                // echo "</tr>";
                //       echo "<tr>";
                //       echo " <th></th>";
                //       echo " <th>Nama Brg</th>";
                //       echo " <th></th>";
                //       echo "</tr>";
                //         echo "<tr>";
                //         echo"<td></td>";
                echo "<td style='width: 500px;'>".$data->NAMABRG."</td>";
                // echo "<td style='width: 500px;'>".$data->KDSUP."</td>";
                echo "<td style=' text-align: right;'>".$data->HARGA."</td>";
                echo "<td style='text-align: right;'>".$data->JMLBRG."</td>";
                echo "<td style='text-align: right;'>".$data->TOTAL."</td>";
                $totalQty=0;
                $total=0;
            
                  $totalQty +=($data->JMLBRG);
                  $total +=($data->TOTAL);
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
    
            foreach($grandtotal as $tot){ 
    ?>
            <tr>
<!--           
                <td colspan="3" class="td_table" height style="text-align: left;"> Dari Supplier<b> <?= $data->KDSUP?> </b></td> -->
            
                <td class="td_table" style="text-align: center;">Nota : <?= $tot->SUBTOTAL?></td>
            </tr>
    <?php
    
        } 
              }
            
            $totalQty=0;
            $total=0;
            foreach($transak as $val){
              $totalQty +=($val->JMLBRG);
              $total +=($val->TOTAL);
          
       
              // $total+= $sum;
            }
          
                       
            echo "<td colspan='4' style='width: 100px; text-align: right;'>Total </td>";
            echo "<td style='width: 100px;  text-align: right;'>".$total."</td>";
                echo "</tr>";
                
            
          //     }   

            
          }
    ?>
  </table>
</body>
</html>
<script>
       var table = document.getElementById("tab"), sumVal = 0;
            
            for(var i = 1; i < table.rows.length; i++)
            {
                sumVal = sumVal + parseInt(table.rows[i].cells[2].innerHTML);
            }
            
            document.getElementById("val").innerHTML = "Sum Value = " + sumVal;
            console.log(sumVal);
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