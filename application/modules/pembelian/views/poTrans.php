<section>

<style>
 
  #trform>tbody>tr>td {
    padding: 1;
  }
  

</style>
  <div class="col-md-6 col-sm-12 text-right">

  </div>
  </div>
  </div>
  <form method="post" id="formPo" action="<?php echo base_url("pembelian/TransPo/addPo"); ?>">
  <div class="card" style="margin: auto; width: 100%;">
    <div class="card-header">Transaksi Purchase Order</div>
    <div class="card-body">
      <div class="row">
      <div class="col-md-3">
          <label for="">No.PO</label>
          <input id="nopo" name="nompo" type="text" class="form-control">
        </div>
        <div class="col-md-3">
          <label for="">KDSUP</label>
          <input id="supp" name="KDSUP" type="text" class="form-control supp">
        </div>
        <div class="col-md-3">
          <label for="">Supplier</label>
          <input id="namesup" name="supplier"  type="text" class="form-control">
        </div>
        <div class="col-md-3">
          <label for="">NOTA</label>
          <input id="nota" name="flag2" type="text" class="form-control">
        </div>
      </div>
      <hr>
      <div class="row">


        <div class="col-md-6">
          <div class="btn-group" role="group" aria-label="Basic example">

            <!-- <button type="button" id="btn-reset" onclick="delete_grid()" style="float: left;"class="btn btn-warning ">Reset</button> -->
            <button type="button" data-toggle="modal" data-target="#modal" id="btn-modal" style="float: left;" class="btn btn-primary"><i class="fa-solid fa-chart-simple"></i> Analisa PO</button>
            <button  type="button" onclick="excel()" id="btn-loadd" style="float: left;" class="btn btn-success"> Load Nota Beli</button>
            <button id="confirm" type="button"  id="btn-excel" style="float: left;" class="btn btn-primary"> Post Po</button>
          </div>

        </div>
        <div class="col-md-4">
          <input type="hidden" id="ids">
          <!-- <label for="">POST</label>
          <input type="checkbox" checked data-toggle="toggle"> -->

        </div>


      </div>
      <hr>
      <div class="sticky-top">
      <div class="row">
        <div class="col-md-6">
       
        <div id="kard" class="card mb-3">
            <div class="card-header">Total Qty</div>
            <div class="container">
              <h1><input style="height:100px; font-size:50pt;  text-align: right;" class="form-control-plaintext" type="text" id='total_qty'></h1>
            </div>
          </div>
        </div>
        <div class="col-md-6">
  
          <div class="card mb-3">
            <div class="card-header">Total Harga</div>
            <div class="container">
              <h1><input style="height:100px; font-size:50pt;  text-align: right;" class="form-control-plaintext" type="text" id='total_amount'></h1>
            </div>
          </div>
        </div>
      </div>
 </div>
      <hr>
      
      <hr>
      <div class="table-responsive-sm">
      <table id="trform" class='table table-fixed' style='border-collapse: collapse;' width = '100%'>
        <thead>
          <tr>
            <th width='2%'></th>
            <th width = '14%'>KODE BARANG</th>
            <th width='7%'>Qty Order</th>
            <th width='25%'>NAMA BARANG</th>
            <th width = '10%'>HET</th>
            <th width = '7%'>RLABA</th>
            <th width = '10%'>HBT</th>
            <th width='10%'>Masuk</th>
            <th  width = '14%'>SUBTOTAL</th>
            <!-- <th><button class='btn btn-sm btn-success' value='Add more' id='addmore' onclick="addRows()"><i class="fa fa-plus"></i></button></th> -->
          </tr>
        </thead>
        <tbody class="tbodyy">

          <!-- <p>Clicks: <a id="clicks">0</a></p> -->
          <div id="inst-form" class="form"></div>
          <!-- <tr class='tr_input'>
