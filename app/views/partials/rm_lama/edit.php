<?php
$comp_model = new SharedController;
$page_element_id = "edit-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="edit"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Edit  Tanggal RM Lama</h4>
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
                        <form novalidate  id="rubahtgl" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("rm_lama/edit/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="tanggal_rm">Tanggal RM <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input id="ctrl-tanggal_rm" class="form-control datepicker  datepicker"  required="" value="<?php  echo $data['tanggal_rm']; ?>" type="datetime" name="tanggal_rm" placeholder="Enter Tanggal RM" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
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
                                                <label class="control-label" for="no_rekam_medis">No Rekam Medis <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-no_rekam_medis"  value="<?php  $norm=$data['no_rekam_medis']; echo $norm; ?>" type="text" placeholder="Enter No Rekam Medis"  readonly required="" name="no_rekam_medis"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="ctrl-no_rm_lama"  value="<?php  echo $data['no_rm_lama']; ?>" type="hidden" placeholder="Enter No Rm Lama"  required="" name="no_rm_lama"  class="form-control " />
                                        </div>
                                        <div class="form-ajax-status"></div>
                                        <div class="form-group text-center">
                                            <button class="btn btn-primary" type="button" onclick="cektglrm()">
                                                Update
                                                <i class="fa fa-send"></i>
                                            </button>
                                        </div>
                                        <script language="JavaScript">
                                            function cektglrm(){ 
                                            var tglrm = $('#ctrl-tanggal_rm').val();
                                            var morm ="<?php echo $norm;?>";
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
                                            var result = confirm('Rubah RM Lama Tanggal ' +tglrm+' ?');
                                            if (result == true) {
                                            document.getElementById("rubahtgl").submit();
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
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
