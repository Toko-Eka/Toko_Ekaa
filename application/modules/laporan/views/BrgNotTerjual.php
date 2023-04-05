<section>

  <div class="col-md-6 col-sm-12 text-right">

  </div>
  </div>
  </div>

  <div class="card" style="margin: auto; width: 100%;">
    <div class="card-header">Laporan Barang Belum Terjual</div>
    <div class="card-body">
      <div class="form-group">
        <h4>Pilih Supplier</h4>
        <hr>
        <div class="row"> <div class="col-md-5">
        <div class="input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <i class="fas fa-box"></i>
            </div>
          </div>
          <div class="form-group">
            <label for="country" class="control-label">Supplier</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="AllSupp">
              <label class="form-check-label" for="AllSupp">
                Semua Supplier
              </label>
            </div>

            <input class="form-control" type="text" id="supp" />
            <span id="validasifilt" class="text-danger">Wajib Diisi</span>
            <input hidden class="" type="text" id="idsupp" />

          </div>
   
                          
                                  
        </div>
        </div>
      <div class="col-md-7">
      <label for="country" class="control-label">Jumlah Stok</label>
      <div class="form-group">
                                <div class="input-group mb-3">
                             
                            
                                          <div class="input-group-prepend">
                                          <span class="input-group-text" id="">Dari</span>
                                          </div>
                                            <input type="number" class="form-control" id="stok1" value="0">
                                            <span class="input-group-text" id="">s/d</span>
                                            <input type="number" id="stok2" class="form-control" value="999999">
                                </div></div></div></div>
        <div class="form-group">
          <label class="control-label">Tanggal</label>


          <!-- <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-calendar"></i>
                      </div>
                    </div> -->
          <div class='daterange-cus' id="daterange-cus" style="font-size: 17px; background: #fff; cursor: pointer; padding:10px 17px; border: 1px solid #ccc; width: 100%">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
          </div>
          <!-- <input type="text" id="tgl" class="form-control" name="tgl_periode" > -->


        </div>

        <input type="text" name="tgl_awal" id="split1" hidden>
        <input type="text" name="tgl_akhir" id="split2" hidden>
      </div>
      <div class="btn-group" role="group" aria-label="Basic example">

        <!-- <button type="button" id="btn-reset" onclick="delete_grid()" style="float: left;"class="btn btn-warning ">Reset</button> -->
        <button type="button" onclick="print()" id="btn-print" style="float: left;" class="btn btn-primary"><i class="fa-solid fa-print"></i> Print</button>
        <button type="button" onclick="excel()" id="btn-excel" style="float: left;" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Download Excel</button>
      </div>
      <HR>
      </HR>
      <div class="row">
        <div class="col-md-6">
          <div class="input-group mb-3">

            <input type="text" placeholder="Cari Barang Disini...." class="form-control" id="draw">
            <div class="input-group-append">
              <span class="input-group-text bg-primary text-white" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" id="btn-filter" style="float: left;" class="btn btn-primary">Cari Data</button>
            <button class="btn btn-info" onclick="reload_table()"><i class="fa-solid fa-rotate-right"></i> Refresh</button>
          </div>
        </div>
      </div>
      </form>

      <!-- Table -->
      <div class="table-responsive-md">
        <table id='brgNotTerjual' class='table table-striped' style="width:100%">

          <thead>
            <tr>

              <th>Nama Barang</th>
              <th>HET</th>
              <th>HBT</th>
              <th>Stok</th>



            </tr>
          </thead>
          <!-- <tfoot>
    <tr>
        <th></th>
        <th colspan="3" style="text-align:right"></th>
        <th style="text-align:right">Qty = <span id="qtytotal">0</span></th>
        <th></th>
        <th style="text-align:right">Total = <span id="totaal">0</span></th>

    </tr>
</tfoot> -->

        </table>
      </div>
    </div>
  </div>
  </div>




  <br>

</section>



<style>
  a {
    color: gray;
  }

  a:link {
    text-decoration: none;
  }


  a:visited {
    text-decoration: none;
  }


  a:hover {
    text-decoration: none;
  }


  a:active {
    text-decoration: none;
  }
</style>

