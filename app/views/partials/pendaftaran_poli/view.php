<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("pendaftaran_poli/add");
$can_edit = ACL::is_allowed("pendaftaran_poli/edit");
$can_view = ACL::is_allowed("pendaftaran_poli/view");
$can_delete = ACL::is_allowed("pendaftaran_poli/delete");
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
                    <h4 class="record-title">View  Pendaftaran Poli</h4>
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
                        $rec_id = (!empty($data['id_pendaftaran_poli']) ? urlencode($data['id_pendaftaran_poli']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-tanggal">
                                        <th class="title"> Tanggal: </th>
                                        <td class="value"> <?php echo $data['tanggal']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_poli">
                                        <th class="title"> Nama Poli: </th>
                                        <td class="value"><?php
                                            $id_user = "".USER_ID;
                                            $dbhost="".DB_HOST;
                                            $dbuser="".DB_USERNAME;
                                            $dbpass="".DB_PASSWORD;
                                            $dbname="".DB_NAME;
                                            //$koneksi=open_connection();
                                            $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                            $idpol=$data['nama_poli'];
                                            $queryh = mysqli_query($koneksi, "SELECT * from data_poli WHERE id_poli='$idpol'")
                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                            $rowsh = mysqli_num_rows($queryh);
                                            if ($rowsh <> 0) {
                                            $datacekh= mysqli_fetch_assoc($queryh);
                                            $nampol=$datacekh['nama_poli'];
                                            }else{
                                            $nampol="";
                                            }
                                            ?>
                                        <a size="sm" class="btn btn-sm btn-primary page-modal" href="#"><i class="fa fa-eye"></i> <?php echo $nampol;?></a></td>
                                    </tr>
                                    <tr  class="td-dokter">
                                        <th class="title"> Dokter: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_dokter/view/" . urlencode($data['dokter'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['data_dokter_nama_dokter'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-pembayaran">
                                        <th class="title"> Pembayaran: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_bank/view/" . urlencode($data['pembayaran'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['data_bank_nama_bank'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-setatus_bpjs">
                                        <th class="title"> Setatus Bpjs: </th>
                                        <td class="value"> <?php echo $data['setatus_bpjs']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_pasien">
                                        <th class="title"> Nama Pasien: </th>
                                        <td class="value"> <?php echo $data['nama_pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-no_rekam_medis">
                                        <th class="title"> No Rekam Medis: </th>
                                        <td class="value"> <?php echo $data['no_rekam_medis']; ?></td>
                                    </tr>
                                    <tr  class="td-no_antri_poli">
                                        <th class="title"> No Antri Poli: </th>
                                        <td class="value"> <?php echo $data['no_antri_poli']; ?></td>
                                    </tr>
                                    <tr  class="td-keluhan">
                                        <th class="title"> Keluhan: </th>
                                        <td class="value"> <?php echo $data['keluhan']; ?></td>
                                    </tr>
                                    <tr  class="td-no_hp">
                                        <th class="title"> No Hp: </th>
                                        <td class="value"> <?php echo $data['no_hp']; ?></td>
                                    </tr>
                                    <tr  class="td-alamat">
                                        <th class="title"> Alamat: </th>
                                        <td class="value"> <?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr  class="td-jenis_kelamin">
                                        <th class="title"> Jenis Kelamin: </th>
                                        <td class="value"> <?php echo $data['jenis_kelamin']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal_lahir">
                                        <th class="title"> Tanggal Lahir: </th>
                                        <td class="value"> <?php echo $data['tanggal_lahir']; ?></td>
                                    </tr>
                                    <tr  class="td-umur">
                                        <th class="title"> Umur: </th>
                                        <td class="value"> <?php echo $data['umur']; ?></td>
                                    </tr>
                                    <tr  class="td-setatus">
                                        <th class="title"> Setatus: </th>
                                        <td class="value"> <?php echo $data['setatus']; ?></td>
                                    </tr>
                                    <tr  class="td-email">
                                        <th class="title"> Email: </th>
                                        <td class="value"> <?php echo $data['email']; ?></td>
                                    </tr>
                                    <tr  class="td-alergi_obat">
                                        <th class="title"> Alergi Obat: </th>
                                        <td class="value"> <?php echo $data['alergi_obat']; ?></td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
                            <?php if($can_edit){ ?>
                            <a class="btn btn-sm btn-info"  href="<?php print_link("pendaftaran_poli/edit/$rec_id"); ?>">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <?php } ?>
                            <?php if($can_delete){ ?>
                            <a class="btn btn-sm btn-danger record-delete-btn mx-1"  href="<?php print_link("pendaftaran_poli/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                <i class="fa fa-times"></i> Delete
                            </a>
                            <?php } ?>
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
