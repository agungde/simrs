<?php 
/**
 * Permintaan_barang Page Controller
 * @category  Controller
 */
class Permintaan_barangController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "permintaan_barang";
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
		$fields = array("permintaan_barang.id", 
			"permintaan_barang.tanggal", 
			"permintaan_barang.no_request", 
			"permintaan_barang.action", 
			"permintaan_barang.category_barang", 
			"category_barang.category AS category_barang_category", 
			"permintaan_barang.divisi", 
			"permintaan_barang.bagian", 
			"permintaan_barang.approval", 
			"permintaan_barang.setatus", 
			"permintaan_barang.date_created");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	     if(USER_ROLE==8){
        $divisi = "IGD";
        $bag    = "IGD";
        $db->where("divisi='$divisi' AND bagian='$bag'");      
 }else if(USER_ROLE==6){
       $divisi = "POLI";
       $bag    = $_SESSION[APP_ID.'user_data']['admin_poli'];
       $db->where("divisi='$divisi' AND bagian='$bag'");     
       }else  if(USER_ROLE==13){
$divisi = "RANAP";
$bag    = $_SESSION[APP_ID.'user_data']['admin_ranap'];   
 $db->where("divisi='$divisi' AND bagian='$bag'");  
 }else  if(USER_ROLE==5){
     $divisi = "FARMASI";
     $bag    = "FARMASI";
  $db->where("divisi='$divisi' AND bagian='$bag'");      
       }
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				permintaan_barang.id LIKE ? OR 
				permintaan_barang.tanggal LIKE ? OR 
				permintaan_barang.no_request LIKE ? OR 
				permintaan_barang.action LIKE ? OR 
				permintaan_barang.category_barang LIKE ? OR 
				permintaan_barang.total_jumlah LIKE ? OR 
				permintaan_barang.divisi LIKE ? OR 
				permintaan_barang.bagian LIKE ? OR 
				permintaan_barang.approval LIKE ? OR 
				permintaan_barang.setatus LIKE ? OR 
				permintaan_barang.operator LIKE ? OR 
				permintaan_barang.date_created LIKE ? OR 
				permintaan_barang.date_updated LIKE ? OR 
				permintaan_barang.idtrace LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "permintaan_barang/search.php";
		}
		$db->join("category_barang", "permintaan_barang.category_barang = category_barang.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("permintaan_barang.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Permintaan Barang";
		$view_name = (is_ajax() ? "permintaan_barang/ajax-list.php" : "permintaan_barang/list.php");
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
		$fields = array("permintaan_barang.id", 
			"permintaan_barang.tanggal", 
			"permintaan_barang.no_request", 
			"permintaan_barang.category_barang", 
			"category_barang.category AS category_barang_category", 
			"permintaan_barang.total_jumlah", 
			"permintaan_barang.divisi", 
			"permintaan_barang.operator", 
			"permintaan_barang.setatus", 
			"permintaan_barang.date_created", 
			"permintaan_barang.date_updated", 
			"permintaan_barang.bagian", 
			"permintaan_barang.approval");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("permintaan_barang.id", $rec_id);; //select record based on primary key
		}
		$db->join("category_barang", "permintaan_barang.category_barang = category_barang.id", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Permintaan Barang";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("permintaan_barang/view.php", $record);
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
			$fields = $this->fields = array("tanggal","category_barang","action","bagian","approval");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'category_barang' => 'required',
				'action' => 'required',
				'bagian' => 'required',
				'approval' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'category_barang' => 'sanitize_string',
				'action' => 'sanitize_string',
				'bagian' => 'sanitize_string',
				'approval' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("permintaan_barang");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Permintaan Barang";
		$this->render_view("permintaan_barang/add.php");
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
		$fields = $this->fields = array("id","tanggal","category_barang","action","bagian","approval");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'category_barang' => 'required',
				'action' => 'required',
				'bagian' => 'required',
				'approval' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'category_barang' => 'sanitize_string',
				'action' => 'sanitize_string',
				'bagian' => 'sanitize_string',
				'approval' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("permintaan_barang.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("permintaan_barang");
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
						return	$this->redirect("permintaan_barang");
					}
				}
			}
		}
		$db->where("permintaan_barang.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Permintaan Barang";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("permintaan_barang/edit.php", $data);
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
		$db->where("permintaan_barang.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("permintaan_barang");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function request($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal","category_barang","total_jumlah","divisi","bagian","approval");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'category_barang' => 'required',
				'total_jumlah' => 'required|numeric',
				'divisi' => 'required',
				'bagian' => 'required',
				'approval' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'category_barang' => 'sanitize_string',
				'total_jumlah' => 'sanitize_string',
				'divisi' => 'sanitize_string',
				'bagian' => 'sanitize_string',
				'approval' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("permintaan_barang");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Permintaan Barang";
		$this->render_view("permintaan_barang/request.php");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function approval($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("permintaan_barang.id", 
			"permintaan_barang.tanggal", 
			"permintaan_barang.no_request", 
			"permintaan_barang.action", 
			"permintaan_barang.category_barang", 
			"category_barang.category AS category_barang_category", 
			"permintaan_barang.divisi", 
			"permintaan_barang.bagian", 
			"permintaan_barang.approval", 
			"permintaan_barang.setatus", 
			"permintaan_barang.operator", 
			"permintaan_barang.date_created", 
			"permintaan_barang.date_updated", 
			"permintaan_barang.idtrace", 
			"permintaan_barang.total_jumlah");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				permintaan_barang.id LIKE ? OR 
				permintaan_barang.tanggal LIKE ? OR 
				permintaan_barang.no_request LIKE ? OR 
				permintaan_barang.action LIKE ? OR 
				permintaan_barang.category_barang LIKE ? OR 
				permintaan_barang.divisi LIKE ? OR 
				permintaan_barang.bagian LIKE ? OR 
				permintaan_barang.approval LIKE ? OR 
				permintaan_barang.setatus LIKE ? OR 
				permintaan_barang.operator LIKE ? OR 
				permintaan_barang.date_created LIKE ? OR 
				permintaan_barang.date_updated LIKE ? OR 
				permintaan_barang.idtrace LIKE ? OR 
				permintaan_barang.total_jumlah LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "permintaan_barang/search.php";
		}
		$db->join("category_barang", "permintaan_barang.category_barang = category_barang.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("permintaan_barang.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Permintaan Barang";
		$this->render_view("permintaan_barang/approval.php", $data); //render the full page
	}
}
