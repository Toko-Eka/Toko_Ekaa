
<section>

						<div class="col-md-6 col-sm-12 text-right">
							
						</div>
					</div>
				</div>
              
                  <div class="card" style= "margin: auto; width: 100%;" >
                    <div class="card-header"></div>
                    <div class="card-body">  <div class="form-group">
                  <h4>Harga Barang Per Supplier</h4>
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
              
                <input type="text" name="tgl_awal" id="split1" hidden>
                <input type="text" name="tgl_akhir" id="split2" hidden>
                </div>  <div class="btn-group" role="group" aria-label="Basic example">
                           
                           <!-- <button type="button" id="btn-reset" onclick="delete_grid()" style="float: left;"class="btn btn-warning ">Reset</button> -->
                           <button type="button" onclick="print()" id="btn-print" style="float: left;" class="btn btn-primary"><i class="fa-solid fa-print"></i> Print</button>
                           <button type="button" onclick="excel()" id="btn-excel" style="float: left;" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Download Excel</button>
                       </div><HR></HR>
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
                            <table id='hrgBrg' class='table table-striped' style="width:100%">

<thead>
    <tr>

        <th>Nama Barang</th>
        <th>HET</th>
        <th>RLABA</th>
        <th>HBT</th>
        <th>A</th>
        <th>B</th>

        <th>C</th>
        <th>D</th>
        <th>E</th>
        <th>KANVAS</th>

    </tr>
</thead>
<tfoot>
    <tr>
       
    </tr>
</tfoot>

</table> </div></div>
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
  var table;
  $('#AllSupp')[0].checked = true;
// ("#AllSupp").attr("checked", true);
// ("#AllSupp").prop('checked', true);
 $('#supp').hide();

 $("#AllSupp").change(function() {
     if($('#AllSupp').is(':checked')) {
         $('#supp').hide();
         $('#supp option').eq(0).prop('selected', true);
     }
     else{
         $('#supp').show();
     }
 });
 $( document ).ready(function() {
    $('#validasifilt').hide();
             $( "#supp" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url: "<?php echo site_url('Laporan/BrgHarga/Search'); ?>",
            type: 'post',
            dataType: "json",
            data: {
              search: request.term
            },
            success: function( data ) {
              response( data );
            }
          });
        },
        select: function (event, ui) {
          // Set selection
          $('#supp').val(ui.item.label); // display the selected text
  
          return false;
        }
      });
      $('#btn-filter').click(function(){ //button filter event click
      
    draw_grid();
    table.ajax.reload();  //just reload table
    // $('#rekapKasir').DataTable().reset();


});
    });
      function draw_grid() {
        // $('input[type=search]').hide();
        table = $('#hrgBrg').DataTable({
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
                "url": "<?php echo site_url('Laporan/BrgHarga/brgHargaList') ?>",
                "type": "POST",
                "data": function(data) {

                    // data.min = $('#split1').val();
                    // data.max = $('#split2').val();
                    data.KDSUP = $('#supp').val();
                    data.NAMABRG = $('#draw').val();

                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [
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
                    "className": 'kdbrg text-right'
                },
                {
                    "className": 'brg text-right'
                },
                {
                    "className": 'supp text-right'
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
                    "className": 'text-right'
                },
                {
                    "className": 'total text-right'
                },
                {
                    "className": 'text-right'
                },

            ],
        });


    }


// $('.daterange-cus').daterangepicker({
  
// });



function excel() {
  if($('#AllSupp').is(':checked')){
        // send3();
    // var tglAwal= $('#split1').val();
    // var tglAkhir= $('#split2').val();
    // var supp= $('#supp').val();
    // var brg= $('#brg').val();
    myw = window.open('<?php echo base_url()?>Laporan/BrgHarga/excelHargaAll/');

    myw.document.close(); //missing code


    myw.focus();
  
    }
    
   
 
    else {
        // sendNoBrg();

    var supp= $('#supp').val();
    var namasupp= $('#supp').val();
    if (supp.length < 1) {
        error();
                    $('#validasifilt').show();
                } else {
                    $('#validasifilt').hide();
    myw = window.open('<?php echo base_url()?>Laporan/BrgHarga/excelHarga/'+supp+'/'+namasupp);

    myw.document.close(); //missing code


    myw.focus();
                }
    }


        }

function print() {
  if($('#AllSupp').is(':checked')){
        // send3();
    // var tglAwal= $('#split1').val();
    // var tglAkhir= $('#split2').val();
    // var supp= $('#supp').val();
    // var brg= $('#brg').val();
    myw = window.open('<?php echo base_url()?>Laporan/BrgHarga/printHargaAll/');

    myw.document.close(); //missing code


    myw.focus();
   
    }
    
   
 
    else {
        // sendNoBrg();
        $('#validasifilt').hide();
    var supp= $('#supp').val();
    var namasupp= $('#supp').val();
    if (supp.length < 1) {
        error();
                    $('#validasifilt').show();
                } else {
                    $('#validasifilt').hide();
    myw = window.open('<?php echo base_url()?>Laporan/BrgHarga/printHarga/'+supp+'/'+namasupp);

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
var kdsupp = $('#supp').val();
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
var kdsupp = $('#supp').val();
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
//  var kdsupp= $('#supp').val();
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
function error(){
    Swal.fire({
  icon: 'error',
  title: 'Error',
  text: 'Kolom Supplier Wajib Diisi',

})
   }
</script>
