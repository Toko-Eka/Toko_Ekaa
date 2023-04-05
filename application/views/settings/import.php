<section>
<h4>Settings</h4>   

							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                    <!-- <li class="breadcrumb-item"><a href="#">Import</a></li> -->
									<li class="breadcrumb-item active" aria-current="page">Import</li>
								</ol>
							</nav>
						</div>
						<div class="col-md-6 col-sm-12 text-right">
							
						</div>
					</div>
				</div>
              
                  <div class="card" style= "margin: auto; width: 100%;" >
                    <div class="card-header">Import Database</div>
                    <div class="card-body">  <div class="form-group">
                  <h4>Pilih File Database</h4>
                  <hr>
            
<!--  -->
<?php echo $error;?> 
<?php 
$a='';
$b='';
$a = $totalFiles[0];
$b = $totalFiles[1];
echo $a;
?> 
<hr>
<input hidden type="text" id="param1" value="<?=$a?>" >
<input hidden type="text" id="param2" value="<?=$b?>" >
<strong><?php if(isset($totalFiles)) echo "Successfully uploaded ".count($totalFiles)." files"; ?></strong>
       
    <form method='post' action='<?= base_url()?>/uploadImport/do_upload' enctype='multipart/form-data'>
   
      <input type='file' name='files[]' class='form-control' multiple="" onchange='changeEventHandler(event);'> <br/><br/>
      <input type='submit' class='btn btn-primary' value='Upload' name='upload' />
<button onclick="sendParam()" class="btn btn-success" id="btnImport" >Import Database</button>
    </form>
                <!-- <button onclick="print()" class="btn btn-primary btn-block" id="save">Print</button> -->
            </div>
                  </div>
</div>
      
<script>

function sendParam(){
    var primary= $('#param1').val();
    var log= $('#param2').val();

 var url = '<?php echo base_url()?>uploadImport/switchdb/'+primary+'/'+log;
//  $.ajax({url: url, success: function(result){

//     }});
window.open(url);
}
</script>


            <br>   
                
        </section>




