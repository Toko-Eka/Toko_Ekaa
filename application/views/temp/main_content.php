<section>

	<div class="col-md-6 col-sm-12 text-right">

	</div>
	</div>
	</div>

	<div class="card-box pd-20 height-100-p mb-30">
		<div class="row align-items-center">


			<div class="col-md-12">
				<h4 class="font-20 weight-500 mb-10 text-capitalize">
					Selamat Datang, <div class="weight-600 font-30 text-blue"><?= $this->session->userdata('UserID'); ?></div>
				</h4>
				<p class="font-18 max-width-600">di Toko Eka. <strong>Database Server</strong></p>
			</div>
		</div>
	</div>


	<div class="card-box pd-20 height-100-p mb-30">

		 <center><div class="weight-600 font-14">Laba & Rugi Periode</div></center>
		<hr>


			<!-- <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-calendar"></i>
                      </div>
                    </div> -->
					<div class="row">
						<div class="col-md-11">
			<div class='daterange-cus' id="daterange-cus" style="font-size: 17px; background: #fff; cursor: pointer; padding:10px 17px; border: 1px solid #ccc; width: 100%">
				<i class="fa fa-calendar"></i>&nbsp;
				<span></span> <i class="fa fa-caret-down"></i>
			</div></div><div class="col-md-1"><button class="btn btn-primary	" id="filter">Cari</button></div>
	</div>
			<input type="text" name="a" id="a" hidden>
			<input type="text" name="b" id="b" hidden>
			<input type="text" name="tgl_awal" id="split1" hidden>
			<input type="text" name="tgl_akhir" id="split2" hidden>
			<!-- <input type="text" id="tgl" class="form-control" name="tgl_periode" > -->

			<center>
		</center>
		</div>
		

	</div>

	<div class="row clearfix progress-box">
				<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							
							<h5 class="text-blue padding-top-10 h5">Pemasukan</h5>
							<span class="d-block" id="totalJual"> <i class="fa fa-line-chart text-blue"></i></span>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							
							<h5 class="text-blue padding-top-10 h5">Pengeluaran</h5>
							<span class="d-block" id="totalBeli"> <i class="fa text-light-green fa-line-chart"></i></span>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							 
							<h5 class="text-blue padding-top-10 h5">Laba</h5>
							<span class="d-block" id="omzet"> <i class="fa text-light-orange fa-line-chart"></i></span>
						</div>
					</div>
				</div>
	</div>
	<div class="row clearfix progress-box">
				<div class="col-lg-6 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
						
							<h5 class="text-light-blue padding-top-10 h5">Barang Masuk</h5>
							<span class="d-block" id="qtyM"> <i class="fa text-light-purple fa-line-chart"></i></span>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
						
							<h5 class="text-light-blue	 padding-top-10 h5">Barang Keluar</h5>
							<span class="d-block" id="qtyK"> <i class="fa text-light-purple fa-line-chart"></i></span>
						</div>
					</div>
				</div>
			</div>


	</div>
	<script type="text/javascript">
   $(function() {
      $('#reservation').daterangepicker({
         //singleDatePicker: true,
         //showDropdowns: true
      }, 
     function() {
        var date = $("#reservation").val();
        var replaced = date.split(' ').join('')
        $("#partialtable").load('@(Url.Action("GetDateResults", "Temps", null, Request.Url.Scheme))?date=' + replaced);
    });
  });
</script>
</section>
<script>
	  $(document).ready(function() {
		<?php if ($this->session->flashdata('msg')): ?>
                        
                        msg('  <?=$this->session->flashdata('msg')?> ');
                  
              <?php endif; ?>
		function msg(msg) {
      const Toast = Swal.mixin({
        toast: true,
        confirmButtonColor: '#3085d6',
        position: 'top-end',
        showConfirmButton: true,
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
		$('#totalJual').text('0');
			$('#qtyK').text('0');
			$('#totalBeli').text('0');
			$('#qtyM').text('0');
			$('#omzet').text('0');
		// getGrandTotal();
	var startDate = moment();
        var endDate = moment();

        function cb(startDate, endDate) {
            $('.daterange-cus span').html(startDate.format('MMMM D, YYYY') + ' s/d ' + endDate.format('MMMM D, YYYY'))
        }
        // function cb(startDate, endDate) {
        //     $('#daterange-cus span').html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
        // }
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
            // function (startDate, endDate) {
            //   $('.daterange-cus span').html(startDate.format('MMMM D, YYYY') + ' s/d ' + endDate.format('MMMM D, YYYY'))
            // }
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
			// getGrandTotal()
        });
	});



	
	$( "#filter" ).click(function() {
  getGrandTotal();

});
	function sum(){
	var masuk =parseFloat($('#a').val());
	var keluar = parseFloat($('#b').val());;
	var omzet =0;
		omzet = masuk - keluar; 
		console.log(omzet);
		$('#omzet').text('Rp '+number_format(omzet));
}
	function getGrandTotal() {
		$('#totalBeli').text('0');
			$('#qtyM').text('0');
		$('#totalJual').text('0');
			$('#qtyK').text('0');
			$('#omzet').text('0');
var tglAwal = $('#split1').val();
var tglAkhir = $('#split2').val();
$.ajax({
	type: "POST",
	url: "<?php echo base_url('Master/getGrandTotalJual') ?>",
	dataType: "JSON",
	data: {
		"tgl_awal": tglAwal,
		"tgl_akhir": tglAkhir
	},
	cache: false,
	success: function(data) {
		$.each(data, function(GRANDJUAL,JMLK) {
			
			$('#totalJual').text('Rp '+ number_format(data.GRANDJUAL));
			$('#a').val(data.GRANDJUAL);
			$('#qtyK').text(number_format(data.JMLK)+' Barang ');
	


		});
		$.ajax({
	type: "POST",
	url: "<?php echo base_url('Master/getGrandTotalBeli') ?>",
	dataType: "JSON",
	data: {
		"tgl_awal": tglAwal,
		"tgl_akhir": tglAkhir
	},
	cache: false,
	success: function(data) {
		$.each(data, function(GRANDBELI,JMLM) {
		
			$('#b').val(data.GRANDBELI);
			$('#totalBeli').text('Rp '+ number_format(data.GRANDBELI));
			$('#qtyM').text(number_format(data.JMLM)+' Barang ' );
			sum();
		});

	}
});
	}
});

return false;
sum();
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
	
</script>