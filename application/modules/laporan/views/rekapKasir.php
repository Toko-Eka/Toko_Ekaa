<section>


  <div class="col-md-6 col-sm-12 text-right">

  </div>
  </div>
  </div>

  <div class="card" style="margin: auto; width: 100%;">
    <div class="card-header"></div>
    <div class="card-body">
      <div class="form-group">
    
        <h4>Laporan Rekap Kasir</h4>

        <hr>

        <div class="form-check">
          <input class="form-check-input" type="radio" name="exampleRadios" id="rkpkasir" value="option1" checked>
          <label class="form-check-label" for="exampleRadios1">
            Cetak Rekap
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="exampleRadios" id="rkptotal" value="option2">
          <label class="form-check-label" for="exampleRadios2">
            Cetak Total
          </label>
        </div>
        <div id="filter">
          <div class="form-group">
            <label for="iduser">Kasir</label>
            <input type="text" name="usr" class="form-control" id="iduser" value="<?= $this->session->userdata('UserID'); ?>">
          </div>
          </div>
          <div class="form-group">



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
        <input type="text" name="tgl_awal" id="splitb1" hidden>
        <input type="text" name="tgl_akhir" id="splitb2" hidden>

      </div>   <div class="btn-group" role="group" aria-label="Basic example">
                           
                           <!-- <button type="button" id="btn-reset" onclick="delete_grid()" style="float: left;"class="btn btn-warning ">Reset</button> -->
                           <button type="button" onclick="print()" id="btn-print" style="float: left;" class="btn btn-primary"><i class="fa-solid fa-print"></i> Print</button>
                           <button type="button" onclick="excel()" id="btn-excel" style="float: left;" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Download Excel</button>
                       </div>
    </div>
  </div>
  <div class="card">
    <div class="card-body">

      <div class="row">
       
          <div id="k2">
    
          <div class="col-md-12">
          <div class="input-group mb-3">

    <input type="text" placeholder="Cari Supplier Disini...." class="form-control" id="draw2">
    <div class="input-group-append">
      <span class="input-group-text bg-primary text-white" id="basic-addon1"><i class="fas fa-search"></i></span>
    </div>
 

    </div>
        </div>
</div><div id="k1">
<div class="col-md-12">
          <div class="input-group mb-3">
            <input type="text" placeholder="Cari Nota Disini...." class="form-control" id="draw">
            <div class="input-group-append">
              <span class="input-group-text bg-primary text-white" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
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
    </div>
    <!-- Table -->
    <div id="rekapcash" class="table-responsive-md">
      <table id='rekapKasir' class='table table-striped' style="width:100%">

        <thead>
          <tr>
            <th width="10%"></th>
            <th>#</th>
            <th>Tanggal</th>
            <th>NOTA</th>

            <th>SUBTOTAL</th>


          </tr>
        </thead>
        <tfoot>
          <tr>
            <!-- <th></th> -->
            <!-- <th colspan="3" style="text-align:right"></th>
                                            <th style="text-align:right">Qty = <span id="qtytotal">0</span></th> -->
            <th></th>
            <th colspan="4" style="text-align:right">Total = <span id="totaal">0</span></th>

          </tr>
        </tfoot>

      </table>
    </div>
    <div id="rekaptotalsupp" class="table-responsive-md">
      <table id='rekaptotal' class='table table-striped' style="width:100%">

        <thead>
          <tr>
         
            <th>#</th>
            <th>KASSA</th>
            <th>SUPPLIER</th>

            <th>TOTAL</th>


          </tr>
        </thead>
        <tfoot>
          <tr>
            <!-- <th></th> -->
            <!-- <th colspan="3" style="text-align:right"></th>
                                            <th style="text-align:right">Qty = <span id="qtytotal">0</span></th> -->
            <th></th>
            <th colspan="3" style="text-align:right">Total = <span id="ttl">0</span></th>

          </tr>
        </tfoot>

      </table>
    </div>
  </div>
  </div>
  </div>


  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>

  <br>

</section>


<!-- Table -->

