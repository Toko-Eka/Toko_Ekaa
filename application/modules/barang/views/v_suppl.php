<section>

						<div class="col-md-6 col-sm-12 text-right">
							
						</div>
					</div>
				</div>
          <div class="row">
              <div class="col-12 mb-4">
              <div class="card">
                  <div class="card-header">
                    <h4>Tabel Supplier</h4>
                    
                  </div>
                
                  <div class="card-body">
                  <button class="btn btn-primary" onclick="addSup()"><i class="fa fa-plus"></i> Tambah Supplier</button>
 <button class="btn btn-info" onclick="reload_table()"><i class="fa fa-reload"></i> Refresh</button><br> <hr>
 <div></div>
              <!-- Table -->
                <div class="table-responsive-md">
     <table id='tableSupp' class='table table-striped' style="width:100%">

<thead>
  <tr>
    <th>KD SUPPLIER</th>
    <th>NAMA</th>
    <th>FAKTUR</th>
    <th>Faktor X Order</th>
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
            <div class="modal-body data2">
                <form action="#" id="data2" class="form-horizontal">
                 
                    <div class="form-body">
                        <div class="form-group">
                            <label id="lbl" class="control-label col-md-3">Kode Supplier</label>
                            <div class="col-md-9">
                                <input  style="text-transform:uppercase" name="KDSUP" placeholder="Kode Barang" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama</label>
                            <div class="col-md-9">
                                <input  style="text-transform:uppercase" name="NAMA" placeholder="Nama" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                      
                       
                        <div class="form-group">
                            <label class="control-label col-md-3">Faktur</label>
                            <div class="col-md-9">
                                <select name="FAKTUR" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="1">Iya</option>
                                    <option value="0">Tidak</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Faktur X Order</label>
                            <div class="col-md-9">
                                <input  style="text-transform:uppercase" name="FxOrder" placeholder="Nama" class="form-control" type="number">
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
 
    //datatables
    table = $('#tableSupp').DataTable({ 
        "lengthMenu": [ 50, 75, 100, 250, 500, 1000 ],
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
       
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Barang/Supplier/suppList')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });
 
});
 
 
 
function addSup()
{
    save_method = 'add';
 
    $('#data2')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#modal_form').modal('show');
    $('.modal-title').text('Tambah Supplier'); 
}
 
function editSup(id)
{
    save_method = 'update';
   
    $('#data2')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
 
  
    $.ajax({
        url : "<?php echo site_url('Barang/Supplier/editSupp/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
         
            $('[name="KDSUP"]').val(data.KDSUP);
            $('[name="NAMA"]').val(data.NAMA);
            $('[name="FAKTUR"]').val(data.FAKTUR);
            $('[name="FxOrder"]').val(data.FxOrder);

          
            $('#modal_form').modal('show'); 
            $('.modal-title').text('Edit Supplier'); 
 
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
        url = "<?php echo site_url('Barang/Supplier/addSupp')?>";
    } else {
        url = "<?php echo site_url('Barang/Supplier/updateSupp')?>";
    }
 
    
    $.ajax({
        url : url,
        type: "POST",
        data: $('#data2').serialize(),
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
            url : "<?php echo site_url('Barang/Supplier/delSupp')?>/"+id,
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