<td></td>
            <td><input type='text' class='form-control obat ' id='obat' placeholder='Masukkan Barang...'></td>
          
            <td><input type='text' class='form-control  ' id='kd_1'></td>

            <td><input type='text' class='form-control  harga ' id='harga_1'></td>
            <td><input type='text' name="jumlah[]" value='' class='txtCal form-control jumlah' id='jumlah_1'></td>

            <td><input readonly type='number' name="subtotal[]" class='txtCal form-control total inst_amount' id="total_1"></td>
            <td> <button class='btn btn-sm btn-success' value='Add more' id='addmore' onclick="addRows()"><i class="fa fa-plus"></i></button></td>
          </tr> -->




        </tbody>
      </table>
      </div>
    </div>
    <div class="card-footer">
    <a onclick="addRows()" class="btn btn-success text-white">Tambah Baris</a></div>
  </div>

  </form>

  </div>




  <br>

</section>

<div class="modal fade" id="modal" tabindex="" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Analisa Penerbitan PO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
   
        <div class="row">

          <div class="col-md-4">
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
<input type="hidden" id="split1">
<input type="hidden" id="split2">
            </div>
           
          </div>
          <div class="col-md-2">
          <label for="">KDSUP</label>
          <input id="supp2" type="text" class="form-control supp">
</div>

          <div class="col-md-5">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="">Jumlah Terjual</span>
              </div>
              <input id="terjual" type="number" style="  text-align: right; " class="form-control" value="0">
              <span class="input-group-text" id="">s/d</span>
              <input id="terjual2" type="number" style="  text-align: right; "  class="form-control" value="999999">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="">Stok</span>
              </div>
              <input id="stokawal" type="number" style="  text-align: right; "  class="form-control" value="0">
              <span class="input-group-text" id="">s/d</span>
              <input id="stokakhir" type="number" style="  text-align: right; "  class="form-control" value="999999">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for=""></label>
            
            </div>
     
          
           
          </div>

        </div>
        <div class="row">
          <div class="col-md-4">
        <div class="btn-group">
       
          <button type="button" id="btn-select-all" style="float: left;" class="btn btn-success"> Pilih Semua</button>
          <button type="button" id="btn-deselect-all" style="float: left;" class="btn btn-danger"> Batal Pilih Semua</button>
          <button type="button" id="btn-exec" style="float: left;" class="btn btn-primary"> Load</button>
          <button type="button" id="btn-filter"  style="float: left;" class="btn btn-info">Cari Data</button>
        </div>
        </div>
        <div class="col-md-8">
   
   <h6>Klik 1 kali pada tabel barang untuk memilih salah satu barang.
         Klik ulang pada barang yang terpiih untuk membatalkan
</h6>
           
        </div>
        </div>
        <hr>
        <div class="table-responsive-md">
          <table id='tableBrg' class='table' style="width:100%">

            <thead>

              <tr>

                <th>KD BRG</th>

                <th>NAMA BARANG</th>
                <th>SUPPLIER</th>
                <th>STOK</th>
                <th>MASUK</th>
                <th>JUAL</th>
                <th>MAXOR</th>

                <!-- <th style="width:125px;">Action</th> -->

              </tr>
            </thead>

          </table>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="modalLoad" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Nota untuk Di Load</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <div class="table-responsive-md">
     <table id='tableLoad' class='table table-striped' style="width:100%">

<thead>
  <tr>
    <th>No.PO</th>
    <th>KDSUP</th>
    <th>Supplier</th>
    <th>NOTA</th>


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

  .modal {
    padding: 0 !important;
  }

  .modal .modal-dialog {
    width: 100%;
    max-width: none;
    height: 100%;
    margin: 0;
  }

  .modal .modal-content {
    height: 100%;
    border: 0;
    border-radius: 0;
  }

  .modal .modal-body {
    overflow-y: auto;
  }

  #data_wrapper.dataTables_wrapper {
    height: 500 !important;
    background-color: #F1F1F1 !important;
  }

  #data_wrapper .fg-toolbar.ui-toolbar.ui-widget-header.ui-helper-clearfix.ui-corner-bl.ui-corner-br {
    position: absolute;
    width: 100%;
    bottom: 0;
  }
</style>

