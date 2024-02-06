<?php 
/**
 * Data_rm Page Controller
 * @category  Controller
 */
class Data_rmController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_rm";
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
			"tanggal", 
			"jam", 
			"no_rekam_medis", 
			"rm_lama", 
			"nama_pasien", 
			"pendaftaran_poli", 
			"igd", 
			"rawat_inap", 
			"setatus");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_rm.id LIKE ? OR 
				data_rm.id_daftar LIKE ? OR 
				data_rm.tanggal LIKE ? OR 
				data_rm.jam LIKE ? OR 
				data_rm.no_rekam_medis LIKE ? OR 
				data_rm.rm_lama LIKE ? OR 
				data_rm.nama_pasien LIKE ? OR 
				data_rm.pendaftaran_poli LIKE ? OR 
				data_rm.igd LIKE ? OR 
				data_rm.rawat_inap LIKE ? OR 
				data_rm.setatus LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_rm/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_rm.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Rm";
		$this->render_view("data_rm/list.php", $data); //render the full page
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
			"tanggal", 
			"jam", 
			"no_rekam_medis", 
			"rm_lama", 
			"nama_pasien", 
			"pendaftaran_poli", 
			"igd", 
			"rawat_inap", 
			"setatus");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_rm.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Rm";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_rm/view.php", $record);
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
			$fields = $this->fields = array("id_daftar","tanggal","jam","no_rekam_medis","rm_lama","pendaftaran_poli","igd","rawat_inap","setatus","nama_pasien");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required|numeric',
				'tanggal' => 'required',
				'jam' => 'required',
				'no_rekam_medis' => 'required',
				'rm_lama' => 'required',
				'pendaftaran_poli' => 'required',
				'igd' => 'required',
				'rawat_inap' => 'required',
				'setatus' => 'required',
				'nama_pasien' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'jam' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'rm_lama' => 'sanitize_string',
				'pendaftaran_poli' => 'sanitize_string',
				'igd' => 'sanitize_string',
				'rawat_inap' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_rm");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Rm";
		$this->render_view("data_rm/add.php");
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
		$fields = $this->fields = array("id","id_daftar","tanggal","jam","no_rekam_medis","rm_lama","pendaftaran_poli","igd","rawat_inap","setatus","nama_pasien");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required|numeric',
				'tanggal' => 'required',
				'jam' => 'required',
				'no_rekam_medis' => 'required',
				'rm_lama' => 'required',
				'pendaftaran_poli' => 'required',
				'igd' => 'required',
				'rawat_inap' => 'required',
				'setatus' => 'required',
				'nama_pasien' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'jam' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'rm_lama' => 'sanitize_string',
				'pendaftaran_poli' => 'sanitize_string',
				'igd' => 'sanitize_string',
				'rawat_inap' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_rm.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_rm");
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
						return	$this->redirect("data_rm");
					}
				}
			}
		}
		$db->where("data_rm.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Rm";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_rm/edit.php", $data);
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
		$db->where("data_rm.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("data_rm");
	}
}
