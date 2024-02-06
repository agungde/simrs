<?php 
/**
 * Resep_obat Page Controller
 * @category  Controller
 */
class Resep_obatController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "resep_obat";
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
		$fields = array("id_resep_obat", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"tanggal_lahir", 
			"setatus", 
			"pembayaran", 
			"action", 
			"pasien", 
			"nama_poli", 
			"umur", 
			"nama_dokter", 
			"tebus_resep", 
			"date_created", 
			"date_updated", 
			"id_daftar", 
			"resep", 
			"name");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(!empty($request->resep_tanggal)){
    $val = $request->resep_tanggal;
    $set = $request->resep_setatus;
    $db->where("setatus='$set' and DATE(resep_obat.tanggal)", $val , "=");
        }
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				resep_obat.id_resep_obat LIKE ? OR 
				resep_obat.tanggal LIKE ? OR 
				resep_obat.no_rekam_medis LIKE ? OR 
				resep_obat.nama_pasien LIKE ? OR 
				resep_obat.alamat LIKE ? OR 
				resep_obat.tanggal_lahir LIKE ? OR 
				resep_obat.setatus LIKE ? OR 
				resep_obat.pembayaran LIKE ? OR 
				resep_obat.action LIKE ? OR 
				resep_obat.pasien LIKE ? OR 
				resep_obat.nama_poli LIKE ? OR 
				resep_obat.umur LIKE ? OR 
				resep_obat.nama_dokter LIKE ? OR 
				resep_obat.tebus_resep LIKE ? OR 
				resep_obat.operator LIKE ? OR 
				resep_obat.date_created LIKE ? OR 
				resep_obat.date_updated LIKE ? OR 
				resep_obat.id_daftar LIKE ? OR 
				resep_obat.resep LIKE ? OR 
				resep_obat.name LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "resep_obat/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("id_resep_obat", "ASC");
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
		$page_title = $this->view->page_title = "Resep Obat";
		$view_name = (is_ajax() ? "resep_obat/ajax-list.php" : "resep_obat/list.php");
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
		$fields = array("resep_obat.id_resep_obat", 
			"resep_obat.tanggal", 
			"resep_obat.nama_pasien", 
			"resep_obat.alamat", 
			"resep_obat.tanggal_lahir", 
			"user_login.nama AS user_login_nama", 
			"resep_obat.setatus", 
			"resep_obat.action", 
			"resep_obat.pasien", 
			"resep_obat.nama_poli", 
			"resep_obat.umur", 
			"resep_obat.no_rekam_medis", 
			"resep_obat.nama_dokter", 
			"resep_obat.pembayaran", 
			"resep_obat.date_created", 
			"resep_obat.date_updated", 
			"resep_obat.id_daftar", 
			"resep_obat.resep");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("resep_obat.id_resep_obat", $rec_id);; //select record based on primary key
		}
		$db->join("user_login", "resep_obat.tanggal_lahir = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Resep Obat";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("resep_obat/view.php", $record);
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
			$fields = $this->fields = array("nama_pasien","alamat","tanggal_lahir","setatus","tanggal","nama_poli","umur","no_rekam_medis","nama_dokter","pembayaran","name");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'setatus' => 'required',
				'tanggal' => 'required',
				'nama_poli' => 'required',
				'umur' => 'required',
				'no_rekam_medis' => 'required',
				'nama_dokter' => 'required',
				'pembayaran' => 'required',
				'name' => 'required',
			);
			$this->sanitize_array = array(
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_dokter' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'name' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("resep_obat");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Resep Obat";
		$this->render_view("resep_obat/add.php");
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
		$fields = $this->fields = array("id_resep_obat","nama_pasien","alamat","tanggal_lahir","setatus","tanggal","nama_poli","umur","no_rekam_medis","nama_dokter","pembayaran","name");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'setatus' => 'required',
				'tanggal' => 'required',
				'nama_poli' => 'required',
				'umur' => 'required',
				'no_rekam_medis' => 'required',
				'nama_dokter' => 'required',
				'pembayaran' => 'required',
				'name' => 'required',
			);
			$this->sanitize_array = array(
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_dokter' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'name' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("resep_obat.id_resep_obat", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("resep_obat");
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
						return	$this->redirect("resep_obat");
					}
				}
			}
		}
		$db->where("resep_obat.id_resep_obat", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Resep Obat";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("resep_obat/edit.php", $data);
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
		$db->where("resep_obat.id_resep_obat", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("resep_obat");
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
		$fields = array("id_resep_obat", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"tanggal_lahir", 
			"umur", 
			"nama_dokter", 
			"id_daftar");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("resep_obat.id_resep_obat", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Resep Obat";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("resep_obat/obat.php", $record);
	}
}
