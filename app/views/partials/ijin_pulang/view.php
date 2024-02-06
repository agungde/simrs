<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("ijin_pulang/add");
$can_edit = ACL::is_allowed("ijin_pulang/edit");
$can_view = ACL::is_allowed("ijin_pulang/view");
$can_delete = ACL::is_allowed("ijin_pulang/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "view-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data Information from Controller
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View  Ijin Pulang</h4>
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
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="card animated fadeIn page-content">
                        <?php
                        $counter = 0;
                        if(!empty($data)){
                        $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-tanggal">
                                        <th class="title"> Tanggal Pulang: </th>
                                        <td class="value"> <?php echo $data['tanggal']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_pasien">
                                        <th class="title"> Nama Pasien: </th>
                                        <td class="value"> <?php echo $data['nama_pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-no_rekam_medis">
                                        <th class="title"> No Rekam Medis: </th>
                                        <td class="value"> <?php echo $data['no_rekam_medis']; ?></td>
                                    </tr>
                                    <tr  class="td-jenis_kelamin">
                                        <th class="title"> Jenis Kelamin: </th>
                                        <td class="value"> <?php echo $data['jenis_kelamin']; ?></td>
                                    </tr>
                                    <tr  class="td-alamat">
                                        <th class="title"> Alamat: </th>
                                        <td class="value"> <?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr  class="td-poli">
                                        <th class="title"> Poli: </th>
                                        <td class="value"> <?php echo $data['poli']; ?></td>
                                    </tr>
                                    <tr  class="td-dokter">
                                        <th class="title"> Dokter: </th>
                                        <td class="value"> <?php echo $data['dokter']; ?></td>
                                    </tr>
                                    <tr  class="td-keterangan">
                                        <th class="title"> Keterangan: </th>
                                        <td class="value"> <?php echo $data['keterangan']; ?></td>
                                    </tr>
                                    <tr  class="td-kamar_kelas">
                                        <th class="title"> Kamar Kelas: </th>
                                        <td class="value"> <?php echo $data['kamar_kelas']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_kamar">
                                        <th class="title"> Nama Kamar: </th>
                                        <td class="value"> <?php echo $data['nama_kamar']; ?></td>
                                    </tr>
                                    <tr  class="td-no_kamar">
                                        <th class="title"> No Kamar: </th>
                                        <td class="value"> <?php echo $data['no_kamar']; ?></td>
                                    </tr>
                                    <tr  class="td-no_ranjang">
                                        <th class="title"> No Ranjang: </th>
                                        <td class="value"> <?php echo $data['no_ranjang']; ?></td>
                                    </tr>
                                    <tr  class="td-ttd">
                                        <th class="title"> Ttd Dokter: </th>
                                        <td class="value"><?php Html :: page_img($data['ttd'],400,400,1); ?></td>
                                    </tr>
                                    <tr  class="td-kontrol">
                                        <th class="title"> Kontrol: </th>
                                        <td class="value"> <?php echo $data['kontrol']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal_kontrol">
                                        <th class="title"> Tanggal Kontrol: </th>
                                        <td class="value"> <?php echo $data['tanggal_kontrol']; ?></td>
                                    </tr>
                                    <tr  class="td-id_transaksi">
                                        <th class="title"> Id Transaksi: </th>
                                        <td class="value"> <?php echo $data['id_transaksi']; ?></td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
                        </div>
                        <?php
                        }
                        else{
                        ?>
                        <!-- Empty Record Message -->
                        <div class="text-muted p-3">
                            <i class="fa fa-ban"></i> No Record Found
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