<!-- End Bootstrap modal -->
<!-- Script -->

      
<script type="text/javascript">
  var save_method; //for save method string
  var table;
  var table2;
  var master = 'xTransak'
  var detil = 'xTransakDetil'
  $("#AllSupp").prop('checked', false);
  $("#AllBrg").prop('checked', false);
  $('#supp').hide();
  $('#brg').hide();
  $("#rkpkasir").change(function() {
    if ($('#rkpkasir').is(':checked')) {
      // $('.daterange-cus').show();
      $('#filter').show();
      $('#rekapcash').show();
      $('#rekaptotalsupp').hide();
      $('#k1').show();
      $('#k2').hide();
    }

  });
  $("#rkptotal").change(function() {
    if ($('#rkptotal').is(':checked')) {
      // $('.daterange-cus').hide();
      $('#filter').hide();
      $('#rekapcash').hide();
      $('#rekaptotalsupp').show();
      $('#k1').hide();
      $('#k2').show();
    }

  });
  $(document).ready(function() {
    // $('#btn-reset').click();
    // $('#supp').select2();
    // $('#supp2').select2();
    $('#rekaptotalsupp').hide();
    $('#k2').hide();
    //datatables

      $("#brg").autocomplete({
        source: function(request, response) {
          // Fetch data
          $.ajax({
            url: "<?php echo site_url('Barang/searchBrg'); ?>",
            type: 'post',
            dataType: "json",
            data: {
              searchBar: request.term
            },
            success: function(data) {
              response(data);
            }
          });
        },
        select: function(event, ui) {
          // Set selection
          $('#brg').val(ui.item.label); // display the selected text
          //   $('#idsupp').val(ui.item.value); // save selected id to input
          return false;
        }
      })
      $( "#draw" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url: "<?php echo site_url('Laporan/Kasir/searchNota'); ?>",
            type: 'post',
            dataType: "json",
            data: {
              searchNot: request.term
            },
            success: function( data ) {
              response(data);
            }
          });
        },
        select: function (event, ui) {
          // Set selection
          $('#brg').val(ui.item.label); // display the selected text
        //   $('#supp').val(ui.item.value); // save selected id to input
          return false;
        }
      })
      $("#iduser").autocomplete({
        source: function(request, response) {
          // Fetch data
          $.ajax({
            url: "<?php echo site_url('Laporan/Kasir/Search'); ?>",
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
          $('#iduser').val(ui.item.label); // display the selected text
       
          return false;
        }
      });


    $('#btn-filter').click(function() { //button filter event click
      if ($('#rkptotal').is(':checked')) {
      // $('.daterange-cus').hide();
      delete_grid2();
     draw_gridtTotal();
getGrandTotalAll();
  
  
  } else if ($('#rkpkasir').is(':checked')) {
      delete_grid();
      var value = $('#draw').val();
      if (value.length < 1 && $('#rkpkasir').is(':checked')) {
        getGrandTotalWBoth();
      } else if (value.length > 0 && $('#rkpkasir').is(':checked')) {
        getGrandTotalSearch();

      } else if (value.length > 0 && $('#rkptotal').is(':checked')) {
        getGrandTotalWBoth();
      } else if (value.length < 1 && $('#rkptotal').is(':checked')) {
        getGrandTotalSearch();
      }
      draw_grid();
      // table.ajax.reload(); //just reload table
      // $('#rekapKasir').DataTable().reset();
    }

    });
    $('#btn-print').click(function() { //button filter event click
      table.ajax.reload(); //just reload table
    });
    $('#btn-reset').click(function() { //button reset event click
      $('#filter')[0].reset();
      table.ajax.reload(); //just reload table
    });


    var startDate = moment();
    var endDate = moment();

    function cb(startDate, endDate) {
      $('.daterange-cus span').html(startDate.format('MMMM D, YYYY') + ' s/d ' + endDate.format('MMMM D, YYYY'))
    }
    // function cb(startDate, endDate) {
    //     $('#daterange-cus span').html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
    // }
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
      // function (startDate, endDate) {
      //   $('.daterange-cus span').html(startDate.format('MMMM D, YYYY') + ' s/d ' + endDate.format('MMMM D, YYYY'))
      // }
    );
    cb(startDate, endDate);
    var startDate = $('.daterange-cus').data('daterangepicker').startDate.format('YYYY-MM-DD');
    var endDate = $('.daterange-cus').data('daterangepicker').endDate.format('YYYY-MM-DD');
    $('#split1').val(startDate);
    $('#split2').val(endDate);
    $('#splitb1').val(startDate);
    $('#splitb2').val(endDate);
    $('.ranges').click(function() {
      var startDate = $('.daterange-cus').data('daterangepicker').startDate.format('YYYY-MM-DD');
      var endDate = $('.daterange-cus').data('daterangepicker').endDate.format('YYYY-MM-DD    ');
      $('#split1').val(startDate);
      $('#split2').val(endDate);
      $('#splitb1').val(startDate);
    $('#splitb2').val(endDate);
    });


    //datepicker
    // $('.datepicker').datepicker({
    //     autoclose: true,
    //     format: "yyyy-mm-dd",
    //     todayHighlight: true,
    //     orientation: "top auto",
    //     todayBtn: true,
    //     todayHighlight: true,  
    // });

  });


  function delete_grid() {
    $('#rekapKasir').DataTable().clear().destroy();
  }
  function delete_grid2() {
    $('#rekaptotal').DataTable().clear().destroy();
  }

  
  function draw_gridtTotal() {
    // $('input[type=search]').hide();
    table2 = $('#rekaptotal').DataTable({
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
        "url": "<?php echo site_url('Laporan/Kasir/rekapTotalList') ?>/" + master +"/" + detil,
        "type": "POST",
        "data": function(data) {

          data.awal = $('#splitb1').val();
          data.akhir = $('#splitb2').val();
          // data.KASIR = $('#iduser').val();
          data.suplier = $('#draw2').val();

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
          "className": 'suppl'
        },

        {
          "className": 'total text-right'
        },

      ],
    });
   
  }
  

  function draw_grid() {
    // $('input[type=search]').hide();
    table = $('#rekapKasir').DataTable({
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
        "url": "<?php echo site_url('Laporan/Kasir/rekapKasirList') ?>/" + master +"/" + detil,
        "type": "POST",
        "data": function(data) {

          data.min = $('#split1').val();
          data.max = $('#split2').val();
          data.KASIR = $('#iduser').val();
          data.NOTA = $('#draw').val();

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
          "className": 'detail-control'
        },
        {
          "className": 'no'
        },
        {
          "className": 'tgl'
        },
        {
          "className": 'nota'
        },


        {
          "className": 'total text-right'
        },

      ],
    });
    $("#draw").keyup(function() {
      // table.search( this.value ).draw();
      var value = $(this).val();
      // if ( value.length > 0 ) {
      //     getGrandTotalSearch();
      // }
      // var a = $( "#draw" ).val();
      // $('input[type=search]').val(a);
    });
    $("#rekapKasir tbody").on('click', 'td.detail-control', function() {


      var tr = $(this).closest('tr');
      var row = table.row(tr);
      // console.log(tr)
      // console.log(row.data()[4])
      if (row.child.isShown()) {
        tr.removeClass('shown');
        document.getElementsByClassName("fa fa-minus" + (parseInt(row.data()[0]) - 1)).className = "fa fa-plus";
      
        row.child.hide();
       
      } else {
        tr.addClass('shown');
        // Open this row
        document.getElementsByClassName("fa fa-plus" + (parseInt(row.data()[0]) - 1)).className = "fa fa-minus";
        // var splt = row.data()[4].split("/");
        // var data2 = splt[0].split(">");
        var data = row.data()[3];
        // console.log(data)
        format(data, row);

        // row.child( format(data) ).show();
      

      }
    });
  }

  function format(nota, row) {
    // getajax(soid);
    // console.log(nota);
    $.ajax({
      type: "POST",
      global: false,
      url: "<?= site_url('Laporan/kasir/getRekapDetail') ?>",
      data: {
        'id': nota,
      },

      success: function(response) {

        var html = '<table cellpadding="0" id="detailtb" cellspacing="0" border="0" style="width:60%;">' +
          '<tr>' +
          '<td width="5%">No</td>' +
          '<td width="15%">KDBRG</td>' +
          '<td width="30%">NAMABRG</td>' +
          '<td width="15%" align="right">HARGA</td>' +
          '<td width="5%" align="right">Qty</td>' +

          '<td width="15%" align="right">Subtotal</td>' +
          '</tr>';
        // console.log(response);

        var detailRecord = JSON.parse(response);
        var no = 1;
        for (let index = 0; index < detailRecord.length; index++) {
          var subtotal = detailRecord[index]['HARGA'] * detailRecord[index]['JMLBRG'];
          html += '<tr>' +
            '<td width="5%">' + number_format(no, 0, ",", ".") + '</td>' +
            '<td width="15%">' + detailRecord[index]['KDBRG'] + '</td>' +
            '<td width="30%">' + detailRecord[index]['NAMABRG'] + '</td>' +
            '<td width="15%" align="right">' + number_format(detailRecord[index]['HARGA'], 0, ",", ".") + '</td>' +
            '<td width="5%" align="right">' + number_format(detailRecord[index]['JMLBRG'], 0, ",", ".") + '</td>' +

            '<td width="15%" align="right">' + number_format(subtotal, 0, ",", ".") + '</td>' +
            '</tr>';
          no = no + 1;
        }

        html += '</table>';
        row.child(html).show();

      }

    });

  }

  function print() {
    var awal = $('#split1').val();
      var akhir = $('#split2').val();
      var supp = $('#draw2').val();
    if ($('#rkptotal').is(':checked') && supp.length < 1)  {
      // send3();


      // var brg= $('#brg').val();
      myw = window.open('<?php echo base_url() ?>Laporan/Kasir/printRekapTotalNoSupp/' + awal + '/' + akhir +'/' + master + '/' + detil  );

      myw.document.close(); //missing code


      myw.focus();

    } else if ($('#rkptotal').is(':checked') && supp.length > 0){
      myw = window.open('<?php echo base_url() ?>Laporan/Kasir/printRekapTotal/' + awal + '/' + akhir +'/' + supp +'/' + master + '/' + detil );

myw.document.close(); //missing code


myw.focus();
    }
    else if ($('#rkpkasir').is(':checked')) {
      // sendNoBrg();
    
      var user = $('#iduser').val();
      myw = window.open('<?php echo base_url() ?>Laporan/Kasir/printRekapKasir/' + awal + '/' + akhir + '/' + btoa(user)+'/' + master + '/' + detil );

      myw.document.close(); //missing code


      myw.focus();

    }

    // myw = myWindow.document.write("<p>This is 'myWindow'</p>");


  }

  function excel() {
    var awal = $('#split1').val();
      var akhir = $('#split2').val();
      var supp = $('#draw2').val();
      var user = $('#iduser').val();
      var brg = $('#draw').val();
    if ($('#rkptotal').is(':checked') && supp.length < 1)  {
      // send3();


      // var brg= $('#brg').val();
      myw = window.open('<?php echo base_url() ?>Laporan/Kasir/ExcelRekapTotalNoSupp/' + awal + '/' + akhir +'/' +supp+'/'+ master + '/' + detil  );

      myw.document.close(); //missing code


      myw.focus();

    } else if ($('#rkptotal').is(':checked') && supp.length > 0){
      myw = window.open('<?php echo base_url() ?>Laporan/Kasir/ExcelRekapTotal/' + awal + '/' + akhir +'/' + master + '/' + detil );

myw.document.close(); //missing code


myw.focus();
    }
    else if ($('#rkpkasir').is(':checked')) {
      // sendNoBrg();
    
      
      myw = window.open('<?php echo base_url() ?>Laporan/Kasir/ExcelRekapKasir/' + awal + '/' + akhir + '/' + btoa(user) +'/' + master + '/' + detil );

      myw.document.close(); //missing code


      myw.focus();

    }
    // myw = myWindow.document.write("<p>This is 'myWindow'</p>");


  }
  // myw = myWindow.document.write("<p>This is 'myWindow'</p>");



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

  function getGrandTotalSearch() {
    var notr = $('#draw').val();
    var user = $('#iduser').val();
    var tglAwal = $('#split1').val();
    var tglAkhir = $('#split2').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('Laporan/kasir/getGrandTotalWBoth') ?>",
      dataType: "JSON",
      data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "nota": notr,
        "user": user,
        "master": master,
        "detil": detil,
 
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
  function getGrandTotalAll() {
    var supp = $('#draw2').val();
  
    var tglAwal = $('#split1').val();
    var tglAkhir = $('#split2').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('Laporan/kasir/getGrandTotalRekap') ?>",
      dataType: "JSON",
      data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "kdsup": supp,
        "master": master,
        "detil": detil,
      
 
      },
      cache: false,
      success: function(data) {
        $.each(data, function(GRANDTOTAL, JML) {
          $('#ttl').text(number_format(data.GRANDTOTAL));
          // $('#qtytotal').text(number_format(data.JML));


        });

      }
    });
    return false;
  };
  function getGrandTotalWBoth() {

    var tglAwal = $('#split1').val();
    var tglAkhir = $('#split2').val();
    var user = $('#iduser').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('Laporan/kasir/getGrandTotal') ?>",
      dataType: "JSON",
      data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "user": user,
        "master": master,
        "detil": detil,
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
      url: "<?php echo base_url('Laporan/kasir/getGrandTotalWSupp') ?>",
      dataType: "JSON",
      data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "supp": kdsupp,
        "master": master,
        "detil": detil,
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
      url: "<?php echo base_url('Laporan/kasir/getGrandTotalWBrg') ?>",
      dataType: "JSON",
      data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "namabrg": namaBrg,
        "master": master,
        "detil": detil,
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
  /// end of all
</script>

</div>


</section>