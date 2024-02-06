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
    <div  class="p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Add New Rm Lama</h4>
                    <div class=""><div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        if(!empty($_GET['datprecord'])){
                        $idpas=$_GET['datprecord'];
                        $queryb = mysqli_query($koneksi, "select * from data_pasien WHERE id_pasien='$idpas'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_rm_lama=$row['rm'];
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php } ?>
                        <script language="JavaScript">
                            function cektglrm(){ 
                            var tglrm = $('#ctrl-tanggal_rm').val();
                            var morm ="<?php echo $no_rekam_medis;?>";
                            if(tglrm==""){
                            document.getElementById("ctrl-tanggal_rm").focus();
                            document.getElementById('tglerror').innerHTML = "Pilih Tanggal RM!!";
                            setTimeout(function(){
                            $('#kaserror').hide();
                            clearerror();
                            }, 5000);
                            return false;
                            }
                            $.ajax({
                            url:"<?php print_link("cektglrm.php");?>",
                            method:"POST",
                            data:{tgl:tglrm,rm:morm},
                            dataType:"JSON",
                            success:function(data)
                            {
                            var hasil=""+ data.passok; 
                            if(hasil=="OK"){
                            // document.getElementById("transaksi-debet-form").submit();
                            var result = confirm('Add RM Lama Tanggal ' +tglrm+' ?');
                            if (result == true) {
                            document.getElementById("rm_lama-rm_lama-form").submit();
                            return true;
                            }
                            else {
                            return false;
                            }
                            }else{
                            document.getElementById('tglerror').innerHTML = "Tanggal RM Sudah Ada";  
                            }
                            }
                            });
                            }
                            function clearerror() { 
                            $("#tglerror").html("");
                            $("#tglerror").show();
                            }   
                        </script>
                    </div>
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
            <div class="col-md-7 comp-grid">
                <div class=" ">
                    <?php  
                    $this->render_page("data_pasien/pasien/$_GET[datprecord]"); 
                    ?>
                </div>
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form id="rm_lama-rm_lama-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("rm_lama/rm_lama?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="tanggal_rm">Tanggal Rm <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input id="ctrl-tanggal_rm" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal_rm',""); ?>" type="datetime" name="tanggal_rm" placeholder="Enter Tanggal Rm" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div><span id="tglerror" style="color:red;"></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="no_rm_lama">No Rm Lama <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-no_rm_lama"  value="<?php echo $no_rm_lama;?>" type="text" placeholder="Enter No Rm Lama"  readonly required="" name="no_rm_lama"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="no_rekam_medis">No Rekam Medis <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="text" placeholder="Enter No Rekam Medis"  readonly required="" name="no_rekam_medis"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-submit-btn-holder text-center mt-3">
                                        <div class="form-ajax-status"></div>
                                        <button class="btn btn-primary" type="button" onclick="cektglrm()">
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
