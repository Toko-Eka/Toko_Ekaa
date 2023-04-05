<html>
<head>
  <title>Cetak Laporan Barang Tidak Terjual</title>
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
    <!-- <h4 style="margin-bottom: 5px;">Laporan Barang yang tidak terjual</h4> -->
    <h4 style="margin-bottom: 5px;"><?=$label;?></h4>
    <hr>
  <table class="table"  width="100%" style="margin-top: 5px;">
    <tr>
    <th style="width: 3%;">No</th>
      <!-- <th style="width: 10%;">Kode Barang</th> -->
      <th style="width: 18%;">Nama Barang</th>
      <th style="width: 5%;">Supplier</th>
         
      <th style="width: 6%;">Harga Jual</th>
      <th style="width: 6%;">Harga Beli</th>
      <th style="width: 5%;">Stok Akhir</th>

     

      <!-- <th>Total Harga</th> -->
    </tr>
    <?php
        if(empty($res)){ // Jika data tidak ada
            echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
        }else{ // Jika jumlah data lebih dari 0 (Berarti jika data ada)
            $count = 1;
  $sub=0;
  error_reporting(0);

            foreach($res as $data){ // Looping hasil data transaksi
        
           
                // $tgl = date('d-m-Y', strtotime($data->tgll)); // Ubah format tanggal jadi dd-mm-yyyy
                echo "<tr>";
              
                echo "<td style='width: 40px;'>".$count++."</td>";
                // echo "<td style='width: 80px;'>".$data->KDBRG."</td>";
                echo "<td style='width: 100px;'>".$data->NAMABRG."</td>";
            echo "<td style='width: 100px;'>".$data->KDSUP."</td>";
          
          
                echo "<td style='text-align:right;width: 100px;'>".number_format($data->HET)."</td>";
                echo "<td style='text-align:right;width: 100px;'>".number_format($data->HBT)."</td>";
                echo "<td style='text-align:right;width: 100px;'>".number_format($data->AKHIR)."</td>";
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