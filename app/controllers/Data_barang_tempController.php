<?php 
/**
 * Data_barang_temp Page Controller
 * @category  Controller
 */
class Data_barang_tempController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_barang_temp";
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
		$fields = array("data_barang_temp.id_barang", 
			"data_barang_temp.nama_barang", 
			"data_barang_temp.satuan", 
			"data_barang_temp.harga_beli", 
			"data_barang_temp.harga", 
			"data_barang_temp.operator", 
			"user_login.nama AS user_login_nama");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_barang_temp.id_barang LIKE ? OR 
				data_barang_temp.kode_barang LIKE ? OR 
				data_barang_temp.nama_barang LIKE ? OR 
				data_barang_temp.satuan LIKE ? OR 
				data_barang_temp.category_barang LIKE ? OR 
				data_barang_temp.action LIKE ? OR 
				data_barang_temp.harga_beli LIKE ? OR 
				data_barang_temp.harga LIKE ? OR 
				data_barang_temp.operator LIKE ? OR 
				data_barang_temp.harga_jual LIKE ? OR 
				data_barang_temp.idtrace LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_barang_temp/search.php";
		}
		$db->join("user_login", "data_barang_temp.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_barang_temp.id_barang", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Barang Temp";
		$view_name = (is_ajax() ? "data_barang_temp/ajax-list.php" : "data_barang_temp/list.php");
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
		$fields = array("data_barang_temp.id_barang", 
			"data_barang_temp.nama_barang", 
			"data_barang_temp.satuan", 
			"data_barang_temp.operator", 
			"user_login.nama AS user_login_nama", 
			"data_barang_temp.harga_beli", 
			"data_barang_temp.harga");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_barang_temp.id_barang", $rec_id);; //select record based on primary key
		}
		$db->join("user_login", "data_barang_temp.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Barang Temp";
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
		return $this->render_view("data_barang_temp/view.php", $record);
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
			$fields = $this->fields = array("kode_barang","nama_barang","satuan","category_barang","action","operator","harga_beli","harga_jual","idtrace","harga");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'satuan' => 'required',
				'category_barang' => 'required|numeric',
				'action' => 'required',
				'operator' => 'required',
				'harga_beli' => 'required|numeric',
				'harga_jual' => 'required|numeric',
				'idtrace' => 'required',
				'harga' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'satuan' => 'sanitize_string',
				'category_barang' => 'sanitize_string',
				'action' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'harga_beli' => 'sanitize_string',
				'harga_jual' => 'sanitize_string',
				'idtrace' => 'sanitize_string',
				'harga' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_barang_temp");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Barang Temp";
		$this->render_view("data_barang_temp/add.php");
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
		$fields = $this->fields = array("id_barang","nama_barang","satuan");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_barang' => 'required',
				'satuan' => 'required',
			);
			$this->sanitize_array = array(
				'nama_barang' => 'sanitize_string',
				'satuan' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_barang_temp.id_barang", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_barang_temp");
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
						return	$this->redirect("data_barang_temp");
					}
				}
			}
		}
		$db->where("data_barang_temp.id_barang", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Barang Temp";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_barang_temp/edit.php", $data);
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
	#Statement to execute before delete record
	$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
if($rec_id=="all"){
 mysqli_query($koneksi, "DELETE FROM data_barang_temp WHERE idtrace='$idtrace'");
  $this->set_flash_msg("Data Berhasil Di Hapus!!", "danger");
 return  $this->redirect("data_barang");
}
	# End of before delete statement
		$db->where("data_barang_temp.id_barang", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("data_barang_temp");
	}
}
