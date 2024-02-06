<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("rawat_inap/add");
$can_edit = ACL::is_allowed("rawat_inap/edit");
$can_view = ACL::is_allowed("rawat_inap/view");
$can_delete = ACL::is_allowed("rawat_inap/delete");
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
                    <h4 class="record-title">View  Rawat Inap</h4>
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
                                    <tr  class="td-tanggal_masuk">
                                        <th class="title"> Tanggal Masuk: </th>
                                        <td class="value"> <?php echo $data['tanggal_masuk']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_pasien">
                                        <th class="title"> Nama Pasien: </th>
                                        <td class="value"> <?php echo $data['nama_pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-no_rekam_medis">
                                        <th class="title"> No Rekam Medis: </th>
                                        <td class="value"> <?php echo $data['no_rekam_medis']; ?></td>
                                    </tr>
                                    <tr  class="td-alamat">
                                        <th class="title"> Alamat: </th>
                                        <td class="value"> <?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr  class="td-jenis_kelamin">
                                        <th class="title"> Jenis Kelamin: </th>
                                        <td class="value"> <?php echo $data['jenis_kelamin']; ?></td>
                                    </tr>
                                    <tr  class="td-dokter_pengirim">
                                        <th class="title"> Dokter Pengirim: </th>
                                        <td class="value"><?php
                                            $usrnam  = "".USER_NAME;
                                            $id_user = "".USER_ID;
                                            $dbhost  = "".DB_HOST;
                                            $dbuser  = "".DB_USERNAME;
                                            $dbpass  = "".DB_PASSWORD;
                                            $dbname  = "".DB_NAME;
                                            $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                            $idtrace = "$id_user$usrnam";
                                            $Queryp = "SELECT * FROM data_dokter WHERE id_dokter='".$data['dokter_pengirim']."'";
                                            $ExecQueryp = MySQLi_query($koneksi, $Queryp);
                                            while ($Resultp = MySQLi_fetch_array($ExecQueryp)) {
                                            $namdok=$Resultp['nama_dokter'];
                                            }
                                        echo $namdok; ?></td>
                                    </tr>
                                    <tr  class="td-dokter_rawat_inap">
                                        <th class="title"> Dokter Rawat Inap: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_dokter/view/" . urlencode($data['dokter_rawat_inap'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['data_dokter_nama_dokter'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-tl">
                                        <th class="title"> Tl: </th>
                                        <td class="value"> <?php echo $data['tl']; ?></td>
                                    </tr>
                                    <tr  class="td-no_ktp">
                                        <th class="title"> No Ktp: </th>
                                        <td class="value"> <?php echo $data['no_ktp']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal_lahir">
                                        <th class="title"> Tanggal Lahir: </th>
                                        <td class="value"> <?php echo $data['tanggal_lahir']; ?></td>
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
                                    <tr  class="td-operator">
                                        <th class="title"> Operator: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-kamar_kelas">
                                        <th class="title"> Kamar Kelas: </th>
                                        <td class="value">  <?php
                                            if($data['kamar_kelas']=="" or $data['kamar_kelas']=="0"){ }else{
                                            $Queryk = "SELECT * FROM data_kelas WHERE id_kelas='".$data['kamar_kelas']."'";
                                            $ExecQueryk = MySQLi_query($koneksi, $Queryk);
                                            while ($Resultk = MySQLi_fetch_array($ExecQueryk)) {
                                            $namkel=$Resultk['nama_kelas'];
                                            }
                                        echo $namkel; }?>  </td>
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
                                    <tr  class="td-poli">
                                        <th class="title"> Poli: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_poli/view/" . urlencode($data['poli'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['data_poli_nama_poli'] ?>
                                            </a>
                                        </td>
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
                            <div class="dropup export-btn-holder mx-1">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-save"></i> Export
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <?php $export_print_link = $this->set_current_page_link(array('format' => 'print')); ?>
                                    <a class="dropdown-item export-link-btn" data-format="print" href="<?php print_link($export_print_link); ?>" target="_blank">
                                        <img src="<?php print_link('assets/images/print.png') ?>" class="mr-2" /> PRINT
                                        </a>
                                        <?php $export_pdf_link = $this->set_current_page_link(array('format' => 'pdf')); ?>
                                        <a class="dropdown-item export-link-btn" data-format="pdf" href="<?php print_link($export_pdf_link); ?>" target="_blank">
                                            <img src="<?php print_link('assets/images/pdf.png') ?>" class="mr-2" /> PDF
                                            </a>
                                            <?php $export_word_link = $this->set_current_page_link(array('format' => 'word')); ?>
                                            <a class="dropdown-item export-link-btn" data-format="word" href="<?php print_link($export_word_link); ?>" target="_blank">
                                                <img src="<?php print_link('assets/images/doc.png') ?>" class="mr-2" /> WORD
                                                </a>
                                                <?php $export_csv_link = $this->set_current_page_link(array('format' => 'csv')); ?>
                                                <a class="dropdown-item export-link-btn" data-format="csv" href="<?php print_link($export_csv_link); ?>" target="_blank">
                                                    <img src="<?php print_link('assets/images/csv.png') ?>" class="mr-2" /> CSV
                                                    </a>
                                                    <?php $export_excel_link = $this->set_current_page_link(array('format' => 'excel')); ?>
                                                    <a class="dropdown-item export-link-btn" data-format="excel" href="<?php print_link($export_excel_link); ?>" target="_blank">
                                                        <img src="<?php print_link('assets/images/xsl.png') ?>" class="mr-2" /> EXCEL
                                                        </a>
                                                    </div>
                                                </div>
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
