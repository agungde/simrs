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
                </div>
                <div class="col-md-4 comp-grid">
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
                        if ($Key < 1) continue;     
                        //  $harga=trim($Row[2]);
                        //  $hargab=trim($harga);
                        // $hargab=str_replace(',','',$hargab);
                        // $hargalen=strlen($hargab);
                        //$cekharga  = substr($hargab, 2, $hargalen);
                        //  $hargajual=$harga * 20 / 100;
                        //  $jual=$hargajual + $harga;
                        $satuan=strtoupper($Row[6]);
                        $query=mysqli_query($koneksi,"INSERT INTO `data_obat_temp` (`penggunaan`,`nama_obat`,`pbf`,`hna`,`hja`,`tipe`,`satuan`,`operator`,`idtrace`) VALUES ('".$Row[0]."','".$Row[1]."','".$Row[2]."','".$Row[3]."','".$Row[4]."','".$Row[5]."','$satuan','$id_user','$idtrace')");    
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
                            document.location='<?php print_link("data_obat_temp"); ?>';
                        </script>
                        <?php
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
                    <form id="data_obat-impor-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_obat/impor?csrf_token=$csrf_token") ?>" method="post">
                        <div>
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
