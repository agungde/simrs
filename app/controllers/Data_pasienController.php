<?php 
/**
 * Data_pasien Page Controller
 * @category  Controller
 */
class Data_pasienController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_pasien";
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
		$fields = array("data_pasien.id_pasien", 
			"data_pasien.no_rekam_medis", 
			"data_pasien.no_ktp", 
			"data_pasien.rm", 
			"data_pasien.tl", 
			"data_pasien.nama_pasien", 
			"data_pasien.alamat", 
			"data_pasien.action", 
			"data_pasien.tanggal_lahir", 
			"data_pasien.no_hp", 
			"data_pasien.jenis_kelamin", 
			"data_pasien.umur", 
			"data_pasien.email", 
			"data_pasien.photo", 
			"data_pasien.nokk", 
			"data_pasien.namaortu", 
			"data_pasien.operator", 
			"user_login.nama AS user_login_nama", 
			"data_pasien.date_created", 
			"data_pasien.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_pasien.id_pasien LIKE ? OR 
				data_pasien.no_rekam_medis LIKE ? OR 
				data_pasien.no_ktp LIKE ? OR 
				data_pasien.rm LIKE ? OR 
				data_pasien.tl LIKE ? OR 
				data_pasien.nama_pasien LIKE ? OR 
				data_pasien.alamat LIKE ? OR 
				data_pasien.action LIKE ? OR 
				data_pasien.tanggal_lahir LIKE ? OR 
				data_pasien.no_hp LIKE ? OR 
				data_pasien.jenis_kelamin LIKE ? OR 
				data_pasien.umur LIKE ? OR 
				data_pasien.email LIKE ? OR 
				data_pasien.photo LIKE ? OR 
				data_pasien.nokk LIKE ? OR 
				data_pasien.namaortu LIKE ? OR 
				data_pasien.id_user LIKE ? OR 
				data_pasien.operator LIKE ? OR 
				data_pasien.date_created LIKE ? OR 
				data_pasien.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_pasien/search.php";
		}
		$db->join("user_login", "data_pasien.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_pasien.id_pasien", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Pasien";
		$view_name = (is_ajax() ? "data_pasien/ajax-list.php" : "data_pasien/list.php");
		$this->render_view($view_name, $data);
	}
	/**
     * Load csv data
     * @return data
     */
	function import_data(){
		if(!empty($_FILES['file'])){
			$finfo = pathinfo($_FILES['file']['name']);
			$ext = strtolower($finfo['extension']);
			if(!in_array($ext , array('csv'))){
				$this->set_flash_msg("File format not supported", "danger");
			}
			else{
			$file_path = $_FILES['file']['tmp_name'];
				if(!empty($file_path)){
					$request = $this->request;
					$db = $this->GetModel();
					$tablename = $this->tablename;
					$options = array('table' => $tablename, 'fields' => '', 'delimiter' => ',', 'quote' => '"');
					$data = $db->loadCsvData( $file_path , $options , false );
					if($db->getLastError()){
						$this->set_flash_msg($db->getLastError(), "danger");
					}
					else{
						$this->set_flash_msg("Data imported successfully", "success");
					}
				}
				else{
					$this->set_flash_msg("Error uploading file", "danger");
				}
			}
		}
		else{
			$this->set_flash_msg("No file selected for upload", "warning");
		}
		$this->redirect("data_pasien");
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
		$fields = array("data_pasien.id_pasien", 
			"data_pasien.no_rekam_medis", 
			"data_pasien.no_ktp", 
			"data_pasien.rm", 
			"data_pasien.tl", 
			"data_pasien.nama_pasien", 
			"user_login.nama AS user_login_nama", 
			"data_pasien.tanggal_lahir", 
			"data_pasien.no_hp", 
			"data_pasien.alamat", 
			"data_pasien.jenis_kelamin", 
			"data_pasien.umur", 
			"data_pasien.email", 
			"data_pasien.nokk", 
			"data_pasien.photo", 
			"data_pasien.action", 
			"data_pasien.operator", 
			"user_login.nama AS user_login_nama", 
			"data_pasien.date_created", 
			"data_pasien.date_updated", 
			"data_pasien.namaortu");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_pasien.id_pasien", $rec_id);; //select record based on primary key
		}
		$db->join("user_login", "data_pasien.nama_pasien = user_login.id_userlogin", "INNER");
		$db->join("user_login", "data_pasien.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Pasien";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_pasien/view.php", $record);
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
			$fields = $this->fields = array("no_ktp","tl","rm","nama_pasien","tanggal_lahir","no_hp","alamat","jenis_kelamin","nokk","namaortu","email","photo");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'no_ktp' => 'required|max_len,16|min_len,16',
				'nama_pasien' => 'required',
				'tanggal_lahir' => 'required',
				'no_hp' => 'required',
				'alamat' => 'required',
				'jenis_kelamin' => 'required',
				'nokk' => 'required',
				'namaortu' => 'required',
				'email' => 'valid_email',
			);
			$this->sanitize_array = array(
				'no_ktp' => 'sanitize_string',
				'tl' => 'sanitize_string',
				'rm' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'nokk' => 'sanitize_string',
				'namaortu' => 'sanitize_string',
				'email' => 'sanitize_string',
				'photo' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			$db->where("no_ktp", $modeldata['no_ktp']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['no_ktp']." Already exist!";
			}
			//Check if Duplicate Record Already Exit In The Database
			$db->where("rm", $modeldata['rm']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['rm']." Already exist!";
			} 
			if($this->validated()){
		# Statement to execute before adding record
		$nama_pasien   = $_POST['nama_pasien'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$no_ktp        = $_POST['no_ktp'];
$cek           = $db->rawQuery("select * from data_pasien WHERE nama_pasien='$nama_pasien' and tanggal_lahir='$tanggal_lahir'");
if($cek){
    $this->set_flash_msg("Data Pasien Sudah Ada ", "warning");
 return  $this->redirect("data_pasien/add");
}
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
//$nama_pasien   = $_POST['nama_pasien'];
//$tanggal_lahir = $_POST['tanggal_lahir'];
//$no_ktp        = $_POST['no_ktp'];
$db->rawQuery("UPDATE data_pasien SET operator='".USER_ID."', no_rekam_medis='RMP$rec_id' WHERE id_pasien='$rec_id'");
  $dapas = mysqli_query($koneksi,"select * from data_pasien WHERE no_ktp='$no_ktp'");
  $ropas = mysqli_num_rows($dapas);
  if ($ropas  <> 0) {
      $datapas = mysqli_fetch_assoc($dapas);
       $no_rekam_medis = $datapas['no_rekam_medis'];
       $tanggal_lahir  = $datapas['tanggal_lahir'];
       $no_ktp         = $datapas['no_ktp'];
       $email          = $datapas['email'];
  } 
  $thn = substr($tanggal_lahir, 0, 4);
    $taun = date("Y");
    $umur = $taun - $thn;
    $umur = substr($umur, 0, 2);
function hitung_umur($thn){
    $birthDate = new DateTime($thn);
    $today = new DateTime("today");
    if ($birthDate > $today) { 
        exit("0 tahun 0 bulan 0 hari");
    }
    $y = $today->diff($birthDate)->y;
    $m = $today->diff($birthDate)->m;
    $d = $today->diff($birthDate)->d;
    return $y."Tahun ".$m."Bulan ".$d."Hari";
}
$umurnya = hitung_umur("$tanggal_lahir");
$db->rawQuery("UPDATE data_pasien SET umur='$umurnya' WHERE id_pasien='$rec_id'");
$password_hash = password_hash("$no_rekam_medis", PASSWORD_DEFAULT);
mysqli_query($koneksi,"INSERT INTO `user_login` (`no_ktp`,`nama`, `username`, `email`, `password`, `user_role_id`) VALUES ('$no_ktp','$nama_pasien','$no_ktp', '$email', '$password_hash', '2')"); 
 $pasceku = mysqli_query($koneksi,"select * from user_login WHERE no_ktp='$no_ktp'");
$ropasu = mysqli_num_rows($pasceku);
  if ($ropasu  <> 0) {
      $datauser = mysqli_fetch_assoc($pasceku);
     $iduserlogin=$datauser['id_userlogin'];
  mysqli_query($koneksi, "UPDATE data_pasien SET id_user='$iduserlogin' WHERE id_pasien='$rec_id'");
  }
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_pasien");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Pasien";
		$this->render_view("data_pasien/add.php");
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
		$fields = $this->fields = array("id_pasien","no_ktp","tl","rm","nama_pasien","tanggal_lahir","no_hp","alamat","jenis_kelamin","nokk","namaortu","email","photo");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'no_ktp' => 'required|max_len,16|min_len,16',
				'nama_pasien' => 'required',
				'tanggal_lahir' => 'required',
				'no_hp' => 'required',
				'alamat' => 'required',
				'jenis_kelamin' => 'required',
				'nokk' => 'required',
				'namaortu' => 'required',
				'email' => 'valid_email',
			);
			$this->sanitize_array = array(
				'no_ktp' => 'sanitize_string',
				'tl' => 'sanitize_string',
				'rm' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'nokk' => 'sanitize_string',
				'namaortu' => 'sanitize_string',
				'email' => 'sanitize_string',
				'photo' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['no_ktp'])){
				$db->where("no_ktp", $modeldata['no_ktp'])->where("id_pasien", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['no_ktp']." Already exist!";
				}
			}
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['rm'])){
				$db->where("rm", $modeldata['rm'])->where("id_pasien", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['rm']." Already exist!";
				}
			} 
			if($this->validated()){
				$db->where("data_pasien.id_pasien", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			$db->rawQuery("UPDATE data_pasien SET operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id_pasien='$rec_id'");
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_pasien");
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
						return	$this->redirect("data_pasien");
					}
				}
			}
		}
		$db->where("data_pasien.id_pasien", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Pasien";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_pasien/edit.php", $data);
	}
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("data_pasien.id_pasien", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("data_pasien");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function rekap_pasien($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id_pasien", 
			"no_rekam_medis", 
			"nama_pasien", 
			"nokk", 
			"namaortu", 
			"tl", 
			"rm");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_pasien.id_pasien LIKE ? OR 
				data_pasien.no_rekam_medis LIKE ? OR 
				data_pasien.nama_pasien LIKE ? OR 
				data_pasien.tanggal_lahir LIKE ? OR 
				data_pasien.no_hp LIKE ? OR 
				data_pasien.alamat LIKE ? OR 
				data_pasien.jenis_kelamin LIKE ? OR 
				data_pasien.umur LIKE ? OR 
				data_pasien.email LIKE ? OR 
				data_pasien.photo LIKE ? OR 
				data_pasien.date_created LIKE ? OR 
				data_pasien.action LIKE ? OR 
				data_pasien.id_user LIKE ? OR 
				data_pasien.no_ktp LIKE ? OR 
				data_pasien.operator LIKE ? OR 
				data_pasien.date_updated LIKE ? OR 
				data_pasien.nokk LIKE ? OR 
				data_pasien.namaortu LIKE ? OR 
				data_pasien.tl LIKE ? OR 
				data_pasien.rm LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_pasien/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_pasien.id_pasien", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Pasien";
		$this->render_view("data_pasien/rekap_pasien.php", $data); //render the full page
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function pasien($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id_pasien", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"jenis_kelamin", 
			"tanggal_lahir", 
			"umur", 
			"rm");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_pasien.id_pasien", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Pasien";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_pasien/pasien.php", $record);
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function obat($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id_pasien", 
			"no_rekam_medis", 
			"tl", 
			"nama_pasien", 
			"alamat", 
			"tanggal_lahir", 
			"jenis_kelamin", 
			"umur");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_pasien.id_pasien", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Pasien";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_pasien/obat.php", $record);
	}
}
