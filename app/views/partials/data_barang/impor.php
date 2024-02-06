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
                <div class="col-md-6 comp-grid">
                    <div class=""><div>
                        <?php
                        if(isset($_POST['category'])){
                        set_time_limit (0);
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        $rootfile="".ROOT_DIR_NAME;      
                        $fileid=$id_user;
                        $category=$_POST['category'];      
                        require('reader/SpreadsheetReader.php');
                        // menghubungkan dengan library excel reader
                        include "reader/php-excel-reader/excel_reader2.php";    
                        // upload file xls
                        $target = basename($_FILES['impordata']['name']) ;
                        $idpicfile="$fileid$target";
                        move_uploaded_file($_FILES['impordata']['tmp_name'], $idpicfile);
                        $filename = $_FILES['impordata']['name'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        //echo $ext;
                        // beri permisi agar file xls dapat di baca
                        chmod($idpicfile,0777);
                        // mengambil isi file xls
                        $Reader = new SpreadsheetReader($idpicfile,false);
                        foreach ($Reader as $Key => $Row)
                        {
                        // import data excel mulai baris ke-2 (karena ada header pada baris 1)
                        if ($Key < 2) continue;     
                        $harga=trim($Row[2]);
                        $hargab=trim($harga);
                        $hargab=str_replace(',','',$hargab);
                        $hargalen=strlen($hargab);
                        $cekharga  = substr($hargab, 2, $hargalen);
                        //  $hargajual=$harga * 20 / 100;
                        //  $jual=$hargajual + $harga;
                        $query=mysqli_query($koneksi,"INSERT INTO `data_barang_temp` (`harga`,`operator`,`idtrace`,`nama_barang`,`satuan`,`harga_beli`,`category_barang`) VALUES ('$cekharga','$id_user','$idtrace','".$Row[0]."','".$Row[1]."','$harga','$category')");    
                        }   
                        if ($query) {
                        ?>
                        <script language="JavaScript">
                            alert('Upload data File >>  <?php echo $target;?> berhasil!');
                        </script>
                        <?php
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Upload data File >>  <?php echo $target;?> Gagal!');
                        </script>
                        <?php
                        }
                        // hapus kembali file .xls yang di upload tadi
                        unlink($idpicfile);
                        ?>
                        <script language="JavaScript">
                            document.location='<?php print_link("data_barang_temp"); ?>';
                        </script>
                        <?php
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
                    <form id="data_barang-impor-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_barang/impor?csrf_token=$csrf_token") ?>" method="post">
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
