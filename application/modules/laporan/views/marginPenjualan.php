<section>

    <div class="col-md-6 col-sm-12 text-right">

    </div>
    </div>
    </div>

    <div class="card" style="margin: auto; width: 100%;">
        <div class="card-header"></div>
        <div class="card-body">
            <div class="form-group">
                <h4>Pilih Periode</h4>
                <hr>
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
                <table id='margin' class='table table-striped' style="width:100%">

                    <thead>
                        <tr>


                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>HBT</th>
                            <th>Modal</th>
                            <th>TOTAL</th>
                            <th>Margin</th>


                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th colspan="3" style="text-align:right"></th>

                            <th></th>
                            <th style="text-align:right">Total = <span id="totaal">0</span></th>

                        </tr>
                    </tfoot>

                </table>
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
    var save_method; //for save method string
    var table;
    var table2;
    var master = 'xTransak';
    var detil = 'xTransakDetil';

    $(document).ready(function() {
        $('#validasifilt').hide();
        $("#AllSupp").prop('checked', true);

        $('#supp').hide();
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

                return false;
            }
        });


        $("#AllSupp").change(function() {
            if ($('#AllSupp').is(':checked')) {
                $('#supp').hide();

                $('#supp').val('');
            } else {
                $('#supp').show();
            }
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
        $('#btn-filter').click(function() { //button filter event click
            var value = $('#draw').val();
            if (value.length < 1 && !$('#AllSupp').is(':checked')) {
                // send3();
                getGrandTotalWSupp();

            } else if ($('#AllSupp').is(':checked') && value.length > 0) {
                // sendNoBrg();
                getGrandTotalWBrg();

            } else if (!$('#AllSupp').is(':checked') && value.length > 0) {
                // send();
                getGrandTotalWBoth();

            } else if (value.length < 1 && $('#AllSupp').is(':checked')) {

                getGrandTotal();


            }
            draw_grid();
            table.ajax.reload(); //just reload table
            // $('#tableHisjual').DataTable().reset();


        });
    });

    function draw_grid() {
        // $('input[type=search]').hide();
        table = $('#margin').DataTable({
            "pageLength": 5,
          
            "dom": '<"pull-left"><"pull-right">tp',
            retrieve: true,
            "processing": true,
            "serverSide": true, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('laporan/MarginJual/margiinList') ?>/" + master + "/" + detil,
                "type": "POST",
                "data": function(data) {
                    data.min = $('#split1').val();
                    data.max = $('#split2').val();
                    data.KDSUP = $('#supp').val();
                    data.NAMABRG = $('#draw').val();

                }
            },

         
            "columnDefs": [{
                    "targets": [-1], //last column

                },
        
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
                }, {
                    "className": 'totalqty text-right'
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

    function print() {
        var value = $('#draw').val();
        if (value.length < 1 && !$('#AllSupp').is(':checked')) {
            // send3();
            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            var supp = $('#supp').val();
            // var brg= $('#brg').val();
            if (supp.length < 1) {
                error();
                $('#validasifilt').show();
            } else {
                $('#validasifilt').hide();
                myw = window.open('<?php echo base_url() ?>laporan/MarginJual/marginPrintSupp/' + tglAwal + '/' + tglAkhir + '/' + supp + '/' + master + '/' + detil);

                myw.document.close(); //missing code


                myw.focus();
            }

        } else if ($('#AllSupp').is(':checked') && value.length > 0) {
            // sendNoBrg();
            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            // var supp= $('#supp').val();
            var brg = $('#draw').val();
            myw = window.open('<?php echo base_url() ?>laporan/MarginJual/marginPrintBrg/' + tglAwal + '/' + tglAkhir + '/' + btoa(brg) + '/' + master + '/' + detil);

            myw.document.close(); //missing code


            myw.focus();

        } else if (!$('#AllSupp').is(':checked') && value.length > 0) {
            // send();
            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            var supp = $('#supp').val();
            var brg = $('#draw').val();
            if (supp.length < 1) {
                error();
                $('#validasifilt').show();
            } else {
                $('#validasifilt').hide();
                myw = window.open('<?php echo base_url() ?>laporan/MarginJual/marginPrintBoth/' + tglAwal + '/' + tglAkhir + '/' + supp + '/' + btoa(brg) + '/' + master + '/' + detil);

                myw.document.close(); //missing code


                myw.focus();
            }

        } else if (value.length < 1 && $('#AllSupp').is(':checked')) {

            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            // var supptr= $('#supp').val();
            var brg = $('#draw').val();

            myw = window.open('<?php echo base_url() ?>laporan/MarginJual/marginPrint/' + tglAwal + '/' + tglAkhir + '/' + master + '/' + detil);

            myw.document.close(); //missing code


            myw.focus();



        }
    }

    function excel() {
        var value = $('#draw').val();
        if (value.length < 1 && !$('#AllSupp').is(':checked')) {
            // send3();
            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            var supp = $('#supp').val();
            // var brg= $('#brg').val();
            if (supp.length < 1) {
                error();
                $('#validasifilt').show();
            } else {
                $('#validasifilt').hide();
                myw = window.open('<?php echo base_url() ?>laporan/MarginJual/marginExcelSupp/' + tglAwal + '/' + tglAkhir + '/' + supp + '/' + master + '/' + detil);

                myw.document.close(); //missing code


                myw.focus();
            }
        } else if ($('#AllSupp').is(':checked') && value.length > 0) {
            // sendNoBrg();
            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            // var supp= $('#supp').val();
            var brg = $('#draw').val();
            myw = window.open('<?php echo base_url() ?>laporan/MarginJual/marginExcelBrg/' + tglAwal + '/' + tglAkhir + '/' + btoa(brg) + '/' + master + '/' + detil);

            myw.document.close(); //missing code


            myw.focus();

        } else if (!$('#AllSupp').is(':checked') && value.length > 0) {
            // send();
            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            var supp = $('#supp').val();
            var brg = $('#draw').val();
            if (supp.length < 1) {
                error();
                $('#validasifilt').show();
            } else {
                $('#validasifilt').hide();
                myw = window.open('<?php echo base_url() ?>laporan/MarginJual/marginExcelBoth/' + tglAwal + '/' + tglAkhir + '/' + supp + '/' + btoa(brg) + '/' + master + '/' + detil);

                myw.document.close(); //missing code


                myw.focus();
            }
        } else if (value.length < 1 && $('#AllSupp').is(':checked')) {

            var tglAwal = $('#split1').val();
            var tglAkhir = $('#split2').val();
            // var supptr= $('#supp').val();
            var brg = $('#draw').val();
            myw = window.open('<?php echo base_url() ?>laporan/MarginJual/marginExcel/' + tglAwal + '/' + tglAkhir + '/' + master + '/' + detil);

            myw.document.close(); //missing code


            myw.focus();



        }
    }

    function getGrandTotal() {

        var tglAwal = $('#split1').val();
        var tglAkhir = $('#split2').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('laporan/MarginJual/marginGrandTotal') ?>",
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
            url: "<?php echo base_url('laporan/MarginJual/marginGrandTotalBoth') ?>",
            dataType: "JSON",
            data: {
                "tgl_awal": tglAwal,
                "tgl_akhir": tglAkhir,
                "namabrg": namaBrg,
                "kdsup": kdsupp
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
            url: "<?php echo base_url('laporan/MarginJual/marginGrandTotalSupp') ?>",
            dataType: "JSON",
            data: {
                "tgl_awal": tglAwal,
                "tgl_akhir": tglAkhir,
                "kdsup": kdsupp,
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
            url: "<?php echo base_url('laporan/MarginJual/marginGrandTotalBrg') ?>",
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

    function error() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Kolom Supplier Wajib Diisi',

        })
    }
</script>