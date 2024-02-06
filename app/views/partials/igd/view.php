<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("igd/add");
$can_edit = ACL::is_allowed("igd/edit");
$can_view = ACL::is_allowed("igd/view");
$can_delete = ACL::is_allowed("igd/delete");
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
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View  Igd</h4>
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
                        $rec_id = (!empty($data['id_igd']) ? urlencode($data['id_igd']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-tanggal_masuk">
                                        <th class="title"> Tanggal Masuk: </th>
                                        <td class="value"> <?php echo $data['tanggal_masuk']; ?></td>
                                    </tr>
                                    <tr  class="td-no_rekam_medis">
                                        <th class="title"> No Rekam Medis: </th>
                                        <td class="value"> <?php echo $data['no_rekam_medis']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_pasien">
                                        <th class="title"> Nama Pasien: </th>
                                        <td class="value"> <?php echo $data['nama_pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-alamat">
                                        <th class="title"> Alamat: </th>
                                        <td class="value"> <?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr  class="td-dokter">
                                        <th class="title"> Dokter: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_dokter/view/" . urlencode($data['dokter'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['data_dokter_nama_dokter'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-tanggal_lahir">
                                        <th class="title"> Tanggal Lahir: </th>
                                        <td class="value"> <?php echo $data['tanggal_lahir']; ?></td>
                                    </tr>
                                    <tr  class="td-jenis_kelamin">
                                        <th class="title"> Jenis Kelamin: </th>
                                        <td class="value"> <?php echo $data['jenis_kelamin']; ?></td>
                                    </tr>
                                    <tr  class="td-umur">
                                        <th class="title"> Umur: </th>
                                        <td class="value"> <?php echo $data['umur']; ?></td>
                                    </tr>
                                    <tr  class="td-no_hp">
                                        <th class="title"> No Hp: </th>
                                        <td class="value"> <?php echo $data['no_hp']; ?></td>
                                    </tr>
                                    <tr  class="td-email">
                                        <th class="title"> Email: </th>
                                        <td class="value"> <?php echo $data['email']; ?></td>
                                    </tr>
                                    <tr  class="td-pembayaran">
                                        <th class="title"> Pembayaran: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_bank/view/" . urlencode($data['pembayaran'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['data_bank_nama_bank'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-penanggung_jawab">
                                        <th class="title"> Penanggung Jawab: </th>
                                        <td class="value"> <?php echo $data['penanggung_jawab']; ?></td>
                                    </tr>
                                    <tr  class="td-id_penanggung_jawab">
                                        <th class="title"> Id Penanggung Jawab: </th>
                                        <td class="value"> <?php echo $data['id_penanggung_jawab']; ?></td>
                                    </tr>
                                    <tr  class="td-alamat_penanggung_jawab">
                                        <th class="title"> Alamat Penanggung Jawab: </th>
                                        <td class="value"> <?php echo $data['alamat_penanggung_jawab']; ?></td>
                                    </tr>
                                    <tr  class="td-no_hp_penanggung_jawab">
                                        <th class="title"> No Hp Penanggung Jawab: </th>
                                        <td class="value"> <?php echo $data['no_hp_penanggung_jawab']; ?></td>
                                    </tr>
                                    <tr  class="td-hubungan">
                                        <th class="title"> Hubungan: </th>
                                        <td class="value"> <?php echo $data['hubungan']; ?></td>
                                    </tr>
                                    <tr  class="td-rawat_inap">
                                        <th class="title"> Rawat Inap: </th>
                                        <td class="value"> <?php echo $data['rawat_inap']; ?></td>
                                    </tr>
                                    <tr  class="td-setatus_bpjs">
                                        <th class="title"> Setatus Bpjs: </th>
                                        <td class="value"> <?php echo $data['setatus_bpjs']; ?></td>
                                    </tr>
                                    <tr  class="td-setatus">
                                        <th class="title"> Setatus: </th>
                                        <td class="value"> <?php echo $data['setatus']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal_keluar">
                                        <th class="title"> Tanggal Keluar: </th>
                                        <td class="value"> <?php echo $data['tanggal_keluar']; ?></td>
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
