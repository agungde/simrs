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
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Input Kas Awal
                        <script>
                            function validateFormkas() { 
                            var kas = $('#ctrl-kas_awal').val();
                            var ket = $('#ctrl-keterangan').val();
                            var nam = $('#ctrl-nama').val();
                            var pin = $('#ctrl-pin').val();
                            var pass = $('#ctrl-password').val();
                            if(kas==""){
                            document.getElementById("ctrl-kas_awal").focus();
                            document.getElementById('kaserror').innerHTML = "Please enter Kas Awal!!";
                            setTimeout(function(){
                            $('#kaserror').hide();
                            clearerror();
                            }, 5000);
                            return false;
                            }  
                            if(ket==""){
                            document.getElementById("ctrl-keterangan").focus();
                            document.getElementById('keterror').innerHTML = "Please enter Keterangan!!";
                            setTimeout(function(){
                            $('#keterror').hide();
                            clearerror();
                            }, 5000);
                            return false;
                            }           
                            if(nam==""){
                            document.getElementById("ctrl-nama").focus();
                            document.getElementById('namerror').innerHTML = "Please select Nama Kasir!!";
                            setTimeout(function(){
                            $('#namerror').hide();
                            clearerror();
                            }, 5000);
                            return false;
                            }           
                            if(pin==""){
                            document.getElementById("ctrl-pin").focus();
                            document.getElementById('pinerror').innerHTML = "Please enter Your Pin!!";
                            setTimeout(function(){
                            $('#pinerror').hide();
                            clearerror();
                            }, 5000);
                            return false;
                            }
                            if(pass==""){
                            document.getElementById("nctrl-password").focus();
                            document.getElementById('pinerror').innerHTML = "Please enter Your Password!!";
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
                            $("#kaserror").html("");
                            $("#pinerror").html("");
                            $("#passerror").html("");
                            $("#keterror").html("");
                            $("#namerror").html("");
                            $("#keterror").show();
                            $("#namerror").show();
                            $("#keyerror").show();
                            $("#kaserror").show();
                            $("#pinerror").show();
                            $("#passerror").show();
                            }
                            function appkeykas() { 
                            var pinx = $('#ctrl-pin').val();
                            var passx = $('#ctrl-password').val();
                            $.ajax({
                            url:"<?php print_link("key.php");?>",
                            method:"POST",
                            data:{pin:pinx,pass:passx},
                            dataType:"JSON",
                            success:function(data)
                            {
                            var hasil=""+ data.passok; 
                            if(hasil=="OK"){
                            // document.getElementById("transaksi-debet-form").submit();
                            var result = confirm("Proses Input Kas Awal?");
                            if (result == true) {
                            document.getElementById("transaksi-debet-form").submit();
                            return true;
                            }
                            else {
                            return false;
                            }
                            }else{
                            document.getElementById('keyerror').innerHTML = "Pin / Password Salah!!";  
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
                            ?>
                            <form id="transaksi-debet-form" name="kas" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("transaksi/debet?csrf_token=$csrf_token") ?>" method="post">
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
                                                    <label class="control-label" for="type_kas">Type kas<span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class=""> Cash
                                                        <input id="ctrl-type_kas"  value="<?php  echo $this->set_field_value('type_kas',"2"); ?>" type="hidden"   name="type_kas"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>          
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="kas_awal">Kas Awal <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input type="number"  placeholder="Enter Kas Awal" id="ctrl-kas_awal" required="" name="kas_awal" class="form-control">          
                                                            </div><span id="kaserror" style="color:red;"></span>  
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="keterangan">Keterangan <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input type="text"  placeholder="Enter keterangan" id="ctrl-keterangan" required="" name="keterangan" class="form-control">          
                                                                </div><span id="keterror" style="color:red;"></span>  
                                                            </div>
                                                        </div>
                                                    </div>      
                                                    <?php ////////////////////////////////////////////////////////////////////////// ?>                    
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="nama">Kas Awal Untuk Kasir <span class="text-danger">*</span></label>
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
                                                                        $selected="selected";
                                                                        }else{
                                                                        $selected="";
                                                                        }  
                                                                        echo"<option value=\"$iduserlogin\" $selected>$namauser</option>";
                                                                        }
                                                                        ?>       
                                                                    </select>
                                                                </div><span id="namerror" style="color:red;"></span> 
                                                            </div>
                                                        </div>
                                                    </div>                
                                                    <div align="center"><i class="fa fa-arrow-circle-down "></i> Pin Dan Password Yang Berwenang</div>           
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="pin">Pin <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="input-group">                                
                                                                    <input id="ctrl-pin"  value="<?php  echo $this->set_field_value('pin',""); ?>" type="password" placeholder="Enter Pin"  required="" name="pin"  class="form-control" />
                                                                    </div>  <span id="pinerror" style="color:red;"></span>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                            <button class="btn btn-primary" type="button" onclick="validateFormkas();">
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