<script>
 <?php if( $stat == 1) {?>
      
     
      var save_method; //for save method string
      var table;
      var table2;
      var master = 'xTransak'
      var detil = 'xTransakDetil'
      <?php } else {?>

        var save_method; //for save method string
      var table;
      var table2;
      var master = 'Transak'
      var detil = 'TransakDetil'
      <?php } ?>
  $('#AllSupp')[0].checked = true;
  // ("#AllSupp").attr("checked", true);
  // ("#AllSupp").prop('checked', true);
  $('#supp').hide();

  $("#AllSupp").change(function() {
    if ($('#AllSupp').is(':checked')) {
      $('#supp').hide();
      $('#supp option').eq(0).prop('selected', true);
    } else {
      $('#supp').show();
    }
  });
  $(function() {
    $('#validasifilt').hide();

    $("#supp").autocomplete({
      source: function(request, response) {
        // Fetch data
        $.ajax({
          url: "<?php echo site_url('Barang/Search'); ?>",
          type: 'post',
          dataType: "json",
          data: {
            search: request.term
          },
          success: function(data) {
            response(data);
          }
        });
      },
      select: function(event, ui) {
        // Set selection
        $('#supp').val(ui.item.label); // display the selected text
        $('#supp').val(ui.item.value); // save selected id to input
        return false;
      }
    });



    // $('.daterange-cus').daterangepicker({

    // });
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
        drops: 'up',
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

    $('#btn-filter').click(function() { //button filter event click
delete_grid();
      draw_grid();
      table.ajax.reload(); //just reload table
      // $('#rekapKasir').DataTable().reset();
    


    });
  });

  function draw_grid() {
  
    // $('input[type=search]').hide();
    table = $('#brgNotTerjual').DataTable({
      "pageLength": 5,
      // "className": 'details-control',
      "dom": '<"pull-left"><"pull-right">itp',
      retrieve: true,
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.
      // "searchPanes": {
      //    " viewTotal": true
      // },


      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('Laporan/BrgTakTerjual/brgNotTerjualList' )?>/" + master +"/" + detil,
        "type": "POST",
        "data": function(data) {
 
          data.min = $('#split1').val();
          data.max = $('#split2').val();
          data.KDSUP = $('#supp').val();
          data.NAMABRG = $('#draw').val();
          data.AWAL = $('#stok1').val();
          data.AKHIR = $('#stok2').val();

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
      "columns": [{
          "className": 'kdbrg'
        },
        {
          "className": 'brg  text-right'
        },
        {
          "className": 'supp  text-right'
        },
        {
          "className": 'totalqty text-right'
        }
      ],
    });


  }


  function print() {
    var awal = $('#split1').val();
    var akhir = $('#split2').val();
    var stok1 = $('#stok1').val();
    var stok2 = $('#stok2').val();
    var supp = $('#supp').val();
    var barr = $('#draw').val();
    var value = $('#draw').val();
    if (value.length < 1 && !$('#AllSupp').is(':checked')) {
      if (supp.length < 1) {
        error();
        $('#validasifilt').show();
      } else {
        $('#validasifilt').hide();
        myw = window.open('<?php echo base_url() ?>Laporan/BrgTakTerjual/printNotTerjualWithSupp/' + awal + '/' + akhir + '/' + supp+ '/' + master + '/' + detil + '/' + stok1 + '/' + stok2 );
;

        myw.document.close(); //missing code


        myw.focus();
      }
    } else if (value.length > 0 && $('#AllSupp').is(':checked')) {
      myw = window.open('<?php echo base_url() ?>Laporan/BrgTakTerjual/printNotTerjual/' + awal + '/' + akhir + '/' + btoa(barr)+ '/' + master + '/' + detil + '/' + stok1 + '/' + stok2 );
;

      myw.document.close(); //missing code


      myw.focus();

    } else if (value.length > 0 && !$('#AllSupp').is(':checked')) {
      if (supp.length < 1) {
        error();
        $('#validasifilt').show();
      } else {
        $('#validasifilt').hide();
        myw = window.open('<?php echo base_url() ?>Laporan/BrgTakTerjual/printNotTerjualBoth/' + awal + '/' + akhir + '/' + btoa(barr) + '/' + supp+ '/' + master + '/' + detil + '/' + stok1 + '/' + stok2  );
;
        myw.document.close(); //missing code


        myw.focus();
      }
    } else {
      myw = window.open('<?php echo base_url() ?>Laporan/BrgTakTerjual/printNotTerjualAll/' + awal + '/' + akhir+ '/' + master + '/' + detil + '/' + stok1 + '/' + stok2 );
;
      myw.document.close(); //missing code


      myw.focus();
    }


  }
  function delete_grid() {
        $('#brgNotTerjual').DataTable().clear().destroy();
    }
  function excel() {
    var awal = $('#split1').val();
    var akhir = $('#split2').val();
    var supp = $('#supp').val();
    var barr = $('#draw').val();
    var value = $('#draw').val();
    var stok1 = $('#stok1').val();
    var stok2 = $('#stok2').val();
    if (value.length < 1 && !$('#AllSupp').is(':checked')) {
      if (supp.length < 1) {
        error();
        $('#validasifilt').show();
      } else {
        $('#validasifilt').hide();
        myw = window.open('<?php echo base_url() ?>Laporan/BrgTakTerjual/excelNotTerjualWithSupp/' + awal + '/' + akhir + '/' + supp+ '/' + master + '/' + detil+ '/' + stok1 + '/' + stok2  );
;

        myw.document.close(); //missing code


        myw.focus();
      }
    } else if (value.length > 0 && $('#AllSupp').is(':checked')) {
      myw = window.open('<?php echo base_url() ?>Laporan/BrgTakTerjual/excelNotTerjual/' + awal + '/' + akhir + '/' + btoa(barr)+ '/' + master + '/' + detil + '/' + stok1 + '/' + stok2 );
;

      myw.document.close(); //missing code


      myw.focus();

    } else if (value.length > 0 && !$('#AllSupp').is(':checked')) {
      if (supp.length < 1) {
        error();
        $('#validasifilt').show();
      } else {
        $('#validasifilt').hide();
        myw = window.open('<?php echo base_url() ?>Laporan/BrgTakTerjual/excelNotTerjualBoth/' + awal + '/' + akhir + '/' + btoa(barr) + '/' + supp+ '/' + master + '/' + detil + '/' + stok1 + '/' + stok2 );
;
        myw.document.close(); //missing code


        myw.focus();
      }
    } else {
      myw = window.open('<?php echo base_url() ?>Laporan/BrgTakTerjual/excelNotTerjualAll/' + awal + '/' + akhir+ '/' + stok1 + '/' + stok2 );

      myw.document.close(); //missing code


      myw.focus();
    }



  }

  function error() {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Kolom Supplier Wajib Diisi',

    })
  }
</script>