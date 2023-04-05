<section>

<h4>Data User</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Form Basic</li>
								</ol>
							</nav>
						</div>
						<div class="col-md-6 col-sm-12 text-right">
							
						</div>
					</div>
				</div>
          <div class="row">
              <div class="col-12 mb-4">
              <div class="card">
                  <div class="card-header">
                    <h4>Tabel Users</h4>
                 
                  </div>
                  <div class="card-body">
                  <button class="btn btn-primary" onclick="addBarg()"><i class="fa fa-plus"></i> Tambah Barang</button>
        <button class="btn btn-info" onclick="reload_table()"><i class="fa-solid fa-rotate-right"></i> Refresh</button>
        <br><hr>
                <!-- Table -->
                <div class="table-responsive-md">
     <table id='tableBrg' class='table table-striped' style="width:100%">

<thead>
  <tr>
    <th>UserID</th>
    <th>ROLE</th>
    <th>IS_ACTIVE</th>
 
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
                <form action="#" id="data" class="form-horizontal">
                 
                    <div class="form-body">
                        <div class="form-group">
                            <label id="lbl" class="control-label col-md-3">Kode Barang</label>
                            <div class="col-md-9">
                                <input  style="text-transform:uppercase" name="KDBRG" placeholder="Kode Barang" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jenis</label>
                            <div class="col-md-9">
                                <input  style="text-transform:uppercase" name="JENIS" placeholder="Jenis" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Barang</label>
                            <div class="col-md-9">
                                <input  style="text-transform:uppercase" name="NAMABRG" placeholder="Nama Barang" class="form-control" type="text">
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
                                <input  name="KDSUP" placeholder="Supplier" class="form-control"  style="text-transform:uppercase"></input>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jumlah</label>
                            <div class="col-md-9">
                                <input style="text-transform:uppercase"type="number" name="AKHIR" placeholder="Jumlah" class="form-control"></input>
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
    table = $('#tableBrg').DataTable({ 
        "lengthChange": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
      
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Users/usrList')?>",
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
 
 
 
function addBarg()
{
    save_method = 'add';
 
    $('#data')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();
    $('#modal_form').modal('show');
    $('.modal-title').text('Tambah Barang'); 
}
 
function editBarg(id)
{
    save_method = 'update';
   
    $('#data')[0].reset(); 
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
        data: $('#data').serialize(),
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