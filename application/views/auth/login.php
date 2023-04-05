<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Toko Eka - Login</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?=base_url()?>vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?=base_url()?>vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendors/styles/style.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/modules/bootstrap/css/bootstrap.min.css">
  <script src="<?= base_url()?>assets/modules/jquery.min.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>
<?php
//whether ip is from share internet
if (!empty($_SERVER['HTTP_CLIENT_IP']))   
  {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
  {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
//whether ip is from remote address
else
  {
    $ip_address = $_SERVER['REMOTE_ADDR'];
  }
// echo $ip_address;
?>
<body class="login-page">

	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">

					<img src="vendors/images/login-page-img.png" alt="">
	
	
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Toko Eka <strong>Database Lokal</strong></h2>
						</div>
           
            <form method="POST"action="<?php echo base_url()?>/auth" name="logiin" onsubmit="return validateForm()">
			
							<div class="input-group custom">
              <input id="email" type="text" class="form-control form-control-lg""  name="UserID"  placeholder="Username" value="<?= set_value('UserID')?>" tabindex="1"  autofocus>
								
								<div class="input-group-append custom">
                <!-- <div class="invalid-feedback">
                      Silahkan isi User ID
                    </div> -->
									<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
								</div>
							</div>
							<div class="input-group custom">
              <input type="password" class="form-control form-control-lg" placeholder="**********"name="Password" tabindex="2" >
              <!-- <div class="invalid-feedback">
                      Silahkan isi password
                    </div> -->
								<div class="input-group-append custom">
               
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
								
							</div>
							<!-- <p>Untuk akses lokal silahkan ketik "localhost"</p>
	<p>Untuk Akses ke server silahkan ketik alamat ip server (misalnya : 192.138.1.11</p>
<input type="text" class="form-control"  placeholder="Masukkan IP" id="ip2" value="<?= $ip_address;?>"> -->
							<div class="row pb-30">
								<div class="col-6">
									
								</div>
								
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
										-->
                    <input type="submit"class="btn btn-primary btn-lg btn-block" tabindex="4" name="login"  value="Login"></input>
								
									</div>
						
						<hr>
									<a class="btn btn-info btn-block"style="margin: center;"  data-toggle="modal" data-target="#connection" href="#">Connection Properties</a>
						
								</div>
							</div>
						</form>
					</div>
				</div>

		</div>
	</div>
	<!-- Modal -->
<div class="modal fade" id="connection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Masukkan IP</h5>
        <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	<h6>Contoh : Untuk akses lokal silahkan ketik "localhost"</h6>
	<h6>Untuk Akses ke server silahkan ketik alamat ip server (misalnya : 192.138.1.11</h6>
<input type="text" class="form-control" placeholder="Masukkan IP" id="ip" value="<?= $ip_address;?>">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="changeParam()" id="a" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>

$(document).ready(function() {
	
			  <?php if ($this->session->flashdata('err')): ?>
                        
                        msgErr('  <?=$this->session->flashdata('err')?> ');
                  
              <?php endif; ?>
			  <?php if ($this->session->flashdata('msg')): ?>
                        
                        msg('  <?=$this->session->flashdata('msg')?> ');
                  
              <?php endif; ?>
			  });
			  function validateForm() {
  let x = document.forms["logiin"]["UserID"].value;
  let y = document.forms["logiin"]["Password"].value;
  if (x == "") {
    msgErr('Kolom Username Harus Di Isi !');
    return false;
  }else if(y == "") {
    msgErr('Kolom Password Harus Di Isi !');
    return false;
  }
}
	function msgErr(err) {
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
        title: err,

      })
    }
	function msg(msg) {
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
        title: msg,

      })
    }
// $("#a").attr("href", "http://www.google.com/")
// $('#ip').hide();
// // $('#brg').hide();
// $("#lokal").change(function() {
//     if($('#lokal').is(':checked')) {
//         $('#ip').show();
	
//     }
//     else{
//         $('#ip').hide();
//     }
// });
// $("#network").change(function() {
//     if($('#network').is(':checked')) {
//         // $('#ip').show();
	
// 		$('#ip').hide();
//     }
//     // else{
//     //     $('#ip').hide();
//     // }
// });


function changeParam(){
	var ip = $("#ip").val();
	var url = "http://"+ip+"/Toko_Eka/Auth"
	console.log(url);
// 


		location.href = url;
	// window.history.pushState({}, url);


	// $("#a").prop("href",+url);
}
</script>
	<!-- js -->
	<script src="<?=base_url()?>assets/vendors/scripts/core.js"></script>
	
  <script src="<?= base_url()?>assets/modules/jquery.min.js"></script>
  <script src="<?= base_url()?>assets/modules/sweetalert2/dist/sweetalert2.js"></script>
  <script src="<?= base_url()?>assets/modules/sweetalert2/dist/sweetalert2.min.js"></script>
  <link href="<?= base_url()?>assets/modules/sweetalert2/dist/sweetalert2.css" rel="stylesheet">
</body>
</html>






<!--  -->