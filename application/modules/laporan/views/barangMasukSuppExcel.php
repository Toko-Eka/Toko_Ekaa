<html>
<head>
  <title>Cetak Laporan Pembelian per Supplier</title>
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
    <h4 style="margin-bottom: 5px;">Laporan Pembelian per Supplier</h4>
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
         
            $sup = array(); // initialize array which will contain the categories
            $sub = array();
            $no = 1;
            $total = 0;
            $totalqty = 0;
   
            $supp = '';
            foreach($transak as $data){ // Looping hasil data transaksi       
         
          
                 if($supp !== $data->KDSUP){
                     $supp = $data->KDSUP;
                     if($no > 1){
                         echo "<tr>";
                         echo "<td class='num' align='right' colspan=3><b>Subtotal</td>";
                         echo "<td class='num' align='right'><b>".$totalqty."</td>";
                         echo "<td class='num' align='right'><b>".$total."</td>";
                         echo "</tr>";
                       
     
                         $total = 0;
                         $totalqty = 0;
                         
                     }
                 } 
                 if(!in_array($data->KDSUP, $sup)){ // check if category exists in the array
              $no=1;
                  $sup[] = $data->KDSUP; // insert the value in the array and show it as a heading
              
              
                
          
          ?>
            
                  <tr>
                
                      <td colspan="2" class="td_table" height style="text-align: left;"> Dari Supplier<b> <?= $data->KDSUP?> </b></td>
                      <td></td>
                      <td></td>
                      <td></td>
  
             
             
            
                  </tr>
          <?php
                  }
                 $total += $data->HBT * $data->JMLBRG ;
                 $totalqty += $data->JMLBRG;
                echo "<tr>";
                echo "<td class='text' align='center'>".$no."</td>";
                echo "<td style='width: 500px;'>".$data->NAMABRG."</td>";
                echo "<td style=' text-align: right;'>".$data->HBT."</td>";
                echo "<td style='text-align: right;'>".$data->JMLBRG."</td>";
                echo "<td style='text-align: right;'>".$data->HBT * $data->JMLBRG."</td>";
            
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
            echo "<td class='num' align='right'><b>".$totalqty."</td>";
            echo "<td class='num' align='right'><b>".$total."</td>";
            echo "</tr>";
                
            
          //     }  
          $totalQty=0;
          $total=0;
          $sub=0;
          foreach($transak as $val){
            $totalQty +=($val->JMLBRG);
            $total +=($val->HBT * $val->JMLBRG);
            $sub = $total;
          }
          echo "<tr>";
          echo "<td class='footer text' align='right' colspan=5><b></td>";
          echo "</tr>";
          echo "<tr>";
            echo "<td class='num' align='right' colspan=3><b>Grand Total</td>";
            echo "<td class='num' align='right'><b>".$totalQty."</td>";
            echo "<td class='num' align='right'><b>".round($total)."</td>";
            echo "</tr>";
         

            
          }
    ?>
  </table>
</body>
</html>
<script>
  
</script>