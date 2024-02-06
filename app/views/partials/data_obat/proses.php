<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Add New Data Obat</h4>
                    <div class=""><div>
                        <?php
                        if(isset($_POST['idtrace'])){
                        set_time_limit (0);
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        $sql = mysqli_query($koneksi,"select * from data_obat_temp where idtrace='$idtrace'");
                        while ($row=mysqli_fetch_array($sql)){
                        $nama_obat=$row['nama_obat'];
                        $penggunaan=$row['penggunaan'];
                        $pbf=$row['pbf'];
                        $hna=$row['hna'];
                        $hja=$row['hja'];
                        $tipe=$row['tipe'];
                        $satuan=$row['satuan'];
                        $query = mysqli_query($koneksi, "SELECT * from data_obat where nama_obat='$nama_obat' and tipe='$tipe'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows = mysqli_num_rows($query);
                        if ($rows <> 0) {
                        $data        = mysqli_fetch_assoc($query);
                        }else{
                        mysqli_query($koneksi,"INSERT INTO `data_obat`(`penggunaan`, `nama_obat`, `pbf`, `hna`, `hja`, `tipe`, `operator`) VALUES ('$penggunaan','$nama_obat','$pbf','$hna','$hja','$tipe','$id_user')"); 
                        $queryd = mysqli_query($koneksi, "SELECT * from data_obat where nama_obat='$nama_obat' and tipe='$tipe'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsd = mysqli_num_rows($queryd);
                        if ($rowsd <> 0) {
                        $datad        = mysqli_fetch_assoc($queryd);
                        $idob=$datad['id'];
                        } 
                        $kode="DTOB$idob";
                        mysqli_query($koneksi, "UPDATE data_obat SET kode_obat='$kode' WHERE id='$idob'");  
                        }
                        /////////////////////////////////
                        $query = mysqli_query($koneksi, "SELECT * from data_barang where nama_barang='$nama_obat'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows = mysqli_num_rows($query);
                        if ($rows <> 0) {
                        $data        = mysqli_fetch_assoc($query);
                        }else{
                        mysqli_query($koneksi,"INSERT INTO `data_barang` (`operator`,`nama_barang`,`satuan`,`category_barang`) VALUES ('$id_user','$nama_obat','$satuan','1')"); 
                        $queryd = mysqli_query($koneksi, "SELECT * from data_barang where nama_barang='$nama_obat'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsd = mysqli_num_rows($queryd);
                        if ($rowsd <> 0) {
                        $datad        = mysqli_fetch_assoc($queryd);
                        $id_barang=$datad['id_barang'];
                        } 
                        $kode="DTOB$id_barang";
                        mysqli_query($koneksi, "UPDATE data_barang SET kode_barang='$kode' WHERE id_barang='$id_barang'"); 
                        mysqli_query($koneksi,"INSERT INTO `setok_barang` (`id_data`,`harga_beli`,`harga_jual`,`kode_barang`,`operator`,`nama_barang`,`satuan`,`category_barang`) VALUES ('$id_barang','$hna','$hja','$kode','$id_user','$nama_obat','$satuan','1')"); 
                        }
                        //////////////////////////////////////////
                        }
                        $querydel=mysqli_query($koneksi, "DELETE FROM data_obat_temp WHERE idtrace='$idtrace'");
                        if ($querydel) {
                        ?>
                        <script language="JavaScript">
                            alert('Impor Data Barang Berhasil!');
                            document.location='<?php print_link("data_obat"); ?>';
                        </script>
                        <?php
                        }
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses!!!');
                            document.location='<?php print_link("data_obat"); ?>';
                        </script>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<div  class="">
    <div class="container">
        <div class="row ">
            <div class="col-md-7 comp-grid">
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form id="data_obat-proses-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_obat/proses?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="kode_obat">Kode Obat <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <input id="ctrl-kode_obat"  value="<?php  echo $this->set_field_value('kode_obat',""); ?>" type="text" placeholder="Enter Kode Obat"  required="" name="kode_obat"  class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="penggunaan">Penggunaan <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-penggunaan"  value="<?php  echo $this->set_field_value('penggunaan',""); ?>" type="text" placeholder="Enter Penggunaan"  required="" name="penggunaan"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="nama_obat">Nama Obat <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-nama_obat"  value="<?php  echo $this->set_field_value('nama_obat',""); ?>" type="text" placeholder="Enter Nama Obat"  required="" name="nama_obat"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="pbf">Pbf <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-pbf"  value="<?php  echo $this->set_field_value('pbf',""); ?>" type="text" placeholder="Enter Pbf"  required="" name="pbf"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="hna">Hna <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-hna"  value="<?php  echo $this->set_field_value('hna',""); ?>" type="number" placeholder="Enter Hna" step="1"  required="" name="hna"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="hja">Hja <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-hja"  value="<?php  echo $this->set_field_value('hja',""); ?>" type="number" placeholder="Enter Hja" step="1"  required="" name="hja"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="tipe">Tipe <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-tipe"  value="<?php  echo $this->set_field_value('tipe',""); ?>" type="text" placeholder="Enter Tipe"  required="" name="tipe"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="operator">Operator <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-operator"  value="<?php  echo $this->set_field_value('operator',""); ?>" type="number" placeholder="Enter Operator" step="1"  required="" name="operator"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="tanggal_dibuat">Tanggal Dibuat <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="input-group">
                                                                            <input id="ctrl-tanggal_dibuat" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('tanggal_dibuat',""); ?>" type="datetime"  name="tanggal_dibuat" placeholder="Enter Tanggal Dibuat" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="tanggal_diperbarui">Tanggal Diperbarui <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="input-group">
                                                                                <input id="ctrl-tanggal_diperbarui" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('tanggal_diperbarui',""); ?>" type="datetime"  name="tanggal_diperbarui" placeholder="Enter Tanggal Diperbarui" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="satuan">Satuan <span class="text-danger">*</span></label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-satuan"  value="<?php  echo $this->set_field_value('satuan',""); ?>" type="text" placeholder="Enter Satuan"  required="" name="satuan"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group form-submit-btn-holder text-center mt-3">
                                                                        <div class="form-ajax-status"></div>
                                                                        <button class="btn btn-primary" type="submit">
                                                                            Submit
                                                                            <i class="fa fa-send"></i>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
