<?php 
/**
 * Data_barang Page Controller
 * @category  Controller
 */
class Data_barangController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_barang";
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
		$fields = array("data_barang.id_barang", 
			"data_barang.kode_barang", 
			"data_barang.nama_barang", 
			"data_barang.satuan", 
			"data_barang.category_barang", 
			"category_barang.category AS category_barang_category", 
			"data_barang.warning_setok", 
			"data_barang.action", 
			"data_barang.operator", 
			"user_login.nama AS user_login_nama", 
			"data_barang.date_created", 
			"data_barang.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_barang.id_barang LIKE ? OR 
				data_barang.kode_barang LIKE ? OR 
				data_barang.nama_barang LIKE ? OR 
				data_barang.satuan LIKE ? OR 
				data_barang.category_barang LIKE ? OR 
				data_barang.warning_setok LIKE ? OR 
				data_barang.action LIKE ? OR 
				data_barang.operator LIKE ? OR 
				data_barang.date_created LIKE ? OR 
				data_barang.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_barang/search.php";
		}
		$db->join("category_barang", "data_barang.category_barang = category_barang.id", "INNER");
		$db->join("user_login", "data_barang.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_barang.id_barang", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		if(!empty($request->data_barang_category_barang)){
			$val = $request->data_barang_category_barang;
			$db->where("data_barang.category_barang", $val , "=");
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
		$page_title = $this->view->page_title = "Data Barang";
		$this->render_view("data_barang/list.php", $data); //render the full page
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
		$fields = array("data_barang.id_barang", 
			"data_barang.kode_barang", 
			"data_barang.nama_barang", 
			"data_barang.satuan", 
			"data_barang.category_barang", 
			"category_barang.category AS category_barang_category", 
			"data_barang.warning_setok", 
			"data_barang.operator", 
			"user_login.nama AS user_login_nama", 
			"data_barang.date_created", 
			"data_barang.date_updated");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_barang.id_barang", $rec_id);; //select record based on primary key
		}
		$db->join("category_barang", "data_barang.category_barang = category_barang.id", "INNER");
		$db->join("user_login", "data_barang.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Barang";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_barang/view.php", $record);
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
			$fields = $this->fields = array("kode_barang","nama_barang","satuan","category_barang");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'satuan' => 'required',
				'category_barang' => 'required',
			);
			$this->sanitize_array = array(
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'satuan' => 'sanitize_string',
				'category_barang' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			$db->where("kode_barang", $modeldata['kode_barang']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['kode_barang']." Already exist!";
			}
			//Check if Duplicate Record Already Exit In The Database
			$db->where("nama_barang", $modeldata['nama_barang']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['nama_barang']." Already exist!";
			} 
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_barang");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Barang";
		$this->render_view("data_barang/add.php");
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
		$fields = $this->fields = array("id_barang","kode_barang","nama_barang","satuan","category_barang","warning_setok");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'satuan' => 'required',
				'category_barang' => 'required',
				'warning_setok' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'satuan' => 'sanitize_string',
				'category_barang' => 'sanitize_string',
				'warning_setok' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['kode_barang'])){
				$db->where("kode_barang", $modeldata['kode_barang'])->where("id_barang", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['kode_barang']." Already exist!";
				}
			}
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['nama_barang'])){
				$db->where("nama_barang", $modeldata['nama_barang'])->where("id_barang", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['nama_barang']." Already exist!";
				}
			} 
			if($this->validated()){
				$db->where("data_barang.id_barang", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
$db->rawQuery("UPDATE data_barang SET operator='$id_user',date_updated='".date("Y-m-d H:i:s")."' WHERE id_barang='$rec_id'");
$queryd = mysqli_query($koneksi, "SELECT * from data_barang where id_barang='$rec_id'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rowsd = mysqli_num_rows($queryd);
if ($rowsd <> 0) {// ambil data hasil query
    $datad       = mysqli_fetch_assoc($queryd);
    $kode_barang = $datad['kode_barang'];
    $nama_barang    = $datad['nama_barang'];
    $satuan    = $datad['satuan'];
    $category_barang    = $datad['category_barang'];
}
 mysqli_query($koneksi,"UPDATE setok_barang SET kode_barang='$kode_barang', nama_barang='$nama_barang', satuan='$satuan', category_barang='$category_barang', operator='$id_user' where id_data='$rec_id'");
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_barang");
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
						return	$this->redirect("data_barang");
					}
				}
			}
		}
		$db->where("data_barang.id_barang", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Barang";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_barang/edit.php", $data);
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
		$db->where("data_barang.id_barang", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("data_barang");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function impor($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("nama_barang","warning_setok");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_barang' => 'required',
				'warning_setok' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'nama_barang' => 'sanitize_string',
				'warning_setok' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_barang");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Barang";
		$this->render_view("data_barang/impor.php");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function proses($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("nama_barang","warning_setok");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_barang' => 'required',
				'warning_setok' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'nama_barang' => 'sanitize_string',
				'warning_setok' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_barang");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Barang";
		$this->render_view("data_barang/proses.php");
	}
}
