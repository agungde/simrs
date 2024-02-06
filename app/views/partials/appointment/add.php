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
                    <div class=""><div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        //$koneksi=open_connection();
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
                        if(!empty($_GET['precord'])){
                        $ciphertext = $_GET['precord'];
                        $ciphertext=str_replace(' ', '+', $ciphertext);
                        $resep=$ciphertext;
                        $key="dermawangroup";
                        $c = base64_decode($ciphertext);
                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                        $iv = substr($c, 0, $ivlen);
                        $hmac = substr($c, $ivlen, $sha2len=32);
                        $ciphertext_raw = substr($c, $ivlen+$sha2len);
                        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                        if (hash_equals($hmac, $calcmac))// timing attack safe comparison
                        {
                        // echo $original_plaintext."\n";
                        }
                        if(!empty($_GET['pasien'])){
                        $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }else{
                        $queryb = mysqli_query($koneksi, "select * from data_pasien WHERE id_pasien='$original_plaintext'")
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
                        $no_ktp=$row['no_ktp'];
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }
                        }else{
                        if(isset($_POST['kontrol'])){
                        $idpass=$_POST['idpass'];
                        $iddt=$_POST['iddt'];
                        $backlink=$_POST['backlink'];
                        $tglk=$_POST['tanggal_appointment'];
                        $poli=$_POST['nama_poli'];
                        $dokter=$_POST['dokter'];
                        $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$idpass'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
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
                        $tl=$row['tl'];
                        $no_ktp=$row['no_ktp'];
                        }         
                        mysqli_query($koneksi, "INSERT INTO `appointment`(  `nama_poli`, `dokter`, `tl`, `nama_pasien`, `no_rekam_medis`, `no_hp`, `alamat`, `jenis_kelamin`, `tanggal_lahir`, `email`, `no_ktp`, `tanggal_appointment`, `id_daftar`) VALUES ('$poli','$dokter','$tl','$nama_pasien','$no_rekam_medis','$no_hp','$alamat','$jenis_kelamin','$tanggal_lahir','$email','$no_ktp','$tglk','$idpass')");
                        $queryc = mysqli_query($koneksi, "select * from appointment WHERE id_daftar='$idpass' and no_rekam_medis='$no_rekam_medis' ORDER BY id_appointment DESC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                        $rowsc = mysqli_num_rows($queryc);
                        if ($rowsc <> 0) {
                        $rowc   = mysqli_fetch_assoc($queryc); 
                        $idapp=$rowc['id_appointment'];
                        mysqli_query($koneksi, "UPDATE data_rekam_medis SET idapp='$idapp' WHERE id='$iddt'");
                        }
                        ?>
                        <script language="JavaScript">
                            alert('Jadwal Kontrol Berhasil Di Simpan');
                            document.location='<?php print_link("Pendaftaran_poli/dokter?precord=$backlink&datrm=$no_rekam_medis"); ?>';
                        </script>
                        <?php          
                        }
                        ////////////////////////////////////////////////////////////////////   
                        if(isset($_POST['rujukpoli'])){
                        $idpass=$_POST['idpass'];
                        $iddt=$_POST['iddt'];
                        $backlink=$_POST['backlink'];
                        $tglk=$_POST['tanggal'];
                        $poli=$_POST['nama_poli'];
                        $dokter=$_POST['dokter'];
                        $keterangan_rujukan=$_POST['keterangan_rujukan'];
                        $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$idpass'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
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
                        $tl=$row['tl'];
                        $nohp=$row['no_hp'];
                        $keluhan=$row['keluhan'];
                        $no_ktp=$row['no_ktp'];
                        $bayar=$row['pembayaran'];
                        $setbpjs=$row['setatus_bpjs'];
                        }  
                        if($tglk==$sekarang){
                        mysqli_query($koneksi, "INSERT INTO `pendaftaran_poli`(`pembayaran`,`setatus_bpjs`, `nama_poli`, `keluhan`,  `dokter`, `tl`, `nama_pasien`, `no_rekam_medis`, `no_ktp`, `no_hp`, `alamat`, `jenis_kelamin`, `tanggal_lahir`, `umur`,`tanggal`, `email`) VALUES ('$bayar','$setbpjs','$poli','$keluhan','$dokter','$tl','$nama_pasien','$no_rekam_medis','$no_ktp','$nohp','$alamat','$jenis_kelamin','$tanggal_lahir','$umur','$tglk','$email')");
                        $queryc = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE tanggal='$tglk' and no_rekam_medis='$no_rekam_medis' ORDER BY id_pendaftaran_poli DESC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                        $rowsc = mysqli_num_rows($queryc);
                        if ($rowsc <> 0) {
                        $rowc   = mysqli_fetch_assoc($queryc); 
                        $idapp=$rowc['id_pendaftaran_poli'];
                        mysqli_query($koneksi, "UPDATE data_rekam_medis SET idapp='$idapp', keterangan_rujukan='$keterangan_rujukan' WHERE id='$iddt'");
                        }
                        }else{
                        mysqli_query($koneksi, "INSERT INTO `appointment`(  `nama_poli`, `dokter`, `tl`, `nama_pasien`, `no_rekam_medis`, `no_hp`, `alamat`, `jenis_kelamin`, `tanggal_lahir`, `email`, `no_ktp`, `tanggal_appointment`, `id_daftar`) VALUES ('$poli','$dokter','$tl','$nama_pasien','$no_rekam_medis','$no_hp','$alamat','$jenis_kelamin','$tanggal_lahir','$email','$no_ktp','$tglk','$idpass')");
                        $queryc = mysqli_query($koneksi, "select * from appointment WHERE id_daftar='$idpass' and no_rekam_medis='$no_rekam_medis' ORDER BY id_appointment DESC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                        $rowsc = mysqli_num_rows($queryc);
                        if ($rowsc <> 0) {
                        $rowc   = mysqli_fetch_assoc($queryc); 
                        $idapp=$rowc['id_appointment'];
                        mysqli_query($koneksi, "UPDATE data_rekam_medis SET idapp='$idapp', keterangan_rujukan='$keterangan_rujukan' WHERE id='$iddt'");
                        }
                        }
                        /*
                        INSERT INTO `igd`(`id_igd`, `id_transaksi`, `tanggal_masuk`, `no_rekam_medis`, `tl`, `no_ktp`, `nama_pasien`, `alamat`, `tanggal_lahir`, `jenis_kelamin`, `umur`, `no_hp`, `email`, `pembayaran`, `penanggung_jawab`, `id_penanggung_jawab`, `alamat_penanggung_jawab`, `no_hp_penanggung_jawab`, `hubungan`, `rawat_inap`, `setatus_bpjs`, `back_link`, `action`, `setatus`, `dokter`, `tindakan`, `operator`, `date_created`, `date_updated`, `pasien`, `tanggal_keluar`, `resep_obat`, `lab`, `catatan_medis`, `assesment_triase`, `assesment_medis`, `pemeriksaan_fisik`, `rekam_medis`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]','[value-12]','[value-13]','[value-14]','[value-15]','[value-16]','[value-17]','[value-18]','[value-19]','[value-20]','[value-21]','[value-22]','[value-23]','[value-24]','[value-25]','[value-26]','[value-27]','[value-28]','[value-29]','[value-30]','[value-31]','[value-32]','[value-33]','[value-34]','[value-35]','[value-36]','[value-37]','[value-38]')
                        */
                        ?>
                        <script language="JavaScript">
                            alert('Proses Rujuk Pasien Ke Poli Lain Berhasil');
                            document.location='<?php print_link("pendaftaran_poli/dokter?precord=$backlink"); ?>';
                        </script>
                        <?php     
                        }
                        //////////////////////////////////////////////////////////
                        if(isset($_POST['rujukigd'])){
                        $idpass=$_POST['idpass'];
                        $iddt=$_POST['iddt'];
                        $backlink=$_POST['backlink'];
                        $tglk=$_POST['tanggal'];
                        $poli=$_POST['nama_poli'];
                        $dokter=$_POST['dokter'];
                        $keterangan_rujukan=$_POST['keterangan_rujukan'];
                        $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$idpass'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
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
                        $tl=$row['tl'];
                        $nohp=$row['no_hp'];
                        $keluhan=$row['keluhan'];
                        $no_ktp=$row['no_ktp'];
                        $bayar=$row['pembayaran'];
                        $setbpjs=$row['setatus_bpjs'];
                        }         
                        mysqli_query($koneksi, "INSERT INTO `igd`(`pembayaran`,`setatus_bpjs`, `tl`, `nama_pasien`, `no_rekam_medis`, `no_ktp`, `no_hp`, `alamat`, `jenis_kelamin`, `tanggal_lahir`, `umur`,`tanggal_masuk`, `email`) VALUES ('$bayar','$setbpjs','$tl','$nama_pasien','$no_rekam_medis','$no_ktp','$nohp','$alamat','$jenis_kelamin','$tanggal_lahir','$umur','$tglk','$email')");
                        $queryc = mysqli_query($koneksi, "select * from igd WHERE DATE(igd.tanggal_masuk)='$tglk' and no_rekam_medis='$no_rekam_medis' ORDER BY id_igd DESC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                        $rowsc = mysqli_num_rows($queryc);
                        if ($rowsc <> 0) {
                        $rowc   = mysqli_fetch_assoc($queryc); 
                        $idapp=$rowc['id_igd'];
                        mysqli_query($koneksi, "UPDATE data_rekam_medis SET idapp='$idapp', keterangan_rujukan='$keterangan_rujukan' WHERE id='$iddt'");
                        }
                        ?>
                        <script language="JavaScript">
                            alert('Proses Rujuk Pasien Ke IGD Berhasil');
                            document.location='<?php print_link("pendaftaran_poli/dokter?precord=$backlink"); ?>';
                        </script>
                        <?php  
                        }
                        if(isset($_POST['closed'])){
                        $datid=$_POST['datid'];
                        $backlink=$_POST['backlink'];
                        $norm=$_POST['norm'];
                        mysqli_query($koneksi, "UPDATE pendaftaran_poli SET setatus='Closed' WHERE id_pendaftaran_poli='$datid'");
                        mysqli_query($koneksi,"UPDATE data_rm SET setatus='Closed' WHERE id_daftar='$datid' and no_rekam_medis='$norm'");
                        ?>
                        <script language="JavaScript">
                            alert('Proses Closed Berhasil');
                            document.location='<?php print_link("pendaftaran_poli/dokter?precord=$backlink"); ?>';
                        </script>
                        <?php      
                        }
                        /////////////////////////////////////////////////////////////////////////    
                        if(!empty($_GET['csrf_token'])){
                        $getcekcrf=$_GET['csrf_token'];
                        $cekcrf=$csrf_token;
                        if($getcekcrf==$cekcrf){
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses Add Langsung');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php 
                        }
                        }
                        $no_rekam_medis="";
                        $nama_pasien="";
                        $alamat="";
                        $no_hp="";
                        $tanggal_lahir="";
                        $email="";
                        $jenis_kelamin="";
                        $umur="";
                        $no_ktp="";
                        }
                        if($no_ktp==0){
                        $no_ktp="";
                        }
                        ?>
                    </div>
                    <script>
                        $(document).ready(function() {
                        <?php if($jenis_kelamin==""){}else{
                        if($jenis_kelamin=="Laki-Laki"){
                        $indexval="1";
                        }else{
                        $indexval="2";
                        }
                        ?>
                        document.getElementById("ctrl-jenis_kelamin").selectedIndex = "<?php echo $indexval;?>";
                        <?php }?>
                        <?php if($tl==""){}else{
                        if($tl=="TN"){
                        $indexvalt="1";
                        }else if($tl=="NY"){
                        $indexvalt="2";
                        }else if($tl=="AN"){
                        $indexvalt="3";
                        }else if($tl=="BY"){
                        $indexvalt="4";
                        }
                        ?>
                        document.getElementById("ctrl-tl").selectedIndex = "<?php echo $indexvalt;?>";
                        <?php }?>   
                        });
                    </script></div><h4 class="record-title">Add New Appointment</h4>
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
                        <form id="appointment-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("appointment/add?csrf_token=$csrf_token") ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="tanggal_appointment">Tanggal Appointment <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input id="ctrl-tanggal_appointment" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal_appointment',""); ?>" type="datetime" name="tanggal_appointment" placeholder="Enter Tanggal Appointment" data-enable-time="false" data-min-date="<?php echo date('Y-m-d', strtotime('+1day')); ?>" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
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
                                                <label class="control-label" for="no_rekam_medis">No Rekam Medis <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="text" placeholder="Input No Rekam Medis"  readonly required="" name="no_rekam_medis"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="tl">Tl </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <select  id="ctrl-tl" name="tl"  placeholder="Select a value ..."    class="custom-select" >
                                                            <option value="">Select a value ...</option>
                                                            <?php
                                                            $tl_options = Menu :: $tl;
                                                            if(!empty($tl_options)){
                                                            foreach($tl_options as $option){
                                                            $value = $option['value'];
                                                            $label = $option['label'];
                                                            $selected = $this->set_field_selected('tl', $value, "");
                                                            ?>
                                                            <option <?php echo $selected ?> value="<?php echo $value ?>">
                                                                <?php echo $label ?>
                                                            </option>                                   
                                                            <?php
                                                            }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="nama_pasien">Nama Pasien <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-nama_pasien"  value="<?php echo $nama_pasien;?>" type="text" placeholder="Input Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="no_ktp">No Ktp <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-no_ktp"  value="<?php echo $no_ktp;?>" type="text" placeholder="Enter No Ktp"  required="" name="no_ktp"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="alamat">Alamat <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <textarea placeholder="Input Alamat" id="ctrl-alamat"  required="" rows="5" name="alamat" class=" form-control"><?php echo $alamat;?></textarea>
                                                                <!--<div class="invalid-feedback animated bounceIn text-center">Please enter text</div>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="keluhan">Keluhan <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-keluhan"  value="<?php  echo $this->set_field_value('keluhan',""); ?>" type="text" placeholder="Enter Keluhan"  required="" name="keluhan"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="nama_poli">Nama Poli <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <select required=""  id="ctrl-nama_poli" data-load-select-options="dokter" name="nama_poli"  placeholder="Select a value ..."    class="custom-select" >
                                                                        <option value="">Select a value ...</option>
                                                                        <?php 
                                                                        $nama_poli_options = $comp_model -> appointment_nama_poli_option_list();
                                                                        if(!empty($nama_poli_options)){
                                                                        foreach($nama_poli_options as $option){
                                                                        $value = (!empty($option['value']) ? $option['value'] : null);
                                                                        $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                        $selected = $this->set_field_selected('nama_poli',$value, "");
                                                                        ?>
                                                                        <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                                            <?php echo $label; ?>
                                                                        </option>
                                                                        <?php
                                                                        }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="dokter">Dokter <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <select required=""  id="ctrl-dokter" data-load-path="<?php print_link('api/json/appointment_dokter_option_list') ?>" name="dokter"  placeholder="Select a value ..."    class="custom-select" >
                                                                        <option value="">Select a value ...</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="no_hp">No Hp </label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-no_hp"  value="<?php echo $no_hp;?>" type="text" placeholder="Input No Hp"  name="no_hp"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <select required=""  id="ctrl-jenis_kelamin" name="jenis_kelamin"  placeholder="Input Jenis Kelamin"    class="custom-select" >
                                                                            <option value="">Input Jenis Kelamin</option>
                                                                            <?php
                                                                            $jenis_kelamin_options = Menu :: $jenis_kelamin;
                                                                            if(!empty($jenis_kelamin_options)){
                                                                            foreach($jenis_kelamin_options as $option){
                                                                            $value = $option['value'];
                                                                            $label = $option['label'];
                                                                            $selected = $this->set_field_selected('jenis_kelamin', $value, "");
                                                                            ?>
                                                                            <option <?php echo $selected ?> value="<?php echo $value ?>">
                                                                                <?php echo $label ?>
                                                                            </option>                                   
                                                                            <?php
                                                                            }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="input-group">
                                                                        <input id="ctrl-tanggal_lahir"  value="<?php echo $tanggal_lahir;?>" type="text" placeholder="Input Tanggal Lahir"  required="" name="tanggal_lahir"  class="form-control " />
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
                                                                        <label class="control-label" for="email">Email </label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-email"  value="<?php echo $email;?>" type="email" placeholder="Enter Email"  name="email"  class="form-control " />
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
