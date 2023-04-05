<body class="sidebar-light"> 


	<div class="header ">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
			<div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
		
		</div>
		<div class="header-right">
		
			<div class="user-notification">
				<div class="dropdown">
					<a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
						<i class="icon-copy dw dw-notification"></i>
						<span class="badge notification-active"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<div class="notification-list mx-h-350 customscroll">
						
							<H6>No Notification</H6>

						</div>
					</div>
				</div>
			</div>
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
					<span class="user-icon">
							<img src="<?= base_url() ?>/assets/vendors/images/profpic.png" alt="">
						</span>
						<span class="user-name"><?= $this->session->userdata('UserID'); ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">

						<a class="dropdown-item" onclick="conflogout()"><i class="dw dw-logout"></i> Log Out</a>
					</div>
				</div>
			</div>

		</div>
	</div>

	

	<div class="left-side-bar">
		<div class="brand-logo">
			<a href="<?= base_url() ?>Master/">
				<h4 class="text-black">Toko Eka </h4>
				<h6><span class="badge badge-sm badge-pill badge-success">Server</span></h6>
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
						</a>
						<ul class="submenu">
							<li><a href="<?= base_url() ?>Master/">Dashboard</a></li>

						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-edit2"></span><span class="mtext">Inventory</span>
						</a>
						<ul class="submenu">
							<li><a href="<?= base_url() ?>Barang/Barang/">Barang</a></li>
							<li><a href="<?= base_url() ?>Barang/Supplier/">Supplier</a></li>
							<!-- <li><a href="<?= base_url() ?>L_BarangMasuk/">Laporan Barang Masuk</a></li> -->

						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-edit2"></span><span class="mtext">Laporan</span>
						</a>
						
						<ul class="submenu">
							<li><a href="<?= base_url() ?>Laporan/Kasir/">Rekap Kasir</a></li>
							<li><a href="<?= base_url() ?>Penjualan/TransJual/laporan">Rincian Jual</a></li>
							<li><a href="<?= base_url() ?>Pembelian/TransBeli/laporan">Rincian Beli</a></li>
							<li><a href="<?= base_url() ?>Laporan/RinciJualNota">Rincian Penjualan/NOTA</a></li>

							<li><a href="<?= base_url() ?>Laporan/BrgMasuk/"> Barang Masuk (Beli) Per Supplier / Barang</a></li>
							<li><a href="<?= base_url() ?>Laporan/BrgHarga">Harga Barang /Supplier</a></li>
							<li><a href="<?= base_url() ?>Laporan/UnpaidTr">Penjualan Belum Di Bayar</a></li>
					
							<li><a href="<?= base_url() ?>Laporan/JualJenis/kanvas">Kanvas</a></li>
									<li><a href="<?= base_url() ?>Laporan/JualJenis/program">Program</a></li>
									<li><a href="<?= base_url() ?>Laporan/JualJenis/olshop">OL Shop</a></li>
							<li><a href="<?= base_url() ?>/">Hapus Data<span class="badge badge-sm badge-danger">Belum</span></a></li>
							<li><a href="<?= base_url() ?>Laporan/MarginJual">Margin Penjualan</a></li>
							<li><a href="<?= base_url() ?>Laporan/L_inventory">Nilai Inventory / Stock</a></li>
							<li><a href="<?= base_url() ?>Laporan/L_returKeluar">Laporan Retur Keluar</a></li>
							<li><a href="<?= base_url() ?>Laporan/L_returMasuk">Laporan Retur Masuk</a></li>
							<li><a href="<?= base_url() ?>Laporan/BrgTakTerjual">Barang Belum Terjual</a></li>
							<li><a href="<?= base_url() ?>Laporan/kartuStok">Kartu Stok<span class="badge badge-sm badge-primary">Baru</span></a></li>

						</ul>
					</li>
				

							<li class="dropdown">
								<a href="javascript:;" class="dropdown-toggle">
									<span class="micon fa fa-plug"></span><span class="mtext">History Beli</span>
								</a>
								<ul class="submenu child">
									<li><a href="<?= base_url() ?>Pembelian/TransBeli/">Riwayat Transaksi Beli</a></li>
									<li><a href="<?= base_url() ?>Pembelian/TransBeli/viewDet">Riwayat Transaksi Beli Detail</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="javascript:;" class="dropdown-toggle">
									<span class="micon fa fa-plug"></span><span class="mtext">Transaksi</span>
								</a>
								<ul class="submenu child">
									<!-- <li><a href="#">Riwayat Transaksi Jual</a></li> -->
									<li><a href="<?= base_url() ?>Pembelian/TransPO"> Purchase Order Analisa </a></li>
									<li><a href="<?= base_url() ?>Pembelian/TransPo/Add"> Entry PO </li></a></li>
									<li><a href="<?= base_url() ?>Pembelian/"> Penjualan </li></a></li>
									<li><a href="<?= base_url() ?>Pembelian/"> Pembelian </li></a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="javascript:;" class="dropdown-toggle">
									<span class="micon fa fa-plug"></span><span class="mtext">History Jual </span>
								</a>
								<ul class="submenu child">
									<li><a href="<?= base_url() ?>Penjualan/TransJual/">Riwayat Transaksi Jual</a></li>
									<li><a href="<?= base_url() ?>Penjualan/TransJual/viewDet">Riwayat Transaksi Jual Detail</a></li>
								</ul>
							</li>
							<!-- <li><a href="javascript:;">Level 1</a></li>
							<li><a href="javascript:;">Level 1</a></li>
							<li><a href="javascript:;">Level 1</a></li> -->
						
				
					<!-- <li>
						<a href="sitemap.html" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-diagram"></span><span class="mtext">Sitemap</span>
						</a>
					</li>
					<li>
						<a href="chat.html" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-chat3"></span><span class="mtext">Chat</span>
						</a>
					</li>
					<li>
						<a href="invoice.html" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-invoice"></span><span class="mtext">Invoice</span>
						</a>
					</li> -->
					<li>
						<div class="dropdown-divider"></div>
					</li>
					<!-- <li>
						<div class="sidebar-small-cap">Extra</div>
					</li>
					<li>
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-settings"></span><span class="mtext">Setting</span>
						</a>
						<ul class="submenu">
							<li><a href="<?= base_url() ?>uploadImport/">Import</a></li>
							<!-- <li><a href="getting-started.html">Getting Started</a></li>
							<li><a href="color-settings.html">Color Settings</a></li>
							<li><a href="third-party-plugins.html">Third Party Plugins</a></li> -->
						</ul>
					</li>

				</ul>
			</div>
		</div>
	</div>
	<div class="mobile-menu-overlay"></div>

	<div class="main-container">

		<div class="pd-ltr-20 xs-pd-20-10">
			<!-- <div class="alert alert-primary" role="alert">
				TOLONG segera laporkan jika terdapat bug, Terima Kasih ! <i class="fa fa-exclamation"></i>
			</div> -->
			<div class="min-height-200px">
				<div class="page-header">

					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">


								<!-- Default Basic Forms Start -->

								<!-- Input Validation End -->
								<script>
									function conflogout(url) {

										Swal.fire({
											title: 'LOG OUT',
											text: "Apakah anda yakin ingin logout? semua perubahan akan disimpan",
											icon: 'info',
											showCancelButton: true,
											background: '#fff',
											confirmButtonColor: '#3085d6',
											cancelButtonColor: '#d33',
											confirmButtonText: 'Iya',
										}).then((result) => {

											if (result.isConfirmed) {
												Swal.fire({
													title: 'Bye',
													text: "Anda berhasil logout",
													icon: 'success',
													showCancelButton: false,
													confirmButtonColor: '#3085d6',
													cancelButtonColor: '#d33',
													confirmButtonText: 'Ok!'

												}).then(function() {
													window.location.href = '<?php echo base_url() ?>auth/logout';
												});
											}
										})
									}
								</script>