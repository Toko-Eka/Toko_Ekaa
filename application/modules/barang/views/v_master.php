
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
            <button class="btn btn-primary" onclick="addBarg()"><i class="fa fa-plus"></i> Tambah Barang</button>
        <button class="btn btn-info" onclick="reload_table()"><i class="fa-solid fa-rotate-right"></i> Refresh</button>
            </div>
            <div class="panel-body">
                <hr><p>Filter Data</p>
                <form id="filter" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-4">
                  
                    <div class="form-group">
                        <label for="country" class="control-label">Supplier</label>
                        <input class="form-control" type="text" id="supp" />
                        <input hidden class="" type="text" id="idsupp" />
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="FirstName" class="control-label">Jenis</label>
                      
                        <input class="form-control" type="text" id="jenn" />
                        
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                        <label for="LastName" class="control-label">Jumlah</label>
                        <div class="input-group mb-3">
  <div class="input-group-prepend">
  <select class="form-control" name="" id="MORELESS">
  <option value="">Sama Dengan</option>
                                    <option value="<">Kurang Dari</option>
                                <option value=">">Lebih Dari</option>
                                <option value="1">Nol</option></select>
  </div>
  
  <input type="text" class="form-control" id="stok">
</div>
                       
                       
                    </div>
                    </div>
                    <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" id="address"></textarea>
                        </div>
                    </div>
                    </div> -->
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                      
                            <button type="button" id="btn-filter" style="float: right;" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-reset"  style="float: right;"class="btn btn-default">Reset</button>
                    
                    </div>
                </form>
            </div>
                  </div>
              </div>
              <div class="card">
                  <!-- <div class="card-header">
                    <h4>Tabel Barang</h4>
                 
                  </div> -->
                  <div class="card-body">
              
  
                <!-- Table -->
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
                <form action="#" id="formDataModal" class="form-horizontal">
                 
                    <div class="form-body">
                        <div class="form-group">
                            <label id="lbl" class="control-label col-md">Kode Barang</label>
                            <div class="col-md-12">
                                <input  style="text-transform:uppercase" name="KDBRG"  placeholder="Kode Barang" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md">Nama Barang</label>
                            <div class="col-md-12">
                                <input  style="text-transform:uppercase" name="NAMABRG"  placeholder="Nama Barang" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="control-label col-md">Jenis</label>
                            <div class="col-md-12">
                                <input  style="text-transform:uppercase" name="JENIS"  placeholder="Jenis" class="form-control" type="text">
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
                            <label class="control-label col-md">Supplier</label>
                            <div class="col-md-12">
                        <input type="text" class="form-control" id="supp2" name="KDSUP">                             <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md">Jumlah</label>
                       
                             
                            </div>
                            <div class="col-md-12">
                                <input style="text-transform:uppercase"type="number" name="AKHIR" placeholder="Jumlah" class="form-control"></input>
                                <span class="help-block"></span>
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
</div>
</div>
<!-- /.modal -->
<!-- End Bootstrap modal -->
<!-- Script -->

<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
    // $('#supp').select2();
    // $('#supp2').select2();
    $(function () {
             $( "#supp" ).autocomplete({
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
          $('#supp').val(ui.item.label); // display the selected text
         
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
          $('#supp2').val(ui.item.label); // display the selected text
         
          return false;
        }
      });
      $( "#supp2" ).autocomplete( "option", "appendTo", "#modal_form" );
        });
        $( "#jenn" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url: "<?php echo site_url('Barang/searchJen'); ?>",
            type: 'post',
            dataType: "json",
            data: {
              search2: request.term
            },
            success: function( data ) {
              response( data );
            }
          });
        },
        select: function (event, ui) {
          // Set selection
        //   $('#supp').val(ui.item.label); // display the selected text
          $('#jenn').val(ui.item.value); // save selected id to input
          return false;
        }
      });
        // });
    //datatables
    table = $('#tableBrg').DataTable({ 
    "lengthPage": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
       
        "dom": '<"pull-left"f><"pull-right"l>tip',
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Barang/brgList')?>",
            "type": "POST",
            "data": function ( data ) {
                
                data.JENIS = $('#jenn').val();
                data.KDSUP = $('#supp').val();
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
    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#filter')[0].reset();
        table.ajax.reload();  //just reload table
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
 
 
 
function addBarg()
{
    save_method = 'add';
 
    $('#formDataModal')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#modal_form').modal('show');
    $('.modal-title').text('Tambah Barang'); 
}
function printKartuStok(id){
 
           
            myw = window.open('<?php echo base_url() ?>barang/printKartuStok/' + id);

            myw.document.close(); //missing code


            myw.focus();
}
function editBarg(id)
{
    save_method = 'update';
   
    $('#formDataModal')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
 
  
    $.ajax({
        url : "<?php echo site_url('Barang/editBrg/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
         
            $('[name="KDBRG"]').val(data.KDBRG);
            $('[name="NAMABRG"]').val(data.NAMABRG);
            $('[name="JENIS"]').val(data.JENIS);
            $('[name="KDSUP"]').val(data.KDSUP);
            $('[name="AKHIR"]').val(data.AKHIR);
          
            $('#modal_form').modal('show'); 
            $('.modal-title').text('Edit Barang'); 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }   
    });
}
 
function reload_table()
{
    table.ajax.reload(null,false); 
}
 
function save()
{
    $('#btnSave').text('saving...'); 
    $('#btnSave').attr('disabled',true); 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('Barang/addBrg')?>";
    } else {
        url = "<?php echo site_url('Barang/updateBrg')?>";
    }
 
    
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formDataModal').serialize(),
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) 
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
 
            $('#btnSave').text('save'); 
            $('#btnSave').attr('disabled',false); 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); 
            $('#btnSave').attr('disabled',false); 
 
        }
    });
}
 
function del(id)
{
    Swal.fire({
                title: 'Peringatan',
  text: "Apakah anda yakin ingin menghapus data ini? ",
  icon: 'warning',
  showCancelButton: true,
  background:'#fff',
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
            url : "<?php echo site_url('barang/delBrg')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
           

                }
            })
      
      
 
    
}
 
</script>
              </div>
        
          
</section>
