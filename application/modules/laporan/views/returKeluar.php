<section>

  <div class="col-md-6 col-sm-12 text-right">

  </div>
  </div>
  </div>

  <div class="card" style="margin: auto; width: 100%;">
    <div class="card-header">Laporan Retur Keluar</div>
    <div class="card-body">
      <div class="form-group">
        <h4>Retur Keluar</h4>
        <hr>
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
        <div class="btn-group" role="group" aria-label="Basic example">

<!-- <button type="button" id="btn-reset" onclick="delete_grid()" style="float: left;"class="btn btn-warning ">Reset</button> -->
<button type="button" onclick="print()" id="btn-print" style="float: left;" class="btn btn-primary"><i class="fa-solid fa-print"></i> Print</button>
<button type="button" onclick="excel()" id="btn-excel" style="float: left;" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Download Excel</button>
</div>
        <input type="text" name="tgl_awal" id="split1" hidden>
        <input type="text" name="tgl_akhir" id="split2" hidden>
      </div>    <HR></HR>
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
                            <table id='retM' class='table table-striped' style="width:100%">

<thead>
    <tr>

        <th>Tanggal Entry</th>
        <th>Tanggal NOTA</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>KET</th>
       

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

</table> </div>
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
  $(document).ready(function() {
    $('#validasifilt').hide();
    $('#supp').hide();
    $('#AllSupp')[0].checked = true;
    $("#AllSupp").change(function() {
      if ($('#AllSupp').is(':checked')) {
        $('#supp').hide();
        $('#supp option').eq(0).prop('selected', true);
      } else {
        $('#supp').show();
      }
    });
    $(function() {

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
          $('#idsupp').val(ui.item.value); // save selected id to input
          return false;
        }
      });



      // $('.daterange-cus').daterangepicker({

      // });


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

    $('#btn-filter').click(function(){ //button filter event click
      var value = $('#draw').val();
            if (value.length < 1 && !$('#AllSupp').is(':checked')) {
                getGrandTotalWSupp();
            } else if (value.length > 0 && $('#AllSupp').is(':checked')) {
                getGrandTotalWBrg();

            } else if (value.length > 0 && $('#AllSupp').is(':checked')) {
                getGrandTotalWBoth();
            } else {
                getGrandTotal();
            }
    draw_grid();
    table.ajax.reload();  //just reload table
    // $('#rekapKasir').DataTable().reset();


});
  });
  function draw_grid() {
        // $('input[type=search]').hide();
        table = $('#retM').DataTable({
            "pageLength": 5,
            // "className": 'details-control',
            "dom": '<"pull-left"><"pull-right">tp',
            retrieve: true,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            // "searchPanes": {
            //    " viewTotal": true
            // },


            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('Laporan/L_returKeluar/retKeluarList') ?>",
                "type": "POST",
                "data": function(data) {

                    data.min = $('#split1').val();
                    data.max = $('#split2').val();
                    data.KDSUP = $('#supp').val();
                    // data.NAMABRG = $('#draw').val();

                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [-1], //last column
                    "orderable": false, //set not orderable
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
                    "className": 'nota'
                },
                {
                    "className": 'kdbrg'
                },
                {
                    "className": 'brg'
                },
                {
                    "className": 'supp '
                },
                {
                    "className": 'KET'
                }
            ],
        });


    }

  function print() {
    if ($('#AllSupp').is(':checked')) {
      var awal = $('#split1').val();
      var akhir = $('#split2').val();
      myw = window.open('<?php echo base_url() ?>Laporan/L_returKeluar/print/' + awal + '/' + akhir);

      myw.document.close(); //missing code


      myw.focus();

      // send3();
      // var tglAwal= $('#split1').val();
      // var tglAkhir= $('#split2').val();
      // var supp= $('#idsupp').val();
      // var brg= $('#brg').val();




    } else {
      var supp = $('#supp').val();
      var awal = $('#split1').val();
      var akhir = $('#split2').val();
      if (supp.length < 1) {
        error();
                    $('#validasifilt').show();
                } else {
                    $('#validasifilt').hide();
      myw = window.open('<?php echo base_url() ?>Laporan/L_returKeluar/printWSupp/' + awal + '/' + akhir + '/' + supp);

      myw.document.close(); //missing code


      myw.focus();
    }
  }
  }

  function excel() {
    if ($('#AllSupp').is(':checked')) {
      var awal = $('#split1').val();
      var akhir = $('#split2').val();
      myw = window.open('<?php echo base_url() ?>Laporan/L_returKeluar/excel/' + awal + '/' + akhir);

      myw.document.close(); //missing code


      myw.focus();

      // send3();
      // var tglAwal= $('#split1').val();
      // var tglAkhir= $('#split2').val();
      // var supp= $('#idsupp').val();
      // var brg= $('#brg').val();




    } else {
      var supp = $('#supp').val();
      var awal = $('#split1').val();
      var akhir = $('#split2').val();
      if (supp.length < 1) {
        error();
                    $('#validasifilt').show();
                } else {
                    $('#validasifilt').hide();
      myw = window.open('<?php echo base_url() ?>Laporan/L_returKeluar/excelWSupp/' + awal + '/' + akhir + '/' + supp);
      myw.document.close(); //missing code


      myw.focus();
                }

    }
  }
  function getGrandTotal() {

var tglAwal = $('#split1').val();
var tglAkhir = $('#split2').val();
$.ajax({
    type: "POST",
    url: "<?php echo base_url('transJual/getGrandTotal') ?>",
    dataType: "JSON",
    data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir
    },
    cache: false,
    success: function(data) {
        $.each(data, function(GRANDTOTAL, JML) {
            $('#totaal').text(number_format(data.GRANDTOTAL));
            $('#qtytotal').text(number_format(data.JML));


        });

    }
});
return false;
};

