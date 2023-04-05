<section>

    <div class="col-md-6 col-sm-12 text-right">

    </div>
    </div>
    </div>

    <div class="card" style="margin: auto; width: 100%;">
        <div class="card-header">Laporan Inventory</div>
        <div class="card-body">
            <div class="form-group">
                <h4>Laporan Inventory</h4>
                <hr>
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
                <!-- <div class="form-group">
                                            <label class="control-label">Tanggal</label>


                                            <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-calendar"></i>
                      </div>
                    </div> 
                                            <div class='daterange-cus' id="daterange-cus" style="font-size: 17px; background: #fff; cursor: pointer; padding:10px 17px; border: 1px solid #ccc; width: 100%">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                            


                                        </div> -->

                <input type="text" name="tgl_awal" id="split1" hidden>
                <input type="text" name="tgl_akhir" id="split2" hidden>
            </div> <div class="btn-group" role="group" aria-label="Basic example">
                           
                           <!-- <button type="button" id="btn-reset" onclick="delete_grid()" style="float: left;"class="btn btn-warning ">Reset</button> -->
                           <button type="button" onclick="print()" id="btn-print" style="float: left;" class="btn btn-primary"><i class="fa-solid fa-print"></i> Print</button>
                           <button type="button" onclick="excel()" id="btn-excel" style="float: left;" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Download Excel</button>
                       </div></div>
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
                <table id='inventory' class='table table-striped' style="width:100%">

                    <thead>
                        <tr>


                            <th>Nama Barang</th>
                            <th>Supplier</th>
                            <th>Stok Akhir</th>
                            <th>HBT</th>


                            <th>Nilai Inventaris</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>

                            <th colspan="2" style="text-align:right"></th>
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
        var table;
        $('#validasifilt').hide();
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

    });

    function draw_grid() {
        // $('input[type=search]').hide();
        table = $('#inventory').DataTable({
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
                "url": "<?php echo site_url('Laporan/L_inventory/invenList') ?>",
                "type": "POST",
                "data": function(data) {

                    // data.min = $('#split1').val();
                    // data.max = $('#split2').val();
                    data.KDSUP = $('#supp').val();
                    data.NAMABRG = $('#draw').val();

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
                    "className": 'nota'
                },
                {
                    "className": 'kdbrg'
                },
                {
                    "className": 'totalqty text-right'
                },
                {
                    "className": 'totalqty text-right'
                },
                {
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
    $('#btn-filter').click(function() { //button filter event click
        var value = $('#draw').val();
        if (value.length < 1 && !$('#AllSupp').is(':checked')) {
            getGrandTotalWSupp();
        } else if (value.length > 0 && $('#AllSupp').is(':checked')) {
            getGrandTotalWBrg();

        } else if (value.length > 0 && !$('#AllSupp').is(':checked')) {
            getGrandTotalAll();
        } else {
            getGrandTotal();
        }
        draw_grid();
        table.ajax.reload(); //just reload table
        // $('#tableHisjual').DataTable().reset();


    });

    function print() {
        var awal = $('#split1').val();
        var akhir = $('#split2').val();
        var kdsupp = $('#supp').val();
        var brg = $('#draw').val();
        var value = $('#draw').val();
        if (value.length < 1 && !$('#AllSupp').is(':checked')) {
            if (kdsupp.length < 1) {
                error();
                    $('#validasifilt').show();
                } else {
                    $('#validasifilt').hide();
            myw = window.open('<?php echo base_url() ?>Laporan/L_inventory/printInventoryWSupp/' + kdsupp);

            myw.document.close(); //missing code


            myw.focus();
                }
        } else if (value.length > 0 && $('#AllSupp').is(':checked')) {
            myw = window.open('<?php echo base_url() ?>Laporan/L_inventory/printInventoryWBrg/' + btoa(brg));

myw.document.close(); //missing code


myw.focus();

        } else if (value.length > 0 && !$('#AllSupp').is(':checked')) {
            if (kdsupp.length < 1) {
                error();
                    $('#validasifilt').show();
                } else {
                    $('#validasifilt').hide();
            myw = window.open('<?php echo base_url() ?>Laporan/L_inventory/printInventoryAll/' + kdsupp+'/'+btoa(brg));

myw.document.close(); //missing code


myw.focus();
                }
        } else {
            myw = window.open('<?php echo base_url() ?>Laporan/L_inventory/printInventory/');

myw.document.close(); //missing code


myw.focus();
        }


    }

    function excel() {
        var awal = $('#split1').val();
        var akhir = $('#split2').val();
        var kdsupp = $('#supp').val();
        var brg = $('#draw').val();
        var value = $('#draw').val();
        if (value.length < 1 && !$('#AllSupp').is(':checked')) {
            if (kdsupp.length < 1) {
                error();
                    $('#validasifilt').show();
                } else {
                    $('#validasifilt').hide();
            myw = window.open('<?php echo base_url() ?>Laporan/L_inventory/excelInventoryWSupp/' + kdsupp);

            myw.document.close(); //missing code


            myw.focus();
                }
        } else if (value.length > 0 && $('#AllSupp').is(':checked')) {
            myw = window.open('<?php echo base_url() ?>Laporan/L_inventory/excelInventoryWBrg/' + btoa(brg));

myw.document.close(); //missing code


myw.focus();

        } else if (value.length > 0 && !$('#AllSupp').is(':checked')) {
            if (kdsupp.length < 1) {
                error();
                    $('#validasifilt').show();
                } else {
                    $('#validasifilt').hide();
            myw = window.open('<?php echo base_url() ?>Laporan/L_inventory/excelInventoryWAll/' + kdsupp+'/'+btoa(brg));

myw.document.close(); //missing code


myw.focus();
                }
        } else {
            myw = window.open('<?php echo base_url() ?>Laporan/L_inventory/excelInventory/');

myw.document.close(); //missing code


myw.focus();
        }
    }

    function getGrandTotal() {


        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Laporan/L_inventory/getGrandTotal') ?>",
            dataType: "JSON",
            data: {

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


        //  var kdsupp= $('#supp').val();
        var namaBrg = $('#draw').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Laporan/L_inventory/getGrandTotalWBrg') ?>",
            dataType: "JSON",
            data: {
                // "tgl_awal": tglAwal,
                // "tgl_akhir": tglAkhir,
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

    function getGrandTotalWSupp() {

        // var tglAwal = $('#split1').val();
        // var tglAkhir = $('#split2').val();
        var kdsupp = $('#supp').val();
        // var namaBrg = $('#draw').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Laporan/L_inventory/getGrandTotalWSupp') ?>",
            dataType: "JSON",
            data: {
                // "tgl_awal": tglAwal,
                // "tgl_akhir": tglAkhir,
                "suppl": kdsupp
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

        // var tglAwal = $('#split1').val();
        // var tglAkhir = $('#split2').val();
        var kdsupp = $('#supp').val();
        var namaBrg = $('#draw').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Laporan/L_inventory/getGrandTotalAll') ?>",
            dataType: "JSON",
            data: {
                // "tgl_awal": tglAwal,
                // "tgl_akhir": tglAkhir,
                "namabrg": namaBrg,
                "suppl": kdsupp
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