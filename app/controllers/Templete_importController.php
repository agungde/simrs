<?php 
/**
 * Templete_import Page Controller
 * @category  Controller
 */
class Templete_importController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "templete_import";
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
		$fields = array("templete_import.id", 
			"templete_import.nama", 
			"templete_import.file", 
			"templete_import.action", 
			"templete_import.operator", 
			"user_login.nama AS user_login_nama", 
			"templete_import.date_created", 
			"templete_import.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				templete_import.id LIKE ? OR 
				templete_import.nama LIKE ? OR 
				templete_import.file LIKE ? OR 
				templete_import.action LIKE ? OR 
				templete_import.operator LIKE ? OR 
				templete_import.date_created LIKE ? OR 
				templete_import.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "templete_import/search.php";
		}
		$db->join("user_login", "templete_import.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("templete_import.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Templete Import";
		$view_name = (is_ajax() ? "templete_import/ajax-list.php" : "templete_import/list.php");
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
		$fields = array("templete_import.id", 
			"templete_import.nama", 
			"templete_import.file", 
			"templete_import.action", 
			"templete_import.operator", 
			"user_login.nama AS user_login_nama", 
			"templete_import.date_created", 
			"templete_import.date_updated");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("templete_import.id", $rec_id);; //select record based on primary key
		}
		$db->join("user_login", "templete_import.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Templete Import";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("templete_import/view.php", $record);
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
			$fields = $this->fields = array("nama","file");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama' => 'required',
				'file' => 'required',
			);
			$this->sanitize_array = array(
				'nama' => 'sanitize_string',
				'file' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$db->rawQuery("UPDATE templete_import SET operator='".USER_ID."' WHERE id='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("templete_import");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Templete Import";
		$this->render_view("templete_import/add.php");
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
		$fields = $this->fields = array("id","nama","file");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama' => 'required',
				'file' => 'required',
			);
			$this->sanitize_array = array(
				'nama' => 'sanitize_string',
				'file' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("templete_import.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			$db->rawQuery("UPDATE templete_import SET operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id='$rec_id'");
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("templete_import");
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
						return	$this->redirect("templete_import");
					}
				}
			}
		}
		$db->where("templete_import.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Templete Import";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("templete_import/edit.php", $data);
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
		$db->where("templete_import.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("templete_import");
	}
}