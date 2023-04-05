<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Toko Eka</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?=base_url()?>assets/vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?=base_url()?>assets/vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>assets/vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/vendors/styles/style.css">

  
  <link rel="stylesheet" href="<?= base_url()?>assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url()?>assets/modules/bootstrap-daterangepicker/daterangepicker.css">

  <!-- Template CSS -->

  <script src="<?= base_url()?>assets/modules/jquery.min.js"></script>
  <link rel="stylesheet" href="<?= base_url()?>assets/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?= base_url()?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">	

  
  <link rel="stylesheet" href="<?= base_url()?>assets/modules/select2/dist/css/select2.min.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>
<div class="preloader"><span class="loading-bar blue-colored"></span></div>
<style>
	.preloader {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1999999999;
}

.preloader.immune {
  bottom: 0;
}

.preloader.white {
  background-color: rgba(255, 255, 255, .3);
}

.preloader.black {
  background-color: rgba(1, 1, 1, .3);
}

.preloader > i.radial-loader:not(:required) {
  -moz-animation: radial-loader .5s infinite linear;
  -webkit-animation: radial-loader .5s infinite linear;
  animation: radial-loader .5s infinite linear;
  border-color: #ea6052;
  border-style: solid;
  border-width: 2px;
  border-right-color: transparent;
  border-radius: 100%;
  display: block;
  position: relative;
  float: right;
  margin: 10px;
  overflow: hidden;
  width: 10px;
  height: 10px;
}

.preloader > span.loading-bar {
  -moz-animation: loading-bar 1s 1;
  -webkit-animation: loading-bar 1s 1;
  animation: loading-bar 1s 1;
  display: block;
  height: 3px;
  background-color: #ea6052;
  opacity: 0;
  transition: width .2s;
}

.preloader > span.loading-bar.red-colored {
  background-color: #ea6052;
}

.preloader > .red-colored.radial-loader {
  border-color: #ea6052 !important;
  border-right-color: transparent !important;
}

.preloader > span.loading-bar.blue-colored {
  background-color: #000080;
}

.preloader > .blue-colored.radial-loader {
  border-color: #3498db !important;
  border-right-color: transparent !important;
}

.preloader > span.loading-bar.green-colored {
  background-color: #2ecc71;
}

.preloader > .green-colored.radial-loader {
  border-color: #2ecc71 !important;
  border-right-color: transparent !important;
}

.preloader > span.loading-bar.yellow-colored {
  background-color: #f1c40f;
}

.preloader > .yellow-colored.radial-loader {
  border-color: #f1c40f !important;
  border-right-color: transparent !important;
}
/* Animations */

@-moz-keyframes loading-bar {
  0% {
    width: 0%;
    opacity: 1;
  }
  90% {
    width: 90%;
    opacity: 1;
  }
  100% {
    width: 100%;
    opacity: 0;
  }
}

@-webkit-keyframes loading-bar {
  0% {
    width: 0%;
    opacity: 1;
  }
  90% {
    width: 90%;
    opacity: 1;
  }
  100% {
    width: 100%;
    opacity: 0;
  }
}

@keyframes loading-bar {
  0% {
    width: 0%;
    opacity: 1;
  }
  90% {
    width: 100%;
    opacity: 1;
  }
  100% {
    width: 100%;
    opacity: 0;
  }
}

@-moz-keyframes radial-loader {
  0% {
    -moz-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  20% {
    -moz-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@-webkit-keyframes radial-loader {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes radial-loader {
  0% {
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

/* OFF-TOPIC */


</style>
<script>
    
  function preloader(immune, background, color) {
  $("body").prepend('<div class="preloader"><span class="loading-bar"></span></div>');

  if (immune == true) {
    $("body > div.preloader").addClass('immune');
  }

  if (background == 'white') {
    $("body > div.preloader").addClass('white');
  }
  
  else if (background == 'black') {
    $("body > div.preloader").addClass('black');
  }

  if (color == 'red') {
    $("body > div.preloader span.loading-bar").addClass('red-colored');
    $("body > div.preloader i.radial-loader").addClass('red-colored');
  } else if (color == 'blue') {
    $("body > div.preloader span.loading-bar").addClass('blue-colored');
    $("body > div.preloader i.radial-loader").addClass('blue-colored');
  } else if (color == 'green') {
    $("body > div.preloader span.loading-bar").addClass('green-colored');
    $("body > div.preloader i.radial-loader").addClass('green-colored');
  } else if (color == 'yellow') {
    $("body > div.preloader span.loading-bar").addClass('yellow-colored');
    $("body > div.preloader i.radial-loader").addClass('yellow-colored');
  }

};

preloader(false, 'immune', 'blue');
</script>
          <!-- sidebar menu -->
          <?php echo $this->load->view($header); ?>
          <!-- /sidebar menu -->
          
       

      <!-- top navigation -->
      <?php //echo $this->load->view($header); ?>
      <!-- /top navigation -->

      <!-- page content -->
      
      <h4><?= $group ?> <?= $thisPage ?></h4>
    </div>
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html"><?= $group ?></a></li>
        
            <li class="breadcrumb-item active" aria-current="page"><?= $thisPage ?></li>
        </ol>
    </nav>
    </div>
          <?php echo $this->load->view($content); ?>
     
      <!-- /page content -->
  
      <!-- footer content -->
    
			</div>
			<div class="footer-wrap pd-20 mb-20 card-box">
				Toko Eka - copyright @2023 FootPrint</a>
			</div>
		</div>
	</div>
	<!-- js -->
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
	<script src="<?=base_url()?>assets/vendors/scripts/core.js"></script>
	<script src="<?=base_url()?>assets/vendors/scripts/script.min.js"></script>
	<script src="<?=base_url()?>assets/vendors/scripts/process.js"></script>
	<script src="<?=base_url()?>assets/vendors/scripts/layout-settings.js"></script>
  
  <script
  src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
  integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0="
  crossorigin="anonymous"></script>
  <script src="<?= base_url()?>assets/modules/select2/dist/js/select2.js"></script>
<script src="<?= base_url()?>assets/modules/datatables/datatables.min.js"></script>
  <script src="<?= base_url()?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <!-- <link rel="stylesheet" href="<?= base_url()?>assets/modules/dist/select2/css/select2.min.css"> -->
  <script src="<?= base_url()?>assets/modules/popper.js"></script>

  <script src="<?= base_url()?>assets/modules/tooltip.js"></script>
  <script src="<?= base_url()?>assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?= base_url()?>assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="<?= base_url()?>assets/modules/moment.min.js"></script>
  <script src="<?= base_url()?>assets/modules/jquery.base64.js"></script>

  <script src="<?= base_url()?>assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- JS Libraies --><script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>


  <script src="<?= base_url()?>assets/modules/sweetalert2/dist/sweetalert2.js"></script>
  <script src="<?= base_url()?>assets/modules/sweetalert2/dist/sweetalert2.min.js"></script>
  <link href="<?= base_url()?>assets/modules/sweetalert2/dist/sweetalert2.css" rel="stylesheet">
</body>
</html>
      <!-- /footer content -->
    </div>
  </div>

  <!-- javascript liblary -->
  
  <!-- Bootstrap -->
  
	



   
</body>
</html>