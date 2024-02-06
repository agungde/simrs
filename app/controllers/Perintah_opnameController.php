<?php 
/**
 * Perintah_opname Page Controller
 * @category  Controller
 */
class Perintah_opnameController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "perintah_opname";
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
			"tanggal", 
			"nama_pasien", 
			"no_rekam_medis", 
			"jenis_kelamin", 
			"alamat", 
			"diagnosa", 
			"therapi", 
			"dokter_pemeriksa", 
			"ttd", 
			"id_daftar");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				perintah_opname.id LIKE ? OR 
				perintah_opname.tanggal LIKE ? OR 
				perintah_opname.nama_pasien LIKE ? OR 
				perintah_opname.no_rekam_medis LIKE ? OR 
				perintah_opname.jenis_kelamin LIKE ? OR 
				perintah_opname.alamat LIKE ? OR 
				perintah_opname.diagnosa LIKE ? OR 
				perintah_opname.therapi LIKE ? OR 
				perintah_opname.dokter_pemeriksa LIKE ? OR 
				perintah_opname.ttd LIKE ? OR 
				perintah_opname.id_daftar LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "perintah_opname/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("perintah_opname.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Perintah Opname";
		$this->render_view("perintah_opname/list.php", $data); //render the full page
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
			"tanggal", 
			"nama_pasien", 
			"no_rekam_medis", 
			"jenis_kelamin", 
			"alamat", 
			"diagnosa", 
			"therapi", 
			"dokter_pemeriksa", 
			"ttd", 
			"id_daftar");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("perintah_opname.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Perintah Opname";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("perintah_opname/view.php", $record);
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
			$fields = $this->fields = array("tanggal","no_rekam_medis","nama_pasien","jenis_kelamin","alamat","diagnosa","therapi","dokter_pemeriksa","ttd","id_daftar");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'jenis_kelamin' => 'required',
				'alamat' => 'required',
				'diagnosa' => 'required',
				'dokter_pemeriksa' => 'required',
				'ttd' => 'required',
				'id_daftar' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'diagnosa' => 'sanitize_string',
				'therapi' => 'sanitize_string',
				'dokter_pemeriksa' => 'sanitize_string',
				'ttd' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$this->set_flash_msg("Perintah Opname Berhasil Di Simpan!! ", "success");
return  $this->redirect("igd");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("perintah_opname");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Perintah Opname";
		$this->render_view("perintah_opname/add.php");
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
		$fields = $this->fields = array("id","tanggal","no_rekam_medis","nama_pasien","jenis_kelamin","alamat","diagnosa","therapi","dokter_pemeriksa","ttd","id_daftar");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'jenis_kelamin' => 'required',
				'alamat' => 'required',
				'diagnosa' => 'required',
				'dokter_pemeriksa' => 'required',
				'ttd' => 'required',
				'id_daftar' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'diagnosa' => 'sanitize_string',
				'therapi' => 'sanitize_string',
				'dokter_pemeriksa' => 'sanitize_string',
				'ttd' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("perintah_opname.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("perintah_opname");
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
						return	$this->redirect("perintah_opname");
					}
				}
			}
		}
		$db->where("perintah_opname.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Perintah Opname";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("perintah_opname/edit.php", $data);
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
		$db->where("perintah_opname.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("perintah_opname");
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function opname($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("perintah_opname.id", 
			"perintah_opname.id_daftar", 
			"perintah_opname.tanggal", 
			"perintah_opname.nama_pasien", 
			"perintah_opname.no_rekam_medis", 
			"perintah_opname.jenis_kelamin", 
			"perintah_opname.alamat", 
			"perintah_opname.diagnosa", 
			"diagnosa.description AS diagnosa_description", 
			"perintah_opname.therapi", 
			"perintah_opname.dokter_pemeriksa", 
			"perintah_opname.ttd");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("perintah_opname.id", $rec_id);; //select record based on primary key
		}
		$db->join("diagnosa", "perintah_opname.diagnosa = diagnosa.id", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Perintah Opname";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("perintah_opname/opname.php", $record);
	}
}
