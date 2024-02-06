<?php 
/**
 * Data_hasil_lab Page Controller
 * @category  Controller
 */
class Data_hasil_labController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_hasil_lab";
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
		$fields = array("nama_pemeriksaan", 
			"nilai_rujukan", 
			"hasil_pemeriksaan", 
			"diagnosa", 
			"jenis_pemeriksaan", 
			"harga", 
			"id", 
			"id_transaksi");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(!empty($request->data_hasil_lab_id_hasil_lab)){
$val  = $request->data_hasil_lab_id_hasil_lab;
$db->where("data_hasil_lab.id_hasil_lab", $val , "=");
}  
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_hasil_lab.id_hasil_lab LIKE ? OR 
				data_hasil_lab.nama_pemeriksaan LIKE ? OR 
				data_hasil_lab.nilai_rujukan LIKE ? OR 
				data_hasil_lab.hasil_pemeriksaan LIKE ? OR 
				data_hasil_lab.date_created LIKE ? OR 
				data_hasil_lab.date_updated LIKE ? OR 
				data_hasil_lab.dokter_lab LIKE ? OR 
				data_hasil_lab.id_daftar_lab LIKE ? OR 
				data_hasil_lab.diagnosa LIKE ? OR 
				data_hasil_lab.jenis_pemeriksaan LIKE ? OR 
				data_hasil_lab.harga LIKE ? OR 
				data_hasil_lab.id LIKE ? OR 
				data_hasil_lab.id_transaksi LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_hasil_lab/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_hasil_lab.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Hasil Lab";
		$view_name = (is_ajax() ? "data_hasil_lab/ajax-list.php" : "data_hasil_lab/list.php");
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
		$fields = array("nama_pemeriksaan", 
			"nilai_rujukan", 
			"hasil_pemeriksaan", 
			"date_created", 
			"date_updated", 
			"dokter_lab", 
			"diagnosa", 
			"jenis_pemeriksaan", 
			"harga", 
			"id", 
			"id_transaksi");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_hasil_lab.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Hasil Lab";
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
		return $this->render_view("data_hasil_lab/view.php", $record);
	}
	/**
     * Insert multiple record into the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$request = $this->request;
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("nama_pemeriksaan","hasil_pemeriksaan","nilai_rujukan","id_daftar_lab","diagnosa","jenis_pemeriksaan","harga","id_transaksi"); 
			$allpostdata = $this->format_multi_request_data($formdata);
			$allmodeldata = array();
			foreach($allpostdata as &$postdata){
			$this->rules_array = array(
				'nama_pemeriksaan' => 'required',
				'hasil_pemeriksaan' => 'required',
				'nilai_rujukan' => 'required',
				'id_daftar_lab' => 'required',
				'diagnosa' => 'required',
				'jenis_pemeriksaan' => 'required',
				'harga' => 'required|numeric',
				'id_transaksi' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'nama_pemeriksaan' => 'sanitize_string',
				'hasil_pemeriksaan' => 'sanitize_string',
				'nilai_rujukan' => 'sanitize_string',
				'id_daftar_lab' => 'sanitize_string',
				'diagnosa' => 'sanitize_string',
				'jenis_pemeriksaan' => 'sanitize_string',
				'harga' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
				$allmodeldata[] = $modeldata;
			}
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insertMulti($tablename, $allmodeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_hasil_lab");
				}
				else{
					$this->set_page_error(); //check if there's any db error and pass it to the view
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Hasil Lab";
		return $this->render_view("data_hasil_lab/add.php");
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
		$fields = $this->fields = array("nama_pemeriksaan","hasil_pemeriksaan","nilai_rujukan","id_daftar_lab","diagnosa","jenis_pemeriksaan","harga","id_transaksi");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_pemeriksaan' => 'required',
				'hasil_pemeriksaan' => 'required',
				'nilai_rujukan' => 'required',
				'id_daftar_lab' => 'required',
				'diagnosa' => 'required',
				'jenis_pemeriksaan' => 'required',
				'harga' => 'required|numeric',
				'id_transaksi' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'nama_pemeriksaan' => 'sanitize_string',
				'hasil_pemeriksaan' => 'sanitize_string',
				'nilai_rujukan' => 'sanitize_string',
				'id_daftar_lab' => 'sanitize_string',
				'diagnosa' => 'sanitize_string',
				'jenis_pemeriksaan' => 'sanitize_string',
				'harga' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_hasil_lab.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_hasil_lab");
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
						return	$this->redirect("data_hasil_lab");
					}
				}
			}
		}
		$db->where("data_hasil_lab.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Hasil Lab";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_hasil_lab/edit.php", $data);
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
		$db->where("data_hasil_lab.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("data_hasil_lab");
	}
}
