
<section>

						<div class="col-md-6 col-sm-12 text-right">
							
						</div>
					</div>
				</div>
              
                  <div class="card" style= "margin: auto; width: 100%;" >
                    <div class="card-header">Laporan Kartu Stok</div>
                   <div class="card-body">  <div class="form-group">
                  <h4>Pilih Barang</h4>
                  <hr>
                  <label class="control-label">Cari terlebih dahulu barang yang akan di cetak laporannya</label>
                  <div class="input-group mb-3">
            
                                         
                                        <input type="text" placeholder="Cari Barang Disini...." class="form-control" id="draw">
                                        <div class="input-group-append">
                                        <button class="btn btn-primary btn-block"data-toggle="modal" data-target="#modalBrg"> Cari Barang..</button> 
                                        </div>
                                    </div>
                  <div class="form-group">
                                            


                                            <!-- <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-calendar"></i>
                      </div>
                    </div> -->
                                            <!-- <input type="text" id="tgl" class="form-control" name="tgl_periode" > -->
                                            <div class="row">
                                            <div class="col-md-3">
                                              <label for="">Nama</label>
<h5 id="draw2"></h5>
</div>
<div class="col-md-3">
  <label for="">Supplier</label>
<h5 id="draw3"></h5>
</div>
<div class="col-md-3">
                                              <label for="">Stok Awal</label>
<h5 id="draw4"></h5>
</div>
<div class="col-md-3">
  <label for="">Stok Akhir</label>
  <h5 id="draw5"></h5>
</div>
                                            </div>
                                            <br>
<br><hr>
         
<div class="row">
<div class="col-md-3">
                                              <label for="">Jumlah Keluar</label>
<h5 id="draw6"></h5>
</div>
<div class="col-md-3">
  <label for="">Jumlah Masuk</label>
<h5 id="draw7"></h5>
</div>                                         
<div class="col-md-3">
                                              <label for="">HET</label>
<h5 id="draw8"></h5>
</div>
<div class="col-md-3">
  <label for="">HBT</label>
<h5 id="draw9"></h5>
</div>
</div>
<br>
<br>

<hr>

</div>

                                
                                        <div class ='daterange-cus' id="daterange-cus" style="font-size: 17px; background: #fff; cursor: pointer; padding:10px 17px; border: 1px solid #ccc; width: 100%">
    <i class="fa fa-calendar"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
</div>
<br><hr>
<div class="btn-group" role="group" aria-label="Basic example">
                           
<button class="btn btn-info" onclick="reload_table()"><i class="fa-solid fa-rotate-right"></i> Refresh</button>
                           <button type="button" onclick="print()" id="btn-print" style="float: left;" class="btn btn-primary"><i class="fa-solid fa-print"></i> Print</button>
                           <button type="button" onclick="excel()" id="btn-excel" style="float: left;" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Download Excel</button>
                       </div>

                <input type="text" name="tgl_awal" id="split1" hidden>
                <input type="text" name="tgl_akhir" id="split2" hidden>
                <hr>
                <br>
                <div class="table-responsive-md">
     <table id='kartuStok' class='table table-striped' style="width:100%">

<thead>
  <tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Jumlah Keluar</th>
    <th>Jumlah Masuk</th>
    <th>Keterangan</th>



  </tr>
</thead>

</table>
                </div>
                  </div>
</div>
      



            <br>   
                
        </section>
<!-- Modal -->
<div class="modal fade" id="modalBrg" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Barang untuk di print kartu stok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <div class="table-responsive-md">
     <table id='tableBrg' class='table table-striped' style="width:100%">

<thead>
  <tr>
    <th>KD BRG</th>
    <th>JENIS</th>
    <th>NAMA BARANG</th>
    <th>SUPPLIER</th>
    <th>STOK</th> 

    <th style="width:125px;">Action</th>

  </tr>
</thead>

</table>
                </div>
      </div>
     
    </div>
  </div>
</div>


<style>
  a {
  color: gray;
}
  a:link { text-decoration: none; }


a:visited { text-decoration: none; }


a:hover { text-decoration: none; }


a:active { text-decoration: none; }
</style>

<script>

