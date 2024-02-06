<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_dokter/add");
$can_edit = ACL::is_allowed("data_dokter/edit");
$can_view = ACL::is_allowed("data_dokter/view");
$can_delete = ACL::is_allowed("data_dokter/delete");
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
                    <h4 class="record-title">View  Data Dokter</h4>
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
                        $rec_id = (!empty($data['id_dokter']) ? urlencode($data['id_dokter']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-nama_dokter">
                                        <th class="title"> Nama Dokter: </th>
                                        <td class="value"> <?php echo $data['nama_dokter']; ?></td>
                                    </tr>
                                    <tr  class="td-jenis_kelamin">
                                        <th class="title"> Jenis Kelamin: </th>
                                        <td class="value"> <?php echo $data['jenis_kelamin']; ?></td>
                                    </tr>
                                    <tr  class="td-no_hp">
                                        <th class="title"> No Hp: </th>
                                        <td class="value"> <?php echo $data['no_hp']; ?></td>
                                    </tr>
                                    <tr  class="td-alamat">
                                        <th class="title"> Alamat: </th>
                                        <td class="value"> <?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr  class="td-specialist">
                                        <th class="title"> Specialist: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_poli/view/" . urlencode($data['specialist'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['data_poli_nama_poli'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-email">
                                        <th class="title"> Email: </th>
                                        <td class="value"> <?php echo $data['email']; ?></td>
                                    </tr>
                                    <tr  class="td-jasa_poli">
                                        <th class="title"> Jasa Poli: </th>
                                        <td class="value">Rp.<?php echo number_format($data['jasa_poli'],0,",",".");?></td>
                                    </tr>
                                    <tr  class="td-jasa_kunjungan">
                                        <th class="title"> Jasa Kunjungan: </th>
                                        <td class="value">Rp.<?php echo number_format($data['jasa_kunjungan'],0,",",".");?></td>
                                    </tr>
                                    <tr  class="td-photo">
                                        <th class="title"> Photo: </th>
                                        <td class="value"> <?php echo $data['photo']; ?></td>
                                    </tr>
                                    <tr  class="td-date_created">
                                        <th class="title"> Date Created: </th>
                                        <td class="value"> <?php echo $data['date_created']; ?></td>
                                    </tr>
                                    <tr  class="td-date_updated">
                                        <th class="title"> Date Updated: </th>
                                        <td class="value"> <?php echo $data['date_updated']; ?></td>
                                    </tr>
                                    <tr  class="td-tagihan_jasa_poli">
                                        <th class="title"> Tagihan Jasa Poli: </th>
                                        <td class="value"> <?php echo $data['tagihan_jasa_poli']; ?></td>
                                    </tr>
                                    <tr  class="td-tagihan_jasa_kunjungan">
                                        <th class="title"> Tagihan Jasa Kunjungan: </th>
                                        <td class="value"> <?php echo $data['tagihan_jasa_kunjungan']; ?></td>
                                    </tr>
                                    <tr  class="td-jasa_igd">
                                        <th class="title"> Jasa Igd: </th>
                                        <td class="value"> <?php echo $data['jasa_igd']; ?></td>
                                    </tr>
                                    <tr  class="td-tagihan_jasa_igd">
                                        <th class="title"> Tagihan Jasa Igd: </th>
                                        <td class="value"> <?php echo $data['tagihan_jasa_igd']; ?></td>
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
