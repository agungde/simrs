<?php 
/**
 * Data_permintaan_harga Page Controller
 * @category  Controller
 */
class Data_permintaan_hargaController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_permintaan_harga";
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
		$fields = array("id", 
			"kode_barang", 
			"nama_barang", 
			"category_barang", 
			"jumlah", 
			"harga_satuan", 
			"no_request");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(!empty($request->detile_request)){
    $req = $request->detile_request;
    $db->where("no_request='$req'");
}else{
    if(!empty($request->limit_start)){
        }else{
               $this->set_flash_msg("URL Tidak Valid!! ", "danger");
               return  $this->redirect("permintaan_harga");
        }
}
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_permintaan_harga.id LIKE ? OR 
				data_permintaan_harga.id_permintaan_harga LIKE ? OR 
				data_permintaan_harga.tanggal LIKE ? OR 
				data_permintaan_harga.id_suplier LIKE ? OR 
				data_permintaan_harga.nama_suplier LIKE ? OR 
				data_permintaan_harga.alamat LIKE ? OR 
				data_permintaan_harga.no_hp LIKE ? OR 
				data_permintaan_harga.email LIKE ? OR 
				data_permintaan_harga.kode_barang LIKE ? OR 
				data_permintaan_harga.nama_barang LIKE ? OR 
				data_permintaan_harga.category_barang LIKE ? OR 
				data_permintaan_harga.jumlah LIKE ? OR 
				data_permintaan_harga.harga_satuan LIKE ? OR 
				data_permintaan_harga.total_harga LIKE ? OR 
				data_permintaan_harga.operator LIKE ? OR 
				data_permintaan_harga.setatus LIKE ? OR 
				data_permintaan_harga.date_created LIKE ? OR 
				data_permintaan_harga.date_updated LIKE ? OR 
				data_permintaan_harga.no_request LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_permintaan_harga/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_permintaan_harga.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Permintaan Harga";
		$view_name = (is_ajax() ? "data_permintaan_harga/ajax-list.php" : "data_permintaan_harga/list.php");
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
		$fields = array("id", 
			"id_permintaan_harga", 
			"tanggal", 
			"id_suplier", 
			"nama_suplier", 
			"alamat", 
			"no_hp", 
			"email", 
			"kode_barang", 
			"nama_barang", 
			"category_barang", 
			"jumlah", 
			"operator", 
			"setatus", 
			"date_created", 
			"date_updated", 
			"harga_satuan", 
			"total_harga", 
			"no_request");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_permintaan_harga.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Permintaan Harga";
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
		return $this->render_view("data_permintaan_harga/view.php", $record);
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
					return	$this->redirect("data_permintaan_harga");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Permintaan Harga";
		$this->render_view("data_permintaan_harga/add.php");
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
		$fields = $this->fields = array("id","kode_barang","nama_barang","jumlah","harga_satuan");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'jumlah' => 'required|numeric',
				'harga_satuan' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'jumlah' => 'sanitize_string',
				'harga_satuan' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_permintaan_harga.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_permintaan_harga");
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
						return	$this->redirect("data_permintaan_harga");
					}
				}
			}
		}
		$db->where("data_permintaan_harga.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Permintaan Harga";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_permintaan_harga/edit.php", $data);
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
		$db->where("data_permintaan_harga.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("data_permintaan_harga");
	}
}
