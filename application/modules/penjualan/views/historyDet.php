<section>

   
    <div class="col-md-6 col-sm-12 text-right">

    </div>
    </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card bg-defaullt">


                <div class="card" style="margin: auto; width: 100%;">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <div class="form-group">
                            <h4>Rincian Jual</h4>
                            <hr>



                            <form id="filter" method="POST" class="form-horizontal">
                                <div class="row">
                                    <div class="col-md-5">

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
                                    </div>
                                    <div class="col-md-2">
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
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="country" class="control-label">Barang</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="AllBrg">
                                                <label class="form-check-label" for="AllBrg">
                                                    Semua Barang
                                                </label>
                                            </div>
                                            <input class="form-control" type="text" id="brg" />

                                        </div>
                                    </div> -->
                                    <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="FirstName" class="control-label">Nama Barang</label>
                      
                            <input type="text" class="form-control" id="nama">
                        
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="LastName" class="control-label">Jumlah</label>
                       
                            <input type="text" class="form-control" id="stok">
                       
                    </div>
                    </div> -->
                                    <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" id="address"></textarea>
                        </div>
                    </div>
                    </div> -->
                                    <input type="text" name="tgl_awal" id="split1" hidden>
                                    <input type="text" name="tgl_akhir" id="split2" hidden>

                                </div>


                                <div class="btn-group" role="group" aria-label="Basic example">
                           
                           <!-- <button type="button" id="btn-reset" onclick="delete_grid()" style="float: left;"class="btn btn-warning ">Reset</button> -->
                           <button type="button" onclick="print()" id="btn-print" style="float: left;" class="btn btn-primary"><i class="fa-solid fa-print"></i> Print</button>
                           <button type="button" onclick="excel()" id="btn-excel" style="float: left;" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Download Excel</button>
                       </div>



                        </div>
                    </div>
                    <div class="card">
                        <!-- <div class="card-header">
                    <h4>Tabel Barang</h4>
                 
                  </div> -->
                        <div class="card-body">
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
                                </form>
                            </div>
                            <!-- Table -->
                            <div class="table-responsive-md">
                                <table id='tableHisjual' class='table table-striped' style="width:100%">

                                    <thead>
                                        <tr>

                                            <th>NOTA</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Supplier</th>
                                            <th>qty</th>
                                            <th>Harga Jual</th>

                                            <th>SUBTOTAL</th>
                                            <th>Tanggal</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th colspan="3" style="text-align:right"></th>
                                            <th style="text-align:right">Qty = <span id="qtytotal">0</span></th>
                                            <th></th>
                                            <th style="text-align:right">Total = <span id="totaal">0</span></th>

                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Barang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body data">
                <form action="#" id="data" class="form-horizontal">

                    <div class="form-body">
                        <div class="form-group">
                            <label id="lbl" class="control-label col-md-3">Kode Barang</label>
                            <div class="col-md-9">
                                <input style="text-transform:uppercase" name="KDBRG" placeholder="Kode Barang" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jenis</label>
                            <div class="col-md-9">
                                <input style="text-transform:uppercase" name="JENIS" placeholder="Jenis" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Barang</label>
                            <div class="col-md-9">
                                <input style="text-transform:uppercase" name="NAMABRG" placeholder="Nama Barang" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label class="control-label col-md-3">Gender</label>
                            <div class="col-md-9">
                                <select name="gender" class="form-control">
                                    <option value="">--Select Gender--</option>
                                    <option value="male">Male</option>
                                    <option valyjnue="female">Female</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="control-label col-md-3">Supplier</label>
                            <div class="col-md-9">
                                <?php echo $supplierList2; ?> <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jumlah</label>
                            <div class="col-md-9">
                                <input style="text-transform:uppercase" type="number" name="AKHIR" placeholder="Jumlah" class="form-control"></input>
                                <span class="help-block"></span>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<!-- Script -->
<style>
    input[type=search] {
        display: none;
    }
