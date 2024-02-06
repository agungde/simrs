<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_resep/add");
$can_edit = ACL::is_allowed("data_resep/edit");
$can_view = ACL::is_allowed("data_resep/view");
$can_delete = ACL::is_allowed("data_resep/delete");
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
                    <div class=" ">
                        <?php  
                        $this->render_page("data_pasien/obat/$_GET[datprecord]"); 
                        ?>
                    </div>
                    <?php $this :: display_page_errors(); ?>
                    <div  class=" animated fadeIn page-content">
                        <div id="data_resep-obat-records">
                            <div id="page-report-body" class="table-responsive">
                                <table class="table table-hover table-sm text-left">
                                    <thead class="table-header bg-success text-dark">
                                        <tr>
                                            <th  class="td-tanggal"> Tanggal</th>
                                            <th  class="td-nama_poli"> Specialist</th>
                                            <th  class="td-nama_dokter"> Nama Dokter</th>
                                            <th  class="td-nama_obat"> Nama Obat</th>
                                            <th  class="td-aturan_minum"> Aturan Pakai</th>
                                            <th  class="td-jumlah"> Jumlah</th>
                                            <th  class="td-keterangan"> Keterangan</th>
                                            <th  class="td-racikan"> Racikan</th>
                                            <th  class="td-resep"> Resep</th>
                                            <th  class="td-tebus_resep"> Tebus Resep</th>
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
                                        $rec_id = (!empty($data['id_data_resep']) ? urlencode($data['id_data_resep']) : null);
                                        $counter++;
                                        ?>
                                        <tr>
                                            <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
                                            <td class="td-nama_poli"> <span><?php
                                                $id_user = "".USER_ID;
                                                $dbhost  = "".DB_HOST;
                                                $dbuser  = "".DB_USERNAME;
                                                $dbpass  = "".DB_PASSWORD;
                                                $dbname  = "".DB_NAME;
                                                //$koneksi=open_connection();
                                                $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                $qupol = mysqli_query($koneksi, "SELECT * from data_poli WHERE id_poli='".$data['nama_poli']."' ")
                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                $rotrif = mysqli_num_rows($qupol);
                                                if ($rotrif <> 0) {
                                                $dapol= mysqli_fetch_assoc($qupol);
                                                echo $dapol['nama_poli'];
                                                }else{
                                                echo $data['nama_poli'];
                                                }
                                            ?></span></td>
                                            <td class="td-nama_dokter"> <?php echo $data['nama_dokter']; ?></td>
                                            <td class="td-nama_obat"> <?php echo $data['nama_obat']; ?></td>
                                            <td class="td-aturan_minum"> <?php echo $data['aturan_minum']; ?></td>
                                            <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
                                            <td class="td-keterangan"> <?php echo $data['keterangan']; ?></td>
                                            <td class="td-racikan"> <span><?php
                                                if($data['racikan']=="" or $data['racikan']=="0"){
                                                $racikan="";
                                                }else{
                                                $racikan="Racikan";
                                                }
                                            echo $racikan; ?></span></td>
                                            <td class="td-resep"> <span>Resep Ke <?php echo $data['resep']; ?></span></td>
                                            <td class="td-tebus_resep"> <?php echo $data['tebus_resep']; ?></td>
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
