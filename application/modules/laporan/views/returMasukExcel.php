<html>
<head>
  <title>Cetak Laporan Retur Masuk</title>
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
    <h4 style="margin-bottom: 5px;">Laporan Retur Masuk</h4>
  <?php echo $label ?>
  <table class="table"  width="100%" style="margin-top: 5px;">
    <tr>
    <th style="width: 5%;">No</th>
      <th style="width: 15%;">Tanggal Entry</th>
      <th style="width: 15%;">Tanggal Nota</th>

      <th style="width: 32%;">Nama Barang</th>


      <th style="width: 5%;">Jumlah</th>
      
      <th style="width: 6%;">Ket</th>


      <!-- <th>Total Harga</th> -->
    </tr>
    <?php
        if(empty($retKel)){ // Jika data tidak ada
            echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
        }else{ // Jika jumlah data lebih dari 0 (Berarti jika data ada)
            $count = 1;
  $tgl = array();
  $sup = array();
            foreach($retKel as $data){ // Looping hasil data transaksi
              if(!in_array($data->TGLENTRY, $tgl)){ // check if category exists in the array
              
                $tgl[] = $data->TGLENTRY; // insert the value in the array and show it as a heading
            
            
                $tglentry = date('d-m-Y', strtotime($data->TGLENTRY)); // Ubah format tanggal jadi dd-mm-yyyy
        
        ?>
          
                <tr>
              
                    <td colspan="6" class="td_table" height style="text-align: left;">Tanggal Retur<b> <?= $tglentry?> </b></td>
            

           
           
          
                </tr>
        <?php
                }
              if(!in_array($data->KDSUP, $sup)){ // check if category exists in the array
              
                $sup[] = $data->KDSUP; // insert the value in the array and show it as a heading
            
                $count = 1;
              
        
        ?>
          
                <tr>
              
                    <td colspan="6" class="td_table" height style="text-align: left;"> Dari Supplier<b> <?= $data->KDSUP?> </b></td>
                 

           
           
          
                </tr>
        <?php
                }
           
                $tglentry = date('d-m-Y', strtotime($data->TGLENTRY)); // Ubah format tanggal jadi dd-mm-yyyy
                $tglnota = date('d-m-Y', strtotime($data->tgl)); // Ubah format tanggal jadi dd-mm-yyyy
                echo "<tr>";
                echo "<td style=' text-align: center; width: 40px;'>".$count++."</td>";
                echo "<td >".$tglentry."</td>";
                echo "<td >".$tglnota."</td>";
               

 
          
                 
          
                // echo "</tr>";
                //       echo "<tr>";
                //       echo " <th></th>";
                //       echo " <th>Nama Brg</th>";
                //       echo " <th></th>";
                //       echo "</tr>";
                //         echo "<tr>";
                //         echo"<td></td>";
                echo "<td style='width: 600px;'>".$data->NAMABRG."</td>";
           
                echo "<td style='text-align: right;'>".$data->JMLBRG."</td>";
                echo "<td style='width: 600px;'>".$data->KET1."</td>";
              
                // echo "<td style='width: 100px;'>".number_format($data->SUBTOTAL)."</td>";
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
            }
              
          
          //       

            
         
    
    
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