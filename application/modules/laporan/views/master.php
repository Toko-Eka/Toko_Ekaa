
<section>

<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Transaksi Penjualan</h1>
          </div>
         
              <div class="col-12 mb-4">
              <div class="card bg-defaullt">
                <div class="card-header">

                </div>
<div class="card-body">
            <div class="container">
                <div class="mb-2">
                <div class="row"><div class="col-md-3">   <label>Scan Barcode</label><span>*</span>
                                <div class="input-group mb-3">

                                    <input class="form-control " type="text" placeholder="Scan Barcode" name="nama_customer" aria-label="default input example" required>
                                    <div class="input-group-append">
   <button class="btn btn-primary ">Cari</button>
  </div>
                                </div></div>
                                <div class="col-md-3"> 
                                <div class="input-group mb-3">
                       
                                <label>Nota</label><span>*</span>
                                <div class="input-group mb-3">
                                <input class="form-control " type="text" placeholder="Nota" name="nama_customer" aria-label="default input example" required>
                                </div>
                                </div>
                                </div>
                                <div class="col-md-3"> 
                                <div class="input-group mb-3">
                       
                                <label>Keterangan </label><span>*</span>
                                <div class="input-group mb-3">
                                <input class="form-control " type="text" placeholder="Keterangan" name="nama_customer" aria-label="default input example" required>
                                </div>
                                </div>
                                </div>
                                <div class="col-md-3"> 
                                <div class="input-group mb-3">
                       
                                <label>Petugas </label><span>*</span>
                                <div class="input-group mb-3">
                                <input class="form-control " type="text" placeholder="Petugas" name="nama_customer" aria-label="default input example" required>
                                </div>
                                </div>
                                </div>
                </div>
                    <form action="transaksi_in.php" method="post">
                        <table id="trform" class='table table-striped' style='border-collapse: collapse;'>
                            <thead>
                                <tr>
                                  
                                    <th>Nama Barang</th>
                                    <th>Kode</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                              
                               
                                <tr class='tr_input'>
<!--                    
                                    <td><input type='text' class='form-control obat ' id='obat_1' placeholder='Masukkan Nama Obat...'></td>
                                    <td><input name="id_obat[]" type='text' class='form-control nama ' id='id_1'></td>
                                    <td><input readonly type='text' class='form-control  ' id='kd_1'></td>

                                    <td><input readonly type='text' class='form-control  harga ' id='harga_1'></td>
                                    <td><input type='text' name="jumlah[]" value='' class='txtCal form-control jumlah' id='jumlah_1'></td>

                                    <td><input readonly type='number' name="subtotal[]" class='txtCal form-control total inst_amount' id="total_1"></td>
                                    <td> <input type='button' class='btn btn-sm btn-success' value='Add more' id='addmore'></td> -->
                                </tr>




                            </tbody>
                        </table>
                      
                            <button type="submit" name="save_multiple_data" class="btn btn-primary" name="submit" value="save">Save</button>
                    </form>
                    <br>

                </div>
            </div>
            </div>
              </div>
              </div>






</section>

