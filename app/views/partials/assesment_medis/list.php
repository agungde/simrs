<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("assesment_medis/add");
$can_edit = ACL::is_allowed("assesment_medis/edit");
$can_view = ACL::is_allowed("assesment_medis/view");
$can_delete = ACL::is_allowed("assesment_medis/delete");
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
    <div  class="bg-light p-1 mb-1">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Detile Assesment Medis</h4>
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
                        <div id="assesment_medis-list-records">
                            <div id="page-report-body" class="table-responsive">
                                <table class="table  table-sm text-left">
                                    <thead class="table-header bg-success text-dark">
                                        <tr>
                                            <th  class="td-tgl_masuk"> Tgl Masuk</th>
                                            <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                            <th  class="td-pasien"> Pasien</th>
                                            <th  class="td-scor_gcs"> SCOR/GCS</th>
                                            <th  class="td-td"> TD</th>
                                            <th  class="td-dj"> DJ</th>
                                            <th  class="td-djj"> DJJ</th>
                                            <th  class="td-sh"> SH</th>
                                            <th  class="td-spo"> SPO2</th>
                                            <th  class="td-nd"> ND</th>
                                            <th  class="td-kondisi_umum"> Kondisi Umum</th>
                                            <th  class="td-pemeriksaan_penunjang"> Pemeriksaan Penunjang</th>
                                            <th  class="td-diagnosa_kerja"> Diagnosa Kerja</th>
                                            <th  class="td-diagnosa_banding"> Diagnosa Banding</th>
                                            <th  class="td-tindakan_pengobatan"> Tindakan Pengobatan</th>
                                            <th  class="td-instruksi_selanjutnya"> Instruksi Selanjutnya</th>
                                            <th  class="td-diteruskan_dokter"> Diteruskan Dokter</th>
                                            <th  class="td-keadaan_keluar_igd"> Keadaan Keluar Igd</th>
                                            <th  class="td-ttd_dokter"> Ttd Dokter</th>
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
                                            <td class="td-tgl_masuk"> <?php echo $data['tgl_masuk']; ?></td>
                                            <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
                                            <td class="td-pasien"> <?php echo $data['pasien']; ?></td>
                                            <td class="td-scor_gcs"> <?php echo $data['scor_gcs']; ?></td>
                                            <td class="td-td"> <?php echo $data['td']; ?></td>
                                            <td class="td-dj"> <?php echo $data['dj']; ?></td>
                                            <td class="td-djj"> <?php echo $data['djj']; ?></td>
                                            <td class="td-sh"> <?php echo $data['sh']; ?></td>
                                            <td class="td-spo"> <?php echo $data['spo']; ?></td>
                                            <td class="td-nd"> <?php echo $data['nd']; ?></td>
                                            <td class="td-kondisi_umum"> <?php echo $data['kondisi_umum']; ?></td>
                                            <td class="td-pemeriksaan_penunjang"> <?php echo $data['pemeriksaan_penunjang']; ?></td>
                                            <td class="td-diagnosa_kerja"> <span><?php
                                                $usrnam  = "".USER_NAME;
                                                $id_user = "".USER_ID;
                                                $dbhost  = "".DB_HOST;
                                                $dbuser  = "".DB_USERNAME;
                                                $dbpass  = "".DB_PASSWORD;
                                                $dbname  = "".DB_NAME;
                                                $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                $idtrace = "$id_user$usrnam";
                                                $iddiag=$data['diagnosa_kerja'];
                                                $qutrt = mysqli_query($koneksi, "SELECT * from diagnosa WHERE id='$iddiag'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                $rotrt = mysqli_num_rows($qutrt);
                                                if ($rotrt <> 0) {
                                                $ctrt= mysqli_fetch_assoc($qutrt);
                                                $diag=$ctrt['description'];
                                                }else{
                                                $diag=""; 
                                                }
                                                ?>
                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="#">
                                                <?php echo $diag;?></a>
                                            </span></td>
                                            <td class="td-diagnosa_banding"> <span><?php
                                                $iddiagb=$data['diagnosa_banding'];
                                                $qutrta = mysqli_query($koneksi, "SELECT * from diagnosa WHERE id='$iddiagb'")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                $rotrta = mysqli_num_rows($qutrta);
                                                if ($rotrta <> 0) {
                                                $ctrta= mysqli_fetch_assoc($qutrta);
                                                $diaga=$ctrta['description'];
                                                }else{
                                                $diaga=""; 
                                                }
                                                ?>
                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="#">
                                                <?php echo $diaga;?></a>
                                            </span></td>
                                            <td class="td-tindakan_pengobatan"> <?php echo $data['tindakan_pengobatan']; ?></td>
                                            <td class="td-instruksi_selanjutnya"> <?php echo $data['instruksi_selanjutnya']; ?></td>
                                            <td class="td-diteruskan_dokter">
                                                <span><?php
                                                    $iddok=$data['diteruskan_dokter'];
                                                    $qutrtb = mysqli_query($koneksi, "SELECT * from data_dokter WHERE id_dokter='$iddok'")
                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                    $rotrtb = mysqli_num_rows($qutrtb);
                                                    if ($rotrtb <> 0) {
                                                    $ctrtb= mysqli_fetch_assoc($qutrtb);
                                                    $diagb=$ctrtb['nama_dokter'];
                                                    }else{
                                                    $diagb=""; 
                                                    }
                                                    ?>
                                                    <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip page-modal" href="#">
                                                    <?php echo $diagb;?></a>
                                                </span></td>
                                                <td class="td-keadaan_keluar_igd"> <?php echo $data['keadaan_keluar_igd']; ?></td>
                                                <td class="td-ttd_dokter"><?php Html :: page_img($data['ttd_dokter'],50,50,1); ?></td>
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
