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
                    <h4 class="record-title"><?php
                        if(!empty($_GET['pasien'])){
                        $pasien=$_GET['pasien'];
                        }else{
                        $pasien="";
                        }
                        echo "Add New Hasil Lab Luar $pasien";
                        ?>
                    </h4>
                    <div class=""><div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        if(!empty($_GET['datrecord'])){
                        $original_plaintext=$_GET['datrecord'];
                        if($pasien=="POLI"){   
                        $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }
                        if($pasien=="IGD"){        
                        $queryb = mysqli_query($koneksi, "select * from igd WHERE id_igd='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));                               
                        }    
                        if($pasien=="RAWAT INAP"){        
                        $queryb = mysqli_query($koneksi, "select * from rawat_inap WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));                               
                        }  
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        //////////////////////////
                        // $tinggi=$row['tinggi'];
                        //$berat_badan=$row['berat_badan'];
                        // $tensi=$row['tensi'];
                        //dokter_pengirim
                        // $keluhan=$row['keluhan'];
                        if($pasien=="IGD"){ 
                        $keluhan="";
                        $id_daftar=$row['id_igd'];
                        $dokter=$row['dokter'];
                        }else if($pasien=="RAWAT INAP"){
                        $keluhan="";
                        $id_daftar=$row['id'];
                        $dokter=$row['dokter_rawat_inap'];
                        }else if($pasien=="POLI"){ 
                        $nama_poli=$row['nama_poli'];
                        $id_daftar=$row['id_pendaftaran_poli'];
                        $keluhan=$row['keluhan'];
                        $dokter=$row['dokter'];
                        }else{
                        $dokter=$row['dokter'];
                        }
                        $querybc = mysqli_query($koneksi, "select * from pemeriksaan_fisik WHERE id_daftar='$original_plaintext' and no_rekam_medis='$no_rekam_medis'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                        $rowsbc = mysqli_num_rows($querybc);
                        if ($rowsbc <> 0) {
                        $rowc   = mysqli_fetch_assoc($querybc); 
                        $keluhan=$rowc['keluhan'];
                        }
                        ///////////////////
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }
                        if($pasien=="POLI"){ 
                        $sqlp = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$nama_poli'");
                        while ($rowp=mysqli_fetch_array($sqlp)){
                        $nama_poli=$rowp['nama_poli'];
                        }
                        }else{
                        $nama_poli=$pasien; 
                        }
                        $sqld = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter'");
                        while ($rowd=mysqli_fetch_array($sqld)){
                        $dokter=$rowd['nama_dokter'];
                        }
                        }else{
                        $no_rekam_medis="";
                        $nama_pasien="";
                        $alamat="";
                        $no_hp="";
                        $tanggal_lahir="";
                        $jenis_kelamin="";
                        $email="";
                        $umur="";
                        $tinggi="";
                        $berat_badan="";
                        $tensi="";
                        $dokter="";
                        $nama_poli="";
                        $keluhan="";
                        $id_daftar="";
                        }
                        if($pasien=="POLI"){
                        $bagian=$nama_poli;
                        }else{
                        $bagian=""; 
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
                    <form id="hasil_lab_luar-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("hasil_lab_luar/add?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <input id="ctrl-id_daftar"  value="<?php echo $id_daftar;?>" type="hidden" placeholder="Enter Id Daftar"  required="" name="id_daftar"  class="form-control " />
                                <input id="ctrl-pasien"  value="<?php echo $pasien;?>" type="hidden" placeholder="Enter Pasien"  required="" name="pasien"  class="form-control " />
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="nama_pasien">Nama Pasien <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-nama_pasien"  value="<?php echo $nama_pasien;?>" type="text" placeholder="Enter Nama Pasien"  readonly required="" name="nama_pasien"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="no_rekam_medis">No Rekam Medis <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="text" placeholder="Enter No Rekam Medis"  readonly required="" name="no_rekam_medis"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="hasil_lab">Hasil Lab <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <div class="dropzone required" input="#ctrl-hasil_lab" fieldname="hasil_lab"    data-multiple="false" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="15" maximum="1">
                                                                <input name="hasil_lab" id="ctrl-hasil_lab" required="" class="dropzone-input form-control" value="<?php  echo $this->set_field_value('hasil_lab',""); ?>" type="text"  />
                                                                    <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                    <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                                </div>
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
