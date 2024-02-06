<?php 
/**
 * Data_penjualan Page Controller
 * @category  Controller
 */
class Data_penjualanController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_penjualan";
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
		$fields = array("id_data_penjualan", 
			"id_pelanggan", 
			"tanggal", 
			"nama_pelanggan", 
			"alamat", 
			"no_hp", 
			"kode_barang", 
			"nama_barang", 
			"jumlah", 
			"harga", 
			"total_harga", 
			"total_bayar", 
			"ppn", 
			"nama_poli", 
			"operator", 
			"date_created", 
			"date_updated", 
			"id_penjualan", 
			"diskon", 
			"id_jual", 
			"no_invoice", 
			"id_transaksi", 
			"divisi", 
			"bagian", 
			"lap", 
			"id_data_setok", 
			"trx", 
			"setatus");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_penjualan.id_data_penjualan LIKE ? OR 
				data_penjualan.id_pelanggan LIKE ? OR 
				data_penjualan.tanggal LIKE ? OR 
				data_penjualan.nama_pelanggan LIKE ? OR 
				data_penjualan.alamat LIKE ? OR 
				data_penjualan.no_hp LIKE ? OR 
				data_penjualan.kode_barang LIKE ? OR 
				data_penjualan.nama_barang LIKE ? OR 
				data_penjualan.jumlah LIKE ? OR 
				data_penjualan.harga LIKE ? OR 
				data_penjualan.total_harga LIKE ? OR 
				data_penjualan.total_bayar LIKE ? OR 
				data_penjualan.ppn LIKE ? OR 
				data_penjualan.nama_poli LIKE ? OR 
				data_penjualan.operator LIKE ? OR 
				data_penjualan.date_created LIKE ? OR 
				data_penjualan.date_updated LIKE ? OR 
				data_penjualan.id_penjualan LIKE ? OR 
				data_penjualan.diskon LIKE ? OR 
				data_penjualan.id_jual LIKE ? OR 
				data_penjualan.no_invoice LIKE ? OR 
				data_penjualan.id_transaksi LIKE ? OR 
				data_penjualan.divisi LIKE ? OR 
				data_penjualan.bagian LIKE ? OR 
				data_penjualan.lap LIKE ? OR 
				data_penjualan.id_data_setok LIKE ? OR 
				data_penjualan.trx LIKE ? OR 
				data_penjualan.setatus LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_penjualan/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_penjualan.id_data_penjualan", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Penjualan";
		$view_name = (is_ajax() ? "data_penjualan/ajax-list.php" : "data_penjualan/list.php");
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
		$fields = array("id_data_penjualan", 
			"id_pelanggan", 
			"tanggal", 
			"nama_pelanggan", 
			"alamat", 
			"no_hp", 
			"kode_barang", 
			"nama_barang", 
			"jumlah", 
			"harga", 
			"total_harga", 
			"total_bayar", 
			"ppn", 
			"nama_poli", 
			"operator", 
			"date_created", 
			"date_updated", 
			"id_penjualan", 
			"diskon", 
			"no_invoice", 
			"id_transaksi", 
			"divisi", 
			"bagian", 
			"lap", 
			"id_data_setok", 
			"trx", 
			"setatus");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_penjualan.id_data_penjualan", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Penjualan";
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
		return $this->render_view("data_penjualan/view.php", $record);
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
			$fields = $this->fields = array("id_pelanggan","tanggal","nama_pelanggan","alamat","no_hp","kode_barang","nama_barang","jumlah","harga","total_harga","total_bayar","ppn","nama_poli","operator","date_updated","id_penjualan","diskon","no_invoice","id_transaksi","divisi","bagian","lap","id_data_setok","trx","setatus");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_pelanggan' => 'required',
				'tanggal' => 'required',
				'nama_pelanggan' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'jumlah' => 'required|numeric',
				'harga' => 'required|numeric',
				'total_harga' => 'required|numeric',
				'total_bayar' => 'required|numeric',
				'ppn' => 'required',
				'nama_poli' => 'required|numeric',
				'operator' => 'required|numeric',
				'date_updated' => 'required',
				'id_penjualan' => 'required',
				'diskon' => 'required',
				'no_invoice' => 'required',
				'id_transaksi' => 'required|numeric',
				'divisi' => 'required',
				'bagian' => 'required',
				'lap' => 'required|numeric',
				'id_data_setok' => 'required|numeric',
				'trx' => 'required',
				'setatus' => 'required',
			);
			$this->sanitize_array = array(
				'id_pelanggan' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_pelanggan' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'jumlah' => 'sanitize_string',
				'harga' => 'sanitize_string',
				'total_harga' => 'sanitize_string',
				'total_bayar' => 'sanitize_string',
				'ppn' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
				'id_penjualan' => 'sanitize_string',
				'diskon' => 'sanitize_string',
				'no_invoice' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
				'divisi' => 'sanitize_string',
				'bagian' => 'sanitize_string',
				'lap' => 'sanitize_string',
				'id_data_setok' => 'sanitize_string',
				'trx' => 'sanitize_string',
				'setatus' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_penjualan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Penjualan";
		$this->render_view("data_penjualan/add.php");
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
		$fields = $this->fields = array("id_data_penjualan","id_pelanggan","tanggal","nama_pelanggan","alamat","no_hp","kode_barang","nama_barang","jumlah","harga","total_harga","total_bayar","ppn","nama_poli","operator","date_updated","id_penjualan","diskon","id_jual","no_invoice","id_transaksi","divisi","bagian","lap","id_data_setok","trx","setatus");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_pelanggan' => 'required',
				'tanggal' => 'required',
				'nama_pelanggan' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'jumlah' => 'required|numeric',
				'harga' => 'required|numeric',
				'total_harga' => 'required|numeric',
				'total_bayar' => 'required|numeric',
				'ppn' => 'required',
				'nama_poli' => 'required|numeric',
				'operator' => 'required|numeric',
				'date_updated' => 'required',
				'id_penjualan' => 'required',
				'diskon' => 'required',
				'id_jual' => 'required',
				'no_invoice' => 'required',
				'id_transaksi' => 'required|numeric',
				'divisi' => 'required',
				'bagian' => 'required',
				'lap' => 'required|numeric',
				'id_data_setok' => 'required|numeric',
				'trx' => 'required',
				'setatus' => 'required',
			);
			$this->sanitize_array = array(
				'id_pelanggan' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_pelanggan' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'jumlah' => 'sanitize_string',
				'harga' => 'sanitize_string',
				'total_harga' => 'sanitize_string',
				'total_bayar' => 'sanitize_string',
				'ppn' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
				'id_penjualan' => 'sanitize_string',
				'diskon' => 'sanitize_string',
				'id_jual' => 'sanitize_string',
				'no_invoice' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
				'divisi' => 'sanitize_string',
				'bagian' => 'sanitize_string',
				'lap' => 'sanitize_string',
				'id_data_setok' => 'sanitize_string',
				'trx' => 'sanitize_string',
				'setatus' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_penjualan.id_data_penjualan", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_penjualan");
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
						return	$this->redirect("data_penjualan");
					}
				}
			}
		}
		$db->where("data_penjualan.id_data_penjualan", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Penjualan";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_penjualan/edit.php", $data);
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
		$db->where("data_penjualan.id_data_penjualan", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("data_penjualan");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function detail($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id_data_penjualan", 
			"kode_barang", 
			"nama_barang", 
			"jumlah", 
			"harga", 
			"total_harga", 
			"total_bayar", 
			"id_penjualan", 
			"no_invoice", 
			"id_transaksi", 
			"divisi", 
			"bagian", 
			"lap", 
			"id_data_setok", 
			"trx", 
			"setatus");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(!empty($_GET['data_penjualan'])){
$idpenjualan = $_GET['data_penjualan'];
$db->where("id_penjualan='$idpenjualan'");
}
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_penjualan.id_data_penjualan LIKE ? OR 
				data_penjualan.id_pelanggan LIKE ? OR 
				data_penjualan.tanggal LIKE ? OR 
				data_penjualan.nama_pelanggan LIKE ? OR 
				data_penjualan.alamat LIKE ? OR 
				data_penjualan.no_hp LIKE ? OR 
				data_penjualan.kode_barang LIKE ? OR 
				data_penjualan.nama_barang LIKE ? OR 
				data_penjualan.jumlah LIKE ? OR 
				data_penjualan.harga LIKE ? OR 
				data_penjualan.total_harga LIKE ? OR 
				data_penjualan.total_bayar LIKE ? OR 
				data_penjualan.nama_poli LIKE ? OR 
				data_penjualan.ppn LIKE ? OR 
				data_penjualan.operator LIKE ? OR 
				data_penjualan.date_created LIKE ? OR 
				data_penjualan.date_updated LIKE ? OR 
				data_penjualan.id_penjualan LIKE ? OR 
				data_penjualan.diskon LIKE ? OR 
				data_penjualan.id_jual LIKE ? OR 
				data_penjualan.no_invoice LIKE ? OR 
				data_penjualan.id_transaksi LIKE ? OR 
				data_penjualan.divisi LIKE ? OR 
				data_penjualan.bagian LIKE ? OR 
				data_penjualan.lap LIKE ? OR 
				data_penjualan.id_data_setok LIKE ? OR 
				data_penjualan.trx LIKE ? OR 
				data_penjualan.setatus LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_penjualan/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_penjualan.id_data_penjualan", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Penjualan";
		$view_name = (is_ajax() ? "data_penjualan/ajax-detail.php" : "data_penjualan/detail.php");
		$this->render_view($view_name, $data);
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function penjualan($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id_data_penjualan", 
			"kode_barang", 
			"nama_barang", 
			"jumlah", 
			"harga", 
			"diskon", 
			"ppn", 
			"total_harga", 
			"no_invoice", 
			"id_transaksi", 
			"divisi", 
			"bagian", 
			"lap", 
			"id_data_setok", 
			"trx", 
			"setatus");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_penjualan.id_data_penjualan LIKE ? OR 
				data_penjualan.id_pelanggan LIKE ? OR 
				data_penjualan.tanggal LIKE ? OR 
				data_penjualan.nama_pelanggan LIKE ? OR 
				data_penjualan.alamat LIKE ? OR 
				data_penjualan.no_hp LIKE ? OR 
				data_penjualan.kode_barang LIKE ? OR 
				data_penjualan.nama_barang LIKE ? OR 
				data_penjualan.jumlah LIKE ? OR 
				data_penjualan.harga LIKE ? OR 
				data_penjualan.diskon LIKE ? OR 
				data_penjualan.ppn LIKE ? OR 
				data_penjualan.total_harga LIKE ? OR 
				data_penjualan.total_bayar LIKE ? OR 
				data_penjualan.nama_poli LIKE ? OR 
				data_penjualan.operator LIKE ? OR 
				data_penjualan.date_created LIKE ? OR 
				data_penjualan.date_updated LIKE ? OR 
				data_penjualan.id_penjualan LIKE ? OR 
				data_penjualan.id_jual LIKE ? OR 
				data_penjualan.no_invoice LIKE ? OR 
				data_penjualan.id_transaksi LIKE ? OR 
				data_penjualan.divisi LIKE ? OR 
				data_penjualan.bagian LIKE ? OR 
				data_penjualan.lap LIKE ? OR 
				data_penjualan.id_data_setok LIKE ? OR 
				data_penjualan.trx LIKE ? OR 
				data_penjualan.setatus LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_penjualan/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_penjualan.id_data_penjualan", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Penjualan";
		$view_name = (is_ajax() ? "data_penjualan/ajax-penjualan.php" : "data_penjualan/penjualan.php");
		$this->render_view($view_name, $data);
	}
}
