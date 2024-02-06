<?php 
/**
 * List_biaya_tindakan Page Controller
 * @category  Controller
 */
class List_biaya_tindakanController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "list_biaya_tindakan";
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
		$fields = array("list_biaya_tindakan.id", 
			"list_biaya_tindakan.nama_tindakan", 
			"list_biaya_tindakan.harga", 
			"list_biaya_tindakan.operator", 
			"user_login.nama AS user_login_nama", 
			"list_biaya_tindakan.date_created", 
			"list_biaya_tindakan.date_updated", 
			"list_biaya_tindakan.kodetarif");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				list_biaya_tindakan.id LIKE ? OR 
				list_biaya_tindakan.nama_tindakan LIKE ? OR 
				list_biaya_tindakan.harga LIKE ? OR 
				list_biaya_tindakan.operator LIKE ? OR 
				list_biaya_tindakan.date_created LIKE ? OR 
				list_biaya_tindakan.date_updated LIKE ? OR 
				list_biaya_tindakan.kodetarif LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "list_biaya_tindakan/search.php";
		}
		$db->join("user_login", "list_biaya_tindakan.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("list_biaya_tindakan.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "List Biaya Tindakan";
		$view_name = (is_ajax() ? "list_biaya_tindakan/ajax-list.php" : "list_biaya_tindakan/list.php");
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
		$fields = array("list_biaya_tindakan.id", 
			"list_biaya_tindakan.nama_tindakan", 
			"list_biaya_tindakan.harga", 
			"list_biaya_tindakan.operator", 
			"user_login.nama AS user_login_nama", 
			"list_biaya_tindakan.date_created", 
			"list_biaya_tindakan.date_updated", 
			"list_biaya_tindakan.kodetarif");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("list_biaya_tindakan.id", $rec_id);; //select record based on primary key
		}
		$db->join("user_login", "list_biaya_tindakan.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  List Biaya Tindakan";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("list_biaya_tindakan/view.php", $record);
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
			$fields = $this->fields = array("nama_tindakan","harga","kodetarif");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_tindakan' => 'required',
				'harga' => 'required',
				'kodetarif' => 'required',
			);
			$this->sanitize_array = array(
				'nama_tindakan' => 'sanitize_string',
				'harga' => 'sanitize_string',
				'kodetarif' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$db->rawQuery("UPDATE list_biaya_tindakan SET operator='".USER_ID."' WHERE id='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("list_biaya_tindakan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New List Biaya Tindakan";
		$this->render_view("list_biaya_tindakan/add.php");
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
		$fields = $this->fields = array("id","nama_tindakan","harga","kodetarif");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_tindakan' => 'required',
				'harga' => 'required',
				'kodetarif' => 'required',
			);
			$this->sanitize_array = array(
				'nama_tindakan' => 'sanitize_string',
				'harga' => 'sanitize_string',
				'kodetarif' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("list_biaya_tindakan.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			$db->rawQuery("UPDATE list_biaya_tindakan SET operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id='$rec_id'");
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("list_biaya_tindakan");
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
						return	$this->redirect("list_biaya_tindakan");
					}
				}
			}
		}
		$db->where("list_biaya_tindakan.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  List Biaya Tindakan";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("list_biaya_tindakan/edit.php", $data);
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
		$db->where("list_biaya_tindakan.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("list_biaya_tindakan");
	}
}
