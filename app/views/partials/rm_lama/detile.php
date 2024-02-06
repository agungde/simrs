<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("rm_lama/add");
$can_edit = ACL::is_allowed("rm_lama/edit");
$can_view = ACL::is_allowed("rm_lama/view");
$can_delete = ACL::is_allowed("rm_lama/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "view-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data Information from Controller
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title"><?php
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        $linksite="".SITE_ADDR;
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
                        $norm=$ro['no_rekam_medis'];
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php $linksite; ?>';
                        </script>
                        <?php   
                        }
                        }
                        echo "View $namupload RM Lama";
                    ?></h4>
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
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="card animated fadeIn page-content">
                        <?php
                        $linksite="".SITE_ADDR;
                        $rootdir="".ROOT;
                        if(!empty($_GET['rmlama'])){
                        $rmlama=$_GET['rmlama'];
                        }
                        $dirurlimg="rmlama/$norm/$tglrm/$rmlama";
                        $dir = $rootdir."rmlama/$norm/$tglrm/$rmlama";
                        $file_display = array('jpg', 'jpeg', 'png', 'gif');
                        if (file_exists($dir) == false) 
                        {
                        echo "Data Halaman Tidak Valid";
                        // echo 'Directory "', $dir, '" not found!';
                        } 
                        else 
                        {
                        if(!empty($_GET['action'])){
                        if($_GET['action']=="hapus"){
                        $namafile= $_GET['file']; 
                        $datfile="$dir/$namafile";
                        if (file_exists($datfile)) 
                        {
                        unlink($datfile);
                        // echo "File Successfully Delete."; 
                        ?>
                        <script language="JavaScript">
                            alert('File Berhasil Di Hapus');
                            // location.reload(); 
                            document.location='<?php print_link("rm_lama/detile/$page_id?precord=$backid&datprecord=$datprecord&rmlama=$rmlama"); ?>';
                        </script>
                        <?php                
                        }
                        else
                        {
                        ?>
                        <script language="JavaScript">
                            alert('File Tidak Ada!!');
                            document.location='<?php print_link("rm_lama/detile/$page_id?precord=$backid&datprecord=$datprecord&rmlama=$rmlama"); ?>';
                        </script>
                        <?php                    
                        //  echo "File does not exists"; 
                        }  
                        } 
                        }     
                        $dir_contents = scandir($dir);
                        foreach ($dir_contents as $file) 
                        {
                        $file_type = strtolower(end(explode('.', $file)));
                        if ($file !== '.' && $file !== '..' && in_array($file_type, $file_display) == true)     
                        {
                        $datprecord=$_GET['datprecord'];
                        $name = basename($file);
                        $tesimg="$linksite$dirurlimg/$name";
                        $urlimg="$dirurlimg/$name";             
                        ?>
                        <img class="img-fluid" src="<?php print_link(set_img_src($urlimg)); ?>" />
                            <a style="margin-bottom:15px;" class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php  print_link("rm_lama/detile/$page_id?precord=$backid&datprecord=$datprecord&rmlama=$rmlama&action=hapus&file=$name");?>" data-prompt-msg="Anda Yakin Hapus Data ini?" data-display-style="modal">                         
                                <i class="fa fa-times"></i>
                                Hapus File ini
                            </a> 
                        </br>
                        <?php
                        }
                        }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
