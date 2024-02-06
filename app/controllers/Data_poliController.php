<?php 
/**
 * Data_poli Page Controller
 * @category  Controller
 */
class Data_poliController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_poli";
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
		$fields = array("data_poli.id_poli", 
			"data_poli.kode", 
			"data_poli.nama_poli", 
			"data_poli.quota_pasien", 
			"data_poli.category", 
			"data_poli.operator", 
			"user_login.nama AS user_login_nama", 
			"data_poli.date_created", 
			"data_poli.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_poli.id_poli LIKE ? OR 
				data_poli.kode LIKE ? OR 
				data_poli.nama_poli LIKE ? OR 
				data_poli.quota_pasien LIKE ? OR 
				data_poli.category LIKE ? OR 
				data_poli.operator LIKE ? OR 
				data_poli.date_created LIKE ? OR 
				data_poli.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_poli/search.php";
		}
		$db->join("user_login", "data_poli.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("id_poli", "ASC");
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
		$page_title = $this->view->page_title = "Data Poli";
		$view_name = (is_ajax() ? "data_poli/ajax-list.php" : "data_poli/list.php");
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
		$fields = array("data_poli.id_poli", 
			"data_poli.kode", 
			"data_poli.nama_poli", 
			"data_poli.quota_pasien", 
			"data_poli.category", 
			"data_poli.operator", 
			"user_login.nama AS user_login_nama", 
			"data_poli.date_created", 
			"data_poli.date_updated");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_poli.id_poli", $rec_id);; //select record based on primary key
		}
		$db->join("user_login", "data_poli.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Poli";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_poli/view.php", $record);
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
			$fields = $this->fields = array("kode","nama_poli","quota_pasien","category");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode' => 'required|max_len,1|min_len,1',
				'nama_poli' => 'required',
				'quota_pasien' => 'required|numeric',
				'category' => 'required',
			);
			$this->sanitize_array = array(
				'kode' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'quota_pasien' => 'sanitize_string',
				'category' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			$db->where("kode", $modeldata['kode']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['kode']." Already exist!";
			} 
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$db->rawQuery("UPDATE data_poli SET operator='".USER_ID."' WHERE id_poli='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_poli");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Poli";
		$this->render_view("data_poli/add.php");
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
		$fields = $this->fields = array("id_poli","kode","nama_poli","quota_pasien","category");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode' => 'required|max_len,1|min_len,1',
				'nama_poli' => 'required',
				'quota_pasien' => 'required|numeric',
				'category' => 'required',
			);
			$this->sanitize_array = array(
				'kode' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'quota_pasien' => 'sanitize_string',
				'category' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['kode'])){
				$db->where("kode", $modeldata['kode'])->where("id_poli", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['kode']." Already exist!";
				}
			} 
			if($this->validated()){
				$db->where("data_poli.id_poli", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			$db->rawQuery("UPDATE data_poli SET operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id_poli='$rec_id'");
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_poli");
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
						return	$this->redirect("data_poli");
					}
				}
			}
		}
		$db->where("data_poli.id_poli", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Poli";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_poli/edit.php", $data);
	}
}
