<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("nama_pemeriksaan_lab/add");
$can_edit = ACL::is_allowed("nama_pemeriksaan_lab/edit");
$can_view = ACL::is_allowed("nama_pemeriksaan_lab/view");
$can_delete = ACL::is_allowed("nama_pemeriksaan_lab/delete");
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
                    <h4 class="record-title">View  Nama Pemeriksaan Lab</h4>
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
                                    <tr  class="td-jenis_pemeriksaan">
                                        <th class="title"> Jenis Pemeriksaan: </th>
                                        <td class="value"><?php //echo $data['diagnosa'];
                                            $id_user = "".USER_ID;
                                            $dbhost  = "".DB_HOST;
                                            $dbuser  = "".DB_USERNAME;
                                            $dbpass  = "".DB_PASSWORD;
                                            $dbname  = "".DB_NAME;
                                            //$koneksi=open_connection();
                                            $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                            $idjen=$data['jenis_pemeriksaan'];
                                            if($idjen=="" or $idjen=="0"){
                                            }else{
                                            $queryd = mysqli_query($koneksi, "SELECT * from jenis_pemeriksaan_lab WHERE id='$idjen'")
                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                            $rowsd = mysqli_num_rows($queryd);
                                            if ($rowsd <> 0) {
                                            $datacekd= mysqli_fetch_assoc($queryd);
                                            $namjen=$datacekd['jenis_pemeriksaan'];
                                            }else{
                                            $namjen="" ;
                                            }
                                            echo $namjen;
                                            }
                                        ?></td>
                                    </tr>
                                    <tr  class="td-nama_pemeriksaan">
                                        <th class="title"> Nama Pemeriksaan: </th>
                                        <td class="value"> <?php echo $data['nama_pemeriksaan']; ?></td>
                                    </tr>
                                    <tr  class="td-nilai_rujukan">
                                        <th class="title"> Nilai Rujukan: </th>
                                        <td class="value"> <?php echo $data['nilai_rujukan']; ?></td>
                                    </tr>
                                    <tr  class="td-satuan">
                                        <th class="title"> Satuan: </th>
                                        <td class="value"> <?php echo $data['satuan']; ?></td>
                                    </tr>
                                    <tr  class="td-harga">
                                        <th class="title"> Harga: </th>
                                        <td class="value"><?php echo number_format($data['harga'],0,",","."); ?></td>
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
                                                <?php if($can_edit){ ?>
                                                <a class="btn btn-sm btn-info"  href="<?php print_link("nama_pemeriksaan_lab/edit/$rec_id"); ?>">
                                                    <i class="fa fa-edit"></i> Edit
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
