<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_rekam_medis/add");
$can_edit = ACL::is_allowed("data_rekam_medis/edit");
$can_view = ACL::is_allowed("data_rekam_medis/view");
$can_delete = ACL::is_allowed("data_rekam_medis/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "list-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data From Controller
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_footer = $this->show_footer;
$show_pagination = $this->show_pagination;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <div  class="">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class=" animated fadeIn page-content">
                        <div id="data_rekam_medis-detile-records">
                            <div id="page-report-body" class="table-responsive">
                                <table class="table table-hover table-sm text-left">
                                    <thead class="table-header bg-success text-dark">
                                        <tr>
                                            <th  class="td-tanggal"> Tanggal</th>
                                            <th  class="td-nama_poli"> Specialist</th>
                                            <th  class="td-dokter_pemeriksa"> Dokter Pemeriksa</th>
                                            <th  class="td-keluhan"> Keluhan</th>
                                            <th  class="td-pemeriksaan_fisik"> Pemeriksaan Fisik</th>
                                            <th  class="td-tindakan"> Tindakan</th>
                                            <th  class="td-resep_obat"> Resep Obat</th>
                                            <th  class="td-diagnosa"> Diagnosa</th>
                                            <th  class="td-hasil_laboratorium_radiologi"> Hasil Laboratorium Radiologi</th>
                                            <th  class="td-alergi_obat"> Alergi Obat</th>
                                            <th  class="td-assesment_triase"> Assesment Triase</th>
                                            <th  class="td-assesment_medis"> Assesment Medis</th>
                                            <th  class="td-catatan_medis"> Catatan Medis</th>
                                            <th class="td-btn"></th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if(!empty($records)){
                                    ?>
                                    <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                        <!--record-->
                                        <?php
                                        $counter = 0;
                                        foreach($records as $data){
                                        $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                                        $counter++;
                                        ?>
                                        <tr>
                                            <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
                                            <td class="td-nama_poli"> <span><?php 
                                                $sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
                                                $id_user = "".USER_ID;
                                                $dbhost="".DB_HOST;
                                                $dbuser="".DB_USERNAME;
                                                $dbpass="".DB_PASSWORD;
                                                $dbname="".DB_NAME;
                                                //$koneksi=open_connection();
                                                $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                $idpol=$data['nama_poli'];
                                                if($idpol==""){ }else{
                                                $query = mysqli_query($koneksi, "SELECT * from data_poli WHERE id_poli='$idpol'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                $rows = mysqli_num_rows($query);
                                                if ($rows <> 0) {
                                                $datacek= mysqli_fetch_assoc($query);
                                                $nampol=$datacek['nama_poli'];
                                                }else{
                                                $nampol="$idpol" ;
                                                }
                                                echo $nampol;
                                                }
                                            //echo $data['nama_poli']; ?></span></td>
                                            <td class="td-dokter_pemeriksa"> <?php echo $data['dokter_pemeriksa']; ?></td>
                                            <td class="td-keluhan"> <?php echo $data['keluhan']; ?></td>
                                            <td class="td-pemeriksaan_fisik"> <span><?php   $norm=$data['no_rekam_medis'];
                                                $id_daftar=$data['id_daftar'];
                                                $qutrif = mysqli_query($koneksi, "SELECT * from pemeriksaan_fisik WHERE id_daftar='$id_daftar' and no_rekam_medis='$norm'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                $rotrif = mysqli_num_rows($qutrif);
                                                if ($rotrif <> 0) {
                                                $ctrif= mysqli_fetch_assoc($qutrif);
                                                $idtrif=$ctrif['id_fisik'];
                                                ?>
                                                <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("pemeriksaan_fisik/view/$idtrif?precord=$ciphertext&datprecord=$rec_id");?>">
                                                <i class="fa fa-send"></i> Lihat Pemeriksaan Fisik</a>                                
                                                <?php
                                            } ?></span></td>
                                            <td class="td-tindakan"> <span><?php
                                                $id_daftar=$data['id_daftar'];
                                                $pasien=$data['pasien'];
                                                $query = mysqli_query($koneksi, "SELECT * from data_tindakan WHERE id_daftar='$id_daftar'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                // ambil jumlah baris data hasil query
                                                $rows = mysqli_num_rows($query);
                                                // cek hasil query
                                                // jika "no_antrian" sudah ada
                                                if ($rows <> 0) {
                                                // $datacek= mysqli_fetch_assoc($query);
                                                ?>
                                                <a style="margin-top:2px;" class="btn btn-sm btn-warning has-tooltip page-modal"  href="<?php  print_link("data_tindakan?detile_precord=$id_daftar&trace=$pasien");?>">
                                                <i class="fa fa-user "></i> Lihat Tindakan</a> 
                                                <?php
                                                }
                                                // echo $data['tindakan'];
                                            ?></span></td>
                                            <td class="td-resep_obat"> <span> <?php
                                                $iddaftar=$data['id_daftar'];
                                                $queryr = mysqli_query($koneksi, "SELECT * from data_resep WHERE id_daftar='$iddaftar'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                $rowsr = mysqli_num_rows($queryr);
                                                if ($rowsr <> 0) {
                                                $datr= mysqli_fetch_assoc($queryr);
                                                $idresp=$datr['id_resep_obat'];
                                                $key="dermawangroup";
                                                $plaintext = "$idresp";
                                                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                $iv = openssl_random_pseudo_bytes($ivlen);
                                                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                ?>
                                                <a class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("data_resep/proses?csrf_token=$csrf_token&precord=$ciphertext&view=$ciphertext");?>">
                                                <i class="fa fa-eye"></i> Lihat Resep</a> 
                                                <?php 
                                                }
                                            //echo $data['resep_obat']; ?></span></td>
                                            <td class="td-diagnosa"> <span><?php //echo $data['diagnosa'];
                                                $iddig=$data['diagnosa'];
                                                if($iddig==""){ }else{
                                                $queryd = mysqli_query($koneksi, "SELECT * from diagnosa WHERE id='$iddig'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                $rowsd = mysqli_num_rows($queryd);
                                                if ($rowsd <> 0) {
                                                $datacekd= mysqli_fetch_assoc($queryd);
                                                $namdig=$datacekd['description'];
                                                }else{
                                                $namdig="" ;
                                                }
                                                echo $namdig;
                                                }
                                            ?></span></td>
                                            <td class="td-hasil_laboratorium_radiologi"> <span> <?php
                                                $idlab=$data['id_daftar'];
                                                $queryh = mysqli_query($koneksi, "SELECT * from hasil_lab_luar WHERE id_daftar='$idlab'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                // ambil jumlah baris data hasil query
                                                $rowsh = mysqli_num_rows($queryh);
                                                // cek hasil query
                                                // jika "no_antrian" sudah ada
                                                if ($rowsh <> 0) {
                                                $datacekh= mysqli_fetch_assoc($queryh);
                                                $idluar= $datacekh['id']; 
                                                ?>
                                                <a style="margin-top:2px;" class="btn btn-sm btn-secondary has-tooltip page-modal"  href="<?php  print_link("hasil_lab_luar/view/$idluar?csrf_token=$csrf_toke");?>">
                                                <i class="fa fa-send"></i>Lihat Hasil Lab Luar</a>       
                                                <?php
                                                }
                                                $query = mysqli_query($koneksi, "SELECT * from pendaftaran_lab WHERE id_daftar=' $idlab'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                // ambil jumlah baris data hasil query
                                                $rows = mysqli_num_rows($query);
                                                // cek hasil query
                                                // jika "no_antrian" sudah ada
                                                if ($rows <> 0) {
                                                $datacek= mysqli_fetch_assoc($query);
                                                $iddaftarlab=$datacek['id'];
                                                if($datacek['setatus']=="Closed"){
                                                $queryh = mysqli_query($koneksi, "SELECT * from hasil_lab WHERE id_daftar_lab='$iddaftarlab'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                // ambil jumlah baris data hasil query
                                                $rowsh = mysqli_num_rows($queryh);
                                                // cek hasil query
                                                // jika "no_antrian" sudah ada
                                                if ($rowsh <> 0) {
                                                $datacekh= mysqli_fetch_assoc($queryh);
                                                $id_hasil_lab= $datacekh['id_hasil_lab']; 
                                                $key="dermawangroup";
                                                $plaintext = "$id_hasil_lab";
                                                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                $iv = openssl_random_pseudo_bytes($ivlen);
                                                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                }
                                                ?>
                                                <a style="margin-top:2px;" class="btn btn-sm btn-secondary has-tooltip page-modal"  href="<?php  print_link("hasil_lab/hasil?csrf_token=$csrf_token&precord=$ciphertext");?>">
                                                <i class="fa fa-send"></i>Lihat Lab</a> 
                                                <?php 
                                                }else{
                                                echo "<i class=\"fa fa-users \"></i> Masih Proses";
                                                $norekam=$data['no_rekam_medis'];
                                                }
                                                }
                                            //echo $data['resep_obat']; ?></span></td>
                                            <td class="td-alergi_obat"> <?php echo $data['alergi_obat']; ?></td>
                                            <td class="td-assesment_triase"> <span>
                                                <?php
                                                $norm=$data['no_rekam_medis'];
                                                $id_daftar=$data['id_daftar'];  
                                                $qutr = mysqli_query($koneksi, "SELECT * from assesment_triase WHERE id_daftar='$id_daftar' and no_rekam_medis='$norm'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                $rotr = mysqli_num_rows($qutr);
                                                if ($rotr <> 0) {
                                                $ctr= mysqli_fetch_assoc($qutr);
                                                $idtri=$ctr['id_triase'];
                                                ?>
                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip page-modal" href="<?php  print_link("assesment_triase/triase/$idtri?precord=$norm&datprecord=$idtr");?>">
                                                <i class="fa fa-eye"></i> Lihat Assesment Triase</a>
                                                <?php
                                                }
                                                //echo $data['assesment_triase'];
                                            ?></span></td>
                                            <td class="td-assesment_medis"> <span><?php     $norm=$data['no_rekam_medis'];
                                                $id_daftar=$data['id_daftar'];
                                                $qutripm = mysqli_query($koneksi, "SELECT * from assesment_medis WHERE id_daftar='$id_daftar' and no_rekam_medis='$norm'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                $rotripm = mysqli_num_rows($qutripm);
                                                if ($rotripm <> 0) {
                                                $ctripm= mysqli_fetch_assoc($qutripm);
                                                $idopm=$ctripm['id'];
                                                ?>
                                                <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("assesment_medis/view/$idopm?precord=$ciphertext&datprecord=$rec_id");?>">
                                                <i class="fa fa-send"></i>  Lihat Assesment Medis</a> 
                                            <?php } ?></span></td>
                                            <td class="td-catatan_medis"> <span>
                                                <div class="dropdown" >
                                                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-danger btn-sm">
                                                        <i class="fa fa-bars"></i> 
                                                        </button><ul class="dropdown-menu">
                                                        <?php
                                                        //  if(USER_ROLE==3){
                                                        $norekam=$data['no_rekam_medis'];
                                                        $querydt = mysqli_query($koneksi, "SELECT * from data_rekam_medis WHERE no_rekam_medis='$norekam'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        $rowsdt = mysqli_num_rows($querydt);
                                                        if ($rowsdt <> 0) { 
                                                        $querydtb = mysqli_query($koneksi, "SELECT * from rekam_medis WHERE no_rekam_medis='$norekam'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        $rowsdtb = mysqli_num_rows($querydtb);
                                                        if ($rowsdtb <> 0) {      
                                                        $datidb= mysqli_fetch_assoc($querydtb);
                                                        $idrekam=$datidb['id_rekam_medis'];
                                                        }
                                                        ?>
                                                        <a class="btn btn-sm btn-danger has-tooltip page-modal"  href="<?php  print_link("rekam_medis/catatan/$idrekam?detile_precord=$norekam");?>">
                                                        <i class="fa fa-eye"></i> Lihat Catatan Medis</a>
                                                        <?php
                                                        }
                                                        //}
                                                        ?>
                                                    </ul>
                                                </div>
                                            </span></td>
                                        </tr>
                                        <?php 
                                        }
                                        ?>
                                        <!--endrecord-->
                                    </tbody>
                                    <tbody class="search-data" id="search-data-<?php echo $page_element_id; ?>"></tbody>
                                    <?php
                                    }
                                    ?>
                                </table>
                                <?php 
                                if(empty($records)){
                                ?>
                                <h4 class="bg-light text-center border-top text-muted animated bounce  p-3">
                                    <i class="fa fa-ban"></i> No record found
                                </h4>
                                <?php
                                }
                                ?>
                            </div>
                            <?php
                            if( $show_footer && !empty($records)){
                            ?>
                            <div class=" border-top mt-2">
                                <div class="row justify-content-center">    
                                    <div class="col-md-auto justify-content-center">    
                                        <div class="p-3 d-flex justify-content-between">    
                                        </div>
                                    </div>
                                    <div class="col">   
                                        <?php
                                        if($show_pagination == true){
                                        $pager = new Pagination($total_records, $record_count);
                                        $pager->route = $this->route;
                                        $pager->show_page_count = true;
                                        $pager->show_record_count = true;
                                        $pager->show_page_limit =true;
                                        $pager->limit_count = $this->limit_count;
                                        $pager->show_page_number_list = true;
                                        $pager->pager_link_range=5;
                                        $pager->render();
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
