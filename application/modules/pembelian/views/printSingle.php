<html>
<head>
  <title>Cetak Laporan Pembelian</title>
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
    @page {
      size: lanscape;
        margin: 15px;
    }
  </style>
</head>
<body>
    <h4 style="margin-bottom: 5px;">Laporan Transaksi Pembelian</h4>

  <table class="table" border="1" width="100%" height="100%" style="margin-top: 5px;">
  
    <?php
        if(empty($master)){ // Jika data tidak ada
            echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
        }else{ // Jika jumlah data lebih dari 0 (Berarti jika data ada)
            $count = 1;
  $sub=0;
  error_reporting(0);

            foreach($master as $data){ // Looping hasil data transaksi
        
           
                $tgl = date('d-m-Y', strtotime($data->TGL)); // Ubah format tanggal jadi dd-mm-yyyy
                echo"<p>NOTA : ".$data->NOTA."</p>";
                echo"<p> Tanggal NOTA : ".$tgl."</p>";
                $unpaid = '';
                if ($data->PAID == 0) {
                    $unpaid = '<font color="Red">Belum Dibayar</font>';
                } else {
                    $unpaid = 'Sudah Dibayar';
                }
    
                $row[] = $unpaid;
                echo"<p> Status : ".$unpaid."</p>";
                echo"<p>Kasir : ".$data->KASIR."</p>";

 
                
              
                echo "<table class ='table' border='1' width='100%'>";
                echo "<tr>";
                echo " <th style='width: 5%;'>No</th>";
                echo " <th style='width: 30%;'>Nama Brg</th>";
                echo " <th style='width: 7%;'>Supplier</th>";
                echo " <th style='width: 7%;'>HBT</th>";
                echo " <th style='width: 5%;'>QTY</th>";
                echo " <th style='width: 7%;'>Subtotal</th>";
                echo "</tr>";
     
          
                foreach($det as $data){ // Looping hasil data transaksi
        
                 
                    echo "<td style='width: 40px;'>".$count++."</td>";
             
                   
        
        
            
                     
              
                    // echo "</tr>";
                    //       echo "<tr>";
                    //       echo " <th></th>";
                    //       echo " <th>Nama Brg</th>";
                    //       echo " <th></th>";
                    //       echo "</tr>";
                    //         echo "<tr>";
                    //         echo"<td></td>";
                    echo "<td style='width: 500px;'>".$data->NAMABRG."</td>";
                    echo "<td style='width: 500px;'>".$data->KDSUP."</td>";
                    echo "<td style=' text-align: right;'>".number_format($data->HBT,0)."</td>";
                    echo "<td style='text-align: right;'>".number_format($data->JMLBRG)."</td>";
                    echo "<td style='text-align: right;'>".number_format($data->TOTAL)."</td>";
                    echo "</tr>";
                  
                  }
                  $totalQty=0;
                  $total=0;
                  foreach($det as $val){
                    $totalQty +=($val->JMLBRG);
                    $total +=($val->TOTAL);
            }
            echo "<tr>";
          
                   
        
        
            
                     
              
            // echo "</tr>";
            //       echo "<tr>";
            //       echo " <th></th>";
            //       echo " <th>Nama Brg</th>";
            //       echo " <th></th>";
            //       echo "</tr>";
            //         echo "<tr>";
            //         echo"<td></td>";
          
            echo "<td colspan='5' style='text-align: right;'>".number_format($totalQty)."</td>";
            echo "<td style='text-align: right;'>Total : ".number_format($total)."</td>";
            echo "</tr>";
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