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
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Add New Data Barang</h4>
                </div>
                <div class="col-md-4 comp-grid">
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
                        $sql = mysqli_query($koneksi,"select * from data_barang_temp where idtrace='$idtrace'");
                        while ($row=mysqli_fetch_array($sql)){
                        $nama_barang=$row['nama_barang'];
                        $category_barang=$row['category_barang'];
                        $satuan=$row['satuan'];
                        $harga=$row['harga'];
                        $hargajual=$harga * 20 / 100;
                        $jual=$hargajual + $harga;
                        $queryc = mysqli_query($koneksi, "SELECT * from category_barang where id='$category_barang'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsc = mysqli_num_rows($queryc);
                        if ($rowsc <> 0) {
                        $datac        = mysqli_fetch_assoc($queryc);
                        $category=$datac['category'];
                        $categ  = substr($category, 0, 2);
                        }
                        $categ=strtoupper("$categ");
                        $query = mysqli_query($koneksi, "SELECT * from data_barang where nama_barang='$nama_barang'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows = mysqli_num_rows($query);
                        if ($rows <> 0) {
                        $data        = mysqli_fetch_assoc($query);
                        }else{
                        mysqli_query($koneksi,"INSERT INTO `data_barang` (`operator`,`nama_barang`,`satuan`,`category_barang`) VALUES ('$id_user','$nama_barang','$satuan','$category_barang')"); 
                        $queryd = mysqli_query($koneksi, "SELECT * from data_barang where nama_barang='$nama_barang'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsd = mysqli_num_rows($queryd);
                        if ($rowsd <> 0) {
                        $datad        = mysqli_fetch_assoc($queryd);
                        $id_barang=$datad['id_barang'];
                        } 
                        $kode="DT$categ$id_barang";
                        mysqli_query($koneksi, "UPDATE data_barang SET kode_barang='$kode' WHERE id_barang='$id_barang'"); 
                        mysqli_query($koneksi,"INSERT INTO `setok_barang` (`id_data`,`harga_beli`,`harga_jual`,`kode_barang`,`operator`,`nama_barang`,`satuan`,`category_barang`) VALUES ('$id_barang','$harga','$jual','$kode','$id_user','$nama_barang','$satuan','$category_barang')"); 
                        }
                        }
                        $querydel=mysqli_query($koneksi, "DELETE FROM data_barang_temp WHERE idtrace='$idtrace'");
                        if ($querydel) {
                        ?>
                        <script language="JavaScript">
                            alert('Impor Data Barang Berhasil!');
                            document.location='<?php print_link("data_barang"); ?>';
                        </script>
                        <?php
                        }
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses!!!');
                            document.location='<?php print_link("data_barang"); ?>';
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
                    <form id="data_barang-proses-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_barang/proses?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <input id="ctrl-nama_barang"  value="<?php  echo $this->set_field_value('nama_barang',""); ?>" type="text" placeholder="Enter Nama Barang"  required="" name="nama_barang"  class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="warning_setok">Warning Setok <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-warning_setok"  value="<?php  echo $this->set_field_value('warning_setok',"3"); ?>" type="number" placeholder="Enter Warning Setok" step="1"  required="" name="warning_setok"  class="form-control " />
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