<script>
       let arr = new Array()
  let index = 0;
  let dupp = '';
  $(document).ready(function() {
    <?php if ($strat == 1){
            
            ?> let stat = 1;
                   <?php  } else {
                    ?>let stat = 2;
                   <?php } ?>
    $('#supp').focus()
    $('#total_qty').val('0 Barang');
    $('#total_amount').val('Rp. 0');
    <?php if ($this->session->flashdata('msg')): ?>
                        
                        msg('Transaksi PO Berhasil Di Posting');
                  
              <?php endif; ?>
    $( "#supp" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url: "<?php echo site_url('Barang/Search'); ?>",
            type: 'post',
            dataType: "json",
            autoFocus: true,
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
          $('.supp').val(ui.item.label); // display the selected text
          $('#namesup').val(ui.item.val);
          return false;
        }
      });
      $( "#supp2" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url: "<?php echo site_url('Barang/Search'); ?>",
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
          $('.supp').val(ui.item.label); // display the selected text
          $('#namesup').val(ui.item.val);
          return false;
        }
      });
      $( "#supp2" ).autocomplete( "option", "appendTo", "#modal" );
      $( "#supp" ).autocomplete( "option", "appendTo", "#kard" );
      setInterval(genPO, 10000);
    setInterval(genNota, 10000);
    $('#btn-exec').hide();
    $('#btn-deselect-all').hide();
  
    genNota();
    genPO();
  

    table = $('#tableBrg').DataTable({
      select: {
        style: 'multi'
      },
    
      "paging": false,
      "lengthChange": true,
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.

      "dom": '<"pull-left"f><"pull-right"l>tp',

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('Pembelian/TransPo/brgPoList') ?>/",
        "type": "POST",
        "data": function(data) {
          data.dari = $('#split1').val();
          data.ke = $('#split2').val();
          data.AWAL = $('#terjual').val();
          data.KDSUP = $('.supp').val();
          data.AKHIR = $('#terjual2').val();
          data.AWALSTOK = $('#stokawal').val();
          data.AKHIRSTOK = $('#stokakhir').val();
   

        }
      },
      "deferRender": true,
      "rowId": 'extn',
      //Set column definition initialisation properties.
      "columnDefs": [{
          "targets": [-1, 0], //last column
          "orderable": false, //set not orderable
        },

      ],


    });
    table2 = $('#tableLoad').DataTable({
     
    
    
      "lengthChange": true,
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.

      "dom": '<"pull-left"f><"pull-right"l>tp',

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('Pembelian/TransPo/poList') ?>/"+stat,
        "type": "POST",
        "data": function(data) {
       
          data.AKHIRSTOK = $('#stokakhir').val();
   

        }
      },
      "deferRender": true,
      "rowId": 'extn',
      //Set column definition initialisation properties.
      "columnDefs": [{
          "targets": [-1, 0], //last column
          "orderable": false, //set not orderable
        },

      ],


    });
    $('#tableBrg tbody').on('click', 'tr', function () {
        $(this).toggleClass('selected');
    });
 
    $('#tableBrg tbody').on('click', 'tr', function() {
    var selected = table.rows('.selected').data().length ;
    if (selected  >= 1) {
  $('#btn-exec').show();
} else {
  $('#btn-exec').hide();
}
    });
    function reloadd(){
      table.ajax.reload();
    }
    let selected = table.rows('.selected').data().length;
//     $('#tableBrg tbody').on('click', 'tr', function() {
//       var selected = table.rows('.selected').data().length ;
// console.log(selected)
//   // $('#btn-exec').show();

// if (selected  >= 1) {
//   $('#btn-exec').show();
// } else {
  
// }
    

