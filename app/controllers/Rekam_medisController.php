<?php 
/**
 * Rekam_medis Page Controller
 * @category  Controller
 */
class Rekam_medisController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "rekam_medis";
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
		$fields = array("id_rekam_medis", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"action", 
			"rm_lama", 
			"jenis_kelamin", 
			"tanggal_lahir", 
			"umur", 
			"no_hp", 
			"email");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				rekam_medis.id_rekam_medis LIKE ? OR 
				rekam_medis.no_rekam_medis LIKE ? OR 
				rekam_medis.nama_pasien LIKE ? OR 
				rekam_medis.alamat LIKE ? OR 
				rekam_medis.action LIKE ? OR 
				rekam_medis.rm_lama LIKE ? OR 
				rekam_medis.jenis_kelamin LIKE ? OR 
				rekam_medis.tanggal_lahir LIKE ? OR 
				rekam_medis.umur LIKE ? OR 
				rekam_medis.no_hp LIKE ? OR 
				rekam_medis.email LIKE ? OR 
				rekam_medis.date_created LIKE ? OR 
				rekam_medis.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "rekam_medis/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("rekam_medis.id_rekam_medis", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Rekam Medis";
		$this->render_view("rekam_medis/list.php", $data); //render the full page
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
		$fields = array("id_rekam_medis", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"no_hp", 
			"email", 
			"jenis_kelamin", 
			"tanggal_lahir", 
			"umur");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("rekam_medis.id_rekam_medis", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Rekam Medis";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("rekam_medis/view.php", $record);
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
			$fields = $this->fields = array("no_rekam_medis","nama_pasien","alamat","no_hp","email","jenis_kelamin","tanggal_lahir","umur");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'email' => 'required',
				'jenis_kelamin' => 'required',
				'tanggal_lahir' => 'required',
				'umur' => 'required',
			);
			$this->sanitize_array = array(
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'email' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("rekam_medis");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Rekam Medis";
		$this->render_view("rekam_medis/add.php");
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
		$fields = $this->fields = array("id_rekam_medis","no_rekam_medis","nama_pasien","alamat","no_hp","email","jenis_kelamin","tanggal_lahir","umur");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'email' => 'required',
				'jenis_kelamin' => 'required',
				'tanggal_lahir' => 'required',
				'umur' => 'required',
			);
			$this->sanitize_array = array(
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'email' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("rekam_medis.id_rekam_medis", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("rekam_medis");
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
						return	$this->redirect("rekam_medis");
					}
				}
			}
		}
		$db->where("rekam_medis.id_rekam_medis", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Rekam Medis";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("rekam_medis/edit.php", $data);
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
		$db->where("rekam_medis.id_rekam_medis", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("rekam_medis");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function resep($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("no_rekam_medis","nama_pasien","alamat","no_hp","email","jenis_kelamin","umur","tanggal_lahir","action","rm_lama");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required|numeric',
				'email' => 'required|valid_email',
				'jenis_kelamin' => 'required',
				'umur' => 'required',
				'tanggal_lahir' => 'required',
				'action' => 'required',
				'rm_lama' => 'required',
			);
			$this->sanitize_array = array(
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'email' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'action' => 'sanitize_string',
				'rm_lama' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("rekam_medis");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Rekam Medis";
		$this->render_view("rekam_medis/resep.php");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function history($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id_rekam_medis", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"jenis_kelamin", 
			"action");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	 $id_user = "".USER_ID;
 $dbhost="".DB_HOST;
$dbuser="".DB_USERNAME;
$dbpass="".DB_PASSWORD;
$dbname="".DB_NAME;
//$koneksi=open_connection();
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$sqlcek  = mysqli_query($koneksi,"select * from user_login WHERE id_userlogin='$id_user'");
while ($row=mysqli_fetch_array($sqlcek)){
    $cekdata = trim($row['user_role_id']);
}
if($cekdata=="2"){
$sqlcekb = mysqli_query($koneksi,"select * from biodata WHERE id_user='$id_user'");
while ($rowb=mysqli_fetch_array($sqlcekb)){
    $no_rekam_medis = trim($rowb['no_rekam_medis']);
}
$db->where("no_rekam_medis='$no_rekam_medis'");
}else{}
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				rekam_medis.id_rekam_medis LIKE ? OR 
				rekam_medis.no_rekam_medis LIKE ? OR 
				rekam_medis.nama_pasien LIKE ? OR 
				rekam_medis.alamat LIKE ? OR 
				rekam_medis.no_hp LIKE ? OR 
				rekam_medis.email LIKE ? OR 
				rekam_medis.jenis_kelamin LIKE ? OR 
				rekam_medis.tanggal_lahir LIKE ? OR 
				rekam_medis.umur LIKE ? OR 
				rekam_medis.date_created LIKE ? OR 
				rekam_medis.date_updated LIKE ? OR 
				rekam_medis.action LIKE ? OR 
				rekam_medis.rm_lama LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "rekam_medis/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("rekam_medis.id_rekam_medis", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Rekam Medis";
		$this->render_view("rekam_medis/history.php", $data); //render the full page
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
		$fields = array("id_rekam_medis", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"jenis_kelamin", 
			"tanggal_lahir", 
			"umur");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("rekam_medis.id_rekam_medis", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Rekam Medis";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("rekam_medis/detile.php", $record);
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function catatan($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id_rekam_medis", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"jenis_kelamin", 
			"tanggal_lahir", 
			"umur", 
			"no_hp", 
			"email");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("rekam_medis.id_rekam_medis", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Rekam Medis";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("rekam_medis/catatan.php", $record);
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
		$fields = array("id_rekam_medis", 
			"no_rekam_medis", 
			"nama_pasien", 
			"jenis_kelamin", 
			"tanggal_lahir", 
			"alamat", 
			"no_hp", 
			"email", 
			"umur");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("rekam_medis.id_rekam_medis", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Riwayat Resep Obat";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("rekam_medis/obat.php", $record);
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function tindakan($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id_rekam_medis", 
			"no_rekam_medis", 
			"nama_pasien", 
			"jenis_kelamin", 
			"tanggal_lahir", 
			"umur", 
			"alamat", 
			"no_hp", 
			"email");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("rekam_medis.id_rekam_medis", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Rekam Medis Tindakan";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("rekam_medis/tindakan.php", $record);
	}
}
