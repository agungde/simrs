<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_tindakan/add");
$can_edit = ACL::is_allowed("data_tindakan/edit");
$can_view = ACL::is_allowed("data_tindakan/view");
$can_delete = ACL::is_allowed("data_tindakan/delete");
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
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-white p-3 mb-2">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Data Tindakan</h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="p-3 animated fadeIn page-content">
                        <?php
                        $linksite="".SITE_ADDR;
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        if(!empty($_GET['detile_precord'])){
                        $iddaftar=$_GET['detile_precord'];
                        if(!empty($_GET['pasienpoli'])){
                        $idpoli=$_GET['pasienpoli'];
                        $pasienpoli=" or id_daftar='$idpoli'";
                        }else{
                        $pasienpoli="";
                        }
                        if(!empty($_GET['pasienigd'])){
                        $idigd=$_GET['pasienigd'];
                        $pasienigd=" or id_daftar='$idigd'";
                        }else{
                        $pasienigd="";
                        }
                        $trace=$_GET['trace'];
                        if($trace=="IGD"){
                        $trace="igd";
                        $qutrace = mysqli_query($koneksi, "select * from igd WHERE id_igd='$iddaftar'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }else if($trace=="POLI"){
                        $trace="poli";
                        $qutrace = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$iddaftar'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }else if($trace=="RAWAT INAP"){
                        $trace="rawat_inap";
                        $qutrace = mysqli_query($koneksi, "select * from rawat_inap WHERE id='$iddaftar'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }                       
                        // ambil jumlah baris data hasil query
                        $rotrace = mysqli_num_rows($qutrace);
                        if ($rotrace <> 0) {
                        $row   = mysqli_fetch_assoc($qutrace); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }
                        $queryb = mysqli_query($koneksi, "select * from data_tindakan WHERE id_daftar='".$_GET['detile_precord']."' $pasienigd $pasienpoli")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                        ?>
                        <div id="page-report-body" class="table-responsive">
                            <table class=" bg-white">
                                <tr><td>
                                    <table >
                                        <tr >
                                            <th align="left">No Rekam Medis: </th>
                                            <td >&nbsp;&nbsp;
                                                <?php echo $no_rekam_medis; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th align="left">Nama Pasien: </th>
                                            <td >&nbsp;&nbsp;
                                                <?php echo $nama_pasien; ?> 
                                            </td>
                                        </tr>           
                                        <tr>
                                            <th align="left"> Alamat: </th>
                                            <td >&nbsp;&nbsp;
                                                <?php echo $alamat; ?> 
                                            </td>
                                        </tr>           
                                    </table>
                                </td>
                                <td >  
                                    <table >
                                        <tr>
                                            <th align="left">&nbsp;&nbsp;  Tanggal Lahir</th>
                                            <td >
                                                &nbsp;&nbsp; <?php echo $tanggal_lahir; ?> 
                                            </td>
                                        </tr> 
                                        <tr>
                                            <th align="left">&nbsp;&nbsp; Umur: </th>
                                            <td >&nbsp;&nbsp;
                                                <?php echo $umur; ?> 
                                            </td>
                                        </tr>  
                                        <tr>
                                            <th align="left">&nbsp;&nbsp; Jenis Kelamin: </th>
                                            <td >&nbsp;&nbsp;
                                                <?php echo $jenis_kelamin; ?> 
                                            </td>
                                        </tr> 
                                    </table>         
                                </td>  
                            </tr>
                        </table>   
                    </div>
                    <div id="data_tindakan-list-records">
                        <div id="page-report-body" class="table-responsive">
                            <table class="table  table-sm text-left">
                                <thead class="table-header bg-success text-dark">
                                    <tr>
                                        <th  class="td-tanggal"> Tanggal</th>
                                        <th  class="td-pasien"> Pasien</th>
                                        <th  class="td-tindakan"> Tindakan</th>
                                        <th  class="td-nama_tindakan"> Nama Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <!--record-->
                                    <?php
                                    $rowsb = mysqli_num_rows($queryb);
                                    if ($rowsb <> 0) {
                                    while ($rowii=mysqli_fetch_array($queryb)){
                                    ?>
                                    <tr>
                                        <td class="td-tanggal"> <?php echo $rowii['tanggal']; ?></td>
                                        <td class="td-pasien"> <?php echo $rowii['pasien']; ?></td>
                                        <td class="td-tindakan"> <?php echo $rowii['tindakan']; ?></td>
                                        <td class="td-nama_tindakan"> <?php echo $rowii['nama_tindakan']; ?></td>
                                    </tr>
                                    <?php 
                                    }         
                                    $kosong=""; 
                                    }else{
                                    $kosong="Ya"; 
                                    }
                                    ?>
                                    <!--endrecord-->
                                </tbody>
                                <tbody class="search-data" id="search-data-<?php echo $page_element_id; ?>"></tbody>
                            </table>
                            <?php 
                            if($kosong=="Ya"){
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
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
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
