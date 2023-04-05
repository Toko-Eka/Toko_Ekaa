<html>
<head>
  <title>Cetak Kartu Stok</title>
  <style>
 
    .table {
        border-collapse:collapse;
    width:100%;
        align-content: center;
    }
    .table th, td {
      padding-left: 10;
  padding-right: 10;
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

    <h4 style="margin-bottom: 5px;">Kartu Stok</h4>

<table class="table">
  
    <?php
        if(empty($master)){ // Jika data tidak ada
            echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
        }else{ // Jika jumlah data lebih dari 0 (Berarti jika data ada)
            $count = 1;
  $sub=0;
  // error_reporting(0);

            foreach($master as $data){ // Looping hasil data transaksi
        
           
              echo"<p>Kode Barang/ Barcode : ".$data->KDBRG."</p>";
                echo"<p>Nama Barang : ".$data->NAMABRG."</p>";
        echo $label;
      

                // $unpaid = '';
                // if ($data->PAID == 0) {
                //     $unpaid = '<font color="Red">Belum Dibayar</font>';
                // } else {
                //     $unpaid = 'Sudah Dibayar';
                // }
    
                // $row[] = $unpaid;
                // echo"<p> Status : ".$unpaid."</p>";
                // echo"<p>Kasir : ".$data->KASIR."</p>";

 
                echo "<hr>";
              
                echo "<table class ='table' id='tab' border='1'  width='50%'>";
                echo "<thead>";
          
                echo "<tr>";
                echo " <th style='width: 3%;'>No</th>";
                echo " <th style='width: 30%;'>Tanggal</th>";
                echo " <th style='width: 15%;'>Jumlah  Keluar</th>";
                echo " <th style='width: 15;'>Jumlah Masuk</th>";
                echo " <th style='width: 30%;'>Keterangan</th>";
                
           
       
        
                echo "</thead>";
                echo "<tbody>";

                foreach($stoka as $dataa){ // Looping hasil data transaksi
                echo "<tr>";
         
                echo "<td colspan='2'style='width: 500px;' align='right'>Stok Awal </td>";
                echo "<td class='num' align='right'><b>".number_format($dataa->AKHIIR, 0, ',', '.')."</td>";
                echo "</tr>";
                echo "<tr>";
                }
                echo "<td colspan='5'style='width: 500px;' align='right'> </td>";
              
                echo "</tr>";
                $no = 1;
                $supp = '';
                $sumj = 0;
                $sumb = 0;
                foreach($detail as $data){ // Looping hasil data transaksi
                
                // $totalqty += $data->KELUAR;
                    echo "<td style='width: 40px;'>".$no."</td>";
             
                   
        
        
            
                     
              
                    // echo "</tr>";
                    //       echo "<tr>";
                    //       echo " <th></th>";
                    //       echo " <th>Nama Brg</th>";
                    //       echo " <th></th>";
                    //       echo "</tr>";
                    //         echo "<tr>";
                    //         echo"<td></td>";
                    $format = '';
                    $format = date('d/m/Y', strtotime($data->TGL));
                    echo "<td style='width: 500px;'>".$format."</td>";
               
                    
                  
                  
                    
                    // echo "<td style='width: 500px;' align='right'>".$data->JMLBRG."</td>";
                    $ket = '';
                    $jml = '';
                    if ($data->KODETRN == 'B') {
                    echo "<td style='width: 250px;' align='right'></td>";
                          
                    echo "<td style='width: 250px;' align='right'>".$data->JMLBRG."</td>";
                    
                      $ket = 'Beli <b> ( Nota #'.$data->NOTA.') </b>';
                       $sumb += $data->JMLBRG;
                   
                 
                    } else if ($data->KODETRN == 'J' ){
                   echo "<td style='width: 250px;' align='right'>".$data->JMLBRG."</td>";
                     echo "<td style='width: 250px;' align='right'></td>";
                      $ket = 'Jual <b> ( Nota #'.$data->NOTA.')</b>';
                     
                      $sumj += $data->JMLBRG;
          
                    }
                    else if ( $data->KODETRN == 'K'){
                      echo "<td style='width: 250px;' align='right'>".$data->JMLBRG."</td>";
                        echo "<td style='width: 250px;' align='right'></td>";
                         $ket = 'Retur Keluar <b> ( Nota #'.$data->NOTA.')</b>';
                       }else if ( $data->KODETRN == 'M') {
                        echo "<td style='width: 250px;' align='right'></td>";
                          
                        echo "<td style='width: 250px;' align='right'>".$data->JMLBRG."</td>";
                        
                          $ket = 'Retur Masuk <b> ( Nota #'.$data->NOTA.') </b>';
                       }
                    echo "<td style='width: 500px;'>".$ket."</td>";
                    echo "</tr>";
                    $no++;
                  }
               
            //       foreach($det as $val){
            //         $totalQty +=($val->JMLBRG);
            //         $total +=($val->TOTAL);
            // }
            // echo "<tr>";
          
                   
        
        
            
                     
              
            // // echo "</tr>";
            // //       echo "<tr>";
            // //       echo " <th></th>";
            // //       echo " <th>Nama Brg</th>";
            // //       echo " <th></th>";
            // //       echo "</tr>";
            // //         echo "<tr>";
            // //         echo"<td></td>";
          
            // echo "<td colspan='5' style='text-align: right;'>".number_format($totalQty)."</td>";
            // echo "<td style='text-align: right;'>Total : ".number_format($total)."</td>";
            // echo "</tr>";
            }
            echo "<tr>";
   
    echo "<td colspan='3' class='num' align='right'><b>".number_format($sumj, 0, ',', '.')."</td>";
    echo "<td class='num' align='right'><b>".number_format($sumb, 0, ',', '.')."</td>";
    echo "</tr>";
            echo "<tr>";
            echo "<td colspan='5'style='width: 500px;' align='right'> </td>";
          
            echo "</tr>";
            foreach($master as $data2){ // Looping hasil data transaksi
             
              echo "<tr>";
            echo "<td colspan='2'style='width: 500px;' align='right'>Stok Akhir </td>";
            echo "<td class='num' align='right'><b>".number_format($data2->AKHIR, 0, ',', '.')."</td>";
            echo "</tr>";
            }
    }
    
    
    ?>
</table>
</body>
</html>
<script src="<?= base_url()?>assets/modules/jquery.min.js"></script>
<script>
  
$(function() {  

function groupTable($rows, startIndex, total){
if (total === 0){
return;
}
var i , currentIndex = startIndex, count=1, lst=[];
var tds = $rows.find('td:eq('+ currentIndex +')');
var ctrl = $(tds[0]);
lst.push($rows[0]);
for (i=1;i<=tds.length;i++){
if (ctrl.text() ==  $(tds[i]).text()){
count++;
$(tds[i]).addClass('deleted');
lst.push($rows[i]);
}
else{
if (count>1){
ctrl.attr('rowspan',count);
groupTable($(lst),startIndex+1,total-1)
}
count=1;
lst = [];
ctrl=$(tds[i]);
lst.push($rows[i]);
}
}
}
groupTable($('#tab tr:has(td)'),0,1);
$('#tab .deleted').remove();
});
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