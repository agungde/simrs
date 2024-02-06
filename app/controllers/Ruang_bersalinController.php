<?php 
/**
 * Ruang_bersalin Page Controller
 * @category  Controller
 */
class Ruang_bersalinController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "ruang_bersalin";
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
			"tanggal_masuk", 
			"no_rekam_medis", 
			"nama_pasien", 
			"tgl_lahir", 
			"umur", 
			"jenis_kelamin", 
			"action", 
			"pemeriksaan_fisik", 
			"catatan_medis", 
			"tindakan", 
			"rekam_medis", 
			"resep_obat", 
			"lab", 
			"assesment_medis", 
			"tanggal_keluar", 
			"status", 
			"assesment_triase", 
			"id_igd");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				ruang_bersalin.id LIKE ? OR 
				ruang_bersalin.tanggal_masuk LIKE ? OR 
				ruang_bersalin.no_rekam_medis LIKE ? OR 
				ruang_bersalin.nama_pasien LIKE ? OR 
				ruang_bersalin.tgl_lahir LIKE ? OR 
				ruang_bersalin.umur LIKE ? OR 
				ruang_bersalin.jenis_kelamin LIKE ? OR 
				ruang_bersalin.action LIKE ? OR 
				ruang_bersalin.pemeriksaan_fisik LIKE ? OR 
				ruang_bersalin.catatan_medis LIKE ? OR 
				ruang_bersalin.tindakan LIKE ? OR 
				ruang_bersalin.rekam_medis LIKE ? OR 
				ruang_bersalin.resep_obat LIKE ? OR 
				ruang_bersalin.lab LIKE ? OR 
				ruang_bersalin.assesment_medis LIKE ? OR 
				ruang_bersalin.tanggal_keluar LIKE ? OR 
				ruang_bersalin.status LIKE ? OR 
				ruang_bersalin.assesment_triase LIKE ? OR 
				ruang_bersalin.id_igd LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "ruang_bersalin/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("ruang_bersalin.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Ruang Bersalin";
		$this->render_view("ruang_bersalin/list.php", $data); //render the full page
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
			"tanggal_masuk", 
			"no_rekam_medis", 
			"nama_pasien", 
			"tgl_lahir", 
			"umur", 
			"jenis_kelamin", 
			"action", 
			"pemeriksaan_fisik", 
			"catatan_medis", 
			"tindakan", 
			"rekam_medis", 
			"resep_obat", 
			"lab", 
			"assesment_medis", 
			"tanggal_keluar", 
			"status", 
			"assesment_triase", 
			"id_igd");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("ruang_bersalin.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Ruang Bersalin";
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
		return $this->render_view("ruang_bersalin/view.php", $record);
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
			$fields = $this->fields = array("tanggal_masuk","no_rekam_medis","nama_pasien","tgl_lahir","umur","jenis_kelamin","action","pemeriksaan_fisik","catatan_medis","tindakan","rekam_medis","resep_obat","lab","assesment_medis","tanggal_keluar","status","assesment_triase","id_igd");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal_masuk' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'tgl_lahir' => 'required',
				'umur' => 'required',
				'jenis_kelamin' => 'required',
				'action' => 'required',
				'pemeriksaan_fisik' => 'required',
				'catatan_medis' => 'required',
				'tindakan' => 'required',
				'rekam_medis' => 'required',
				'resep_obat' => 'required',
				'lab' => 'required',
				'assesment_medis' => 'required',
				'tanggal_keluar' => 'required',
				'status' => 'required',
				'assesment_triase' => 'required',
				'id_igd' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'tanggal_masuk' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'tgl_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'action' => 'sanitize_string',
				'pemeriksaan_fisik' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'rekam_medis' => 'sanitize_string',
				'resep_obat' => 'sanitize_string',
				'lab' => 'sanitize_string',
				'assesment_medis' => 'sanitize_string',
				'tanggal_keluar' => 'sanitize_string',
				'status' => 'sanitize_string',
				'assesment_triase' => 'sanitize_string',
				'id_igd' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("ruang_bersalin");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Ruang Bersalin";
		$this->render_view("ruang_bersalin/add.php");
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
		$fields = $this->fields = array("id","tanggal_masuk","no_rekam_medis","nama_pasien","tgl_lahir","umur","jenis_kelamin","action","pemeriksaan_fisik","catatan_medis","tindakan","rekam_medis","resep_obat","lab","assesment_medis","tanggal_keluar","status","assesment_triase","id_igd");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal_masuk' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'tgl_lahir' => 'required',
				'umur' => 'required',
				'jenis_kelamin' => 'required',
				'action' => 'required',
				'pemeriksaan_fisik' => 'required',
				'catatan_medis' => 'required',
				'tindakan' => 'required',
				'rekam_medis' => 'required',
				'resep_obat' => 'required',
				'lab' => 'required',
				'assesment_medis' => 'required',
				'tanggal_keluar' => 'required',
				'status' => 'required',
				'assesment_triase' => 'required',
				'id_igd' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'tanggal_masuk' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'tgl_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'action' => 'sanitize_string',
				'pemeriksaan_fisik' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'rekam_medis' => 'sanitize_string',
				'resep_obat' => 'sanitize_string',
				'lab' => 'sanitize_string',
				'assesment_medis' => 'sanitize_string',
				'tanggal_keluar' => 'sanitize_string',
				'status' => 'sanitize_string',
				'assesment_triase' => 'sanitize_string',
				'id_igd' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("ruang_bersalin.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("ruang_bersalin");
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
						return	$this->redirect("ruang_bersalin");
					}
				}
			}
		}
		$db->where("ruang_bersalin.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Ruang Bersalin";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("ruang_bersalin/edit.php", $data);
	}
}
