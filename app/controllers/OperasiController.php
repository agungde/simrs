<?php 
/**
 * Operasi Page Controller
 * @category  Controller
 */
class OperasiController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "operasi";
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
			"tanggal_daftar", 
			"dokter_pengirim", 
			"tanggal_operasi", 
			"dokter_operasi", 
			"action", 
			"no_rekam_medis", 
			"nama_pasien", 
			"tanggal_lahir", 
			"umur", 
			"operator", 
			"date_created", 
			"date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				operasi.id LIKE ? OR 
				operasi.id_daftar LIKE ? OR 
				operasi.tanggal_daftar LIKE ? OR 
				operasi.dokter_pengirim LIKE ? OR 
				operasi.tanggal_operasi LIKE ? OR 
				operasi.dokter_operasi LIKE ? OR 
				operasi.action LIKE ? OR 
				operasi.no_rekam_medis LIKE ? OR 
				operasi.nama_pasien LIKE ? OR 
				operasi.tanggal_lahir LIKE ? OR 
				operasi.umur LIKE ? OR 
				operasi.operator LIKE ? OR 
				operasi.date_created LIKE ? OR 
				operasi.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "operasi/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("operasi.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Operasi";
		$view_name = (is_ajax() ? "operasi/ajax-list.php" : "operasi/list.php");
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
			"tanggal_daftar", 
			"dokter_pengirim", 
			"tanggal_operasi", 
			"dokter_operasi", 
			"action", 
			"no_rekam_medis", 
			"nama_pasien", 
			"tanggal_lahir", 
			"umur");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("operasi.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Operasi";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("operasi/view.php", $record);
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
			$fields = $this->fields = array("id_daftar","tanggal_daftar","dokter_pengirim","tanggal_operasi","dokter_operasi","no_rekam_medis","nama_pasien","tanggal_lahir","umur");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required',
				'tanggal_daftar' => 'required',
				'dokter_pengirim' => 'required|numeric',
				'tanggal_operasi' => 'required',
				'dokter_operasi' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'tanggal_lahir' => 'required',
				'umur' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'tanggal_daftar' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
				'tanggal_operasi' => 'sanitize_string',
				'dokter_operasi' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("operasi");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Operasi";
		$this->render_view("operasi/add.php");
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
		$fields = $this->fields = array("id","tanggal_daftar","dokter_pengirim","tanggal_operasi","dokter_operasi","no_rekam_medis","nama_pasien","tanggal_lahir","umur");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal_daftar' => 'required',
				'dokter_pengirim' => 'required|numeric',
				'tanggal_operasi' => 'required',
				'dokter_operasi' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'tanggal_lahir' => 'required',
				'umur' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal_daftar' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
				'tanggal_operasi' => 'sanitize_string',
				'dokter_operasi' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("operasi.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("operasi");
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
						return	$this->redirect("operasi");
					}
				}
			}
		}
		$db->where("operasi.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Operasi";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("operasi/edit.php", $data);
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
		$db->where("operasi.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("operasi");
	}
}
