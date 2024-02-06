<?php 
/**
 * Setok_barang Page Controller
 * @category  Controller
 */
class Setok_barangController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "setok_barang";
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
		$fields = array("setok_barang.id_barang", 
			"setok_barang.kode_barang", 
			"setok_barang.nama_barang", 
			"setok_barang.satuan", 
			"setok_barang.harga_beli", 
			"setok_barang.harga_jual", 
			"setok_barang.jumlah", 
			"setok_barang.category_barang", 
			"category_barang.category AS category_barang_category", 
			"setok_barang.operator", 
			"user_login.nama AS user_login_nama", 
			"setok_barang.date_created", 
			"setok_barang.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(!empty($request->setok_barang_category_barang)){
$val = $request->setok_barang_category_barang;
 $db->where("setok_barang.category_barang",  $val , "=");
}  
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				setok_barang.id_barang LIKE ? OR 
				setok_barang.kode_barang LIKE ? OR 
				setok_barang.nama_barang LIKE ? OR 
				setok_barang.satuan LIKE ? OR 
				setok_barang.harga_beli LIKE ? OR 
				setok_barang.harga_jual LIKE ? OR 
				setok_barang.harga_bpjs LIKE ? OR 
				setok_barang.jumlah LIKE ? OR 
				setok_barang.category_barang LIKE ? OR 
				setok_barang.operator LIKE ? OR 
				setok_barang.date_created LIKE ? OR 
				setok_barang.date_updated LIKE ? OR 
				setok_barang.id_data LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "setok_barang/search.php";
		}
		$db->join("category_barang", "setok_barang.category_barang = category_barang.id", "INNER");
		$db->join("user_login", "setok_barang.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("setok_barang.id_barang", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		if(!empty($request->setok_barang_category_barang)){
			$val = $request->setok_barang_category_barang;
			$db->where("setok_barang.category_barang", $val , "=");
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
		$page_title = $this->view->page_title = "Setok Barang";
		$view_name = (is_ajax() ? "setok_barang/ajax-list.php" : "setok_barang/list.php");
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
		$fields = array("setok_barang.id_barang", 
			"setok_barang.kode_barang", 
			"setok_barang.nama_barang", 
			"setok_barang.satuan", 
			"setok_barang.harga_beli", 
			"setok_barang.harga_jual", 
			"setok_barang.jumlah", 
			"setok_barang.category_barang", 
			"category_barang.category AS category_barang_category", 
			"setok_barang.operator", 
			"user_login.nama AS user_login_nama", 
			"setok_barang.date_created", 
			"setok_barang.date_updated");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("setok_barang.id_barang", $rec_id);; //select record based on primary key
		}
		$db->join("category_barang", "setok_barang.category_barang = category_barang.id", "INNER");
		$db->join("user_login", "setok_barang.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Setok Barang";
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
		return $this->render_view("setok_barang/view.php", $record);
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
			$fields = $this->fields = array();
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
			);
			$this->sanitize_array = array(
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("setok_barang");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Setok Barang";
		$this->render_view("setok_barang/add.php");
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
		$fields = $this->fields = array("id_barang","kode_barang","nama_barang","satuan","harga_beli","jumlah");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'satuan' => 'required',
				'harga_beli' => 'required',
				'jumlah' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'satuan' => 'sanitize_string',
				'harga_beli' => 'sanitize_string',
				'jumlah' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("setok_barang.id_barang", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			 $harga     = $_POST['harga_beli'];
 $hargajual = $harga * 20 / 100;
            $jual=$hargajual + $harga;
 $db->rawQuery("UPDATE setok_barang SET harga_jual='$jual', operator='".USER_ID."',date_updated='".date("Y-m-d H:i:s")."' WHERE id_barang='$rec_id'");
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("setok_barang");
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
						return	$this->redirect("setok_barang");
					}
				}
			}
		}
		$db->where("setok_barang.id_barang", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Setok Barang";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("setok_barang/edit.php", $data);
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
		$db->where("setok_barang.id_barang", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("setok_barang");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function obat($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("setok_barang.id_barang", 
			"setok_barang.kode_barang", 
			"setok_barang.nama_barang", 
			"setok_barang.satuan", 
			"setok_barang.harga_beli", 
			"setok_barang.harga_jual", 
			"setok_barang.jumlah", 
			"setok_barang.category_barang", 
			"category_barang.category AS category_barang_category", 
			"setok_barang.operator", 
			"user_login.nama AS user_login_nama", 
			"setok_barang.date_created", 
			"setok_barang.date_updated", 
			"setok_barang.harga_bpjs");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
 $db->where("setok_barang.category_barang='1'");
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				setok_barang.id_barang LIKE ? OR 
				setok_barang.kode_barang LIKE ? OR 
				setok_barang.nama_barang LIKE ? OR 
				setok_barang.satuan LIKE ? OR 
				setok_barang.harga_beli LIKE ? OR 
				setok_barang.harga_jual LIKE ? OR 
				setok_barang.jumlah LIKE ? OR 
				setok_barang.category_barang LIKE ? OR 
				setok_barang.operator LIKE ? OR 
				setok_barang.date_created LIKE ? OR 
				setok_barang.date_updated LIKE ? OR 
				setok_barang.id_data LIKE ? OR 
				setok_barang.harga_bpjs LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "setok_barang/search.php";
		}
		$db->join("category_barang", "setok_barang.category_barang = category_barang.id", "INNER");
		$db->join("user_login", "setok_barang.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("setok_barang.id_barang", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Setok Barang";
		$view_name = (is_ajax() ? "setok_barang/ajax-obat.php" : "setok_barang/obat.php");
		$this->render_view($view_name, $data);
	}
}
