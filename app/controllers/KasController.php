<?php 
/**
 * Kas Page Controller
 * @category  Controller
 */
class KasController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "kas";
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
		$fields = array("kas.id", 
			"kas.tanggal", 
			"kas.keterangan", 
			"kas.debet", 
			"kas.kredit", 
			"kas.saldo", 
			"kas.kasir", 
			"user_login.nama AS user_login_nama", 
			"kas.setatus", 
			"kas.kas_awal", 
			"kas.transaksi", 
			"data_bank.nama_bank AS data_bank_nama_bank", 
			"kas.saldo_cash", 
			"kas.date_created", 
			"kas.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				kas.id LIKE ? OR 
				kas.tanggal LIKE ? OR 
				kas.keterangan LIKE ? OR 
				kas.debet LIKE ? OR 
				kas.kredit LIKE ? OR 
				kas.saldo LIKE ? OR 
				kas.kasir LIKE ? OR 
				kas.setatus LIKE ? OR 
				kas.kas_awal LIKE ? OR 
				kas.transaksi LIKE ? OR 
				kas.saldo_cash LIKE ? OR 
				kas.date_created LIKE ? OR 
				kas.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "kas/search.php";
		}
		$db->join("user_login", "kas.kasir = user_login.id_userlogin", "INNER");
		$db->join("data_bank", "kas.transaksi = data_bank.id_databank", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("kas.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Kas";
		$view_name = (is_ajax() ? "kas/ajax-list.php" : "kas/list.php");
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
		$fields = array("kas.id", 
			"kas.tanggal", 
			"kas.keterangan", 
			"kas.debet", 
			"kas.kredit", 
			"kas.saldo", 
			"kas.kasir", 
			"user_login.nama AS user_login_nama", 
			"kas.setatus", 
			"kas.kas_awal", 
			"kas.transaksi", 
			"data_bank.nama_bank AS data_bank_nama_bank", 
			"kas.saldo_cash", 
			"kas.date_created", 
			"kas.date_updated");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("kas.id", $rec_id);; //select record based on primary key
		}
		$db->join("user_login", "kas.kasir = user_login.id_userlogin", "INNER");
		$db->join("data_bank", "kas.transaksi = data_bank.id_databank", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Kas";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("kas/view.php", $record);
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
			$fields = $this->fields = array("tanggal","keterangan","debet","kredit","saldo","kasir","setatus","kas_awal","transaksi","saldo_cash");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'keterangan' => 'required',
				'debet' => 'required|numeric',
				'kredit' => 'required|numeric',
				'saldo' => 'required|numeric',
				'kasir' => 'required',
				'setatus' => 'required',
				'kas_awal' => 'required|numeric',
				'transaksi' => 'required',
				'saldo_cash' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'keterangan' => 'sanitize_string',
				'debet' => 'sanitize_string',
				'kredit' => 'sanitize_string',
				'saldo' => 'sanitize_string',
				'kasir' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'kas_awal' => 'sanitize_string',
				'transaksi' => 'sanitize_string',
				'saldo_cash' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("kas");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Kas";
		$this->render_view("kas/add.php");
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
		$fields = $this->fields = array("id","tanggal","keterangan","debet","kredit","saldo","kasir","setatus","kas_awal","transaksi","saldo_cash");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'keterangan' => 'required',
				'debet' => 'required|numeric',
				'kredit' => 'required|numeric',
				'saldo' => 'required|numeric',
				'kasir' => 'required',
				'setatus' => 'required',
				'kas_awal' => 'required|numeric',
				'transaksi' => 'required',
				'saldo_cash' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'keterangan' => 'sanitize_string',
				'debet' => 'sanitize_string',
				'kredit' => 'sanitize_string',
				'saldo' => 'sanitize_string',
				'kasir' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'kas_awal' => 'sanitize_string',
				'transaksi' => 'sanitize_string',
				'saldo_cash' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("kas.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("kas");
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
						return	$this->redirect("kas");
					}
				}
			}
		}
		$db->where("kas.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Kas";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("kas/edit.php", $data);
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
		$db->where("kas.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("kas");
	}
}
