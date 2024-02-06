<?php 
/**
 * Rm_lama Page Controller
 * @category  Controller
 */
class Rm_lamaController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "rm_lama";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"tanggal_rm", 
			"no_rekam_medis", 
			"no_rm_lama", 
			"pemeriksaan_fisik", 
			"assesment_triase", 
			"assesment_medis", 
			"catatan_medis", 
			"resep_obat", 
			"tindakan");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
if(!empty($request->datprecord)){
$idpas = $request->datprecord;
 $queryb = mysqli_query($koneksi, "select * from data_pasien WHERE id_pasien='$idpas'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
   // ambil jumlah baris data hasil query
  $rowsb = mysqli_num_rows($queryb);
  if ($rowsb <> 0) {
      $row   = mysqli_fetch_assoc($queryb); 
 $rekam=$row['no_rekam_medis'];
 }
    $db->where("no_rekam_medis='$rekam'");
}else{
    if(!empty($request->limit_start)){
        }else{
               $this->set_flash_msg("URL Tidak Valid!! ", "danger");
               //return  $this->redirect("rekam_medis");
        }
}
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				rm_lama.id LIKE ? OR 
				rm_lama.tanggal_rm LIKE ? OR 
				rm_lama.no_rekam_medis LIKE ? OR 
				rm_lama.no_rm_lama LIKE ? OR 
				rm_lama.pemeriksaan_fisik LIKE ? OR 
				rm_lama.assesment_triase LIKE ? OR 
				rm_lama.assesment_medis LIKE ? OR 
				rm_lama.catatan_medis LIKE ? OR 
				rm_lama.resep_obat LIKE ? OR 
				rm_lama.tindakan LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "rm_lama/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("rm_lama.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Rm Lama";
		$view_name = (is_ajax() ? "rm_lama/ajax-list.php" : "rm_lama/list.php");
		$this->render_view($view_name, $data);
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id", 
			"tanggal_rm", 
			"no_rekam_medis", 
			"no_rm_lama", 
			"pemeriksaan_fisik", 
			"assesment_triase", 
			"assesment_medis", 
			"catatan_medis", 
			"resep_obat", 
			"tindakan");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("rm_lama.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Rm Lama";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("rm_lama/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal_rm","no_rekam_medis","no_rm_lama");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal_rm' => 'required',
				'no_rekam_medis' => 'required',
				'no_rm_lama' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal_rm' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'no_rm_lama' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
		# Statement to execute before adding record
		$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
 if(isset($_POST['nmrm'])){
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
$ftgl = "uploads/rmlama/$postnrm/$posttgl";
//mkdir("$frm", 0770, true); 
//mkdir("$ftgl", 0770, true); 
if(is_dir($ftgl)) {
    //echo ("$file is a directory");
} else {
    mkdir("$ftgl", 0770, true); 
    // echo ("$file is not a directory");
}
$files = $_FILES;
$jumlahFile = count($files['listGambar']['name']);
for ($i = 0; $i < $jumlahFile; $i++) {
    $namaFile = $files['listGambar']['name'][$i];
    $lokasiTmp = $files['listGambar']['tmp_name'][$i];
    // echo "nama: $namaFile, tmp: {$lokasiTmp} <br>";
}
for ($i = 0; $i < $jumlahFile; $i++) {
    $namaFile = $files['listGambar']['name'][$i];
    $lokasiTmp = $files['listGambar']['tmp_name'][$i];
    # kita tambahkan uniqid() agar nama gambar bersifat unik
    $namaBaru     = uniqid() . '-' . $namaFile;
    $lokasiBaru   = "$ftgl/$namaBaru";
    $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);
    # jika proses berhasil
    if ($prosesUpload) {
    } else {
    $this->set_flash_msg("Upload Gagal Ukuran File Lebih 10MB !!", "danger");
return  $this->redirect("rm_lama/uploads?precord=$postidback&datprecord=$postidpas&rmlama=$rmlama");  
    }
}
if($postnmrm=="Pemeriksaan Fisik"){
//mysqli_query($koneksi,"UPDATE rm_lama SET pemeriksaan_fisik='$update' id='$postidrm'");
}else if($postnmrm=="Assesment Medis"){
//mysqli_query($koneksi,"UPDATE rm_lama SET assesment_medis='$update' id='$postidrm'");
}else if($postnmrm=="Assesment Triase"){
//mysqli_query($koneksi,"UPDATE rm_lama SET assesment_triase='$update' id='$postidrm'");
}else if($postnmrm=="Catatan Medis"){
//mysqli_query($koneksi,"UPDATE rm_lama SET catatan_medis='$update' id='$postidrm'");
}else if($postnmrm=="Resep Obat"){
//mysqli_query($koneksi,"UPDATE rm_lama SET resep_obat='$update' id='$postidrm'");
}else if($postnmrm=="Tindakan"){
//mysqli_query($koneksi,"UPDATE rm_lama SET tindakan='$update' id='$postidrm'");
}
$this->set_flash_msg("Uploads Berhasil", "success");
return  $this->redirect("rm_lama?precord=$postidback&datprecord=$postidpas");
}
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("rm_lama");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Rm Lama";
		$this->render_view("rm_lama/add.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","tanggal_rm","no_rekam_medis","no_rm_lama");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal_rm' => 'required',
				'no_rekam_medis' => 'required',
				'no_rm_lama' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal_rm' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'no_rm_lama' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
		# Statement to execute after adding record
		$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
