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
                    <h4 class="record-title"><?php
                        if(!empty($_GET['pasien'])){
                        $pasien=$_GET['pasien'];
                        }else{
                        $pasien="";
                        }
                        echo "Add Pendaftaran Lab $pasien";
                    ?></h4>
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
                <div class="col-md-8 comp-grid">
                    <div class=""><div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        if(!empty($_GET['precord'])){
                        //$precord=$_GET['precord']; 
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
                        $id_daftar=$original_plaintext;
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
                        $id_transaksi=$row['id_transaksi'];
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
                        $namadokter=$dokter;
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
                        $id_transaksi="";
                        }
                        ?>
                    </div>
                </div>
                <div class=" ">
                    <?php  
                    $this->render_page("data_pasien/pasien/$_GET[datprecord]"); 
                    ?>
                </div>
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form id="pendaftaran_lab-add-form"  novalidate role="form" enctype="multipart/form-data" class="form multi-form page-form" action="<?php print_link("pendaftaran_lab/add?csrf_token=$csrf_token") ?>" method="post" >
                        <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  readonly required="" name="no_rekam_medis"  class="form-control " />
                            <input id="ctrl-nama_pasien"  value="<?php echo $nama_pasien;?>" type="hidden" placeholder="Enter Nama Pasien"  readonly required="" name="nama_pasien"  class="form-control " />
                                <input id="ctrl-alamat"  value="<?php echo $alamat;?>" type="hidden" placeholder="Enter Alamat"  readonly required="" name="alamat"  class="form-control " />
                                    <input id="ctrl-no_hp"  value="<?php echo $no_hp;?>" type="hidden" placeholder="Enter No Hp"  required="" name="no_hp"  class="form-control " />
                                        <input id="ctrl-nama_poli"  value="<?php echo $nama_poli;?>" type="hidden" placeholder="Select a value ..."  readonly name="nama_poli"  class="form-control " />
                                            <input id="ctrl-dokter_pengirim"  value="<?php echo $dokter;?>" type="hidden" placeholder="Enter Dokter Pengirim"  readonly required="" name="dokter_pengirim"  class="form-control " />
                                                <input id="ctrl-id_transaksi"  value="<?php echo $id_transaksi;?>" type="hidden" placeholder="Enter Dokter Pengirim"  readonly required="" name="id_transaksi"  class="form-control " />  
                                                    <input id="ctrl-id_daftar"  value="<?php echo $id_daftar;?>" type="hidden" placeholder="Enter Dokter Pengirim"  readonly required="" name="id_daftar"  class="form-control " />   
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="tanggal">Dokter Pengirim</label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="input-group">
                                                                        <?php echo $namadokter;?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="input-group">
                                                                        <input id="ctrl-tanggal" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal',date_now()); ?>" type="datetime" name="tanggal" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                            <div>
                                                                <table class="table table-striped table-sm" data-maxrow="10" data-minrow="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="bg-light"><label for="jenis_pemeriksaan" width="35%">Jenis Pemeriksaan</label></th>
                                                                            <th class="bg-light"><label for="nama_pemeriksaan">Nama Pemeriksaan</label></th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                        for( $row = 1; $row <= 1; $row++ ){
                                                                        ?>
                                                                        <tr class="input-row" >
                                                                            <td width="35%">
                                                                                <div id="ctrl-jenis_pemeriksaan-row<?php echo $row; ?>-holder" class="">
                                                                                    <select required=""  id="ctrl-jenis_pemeriksaan-row<?php echo $row; ?>" data-load-check-options="nama_pemeriksaan" name="jenis_pemeriksaan[]"  placeholder="Select a value ..."    class="custom-select" >
                                                                                        <option value="">Select a value ...</option>
                                                                                        <?php 
                                                                                        $jenis_pemeriksaan_options = $comp_model -> pendaftaran_lab_jenis_pemeriksaan_option_list();
                                                                                        if(!empty($jenis_pemeriksaan_options)){
                                                                                        foreach($jenis_pemeriksaan_options as $option){
                                                                                        $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                        $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                        $selected = $this->set_field_selected('jenis_pemeriksaan',$value, "");
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
                                                                            </td>
                                                                            <td>
                                                                                <div id="ctrl-nama_pemeriksaan-row<?php echo $row; ?>-holder" class="">
                                                                                    <template id="nama_pemeriksaan-option-template">
                                                                                        <label class="custom-control custom-checkbox custom-control-inline">
                                                                                            <input class="custom-control-input" id="ctrl-nama_pemeriksaan-row<?php echo $row; ?>" value="true" type="checkbox"  name="nama_pemeriksaan[]"  />
                                                                                                <span class="custom-control-label input-label-text"></span>
                                                                                            </label>
                                                                                        </template>
                                                                                        <div id="nama_pemeriksaan-options-holder" data-load-path="<?php print_link('api/json/pendaftaran_lab_nama_pemeriksaan_option_list') ?>">
                                                                                        </div> 
                                                                                    </div>
                                                                                </td>
                                                                                <th class="text-center">
                                                                                    <button type="button" class="close btn-remove-table-row">&times;</button>
                                                                                </th>
                                                                            </tr>
                                                                            <?php 
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <th colspan="100" class="text-right">
                                                                                    <?php $template_id = "table-row-" . random_str(); ?>
                                                                                    <button type="button" data-template="#<?php echo $template_id ?>" class="btn btn-sm btn-light btn-add-table-row"><i class="fa fa-plus"></i></button>
                                                                                </th>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                                <div class="form-group form-submit-btn-holder text-center mt-3">
                                                                    <div class="form-ajax-status"></div>
                                                                    <button class="btn btn-primary" type="button" onclick"sumbmitlab()">
                                                                        Submit
                                                                        <i class="fa fa-send"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                            <!--[table row template]-->
                                                            <template id="<?php echo $template_id ?>">
                                                                <tr class="input-row">
                                                                    <?php $row = 1; ?>
                                                                    <td width="35%">
                                                                        <div id="ctrl-jenis_pemeriksaan-row<?php echo $row; ?>-holder" class="">
                                                                            <select required=""  id="ctrl-jenis_pemeriksaan-row<?php echo $row; ?>" data-load-check-options="nama_pemeriksaan" name="jenis_pemeriksaan[]"  placeholder="Select a value ..."    class="custom-select" >
                                                                                <option value="">Select a value ...</option>
                                                                                <?php 
                                                                                $jenis_pemeriksaan_options = $comp_model -> pendaftaran_lab_jenis_pemeriksaan_option_list();
                                                                                if(!empty($jenis_pemeriksaan_options)){
                                                                                foreach($jenis_pemeriksaan_options as $option){
                                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                $selected = $this->set_field_selected('jenis_pemeriksaan',$value, "");
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
                                                                    </td>
                                                                    <td>
                                                                        <div id="ctrl-nama_pemeriksaan-row<?php echo $row; ?>-holder" class="">
                                                                            <template id="nama_pemeriksaan-option-template">
                                                                                <label class="custom-control custom-checkbox custom-control-inline">
                                                                                    <input class="custom-control-input" id="ctrl-nama_pemeriksaan-row<?php echo $row; ?>" value="true" type="checkbox"  name="nama_pemeriksaan[]"  />
                                                                                        <span class="custom-control-label input-label-text"></span>
                                                                                    </label>
                                                                                </template>
                                                                                <div id="nama_pemeriksaan-options-holder" data-load-path="<?php print_link('api/json/pendaftaran_lab_nama_pemeriksaan_option_list') ?>">
                                                                                </div> 
                                                                            </div>
                                                                        </td>
                                                                        <th class="text-center">
                                                                            <button type="button" class="close btn-remove-table-row">&times;</button>
                                                                        </th>
                                                                    </tr>
                                                                </template>
                                                                <!--[/table row template]-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
