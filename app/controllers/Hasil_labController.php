<?php 
/**
 * Hasil_lab Page Controller
 * @category  Controller
 */
class Hasil_labController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "hasil_lab";
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
		$fields = array("tanggal", 
			"nama_pasien", 
			"no_rekam_medis", 
			"alamat", 
			"no_hp", 
			"keluhan", 
			"nama_poli", 
			"dokter_pengirim", 
			"action", 
			"setatus", 
			"jenis_pemeriksaan", 
			"pasien", 
			"total_harga", 
			"date_created", 
			"id_hasil_lab", 
			"id_daftar_lab", 
			"id_transaksi", 
			"nama_pemeriksaan");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				hasil_lab.tanggal LIKE ? OR 
				hasil_lab.nama_pasien LIKE ? OR 
				hasil_lab.no_rekam_medis LIKE ? OR 
				hasil_lab.alamat LIKE ? OR 
				hasil_lab.no_hp LIKE ? OR 
				hasil_lab.keluhan LIKE ? OR 
				hasil_lab.nama_poli LIKE ? OR 
				hasil_lab.dokter_pengirim LIKE ? OR 
				hasil_lab.action LIKE ? OR 
				hasil_lab.setatus LIKE ? OR 
				hasil_lab.jenis_pemeriksaan LIKE ? OR 
				hasil_lab.diagnosa LIKE ? OR 
				hasil_lab.pasien LIKE ? OR 
				hasil_lab.dokter_lab LIKE ? OR 
				hasil_lab.total_harga LIKE ? OR 
				hasil_lab.operator LIKE ? OR 
				hasil_lab.date_created LIKE ? OR 
				hasil_lab.date_updated LIKE ? OR 
				hasil_lab.id_hasil_lab LIKE ? OR 
				hasil_lab.id_daftar_lab LIKE ? OR 
				hasil_lab.id_transaksi LIKE ? OR 
				hasil_lab.nama_pemeriksaan LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "hasil_lab/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("hasil_lab.id_hasil_lab", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Hasil Lab";
		$this->render_view("hasil_lab/list.php", $data); //render the full page
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
		$fields = array("tanggal", 
			"nama_pasien", 
			"no_rekam_medis", 
			"alamat", 
			"no_hp", 
			"keluhan", 
			"nama_poli", 
			"jenis_pemeriksaan", 
			"diagnosa", 
			"setatus", 
			"pasien", 
			"total_harga", 
			"dokter_pengirim", 
			"id_transaksi", 
			"nama_pemeriksaan");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("hasil_lab.id_hasil_lab", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Hasil Lab";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("hasil_lab/view.php", $record);
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
			$fields = $this->fields = array("tanggal","nama_pasien","no_rekam_medis","alamat","no_hp","keluhan","nama_poli","jenis_pemeriksaan","action","diagnosa","dokter_lab","total_harga","dokter_pengirim","id_transaksi","nama_pemeriksaan");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'keluhan' => 'required',
				'nama_poli' => 'required',
				'jenis_pemeriksaan' => 'required',
				'action' => 'required',
				'diagnosa' => 'required',
				'dokter_lab' => 'required',
				'total_harga' => 'required|numeric',
				'dokter_pengirim' => 'required',
				'id_transaksi' => 'required|numeric',
				'nama_pemeriksaan' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'jenis_pemeriksaan' => 'sanitize_string',
				'action' => 'sanitize_string',
				'diagnosa' => 'sanitize_string',
				'dokter_lab' => 'sanitize_string',
				'total_harga' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
				'nama_pemeriksaan' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("hasil_lab");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Hasil Lab";
		$this->render_view("hasil_lab/add.php");
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
		$fields = $this->fields = array("tanggal","nama_pasien","no_rekam_medis","alamat","no_hp","keluhan","nama_poli","jenis_pemeriksaan","action","diagnosa","dokter_lab","total_harga","dokter_pengirim","id_transaksi","nama_pemeriksaan");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'keluhan' => 'required',
				'nama_poli' => 'required',
				'jenis_pemeriksaan' => 'required',
				'action' => 'required',
				'diagnosa' => 'required',
				'dokter_lab' => 'required',
				'total_harga' => 'required|numeric',
				'dokter_pengirim' => 'required',
				'id_transaksi' => 'required|numeric',
				'nama_pemeriksaan' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'jenis_pemeriksaan' => 'sanitize_string',
				'action' => 'sanitize_string',
				'diagnosa' => 'sanitize_string',
				'dokter_lab' => 'sanitize_string',
				'total_harga' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
				'nama_pemeriksaan' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("hasil_lab.id_hasil_lab", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("hasil_lab");
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
						return	$this->redirect("hasil_lab");
					}
				}
			}
		}
		$db->where("hasil_lab.id_hasil_lab", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Hasil Lab";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("hasil_lab/edit.php", $data);
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
		$db->where("hasil_lab.id_hasil_lab", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("hasil_lab");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function proses_lab($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal","nama_pasien","no_rekam_medis","alamat","no_hp","keluhan","nama_poli","jenis_pemeriksaan","diagnosa","setatus","pasien","total_harga","dokter_pengirim","id_transaksi","nama_pemeriksaan");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'keluhan' => 'required',
				'nama_poli' => 'required',
				'jenis_pemeriksaan' => 'required',
				'diagnosa' => 'required',
				'setatus' => 'required',
				'pasien' => 'required',
				'total_harga' => 'required|numeric',
				'dokter_pengirim' => 'required',
				'id_transaksi' => 'required|numeric',
				'nama_pemeriksaan' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'jenis_pemeriksaan' => 'sanitize_string',
				'diagnosa' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'total_harga' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
				'nama_pemeriksaan' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("hasil_lab");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Hasil Lab";
		$this->render_view("hasil_lab/proses_lab.php");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function hasil($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("tanggal", 
			"nama_pasien", 
			"no_rekam_medis", 
			"alamat", 
			"no_hp", 
			"keluhan", 
			"jenis_pemeriksaan", 
			"nama_poli", 
			"action", 
			"operator", 
			"date_created", 
			"date_updated", 
			"id_hasil_lab", 
			"id_daftar_lab", 
			"diagnosa", 
			"dokter_lab", 
			"setatus", 
			"pasien", 
			"total_harga", 
			"dokter_pengirim", 
			"id_transaksi", 
			"nama_pemeriksaan");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				hasil_lab.tanggal LIKE ? OR 
				hasil_lab.nama_pasien LIKE ? OR 
				hasil_lab.no_rekam_medis LIKE ? OR 
				hasil_lab.alamat LIKE ? OR 
				hasil_lab.no_hp LIKE ? OR 
				hasil_lab.keluhan LIKE ? OR 
				hasil_lab.jenis_pemeriksaan LIKE ? OR 
				hasil_lab.nama_poli LIKE ? OR 
				hasil_lab.action LIKE ? OR 
				hasil_lab.operator LIKE ? OR 
				hasil_lab.date_created LIKE ? OR 
				hasil_lab.date_updated LIKE ? OR 
				hasil_lab.id_hasil_lab LIKE ? OR 
				hasil_lab.id_daftar_lab LIKE ? OR 
				hasil_lab.diagnosa LIKE ? OR 
				hasil_lab.dokter_lab LIKE ? OR 
				hasil_lab.setatus LIKE ? OR 
				hasil_lab.pasien LIKE ? OR 
				hasil_lab.total_harga LIKE ? OR 
				hasil_lab.dokter_pengirim LIKE ? OR 
				hasil_lab.id_transaksi LIKE ? OR 
				hasil_lab.nama_pemeriksaan LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "hasil_lab/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("hasil_lab.id_hasil_lab", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Hasil Lab";
		$this->render_view("hasil_lab/hasil.php", $data); //render the full page
	}
}
