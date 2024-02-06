<?php 
/**
 * Data_kelahiran Page Controller
 * @category  Controller
 */
class Data_kelahiranController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_kelahiran";
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
			"id_ranap_bersalin", 
			"no_rekam_medis", 
			"tanggal", 
			"jam", 
			"jenis_kelamin", 
			"Jenis_kelahiran", 
			"kelahiran_ke", 
			"Berat_lahir", 
			"panjang_badan", 
			"nama_bayi", 
			"nama_ibu", 
			"umur_ibu", 
			"pekerjaan_ibu", 
			"nik_ibu", 
			"alamat_ibu", 
			"nama_ayah", 
			"umur_ayah", 
			"pekerjaan_ayah", 
			"nik_ayah", 
			"alamat_ayah", 
			"setatus", 
			"operator", 
			"date_created");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_kelahiran.id LIKE ? OR 
				data_kelahiran.id_ranap_bersalin LIKE ? OR 
				data_kelahiran.no_rekam_medis LIKE ? OR 
				data_kelahiran.tanggal LIKE ? OR 
				data_kelahiran.jam LIKE ? OR 
				data_kelahiran.jenis_kelamin LIKE ? OR 
				data_kelahiran.Jenis_kelahiran LIKE ? OR 
				data_kelahiran.kelahiran_ke LIKE ? OR 
				data_kelahiran.Berat_lahir LIKE ? OR 
				data_kelahiran.panjang_badan LIKE ? OR 
				data_kelahiran.nama_bayi LIKE ? OR 
				data_kelahiran.nama_ibu LIKE ? OR 
				data_kelahiran.umur_ibu LIKE ? OR 
				data_kelahiran.pekerjaan_ibu LIKE ? OR 
				data_kelahiran.nik_ibu LIKE ? OR 
				data_kelahiran.alamat_ibu LIKE ? OR 
				data_kelahiran.nama_ayah LIKE ? OR 
				data_kelahiran.umur_ayah LIKE ? OR 
				data_kelahiran.pekerjaan_ayah LIKE ? OR 
				data_kelahiran.nik_ayah LIKE ? OR 
				data_kelahiran.alamat_ayah LIKE ? OR 
				data_kelahiran.setatus LIKE ? OR 
				data_kelahiran.operator LIKE ? OR 
				data_kelahiran.date_created LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_kelahiran/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_kelahiran.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Kelahiran";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("data_kelahiran/list.php", $data); //render the full page
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
			"id_ranap_bersalin", 
			"no_rekam_medis", 
			"tanggal", 
			"jam", 
			"jenis_kelamin", 
			"Jenis_kelahiran", 
			"kelahiran_ke", 
			"Berat_lahir", 
			"panjang_badan", 
			"nama_bayi", 
			"nama_ibu", 
			"umur_ibu", 
			"pekerjaan_ibu", 
			"nik_ibu", 
			"alamat_ibu", 
			"nama_ayah", 
			"umur_ayah", 
			"pekerjaan_ayah", 
			"nik_ayah", 
			"alamat_ayah", 
			"setatus", 
			"operator", 
			"date_created");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_kelahiran.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Kelahiran";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_kelahiran/view.php", $record);
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
			$fields = $this->fields = array("id_ranap_bersalin","no_rekam_medis","tanggal","jam","jenis_kelamin","Jenis_kelahiran","kelahiran_ke","Berat_lahir","panjang_badan","nama_bayi","nama_ibu","umur_ibu","pekerjaan_ibu","nik_ibu","alamat_ibu","nama_ayah","umur_ayah","pekerjaan_ayah","nik_ayah","alamat_ayah","setatus","operator");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_ranap_bersalin' => 'required|numeric',
				'no_rekam_medis' => 'required',
				'tanggal' => 'required',
				'jam' => 'required',
				'jenis_kelamin' => 'required',
				'Jenis_kelahiran' => 'required',
				'kelahiran_ke' => 'required',
				'Berat_lahir' => 'required|numeric',
				'panjang_badan' => 'required|numeric',
				'nama_bayi' => 'required',
				'nama_ibu' => 'required',
				'umur_ibu' => 'required|numeric',
				'pekerjaan_ibu' => 'required',
				'nik_ibu' => 'required|numeric',
				'alamat_ibu' => 'required',
				'nama_ayah' => 'required',
				'umur_ayah' => 'required|numeric',
				'pekerjaan_ayah' => 'required',
				'nik_ayah' => 'required|numeric',
				'alamat_ayah' => 'required',
				'setatus' => 'required',
				'operator' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'id_ranap_bersalin' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'jam' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'Jenis_kelahiran' => 'sanitize_string',
				'kelahiran_ke' => 'sanitize_string',
				'Berat_lahir' => 'sanitize_string',
				'panjang_badan' => 'sanitize_string',
				'nama_bayi' => 'sanitize_string',
				'nama_ibu' => 'sanitize_string',
				'umur_ibu' => 'sanitize_string',
				'pekerjaan_ibu' => 'sanitize_string',
				'nik_ibu' => 'sanitize_string',
				'alamat_ibu' => 'sanitize_string',
				'nama_ayah' => 'sanitize_string',
				'umur_ayah' => 'sanitize_string',
				'pekerjaan_ayah' => 'sanitize_string',
				'nik_ayah' => 'sanitize_string',
				'alamat_ayah' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'operator' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_kelahiran");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Kelahiran";
		$this->render_view("data_kelahiran/add.php");
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
		$fields = $this->fields = array("id","id_ranap_bersalin","no_rekam_medis","tanggal","jam","jenis_kelamin","Jenis_kelahiran","kelahiran_ke","Berat_lahir","panjang_badan","nama_bayi","nama_ibu","umur_ibu","pekerjaan_ibu","nik_ibu","alamat_ibu","nama_ayah","umur_ayah","pekerjaan_ayah","nik_ayah","alamat_ayah","setatus","operator");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_ranap_bersalin' => 'required|numeric',
				'no_rekam_medis' => 'required',
				'tanggal' => 'required',
				'jam' => 'required',
				'jenis_kelamin' => 'required',
				'Jenis_kelahiran' => 'required',
				'kelahiran_ke' => 'required',
				'Berat_lahir' => 'required|numeric',
				'panjang_badan' => 'required|numeric',
				'nama_bayi' => 'required',
				'nama_ibu' => 'required',
				'umur_ibu' => 'required|numeric',
				'pekerjaan_ibu' => 'required',
				'nik_ibu' => 'required|numeric',
				'alamat_ibu' => 'required',
				'nama_ayah' => 'required',
				'umur_ayah' => 'required|numeric',
				'pekerjaan_ayah' => 'required',
				'nik_ayah' => 'required|numeric',
				'alamat_ayah' => 'required',
				'setatus' => 'required',
				'operator' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'id_ranap_bersalin' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'jam' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'Jenis_kelahiran' => 'sanitize_string',
				'kelahiran_ke' => 'sanitize_string',
				'Berat_lahir' => 'sanitize_string',
				'panjang_badan' => 'sanitize_string',
				'nama_bayi' => 'sanitize_string',
				'nama_ibu' => 'sanitize_string',
				'umur_ibu' => 'sanitize_string',
				'pekerjaan_ibu' => 'sanitize_string',
				'nik_ibu' => 'sanitize_string',
				'alamat_ibu' => 'sanitize_string',
				'nama_ayah' => 'sanitize_string',
				'umur_ayah' => 'sanitize_string',
				'pekerjaan_ayah' => 'sanitize_string',
				'nik_ayah' => 'sanitize_string',
				'alamat_ayah' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'operator' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_kelahiran.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_kelahiran");
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
						return	$this->redirect("data_kelahiran");
					}
				}
			}
		}
		$db->where("data_kelahiran.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Kelahiran";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_kelahiran/edit.php", $data);
	}
	/**
     * Update single field
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function editfield($rec_id = null, $formdata = null){
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		//editable fields
		$fields = $this->fields = array("id","id_ranap_bersalin","no_rekam_medis","tanggal","jam","jenis_kelamin","Jenis_kelahiran","kelahiran_ke","Berat_lahir","panjang_badan","nama_bayi","nama_ibu","umur_ibu","pekerjaan_ibu","nik_ibu","alamat_ibu","nama_ayah","umur_ayah","pekerjaan_ayah","nik_ayah","alamat_ayah","setatus","operator");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'id_ranap_bersalin' => 'required|numeric',
				'no_rekam_medis' => 'required',
				'tanggal' => 'required',
				'jam' => 'required',
				'jenis_kelamin' => 'required',
				'Jenis_kelahiran' => 'required',
				'kelahiran_ke' => 'required',
				'Berat_lahir' => 'required|numeric',
				'panjang_badan' => 'required|numeric',
				'nama_bayi' => 'required',
				'nama_ibu' => 'required',
				'umur_ibu' => 'required|numeric',
				'pekerjaan_ibu' => 'required',
				'nik_ibu' => 'required|numeric',
				'alamat_ibu' => 'required',
				'nama_ayah' => 'required',
				'umur_ayah' => 'required|numeric',
				'pekerjaan_ayah' => 'required',
				'nik_ayah' => 'required|numeric',
				'alamat_ayah' => 'required',
				'setatus' => 'required',
				'operator' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'id_ranap_bersalin' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'jam' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'Jenis_kelahiran' => 'sanitize_string',
				'kelahiran_ke' => 'sanitize_string',
				'Berat_lahir' => 'sanitize_string',
				'panjang_badan' => 'sanitize_string',
				'nama_bayi' => 'sanitize_string',
				'nama_ibu' => 'sanitize_string',
				'umur_ibu' => 'sanitize_string',
				'pekerjaan_ibu' => 'sanitize_string',
				'nik_ibu' => 'sanitize_string',
				'alamat_ibu' => 'sanitize_string',
				'nama_ayah' => 'sanitize_string',
				'umur_ayah' => 'sanitize_string',
				'pekerjaan_ayah' => 'sanitize_string',
				'nik_ayah' => 'sanitize_string',
				'alamat_ayah' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'operator' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_kelahiran.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount();
				if($bool && $numRows){
					return render_json(
						array(
							'num_rows' =>$numRows,
							'rec_id' =>$rec_id,
						)
					);
				}
				else{
					if($db->getLastError()){
						$page_error = $db->getLastError();
					}
					elseif(!$numRows){
						$page_error = "No record updated";
					}
					render_error($page_error);
				}
			}
			else{
				render_error($this->view->page_error);
			}
		}
		return null;
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
		$db->where("data_kelahiran.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("data_kelahiran");
	}
}