$(document).ready(function() {
  var table;
  var table2;
    table = $('#tableBrg').DataTable({ 
    "lengthPage": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "pageLength": 5,
        "dom": '<"pull-left"f><"pull-right">tip',
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Barang/Barang/brgListRep')?>",
            "type": "POST",
            "data": function ( data ) {
                
                data.JENIS = $('#jenn').val();
                data.KDSUP = $('#idsupp').val();
                data.AKHIR = $('#stok').val();
                data.MORELESS = $('#MORELESS').val();
            
            }
        },
      
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
      
    });

var startDate = moment();
            var endDate = moment();

            function cb(startDate, endDate) {
                $('.daterange-cus span').html(startDate.format('MMMM D, YYYY') + ' s/d ' + endDate.format('MMMM D, YYYY'))
            }
            $('.daterange-cus').daterangepicker({

                    ranges: {
                        'Hari ini': [moment(), moment()],
                        'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                        '30 Hari terakhir': [moment().subtract(29, 'days'), moment()],
                        'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                        'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment(),
                    endDate: moment(),
                    locale: {
                        format: 'DD/MM/YYYY'
                    },
                    drops: 'down',
                    opens: 'right'
                },
                cb
            );
            cb(startDate, endDate);
            var startDate = $('.daterange-cus').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var endDate = $('.daterange-cus').data('daterangepicker').endDate.format('YYYY-MM-DD');
            $('#split1').val(startDate);
            $('#split2').val(endDate);
            $('.ranges').click(function() {
                var startDate = $('.daterange-cus').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('.daterange-cus').data('daterangepicker').endDate.format('YYYY-MM-DD    ');
                $('#split1').val(startDate);
                $('#split2').val(endDate);
            });

          });
          function select(id,nama,sup,awal,akhir,masuk,jual,het,hbt){

            $('#draw').val(id);
            $('#draw2').text(nama);
            $('#draw3').text(sup);
            $('#draw4').text('0');
            $('#draw5').text('0');
            $('#draw6').text('0');
            $('#draw7').text('0');
var tglAwal = $('#split1').val();
var tglAkhir = $('#split2').val();
$.ajax({
    type: "POST",
    url: "<?php echo base_url('Laporan/KartuStok/getStokAwal') ?>" ,
    dataType: "JSON",
    data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "barang": id,
     
    },
    cache: false,
    success: function(data) {
        $.each(data, function(STOK) {
    
            $('#draw4').text(number_format(data.STOK));
          

  // $('#draw4').text(number_format(awal));
            // $('#draw5').text(number_format(akhir));
            // $('#draw6').text(number_format(masuk));
            // $('#draw7').text(number_format(jual));
        });
        $.ajax({
    type: "POST",
    url: "<?php echo base_url('Laporan/KartuStok/getStokAkhir') ?>" ,
    dataType: "JSON",
    data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "barang": id,
     
    },
    cache: false,
    success: function(data) {
        $.each(data, function(STOK) {
    
            $('#draw5').text(number_format(data.STOK));
          

  // $('#draw4').text(number_format(awal));
            // $('#draw5').text(number_format(akhir));
            // $('#draw6').text(number_format(masuk));
            // $('#draw7').text(number_format(jual));
        });
        $.ajax({
    type: "POST",
    url: "<?php echo base_url('Laporan/KartuStok/getKelMasuk') ?>" ,
    dataType: "JSON",
    data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "barang": id,
     
    },
    cache: false,
    success: function(data) {
        $.each(data, function(Keluar, Masuk) {
            $('#draw6').text(number_format(data.Keluar));
            $('#draw7').text(number_format(data.Masuk));

  // $('#draw4').text(number_format(awal));
            // $('#draw5').text(number_format(akhir));
            // $('#draw6').text(number_format(masuk));
            // $('#draw7').text(number_format(jual));
        });

    }
});
    }
});
     

    }
});


          
            $('#draw8').text(number_format(het));
            $('#draw9').text(number_format(hbt));
            $('#modalBrg').modal('hide');
    
   draw_grid()

          }
  
          function print(){
 
         var id =  $('#draw').val();
            
          var awal =  $('#split1').val();
            
          var akhir = $('#split2').val();
           
 myw = window.open('<?php echo base_url() ?>Laporan/KartuStok//printKartuStok/' + id +'/'+awal+'/'+akhir);

 myw.document.close(); //missing code


 myw.focus();
}

