<?php 
/**
 * Data_pembelian Page Controller
 * @category  Controller
 */
class Data_pembelianController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_pembelian";
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
		$fields = array("id_data_pembelian", 
			"no_invoice", 
			"kode_barang", 
			"nama_barang", 
			"jumlah", 
			"harga_beli", 
			"ppn", 
			"total_harga", 
			"tanggal_expired", 
			"diskon", 
			"total_diskon");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_pembelian.id_data_pembelian LIKE ? OR 
				data_pembelian.id_suplier LIKE ? OR 
				data_pembelian.nama_suplier LIKE ? OR 
				data_pembelian.tanggal_pembelian LIKE ? OR 
				data_pembelian.no_invoice LIKE ? OR 
				data_pembelian.kode_barang LIKE ? OR 
				data_pembelian.nama_barang LIKE ? OR 
				data_pembelian.jumlah LIKE ? OR 
				data_pembelian.harga_beli LIKE ? OR 
				data_pembelian.ppn LIKE ? OR 
				data_pembelian.total_harga LIKE ? OR 
				data_pembelian.tanggal_expired LIKE ? OR 
				data_pembelian.operator LIKE ? OR 
				data_pembelian.date_created LIKE ? OR 
				data_pembelian.date_updated LIKE ? OR 
				data_pembelian.id_pembelian LIKE ? OR 
				data_pembelian.type_pembelian LIKE ? OR 
				data_pembelian.diskon LIKE ? OR 
				data_pembelian.total_diskon LIKE ? OR 
				data_pembelian.idtrace LIKE ? OR 
				data_pembelian.setatus LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_pembelian/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_pembelian.id_data_pembelian", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Pembelian";
		$view_name = (is_ajax() ? "data_pembelian/ajax-list.php" : "data_pembelian/list.php");
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
		$fields = array("id_data_pembelian", 
			"id_suplier", 
			"nama_suplier", 
			"kode_barang", 
			"nama_barang", 
			"jumlah", 
			"harga_beli", 
			"ppn", 
			"total_harga", 
			"tanggal_expired", 
			"operator", 
			"date_created", 
			"date_updated", 
			"id_pembelian", 
			"type_pembelian", 
			"no_invoice", 
			"diskon", 
			"idtrace", 
			"setatus", 
			"tanggal_pembelian", 
			"total_diskon");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_pembelian.id_data_pembelian", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Pembelian";
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
		return $this->render_view("data_pembelian/view.php", $record);
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
			$fields = $this->fields = array("id_data_pembelian","id_suplier","nama_suplier","kode_barang","nama_barang","jumlah","harga_beli","ppn","total_harga","tanggal_expired","operator","date_updated","id_pembelian","type_pembelian","no_invoice","diskon","idtrace","setatus","tanggal_pembelian","total_diskon");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_data_pembelian' => 'required|numeric',
				'id_suplier' => 'required|numeric',
				'nama_suplier' => 'required',
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'jumlah' => 'required|numeric',
				'harga_beli' => 'required|numeric',
				'ppn' => 'required',
				'total_harga' => 'required|numeric',
				'tanggal_expired' => 'required',
				'operator' => 'required|numeric',
				'date_updated' => 'required',
				'id_pembelian' => 'required|numeric',
				'type_pembelian' => 'required',
				'no_invoice' => 'required',
				'diskon' => 'required|numeric',
				'idtrace' => 'required',
				'setatus' => 'required',
				'tanggal_pembelian' => 'required',
				'total_diskon' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'id_data_pembelian' => 'sanitize_string',
				'id_suplier' => 'sanitize_string',
				'nama_suplier' => 'sanitize_string',
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'jumlah' => 'sanitize_string',
				'harga_beli' => 'sanitize_string',
				'ppn' => 'sanitize_string',
				'total_harga' => 'sanitize_string',
				'tanggal_expired' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
				'id_pembelian' => 'sanitize_string',
				'type_pembelian' => 'sanitize_string',
				'no_invoice' => 'sanitize_string',
				'diskon' => 'sanitize_string',
				'idtrace' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'tanggal_pembelian' => 'sanitize_string',
				'total_diskon' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_pembelian");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Pembelian";
		$this->render_view("data_pembelian/add.php");
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
		$fields = $this->fields = array("id_data_pembelian","id_suplier","nama_suplier","kode_barang","nama_barang","jumlah","harga_beli","ppn","total_harga","tanggal_expired","operator","date_updated","id_pembelian","type_pembelian","no_invoice","diskon","idtrace","setatus","tanggal_pembelian","total_diskon");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_data_pembelian' => 'required|numeric',
				'id_suplier' => 'required|numeric',
				'nama_suplier' => 'required',
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'jumlah' => 'required|numeric',
				'harga_beli' => 'required|numeric',
				'ppn' => 'required',
				'total_harga' => 'required|numeric',
				'tanggal_expired' => 'required',
				'operator' => 'required|numeric',
				'date_updated' => 'required',
				'id_pembelian' => 'required|numeric',
				'type_pembelian' => 'required',
				'no_invoice' => 'required',
				'diskon' => 'required|numeric',
				'idtrace' => 'required',
				'setatus' => 'required',
				'tanggal_pembelian' => 'required',
				'total_diskon' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'id_data_pembelian' => 'sanitize_string',
				'id_suplier' => 'sanitize_string',
				'nama_suplier' => 'sanitize_string',
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'jumlah' => 'sanitize_string',
				'harga_beli' => 'sanitize_string',
				'ppn' => 'sanitize_string',
				'total_harga' => 'sanitize_string',
				'tanggal_expired' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
				'id_pembelian' => 'sanitize_string',
				'type_pembelian' => 'sanitize_string',
				'no_invoice' => 'sanitize_string',
				'diskon' => 'sanitize_string',
				'idtrace' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'tanggal_pembelian' => 'sanitize_string',
				'total_diskon' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_pembelian.id_data_pembelian", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_pembelian");
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
						return	$this->redirect("data_pembelian");
					}
				}
			}
		}
		$db->where("data_pembelian.id_data_pembelian", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Pembelian";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_pembelian/edit.php", $data);
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
		$db->where("data_pembelian.id_data_pembelian", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("data_pembelian");
	}
}
