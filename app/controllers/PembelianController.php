<?php 
/**
 * Pembelian Page Controller
 * @category  Controller
 */
class PembelianController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "pembelian";
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
		$fields = array("id_pembelian", 
			"tanggal_pembelian", 
			"no_invoice", 
			"nama_suplier", 
			"alamat", 
			"no_hp", 
			"total_jumlah", 
			"total_harga_beli", 
			"total_diskon", 
			"ppn", 
			"category_barang", 
			"setatus", 
			"operator", 
			"date_created", 
			"date_updated", 
			"divisi");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
    $Query = "SELECT * FROM pembelian where setatus='Closed' or setatus='Pending'";
    //Query execution
   $ExecQuery = MySQLi_query($koneksi, $Query);
   $rows      = mysqli_num_rows($ExecQuery);
  // cek hasil query
  // jika "no_antrian" sudah ada
  if ($rows <> 0) {
      $db->where("setatus='Closed' or setatus='Pending'");
  }
//$db->where("setatus='Closed' or setatus='Pending'");
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				pembelian.id_pembelian LIKE ? OR 
				pembelian.id_suplier LIKE ? OR 
				pembelian.tanggal_pembelian LIKE ? OR 
				pembelian.no_invoice LIKE ? OR 
				pembelian.nama_suplier LIKE ? OR 
				pembelian.alamat LIKE ? OR 
				pembelian.no_hp LIKE ? OR 
				pembelian.total_jumlah LIKE ? OR 
				pembelian.total_harga_beli LIKE ? OR 
				pembelian.total_diskon LIKE ? OR 
				pembelian.ppn LIKE ? OR 
				pembelian.category_barang LIKE ? OR 
				pembelian.setatus LIKE ? OR 
				pembelian.operator LIKE ? OR 
				pembelian.date_created LIKE ? OR 
				pembelian.date_updated LIKE ? OR 
				pembelian.divisi LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "pembelian/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("pembelian.id_pembelian", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Pembelian";
		$this->render_view("pembelian/list.php", $data); //render the full page
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
		$fields = array("pembelian.id_pembelian", 
			"pembelian.tanggal_pembelian", 
			"pembelian.no_invoice", 
			"pembelian.nama_suplier", 
			"pembelian.alamat", 
			"pembelian.no_hp", 
			"pembelian.total_jumlah", 
			"pembelian.total_harga_beli", 
			"pembelian.total_diskon", 
			"pembelian.ppn", 
			"pembelian.category_barang", 
			"category_barang.category AS category_barang_category", 
			"pembelian.setatus", 
			"pembelian.date_created", 
			"pembelian.date_updated", 
			"pembelian.divisi");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("pembelian.id_pembelian", $rec_id);; //select record based on primary key
		}
		$db->join("category_barang", "pembelian.category_barang = category_barang.id", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Pembelian";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("pembelian/view.php", $record);
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
			$fields = $this->fields = array("nama_suplier","ppn","tanggal_pembelian","alamat","no_hp","total_jumlah","total_harga_beli","total_diskon","category_barang","divisi");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_suplier' => 'required',
				'tanggal_pembelian' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'total_jumlah' => 'required|numeric',
				'total_harga_beli' => 'required|numeric',
				'total_diskon' => 'required|numeric',
				'category_barang' => 'required',
				'divisi' => 'required',
			);
			$this->sanitize_array = array(
				'nama_suplier' => 'sanitize_string',
				'ppn' => 'sanitize_string',
				'tanggal_pembelian' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'total_jumlah' => 'sanitize_string',
				'total_harga_beli' => 'sanitize_string',
				'total_diskon' => 'sanitize_string',
				'category_barang' => 'sanitize_string',
				'divisi' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$db->rawQuery("UPDATE pembelian SET operator='".USER_ID."' WHERE id_pembelian='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pembelian");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pembelian";
		$this->render_view("pembelian/add.php");
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
		$fields = $this->fields = array("id_pembelian","nama_suplier","ppn","tanggal_pembelian","alamat","no_hp","total_jumlah","total_harga_beli","total_diskon","category_barang","divisi");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_suplier' => 'required',
				'tanggal_pembelian' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'total_jumlah' => 'required|numeric',
				'total_harga_beli' => 'required|numeric',
				'total_diskon' => 'required|numeric',
				'category_barang' => 'required',
				'divisi' => 'required',
			);
			$this->sanitize_array = array(
				'nama_suplier' => 'sanitize_string',
				'ppn' => 'sanitize_string',
				'tanggal_pembelian' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'total_jumlah' => 'sanitize_string',
				'total_harga_beli' => 'sanitize_string',
				'total_diskon' => 'sanitize_string',
				'category_barang' => 'sanitize_string',
				'divisi' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("pembelian.id_pembelian", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("pembelian");
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
						return	$this->redirect("pembelian");
					}
				}
			}
		}
		$db->where("pembelian.id_pembelian", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Pembelian";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("pembelian/edit.php", $data);
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
		$db->where("pembelian.id_pembelian", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("pembelian");
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
		$fields = array("pembelian.id_pembelian", 
			"pembelian.tanggal_pembelian", 
			"pembelian.no_invoice", 
			"pembelian.nama_suplier", 
			"pembelian.alamat", 
			"pembelian.no_hp", 
			"pembelian.total_jumlah", 
			"pembelian.total_harga_beli", 
			"pembelian.total_diskon", 
			"pembelian.ppn", 
			"pembelian.category_barang", 
			"category_barang.category AS category_barang_category", 
			"pembelian.operator", 
			"pembelian.setatus", 
			"pembelian.date_created", 
			"pembelian.date_updated", 
			"pembelian.divisi");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
        if(!empty($request->pembelian_tanggal)){
          $tgl = $request->pembelian_tanggal;
          $db->where("DATE(tanggal_pembelian)='$tgl' and category_barang='1' and setatus='Closed'");
      }else{
          $db->where("category_barang='1' and setatus='Closed'");
      }
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				pembelian.id_pembelian LIKE ? OR 
				pembelian.tanggal_pembelian LIKE ? OR 
				pembelian.no_invoice LIKE ? OR 
				pembelian.id_suplier LIKE ? OR 
				pembelian.nama_suplier LIKE ? OR 
				pembelian.alamat LIKE ? OR 
				pembelian.no_hp LIKE ? OR 
				pembelian.total_jumlah LIKE ? OR 
				pembelian.total_harga_beli LIKE ? OR 
				pembelian.total_diskon LIKE ? OR 
				pembelian.ppn LIKE ? OR 
				pembelian.category_barang LIKE ? OR 
				pembelian.operator LIKE ? OR 
				pembelian.setatus LIKE ? OR 
				pembelian.date_created LIKE ? OR 
				pembelian.date_updated LIKE ? OR 
				pembelian.divisi LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "pembelian/search.php";
		}
		$db->join("category_barang", "pembelian.category_barang = category_barang.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("pembelian.id_pembelian", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Pembelian";
		$view_name = (is_ajax() ? "pembelian/ajax-obat.php" : "pembelian/obat.php");
		$this->render_view($view_name, $data);
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function alkes($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("pembelian.id_pembelian", 
			"pembelian.tanggal_pembelian", 
			"pembelian.no_invoice", 
			"pembelian.nama_suplier", 
			"pembelian.alamat", 
			"pembelian.no_hp", 
			"pembelian.total_jumlah", 
			"pembelian.total_harga_beli", 
			"pembelian.total_diskon", 
			"pembelian.ppn", 
			"pembelian.category_barang", 
			"category_barang.category AS category_barang_category", 
			"pembelian.operator", 
			"pembelian.setatus", 
			"pembelian.date_created", 
			"pembelian.date_updated", 
			"pembelian.divisi");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
        if(!empty($request->pembelian_tanggal)){
          $tgl = $request->pembelian_tanggal;
          $db->where("DATE(tanggal_pembelian)='$tgl' and category_barang='2' and setatus='Closed'");
      }else{
          $db->where("category_barang='2' and setatus='Closed'");
      }
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				pembelian.id_pembelian LIKE ? OR 
				pembelian.id_suplier LIKE ? OR 
				pembelian.tanggal_pembelian LIKE ? OR 
				pembelian.no_invoice LIKE ? OR 
				pembelian.nama_suplier LIKE ? OR 
				pembelian.alamat LIKE ? OR 
				pembelian.no_hp LIKE ? OR 
				pembelian.total_jumlah LIKE ? OR 
				pembelian.total_harga_beli LIKE ? OR 
				pembelian.total_diskon LIKE ? OR 
				pembelian.ppn LIKE ? OR 
				pembelian.category_barang LIKE ? OR 
				pembelian.operator LIKE ? OR 
				pembelian.setatus LIKE ? OR 
				pembelian.date_created LIKE ? OR 
				pembelian.date_updated LIKE ? OR 
				pembelian.divisi LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "pembelian/search.php";
		}
		$db->join("category_barang", "pembelian.category_barang = category_barang.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("pembelian.id_pembelian", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Pembelian";
		$view_name = (is_ajax() ? "pembelian/ajax-alkes.php" : "pembelian/alkes.php");
		$this->render_view($view_name, $data);
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function atk($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("pembelian.id_pembelian", 
			"pembelian.tanggal_pembelian", 
			"pembelian.no_invoice", 
			"pembelian.nama_suplier", 
			"pembelian.alamat", 
			"pembelian.no_hp", 
			"pembelian.total_jumlah", 
			"pembelian.total_harga_beli", 
			"pembelian.total_diskon", 
			"pembelian.ppn", 
			"pembelian.category_barang", 
			"category_barang.category AS category_barang_category", 
			"pembelian.operator", 
			"pembelian.setatus", 
			"pembelian.date_created", 
			"pembelian.date_updated", 
			"pembelian.divisi");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
        if(!empty($request->pembelian_tanggal)){
          $tgl = $request->pembelian_tanggal;
          $db->where("DATE(tanggal_pembelian)='$tgl' and category_barang='3' and setatus='Closed'");
      }else{
          $db->where("category_barang='3' and setatus='Closed'");
      }
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				pembelian.id_pembelian LIKE ? OR 
				pembelian.id_suplier LIKE ? OR 
				pembelian.tanggal_pembelian LIKE ? OR 
				pembelian.no_invoice LIKE ? OR 
				pembelian.nama_suplier LIKE ? OR 
				pembelian.alamat LIKE ? OR 
				pembelian.no_hp LIKE ? OR 
				pembelian.total_jumlah LIKE ? OR 
				pembelian.total_harga_beli LIKE ? OR 
				pembelian.total_diskon LIKE ? OR 
				pembelian.ppn LIKE ? OR 
				pembelian.category_barang LIKE ? OR 
				pembelian.operator LIKE ? OR 
				pembelian.setatus LIKE ? OR 
				pembelian.date_created LIKE ? OR 
				pembelian.date_updated LIKE ? OR 
				pembelian.divisi LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "pembelian/search.php";
		}
		$db->join("category_barang", "pembelian.category_barang = category_barang.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("pembelian.id_pembelian", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Pembelian";
		$view_name = (is_ajax() ? "pembelian/ajax-atk.php" : "pembelian/atk.php");
		$this->render_view($view_name, $data);
	}
}
