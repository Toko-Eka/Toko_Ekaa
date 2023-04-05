<html>
<head>
  <title>Cetak Laporan Margin Penjualan</title>
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
    <h4 style="margin-bottom: 5px;">Laporan Margin Penjualan</h4>
  <?php echo $label ?>
  <table class="table" id="tab"  width="100%"  style="margin-top: 5px;">
  <tr>
    <th style="width: 3%;">No</th>
<!-- 
      <th style="width: 6%;">Kode Transaksi</th> -->
      <th style="width: 32%;">Nama Barang</th>
      <th style="width: 6%;">Jumlah</th>

      <th style="width: 5%;">HBT</th>
      <th style="width: 10%;">Modal</th>
      <th style="width: 10%;">Jual</th>
      <th style="width: 10%;">Margin</th>
      <!-- <th>Total Harga</th> -->
    </tr>
    <?php
    // error_reporting(0);
        if(empty($transak)){ // Jika data tidak ada
            echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
        }else{ // Jika jumlah data lebih dari 0 (Berart i jika data ada)
          $subtotal = 0;
            $count = 1;
            $sup = array(); // initialize array which will contain the categories
            $sub = array();
            $supp = '';
            $total = 0;
            foreach($transak as $data){ // Looping hasil data transaksi
              if($supp !== $data->KDSUP){
                $supp = $data->KDSUP;
                if($count > 1){
                    echo "<tr>";
                    echo "<td class='num' align='right' colspan=6><b>Subtotal</td>";
                    // echo "<td class='num' align='right'><b>".number_format($totalqty, 0, ',', '.')."</td>";
                    echo "<td class='num' align='right'><b>".number_format($total, 0, ',', '.')."</td>";
                    echo "</tr>";
                  

                    $total = 0;
                    $totalqty = 0;
                    
                }
            } 
              if(!in_array($data->KDSUP, $sup)){ // check if category exists in the array
              
                $sup[] = $data->KDSUP; // insert the value in the array and show it as a heading
$count = 1;
             
        ?>
                <tr>
              
                    <td colspan="7" class="td_table" height style="text-align: left;"> Dari Supplier #<b> <?= $data->KDSUP?> </b></td>
                    <span id="val"></span>
                    <!-- <td class="td_table" style="text-align: center;">Nota : <?= $sub?></td> -->
                </tr>
        <?php
                }
                
         
              $total += $data->margin;
              // $totalqty += $data->JMLBRG;
          error_reporting(0);
              // $group[$data->KDSUP][] = $data;
   
                echo "<tr>";
                echo "<td style='width: 40px;'>".$count."</td>";
       
               

 
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
                // $roundedhbt = 0;
                // $roundedhbt = $number = intval($data->HARGABELI*100)/100;
                echo "<td style='text-align: right;'>".number_format($data->JMLBRG)."</td>";
                echo "<td style='text-align: right;'>".number_format($data->HBT)."</td>";
                echo "<td style='text-align: right;'>".number_format($data->modal)."</td>";
                echo "<td style='text-align: right;'>".number_format($data->TOTAL)."</td>";
                echo "<td style='text-align: right;'>".number_format($data->margin)."</td>";
       
          //       $modal=0;
          //  $jual=0;
          //  $margin=0;
          //      $hargabeli=0;
          //      $hargabeli=$data->HARGABELI;
          //       $modal= $data->HARGABELI * $data->JML;
          //       $jual= $data->HET * $data->JML;
          //       echo "<td style='text-align: right;'>".number_format($modal)."</td>";
          //       echo "<td style='text-align: right;'>".number_format($jual)."</td>";
          //       $margin = $jual - $modal;
          //       echo "<td style='text-align: right;'>".number_format($margin)."</td>";
        
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
    
          $count++;
              }
              echo "<tr>";
                    echo "<td class='num' align='right' colspan=6><b>Subtotal</td>";
                    // echo "<td class='num' align='right'><b>".number_format($totalqty, 0, ',', '.')."</td>";
                    echo "<td class='num' align='right'><b>".number_format($total, 0, ',', '.')."</td>";
                    echo "</tr>";
              $total=0;
          foreach($transak as $val){ 
          //       //   $totalQty +=($data->JMLBRG);
                  $total += ($val->margin);
          }
          
                       
            echo "<td colspan='6' style='width: 100px; text-align: right;'>Total </td>";
            echo "<td style='width: 100px;  text-align: right;'>".number_format($total)."</td>";
                echo "</tr>";
                
      
          
                       
            // echo "<td colspan='6' style='width: 100px; text-align: right;'>Total </td>";
            // echo "<td style='width: 100px;  text-align: right;'>".number_format($total)."</td>";
            //     echo "</tr>";
                
            
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