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
                <div class="col-md-4 comp-grid">
                    <div class=""><div>
                        <div class="round3">
                            <center>
                                <div style="border-radius: 8px; background-color: Indigo; color: white; padding:5px; font-weight: bold;"><h2><b><i class="fa fa-user "></i> ANTRIAN SAAT INI</b></h2></div>
                                <div style="margin-top:2px;margin-bottom:2px; border-radius: 8px; background-color: BlueViolet; color: white; padding:5px; font-weight: bold;font-size: 120px;">
                                    <!-- menampilkan informasi jumlah antrian -->
                                    <p id="antrian-live" >0000</p>
                                </div>
                                <div style="border-radius: 8px; background-color: RebeccaPurple; color: white; padding:5px; font-weight: bold;"><h2><b id="loket-live">LOKET XX</b></h2></div>
                            </center>
                        </div>   
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function() {
                        $('#antrian-live').load('<?php print_link("get_antrian_live.php") ?>');
                        $('#loket-live').load('<?php print_link("get_antrian_live.php?loket=true") ?>');
                        setInterval(function() {
                        $('#antrian-live').load('<?php print_link("get_antrian_live.php") ?>').fadeIn("slow");
                        $('#loket-live').load('<?php print_link("get_antrian_live.php?loket=true") ?>').fadeIn("slow");
                        table.ajax.reload(null, false);
                        }, 1000);
                        });
                    </script></div>
                </div>
                <div class="col-md-8 comp-grid">
                    <div class=""> <video width="100%" height="100%" controls muted autoplay loop>
                        <source src="<?php print_link("uploads/files/vidio/") ?>iklan.mp4" type="video/mp4">
                            <source src="<?php print_link("uploads/files/vidio/") ?>bojo_biduan.ogg" type="video/ogg">
                                Your browser does not support HTML video.
                            </video>
                        </div>
                    </div>
                    <div class="col-md-12 comp-grid">
                        <div class=""><div>
                            <style>
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
                            </style>
                        </div>
                    </div>
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
                        "IndianRed",
                        "BurlyWood");
                        ?>
                        <link rel="stylesheet" href="<?php print_link("assets/css/style.css") ?>"> 
                            <center>
                                <div class="p-2 mb-2">
                                    <div class="row">
                                        <?php 
                                        ///////////////////////////////////////////// 
                                        $wn=0;
                                        $queryp = mysqli_query($koneksi, "SELECT * FROM data_poli")
                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                        while ($rowp = mysqli_fetch_assoc($queryp)) {
                                        $kodep=$rowp['kode'];
                                        $nampoli=$rowp['nama_poli'];
                                        ?>           
                                        <div class="col-md-2">
                                            <div class="round3">
                                                <div style="border-radius: 8px; background-color: <?php echo $warna[$wn];?>; color: white; padding:3px; font-weight: bold;"><h5 class="pt-2"><i class="fa fa-users "></i> ANTRIAN</h5></div>
                                                <div style="margin-top:2px;margin-bottom:2px; border-radius: 8px; background-color: <?php echo $warna[$wn];?>; color: white; padding:5px; font-weight: bold;font-size: 50px;">
                                                    <!-- menampilkan informasi jumlah antrian -->
                                                    <p id="antrian-live-<?php echo $kodep;?>" >0000</p>
                                                </div>           
                                                <div style="border-radius: 8px; background-color: <?php echo $warna[$wn];?>; color: white; padding:3px; font-weight: bold;">POLI <?php echo $nampoli;?></div>
                                            </div> 
                                        </div>
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                            // tampilkan jumlah antrian
                                            $('#antrian-live-<?php echo $kodep;?>').load('<?php print_link("get_antrian_live.php?pol=$kodep") ?>") ?>&pol=<?php echo $kodep;?>');
                                            setInterval(function() {
                                            $('#antrian-live-<?php echo $kodep;?>').load('<?php print_link("get_antrian_live.php?pol=$kodep") ?>').fadeIn("slow");
                                            table.ajax.reload(null, false);
                                            }, 1000); 
                                            });
                                        </script>
                                        <?php 
                                        $wn++;        
                                        }
                                        ////////////////////////////// 
                                        ?>
                                    </div></div></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