//     });
    // $('#tableBrg tbody').on('dblclick', 'tr', function() {
    //   var data = table.row(this).data();
    //   index += 1;
    //   var html = "<tr class='tr_input'><td>" + index + "</td><td><input type='text' class='form-control  obat ' id='kodebarr_" + index + "' placeholder='Masukkan Nama Obat' value = ' " + data[0] + "'></td><td><input type='text' class='form-control' value = ' " + data[1] + "' id='kd_" + index + "'></td><td><input readonly type='text' class='form-control harga' id='harga_" + index + "'value = ' " + data[2] + "'  ></td><td><input type='number'name='jumlah[]' class=' form-control ' id='jumlah_" + index + "' ></td><td><input readonly type='number' name='subtotal[]' id='total_" + index + "' class='total form-control  inst_amount'></td><td><a class='btn btn-sm btn-danger text-white remove_button'><i class='fa-solid fa-trash'></i></a></td></div>" +
    //     "</tr></div></tr>";


    //   $('tbody').append(html);

    // });
    $('#btn-loadd').on('click', function() {
      $('#modalLoad').modal('show');
    });
    $('#btn-filter').on('click', function() {
      reloadd();
    });
    $('#btn-select-all').on('click', function() {
      // Get all rows with search applied
      $('#btn-select-all').hide();
      $('#btn-deselect-all').show();
      table.rows().select();
      $('#btn-exec').show();
      

      // table.rows().deselect();


    });
    $('#btn-add-rows').on('click', function() {
    addRows();
  


    });
    $('#btn-deselect-all').on('click', function() {
      // Get all rows with search applied
      $('#btn-deselect-all').hide();
      $('#btn-select-all').show();
      table.rows().deselect();
      $('#btn-exec').hide();

      // table.rows().deselect();


    });
    function genPO(){
  var yes ='a';
  $.ajax({
      url: "<?php echo site_url('pembelian/TransPO/getCode') ?>",
      type: "POST",
      data:{
        "true": yes,
      },
      cache: false,
      success: function(data) {
   
 $('#nopo').val(data); 


           

      },
      
    });
}
$('#confirm').on('click', function() {

  Swal.fire({
                title: 'Peringatan',
  text: "Apakah anda yakin ingin mengposting PO ini? ",
  icon: 'warning',
  showCancelButton: true,
  background:'#fff',
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Iya',
}).then((result) => {
    
                if (result.isConfirmed) {
 if (index < 1) {
  msgerr('Pilih Minimal 1 Barang')
 } else {
  $('#formPo').submit();
 }
               

                }
                else{
                  return true; 
                }
            })
      

  });
    function genNota(){
  var yes ='a';
  $.ajax({
      url: "<?php echo site_url('pembelian/TransPO/getNota') ?>",
      type: "POST",
      data:{
        "true": yes,
      },
      cache: false,
      success: function(data) {
   
 $('#nota').val(data); 


           

      },
      
    });
}
$(document).on('keydown', '.barr', function() {

var id = this.id;
var splitid = id.split('_');
var index = splitid[1];
var supp =    $('.supp').val(); // display the selected text
$('#' + id).autocomplete({
    source: function(request, response) {
        $.ajax({
          url: '<?php echo site_url('Pembelian/TransPo/Search'); ?>',
            type: 'post',
            dataType: "json",
            autoFocus: true,
            data: {
           supl:supp,
                search: request.term,
                request: 1
            },
            success: function(data) {
                response(data);
                
            }
        });
    },
    select: function (event, ui) {
          // Set selection    document.getElementById('id_' + index).value = id_obat;
                

          $('#kodebarr_' + index).val(ui.item.label); // display the selected text
          $('#kd_' + index).val(ui.item.val);
          $('#a_' + index).val(ui.item.het);
          $('#hargaJ_' + index).val(ui.item.het);
          $('#hargab_' + index).val(ui.item.hbt);
          $('#harga_' + index).val(ui.item.hbt);
          $('#z_' + index).val(ui.item.rlaba);
          return false;
        }
      }).autocomplete("instance")._renderItem = function(ul, item) {
            return $("<li class='each'>")
                .append("<div class='acItem'><span class='name'>" +
                    item.label + "</span><br><span class='desc'>" +
                    item.val + "</span></div>")
           
                .appendTo(ul);
        };

});  
    $('#btn-exec').on('click', function() {
    // Get all rows with search applied
    $('#modal').modal('hide');
    var ids = $.map(table.rows('.selected').data(), function(item) {
          return item[0]
        });


     idi = ids.toString()
    ara = arr.toString()
      if (selected  >= 1000) {
        var error ='Batas maksimal jenis barang tercapai, tidak boleh lebih dari 1000 jenis!'
        validasiRows(error);
      } else if (index + selected >= 1000) {
        var error ='Batas maksimal jenis barang tercapai, tidak boleh lebih dari 1000 jenis!'
        validasiRows(error);
      }else if ( arr.includes(...ids)===true) {
        var error = 'Jenis Barang Tidak Boleh Sama!'
        validasiRows(error);
      }else if ( ara.includes(idi)) {
        var error = 'Jenis Barang Tidak Boleh Sama!'
        validasiRows(error);
      } else {
        // console.log(arr.includes(ids))
      
        arr.push(...ids)
     


  $('#ids').val(ids);
       

    
        $.ajax({
          type: "POST",
          url: "<?php echo base_url('pembelian/transPo/getBarangs') ?>",
          dataType: "JSON",
          data: {
            idall: ids
          },
          cache: false,
          success: function(data) {



            const chunkSize = 6;
            for (let i = 0; i < data.length; i += chunkSize) {
              const chunk = data.slice(i, i + chunkSize);
            
              index += 1;
              console.log(chunk); 
              var html = "<tr class='tr_input'><td>" + index + "</td><td><input type='text' class='inst_amount form-control-plaintext mb-3 form-control-sm kodebarang' id='kodebarr_" + index + "' placeholder='Masukkan Nama Obat' name='KDBRG[]' maxlength='25' value = ' " + chunk[0] + "'></td><td><input type='number'  name='JMLBRG[]' value = '1'   size='4'   class='jumlah form-control form-control-sm masukk'id='jumlah_" + index + "' ></td><td><input type='readonly' maxlength='30'  name='NAMABRG[]' class='form-control-plaintext mb-3 form-control-sm' value = ' " + chunk[1] + "' id='kd_" + index + "'></td><td><input readonly type='text' value = ' " + number_format(chunk[2], 0, ',', '.') + "'   id='a_" + index + "' class=' form-control-plaintext mb-3 form-control-sm '><input type ='hidden' name='HARGA[]'  id='hargaj_" + index + "' class='harga'  value = ' " + chunk[2] + "' ></input></td><td><input  type='hidden' name='RLABA[]' value = ' " + chunk[5]+ "'   id='c_" + index + "'><input readonly type='text' value = ' " + chunk[4]+ "'   id='z_" + index + "' class=' form-control-plaintext mb-3 form-control-sm '></td><td><input type ='hidden' name='HBT[]'  id='harga_" + index + "' class='harga'  value = ' " + chunk[3] + "' ></input><input readonly type='text' class='form-control-plaintext mb-3 form-control-sm'  id='hargab_" + index + "' value = ' " + number_format(chunk[3], 0, ',', '.') + "'  ></td><td><input type='number'name='JMLMSK[]' value = '1'   size='4'   class=' form-control form-control-sm ' id='order_" + index + "'    ></td><td><input class='summed form-control form-control-sm'  type='hidden'  id='total1_" + index + "'  name='subtotal[]' value = ' " + chunk[3] + "' ><input readonly type='text' value = ' " + number_format(chunk[3], 0, ',', '.') + "'   id='total_" + index + "' class=' form-control-plaintext mb-3 form-control-sm '></td><td class=''><a class='btn btn-sm btn-danger text-white remove_button'><i class='fa-solid fa-trash'></i></a></td></div>" +
                "</tr></div></tr>";


              $('.tbodyy').append(html);

        
          }


 sumIt2() ;
  //  $('#trform').DataTable();
          }
        });
      }
           
    });

    function sumIt2() {
      var total = 0,
        val;
        var sum = 0;
    $('.summed').each(function() {
        sum += Number($(this).val());
    });
      
      $('#total_amount').val('Rp. '+number_format(Math.round(sum), 0, ",", "."));
      var total2 = 0,
    val2
        var sum2 = 0;
    $('.masukk').each(function() {
        sum2 += Number($(this).val());
    });
   console.log(sum2);
      $('#total_qty').val(number_format(Math.round(sum2), 0, ",", ".")+' Barang');

    }
  
  

    function validasiRows(error) {
      const Toast = Swal.mixin({
        toast: true,
        confirmButtonColor: '#3085d6',
        position: 'top-end',
        // showConfirmButton: true,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: 'error',
        title: error,

      })
    }

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

  function workinprogress() {
      const Toast = Swal.mixin({
        toast: true,
        confirmButtonColor: '#3085d6',
        position: 'top-end',
        // showConfirmButton: true,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: 'info',
        title: 'Masih dalam perbaikan',

      })
    }
    function loadNotaa(nota){
      $.ajax({
          type: "POST",
          url: "<?php echo base_url('pembelian/transPo/loadNota') ?>",
          dataType: "JSON",
          data: {
            notaa: nota
          },
          cache: false,
          success: function(data) {


$('#modalLoad').modal('hide');
            const chunkSize = 7;
            for (let i = 0; i < data.length; i += chunkSize) {
              const chunk = data.slice(i, i + chunkSize);
            var total = chunk[3] * chunk[5];
              index += 1;
              console.log(chunk); 
              var html = "<tr class='tr_input'><td>" + index + "</td><td><input type='text' class='inst_amount form-control-plaintext mb-3 form-control-sm kodebarang' id='kodebarr_" + index + "' placeholder='Masukkan Nama Obat' name='KDBRG[]' maxlength='25' value = ' " + chunk[0] + "'></td><td><input type='text'  name='JMLBRG[]'value = ' " + chunk[5] + "'  size='4'   class='jumlah form-control form-control-sm masukk'id='jumlah_" + index + "' ></td><td><input type='readonly' maxlength='30'  name='NAMABRG[]' class='form-control-plaintext mb-3 form-control-sm' value = ' " + chunk[1] + "' id='kd_" + index + "'></td><td><input readonly type='text' value = ' " + number_format(chunk[2], 0, ',', '.') + "'   id='a_" + index + "' class=' form-control-plaintext mb-3 form-control-sm '><input type ='hidden' name='HARGA[]'  id='hargaj_" + index + "' class='harga'  value = ' " + chunk[2] + "' ></input></td><td><input  type='hidden' name='RLABA[]' value = ' " + chunk[5]+ "'   id='c_" + index + "'><input readonly type='text' value = ' " + chunk[4]+ "'   id='z_" + index + "' class=' form-control-plaintext mb-3 form-control-sm '></td><td><input type ='hidden' name='HBT[]'  id='harga_" + index + "' class='harga'  value = ' " + chunk[3] + "' ></input><input readonly type='text' class='form-control-plaintext mb-3 form-control-sm'  id='hargab_" + index + "' value = ' " + number_format(chunk[3], 0, ',', '.') + "'  ></td><td><input type='text'name='JMLMSK[]' value = ' " + chunk[6] + "' size='4'   class=' form-control form-control-sm ' id='order_" + index + "'    ></td><td><input class='summed form-control form-control-sm'  type='hidden'  id='total1_" + index + "'  name='subtotal[]' value = ' " + total + "' ><input readonly type='text' value = ' " + number_format(total, 0, ',', '.') + "'   id='total_" + index + "' class=' form-control-plaintext mb-3 form-control-sm '></td><td class=''><a class='btn btn-sm btn-danger text-white remove_button'><i class='fa-solid fa-trash'></i></a></td></div>" +
                "</tr></div></tr>";


              $('.tbodyy').append(html);

        
          }

          msg('Transaksi PO Berhasil di Load');
 sumIt2() ;
  //  $('#trform').DataTable();
          }
        });
    }
    function scan(id){
      $.ajax({
          type: "POST",
          url: "<?php echo base_url('pembelian/transPo/barcode') ?>",
          dataType: "JSON",
          data: {
            kode: id
          },
          cache: false,
          success: function(data) {



            const chunkSize = 7;
            for (let i = 0; i < data.length; i += chunkSize) {
              const chunk = data.slice(i, i + chunkSize);
            var total = chunk[3] * chunk[5];
            index += 1;
              console.log(chunk); 
              var html = "<tr class='tr_input'><td>" + index + "</td><td><input type='text' class='inst_amount form-control-plaintext mb-3 form-control-sm kodebarang' id='kodebarr_" + index + "' placeholder='Masukkan Nama Obat' name='KDBRG[]' maxlength='25' value = ' " + chunk[0] + "'></td><td><input type='text'  name='JMLBRG[]'  size='4'   class='jumlah form-control form-control-sm masukk'id='jumlah_" + index + "' ></td><td><input type='readonly' maxlength='30'  name='NAMABRG[]' class='form-control-plaintext mb-3 form-control-sm' value = ' " + chunk[1] + "' id='kd_" + index + "'></td><td><input readonly type='text' value = ' " + number_format(chunk[2], 0, ',', '.') + "'   id='a_" + index + "' class=' form-control-plaintext mb-3 form-control-sm '><input type ='hidden' name='HARGA[]'  id='hargaj_" + index + "' class='harga'  value = ' " + chunk[2] + "' ></input></td><td><input  type='hidden' name='RLABA[]' value = ' " + chunk[5]+ "'   id='c_" + index + "'><input readonly type='text' value = ' " + chunk[4]+ "'   id='z_" + index + "' class=' form-control-plaintext mb-3 form-control-sm '></td><td><input type ='hidden' name='HBT[]'  id='harga_" + index + "' class='harga'  value = ' " + chunk[3] + "' ></input><input readonly type='text' class='form-control-plaintext mb-3 form-control-sm'  id='hargab_" + index + "' value = ' " + number_format(chunk[3], 0, ',', '.') + "'  ></td><td><input type='text'name='JMLMSK[]' size='4'   class=' form-control form-control-sm ' id='order_" + index + "'    ></td><td><input class='summed form-control form-control-sm'  type='hidden'  id='total1_" + index + "'  name='subtotal[]' value = ' " + total + "' ><input readonly type='text' value = ' " + number_format(total, 0, ',', '.') + "'   id='total_" + index + "' class=' form-control-plaintext mb-3 form-control-sm '></td><td class=''><a class='btn btn-sm btn-danger text-white remove_button'><i class='fa-solid fa-trash'></i></a></td></div>" +
                "</tr></div></tr>";
          

              $('.tbodyy').append(html);

        
          }

          msg('Barang Berhasil Di Scan');
 sumIt2() ;
  //  $('#trform').DataTable();
          }
        });
    }
    function msgerr(msg) {
      const Toast = Swal.mixin({
        toast: true,
        confirmButtonColor: '#3085d6',
        position: 'top-end',
        // showConfirmButton: true,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: 'error',
        title: msg,

      })
    }
  $('table td').each(function() {
   var cellValue = parseInt($(this).text()); // Parse the cell value as an integer
   if(!isNaN(cellValue)){ // check if its a number
      total += cellValue; // Add the cell value to the total
   }
});
  function addRows() {
if (    $('.supp').val() == '' ) {
  msgerr('Pilih Supplier Terlebih Dahulu')
} else {
  

    index += 1;

    var html = "<tr class='tr_input'><td>" + index + "</td><td><input type='text' class='barr inst_amount form-control-plaintext mb-3 form-control-sm kodebarang' id='kodebarr_" + index + "' placeholder='Cari Barang..' name='KDBRG[]' maxlength='25' ></td><td><input type='number'  name='JMLBRG[]'size='4'   class='jumlah form-control form-control-sm masukk'id='jumlah_" + index + "' ></td><td><input type='readonly' maxlength='30'  name='NAMABRG[]' class='form-control-plaintext mb-3 form-control-sm' id='kd_" + index + "'></td><td><input readonly type='text'  id='a_" + index + "' class=' form-control-plaintext mb-3 form-control-sm '><input type ='hidden' name='HARGA[]'  id='hargaj_" + index + "' class='harga' ></input></td><td><input  type='hidden' name='RLABA[]' id='c_" + index + "'><input readonly type='text'   id='z_" + index + "' class=' form-control-plaintext mb-3 form-control-sm '></td><td><input type ='hidden' name='HBT[]'  id='harga_" + index + "' class='harga' ></input><input readonly type='text' class='form-control-plaintext mb-3 form-control-sm' id='hargab_" + index + "' ></td><td><input type='number'name='JMLMSK[]'   size='4'   class=' form-control form-control-sm ' id='order_" + index + "'    ></td><td><input class='summed form-control form-control-sm'  type='hidden'  id='total1_" + index + "'  name='subtotal[]' ><input readonly type='text'    id='total_" + index + "' class=' form-control-plaintext mb-3 form-control-sm '></td><td class=''><a class='btn btn-sm btn-danger text-white remove_button'><i class='fa-solid fa-trash'></i></a></td></div>" +
                "</tr></div></tr>";
          

                $('.tbodyy').append(html);
                $('.barr').focus()
              }
  }
  $(document).keypress(function(e) {
  if(e.charCode == 13) {
    var id = $('#kodebarr_' +index).val();
    scan(id);
    return false;    //<---- Add this line
scan(id);
  }

});
  $(document).on('keydown', '.jumlah', function() {

    var id = this.id;
    var splitid = id.split('_');
    var index = splitid[1];

  
    function sumIt2() {
      var total = 0,
        val;
        var sum = 0;
    $('.summed').each(function() {
        sum += Number($(this).val());
    });

    $('#total_amount').val('Rp. '+number_format(Math.round(sum), 0, ",", "."));

      var total2 = 0,
    val2;
        var sum2 = 0;
    $('.jumlah').each(function() {
        sum2 += Number($(this).val());
    });

   $('#total_qty').val(number_format(Math.round(sum2), 0, ",", ".")+' Barang');

    }
    function init() {
      $(".jumlah").on('keyup',
        function() {
          var jumlah;
          jumlah = parseInt($("#jumlah_" + index).val(), 10);
          var harga = parseInt($("#harga_" + index).val(), 10);
          var result = jumlah * harga;
          var roundResult = Math.round(result)
          $("#total_" + index).val(number_format(roundResult, 0, ",", "."));
          $("#total1_" + index).val(roundResult);
        }
      );
    }

    $(document).ready(init);

    function setGet() {
      $(".obat").on('keyup',
        function() {

          var get = $("#get").val();
          $("#set_" + index).val(get);
        }
      );
    }
    $(document).ready(setGet);
    $(function() {

      // $('.datepicker').datepicker(); // not needed for this test



      $(document).on('keyup', '.jumlah', sumIt2);
  
      sumIt2() 
    });
  });
  $("#trform").on('click','.remove_button',function(){
         // get the current row
         var currentRow=$(this).closest("tr"); 
         
         var col1=currentRow.find(".kodebarang").val(); // get current row 1st TD value
     
    
         const todelete = arr.indexOf(col1);

  arr.splice(todelete, 1);

  index = index - 1;
  $(this).parents('tr').remove();
  console.log(index);
    });
  // $(document).on('click', '.remove_button', function(){
  //         // $(this).parents('tr').remove();
  //     var tes =   $(this).val(0);
  //     console.log(tes)
  //       index = index - 1;

  //    });
  function msg(success) {
      const Toast = Swal.mixin({
        toast: true,
        confirmButtonColor: '#3085d6',
        position: 'top-end',
        // showConfirmButton: true,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: 'success',
        title: success,

      })
    }  function number_format(number, decimals, decPoint, thousandsSep) {
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
  function sumIt2() {
      var total = 0,
        val;
        var sum = 0;
    $('.summed').each(function() {
        sum += Number($(this).val());
    });
      
      $('#total_amount').val('Rp. '+number_format(Math.round(sum), 0, ",", "."));
      var total2 = 0,
    val2
        var sum2 = 0;
    $('.masukk').each(function() {
        sum2 += Number($(this).val());
    });
   console.log(sum2);
      $('#total_qty').val(number_format(Math.round(sum2), 0, ",", ".")+' Barang');

    }
    $('.barr').keydown(function (e) {

});
</script>
