<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("antrian/add");
$can_edit = ACL::is_allowed("antrian/edit");
$can_view = ACL::is_allowed("antrian/view");
$can_delete = ACL::is_allowed("antrian/delete");
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
    <div  class="">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class=" animated fadeIn page-content">
                        <?php
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $queryc = mysqli_query($koneksi, "SELECT  * FROM user_login where id_userlogin='$id_user'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsc = mysqli_num_rows($queryc);
                        // cek hasil query
                        // jika "no_antrian" sudah ada
                        if ($rowsc <> 0) {
                        // ambil data hasil query
                        $datac = mysqli_fetch_assoc($queryc);
                        $loket=$datac['loket'];
                        }
                        //$loket =$_SESSION[APP_ID.'user_data']['loket'];
                        //$loketcek=$_SESSION[APP_ID.'user_data']['loket'];
                        if($loket=="" or $loket=="0"){
                        $loket="1";
                        }else{
                        //if( isset($_SESSION['user_data']['loket']) ) {
                        //   $loket =$_SESSION['user_data']['loket'];
                        //}else{
                        $loket=$loket;
                        // } 
                        }
                        function audio_list()
                        {
                        $output=array();
                        $directory = 'assets/audio/';
                        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
                        foreach($scanned_directory as $r)
                        {
                        $ext=pathinfo($r,PATHINFO_EXTENSION);
                        if(in_array($ext,array("MP3","mp3","wav")))
                        {
                        $explode=explode(".",$r);
                        $ID=$explode[0];
                        $output[]=array(
                        'path'=>$directory.$r,
                        'file'=>$r,
                        'ID'=>$ID,
                        );
                        }
                        }
                        return $output;
                        } 
                        echo "<div class=\"audio\">";
                            $list=audio_list();
                            if(!empty($list))
                            {
                            foreach($list as $a)
                            {
                            ?> 
                            <audio id="audio<?php echo $a['ID'];?>" class="audioitem" src="<?php print_link("".$a['path']) ?>"></audio>
                            <?php
                            }
                            }  
                        echo "</div>";
                        ?><style>
                            .rowder::after {
                            content: "";
                            clear: both;
                            display: block;
                            margin: 5px;
                            }
                            [class*="coll-"] {
                            float: left;
                            padding: 5px;
                            }
                            .coll-1 {width: 8.33%;}
                            .coll-2 {width: 16.66%;}
                            .coll-3 {width: 25%;}
                            .coll-4 {width: 33.33%;}
                            .coll-5 {width: 41.66%;}
                            .coll-6 {width: 50%;}
                            .coll-7 {width: 58.33%;}
                            .coll-8 {width: 66.66%;}
                            .coll-9 {width: 75%;}
                            .coll-10 {width: 83.33%;}
                            .coll-11 {width: 91.66%;}
                            .coll-12 {width: 100%;}
                            .round3 {
                            border: 2px solid #DCDCDC;
                            border-radius: 12px;
                            padding: 5px;
                            }
                            /* Style the tab */
                            .tab {
                            overflow: hidden;
                            /* border: 1px solid #ccf;*/
                            background-color: Orchid;
                            border-radius: 8px;
                            font-weight: bold;  
                            color: white;
                            }
                            /* Style the buttons inside the tab */
                            .tab button {
                            background-color: LightSalmon;
                            float: left;
                            border: none;
                            outline: none;
                            cursor: pointer;
                            color: white;
                            border-radius: 8px;
                            font-weight: bold; 
                            padding: 8px 10px;
                            transition: 0.3s;
                            font-size: 17px;
                            }
                            /* Change background color of buttons on hover */
                            .tab button:hover {
                            background-color: Orchid;
                            border-radius: 8px;
                            font-weight: bold;                        
                            }
                            /* Create an active/current tablink class */
                            .tab button.active {
                            background-color: BlueViolet;
                            color: white;
                            border-radius: 8px;
                            font-weight: bold;
                            }
                            /* Style the tab content */
                            .tabcontent {
                            display: none;
                            padding: 6px 12px;
                            border: 1px solid #ccc;
                            border-top: none;
                            border-radius: 8px;
                            }
                            .dropdown a.dropdown-item:hover {
                            cursor: pointer;
                            background-color: #F5F5DC;
                            }                            
                        </style>
                        <?php
                        $warna = array("BlueViolet",
                        "Coral",
                        "DarkSalmon",
                        "DarkSlateBlue",
                        "DarkViolet",
                        "LightSalmon",
                        "MediumOrchid",
                        "MediumPurple",
                        "MediumSlateBlue",
                        "DarkOrchid",
                        "RebeccaPurple",
                        "SlateBlue",
                        "RebeccaPurple",
                        "BurlyWood",
                        "IndianRed");   
                        $sistem =sisten_antri();
                        foreach($sistem as $b)
                        {
                        $sistemantrian= $b['sistemon'];  
                        $sistemsuara= $b['sistemsuara']; 
                        $sistemloket= $b['sistemloket']; 
                        }
                        //echo "Tes ".$sistemantrian;
                        //$sistemantrian=$sistem["0"];  
                        ?> 
                        <link rel="stylesheet" href="<?php print_link("assets/css/style.css") ?>"> 
                            <center>
                                <main class="flex-shrink-0">       
                                    <div class="container pt-2">
                                        <div class="row justify-content-lg-center">
                                            <div class="px-2 py-2 mb-2 bg-white rounded-2 shadow-sm">
                                                <!-- judul halaman -->
                                                <div class="d-flex align-items-center me-md-auto">
                                                    <div class="tab">
                                                        <?php
                                                        $w=0;
                                                        $query = mysqli_query($koneksi, "SELECT * FROM data_bank  
                                                        WHERE type='1'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                        $kode=$row['kode'];
                                                        $namaan=$row['nama_bank'];
                                                        ?>
                                                        <button class="tablinks" onclick="openAntrian(event, 'an-<?php echo $kode;?>')" id="antrian-<?php echo $kode;?>"><i class="fa fa-microphone "></i> Panggilan Antrian <?php echo $namaan;?></button>
                                                        <?php  $w++;
                                                        }?>
                                                    </div>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </main>
                            </center>
                            <?php
                            $x=0;
                            $query = mysqli_query($koneksi, "SELECT * FROM data_bank  
                            WHERE type='1'")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                            while ($row = mysqli_fetch_assoc($query)) {
                            $kode=$row['kode'];
                            $namaan=$row['nama_bank'];
                            ?>      
                            <div id="an-<?php echo $kode;?>" class="tabcontent">     
                                <div class="col ">
                                    <h4 class="record-title" style="border-radius: 8px; background-color: <?php echo $warna[$x];?>; color: white; padding:3px; font-weight: bold;"> &nbsp; <i class="fa fa-microphone "></i> Panggilan Antrian <?php echo $namaan; $x++;?></h4>
                                </div>
                                <div class="p-2 mb-2">
                                    <div class="row">
                                        <!-- menampilkan informasi jumlah antrian -->
                                        <div class="col-md-3">
                                            <div class="round3">
                                                <div></div>
                                                <div align="center" style="border-radius: 8px; background-color: <?php echo $warna[4];?>; color: white; padding:3px; font-weight: bold;"><b><i class="fa fa-users "></i> Jumlah Antrian</b></div>
                                                <div></div>
                                                <div align="center"><h1 id="jumlah-antrian-<?php echo $kode;?>" class="fs-3 text-warning mb-1"></h1></div>
                                            </div> 
                                        </div>
                                        <!-- menampilkan informasi nomor antrian yang sedang dipanggil -->
                                        <div class="col-sm-3">
                                            <div class="round3">
                                                <div></div>
                                                <div align="center" style="border-radius: 8px; background-color: <?php echo $warna[5];?>; color: white; padding:3px; font-weight: bold;"><b><i class="fa fa-user "></i> Antrian Sekarang</b></div>
                                                <div></div>
                                                <div align="center"><h1 id="antrian-sekarang-<?php echo $kode;?>" class="fs-3 text-success mb-1"></h1></div>
                                            </div> 
                                        </div>
                                        <!-- menampilkan informasi nomor antrian yang akan dipanggil selanjutnya -->
                                        <div class="col-sm-3">
                                            <div class="round3">
                                                <div></div>
                                                <div align="center" style="border-radius: 8px; background-color: <?php echo $warna[6];?>; color: white; padding:3px; font-weight: bold;"><b><i class="fa fa-user-plus "></i> Antrian Selanjutnya</b></div>
                                                <div></div>
                                                <div align="center"><h1 id="antrian-selanjutnya-<?php echo $kode;?>" class="fs-3 text-info mb-1"></h1></div>
                                            </div> 
                                        </div>
                                        <!-- menampilkan informasi jumlah antrian yang belum dipanggil -->
                                        <div class="col-sm-3">
                                            <div class="round3">
                                                <div></div>
                                                <div align="center" style="border-radius: 8px; background-color: <?php echo $warna[7];?>; color: white; padding:3px; font-weight: bold;"><b><i class="fa fa-user-times "></i> Sisa Antrian</b></div>
                                                <div></div>
                                                <div align="center"><h1 id="sisa-antrian-<?php echo $kode;?>" class="fs-3 text-danger mb-1"></h1></div>     
                                            </div> 
                                        </div>
                                    </div> 
                                </div> 
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body p-1">
                                        <table id="tabel-antrian-<?php echo $kode;?>" class="table table-bordered table-striped table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>NO.</th>
                                                    <th>Nomor Antrian</th>
                                                    <th>Status</th>
                                                    <th>Panggil</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>    
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                    // tampilkan informasi antrian
                                    $('#jumlah-antrian-<?php echo $kode;?>').load('<?php print_link("get_jumlah_antrian.php?kode=$kode") ?><?php echo $kode;?>');
                                    $('#antrian-sekarang-<?php echo $kode;?>').load('<?php print_link("get_antrian_sekarang.php?kode=$kode") ?>');
                                    $('#antrian-selanjutnya-<?php echo $kode;?>').load('<?php print_link("get_antrian_selanjutnya.php?kode=$kode") ?>');
                                    $('#sisa-antrian-<?php echo $kode;?>').load('<?php print_link("get_sisa_antrian.php?kode=$kode") ?>');
                                    // menampilkan data antrian menggunakan DataTables
                                    var table = $('#tabel-antrian-<?php echo $kode;?>').DataTable({
                                    "lengthChange": false,              // non-aktifkan fitur "lengthChange"
                                    "searching": false,                 // non-aktifkan fitur "Search"
                                    "ajax": "<?php print_link("get_antrian.php?kode=$kode") ?>",          // url file proses tampil data dari database
                                    // menampilkan data
                                    "columns": [{
                                    "data": "nom",
                                    "width": '50px',
                                    "className": 'text-center'
                                    },
                                    {
                                    "data":"antriantabel",
                                    "width": '50px',
                                    "className": 'text-center'
                                    },
                                    {
                                    "data": "status",
                                    "visible": false
                                    },
                                    {
                                    "data": null,
                                    "orderable": false,
                                    "searchable": false,
                                    "width": '100px',
                                    "className": 'text-center',
                                    "render": function(data, type, row) {
                                    // jika tidak ada data "status"
                                    if (data["status"] === "") {
                                    // sembunyikan button panggil
                                    var btn = "-";
                                    } 
                                    // jika data "status = 0"
                                    else if (data["status"] === "0") {
                                    // tampilkan button panggil
                                    var btn = "<button class=\"btn btn-success btn-sm rounded-circle\"><i class=\"fa fa-microphone\"></i></button>";
                                    } 
                                    // jika data "status = 1"
                                    else if (data["status"] === "1") {
                                    // tampilkan button ulangi panggilan
                                    var btn = "<button class=\"btn btn-secondary btn-sm rounded-circle\"><i class=\"fa fa-microphone\"></i></button>";
                                    };
                                    return btn;
                                    }
                                    },
                                    ],
                                    "order": [
                                    [0, "asc"]             // urutkan data berdasarkan "no_antrian" secara descending
                                    ],
                                    "iDisplayLength": 5,     // tampilkan 10 data per halaman
                                    });
                                    // panggilan antrian dan update data
                                    $('#tabel-antrian-<?php echo $kode;?> tbody').on('click', 'button', function(nomor) {
                                    // ambil data dari datatables 
                                    var data = table.row($(this).parents('tr')).data();
                                    // buat variabel untuk menampilkan data "id"
                                    var ids = data["id"];
                                    var nomor=data["no_antrian"];
                                    var kodanz=data["kode"];
                                    var kodpolz=data["kodepol"];
                                    // buat variabel untuk menampilkan audio bell antrian
                                    let kodan = kodanz.toLowerCase();
                                    let kodpol = kodpolz.toLowerCase();
                                    var bell = document.getElementById('tingtung');
                                    var noantri = document.getElementById('audioantrian');
                                    var pkodan = document.getElementById('audio'+kodan);
                                    var pkodpol = document.getElementById('audio'+kodpol);  
                                    var konter = document.getElementById('audiocounter'); 
                                    var paloket = document.getElementById('audioloket'); 
                                    //alert('Tes '+nomor);
                                    var mokonter = document.getElementById('audio<?php echo $loket;?>'); 
                                    // mainkan suara bell antrian
                                    bell.pause();
                                    bell.currentTime = 0;
                                    bell.play();
                                    // set delay antara suara bell dengan suara nomor antrian
                                    durasi_bell = bell.duration * 730;
                                    // mainkan suara nomor antrian
                                    <?php 
                                    //////////////////////////////////// online ////////////////////
                                    if($sistemantrian=="online"){
                                    ?>
                                    setTimeout(function() {
                                    responsiveVoice.speak("Nomor Antrian, " + data["antriantabel"]+", menuju, Loket, <?php echo $loket;?>", "Indonesian <?php echo $sistemsuara;?>", {
                                    rate: 0.9,
                                    pitch: 1,
                                    volume: 1
                                    });
                                    }, durasi_bell);
                                    <?php
                                    /////////////////////end online /////////////////////
                                    }else{
                                    ?>
                                    setTimeout(function() {
                                    // panggil_nomor(nomor);
                                    noantri.pause();
                                    noantri.currentTime = 0;
                                    noantri.play();
                                    //panggil_nomor(nomor);
                                    setTimeout(function(){
                                    panggil_kode();
                                    },1300);
                                    }, durasi_bell);
                                    function panggil_kode()
                                    {
                                    pkodan.pause();
                                    pkodan.currentTime = 0;
                                    pkodan.play();
                                    setTimeout(function(){   
                                    panggil_pol();
                                    },500);
                                    }   
                                    function panggil_pol()
                                    {
                                    setTimeout(function(){
                                    pkodpol.pause();
                                    pkodpol.currentTime = 0;
                                    pkodpol.play();
                                    panggil_nomor();
                                    },200);
                                    }
                                    function panggil_nomor()
                                    {
                                    if(nomor > 20) // Di audio file ada audio dari 1-20, jadi kita filter mulai dari 21
                                    {
                                    }else{
                                    var pnomor = document.getElementById('audio'+nomor); 
                                    setTimeout(function(){   
                                    pnomor.pause();
                                    pnomor.currentTime = 0;
                                    pnomor.play();
                                    setTimeout(function(){ 
                                    pkonter();
                                    },500);
                                    },500);
                                    }   
                                    }
                                    function pkonter()
                                    {
                                    setTimeout(function(){  
                                    <?php
                                    if($sistemloket=="loket"){
                                    ?>
                                    paloket.pause();
                                    paloket.currentTime = 0;
                                    paloket.play();  
                                    <?php }else{?>
                                    konter.pause();
                                    konter.currentTime = 0;
                                    konter.play();      
                                    <?php }?>
                                    setTimeout(function(){  
                                    ploket();
                                    },500); 
                                    },500);   
                                    }
                                    function ploket()
                                    {   
                                    mokonter.pause();
                                    mokonter.currentTime = 0;
                                    mokonter.play(); 
                                    }
                                    <?php }?>
                                    /////////////////////////
                                    // proses update data
                                    $.ajax({
                                    type: "POST",               // mengirim data dengan method POST
                                    url: "<?php print_link("update.php") ?>",          // url file proses update data
                                    data: { pid: ids, lok: <?php echo $loket;?>}            // tentukan data yang dikirim
                                    });
                                    });
                                    // auto reload data antrian setiap 1 detik untuk menampilkan data secara realtime
                                    setInterval(function() {
                                    $('#jumlah-antrian-<?php echo $kode;?>').load('<?php print_link("get_jumlah_antrian.php?kode=$kode") ?>').fadeIn("slow");
                                    $('#antrian-sekarang-<?php echo $kode;?>').load('<?php print_link("get_antrian_sekarang.php?kode=$kode") ?>').fadeIn("slow");
                                    $('#antrian-selanjutnya-<?php echo $kode;?>').load('<?php print_link("get_antrian_selanjutnya.php?kode=$kode") ?>').fadeIn("slow");
                                    $('#sisa-antrian-<?php echo $kode;?>').load('<?php print_link("get_sisa_antrian.php?kode=$kode") ?>').fadeIn("slow");
                                    table.ajax.reload(null, false);
                                    }, 1000);
                                    });
                                </script>   
                            </div>
                            <?php
                            }
                            /////////////////////////////////////////// ?> 
                            <script>
                                $(document).ready(function(){ 
                                });
                                function openAntrian(evt, cityName) {
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
                                <?php
                                $queryb = mysqli_query($koneksi, "SELECT * FROM data_bank  
                                WHERE type='1' ORDER BY id_databank ASC")
                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                $rowsb = mysqli_num_rows($queryb);
                                if ($rowsb <> 0) {
                                $row   = mysqli_fetch_assoc($queryb); 
                                $kode=$row['kode'];
                                $namaan=$row['nama_bank'];
                                ?>
                                document.getElementById("antrian-<?php echo $kode;?>").click();
                                <?php }?>
                            </script>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
