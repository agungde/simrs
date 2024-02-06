<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View Detil Kamar Perina</h4>
                    <div class=""><?php
                        if(isset($_POST['precord'])){
                        $fromdata=$_POST['fromdata'];
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        $ciphertext = $_POST['precord'];
                        $ciphertext=str_replace(' ', '+', $ciphertext);
                        $resep=$ciphertext;
                        $key="dermawangroup";
                        $c = base64_decode($ciphertext);
                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                        $iv = substr($c, 0, $ivlen);
                        $hmac = substr($c, $ivlen, $sha2len=32);
                        $ciphertext_raw = substr($c, $ivlen+$sha2len);
                        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                        if (hash_equals($hmac, $calcmac))// timing attack safe comparison
                        {
                        // echo $original_plaintext."\n";
                        }
                        $queryb = mysqli_query($koneksi, "select * from data_kamar_perina WHERE id_data_kamar_perina='$fromdata'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        $data   = mysqli_fetch_assoc($queryb);
                        $jumranjang=$data['jumlah_ranjang'];
                        $terisi=$data['terisi'];
                        for($a = 0; $a < $jumranjang; $a++){
                        $nom=$a + 1;
                        $post="nom$nom";
                        if(isset($_POST[$post])){
                        if($_POST[$post]==""){}else{
                        mysqli_query($koneksi,"UPDATE data_ranjang_perina SET no_$nom='isi' WHERE id_data_kamar='$fromdata'");
                        mysqli_query($koneksi,"UPDATE ranap_perina SET no_ranjang='No $nom' WHERE id='$original_plaintext'");
                        }
                        }
                        }
                        // mysqli_query($koneksi,"INSERT INTO `data_ranjang` (`jumlah_ranjang`,`id_data_kamar`) VALUES ('$jumlah_ranjang','$rec_id')"); 
                        mysqli_query($koneksi,"UPDATE ranap_perina SET kamar_kelas='".$data['kamar_kelas']."', nama_kamar='".$data['nama_kamar']."', no_kamar='".$data['no_kamar']."' WHERE id='$original_plaintext'");
                        $terisiplus=$terisi + 1;
                        $siasa=$jumranjang - $terisiplus;
                        mysqli_query($koneksi,"UPDATE data_kamar_perina SET sisa='$siasa', terisi='$terisiplus' WHERE id_data_kamar_perina='$fromdata'");
                        ?>
                        <script language="JavaScript">
                            alert('Daata Kamar Berhasil Di Proses');
                            document.location='<?php print_link("ranap_perina"); ?>';
                        </script>
                        <?php
                        }
                        ?>
                        <div></div>
                    </div>
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
                <div class="col-md-9 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-light p-3 animated fadeIn page-content">
                        <style>
                            /* Hide the default checkbox */
                            .containerchek input {
                            display: none;
                            }
                            .containerchek {
                            display: block;
                            position: relative;
                            cursor: pointer;
                            font-size: 20px;
                            user-select: none;
                            -webkit-tap-highlight-color: transparent;
                            }
                            /* Create a custom checkbox */
                            .checkmark {
                            position: relative;
                            top: 0;
                            left: 0;
                            height: 1.3em;
                            width: 1.3em;
                            background-color: #2196F300;
                            border-radius: 0.25em;
                            transition: all 0.25s;
                            }
                            /* When the checkbox is checked, add a blue background */
                            .containerchek input:checked ~ .checkmark {
                            background-color: #2196F3;
                            }
                            /* Create the checkmark/indicator (hidden when not checked) */
                            .checkmark:after {
                            content: "";
                            position: absolute;
                            transform: rotate(0deg);
                            border: 0.1em solid black;
                            left: 0;
                            top: 0;
                            width: 1.05em;
                            height: 1.05em;
                            border-radius: 0.25em;
                            transition: all 0.25s, border-width 0.1s;
                            }
                            /* Show the checkmark when checked */
                            .containerchek input:checked ~ .checkmark:after {
                            left: 0.45em;
                            top: 0.25em;
                            width: 0.25em;
                            height: 0.5em;
                            border-color: #fff0 white white #fff0;
                            border-width: 0 0.15em 0.15em 0;
                            border-radius: 0em;
                            transform: rotate(45deg);
                            }
                        </style>
                        <form id="data_kamar_perina-detile-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_kamar_perina/detile?csrf_token=$csrf_token") ?>" method="post">
                            <div>
                                <?php
                                $usrnam  = "".USER_NAME;
                                $id_user = "".USER_ID;
                                $dbhost  = "".DB_HOST;
                                $dbuser  = "".DB_USERNAME;
                                $dbpass  = "".DB_PASSWORD;
                                $dbname  = "".DB_NAME;
                                $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                $idtrace = "$id_user$usrnam";
                                if(!empty($_GET['precord'])){
                                $fromdata = $_GET['fromdata'];
                                $precord=$_GET['precord'];
                                $queryb = mysqli_query($koneksi, "select * from data_kamar_perina WHERE id_data_kamar_perina='$fromdata'")
                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
                                $rowsb = mysqli_num_rows($queryb);
                                if ($rowsb <> 0) {
                                }else{
                                ?>
                                <script language="JavaScript">
                                    alert('Dilarang Akses URL Tidak Valid');
                                    document.location='<?php print_link("ranap_perina"); ?>';
                                </script>
                                <?php 
                                }
                                $data   = mysqli_fetch_assoc($queryb);
                                $idkelas=$data['kamar_kelas'];
                                $que= mysqli_query($koneksi, "select * from data_kelas WHERE id_kelas='$idkelas'")
                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                                $datakel   = mysqli_fetch_assoc($que);
                                ?>
                                <div id="page-report-body" class="">
                                    <table class="table table-hover table-borderless table-striped">
                                        <!-- Table Body Start -->
                                        <tbody class="page-data" >
                                            <tr  class="td-kamar_kelas">
                                                <th class="title"> Kamar Kelas: </th>
                                                <td class="value">
                                                    <?php echo $datakel['nama_kelas'] ?>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr  class="td-nama_kamar">
                                            <th class="title"> Nama Kamar: </th>
                                            <td class="value">
                                                <span >
                                                    <?php
                                                    $id_user = "".USER_ID;
                                                    $dbhost  = "".DB_HOST;
                                                    $dbuser  = "".DB_USERNAME;
                                                    $dbpass  = "".DB_PASSWORD;
                                                    $dbname  = "".DB_NAME;
                                                    $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                    $sqlcek1 = mysqli_query($koneksi,"select * from nama_kamar_ranap_perina WHERE id='".$data['nama_kamar']."'");
                                                    $rows1 = mysqli_num_rows($sqlcek1);
                                                    if ($rows1 <> 0) {
                                                    $row= mysqli_fetch_assoc($sqlcek1); 
                                                    echo $row['nama_kamar'];
                                                    }else{
                                                    echo $data['nama_kamar']; 
                                                    }
                                                    //echo $data['nama_kamar']; 
                                                    ?> 
                                                </span>
                                            </td>
                                        </tr>
                                        <tr  class="td-no_kamar">
                                            <th class="title"> No Kamar: </th>
                                            <td class="value">
                                                <span >
                                                    <?php echo $data['no_kamar']; ?> 
                                                </span>
                                            </td>
                                        </tr>
                                        <tr  class="td-harga">
                                            <th class="title"> Harga: </th>
                                            <td class="value"><?php 
                                                $id_user = "".USER_ID;
                                                $dbhost  = "".DB_HOST;
                                                $dbuser  = "".DB_USERNAME;
                                                $dbpass  = "".DB_PASSWORD;
                                                $dbname  = "".DB_NAME;
                                                $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                $sql = mysqli_query($koneksi,"select * from data_kelas WHERE id_kelas='".$data['kamar_kelas']."'");
                                                while ($row=mysqli_fetch_array($sql)){
                                                $hargakamar=$row['harga'];
                                                $hargakamarber=$row['harga_ranap_perina'];
                                                }
                                                if($hargakamarber=="" or $hargakamarber=="0"){
                                                $hargakamar=$hargakamar;
                                                }else{
                                                $hargakamar=$hargakamarber;
                                                }
                                                echo number_format($hargakamar,0,",",".");
                                            ?></td>
                                        </tr>            
                                        <tr  class="td-jumlah_ranjang">
                                            <th class="title"> Jumlah Ranjang: </th>
                                            <td class="value">
                                                <span >
                                                    <?php echo $data['jumlah_ranjang']; ?> 
                                                </span>
                                            </td>
                                        </tr>
                                        <tr  class="td-terisi">
                                            <th class="title"> Terisi: </th>
                                            <td class="value"> <?php echo $data['terisi']; ?></td>
                                        </tr>
                                        <tr  class="td-sisa">
                                            <th class="title"> Sisa: </th>
                                            <td class="value"><?php
                                                if($data['terisi']=="" or $data['terisi']=="0" and $data['sisa']=="" or $data['sisa']=="0"){
                                                echo $data['jumlah_ranjang']; 
                                                }else{
                                                echo $data['sisa']; 
                                                }
                                            ?></td>
                                        </tr>
                                    </tbody>
                                    <!-- Table Body End -->
                                </table>
                            </div>
                            <div align="center"><h3>Pilih Nomor Ranjang</h3></div>
                            <div align="center"><h4><img src="<?php print_link("assets/images/bed.png") ?>" width="35px"
                            height="35px"/> = isi </h4></div>
                            <div id="appointment-liveap-records">    
                                <div id="page-report-body" class="table-responsive">
                                    <table class="table  table-striped table-sm text-left">
                                        <thead class="table-header bg-success text-dark"><tr><input value="<?php echo $precord;?>" type="hidden" name="precord" ><input value="<?php echo $fromdata;?>" type="hidden" name="fromdata"><?php
                                            $jumranjang=$data['jumlah_ranjang'];
                                            $rec_id=$data['id_data_kamar_perina'];
                                            $Query = "SELECT * FROM data_ranjang_perina WHERE id_data_kamar='$rec_id'";
                                            $ExecQuery = MySQLi_query($koneksi, $Query);   
                                            $hitung=0;
                                            //while ($Result = MySQLi_fetch_array($ExecQuery)) {
                                            // $hitung=$hitung + 1;
                                            // $jumran=$Result['jumlah_ranjang'];
                                            for($a = 0; $a < $jumranjang; $a++){
                                            $nom=$a + 1;
                                            echo "<th >Nomor $nom</th>";
                                            }?>
                                        </tr>
                                    </thead>
                                    <tbody class="page-data" id="page-data-list-page-8rt4hbl3u9f5">
                                        <tr>
                                            <?php
                                            while ($Result = MySQLi_fetch_array($ExecQuery)) {
                                            for($b = 0; $b < $jumranjang; $b++){
                                            $nob=$b + 1;
                                            $dat="no_$nob";
                                            if($Result[$dat]==""){
                                            // echo "<td>Kosong</td>";
                                            echo "<td>
                                                <label class=\"containerchek\">
                                                    <input value=\"$nob\" type=\"checkbox\" name=\"nom$nob\" class=\"checkoption\">
                                                        <div class=\"checkmark\"></div>
                                                    </label>
                                                </td>"; 
                                                }else{
                                                ?>
                                                <td><img src="<?php print_link("assets/images/bed.png") ?>" width="35px"
                                                height="35px"/></td>
                                                <?php
                                                }
                                                }
                                                }
                                                ?>
                                            </tr>  </tbody>
                                        </table>                                           
                                    </div></div>
                                    <div class="p-3 d-flex">
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="form-group form-submit-btn-holder text-center mt-3">
                                    <div class="form-ajax-status"></div>
                                    <button class="btn btn-primary" type="submit">
                                        Submit
                                        <i class="fa fa-send"></i>
                                    </button>
                                </div>
                            </form>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                $('.checkoption').click(function() {
                                $('.checkoption').not(this).prop('checked', false);
                                });
                                });
                            </script> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
