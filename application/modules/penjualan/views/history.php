
<section>

    <div class="col-md-6 col-sm-12 text-right">

    </div>
    </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card bg-defaullt">

                <div class="card-body">

                    <div class="panel-heading">
                        <!-- <button class="btn btn-primary" onclick="addBarg()"><i class="fa fa-plus"></i> Tambah Barang</button> -->
                      
                    </div>
                    <div class="panel-body">
                        <hr>
                        <p>Filter Data</p>
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
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label">Status</label>




                                 
                                        <select class="form-control" name="" id="paid">
                                        <option value="">Semua </option>
                                        <option value="0">Belum Dibayar</option>
                                        <option value="1">Sudah Dibayar</option>
                                       </select><span class="help-block"></span>
                                    </div>
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

    <input type="text" placeholder="Cari Nota Disini...." class="form-control" id="draw">
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
                                    <th></th>
                                    <th>NOTA</th>
                                    <th>TGL</th>
                                    <th>Total barang</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>KASIR</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th colspan="3" style="text-align:right"> <span id="qtytotal"></span></th>
                                    <th style="text-align:right"><span id="totaal"></span></th>

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
                                    <option value="female">Female</option>
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

<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        $('#btn-reset').click();
        $('#btn-filter').click();
        // $('#supp').select2();
        // $('#supp2').select2();

        //datatables
        table = $('#tableHisjual').DataTable({


            // footerCallback: function (row, data, start, end, display) {
            //     var api = this.api();

            //     // Remove the formatting to get integer data for summation
            //     var intVal = function (i) {
            //         return typeof i === 'string' ? i.replace(/[\.,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            //     };

            //     // Total over all pages
            //     total = api
            //         .column(4)
            //         .data()
            //         .reduce(function (a, b) {
            //             return intVal(a) + intVal(b);
            //         }, 0);

            //     // Total over this page
            //     pageTotal = api
            //         .column(4)
            //         .data()
            //         .reduce(function (a, b) {
            //             return intVal(a) + intVal(b);
            //         }, 0);

            //     // Update footer
            //     $(api.column(4).footer()).html( 'Rp. ' + total+' (Grand Total Rp.'+ pageTotal );
            // },

            "dom": '<"pull-left"><"pull-right"l>tip',
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            // "searchPanes": {
            //    " viewTotal": true
            // },


            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('penjualan/TransJual/trJualList') ?>",
                "type": "POST",
                "data": function(data) {

                    data.min = $('#split1').val();
                    data.max = $('#split2').val();
                    data.PAID = $('#paid').val();
                    data.NOTA = $('#draw').val();

                }
            },
            "columns": [{
                    "className": 'details-control'
                },
                {
                    "className": 'nota'
                },
                {
                    "className": 'tgl'
                },
                {
                    "className": 'totalqty text-right'
                },
                {
                    "className": 'total text-right'
                },
                {
                    "className": 'stat'
                },
                {
                    "className": 'cashier'
                },
                {
                    "className": 'action'
                },

            ],
            // "rowCallback": function( className,row, data, index ) {
            //     var api = this.api();

            //    var sum = 0;
            //    sum += parseInt(className.total);
            //    console.log(data.TOTAL);
            //    $(api.column(4).footer()).html( 'Rp. ' + sum+' (Grand Total Rp.'+ sum );
            //    //DO WHAT YOU WANT
            // },
            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [-1, 0, 2, 5, 6], //last column
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

        });
        $('#tableHisjual tbody').on('click', 'td.details-control', function() {
            // console.log('tes')
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            // console.log(tr)
            // console.log(row.data()[4])
            if (row.child.isShown()) {
                document.getElementsByClassName("fa fa-minus" + (parseInt(row.data()[1]) - 1)).className = "fa fa-plus";
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                document.getElementsByClassName("fa fa-plus" + (parseInt(row.data()[1]) - 1)).className = "fa fa-minus";
                // var splt = row.data()[4].split("/");
                // var data2 = splt[0].split(">");
                var data = row.data()[1];
                // console.log(data)
                format(data, row);
                // row.child( format(data) ).show();
                tr.addClass('shown');
            }
        });
        $('#btn-filter').click(function() { //button filter event click
            getGrandTotal();
            table.ajax.reload(); //just reload table

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

    function format(nota, row) {
        // getajax(soid);
        // console.log(nota);
        $.ajax({
            type: "POST",
            global: false,
            url: "<?= site_url('/penjualan/TransJual/getTransakJualDetil') ?>",
            data: {
                'id': nota,
            },

            success: function(response) {

                var html = '<table cellpadding="0" cellspacing="0" border="0" style="width:60%;">' +
                    '<tr>' +
                    '<td width="5%">No</td>' +
                    '<td width="15%">KDBRG</td>' +
                    '<td width="30%">NAMABRG</td>' +
                    '<td width="15%" align="right">HARGA</td>' +
                    '<td width="5%" align="right">Qty</td>' +

                    '<td width="15%" align="right">Subtotal</td>' +
                    '</tr>';
                console.log(response);

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

    function send() {
        var tglAwal = $('#split1').val();
        var tglAkhir = $('#split2').val();

        $.ajax({
            url: "<?php echo base_url(); ?>penjualan/TransJual/print",
            type: "POST",
            dataType: "json",
            data: {
                "tgl_awal": tglAwal,
                "tgl_akhir": tglAkhir
            },
            success: function(data) {

            },
            error: function(data) {
                // do something

            }
        });

    }

    function send2() {
        var tglAwal = $('#split1').val();
        var tglAkhir = $('#split2').val();

        $.ajax({
            url: "<?php echo base_url(); ?>penjualan/TransJual/excel",
            type: "POST",
            dataType: "json",
            data: {
                "tgl_awal": tglAwal,
                "tgl_akhir": tglAkhir
            },
            success: function(data) {

            },
            error: function(data) {
                // do something

            }
        });

    } 

    function excel() {
        var tglAwal = $('#split1').val();
        var tglAkhir = $('#split2').val();
        var notaaa = $('#draw').val();
        if (notaaa.length < 1) {
            myw = window.open('<?php echo base_url() ?>penjualan/TransJual/excelWONota/' + tglAwal + '/' + tglAkhir);

myw.document.close(); //missing code


myw.focus();

        } else {
        myw = window.open('<?php echo base_url() ?>penjualan/TransJual/excel/' + tglAwal + '/' + tglAkhir+'/'+notaaa);

        myw.document.close(); //missing code


        myw.focus();
       
        }


        // myw = myWindow.document.write("<p>This is 'myWindow'</p>");



    }

    function print() {
       
        var tglAwal = $('#split1').val();
        var tglAkhir = $('#split2').val();
        var notaaa = $('#draw').val();
        if (notaaa.length < 1) {
            myw = window.open('<?php echo base_url() ?>penjualan/TransJual/printWONota/' + tglAwal + '/' + tglAkhir);

myw.document.close(); //missing code


myw.focus();

        } else {
        myw = window.open('<?php echo base_url() ?>penjualan/TransJual/print/' + tglAwal + '/' + tglAkhir+'/'+notaaa);

        myw.document.close(); //missing code


        myw.focus();
     
        }


        // myw = myWindow.document.write("<p>This is 'myWindow'</p>");


    }
    function getGrandTotal() {

var tglAwal = $('#split1').val();
var tglAkhir = $('#split2').val();
var notaaa = $('#draw').val();
$.ajax({
    type: "POST",
    url: "<?php echo base_url('penjualan/TransJual/getGrandTotalMaster') ?>",
    dataType: "JSON",
    data: {
        "tgl_awal": tglAwal,
        "tgl_akhir": tglAkhir,
        "nota": notaaa
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

    function getajax(nota) {
        $.ajax({
            type: "POST",
            global: false,
            url: "<?= site_url('/penjualan/TransJual/getTransakJualDetil') ?>",
            data: {
                'id': nota,
            },
            success: function(response) {
                callback(JSON.parse(response));
            }
        });
    }

    function addBarg() {
        save_method = 'add';

        $('#data')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Barang');
    }

    function editBarg(id) {
        save_method = 'update';

        $('#data')[0].reset();
        $('.form-group').removeClass('has-error');
        $('.help-block').empty();


        $.ajax({
            url: "<?php echo site_url('Barang/editBrg/') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {


                $('[name="KDBRG"]').val(data.KDBRG);
                $('[name="NAMABRG"]').val(data.NAMABRG);
                $('[name="JENIS"]').val(data.JENIS);
                $('[name="KDSUP"]').val(data.KDSUP);
                $('[name="AKHIR"]').val(data.AKHIR);

                $('#modal_form').modal('show');
                $('.modal-title').text('Edit Barang');

            },

            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_table() {
        table.ajax.reload(null, false);
    }

    function save() {
        $('#btnSave').text('saving...');
        $('#btnSave').attr('disabled', true);
        var url;

        if (save_method == 'add') {
            url = "<?php echo site_url('Barang/addBrg') ?>";
        } else {
            url = "<?php echo site_url('Barang/updateBrg') ?>";
        }


        $.ajax({
            url: url,
            type: "POST",
            data: $('#data').serialize(),
            dataType: "JSON",
            success: function(data) {

                if (data.status) {
                    $('#modal_form').modal('hide');
                    reload_table();
                }

                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);

            }
        });
    }

    function del(id) {
        Swal.fire({
            title: 'Peringatan',
            text: "Apakah anda yakin ingin menghapus data ini? ",
            icon: 'warning',
            showCancelButton: true,
            background: '#fff',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya',
        }).then((result) => {

            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Oke',
                    text: "Data berhasil dihapus",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok!'

                });
                $.ajax({
                    url: "<?php echo site_url('barang/delBrg') ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        reload_table();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });


            }
        })




    }
</script>



</div>


</section>