<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_pasien/add");
$can_edit = ACL::is_allowed("data_pasien/edit");
$can_view = ACL::is_allowed("data_pasien/view");
$can_delete = ACL::is_allowed("data_pasien/delete");
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
    <div  class=" p-2 mb-2">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Rekap Data Pasien</h4>
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
                    <div  class=" animated fadeIn page-content">
                        <div id="data_pasien-rekap_pasien-records">
                            <div id="page-report-body" class="table-responsive">
                                <style>
                                    /* Style the tab */
                                    .tab {
                                    overflow: hidden;
                                    /* border: 1px solid #ccf;*/
                                    background-color: #f1f1f1;
                                    }
                                    /* Style the buttons inside the tab */
                                    .tab button {
                                    background-color: inherit;
                                    float: left;
                                    border: none;
                                    outline: none;
                                    cursor: pointer;
                                    padding: 8px 10px;
                                    transition: 0.3s;
                                    font-size: 17px;
                                    }
                                    /* Change background color of buttons on hover */
                                    .tab button:hover {
                                    background-color: #ddd;
                                    }
                                    /* Create an active/current tablink class */
                                    .tab button.active {
                                    background-color: #ccc;
                                    }
                                    /* Style the tab content */
                                    .tabcontent {
                                    display: none;
                                    padding: 6px 12px;
                                    border: 1px solid #ccc;
                                    border-top: none;
                                    }
                                    .dropdown a.dropdown-item:hover {
                                    cursor: pointer;
                                    background-color: #F5F5DC;
                                    }
                                    table, th, td {
                                    border: 1px solid black;
                                    border-collapse: collapse;
                                    }
                                </style>
                                <?php
                                $sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
                                $usrnam  = "".USER_NAME;
                                $id_user = "".USER_ID;
                                $dbhost  = "".DB_HOST;
                                $dbuser  = "".DB_USERNAME;
                                $dbpass  = "".DB_PASSWORD;
                                $dbname  = "".DB_NAME;
                                $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                $idtrace = "$id_user$usrnam";
                                $linksite="".SITE_ADDR;
                                ?>
                                <div class="tab">
                                    <button class="tablinks" onclick="openResep(event, 'non')" id="nonracik">Raway Jalan</button>
                                    <button class="tablinks" onclick="openResep(event, 'racik')" id="racikan"> Rawat Inap</button>
                                    <button class="tablinks" onclick="openResep(event, 'igd')" id="racikan"> IGD</button>
                                    <button class="tablinks" onclick="openResep(event, 'operasi')" id="racikan"> Ruuang Operasi</button>
                                </div>   
                                <div id="non" class="tabcontent">
                                    <h3>Rawat Jalan</h3> 
                                    <table style="width:100%">
                                        <tr>
                                            <th  rowspan="2"><div align="center">RAWAT JALAN</div></th>
                                            <th  colspan="4" ><div align="center">KETERANGAN</div></th>
                                        </tr>
                                        <tr>
                                            <th ><div align="center">Pagi</div></th>
                                            <th ><div align="center">Siang/Sore</div></th>
                                            <th ><div align="center">Jumlah</div></th>
                                            <th ><div align="center">Dokter</div></th>
                                        </tr>
                                        <?php
                                        $appcek = mysqli_query($koneksi,"select * from data_poli where category='POLI'");
                                        $roapp = mysqli_num_rows($appcek );
                                        if ($roapp  <> 0) {
                                        while ($datapp = MySQLi_fetch_array($appcek)) {
                                        // $cekidpoli=$datapp['id_poli'];
                                        $queryc1 = mysqli_query($koneksi, "SELECT COUNT(*) AS jumd from data_dokter WHERE specialist='".$datapp['id_poli']."'")
                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                        $rowsc1 = mysqli_num_rows($queryc1);
                                        if ($rowsc1 <> 0) {
                                        $datnum1=mysqli_fetch_assoc($queryc1);
                                        $itungdl=$datnum1['jumd'];
                                        }else{
                                        $itungdl="0";
                                        }
                                        if($itungdl > 1){
                                        ?>
                                        <tr>
                                            <th rowspan="<?php echo $itungdl;?>"><div style="margin-left: 5px;">Poli <?php echo $datapp['nama_poli'];?></div></th>
                                            <?php
                                            $rowitung=1;
                                            $appcekdk = mysqli_query($koneksi,"select * from data_dokter WHERE specialist='".$datapp['id_poli']."'");
                                            $roappdk = mysqli_num_rows($appcekdk);
                                            if ($roappdk  <> 0) {
                                            while ($datappdk = MySQLi_fetch_array($appcekdk)) {
                                            //$cekiddok=$datappdk['id_dokter'];
                                            //$namadok=$datappdk['nama_dokter'];
                                            if($rowitung==1){
                                            //SELECT * FROM `appointment` WHERE `setatus`='Register' AND `tanggal_appointment`=2023-06-09; 
                                            //"SELECT COUNT(*) AS num FROM data_pasien"
                                            $queryc1 = mysqli_query($koneksi, "SELECT COUNT(*) AS numb1 from pendaftaran_poli WHERE `tanggal`='$sekarang' and dokter='".$datappdk['id_dokter']."'")
                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                            $rowsc1 = mysqli_num_rows($queryc1);
                                            if ($rowsc1 <> 0) {
                                            $datnum1=mysqli_fetch_assoc($queryc1);
                                            $app1=$datnum1['numb1'];
                                            }else{
                                            $app1="0";
                                            }
                                            ?>
                                            <td align="center">0</td>
                                            <td align="center">0</td>
                                            <td align="center"><?php echo $app1;?></td>
                                        <td align="center"><?php echo $datappdk['nama_dokter'];?></td></td>
                                    </tr>
                                    <?php }else{
                                    $queryc2 = mysqli_query($koneksi, "SELECT COUNT(*) AS numb2 from pendaftaran_poli WHERE `tanggal`='$sekarang' and dokter='".$datappdk['id_dokter']."'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                    $rowsc2 = mysqli_num_rows($queryc2);
                                    if ($rowsc2 <> 0) {
                                    $datnum2=mysqli_fetch_assoc($queryc2);
                                    $app2=$datnum2['numb2'];
                                    }else{
                                    $app2="0";
                                    }
                                    ?>
                                    <tr>
                                        <td align="center">0</td>
                                        <td align="center">0</td>
                                        <td align="center"><?php echo $app2;?></td>
                                        <td align="center"><?php echo $datappdk['nama_dokter'];?></td>
                                    </tr>            
                                    <?php }
                                    $rowitung=$rowitung + 1;
                                    } }
                                    }else{
                                    $appcekdka = mysqli_query($koneksi,"select * from data_dokter WHERE specialist='".$datapp['id_poli']."'");
                                    $roappdka = mysqli_num_rows($appcekdka);
                                    if ($roappdka  <> 0) {
                                    while ($datappdka = MySQLi_fetch_array($appcekdka)) {
                                    $queryc3 = mysqli_query($koneksi, "SELECT COUNT(*) AS numb3 from pendaftaran_poli WHERE `tanggal`='$sekarang' and dokter='".$datappdka['id_dokter']."'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                    $rowsc3 = mysqli_num_rows($queryc3);
                                    if ($rowsc3 <> 0) {
                                    $datnum3=mysqli_fetch_assoc($queryc3);
                                    $app3=$datnum3['numb3'];
                                    }else{
                                    $app3="0";
                                    }
                                    ?>
                                    <tr>
                                        <td ><div style="margin-left: 5px;">Poli <?php echo $datapp['nama_poli'];?></div></td>
                                        <td align="center">0</td>
                                        <td align="center">0</td>
                                        <td align="center"><?php echo $app3;?></td>
                                        <td align="center"><?php echo $datappdka['nama_dokter'];?></td>
                                    </tr>
                                    <?php } } }
                                    }
                                    }
                                    ?>
                                </table>
                            </div>
                            <div id="racik" class="tabcontent">
                                <h3>Rawat Inap</h3>               
                                <table style="width:100%">        
                                </tr>
                                <tr>
                                    <th ><div align="center">RAWAT INAP</div></th>
                                    <th ><div align="center">Pagi</div></th>
                                    <th ><div align="center">Siang/Sore</div></th>
                                    <th ><div align="center">Jumlah</div></th>
                                    <th ><div align="center">KET</div></th>
                                </tr>         
                                <?php
                                $appcekk = mysqli_query($koneksi,"select * from data_kamar");
                                $roappk = mysqli_num_rows($appcekk );
                                if ($roappk  <> 0) {
                                while ($datappk = MySQLi_fetch_array($appcekk)) {
                                ?>
                                <tr>
                                    <td ><div style="margin-left: 5px;"><?php echo $datappk['nama_kamar'];?></div></td>
                                    <td align="center">0</td>
                                    <td align="center">0</td>
                                    <td align="center">0</td>
                                    <td align="center">-</td>
                                </tr>   
                                <?php } }?>
                            </table>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function(){ 
                    });
                    function openResep(evt, cityName) {
                    var i, tabcontent, tablinks;
                    tabcontent = document.getElementsByClassName("tabcontent");
                    for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                    }
                    tablinks = document.getElementsByClassName("tablinks");
                    for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                    }
                    document.getElementById(cityName).style.display = "block";
                    evt.currentTarget.className += " active";
                    }
                    document.getElementById("nonracik").click();
                </script>
            </div>
        </div>
    </div>
</div>
</div>
</section>
