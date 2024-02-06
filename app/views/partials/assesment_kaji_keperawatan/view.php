<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("assesment_kaji_keperawatan/add");
$can_edit = ACL::is_allowed("assesment_kaji_keperawatan/edit");
$can_view = ACL::is_allowed("assesment_kaji_keperawatan/view");
$can_delete = ACL::is_allowed("assesment_kaji_keperawatan/delete");
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
                    <h4 class="record-title">View  Assesment Kaji Keperawatan</h4>
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
                        $rec_id = (!empty($data['id_kaji']) ? urlencode($data['id_kaji']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-id_kaji">
                                        <th class="title"> Id Kaji: </th>
                                        <td class="value"> <?php echo $data['id_kaji']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_pasien">
                                        <th class="title"> Nama Pasien: </th>
                                        <td class="value"> <?php echo $data['nama_pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-no_rekam_medis">
                                        <th class="title"> No Rekam Medis: </th>
                                        <td class="value"> <?php echo $data['no_rekam_medis']; ?></td>
                                    </tr>
                                    <tr  class="td-tgl_lahir">
                                        <th class="title"> Tgl Lahir: </th>
                                        <td class="value"> <?php echo $data['tgl_lahir']; ?></td>
                                    </tr>
                                    <tr  class="td-jenis_kelamin">
                                        <th class="title"> Jenis Kelamin: </th>
                                        <td class="value"> <?php echo $data['jenis_kelamin']; ?></td>
                                    </tr>
                                    <tr  class="td-tgl_masuk">
                                        <th class="title"> Tgl Masuk: </th>
                                        <td class="value"> <?php echo $data['tgl_masuk']; ?></td>
                                    </tr>
                                    <tr  class="td-perawat_pemeriksa">
                                        <th class="title"> Perawat Pemeriksa: </th>
                                        <td class="value"> <?php echo $data['perawat_pemeriksa']; ?></td>
                                    </tr>
                                    <tr  class="td-daftar_alergi">
                                        <th class="title"> Daftar Alergi: </th>
                                        <td class="value"> <?php echo $data['daftar_alergi']; ?></td>
                                    </tr>
                                    <tr  class="td-tanda_vital_kondisi_umum">
                                        <th class="title"> Tanda Vital Kondisi Umum: </th>
                                        <td class="value"> <?php echo $data['tanda_vital_kondisi_umum']; ?></td>
                                    </tr>
                                    <tr  class="td-BB">
                                        <th class="title"> Bb: </th>
                                        <td class="value"> <?php echo $data['BB']; ?></td>
                                    </tr>
                                    <tr  class="td-TD">
                                        <th class="title"> Td: </th>
                                        <td class="value"> <?php echo $data['TD']; ?></td>
                                    </tr>
                                    <tr  class="td-RR">
                                        <th class="title"> Rr: </th>
                                        <td class="value"> <?php echo $data['RR']; ?></td>
                                    </tr>
                                    <tr  class="td-HG">
                                        <th class="title"> Hg: </th>
                                        <td class="value"> <?php echo $data['HG']; ?></td>
                                    </tr>
                                    <tr  class="td-TB">
                                        <th class="title"> Tb: </th>
                                        <td class="value"> <?php echo $data['TB']; ?></td>
                                    </tr>
                                    <tr  class="td-suhu">
                                        <th class="title"> Suhu: </th>
                                        <td class="value"> <?php echo $data['suhu']; ?></td>
                                    </tr>
                                    <tr  class="td-scrining_nutrisi">
                                        <th class="title"> Scrining Nutrisi: </th>
                                        <td class="value"> <?php echo $data['scrining_nutrisi']; ?></td>
                                    </tr>
                                    <tr  class="td-perubahan_ukuran_pakaian">
                                        <th class="title"> Perubahan Ukuran Pakaian: </th>
                                        <td class="value"> <?php echo $data['perubahan_ukuran_pakaian']; ?></td>
                                    </tr>
                                    <tr  class="td-terlihat_kurus">
                                        <th class="title"> Terlihat Kurus: </th>
                                        <td class="value"> <?php echo $data['terlihat_kurus']; ?></td>
                                    </tr>
                                    <tr  class="td-makan_dlm_dua_minggu">
                                        <th class="title"> Makan Dlm Dua Minggu: </th>
                                        <td class="value"> <?php echo $data['makan_dlm_dua_minggu']; ?></td>
                                    </tr>
                                    <tr  class="td-mual_muntah">
                                        <th class="title"> Mual Muntah: </th>
                                        <td class="value"> <?php echo $data['mual_muntah']; ?></td>
                                    </tr>
                                    <tr  class="td-diare">
                                        <th class="title"> Diare: </th>
                                        <td class="value"> <?php echo $data['diare']; ?></td>
                                    </tr>
                                    <tr  class="td-anokresia">
                                        <th class="title"> Anokresia: </th>
                                        <td class="value"> <?php echo $data['anokresia']; ?></td>
                                    </tr>
                                    <tr  class="td-factor_pemberat">
                                        <th class="title"> Factor Pemberat: </th>
                                        <td class="value"> <?php echo $data['factor_pemberat']; ?></td>
                                    </tr>
                                    <tr  class="td-penurunan_fungsi">
                                        <th class="title"> Penurunan Fungsi: </th>
                                        <td class="value"> <?php echo $data['penurunan_fungsi']; ?></td>
                                    </tr>
                                    <tr  class="td-status_gizi">
                                        <th class="title"> Status Gizi: </th>
                                        <td class="value"> <?php echo $data['status_gizi']; ?></td>
                                    </tr>
                                    <tr  class="td-catatan_gizi">
                                        <th class="title"> Catatan Gizi: </th>
                                        <td class="value"> <?php echo $data['catatan_gizi']; ?></td>
                                    </tr>
                                    <tr  class="td-lokasi_nyeri">
                                        <th class="title"> Lokasi Nyeri: </th>
                                        <td class="value"> <?php echo $data['lokasi_nyeri']; ?></td>
                                    </tr>
                                    <tr  class="td-waktu_nyer">
                                        <th class="title"> Waktu Nyer: </th>
                                        <td class="value"> <?php echo $data['waktu_nyer']; ?></td>
                                    </tr>
                                    <tr  class="td-pencetus_saat_nyeri">
                                        <th class="title"> Pencetus Saat Nyeri: </th>
                                        <td class="value"> <?php echo $data['pencetus_saat_nyeri']; ?></td>
                                    </tr>
                                    <tr  class="td-type_nyeri">
                                        <th class="title"> Type Nyeri: </th>
                                        <td class="value"> <?php echo $data['type_nyeri']; ?></td>
                                    </tr>
                                    <tr  class="td-nyeri">
                                        <th class="title"> Nyeri: </th>
                                        <td class="value"> <?php echo $data['nyeri']; ?></td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
                            <?php if($can_edit){ ?>
                            <a class="btn btn-sm btn-info"  href="<?php print_link("assesment_kaji_keperawatan/edit/$rec_id"); ?>">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <?php } ?>
                            <?php if($can_delete){ ?>
                            <a class="btn btn-sm btn-danger record-delete-btn mx-1"  href="<?php print_link("assesment_kaji_keperawatan/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