</style>
<?php if( $strat == 1) {?>
      
      <script type="text/javascript">
        var save_method; //for save method string
        var table;
        var table2;
        var master = 'xTransak'
        var detil = 'xTransakDetil'
        $(document).ready(function() {
        $("#AllSupp").prop('checked', true);
        $("#AllBrg").prop('checked', true);
        $('#supp').hide();
        $('#brg').hide();
        $('#validasifilt').hide();
        $("#AllSupp").change(function() {
            if ($('#AllSupp').is(':checked')) {
                $('#supp').hide();
                $('#supp').val('');
                $('#supp').val('');
            } else {
                $('#supp').show();
            }
        });



        // $('#btn-reset').click();
        // $('#supp').select2();
        // $('#supp2').select2();

        //datatables

        $("#draw").autocomplete({
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
                $('#draw').val(ui.item.label); // display the selected text
                //   $('#supp').val(ui.item.value); // save selected id to input
                return false;
            }
        })


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


        $('#btn-filter').click(function() { //button filter event click
            var value = $('#draw').val();
            var suplier = $('#supp').val();
            if (value.length < 1 && suplier.length > 0) {
                getGrandTotalWSupp();
            } else if (value.length > 0 && suplier.length < 1) {
                getGrandTotalWBrg();

            } else if (value.length > 0 && suplier.length > 0) {
                getGrandTotalWBoth();
            } else {
                getGrandTotal();
            }
          delete_grid();
            draw_grid();
           
           //just reload table
            // $('#tableHisjual').DataTable().reset();


        });
        $('#btn-print').click(function() { //button filter event click
            table.ajax.reload(); //just reload table
        });
        $('#btn-reset').click(function() { //button reset event click
            $('#filter')[0].reset();
            table.ajax.reload(); //just reload table
        });

        const monthNames = ["Januari", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];
        var startDate = moment();
        var endDate = moment();

        function cb(startDate, endDate) {
            $('.daterange-cus span').html(startDate.format('DD MMM YYYY') +  '  s/d  ' +  endDate.format('DD MMM YYYY'))
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
                    format: 'DD/MM/YYYY',
                   
        "separator": " - ",
        "applyLabel": "Terapkan",
        "cancelLabel": "Batal",
        "fromLabel": "Dari",
        "toLabel": "Ke",
        "customRangeLabel": "Pilih Tanggal",
        "daysOfWeek": [
            "Min",
            "Sen",
            "Sel",
            "Rab",
            "Kam",
            "Jum",
            "Sab"
        ],
        "monthNames": [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ],
        "firstDay": 1
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
        $('.ranges').click(function() {
            // if ($('#AllSupp').is(':checked') && $('#AllBrg').is(':checked')) {
            //     $('#btn-filter').click();
            // }
            var startDate = $('.daterange-cus').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var endDate = $('.daterange-cus').data('daterangepicker').endDate.format('YYYY-MM-DD    ');
            $('#split1').val(startDate);
            $('#split2').val(endDate);
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
        $('#tableHisjual').DataTable().clear().destroy();
    }

    function getGrandTotal() {

        var tglAwal = $('#split1').val();
        var tglAkhir = $('#split2').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('penjualan/TransJual/getGrandTotal') ?>" ,
            dataType: "JSON",
            data: {
                "tgl_awal": tglAwal,
                "tgl_akhir": tglAkhir,
                "master": master,
                "detil": detil
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
        var kdsupp = $('#supp').val();
        var namaBrg = $('#draw').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('penjualan/TransJual/getGrandTotalWBoth') ?>",
            dataType: "JSON",
            data: {
                "tgl_awal": tglAwal,
                "tgl_akhir": tglAkhir,
                "namabrg": namaBrg,
                "supp": kdsupp,
                "master": master,
                "detil": detil
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
        var kdsupp = $('#supp').val();
        // var namaBrg= $('#brg').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('penjualan/TransJual/getGrandTotalWSupp') ?>",
            dataType: "JSON",
            data: {
                "tgl_awal": tglAwal,
                "tgl_akhir": tglAkhir,
                "supp": kdsupp,
                "master": master,
                "detil": detil
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
        //  var kdsupp= $('#supp').val();
        var namaBrg = $('#draw').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('penjualan/TransJual/getGrandTotalWBrg') ?>",
            dataType: "JSON",
            data: {
                "tgl_awal": tglAwal,
                "tgl_akhir": tglAkhir,
                "namabrg": namaBrg,
                "master": master,
                "detil": detil
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

    function draw_grid() {
        // $('input[type=search]').hide();
        table = $('#tableHisjual').DataTable({
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
                "url": "<?php echo site_url('penjualan/TransJual/trJualDetList') ?>/" + master +"/" + detil,
                "type": "POST",
                "data": function(data) {

                    data.min = $('#split1').val();
                    data.max = $('#split2').val();
                    data.KDSUP = $('#supp').val();
                    data.NAMABRG = $('#draw').val();

                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [-1], //last column
                    // "orderable": false, //set not orderable
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
                    "className": 'totalqty text-right'
                },
                {
                    "className": 'het text-right'
                },
                {
                    "className": 'total text-right'
                },
                {
                    "className": 'tgl'
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
    }




    function excel() {
        var tglAwal = $('#split1').val();
        var tglAkhir = $('#split2').val();
        var value = $('#draw').val();
        var supp = $('#supp').val();

        var brg = $('#draw').val();
        if (value.length < 1 && !$('#AllSupp').is(':checked')) {
            if (supp.length < 1) {
                error();
                $('#validasifilt').show();
            } else {
                $('#validasifilt').hide();
                // send3();


                // var brg= $('#brg').val();
                myw = window.open('<?php echo base_url() ?>penjualan/TransJual/excelDetWOBrg/' + tglAwal + '/' + tglAkhir + '/' + supp+ '/' + master + '/' + detil );

                myw.document.close(); //missing code


                myw.focus();
            }
        } else if ($('#AllSupp').is(':checked') && value.length > 0) {
            // sendNoBrg();
            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            // var supp= $('#supp').val();
            var brg = $('#draw').val();
            myw = window.open('<?php echo base_url() ?>penjualan/TransJual/excelDetWOSupp/' + tglAwal + '/' + tglAkhir + '/' + btoa(brg)+ '/' + master + '/' + detil );

            myw.document.close(); //missing code


            myw.focus();

        } else if (!$('#AllSupp').is(':checked') && value.length > 0) {
            // send();

            if (supp.length < 1) {
                error();
                $('#validasifilt').show();
            } else {
                $('#validasifilt').hide();
                myw = window.open('<?php echo base_url() ?>penjualan/TransJual/excelDet/' + tglAwal + '/' + tglAkhir + '/' + supp + '/' + btoa(brg)+ '/' + master + '/' + detil );

                myw.document.close(); //missing code


                myw.focus();
            }
        } else if (value.length < 1 && $('#AllSupp').is(':checked')) {

            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            // var supp= $('#supp').val();
            var brg = $('#draw').val();
            myw = window.open('<?php echo base_url() ?>penjualan/TransJual/excelDetNo/' + tglAwal + '/' + tglAkhir + '/' + master + '/' + detil );

            myw.document.close(); //missing code


            myw.focus();
            myw.print();

        }
    }

    function print() {
        var value = $('#draw').val();
        var suplier = $('#supp').val();
        if (value.length < 1 && !$('#AllSupp').is(':checked')) {
            // send3();
            if (suplier.length < 1) {
                error();
                $('#validasifilt').show();
            } else {
                $('#validasifilt').hide();
                var tglAwal = $('#split1').val();
                var tglAkhir = $('#split2').val();
                var supp = $('#supp').val();
                // var brg= $('#brg').val();
                myw = window.open('<?php echo base_url() ?>penjualan/TransJual/printDetWOBrg/' + tglAwal + '/' + tglAkhir + '/' + supp + '/' + master + '/' + detil );

                myw.document.close(); //missing code


                myw.focus();
            }
        } else if (value.length > 0 && $('#AllSupp').is(':checked')) {
            // sendNoBrg();
            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            // var supp= $('#supp').val();
            var brg = $('#draw').val();
            myw = window.open('<?php echo base_url() ?>penjualan/TransJual/printDetWOSupp/' + tglAwal + '/' + tglAkhir + '/' + btoa(brg)+ '/' + master + '/' + detil );

            myw.document.close(); //missing code


            myw.focus();

        } else if (value.length > 0 &&  !$('#AllSupp').is(':checked')) {
            // send();
            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            var supp = $('#supp').val();
            var brg = $('#draw').val();
            if (suplier.length < 1) {
                error();
                $('#validasifilt').show();
            } else {
                $('#validasifilt').hide();
            myw = window.open('<?php echo base_url() ?>penjualan/TransJual/printDet/' + tglAwal + '/' + tglAkhir + '/' + supp + '/' + btoa(brg)+ '/' + master + '/' + detil );

            myw.document.close(); //missing code


            myw.focus();
            }
        } else if (value.length < 1 && suplier.length < 1) {

            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            // var supptr= $('#supp').val();
            var brg = $('#draw').val();
            myw = window.open('<?php echo base_url() ?>penjualan/TransJual/printDetNo/' + tglAwal + '/' + tglAkhir + '/' + master + '/' + detil );

            myw.document.close(); //missing code


            myw.focus();



        }
        // myw = myWindow.document.write("<p>This is 'myWindow'</p>");


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





    function reload_table() {
        getGrandTotal()
        table.ajax.reload(null, false);
    }
    function error(){
    Swal.fire({
  icon: 'error',
  title: 'Error',
  text: 'Kolom Supplier Wajib Diisi',

})
   }
</script>

<?php } else { ?>

<script type="text/javascript">
  /// today
var save_method; //for save method string
var table;
var table2;
var master = 'Transak'
var detil = 'TransakDetil'
$(document).ready(function() {
$("#AllSupp").prop('checked', true);
        $("#AllBrg").prop('checked', true);
        $('#supp').hide();
        $('#brg').hide();
        $('#validasifilt').hide();
        $("#AllSupp").change(function() {
            if ($('#AllSupp').is(':checked')) {
                $('#supp').hide();
                $('#supp').val('');
                $('#supp').val('');
            } else {
                $('#supp').show();
            }
        });



        // $('#btn-reset').click();
        // $('#supp').select2();
        // $('#supp2').select2();

        //datatables

        $("#draw").autocomplete({
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
                $('#draw').val(ui.item.label); // display the selected text
                //   $('#supp').val(ui.item.value); // save selected id to input
                return false;
            }
        })


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


        $('#btn-filter').click(function() { //button filter event click
            var value = $('#draw').val();
            var suplier = $('#supp').val();
            if (value.length < 1 && suplier.length > 0) {
                getGrandTotalWSupp();
            } else if (value.length > 0 && suplier.length < 1) {
                getGrandTotalWBrg();

            } else if (value.length > 0 && suplier.length > 0) {
                getGrandTotalWBoth();
            } else {
                getGrandTotal();
            }
          delete_grid();
            draw_grid();
           
           //just reload table
            // $('#tableHisjual').DataTable().reset();


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
        $('.ranges').click(function() {
            // if ($('#AllSupp').is(':checked') && $('#AllBrg').is(':checked')) {
            //     $('#btn-filter').click();
            // }
            var startDate = $('.daterange-cus').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var endDate = $('.daterange-cus').data('daterangepicker').endDate.format('YYYY-MM-DD    ');
            $('#split1').val(startDate);
            $('#split2').val(endDate);
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
        $('#tableHisjual').DataTable().clear().destroy();
    }

    function getGrandTotal() {

        var tglAwal = $('#split1').val();
        var tglAkhir = $('#split2').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('penjualan/TransJual/getGrandTotal') ?>",
            dataType: "JSON",
            data: {
                "tgl_awal": tglAwal,
                "tgl_akhir": tglAkhir,
                "master": master,
                "detil": detil
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
        var kdsupp = $('#supp').val();
        var namaBrg = $('#draw').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('penjualan/TransJual/getGrandTotalWBoth') ?>",
            dataType: "JSON",
            data: {
                "tgl_awal": tglAwal,
                "tgl_akhir": tglAkhir,
                "namabrg": namaBrg,
                "supp": kdsupp,
                "master": master,
                "detil": detil
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
        var kdsupp = $('#supp').val();
        // var namaBrg= $('#brg').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('penjualan/TransJual/getGrandTotalWSupp') ?>",
            dataType: "JSON",
            data: {
                "tgl_awal": tglAwal,
                "tgl_akhir": tglAkhir,
                "supp": kdsupp,
                "master": master,
                "detil": detil
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
        //  var kdsupp= $('#supp').val();
        var namaBrg = $('#draw').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('penjualan/TransJual/getGrandTotalWBrg') ?>",
            dataType: "JSON",
            data: {
                "tgl_awal": tglAwal,
                "tgl_akhir": tglAkhir,
                "namabrg": namaBrg,
                "master": master,
                "detil": detil
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

    function draw_grid() {
        // $('input[type=search]').hide();
        table = $('#tableHisjual').DataTable({
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
                "url": "<?php echo site_url('penjualan/TransJual/trJualDetList') ?>/" + master +"/" + detil,
                "type": "POST",
                "data": function(data) {

                    data.min = $('#split1').val();
                    data.max = $('#split2').val();
                    data.KDSUP = $('#supp').val();
                    data.NAMABRG = $('#draw').val();

                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [-1], //last column
                    // "orderable": false, //set not orderable
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
                    "className": 'totalqty text-right'
                },
                {
                    "className": 'het text-right'
                },
                {
                    "className": 'total text-right'
                },
                {
                    "className": 'tgl'
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
    }




    function excel() {
        var tglAwal = $('#split1').val();
        var tglAkhir = $('#split2').val();
        var value = $('#draw').val();
        var supp = $('#supp').val();

        var brg = $('#draw').val();
        if (value.length < 1 && !$('#AllSupp').is(':checked')) {
            if (supp.length < 1) {
                error();
                $('#validasifilt').show();
            } else {
                $('#validasifilt').hide();
                // send3();


                // var brg= $('#brg').val();
                myw = window.open('<?php echo base_url() ?>penjualan/TransJual/excelDetWOBrg/' + tglAwal + '/' + tglAkhir + '/' + supp+ '/' + master + '/' + detil );

                myw.document.close(); //missing code


                myw.focus();
            }
        } else if ($('#AllSupp').is(':checked') && value.length > 0) {
            // sendNoBrg();
            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            // var supp= $('#supp').val();
            var brg = $('#draw').val();
            myw = window.open('<?php echo base_url() ?>penjualan/TransJual/excelDetWOSupp/' + tglAwal + '/' + tglAkhir + '/' + btoa(brg)+ '/' + master + '/' + detil );

            myw.document.close(); //missing code


            myw.focus();

        } else if (!$('#AllSupp').is(':checked') && value.length > 0) {
            // send();

            if (supp.length < 1) {
                error();
                $('#validasifilt').show();
            } else {
                $('#validasifilt').hide();
                myw = window.open('<?php echo base_url() ?>penjualan/TransJual/excelDet/' + tglAwal + '/' + tglAkhir + '/' + supp + '/' + btoa(brg)+ '/' + master + '/' + detil );

                myw.document.close(); //missing code


                myw.focus();
            }
        } else if (value.length < 1 && $('#AllSupp').is(':checked')) {

            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            // var supp= $('#supp').val();
            var brg = $('#draw').val();
            myw = window.open('<?php echo base_url() ?>penjualan/TransJual/excelDetNo/' + tglAwal + '/' + tglAkhir + '/' + master + '/' + detil );

            myw.document.close(); //missing code


            myw.focus();
            myw.print();

        }
    }

    function print() {
        var value = $('#draw').val();
        var suplier = $('#supp').val();
        if (value.length < 1 && !$('#AllSupp').is(':checked')) {
            // send3();
            if (suplier.length < 1) {
                error();
                $('#validasifilt').show();
            } else {
                $('#validasifilt').hide();
                var tglAwal = $('#split1').val();
                var tglAkhir = $('#split2').val();
                var supp = $('#supp').val();
                // var brg= $('#brg').val();
                myw = window.open('<?php echo base_url() ?>penjualan/TransJual/printDetWOBrg/' + tglAwal + '/' + tglAkhir + '/' + supp + '/' + master + '/' + detil );

                myw.document.close(); //missing code


                myw.focus();
            }
        } else if (value.length > 0 && $('#AllSupp').is(':checked')) {
            // sendNoBrg();
            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            // var supp= $('#supp').val();
            var brg = $('#draw').val();
            myw = window.open('<?php echo base_url() ?>penjualan/TransJual/printDetWOSupp/' + tglAwal + '/' + tglAkhir + '/' + btoa(brg) + '/' + master + '/' + detil );

            myw.document.close(); //missing code


            myw.focus();

        } else if (value.length > 0 &&  !$('#AllSupp').is(':checked')) {
            // send();
            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            var supp = $('#supp').val();
            var brg = $('#draw').val();
            if (suplier.length < 1) {
                error();
                $('#validasifilt').show();
            } else {
                $('#validasifilt').hide();
            myw = window.open('<?php echo base_url() ?>penjualan/TransJual/printDet/' + tglAwal + '/' + tglAkhir + '/' + supp + '/' + btoa(brg) + '/' + master + '/' + detil );

            myw.document.close(); //missing code


            myw.focus();
            }
        } else if (value.length < 1 && suplier.length < 1) {

            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            // var supptr= $('#supp').val();
            var brg = $('#draw').val();
            myw = window.open('<?php echo base_url() ?>penjualan/TransJual/printDetNo/' + tglAwal + '/' + tglAkhir + '/' + master + '/' + detil );

            myw.document.close(); //missing code


            myw.focus();



        }
        // myw = myWindow.document.write("<p>This is 'myWindow'</p>");


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





    function reload_table() {
        getGrandTotal()
        table.ajax.reload(null, false);
    }
    function error(){
    Swal.fire({
  icon: 'error',
  title: 'Error',
  text: 'Kolom Supplier Wajib Diisi',

})
   }
</script>
<?php } ?>
</div>


</section>