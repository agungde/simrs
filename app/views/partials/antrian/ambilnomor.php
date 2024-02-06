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
                    "BurlyWood",
                    "IndianRed");
                    $warnatab = array(
                    "MediumSlateBlue",
                    "DarkOrchid",
                    "RebeccaPurple",
                    "SlateBlue",
                    "RebeccaPurple",
                    "BlueViolet",
                    "Coral",
                    "DarkSalmon",
                    "DarkSlateBlue",
                    "DarkViolet",
                    "LightSalmon",
                    "MediumOrchid",
                    "MediumPurple",
                    "IndianRed",
                    "BurlyWood");
                    ?>
                    <link rel="stylesheet" href="<?php print_link("assets/css/style.css") ?>"> 
                        <center>
                            <main class="flex-shrink-0">
                                <div class="container pt-2">
                                    <div class="row justify-content-lg-center">
                                        <div class="px-2 py-2 mb-2bg-white rounded-2 shadow-sm">
                                            <!-- judul halaman -->
                                            <div class="d-flex align-items-center me-md-auto">
                                                <h1 class="h5 pt-2"><i class="fa fa-users "></i> NOMOR ANTRIAN RSIA KASIH IBU TEGAL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                                    <button class="tablinks"  onclick="openAntrian(event, 'an-<?php echo $kode;?>')" id="Tab-antrian-<?php echo $kode;?>"><i class="fa fa-users "></i> NOMOR ANTRIAN <?php echo strtoupper($namaan);?></button>
                                                    <?php  $w++;
                                                    }?>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </main>
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
                                    <h4 class="record-title" style="border-radius: 8px; background-color: <?php echo $warna[$x];?>; color: white; padding:3px; font-weight: bold;"><i class="fa fa-users "></i> NOMOR ANTRIAN <?php echo strtoupper($namaan);?></h4>
                                </div>
                                <div class="p-2 mb-2">
                                    <div class="row">
                                        <?php 
                                        ///////////////////////////////////////////// 
                                        $queryp = mysqli_query($koneksi, "SELECT * FROM data_poli")
                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                        $wn=0;
                                        while ($rowp = mysqli_fetch_assoc($queryp)) {
                                        $kodep=$rowp['kode'];
                                        $nampoli=$rowp['nama_poli'];
                                        ?>           
                                        <div class="col-md-2">
                                            <div class="round3">
                                                <div style="border-radius: 8px; background-color: <?php echo $warna[$wn];?>; color: white; padding:3px; font-weight: bold;"><h5 class="pt-2"><i class="fa fa-users "></i> ANTRIAN</h5>
                                                    <div>POLI <?php echo $nampoli;?></div>  
                                                </div>              
                                                <div style="margin-top:2px;margin-bottom:2px; border-radius: 8px; background-color: <?php echo $warna[$wn];?>; color: white; padding:5px; font-weight: bold;font-size: 70px;">
                                                    <!-- menampilkan informasi jumlah antrian -->
                                                    <p id="antrian-<?php echo $kode;?><?php echo $kodep;?>">0000</p>
                                                </div>     
                                                <div align="center" style="border-radius: 8px; background-color: <?php echo $warna[$wn];?>; color: white; padding:5px; font-weight: bold;">
                                                    <a id="insert<?php echo $kode;?><?php echo $kodep;?>" href="javascript:void(0)">
                                                    <h6 style="color: white;font-size: 20px;"><b>AMBIL NOMOR</b></h6></a>
                                                </div>
                                            </div> 
                                        </div><p id="print-<?php echo $kode;?><?php echo $kodep;?>"></p>
                                        <form id="forman<?php echo $kode;?><?php echo $kodep;?>" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="#" method="post">   
                                            <input type="hidden" name="kod" value="<?php echo $kode;?>">
                                                <input type="hidden" name="pol" value="<?php echo $kodep;?>">
                                                </form> 
                                                <script type="text/javascript">
                                                    $(document).ready(function() {
                                                    // tampilkan jumlah antrian
                                                    $('#antrian-<?php echo $kode;?><?php echo $kodep;?>').load('<?php print_link("get_ambil_nomor.php?kode=$kode&pol=$kodep") ?>');
                                                    // proses insert data
                                                    $('#insert<?php echo $kode;?><?php echo $kodep;?>').on('click', function() {
                                                    $.ajax({
                                                    method:"POST",                    // mengirim data dengan method POST
                                                    url: '<?php print_link("insert.php") ?>',                // url file proses insert data
                                                    data: $('#forman<?php echo $kode;?><?php echo $kodep;?>').serialize(),
                                                    dataType:"JSON",
                                                    success:function(data)
                                                    {
                                                    var hasil=""+ data.ambil; 
                                                    var prin=""+ data.print; 
                                                    var tang=""+ data.tanggal; 
                                                    var koda=""+ data.kodantrian; 
                                                    var pol=""+ data.poli; 
                                                    if(hasil=="OK"){
                                                    $('#antrian-<?php echo $kode."$kodep";?>').load('<?php print_link("get_ambil_nomor.php?kode=$kode&pol=$kodep") ?>').fadeIn('slow');
                                                    //document.location='<?php print_link("$current_page?print=") ?>'+prin;
                                                    w=window.open();
                                                    //w.document.write($('#nomor<?php echo $kode."$kodep";?>').prin);
                                                    document.getElementById("nomor<?php echo $kode."$kodep";?>").innerHTML = prin;
                                                    document.getElementById("tgl<?php echo $kode."$kodep";?>").innerHTML = tang;
                                                    document.getElementById("koda<?php echo $kode."$kodep";?>").innerHTML = koda;
                                                    document.getElementById("pol<?php echo $kode."$kodep";?>").innerHTML = pol;
                                                    w.document.write($('#divToPrint<?php echo $kode."$kodep";?>').html());
                                                    w.print();
                                                    w.close();
                                                    }else{
                                                    alert('Tes >> '+result+' <<');
                                                    }
                                                    },
                                                    });
                                                    });
                                                    });
                                                </script>
                                                <div id="divToPrint<?php echo $kode."$kodep";?>" style="display:none;">
                                                    <style>   @page {
                                                        margin: 0px;
                                                        font-family: Arial, Helvetica, sans-serif;
                                                        }
                                                        .ajax-page-load-indicator {
                                                        display: none;
                                                        visibility: hidden;
                                                        }
                                                        #report-body{
                                                        padding-left: 10px;
                                                        }
                                                        .table-responsive {
                                                        display: block;
                                                        width: 100%;
                                                        overflow-x: auto;
                                                        -ms-overflow-style: -ms-autohiding-scrollbar;
                                                        }
                                                        .table-responsive.table-bordered {
                                                        border: 0;
                                                        }
                                                    </style>
                                                    <div id="report-body">
                                                        <span style="text-align:center;border-style:double; padding:10px;display: inline-block;" >
                                                            <div style="font-size:30px;"> RSIA KASIH IBU</div>
                                                            <div id="tgl<?php echo $kode."$kodep";?>"> </div>
                                                            <div> Nomor Antrian Anda: </div>
                                                            <div id="nomor<?php echo $kode."$kodep";?>" style="font-size:100px;">
                                                            </div>
                                                            <div id="koda<?php echo $kode."$kodep";?>"></div>
                                                            <div id="pol<?php echo $kode."$kodep";?>"></div>
                                                        </span></div>
                                                    </div>
                                                    <?php $x++;
                                                    $wn++;             
                                                    }
                                                    ////////////////////////////// 
                                                    ?>
                                                </div>
                                            </div></div>
                                            <?php
                                            $x++;        }
                                            ?>
                                        </center>
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
                                            document.getElementById("Tab-antrian-<?php echo $kode;?>").click();
                                            <?php }?>
                                        </script> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
