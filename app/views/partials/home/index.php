<?php 
$page_id = null;
$comp_model = new SharedController;
$current_page = $this->set_current_page_link();
?>
<div>
    <div  class=" p-2 mb-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 comp-grid">
                    <div class=""><div>
                        <?php if(USER_ROLE==8 or USER_ROLE==15){?>
                        <script language="JavaScript">
                            document.location='<?php print_link("igd"); ?>';
                        </script>
                        <?php }?>  
                        <?php if(USER_ROLE==7){?>
                        <script language="JavaScript">
                            document.location='<?php print_link("transaksi"); ?>';
                        </script>
                        <?php }?>
                        <?php if(USER_ROLE==5){?>
                        <script language="JavaScript">
                            document.location='<?php print_link("resep_obat"); ?>';
                        </script>
                        <?php }?>
                        <?php if(USER_ROLE==3){?>
                        <script language="JavaScript">
                            document.location='<?php print_link("pendaftaran_poli/dokter"); ?>';
                        </script>
                        <?php }?>  
                        <?php if(USER_ROLE==2){?>
                        <script language="JavaScript">
                            document.location='<?php print_link("biodata"); ?>';
                        </script>
                        <?php }?>
                        <?php if(USER_ROLE==14){?>
                        <script language="JavaScript">
                            document.location='<?php print_link("data_rm"); ?>';
                        </script>
                        <?php }?>   
                    </div>
                </div><h3 >Dashboard</h3>
            </div>
        </div>
    </div>
