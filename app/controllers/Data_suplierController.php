<?php 
/**
 * Data_suplier Page Controller
 * @category  Controller
 */
class Data_suplierController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_suplier";
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
		$fields = array("data_suplier.id_suplier", 
			"data_suplier.nama", 
			"data_suplier.alamat", 
			"data_suplier.no_hp", 
			"data_suplier.ketrangan", 
			"data_suplier.operator", 
			"user_login.nama AS user_login_nama", 
			"data_suplier.date_created", 
			"data_suplier.date_updated", 
			"data_suplier.email");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_suplier.id_suplier LIKE ? OR 
				data_suplier.nama LIKE ? OR 
				data_suplier.alamat LIKE ? OR 
				data_suplier.no_hp LIKE ? OR 
				data_suplier.ketrangan LIKE ? OR 
				data_suplier.operator LIKE ? OR 
				data_suplier.date_created LIKE ? OR 
				data_suplier.date_updated LIKE ? OR 
				data_suplier.email LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_suplier/search.php";
		}
		$db->join("user_login", "data_suplier.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_suplier.id_suplier", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Suplier";
		$view_name = (is_ajax() ? "data_suplier/ajax-list.php" : "data_suplier/list.php");
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
		$fields = array("data_suplier.id_suplier", 
			"data_suplier.nama", 
			"data_suplier.alamat", 
			"data_suplier.no_hp", 
			"data_suplier.ketrangan", 
			"data_suplier.operator", 
			"user_login.nama AS user_login_nama", 
			"data_suplier.date_created", 
			"data_suplier.date_updated", 
			"data_suplier.email");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_suplier.id_suplier", $rec_id);; //select record based on primary key
		}
		$db->join("user_login", "data_suplier.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Suplier";
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
		return $this->render_view("data_suplier/view.php", $record);
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
			$fields = $this->fields = array("id_suplier","nama","alamat","no_hp","ketrangan","operator","email");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_suplier' => 'required|numeric',
				'nama' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'ketrangan' => 'required',
				'operator' => 'required',
				'email' => 'required|valid_email',
			);
			$this->sanitize_array = array(
				'id_suplier' => 'sanitize_string',
				'nama' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'ketrangan' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'email' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$db->rawQuery("UPDATE data_suplier SET operator='".USER_ID."' WHERE id_suplier='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_suplier");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Suplier";
		$this->render_view("data_suplier/add.php");
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
		$fields = $this->fields = array("id_suplier","nama","alamat","no_hp","ketrangan","operator","email");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_suplier' => 'required|numeric',
				'nama' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'ketrangan' => 'required',
				'operator' => 'required',
				'email' => 'required|valid_email',
			);
			$this->sanitize_array = array(
				'id_suplier' => 'sanitize_string',
				'nama' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'ketrangan' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'email' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_suplier.id_suplier", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_suplier");
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
						return	$this->redirect("data_suplier");
					}
				}
			}
		}
		$db->where("data_suplier.id_suplier", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Suplier";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_suplier/edit.php", $data);
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
		$db->where("data_suplier.id_suplier", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("data_suplier");
	}
}
