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
                    <h4 class="record-title"><?php
                        if(!empty($_GET['rmlama'])){
                        if($_GET['rmlama']=="fisik"){
                        $namupload="Pemeriksaan Fisik";
                        }else if($_GET['rmlama']=="medis"){
                        $namupload="Assesment Medis";
                        }else if($_GET['rmlama']=="triase"){
                        $namupload="Assesment Triase";
                        }else if($_GET['rmlama']=="catat"){
                        $namupload="Catatan Medis";
                        }else if($_GET['rmlama']=="resep"){
                        $namupload="Resep Obat";
                        }else if($_GET['rmlama']=="tindakan"){
                        $namupload="Tindakan";
                        }
                        }else{
                        $namupload="";  
                        } 
                        echo "Uploads $namupload RM Lama";
                        ?>
                    </h4>
                    <div class=""><div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        if(isset($_POST['listGambar'])){
                        ?>
                        <script language="JavaScript">
                            alert('Tes Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php
                        }
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
                        <?php }
                        if(!empty($_GET['precord'])){
                        $ciphertext=$_GET['precord'];
                        $backid=$ciphertext;
                        $ciphertext=str_replace(' ', '+', $ciphertext);
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
                        $que = mysqli_query($koneksi, "select * from rm_lama WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        // ambil jumlah baris data hasil query
                        $ro = mysqli_num_rows($que);
                        if ($ro <> 0) {
                        $ro   = mysqli_fetch_assoc($que); 
                        $tglrm=$ro['tanggal_rm'];
                        }
                        }
                        ?>    
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
            <div class="col-sm-8 comp-grid">
                <div class=" ">
                    <?php  
                    $this->render_page("data_pasien/pasien/$_GET[datprecord]"); 
                    ?>
                </div>
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form id="rm_lama-uploads-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("rm_lama/add?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="tanggal_rm">Tanggal RM <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input id="ctrl-tanggal_rm"  value="<?php echo $tglrm;?>" type="text" placeholder="Enter Tanggal RM"  readonly required="" name="tanggal_rm"  class="form-control " />
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                    <input id="ctrl-no_rm_lama"  value="<?php echo $no_rm_lama;?>" type="hidden" placeholder="Enter No Rm Lama"  required="" name="no_rm_lama"  class="form-control " />
                                        <input id="ctrl-idrmlama"  value="<?php echo $original_plaintext;?>" type="hidden" required="" name="idrmlama"  class="form-control " />
                                            <input id="ctrl-nmrm"  value="<?php echo $namupload;?>" type="hidden" required="" name="nmrm"  class="form-control " />                            
                                                <input id="ctrl-idback"  value="<?php echo $backid;?>" type="hidden" required="" name="idback"  class="form-control " />                   
                                                    <input id="ctrl-idpas"  value="<?php echo $idpas;?>" type="hidden" required="" name="idpas"  class="form-control " />                   
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <link rel="stylesheet" href="jquery/assets/css/style.css" media="all">
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label for="images">Uploas <?php echo $namupload;?> RM Lama</label>
                                                                <input type="file" name="listGambar[]" id="images" accept="image/png, image/jpeg,  image/jpg"
                                                                    multiple class="form-control" required="">
                                                                </div>
                                                                <div class="form-group">
                                                                    <div id="image_preview" style="width:100%;">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <button class="btn btn-primary btn-block" id="submit-btn">Uploads</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <script src="jquery/assets/js/jquery-3-3-1.min.js"></script>
                                                        <!-- Latest compiled and minified JavaScript -->
                                                        <script src="jquery/assets/js/bootstrap.min.js"></script>
                                                        <script src="jquery/assets/js/jquery.validate.min.js"></script>
                                                        <script src="jquery/assets/js/additional-methods.js"></script>
                                                        <script>
                                                            $(document).ready(function(){
                                                            $.validator.addMethod('maxSize', function (value, element, param) {
                                                            return this.optional(element) || (element.files[0].size <= param)
                                                            }, 'File size must be less than {0} KB');
                                                            $('#form-upload').validate({
                                                            /* maxSize value should be provided in kb e.g (1048576 * 1) for 1MB */
                                                            rules: {
                                                            "images[]": { required: true,  accept:"image/jpeg,image/png", maxSize: 1048576}
                                                            },
                                                            messages: {
                                                            "images[]": {
                                                            required: 'No file has been chosen yet.',
                                                            accept: 'Please upload .png or .jpg or .jpeg format',
                                                            maxSize: `Image size cannot be greater than {0} KB.`
                                                            }
                                                            },
                                                            onblur: "true",
                                                            onfocus: "true",
                                                            errorClass: "help-block",
                                                            errorElement: "strong",
                                                            highlight: function (element) {
                                                            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                                                            },
                                                            unhighlight: function (element) {
                                                            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                                                            },
                                                            errorPlacement: function (error, element) {
                                                            if (element.parent('input-group').length) {
                                                            error.insertAfter(element.parent())
                                                            return false
                                                            } else {
                                                            error.insertAfter(element)
                                                            return false
                                                            }
                                                            }
                                                            });
                                                            var fileArr = [];
                                                            $("#images").change(function () {
                                                            // check if fileArr length is greater than 0
                                                            if (fileArr.length > 0) fileArr = [];
                                                            $('#image_preview').html("");
                                                            var total_file = document.getElementById("images").files;
                                                            var i;
                                                            if (!total_file.length) return;
                                                            for (i = 0; i < total_file.length; i++) {
                                                            if (total_file[i].size > 1048576) {
                                                            document.querySelector('#submit-btn').setAttribute('disabled', true);
                                                            return false;
                                                            } else {
                                                            fileArr.push(total_file[i]);
                                                            $('#image_preview').append("<div class='img-div' id='img-div" + i + "'><img src='" + URL.createObjectURL(event.target.files[i]) + "' class='img-responsive image img-thumbnail'><div class='middle'><button id='action-icon' value='img-div" + i + "' class='btn btn-danger' role='" + total_file[i].name + "'><i class='glyphicon glyphicon-trash'></i></button></div></div><div class='clear-fix'></div>");
                                                                $('#submit-btn').prop('disabled', false);
                                                                }
                                                                }
                                                                });
                                                                $('body').on('click', '#action-icon', function (evt) {
                                                                var divName = this.value;
                                                                var fileName = $(this).attr('role');
                                                                var total_file = fileArr;
                                                                for (var i = 0; i < fileArr.length; i++) {
                                                                if (fileArr[i].name === fileName) {
                                                                fileArr.splice(i, 1);
                                                                }
                                                                }
                                                                document.getElementById('images').files = FileListItem(fileArr);
                                                                $(`#${divName}`).remove();
                                                                evt.preventDefault();
                                                                })
                                                                })
                                                                function FileListItem(file) {
                                                                file = [].slice.call(Array.isArray(file) ? file : arguments)
                                                                for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
                                                                if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
                                                                for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
                                                                return b.files
                                                                }
                                                            </script></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
