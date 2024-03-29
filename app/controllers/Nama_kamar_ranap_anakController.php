<?php 
/**
 * Nama_kamar_ranap_anak Page Controller
 * @category  Controller
 */
class Nama_kamar_ranap_anakController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "nama_kamar_ranap_anak";
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
		$fields = array("nama_kamar_ranap_anak.id", 
			"nama_kamar_ranap_anak.nama_kamar", 
			"nama_kamar_ranap_anak.operator", 
			"user_login.email AS user_login_email", 
			"nama_kamar_ranap_anak.date_created", 
			"nama_kamar_ranap_anak.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				nama_kamar_ranap_anak.id LIKE ? OR 
				nama_kamar_ranap_anak.nama_kamar LIKE ? OR 
				nama_kamar_ranap_anak.operator LIKE ? OR 
				nama_kamar_ranap_anak.date_created LIKE ? OR 
				nama_kamar_ranap_anak.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "nama_kamar_ranap_anak/search.php";
		}
		$db->join("user_login", "nama_kamar_ranap_anak.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("nama_kamar_ranap_anak.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Nama Kamar Ranap Anak";
		$this->render_view("nama_kamar_ranap_anak/list.php", $data); //render the full page
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
		$fields = array("nama_kamar_ranap_anak.id", 
			"nama_kamar_ranap_anak.nama_kamar", 
			"nama_kamar_ranap_anak.operator", 
			"user_login.email AS user_login_email", 
			"nama_kamar_ranap_anak.date_created", 
			"nama_kamar_ranap_anak.date_updated");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("nama_kamar_ranap_anak.id", $rec_id);; //select record based on primary key
		}
		$db->join("user_login", "nama_kamar_ranap_anak.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Nama Kamar Ranap Anak";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("nama_kamar_ranap_anak/view.php", $record);
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
			$fields = $this->fields = array("nama_kamar");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_kamar' => 'required',
			);
			$this->sanitize_array = array(
				'nama_kamar' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$db->rawQuery("UPDATE nama_kamar_ranap_anak SET operator='".USER_ID."' WHERE id='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("nama_kamar_ranap_anak");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Nama Kamar Ranap Anak";
		$this->render_view("nama_kamar_ranap_anak/add.php");
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
		$fields = $this->fields = array("id","nama_kamar");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_kamar' => 'required',
			);
			$this->sanitize_array = array(
				'nama_kamar' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("nama_kamar_ranap_anak.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			 $db->rawQuery("UPDATE nama_kamar_ranap_anak SET operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id='$rec_id'");
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("nama_kamar_ranap_anak");
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
						return	$this->redirect("nama_kamar_ranap_anak");
					}
				}
			}
		}
		$db->where("nama_kamar_ranap_anak.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Nama Kamar Ranap Anak";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("nama_kamar_ranap_anak/edit.php", $data);
	}
}