function getGrandTotalWBoth() {

var tglAwal = $('#split1').val();
var tglAkhir = $('#split2').val();
var kdsupp = $('#idsupp').val();
var namaBrg = $('#draw').val();
$.ajax({
    type: "POST",
    url: "<?php echo base_url('transJual/getGrandTotalWBoth') ?>",
    dataType: "JSON",
    data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "namabrg": namaBrg,
        "supp": kdsupp
    },
    cache: false,
    success: function(data) {
        $.each(data, function(GRANDTOTAL, JML) {
            $('#totaal').text(number_format(data.GRANDTOTAL));
            $('#qtytotal').text(number_format(data.JML));


        });

    }
});
return false;
};

function getGrandTotalWSupp() {

var tglAwal = $('#split1').val();
var tglAkhir = $('#split2').val();
var kdsupp = $('#idsupp').val();
// var namaBrg= $('#brg').val();
$.ajax({
    type: "POST",
    url: "<?php echo base_url('transJual/getGrandTotalWSupp') ?>",
    dataType: "JSON",
    data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "supp": kdsupp
    },
    cache: false,
    success: function(data) {
        $.each(data, function(GRANDTOTAL, JML) {
            $('#totaal').text(number_format(data.GRANDTOTAL));
            $('#qtytotal').text(number_format(data.JML));


        });

    }
});
return false;
};

function getGrandTotalWBrg() {

var tglAwal = $('#split1').val();
var tglAkhir = $('#split2').val();
//  var kdsupp= $('#idsupp').val();
var namaBrg = $('#draw').val();
$.ajax({
    type: "POST",
    url: "<?php echo base_url('transJual/getGrandTotalWBrg') ?>",
    dataType: "JSON",
    data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "namabrg": namaBrg
    },
    cache: false,
    success: function(data) {
        $.each(data, function(GRANDTOTAL, JML) {
            $('#totaal').text(number_format(data.GRANDTOTAL));
            $('#qtytotal').text(number_format(data.JML));

        });

    }
});
return false;
};
function error() {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Kolom Supplier Wajib Diisi',

    })
  }
</script>