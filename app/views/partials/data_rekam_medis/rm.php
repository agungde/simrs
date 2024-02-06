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
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Data Rekam Medis</h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <div class=" ">
                        <?php  
                        $this->render_page("data_pasien/pasien/$_GET[datprecord]"); 
                        ?>
                    </div>
                    <?php $this :: display_page_errors(); ?>
                    <div  class=" animated fadeIn page-content">
                        <div id="data_rekam_medis-rm-records">
                            <div id="page-report-body" class="table-responsive">
                                <table class="table  table-sm text-left">
                                    <thead class="table-header bg-success text-dark">
                                        <tr>
                                            <th  class="td-tanggal"> Tanggal</th>
                                            <th  class="td-nama_poli"> Nama Poli</th>
                                            <th  class="td-dokter_pemeriksa"> Dokter Pemeriksa</th>
                                            <th  class="td-keluhan"> Keluhan</th>
                                            <th  class="td-pemeriksaan_fisik"> Pemeriksaan Fisik</th>
                                            <th  class="td-tindakan"> Tindakan</th>
                                            <th  class="td-resep_obat"> Resep Obat</th>
                                            <th  class="td-catatan_medis"> Catatan Medis</th>
                                            <th  class="td-diagnosa"> Diagnosa</th>
                                            <th  class="td-alergi_obat"> Alergi Obat</th>
                                            <th  class="td-hasil_laboratorium_radiologi"> Hasil Laboratorium Radiologi</th>
                                            <th  class="td-idapp"> Idapp</th>
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
                                            <td class="td-nama_poli"> <?php echo $data['nama_poli']; ?></td>
                                            <td class="td-dokter_pemeriksa"> <?php echo $data['dokter_pemeriksa']; ?></td>
                                            <td class="td-keluhan"> <?php echo $data['keluhan']; ?></td>
                                            <td class="td-pemeriksaan_fisik">  <span>  <?php
                                                $usrnam  = "".USER_NAME;
                                                $id_user = "".USER_ID;
                                                $dbhost  = "".DB_HOST;
                                                $dbuser  = "".DB_USERNAME;
                                                $dbpass  = "".DB_PASSWORD;
                                                $dbname  = "".DB_NAME;
                                                $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                $idtrace = "$id_user$usrnam";
                                                $linksite="".SITE_ADDR;
                                                $iddaftar=$data['id_daftar'];
                                                $no_rm=$data['no_rekam_medis'];
                                                $tgl=$data['tanggal'];
                                                if($data['pemeriksaan_fisik']==""){
                                                $appcek = mysqli_query($koneksi,"select * from pemeriksaan_fisik WHERE id_daftar='$iddaftar' and no_rekam_medis='$no_rm' and tanggal='$tgl'");
                                                $roapp = mysqli_num_rows($appcek );
                                                if ($roapp  <> 0) {
                                                $datai = mysqli_fetch_assoc($appcek);
                                                $idf=$datai['id_fisik'];
                                                $BB=$datai['BB'];
                                                $TB=$datai['TB'];
                                                $RR=$datai['RR'];
                                                $SH=$datai['SH'];
                                                $ND=$datai['ND'];
                                                $keluhan=$datai['keluhan'];
                                                //BB   45 kg
                                                //TB   155 cm
                                                //RR   21
                                                //SH   36
                                                //ND   80 
                                                //Keluhan
                                                //$ta=":";
                                            $isifisik="BB: $BB</br>TB: $TB</br> RR: $RR</br> SH: $SH</br> ND: $ND</br> Keluhan: $keluhan";
                                            mysqli_query($koneksi,"UPDATE data_rekam_medis SET pemeriksaan_fisik='$isifisik' WHERE id='$rec_id'");
                                            }
                                            echo $isifisik;
                                            }
                                            echo $data['pemeriksaan_fisik'];
                                            ?>
                                        </span></td>
                                        <td class="td-tindakan"> <span>
                                            <?php 
                                            if($data['tindakan']==""){
                                            $tin="";
                                            $qutin = mysqli_query($koneksi,"select * from data_tindakan WHERE id_daftar='$iddaftar' and no_rekam_medis='$no_rm' and tanggal='$tgl'");
                                            $rotin = mysqli_num_rows($qutin);
                                            if ($rotin  <> 0) {
                                            while ($rot=mysqli_fetch_array($qutin)){
                                            $nam=$rot['nama_tindakan'];
                                            if($tin==""){
                                            $tin=$nam;
                                            }else{
                                            $tin="$tin, $nam";
                                            }
                                            }
                                            mysqli_query($koneksi,"UPDATE data_rekam_medis SET tindakan='$tin' WHERE id='$rec_id'");
                                            }
                                            echo $tin;
                                            }
                                            echo $data['tindakan'];
                                        ?></span></td>
                                        <td class="td-resep_obat"> <span><?php echo $data['resep_obat']; ?>
                                            <?php 
                                            //if($data['resep_obat']==""){
                                            $res="";
                                            $qure = mysqli_query($koneksi,"select * from data_resep WHERE id_daftar='$iddaftar' and no_rekam_medis='$no_rm' and tanggal='$tgl'");
                                            $rore = mysqli_num_rows($qure);
                                            if ($rore  <> 0) {
                                            while ($ror=mysqli_fetch_array($qure)){
                                            $nam=$ror['nama_obat'];
                                            $at=$ror['aturan_minum'];
                                            $jum=$ror['jumlah'];
                                            $rac=$ror['racikan'];
                                            if($res==""){
                                            if($rac==0){ $racikan="";}else{$racikan="Racikan Ke $rac";}
                                            $res="$nam $at $jum $racikan";
                                            }else{
                                            $res="$tin, $nam $at $jum $racikan";
                                            }
                                            }
                                            mysqli_query($koneksi,"UPDATE data_rekam_medis SET resep_obat='$res' WHERE id='$rec_id'");
                                            }
                                            echo $res;
                                            //}
                                            //echo $data['tindakan'];
                                        ?></span></td>
                                        <td class="td-catatan_medis"> <?php echo $data['catatan_medis']; ?></td>
                                        <td class="td-diagnosa"> <span>  <?php
                                            $usrnam  = "".USER_NAME;
                                            $id_user = "".USER_ID;
                                            $dbhost  = "".DB_HOST;
                                            $dbuser  = "".DB_USERNAME;
                                            $dbpass  = "".DB_PASSWORD;
                                            $dbname  = "".DB_NAME;
                                            $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                            $idtrace = "$id_user$usrnam";
                                            $linksite="".SITE_ADDR;
                                            $iddiagnosa=$data['diagnosa'];
                                            $appcek = mysqli_query($koneksi,"select * from diagnosa WHERE id='$iddiagnosa'");
                                            $roapp = mysqli_num_rows($appcek );
                                            if ($roapp  <> 0) {
                                            $datai = mysqli_fetch_assoc($appcek);
                                            $iddiag=$datai['id'];
                                            $description=$datai['description'];
                                            }else{
                                            }?>                                                 
                                        <?php echo $description; ?></span></td>
                                        <td class="td-alergi_obat"> <?php echo $data['alergi_obat']; ?></td>
                                        <td class="td-hasil_laboratorium_radiologi"> <?php echo $data['hasil_laboratorium_radiologi']; ?></td>
                                        <td class="td-idapp"> <?php echo $data['idapp']; ?></td>
                                        <td class="page-list-action td-btn">
                                            <div class="dropdown" >
                                                <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                    <i class="fa fa-bars"></i> 
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <?php if($can_view){ ?>
                                                    <a class="dropdown-item" href="<?php print_link("data_rekam_medis/view/$rec_id"); ?>">
                                                        <i class="fa fa-eye"></i> View 
                                                    </a>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </td>
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
                <div class=" ">
                    <?php  
                    $this->render_page("rm_lama/rmlama/rm_lama.no_rekam_medis/$_GET[precord]?limit_count=20"); 
                    ?>
                </div>
                </div>
                </div>
                </div>
                </div>
                </section>
