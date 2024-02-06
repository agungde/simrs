<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("hasil_lab/add");
$can_edit = ACL::is_allowed("hasil_lab/edit");
$can_view = ACL::is_allowed("hasil_lab/view");
$can_delete = ACL::is_allowed("hasil_lab/delete");
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
                    <h4 class="record-title">View  Hasil Lab</h4>
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
                        $rec_id = (!empty($data['id_hasil_lab']) ? urlencode($data['id_hasil_lab']) : null);
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
                                    <tr  class="td-no_hp">
                                        <th class="title"> No Hp: </th>
                                        <td class="value"> <?php echo $data['no_hp']; ?></td>
                                    </tr>
                                    <tr  class="td-keluhan">
                                        <th class="title"> Keluhan: </th>
                                        <td class="value"> <?php echo $data['keluhan']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_poli">
                                        <th class="title"> Nama Poli: </th>
                                        <td class="value"> <?php echo $data['nama_poli']; ?></td>
                                    </tr>
                                    <tr  class="td-jenis_pemeriksaan">
                                        <th class="title"> Jenis Pemeriksaan: </th>
                                        <td class="value"> <?php echo $data['jenis_pemeriksaan']; ?></td>
                                    </tr>
                                    <tr  class="td-diagnosa">
                                        <th class="title"> Diagnosa: </th>
                                        <td class="value"> <?php echo $data['diagnosa']; ?></td>
                                    </tr>
                                    <tr  class="td-pasien">
                                        <th class="title"> Pasien: </th>
                                        <td class="value"> <?php echo $data['pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-total_harga">
                                        <th class="title"> Total Harga: </th>
                                        <td class="value"> <?php echo $data['total_harga']; ?></td>
                                    </tr>
                                    <tr  class="td-dokter_pengirim">
                                        <th class="title"> Dokter Pengirim: </th>
                                        <td class="value"> <?php echo $data['dokter_pengirim']; ?></td>
                                    </tr>
                                    <tr  class="td-id_transaksi">
                                        <th class="title"> Id Transaksi: </th>
                                        <td class="value"> <?php echo $data['id_transaksi']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_pemeriksaan">
                                        <th class="title"> Nama Pemeriksaan: </th>
                                        <td class="value"> <?php echo $data['nama_pemeriksaan']; ?></td>
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
                    <div class=""><div>
                        <?php
                        if(!empty($_GET['hasil'])){
                        $hasil=$_GET['hasil'];
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        //$koneksi=open_connection();
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        ?>
                        <table class="table  table-striped table-sm text-left">
                            <thead class="table-header bg-light">
                                <tr>
                                    <th  class="td-nama_pemeriksaan"> Nama Pemeriksaan</th>
                                    <th  class="td-nilai_rujukan"> Nilai Rujukan</th>
                                    <th  class="td-hasil_pemeriksaan"> Hasil Pemeriksaan</th>
                                    <th class="td-btn"></th>
                                </tr>
                            </thead>
                            <tbody class="page-data" >
                                <!--record-->
                                <?php
                                $queryb = mysqli_query($koneksi, "SELECT * FROM data_hasil_lab  WHERE id_hasil_lab='$hasil'")
                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                // ambil jumlah baris data hasil query
                                $rowsb = mysqli_num_rows($queryb);
                                if ($rowsb <> 0) {
                                while ($row=mysqli_fetch_array($queryb)){
                                $nama_pemeriksaan=$row['nama_pemeriksaan'];
                                $nilai_rujukan=$row['nilai_rujukan'];
                                $hasil_pemeriksaan=$row['hasil_pemeriksaan'];
                                ?>
                                <tr>
                                    <td class="td-nama_pemeriksaan">
                                        <span>
                                            <?php echo $nama_pemeriksaan;?>  
                                        </span>
                                    </td>
                                    <td class="td-nilai_rujukan">
                                        <span  >
                                            <?php echo $nilai_rujukan;?>  
                                        </span>
                                    </td>
                                    <td class="td-hasil_pemeriksaan">
                                        <span >
                                            <?php echo $hasil_pemeriksaan;?> 
                                        </span>
                                    </td>
                                </tr>
                                <?php  
                                }
                                }
                                ?>
                                <!--endrecord-->
                            </tbody>
                            <tbody class="search-data" > </tbody>
                        </table>
                        <?php
                        }
                        ?> 
                    </div>
                    </div><div class=""><div align="center"></br>
                    <?php 
                    $ciphertext = $_GET['hasil'];
                    $key="dermawangroup";
                    $plaintext = "$ciphertext";
                    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                    $iv = openssl_random_pseudo_bytes($ivlen);
                    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                    ?>
                    <a class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("hasil_lab/print?csrf_token=$csrf_token&precord=$ciphertext");?>">
                    <i class="fa fa-send"></i>Print Hasil Lab</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>
