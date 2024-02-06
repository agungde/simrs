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
                    <h4 class="record-title"><script>
                        function validateFormkas() { 
                        var kas = $('#ctrl-jumlah').val();
                        var ket = $('#ctrl-keterangan').val();
                        var pin = $('#ctrl-pin').val();
                        var pass = $('#ctrl-password').val();
                        if(kas==""){
                        document.getElementById("ctrl-jumlah").focus();
                        document.getElementById('kaserror').innerHTML = "Masukan Jumlah Penarikan!!";
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
                        //$("#namerror").html("");
                        $("#keterror").show();
                        //$("#namerror").show();
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
                        var result = confirm("Proses Penarikan Kas Tunai?");
                        if (result == true) {
                        document.getElementById("kas").submit();
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
                        function startCalc(){
                        interval = setInterval("calc()",1);}
                        function calc(){
                        satu = document.kas.jumlah.value;
                        dua = document.kas.kas_akhir.value; 
                        //tiga = document.formid.total.value; 
                        document.kas.sisa_saldo.value = (dua * 1) - (satu * 1);}
                        function stopCalc(){
                        clearInterval(interval);}
                    </script></h4>
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
                        $saldo = $datacek['saldo_cash'];
                        }else{
                        $saldo = "0";
                        }
                        ?>
                        <form id="kas" name="kas" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("transaksi/kredit?csrf_token=$csrf_token") ?>" method="post">
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
                                                    <label class="control-label" for="kas_akhir">Kas Tunai Akhir<span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <h3><?php echo number_format($saldo,0,",","."); ?> </h3>       
                                                        <input type="hidden" value="<?php echo $saldo;?>" placeholder="Enter Kas Awal" id="ctrl-kas_akhir" required="" name="kas_akhir" class="form-control">          
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>            
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="jumlah">Jumlah Penarikan<span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input onFocus="startCalc();" onBlur="stopCalc();" type="number" placeholder="Enter Jumlah Penarikan" id="ctrl-jumlah" required="" name="jumlah" class="form-control">          
                                                            </div><span id="kaserror" style="color:red;"></span>  
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="sisa_saldo">Sisa Saldo<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input type="number" onFocus="startCalc();" onBlur="stopCalc();"  id="ctrl-sisa_saldo" required="" name="sisa_saldo" class="form-control" readonly>          
                                                                </div> 
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