</div>
<div  class="">
    <div class="container">
        <div class="row ">
            <div class="col-sm-4 comp-grid">
                <div class=""><?php
                    $usrnam  = "".USER_NAME;
                    $id_user = "".USER_ID;
                    $dbhost  = "".DB_HOST;
                    $dbuser  = "".DB_USERNAME;
                    $dbpass  = "".DB_PASSWORD;
                    $dbname  = "".DB_NAME;
                    $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                    $idtrace = "$id_user$usrnam";
                    $sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
                    //SELECT * FROM `appointment` WHERE `setatus`='Register' AND `tanggal_appointment`=2023-06-09; 
                    //"SELECT COUNT(*) AS num FROM data_pasien"
                    $queryc1 = mysqli_query($koneksi, "SELECT COUNT(*) AS numb1 from appointment WHERE `tanggal_appointment`='$sekarang'")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                    $rowsc1 = mysqli_num_rows($queryc1);
                    if ($rowsc1 <> 0) {
                    $datnum1=mysqli_fetch_assoc($queryc1);
                    $app1=$datnum1['numb1'];
                    }else{
                    $app1="0";
                    }
                    $queryc = mysqli_query($koneksi, "SELECT COUNT(*) AS numb from appointment WHERE `tanggal_appointment`='$sekarang' AND `setatus`='Register'")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                    $rowsc = mysqli_num_rows($queryc);
                    if ($rowsc <> 0) {
                    $datnum=mysqli_fetch_assoc($queryc);
                    $hadir=$datnum['numb'];
                    }else{
                    $hadir="0";
                    }
                    $queryp = mysqli_query($koneksi, "SELECT COUNT(*) AS numpc from pendaftaran_poli WHERE DATE(pendaftaran_poli.tanggal)='$sekarang' and setatus='Closed'")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                    $rowsp = mysqli_num_rows($queryp);
                    if ($rowsp <> 0) {
                    $datnump=mysqli_fetch_assoc($queryp);
                    $pasiencl=$datnump['numpc'];
                    }else{
                    $pasiencl="0";
                    }
                    $querypr = mysqli_query($koneksi, "SELECT COUNT(*) AS numpr from pendaftaran_poli WHERE DATE(pendaftaran_poli.tanggal)='$sekarang' and setatus='Register'")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                    $rowspr = mysqli_num_rows($querypr);
                    if ($rowspr <> 0) {
                    $datnumpr=mysqli_fetch_assoc($querypr);
                    $pasienreg=$datnumpr['numpr'];
                    }else{
                    $pasienreg="0";
                    }
                    $pasienpoli=$pasienreg + $pasiencl;
                    $queryps = mysqli_query($koneksi, "SELECT COUNT(*) AS numps from data_pasien")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                    $rowsps = mysqli_num_rows($queryps);
                    if ($rowsps <> 0) {
                    $datnumps=mysqli_fetch_assoc($queryps);
                    $pasiens=$datnumps['numps'];
                    }else{
                    $pasiens="0";
                    }
                    ?>
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
                    </style>
                    <div class="round3">
                        <div></div>
                        <div>Appointment Hari ini </div>
                        <div></div>
                        <table><tr>
                            <td>
                                <img src= "assets/img/Icons/Buat Janji.png" width="35px"
                                    height="35px">
                                </td>
                                <td>
                                    <table><tr><td><h2><b><?php echo $app1;?></b></h2></td><td>&nbsp;</td><td>| Hadir-> </td><td><h2><b><?php echo $hadir;?></b></h2></td></tr></table> 
                                </td>
                            </tr></table>
                        </div> 
                    </div>
                </div>
                <div class="col-md-4 comp-grid">
                    <div class="">
                        <div class="round3">
                            <div></div>
                            <div>Pendaftaran Poli Hari ini</div>
                            <div></div>
                            <table><tr>
                                <td>
                                    <img src= "assets/img/Icons/Buat Janji.png" width="35px"
                                        height="35px">
                                    </td>
                                    <td>
                                        <h2><b><?php echo $pasienpoli;?></b></h2>
                                    </td>
                                </tr></table>
                            </div> </div>
                        </div>
                        <div class="col-md-4 comp-grid">
                            <div class="">
                                <div class="round3">
                                    <div></div>
                                    <div>Data Pasien</div>
                                    <div></div>
                                    <table><tr>
                                        <td>
                                            <img src= "<?php print_link("");?>assets/img/Icons/Data Pasien1.png" width="35px"
                                                height="35px">
                                            </td>
                                            <td>
                                                <h2><b><?php echo  $pasiens;?></b></h2>
                                            </td>
                                        </tr></table> 
                                    </div> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  class="">
                        <div class="container">
                            <div class="row ">
                                <div class="col-md-12 comp-grid">
                                    <div class="">   <script src="Chart.js"></script>
                                        <style type="text/css">
                                            .containercart {
                                            width: 100%;
                                            margin: 5px auto;
                                            }
                                        </style>
                                        <div class="rowder">
                                            <div class="coll-12">
                                                <div class="round3">
                                                    <div></div>
                                                    <div>Appointment Hari ini</div>
                                                    <div></div>
                                                    <div><table><tr>
                                                        <td>
                                                            <select id="searchpol" name="poli" class="form-control" required="">
                                                                <option value="All">Poli All</option>
                                                                <?php
                                                                $sql = mysqli_query($koneksi,"select * from data_poli");
                                                                while ($row=mysqli_fetch_array($sql)){
                                                                $idpoli=$row['id_poli'];
                                                                $nama=$row['nama_poli'];
                                                                echo"<option value=\"$idpoli\" >$nama</option>";
                                                                }
                                                                ?>
                                                            </select>            
                                                        </td>
                                                        <td>
                                                            <input type="text" id="searchpel" placeholder="Cari Nama Pasien" name="searchpel" class="form-control "/> <input type="hidden" id="idcek" name="idcek" value="<?php echo $id_user;?>"/>              
                                                            </td>
                                                            <td></td>
                                                        </tr></table></div>
                                                        <div></div>
                                                        <div id="displaypel"></div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 comp-grid">
                                        <div class="">
                                            <div class="round3">
                                                <div></div>
                                                <div>Appointment</div>
                                                <div class="input-group">
                                                    <input id="tglap" class="form-control datepicker  datepicker"  value="<?php echo date_now();?>" type="datee"  name="tanggal" placeholder="Tanggal" data-enable-time="" data-date-format="Y-m-d" data-alt-format="M j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                <div></div></br>
                                                <div id="page-report-body" class="table-responsive">
                                                    <canvas id="barchart" width="100" height="50"></canvas>
                                                </div>       
                                            </div> 
                                            <script>
                                                function validateForm() {
                                                let x = document.forms["myForm"]["pelanggan"].value;
                                                if (x == "") {
                                                // alert("Isi Form Pelanggan!!");
                                                return false;
                                                //clearTimeout(reloadpage);
                                                }else{
                                                reloadpage();
                                                }
                                                }       
                                                function reloadpage() {
                                                setTimeout(function(){ window.location.reload();}, 2000);
                                                }
                                                function fillpel(Value) {
                                                //Assigning value to "search" div in "search.php" file.
                                                $('#searchpel').val(Value);
                                                //Hiding "display" div in "search.php" file.
                                                $('#displaypel').hide();
                                                }
                                                $(document).ready(function() {
                                                myFunctioncart();
                                                var name = $('#searchpel').val();
                                                var pol = $('#searchpol').val();
                                                var uid = $('#idcek').val();
                                                var dataString = 'search='+ name + '&poli=' + pol + '&cekid=' + uid;
                                                if(name=="") {      
                                                $.ajax({
                                                //AJAX type is "Post".
                                                type: "POST",
                                                //Data will be sent to "ajax.php".
                                                url: "<?php print_link("appointment.php") ?>",
                                                //Data, that will be sent to "ajax.php".
                                                data: dataString,
                                                //If result found, this funtion will be called.
                                                success: function(html) {
                                                //Assigning result to "display" div in "search.php" file.
                                                $("#displaypel").html(html).show();
                                                }
                                                });
                                                }else{
                                                }
                                                //On pressing a key on "Search box" in "search.php" file. This function will be called.
                                                //$('#searchpel').val("").focus();
                                                $('#searchpel').keyup(function(e){
                                                var tex = $(this).val();
                                                console.log(tex);
                                                if(tex !=="" && e.keyCode===13){
                                                }
                                                e.preventDefault();
                                                //Assigning search box value to javascript variable named as "name".
                                                var name = $('#searchpel').val();
                                                var pol = $('#searchpol').val();
                                                //Validating, if "name" is empty.
                                                //var dataString = 'search='+ name + '&poli=' + pol;
                                                //var dataString = 'search='+ name + '&poli=' + pol;
                                                if (name == "") {
                                                //Assigning empty value to "display" div in "search.php" file.
                                                // $("#displaypel").html("");
                                                $.ajax({
                                                //AJAX type is "Post".
                                                type: "POST",
                                                //Data will be sent to "ajax.php".
                                                url: "<?php print_link("appointment.php") ?>",
                                                //Data, that will be sent to "ajax.php".
                                                // data: search:name + poli:,
                                                data: dataString,
                                                //If result found, this funtion will be called.
                                                success: function(html) {
                                                //Assigning result to "display" div in "search.php" file.
                                                $("#displaypel").html(html).show();
                                                }
                                                });
                                                }
                                                //If name is not empty.
                                                else {
                                                //AJAX is called.
                                                $.ajax({
                                                //AJAX type is "Post".
                                                type: "POST",
                                                //Data will be sent to "ajax.php".
                                                url: "<?php print_link("appointment.php") ?>",
                                                //Data, that will be sent to "ajax.php".
                                                data: dataString,
                                                //If result found, this funtion will be called.
                                                success: function(html) {
                                                //Assigning result to "display" div in "search.php" file.
                                                $("#displaypel").html(html).show();
                                                }
                                                });
                                                }
                                                });
                                                $('#searchpol').on('change', function(){ 
                                                $("#searchpel").val('');
                                                //do something like 
                                                //$(this).hide(); 
                                                //$(#anotherfieldid).show();
                                                var ctrlVal = $(this).val();
                                                //$(#anotherfieldname).val(ctrlVal)
                                                var name = $('#searchpel').val();
                                                //Validating, if "name" is empty.
                                                // var dataString = 'search='+ name + '&poli=' + ctrlVal;
                                                $.ajax({
                                                //AJAX type is "Post".
                                                type: "POST",
                                                //Data will be sent to "ajax.php".
                                                url: "<?php print_link("appointment.php") ?>",
                                                //Data, that will be sent to "ajax.php".
                                                data: dataString,
                                                //If result found, this funtion will be called.
                                                success: function(html) {
                                                //Assigning result to "display" div in "search.php" file.
                                                $("#displaypel").html(html).show();
                                                }
                                                });
                                                }); 
                                                $('#tglap').on('change', function(){ 
                                                var ctrlVal = $('#tglap').val();
                                                var dataString = 'tglpos='+ ctrlVal;
                                                $.ajax({
                                                //AJAX type is "Post".
                                                type: "POST",
                                                //Data will be sent to "ajax.php".
                                                url: "<?php print_link("appointment_cart.php") ?>",
                                                //Data, that will be sent to "ajax.php".
                                                data: dataString,
                                                //If result found, this funtion will be called.
                                                success: function(html) {
                                                //Assigning result to "display" div in "search.php" file.
                                                $("#barchart").html(html).show();
                                                }
                                                });
                                                });   
                                                function myFunctioncart() {
                                                var ctrlVal = $('#tglap').val();
                                                var dataString = 'tglpos='+ ctrlVal;
                                                $.ajax({
                                                //AJAX type is "Post".
                                                type: "POST",
                                                //Data will be sent to "ajax.php".
                                                url: "<?php print_link("appointment_cart.php") ?>",
                                                //Data, that will be sent to "ajax.php".
                                                data: dataString,
                                                //If result found, this funtion will be called.
                                                success: function(html) {
                                                //Assigning result to "display" div in "search.php" file.
                                                $("#barchart").html(html).show();
                                                }
                                                });
                                                }       
                                                });
                                            </script> </div>
                                        </div>
                                        <div class="col-sm-6 comp-grid">
                                            <div class=""><div class="round3">
                                                <div>
                                                    <h4>Transaksi</h4>
                                                    <small class="text-muted"></small>
                                                </div>
                                                <hr />
                                                <canvas id="transaksiPie"></canvas>
                                            </div>
                                            <?php
                                            $querytgl=mysqli_query($koneksi, "SELECT * FROM `transaksi`");
                                            $rowstgl = mysqli_num_rows($querytgl); 
                                            if ($rowstgl <> 0) {
                                            $datatgl="Ada";
                                            }else{
                                            $datatgl="";    
                                            }
                                            ?>
                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                ////////////////////////////////////    
                                                $(function (){
                                                var chartDataPie = {
                                                labels : [<?php 
                                                if ($datatgl=="Ada") {
                                                $quero = mysqli_query($koneksi, "SELECT DISTINCT tanggal as tgl FROM `transaksi` ORDER BY `id` DESC LIMIT 7");                                              
                                                while ($Result = mysqli_fetch_array($quero)) {
                                                $tagl=$Result['tgl'];?>"<?php echo $tagl;?>",<?php } }else{?>"01",<?php }?>],
                                                datasets : [
                                                {
                                                label: 'Transaksi',
                                                borderColor:'rgba(0 , 128 , 64, 0.7)',
                                                backgroundColor:'rgba(128 , 0 , 255, 0.5)',
                                                borderWidth:3,
                                                data : [<?php if($datatgl==""){?>"01",<?php }else{
                                                $querob = mysqli_query($koneksi, "SELECT DISTINCT tanggal AS tagll FROM `transaksi` ORDER BY `id` DESC LIMIT 7");
                                                while ($Resultb = mysqli_fetch_array($querob)) {
                                                $tglb=$Resultb['tagll'];
                                                $quersumb = mysqli_query($koneksi, "select SUM(total_tagihan) AS jumtag from transaksi WHERE tanggal='$tglb'");
                                                $datotjum   = mysqli_fetch_assoc($quersumb);      $grandtotal=$datotjum['jumtag'];
                                                ?>"<?php echo $grandtotal;?>",<?php }}?>],
                                                }
                                                ]
                                                }
                                                var ctx = document.getElementById('transaksiPie');
                                                var chart = new Chart(ctx, {
                                                type:'pie',
                                                data: chartDataPie,
                                                options: {
                                                responsive: true,
                                                scales: {
                                                yAxes: [{
                                                ticks:{display: false},
                                                gridLines:{display: false},
                                                scaleLabel: {
                                                display: true,
                                                labelString: ""
                                                }
                                                }],
                                                xAxes: [{
                                                ticks:{display: false},
                                                gridLines:{display: false},
                                                scaleLabel: {
                                                display: true,
                                                labelString: ""
                                                }
                                                }],
                                                },
                                                }
                                                ,
                                                })});   
                                                ////////////////////////////////////    
                                                });
                                            </script></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
