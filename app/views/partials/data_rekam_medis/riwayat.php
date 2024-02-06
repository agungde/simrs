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
                        <div id="data_rekam_medis-riwayat-records">
                            <div id="page-report-body" class="table-responsive">
                                <table class="table table-hover table-sm text-left">
                                    <thead class="table-header bg-success text-dark">
                                        <tr>
                                            <th  class="td-tanggal"> Tanggal</th>
                                            <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                            <th  class="td-nama_poli"> Nama Poli</th>
                                            <th  class="td-keluhan"> Keluhan</th>
                                            <th  class="td-diagnosa"> Diagnosa</th>
                                            <th  class="td-resep_obat"> Resep Obat</th>
                                            <th  class="td-dokter_pemeriksa"> Dokter Pemeriksa</th>
                                            <th  class="td-alergi_obat"> Alergi Obat</th>
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
                                            <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
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
                                                $nampol="" ;
                                                }
                                                echo $nampol;
                                                }
                                            //echo $data['nama_poli']; ?></span></td>
                                            <td class="td-keluhan"> <?php echo $data['keluhan']; ?></td>
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
                                            <td class="td-resep_obat"> <?php echo $data['resep_obat']; ?></td>
                                            <td class="td-dokter_pemeriksa"> <?php echo $data['dokter_pemeriksa']; ?></td>
                                            <td class="td-alergi_obat"> <?php echo $data['alergi_obat']; ?></td>
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