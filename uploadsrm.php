<?php
session_start();
require('config.php');


$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
$linksite="".SITE_ADDR;

if (isset($_SESSION['sesid'])) {
  //echo "Ok Sesion ".$_SESSION['sesid'];
}else{
	?>
  <script language="JavaScript">
  alert('Dilarang Akses !!');
   document.location='<?php $linksite; ?>';
   </script>
<?php
}

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
$quep = mysqli_query($koneksi, "select * from data_pasien WHERE no_rekam_medis='$norm'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
   // ambil jumlah baris data hasil query
  //$ro = mysqli_num_rows($quep);
      $data   = mysqli_fetch_assoc($quep);
//echo $tglrm;
}else{
	if(isset($_POST['idrmlama'])){
$postidrm   = $_POST['idrmlama'];
$posttgl    = $_POST['tanggal_rm'];
$postnrm    = $_POST['no_rekam_medis'];
$postidpas  = $_POST['idpas'];
$postidback = $_POST['idback'];
$postnmrm = $_POST['nmrm'];


  
 $rmlama = "";   
if($postnmrm=="Pemeriksaan Fisik"){
$rmlama = "fisik";
}else if($postnmrm=="Assesment Medis"){
$rmlama = "medis";
}else if($postnmrm=="Assesment Triase"){
$rmlama = "triase";
}else if($postnmrm=="Catatan Medis"){
$rmlama = "catat";
}else if($postnmrm=="Resep Obat"){
$rmlama = "resep";
}else if($postnmrm=="Tindakan"){
$rmlama = "tindakan";
}

//$frm  = "uploads/rmlama/$postnrm";
$ftgl = "rmlama/$postnrm/$posttgl/$rmlama";
//mkdir("$frm", 0770, true); 
//mkdir("$ftgl", 0770, true); 


if(is_dir($ftgl)) {
    //echo ("$file is a directory");
} else {
    mkdir("$ftgl", 0770, true); 
    // echo ("$file is not a directory");
}



$nfile = fopen("rmlama/index.html","w");
if($nfile){
//echo "myFile Has Been Created Successfully!";
}
else
{
//echo "File Creation Failed!";
}


$nfile = fopen("rmlama/$postnrm/index.html","w");
if($nfile){
//echo "myFile Has Been Created Successfully!";
}
else
{
//echo "File Creation Failed!";
}

$nfile = fopen("rmlama/$postnrm/$posttgl/index.html","w");
if($nfile){
//echo "myFile Has Been Created Successfully!";
}
else
{
//echo "File Creation Failed!";
}

$nfile = fopen("rmlama/$postnrm/$posttgl/$rmlama/index.html","w");
if($nfile){
//echo "myFile Has Been Created Successfully!";
}
else
{
//echo "File Creation Failed!";
}


$update="";

$limit = 10 * 1024 * 1024;
$ekstensi =  array('png','jpg','jpeg','gif');
$jumlahFile = count($_FILES['foto']['name']);
 
for($x=0; $x<$jumlahFile; $x++){
	$namafile = $_FILES['foto']['name'][$x];
	$tmp = $_FILES['foto']['tmp_name'][$x];
	$tipe_file = pathinfo($namafile, PATHINFO_EXTENSION);
	$ukuran = $_FILES['foto']['size'][$x];	
	if($ukuran > $limit){
			?>
  <script language="JavaScript">
  alert('Uploads Gagal Ukuran Melebihi 10MB!!!!');
   document.location='<?php echo "$linksite?precord=$postidback&rmlama=$rmlama"; ?>';
   </script>
<?php
		//header("location:index.php?alert=gagal_ukuran");		
	}else{
		if(!in_array($tipe_file, $ekstensi)){
				?>
  <script language="JavaScript">
  alert('Uploads Gagal Ekstensi Tidak Boleh!!');
   document.location='<?php echo "?precord=$postidback&rmlama=$rmlama"; ?>';
   </script>
<?php
		//	header("location:index.php?alert=gagal_ektensi");			
		}else{	
		
		   $namaFile = $_FILES['foto']['name'][$x];
    $lokasiTmp = $_FILES['foto']['tmp_name'][$x];

    # kita tambahkan uniqid() agar nama gambar bersifat unik
    $namaBaru     = uniqid() . '-' . $namaFile;
    $lokasiBaru   = "$ftgl/$namaBaru";
    $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);

//move_uploaded_file($tmp, '$ftgl/'.date('d-m-Y').'-'.$namafile);		
			//move_uploaded_file($tmp, '$ftgl/'.$namafile);
		//	 $lokasiBaru   = "$ftgl/$namafile";
    //$prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);
			
			
			    
 if($update==""){
$update = "$lokasiBaru";
}else{
    $update = "$update,$lokasiBaru";
}

if($postnmrm=="Pemeriksaan Fisik"){
mysqli_query($koneksi,"UPDATE rm_lama SET pemeriksaan_fisik='$update' WHERE id='$postidrm'");
}else if($postnmrm=="Assesment Medis"){
mysqli_query($koneksi,"UPDATE rm_lama SET assesment_medis='$update' WHERE id='$postidrm'");
}else if($postnmrm=="Assesment Triase"){
mysqli_query($koneksi,"UPDATE rm_lama SET assesment_triase='$update' WHERE id='$postidrm'");
}else if($postnmrm=="Catatan Medis"){
mysqli_query($koneksi,"UPDATE rm_lama SET catatan_medis='$update' WHERE id='$postidrm'");
}else if($postnmrm=="Resep Obat"){
mysqli_query($koneksi,"UPDATE rm_lama SET resep_obat='$update' WHERE id='$postidrm'");
}else if($postnmrm=="Tindakan"){
mysqli_query($koneksi,"UPDATE rm_lama SET tindakan='$update' WHERE id='$postidrm'");
}

			//$x = date('d-m-Y').'-'.$namafile;
			//mysqli_query($koneksi,"INSERT INTO gambar VALUES(NULL, '$x')");
			//header("location:index.php?alert=simpan");
			
			
		}
	}
}
$selesaiup="rm_lama?precord=$postidback&datprecord=$postidpas";

?>
  <script language="JavaScript">
  alert('Upload Berhasil!!');
   document.location='<?php echo "$linksite$selesaiup";?>';
   </script>
<?php

//$this->set_flash_msg("Uploads Berhasil", "success");
//return  $this->redirect("rm_lama?precord=$postidback&datprecord=$postidpas");
}else{
?>
  <script language="JavaScript">
  alert('Dilarang Akses URL Tidak Valid');
   document.location='<?php $linksite; ?>';
   </script>
<?php
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo "Uploads $namupload RM Lama";?></title>
    <!--   Latest compiled and minified CSS -->
    <link rel="stylesheet" href="jquery/assets/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="jquery/assets/css/bootstrap-theme.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="jquery/assets/css/style.css" media="all">
</head>
<body>
    <div class="container-fluid" style="margin-top:3%;">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>Uploads <?php echo $namupload;?></h3>
                    </div>
					<div id="page-report-body" class="">
    
    <table class="table table-hover table-borderless table-striped">
        <!-- Table Body Start -->
        <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
            
            
            <tr  class="td-no_rekam_medis" >
                <th class="title" width="30%"> No Rekam Medis: </th>
                <td class="value"> <?php echo $data['no_rekam_medis']; ?></td>
            </tr>
            
            
            <tr  class="td-nama_pasien">
                <th class="title"> Nama Pasien: </th>
                <td class="value"> <?php echo $data['nama_pasien']; ?></td>
            </tr>
            
            
            <tr  class="td-alamat">
                <th class="title"> Alamat: </th>
                <td class="value"> <?php echo $data['alamat']; ?></td>
            </tr>
            
            
            <tr  class="td-jenis_kelamin">
                <th class="title"> Jenis Kelamin: </th>
                <td class="value"> <?php echo $data['jenis_kelamin']; ?></td>
            </tr>
            
            
            <tr  class="td-tanggal_lahir">
                <th class="title"> Tanggal Lahir: </th>
                <td class="value"> <?php echo $data['tanggal_lahir']; ?></td>
            </tr>
            
            
            <tr  class="td-rm">
                <th class="title"> NO RM Lama: </th>
                <td class="value"> <?php echo $data['rm']; ?></td>
            </tr>
             <tr  class="td-rm">
                <th class="title"> TGL RM Lama: </th>
                <td class="value"> <?php echo $tglrm; ?></td>
            </tr>           
            
        </tbody>
        <!-- Table Body End -->
    </table>
</div>
                    <div class="panel-body">
                        <form novalidate id="form-upload" method="POST" action="<?php echo "$linksite/uploadsrm.php"; ?>" enctype="multipart/form-data">
 <input id="ctrl-tanggal_rm"  value="<?php echo $tglrm;?>" type="hidden" placeholder="Enter Tanggal RM"  readonly required="" name="tanggal_rm"  class="form-control " />						
             <input id="ctrl-no_rekam_medis"  value="<?php echo $norm;?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " /> 
   
                <input id="ctrl-no_rm_lama"  value="<?php echo $no_rm_lama;?>" type="hidden" placeholder="Enter No Rm Lama"  required="" name="no_rm_lama"  class="form-control " />
                    
                  <input id="ctrl-idrmlama"  value="<?php echo $original_plaintext;?>" type="hidden" required="" name="idrmlama"  class="form-control " />
                    
<input id="ctrl-nmrm"  value="<?php echo $namupload;?>" type="hidden" required="" name="nmrm"  class="form-control " />                            
 <input id="ctrl-idback"  value="<?php echo $backid;?>" type="hidden" required="" name="idback"  class="form-control " />                   
                    
  <input id="ctrl-idpas"  value="<?php echo $data['id_pasien']; ?>" type="hidden" required="" name="idpas"  class="form-control " />                 
  <div class="form-group">
                                <label for="images">Images</label>
	 <input type="file" name="foto[]" id="images" accept="image/png, image/jpeg,  image/jpg" multiple class="form-control" required="" >							
 </div>
                            <div class="form-group">
                                <div id="image_preview" style="width:100%;">

                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" id="submit-btn" type="submit">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
    </script>
</body>
</html>