function excel(){
  var id =  $('#draw').val();
            
            var awal =  $('#split1').val();
              
            var akhir = $('#split2').val();
             
            myw = window.open('<?php echo base_url() ?>Laporan/KartuStok//excelKartuStok/'  + id +'/'+awal+'/'+akhir);

    myw.document.close(); //missing code


    myw.focus();
; 
    }
    function delete_grid() {
        $('#kartuStok').DataTable().clear().destroy();
    }
        
    function draw_grid() {
      preloader(false, 'immune', 'blue');
    // $('input[type=search]').hide();
    table2 = $('#kartuStok').DataTable({
      "pageLength": 5,
      // "className": 'details-control',
      "dom": '<"pull-left"><"pull-right">t',
      retrieve: true,
      "paging": false,
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.
      // "searchPanes": {
      //    " viewTotal": true
      // },


      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('Laporan/KartuStok//kartuStokList') ?>",
        "type": "POST",
        "data": function(data) {

          data.min = $('#split1').val();
          data.max = $('#split2').val();
          // data.KASIR = $('#iduser').val();
          data.KDBRG = $('#draw').val();

        }
      },

      //Set column definition initialisation properties.
      "columnDefs": [{
          "targets": [-1], //last column

        },
        //     {
        //     'targets': [0],
        //     'width': '10px',
        //   },
        //   {
        //     'targets': [1,2],
        //     'className' : 'dt-left',
        //   },
        //   {
        //     'targets' : [3,4,5],
        //     'className' : 'dt-right',
        //     'width': '100px',
        //   },
      ],
      "columns": [
        {
          "className": 'no'
        },
        {
          "className": 'kassa'
        },
        {
          "className": 'suppl text-right'
        },

        {
          "className": 'total text-right'
        },
        {
          "className": 'suppl'
        },

      ],
    });
  table2.ajax.reload();
   
  }
  function reload_table(){
    $('#draw4').text('0');
            $('#draw5').text('0');
            $('#draw6').text('0');
            $('#draw7').text('0');
  var brg = $('#draw').val();
    var tglAwal = $('#split1').val();
var tglAkhir = $('#split2').val();
    $.ajax({
    type: "POST",
    url: "<?php echo base_url('Laporan/KartuStok/getStokAwal') ?>" ,
    dataType: "JSON",
    data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "barang": brg,
     
    },
    cache: false,
    success: function(data) {
        $.each(data, function(STOK) {
            $('#draw4').text(number_format(data.STOK));
          

  // $('#draw4').text(number_format(awal));
            // $('#draw5').text(number_format(akhir));
            // $('#draw6').text(number_format(masuk));
            // $('#draw7').text(number_format(jual));
        });
        $.ajax({
    type: "POST",
    url: "<?php echo base_url('Laporan/KartuStok/getStokAkhir') ?>" ,
    dataType: "JSON",
    data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "barang": brg,
     
    },
    cache: false,
    success: function(data) {
        $.each(data, function(STOK) {
            $('#draw5').text(number_format(data.STOK));
          

  // $('#draw4').text(number_format(awal));
            // $('#draw5').text(number_format(akhir));
            // $('#draw6').text(number_format(masuk));
            // $('#draw7').text(number_format(jual));
        });
        $.ajax({
    type: "POST",
    url: "<?php echo base_url('Laporan/KartuStok/getKelMasuk') ?>" ,
    dataType: "JSON",
    data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "barang": brg,
     
    },
    cache: false,
    success: function(data) {
        $.each(data, function(Keluar, Masuk) {
            $('#draw6').text(number_format(data.Keluar));
            $('#draw7').text(number_format(data.Masuk));

  // $('#draw4').text(number_format(awal));
            // $('#draw5').text(number_format(akhir));
            // $('#draw6').text(number_format(masuk));
            // $('#draw7').text(number_format(jual));
        });

    }
});
    }
});
     

    }
});

    preloader(false, 'immune', 'blue');
    table2.ajax.reload();
  }
  function number_format(number, decimals, decPoint, thousandsSep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
            var n = !isFinite(+number) ? 0 : +number
            var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
            var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
            var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
            var s = ''

            var toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec)
                return '' + (Math.round(n * k) / k)
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