$linksite="".SITE_ADDR;
$tglnew = $_POST['tanggal_rm'];
$que = mysqli_query($koneksi, "select * from rm_lama WHERE id='$rec_id'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
   // ambil jumlah baris data hasil query
  $ro = mysqli_num_rows($que);
  if ($ro <> 0) {
      $ro   = mysqli_fetch_assoc($que); 
 $tglrm=$ro['tanggal_rm'];
 $norm=$ro['no_rekam_medis'];
}
$oldname = "rmlama/$norm/$tglrm";
$newname = "rmlama/$norm/$tglnew";
rename($oldname, $newname);
		# End of before update statement
				$db->where("rm_lama.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("rm_lama");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("rm_lama");
					}
				}
			}
		}
		$db->where("rm_lama.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Rm Lama";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("rm_lama/edit.php", $data);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function rm_lama($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal_rm","no_rm_lama","no_rekam_medis");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal_rm' => 'required',
				'no_rm_lama' => 'required',
				'no_rekam_medis' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal_rm' => 'sanitize_string',
				'no_rm_lama' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
$id_user = "".USER_ID;
$dbhost="".DB_HOST;
$dbuser="".DB_USERNAME;
$dbpass="".DB_PASSWORD;
$dbname="".DB_NAME;
//$koneksi=open_connection();
$koneksi        = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$no_rekam_medis = $_POST['no_rekam_medis'];
 $querml = mysqli_query($koneksi, "select * from data_pasien WHERE no_rekam_medis='$no_rekam_medis'")  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rorml = mysqli_num_rows($querml);
  if ($rorml <> 0) {
      $dalm = mysqli_fetch_assoc($querml);
       $rmlm  = $dalm['rm'];
       $idpas = $dalm['id_pasien'];
  }
$key="dermawangroup";
$plaintext = "$rec_id";
$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
$iv = openssl_random_pseudo_bytes($ivlen);
$ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
$hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
$ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
$this->set_flash_msg("TTD Berhasil Di Buat", "success");
return  $this->redirect("rm_lama?precord=$ciphertext&datprecord=$idpas");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("rm_lama");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Rm Lama";
		$this->render_view("rm_lama/rm_lama.php");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function uploads($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal_rm","no_rekam_medis","no_rm_lama");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal_rm' => 'required',
				'no_rekam_medis' => 'required',
				'no_rm_lama' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal_rm' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'no_rm_lama' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("rm_lama");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Rm Lama";
		$this->render_view("rm_lama/uploads.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function uploadsrmlama($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","no_rekam_medis","tanggal_rm","pemeriksaan_fisik","assesment_triase","assesment_medis","catatan_medis","resep_obat","tindakan","no_rm_lama");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'no_rekam_medis' => 'required',
				'tanggal_rm' => 'required',
				'pemeriksaan_fisik' => 'required',
				'resep_obat' => 'required',
				'no_rm_lama' => 'required',
			);
			$this->sanitize_array = array(
				'no_rekam_medis' => 'sanitize_string',
				'tanggal_rm' => 'sanitize_string',
				'pemeriksaan_fisik' => 'sanitize_string',
				'assesment_triase' => 'sanitize_string',
				'assesment_medis' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
				'resep_obat' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'no_rm_lama' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				//get files link to be deleted before updating records
				$file_fields = array('pemeriksaan_fisik','assesment_triase','assesment_medis','catatan_medis','resep_obat','tindakan'); //list of file fields
				$db->where("rm_lama.id", $rec_id);;
				$fields_file_paths = $db->getOne($tablename, $file_fields);
				$db->where("rm_lama.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					if(!empty($fields_file_paths)){
						foreach($file_fields as $field){
							$files = explode(',', $fields_file_paths[$field]); // for list of files separated by comma
							foreach($files as $file){
								//delete files which are not among the submited post data
								if(stripos($modeldata[$field], $file) === false ){
									$file_dir_path = str_ireplace( SITE_ADDR , "" , $file ) ;
									@unlink($file_dir_path);
								}
							}
						}
					}
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("rm_lama");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("rm_lama");
					}
				}
			}
		}
		$db->where("rm_lama.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Rm Lama";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("rm_lama/uploadsrmlama.php", $data);
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function detile($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id", 
			"no_rekam_medis", 
			"tanggal_rm", 
			"pemeriksaan_fisik", 
			"assesment_triase", 
			"assesment_medis", 
			"catatan_medis", 
			"resep_obat", 
			"tindakan", 
			"no_rm_lama");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("rm_lama.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Rm Lama";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("rm_lama/detile.php", $record);
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function rmlama($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"no_rekam_medis", 
			"tanggal_rm", 
			"pemeriksaan_fisik", 
			"tindakan", 
			"catatan_medis", 
			"resep_obat", 
			"assesment_medis", 
			"assesment_triase", 
			"no_rm_lama");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				rm_lama.id LIKE ? OR 
				rm_lama.no_rekam_medis LIKE ? OR 
				rm_lama.tanggal_rm LIKE ? OR 
				rm_lama.pemeriksaan_fisik LIKE ? OR 
				rm_lama.tindakan LIKE ? OR 
				rm_lama.catatan_medis LIKE ? OR 
				rm_lama.resep_obat LIKE ? OR 
				rm_lama.assesment_medis LIKE ? OR 
				rm_lama.assesment_triase LIKE ? OR 
				rm_lama.no_rm_lama LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "rm_lama/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("rm_lama.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Rm Lama";
		$this->render_view("rm_lama/rmlama.php", $data); //render the full page
	}
}
