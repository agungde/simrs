<?php 
/**
 * Hasil_lab_luar Page Controller
 * @category  Controller
 */
class Hasil_lab_luarController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "hasil_lab_luar";
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
			"id_daftar", 
			"nama_pasien", 
			"no_rekam_medis", 
			"pasien", 
			"hasil_lab");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				hasil_lab_luar.id LIKE ? OR 
				hasil_lab_luar.id_daftar LIKE ? OR 
				hasil_lab_luar.nama_pasien LIKE ? OR 
				hasil_lab_luar.no_rekam_medis LIKE ? OR 
				hasil_lab_luar.pasien LIKE ? OR 
				hasil_lab_luar.hasil_lab LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "hasil_lab_luar/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("hasil_lab_luar.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Hasil Lab Luar";
		$this->render_view("hasil_lab_luar/list.php", $data); //render the full page
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
			"id_daftar", 
			"no_rekam_medis", 
			"nama_pasien", 
			"pasien", 
			"hasil_lab");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("hasil_lab_luar.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Hasil Lab Luar";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("hasil_lab_luar/view.php", $record);
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
			$fields = $this->fields = array("id_daftar","pasien","nama_pasien","no_rekam_medis","hasil_lab");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required',
				'pasien' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'hasil_lab' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'hasil_lab' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$pasien = $_POST['pasien'];
$this->set_flash_msg("Upload Berhasil", "success");
if($pasien=="POLI"){
$datdari = "pendaftaran_poli";
}else if($pasien=="IGD"){
$datdari = "igd";
}else if($pasien=="RAWAT INAP"){
$datdari = "rawat_ibap";
}
return  $this->redirect("$datdari");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("hasil_lab_luar");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Hasil Lab Luar";
		$this->render_view("hasil_lab_luar/add.php");
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
		$fields = $this->fields = array("id","id_daftar","pasien","nama_pasien","no_rekam_medis","hasil_lab");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required',
				'pasien' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'hasil_lab' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'hasil_lab' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				//get files link to be deleted before updating records
				$file_fields = array('hasil_lab'); //list of file fields
				$db->where("hasil_lab_luar.id", $rec_id);;
				$fields_file_paths = $db->getOne($tablename, $file_fields);
				$db->where("hasil_lab_luar.id", $rec_id);;
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
					return $this->redirect("hasil_lab_luar");
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
						return	$this->redirect("hasil_lab_luar");
					}
				}
			}
		}
		$db->where("hasil_lab_luar.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Hasil Lab Luar";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("hasil_lab_luar/edit.php", $data);
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
		//list of file fields
		$file_fields = array('hasil_lab'); 
		foreach( $arr_id as $rec_id ){
			$db->where("hasil_lab_luar.id", $arr_rec_id, "in");;
		}
		//get files link to be deleted before deleting records
		$files = $db->get($tablename, null , $file_fields); 
		$db->where("hasil_lab_luar.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			//delete files after record has been deleted
			foreach($file_fields as $field){
				$this->delete_record_files($files, $field);
			}
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("hasil_lab_luar");
	}
}
