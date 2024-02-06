<?php 
/**
 * Pendaftaran_operasi Page Controller
 * @category  Controller
 */
class Pendaftaran_operasiController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "pendaftaran_operasi";
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
			"tgl_operasi", 
			"tgl_lahir", 
			"umur", 
			"jenis_anastesi", 
			"jenis_operasi", 
			"dokter_pengirim", 
			"dokter_bedah", 
			"dokter_anastesi", 
			"catatan_medis", 
			"tgl_daftar", 
			"action", 
			"status", 
			"golongan_darah", 
			"resep_obat", 
			"tindakan");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				pendaftaran_operasi.id LIKE ? OR 
				pendaftaran_operasi.tgl_operasi LIKE ? OR 
				pendaftaran_operasi.tgl_lahir LIKE ? OR 
				pendaftaran_operasi.umur LIKE ? OR 
				pendaftaran_operasi.jenis_anastesi LIKE ? OR 
				pendaftaran_operasi.jenis_operasi LIKE ? OR 
				pendaftaran_operasi.dokter_pengirim LIKE ? OR 
				pendaftaran_operasi.dokter_bedah LIKE ? OR 
				pendaftaran_operasi.dokter_anastesi LIKE ? OR 
				pendaftaran_operasi.catatan_medis LIKE ? OR 
				pendaftaran_operasi.tgl_daftar LIKE ? OR 
				pendaftaran_operasi.action LIKE ? OR 
				pendaftaran_operasi.status LIKE ? OR 
				pendaftaran_operasi.golongan_darah LIKE ? OR 
				pendaftaran_operasi.resep_obat LIKE ? OR 
				pendaftaran_operasi.tindakan LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "pendaftaran_operasi/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("pendaftaran_operasi.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Pendaftaran Operasi";
		$this->render_view("pendaftaran_operasi/list.php", $data); //render the full page
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
			"tgl_operasi", 
			"tgl_lahir", 
			"umur", 
			"jenis_anastesi", 
			"jenis_operasi", 
			"dokter_pengirim", 
			"dokter_bedah", 
			"dokter_anastesi", 
			"catatan_medis", 
			"tgl_daftar", 
			"action", 
			"status", 
			"golongan_darah", 
			"resep_obat", 
			"tindakan");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("pendaftaran_operasi.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Pendaftaran Operasi";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("pendaftaran_operasi/view.php", $record);
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
			$fields = $this->fields = array("tgl_operasi","tgl_lahir","umur","jenis_anastesi","jenis_operasi","dokter_pengirim","dokter_bedah","dokter_anastesi","catatan_medis","tgl_daftar","action","status","golongan_darah","resep_obat","tindakan");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tgl_operasi' => 'required',
				'tgl_lahir' => 'required',
				'umur' => 'required',
				'jenis_anastesi' => 'required',
				'jenis_operasi' => 'required',
				'dokter_pengirim' => 'required',
				'dokter_bedah' => 'required',
				'dokter_anastesi' => 'required',
				'catatan_medis' => 'required',
				'tgl_daftar' => 'required',
				'action' => 'required',
				'status' => 'required',
				'golongan_darah' => 'required',
				'resep_obat' => 'required',
				'tindakan' => 'required',
			);
			$this->sanitize_array = array(
				'tgl_operasi' => 'sanitize_string',
				'tgl_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'jenis_anastesi' => 'sanitize_string',
				'jenis_operasi' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
				'dokter_bedah' => 'sanitize_string',
				'dokter_anastesi' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
				'tgl_daftar' => 'sanitize_string',
				'action' => 'sanitize_string',
				'status' => 'sanitize_string',
				'golongan_darah' => 'sanitize_string',
				'resep_obat' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pendaftaran_operasi");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pendaftaran Operasi";
		$this->render_view("pendaftaran_operasi/add.php");
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
		$fields = $this->fields = array("id","tgl_operasi","tgl_lahir","umur","jenis_anastesi","jenis_operasi","dokter_pengirim","dokter_bedah","dokter_anastesi","catatan_medis","tgl_daftar","action","status","golongan_darah","resep_obat","tindakan");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tgl_operasi' => 'required',
				'tgl_lahir' => 'required',
				'umur' => 'required',
				'jenis_anastesi' => 'required',
				'jenis_operasi' => 'required',
				'dokter_pengirim' => 'required',
				'dokter_bedah' => 'required',
				'dokter_anastesi' => 'required',
				'catatan_medis' => 'required',
				'tgl_daftar' => 'required',
				'action' => 'required',
				'status' => 'required',
				'golongan_darah' => 'required',
				'resep_obat' => 'required',
				'tindakan' => 'required',
			);
			$this->sanitize_array = array(
				'tgl_operasi' => 'sanitize_string',
				'tgl_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'jenis_anastesi' => 'sanitize_string',
				'jenis_operasi' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
				'dokter_bedah' => 'sanitize_string',
				'dokter_anastesi' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
				'tgl_daftar' => 'sanitize_string',
				'action' => 'sanitize_string',
				'status' => 'sanitize_string',
				'golongan_darah' => 'sanitize_string',
				'resep_obat' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("pendaftaran_operasi.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("pendaftaran_operasi");
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
						return	$this->redirect("pendaftaran_operasi");
					}
				}
			}
		}
		$db->where("pendaftaran_operasi.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Pendaftaran Operasi";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("pendaftaran_operasi/edit.php", $data);
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
		$db->where("pendaftaran_operasi.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("pendaftaran_operasi");
	}
}
