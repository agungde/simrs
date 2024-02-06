<?php 
/**
 * Pelanggan Page Controller
 * @category  Controller
 */
class PelangganController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "pelanggan";
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
		$fields = array("pelanggan.id", 
			"pelanggan.id_pelanggan", 
			"pelanggan.nama_pelanggan", 
			"pelanggan.alamat", 
			"pelanggan.phone", 
			"pelanggan.operator", 
			"user_login.nama AS user_login_nama", 
			"pelanggan.date_created", 
			"pelanggan.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				pelanggan.id LIKE ? OR 
				pelanggan.id_pelanggan LIKE ? OR 
				pelanggan.nama_pelanggan LIKE ? OR 
				pelanggan.alamat LIKE ? OR 
				pelanggan.phone LIKE ? OR 
				pelanggan.operator LIKE ? OR 
				pelanggan.date_created LIKE ? OR 
				pelanggan.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "pelanggan/search.php";
		}
		$db->join("user_login", "pelanggan.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("pelanggan.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Pelanggan";
		$view_name = (is_ajax() ? "pelanggan/ajax-list.php" : "pelanggan/list.php");
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
		$fields = array("pelanggan.id", 
			"pelanggan.id_pelanggan", 
			"pelanggan.nama_pelanggan", 
			"pelanggan.alamat", 
			"pelanggan.phone", 
			"pelanggan.operator", 
			"user_login.nama AS user_login_nama", 
			"pelanggan.date_created", 
			"pelanggan.date_updated");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("pelanggan.id", $rec_id);; //select record based on primary key
		}
		$db->join("user_login", "pelanggan.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Pelanggan";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("pelanggan/view.php", $record);
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
			$fields = $this->fields = array("nama_pelanggan","alamat","phone");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_pelanggan' => 'required',
				'alamat' => 'required',
				'phone' => 'required',
			);
			$this->sanitize_array = array(
				'nama_pelanggan' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'phone' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			$db->where("nama_pelanggan", $modeldata['nama_pelanggan']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['nama_pelanggan']." Already exist!";
			}
			//Check if Duplicate Record Already Exit In The Database
			$db->where("phone", $modeldata['phone']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['phone']." Already exist!";
			} 
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$db->rawQuery("UPDATE pelanggan SET id_pelanggan='PLAP$rec_id', operator='".USER_ID."' WHERE id='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pelanggan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pelanggan";
		$this->render_view("pelanggan/add.php");
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
		$fields = $this->fields = array("id","nama_pelanggan","alamat","phone");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_pelanggan' => 'required',
				'alamat' => 'required',
				'phone' => 'required',
			);
			$this->sanitize_array = array(
				'nama_pelanggan' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'phone' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['nama_pelanggan'])){
				$db->where("nama_pelanggan", $modeldata['nama_pelanggan'])->where("id", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['nama_pelanggan']." Already exist!";
				}
			}
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['phone'])){
				$db->where("phone", $modeldata['phone'])->where("id", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['phone']." Already exist!";
				}
			} 
			if($this->validated()){
				$db->where("pelanggan.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			$db->rawQuery("UPDATE pelanggan SET operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id='$rec_id'");
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("pelanggan");
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
						return	$this->redirect("pelanggan");
					}
				}
			}
		}
		$db->where("pelanggan.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Pelanggan";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("pelanggan/edit.php", $data);
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
		$db->where("pelanggan.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("pelanggan");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function pelanggan($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("nama_pelanggan","alamat","phone");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_pelanggan' => 'required',
				'alamat' => 'required',
				'phone' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'nama_pelanggan' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'phone' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pelanggan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pelanggan";
		$this->render_view("pelanggan/pelanggan.php");
	}
}
