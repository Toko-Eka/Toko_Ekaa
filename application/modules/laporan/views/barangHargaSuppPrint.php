<html>
<head>
  <title>Cetak Laporan Barang Harga per Supplier </title>
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
    <h4 style="margin-bottom: 5px;">Laporan Barang Harga per Supplier</h4>
    <h4 style="margin-bottom: 5px;"><?=$label;?></h4>
    <hr>
  <table class="table" width="100%" style="margin-top: 5px;">
    <tr>
    <th style="width: 3%;">No</th>

      <th style="width: 18%;">Nama Barang</th>
      <!-- <th style="width: 5%;">Supplier</th> -->
         
      <th style="width: 6%;">HET</th>
      <th style="width: 6%;">RLABA</th>
      <th style="width: 6%;">HBT</th>
      <th style="width: 6%;">A</th>
      <th style="width: 6%;">B</th>
      <th style="width: 6%;">C</th>
      <th style="width: 6%;">D</th>
      <th style="width: 6%;">E</th>
      <th style="width: 6%;">KANVAS</th>


     

      <!-- <th>Total Harga</th> -->
    </tr>
    <?php
        if(empty($res)){ // Jika data tidak ada
            echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
        }else{ // Jika jumlah data lebih dari 0 (Berarti jika data ada)
            $count = 1;
  $sub=0;
  error_reporting(0);
$sup= array();
            foreach($res as $data){ // Looping hasil data transaksi
              if(!in_array($data->KDSUP, $sup)){ // check if category exists in the array
                $count=1;
                $sup[] = $data->KDSUP; // insert the value in the array and show it as a heading
                // $sub[] = $data->SUBT;
             
        ?>
                <tr>
              
                    <td colspan="3" class="td_table" height style="text-align: left;"> Dari Supplier<b> <?= $data->KDSUP?> </b></td>
                    <td></td>
                    <td></td>
                    <!-- <td rowspan="2" class="td_table" height style="text-align: right;"> <b> <?= $data->SUBT ?> </b></td> -->
                    
        
                </tr>
        <?php
                }
           
                // $tgl = date('d-m-Y', strtotime($data->tgll)); // Ubah format tanggal jadi dd-mm-yyyy
                echo "<tr>";
                echo "<td style='width: 40px;'>".$count++."</td>";
          
                echo "<td style='width: 100px;'>".$data->NAMABRG."</td>";
            // echo "<td style='width: 100px;'>".$data->KDSUP."</td>";
                echo "<td style='text-align:right;width: 100px;'>".number_format($data->HET)."</td>";
                echo "<td style='text-align:right;width: 100px;'>".round((float)$data->RLABA * 1 ) . '%';"</td>";
                echo "<td style='text-align:right;width: 100px;'>".number_format($data->HBT)."</td>";
                echo "<td style='text-align:right;width: 100px;'>".number_format($data->JHAR1)."</td>";
                echo "<td style='text-align:right;width: 100px;'>".number_format($data->JHAR2)."</td>";
                echo "<td style='text-align:right;width: 100px;'>".number_format($data->JHAR3)."</td>";
                echo "<td style='text-align:right;width: 100px;'>".number_format($data->JHAR4)."</td>";
                echo "<td style='text-align:right;width: 100px;'>".number_format($data->JHAR5)."</td>";
                echo "<td style='text-align:right;width: 100px;'>".number_format($data->HKANVAS)."</td>";
                
                // echo "</tr>";
                //       echo "<tr>";
                //       echo " <th></th>";
                //       echo " <th>Nama Brg</th>";
                //       echo " <th></th>";
                //       echo "</tr>";
                //         echo "<tr>";
                //         echo"<td></td>";
         
            }
          
      
          

          
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