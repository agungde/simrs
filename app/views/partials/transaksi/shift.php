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
                    <h4 class="record-title">Serah Terima Shift Kasir
                        <script>
                            function validateShift() { 
                            //var kas = $('#ctrl-kas_awal').val();
                            // var ket = $('#ctrl-keterangan').val();
                            var nam = $('#ctrl-nama').val();
                            // var pin = $('#ctrl-pin').val();
                            var pass = $('#ctrl-password').val();
                            if(nam==""){
                            document.getElementById("ctrl-nama").focus();
                            document.getElementById('namerror').innerHTML = "Please select Nama Kasir!!";
                            setTimeout(function(){
                            $('#namerror').hide();
                            clearerror();
                            }, 5000);
                            return false;
                            }           
                            if(pass==""){
                            document.getElementById("ctrl-password").focus();
                            document.getElementById('passerror').innerHTML = "Please enter Your Password!!";
                            setTimeout(function(){
                            $('#passerror').hide();
                            clearerror();
                            }, 5000);
                            return false;
                            }
                            appkeykas();
                            }
                            function clearerror() { 
                            $("#keyerror").html("");
                            //$("#kaserror").html("");
                            //$("#pinerror").html("");
                            $("#passerror").html("");
                            //$("#keterror").html("");
                            $("#namerror").html("");
                            $("#keterror").show();
                            $("#namerror").show();
                            //$("#keyerror").show();
                            //  $("#kaserror").show();
                            // $("#pinerror").show();
                            $("#passerror").show();
                            }
                            function appkeykas() { 
                            var namx = $('#ctrl-nama').val();
                            var passx = $('#ctrl-password').val();
                            $.ajax({
                            url:"<?php print_link("keyshift.php");?>",
                            method:"POST",
                            data:{id:namx,pass:passx},
                            dataType:"JSON",
                            success:function(data)
                            {
                            var hasil=""+ data.passok; 
                            if(hasil=="OK"){
                            //document.getElementById("transaksi-shift-form").submit();
                            var result = confirm("Proses Serah terima Shift?");
                            if (result == true) {
                            //document.getElementById('autobtn').click();
                            document.getElementById("transaksi-shift-form").submit();
                            return true;
                            }
                            else {
                            return false;
                            }
                            }else{
                            document.getElementById('keyerror').innerHTML = "Password Salah!!";  
                            setTimeout(function(){
                            $('#keyerror').hide();
                            clearerror();
                            }, 5000);
                            }
                            }
                            });
                            }
                        </script> </h4>
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
                    <div class="col-md-7 comp-grid">
                        <?php $this :: display_page_errors(); ?>
                        <div  class="bg-light p-3 animated fadeIn page-content">
                            <?php
                            $id_user = "".USER_ID;
                            $dbhost  = "".DB_HOST;
                            $dbuser  = "".DB_USERNAME;
                            $dbpass  = "".DB_PASSWORD;
                            $dbname  = "".DB_NAME;
                            //$koneksi=open_connection();
                            $koneksi    = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                            $query = mysqli_query($koneksi, "SELECT * FROM `kas` ORDER BY `id` DESC")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                            $rows = mysqli_num_rows($query);
                            if ($rows <> 0) {
                            $datacek= mysqli_fetch_assoc($query);
                            $saldo = $datacek['saldo'];
                            }else{
                            $saldo = "0";
                            }
                            ?>
                            <form id="transaksi-shift-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("transaksi/shift?csrf_token=$csrf_token") ?>" method="post">
                                <div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input id="ctrl-tanggal" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal',date_now()); ?>" type="datetime" name="tanggal" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="kas_akhir">Kas Akhir Kasir Lama<span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-kas_akhir_show"  value="Rp.<?php  echo number_format($saldo,0,",","."); ?>" type="text" placeholder="Enter Kas Akhir" step="1"  readonly required="" name="kas_akhir_show"  class="form-control " />
                                                            <input id="ctrl-kas_akhir"  value="<?php  echo $this->set_field_value('kas_akhir',"$saldo"); ?>" type="hidden" placeholder="Enter Kas Akhir" step="1"  readonly required="" name="kas_akhir"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php ////////////////////////////////////////////////////////////////////////// ?>    
                                                <div align="center"><i class="fa fa-arrow-circle-down "></i> Shift Kasir Baru</div>   
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="nama">Nama Kasir Baru<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <select required=""  id="ctrl-nama" name="nama"  placeholder="Select a value ..."    class="custom-select" >
                                                                    <option value="">Select Kasir...</option>
                                                                    <?php
                                                                    $sql = mysqli_query($koneksi,"select * from user_login where user_role_id='7'");
                                                                    while ($row=mysqli_fetch_array($sql)){
                                                                    $iduserlogin=$row['id_userlogin'];
                                                                    $namauser=$row['nama'];
                                                                    if($iduserlogin==$id_user){
                                                                    }else{
                                                                    echo"<option value=\"$iduserlogin\" >$namauser</option>";
                                                                    }  
                                                                    }
                                                                    ?>       
                                                                </select>
                                                            </div><span id="namerror" style="color:red;"></span> 
                                                        </div>
                                                    </div>
                                                </div>    
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="kas_awal">Kas Awal Shift Kasir Baru<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-kas_awal_show"  value="Rp.<?php  echo number_format($saldo,0,",","."); ?>" type="text" placeholder="Enter Kas Awal" step="1"  readonly required="" name="kas_awal_show"  class="form-control " />
                                                                    <input id="ctrl-kas_awal"  value="<?php  echo $saldo; ?>" type="hidden" placeholder="Enter Kas Awal" step="1"  readonly required="" name="kas_awal"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>       
                                                        <div align="center"><i class="fa fa-arrow-circle-down "></i> Password Login Shift Kasir Baru</div>           
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="password">Password <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="input-group">                                    
                                                                        <input id="ctrl-password"  value="<?php  echo $this->set_field_value('password',""); ?>" type="password" placeholder="Enter Password"  required="" name="password"  class="form-control" />
                                                                        </div>             <span id="passerror" style="color:red;"></span>                       
                                                                    </div>
                                                                </div>
                                                            </div>                    
                                                        </div>
                                                        <div align="center"><span id="keyerror" style="color:red;"></span> </div> 
                                                        <div class="form-group form-submit-btn-holder text-center mt-3">
                                                            <div class="form-ajax-status"></div>
                                                            <button class="btn btn-primary" type="button" onclick="validateShift();">
                                                                Submit
                                                                <i class="fa fa-send"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
