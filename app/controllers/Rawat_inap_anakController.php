<?php 
/**
 * Rawat_inap_anak Page Controller
 * @category  Controller
 */
class Rawat_inap_anakController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "rawat_inap_anak";
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
			"id_igd", 
			"id_transaksi", 
			"tanggal_masuk", 
			"nama_pasien", 
			"no_rekam_medis", 
			"alamat", 
			"tanggal_lahir", 
			"umur", 
			"jenis_kelamin", 
			"nama_orang_tua", 
			"action", 
			"pemeriksaan_fisik", 
			"catatan_medis", 
			"tindakan", 
			"rekam_medis", 
			"resep_obat", 
			"lab", 
			"status", 
			"assesment_medis", 
			"assesment_triase", 
			"tanggal_keluar", 
			"operator", 
			"date_created");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				rawat_inap_anak.id LIKE ? OR 
				rawat_inap_anak.id_igd LIKE ? OR 
				rawat_inap_anak.id_transaksi LIKE ? OR 
				rawat_inap_anak.tanggal_masuk LIKE ? OR 
				rawat_inap_anak.nama_pasien LIKE ? OR 
				rawat_inap_anak.no_rekam_medis LIKE ? OR 
				rawat_inap_anak.alamat LIKE ? OR 
				rawat_inap_anak.tanggal_lahir LIKE ? OR 
				rawat_inap_anak.umur LIKE ? OR 
				rawat_inap_anak.jenis_kelamin LIKE ? OR 
				rawat_inap_anak.nama_orang_tua LIKE ? OR 
				rawat_inap_anak.action LIKE ? OR 
				rawat_inap_anak.pemeriksaan_fisik LIKE ? OR 
				rawat_inap_anak.catatan_medis LIKE ? OR 
				rawat_inap_anak.tindakan LIKE ? OR 
				rawat_inap_anak.rekam_medis LIKE ? OR 
				rawat_inap_anak.resep_obat LIKE ? OR 
				rawat_inap_anak.lab LIKE ? OR 
				rawat_inap_anak.status LIKE ? OR 
				rawat_inap_anak.assesment_medis LIKE ? OR 
				rawat_inap_anak.assesment_triase LIKE ? OR 
				rawat_inap_anak.tanggal_keluar LIKE ? OR 
				rawat_inap_anak.operator LIKE ? OR 
				rawat_inap_anak.date_created LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "rawat_inap_anak/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("rawat_inap_anak.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Rawat Inap Anak";
		$this->render_view("rawat_inap_anak/list.php", $data); //render the full page
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
			"id_igd", 
			"id_transaksi", 
			"tanggal_masuk", 
			"nama_pasien", 
			"no_rekam_medis", 
			"alamat", 
			"tanggal_lahir", 
			"umur", 
			"jenis_kelamin", 
			"nama_orang_tua", 
			"action", 
			"pemeriksaan_fisik", 
			"catatan_medis", 
			"tindakan", 
			"rekam_medis", 
			"resep_obat", 
			"lab", 
			"status", 
			"assesment_medis", 
			"assesment_triase", 
			"tanggal_keluar", 
			"operator", 
			"date_created");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("rawat_inap_anak.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Rawat Inap Anak";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("rawat_inap_anak/view.php", $record);
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
			$fields = $this->fields = array("id_igd","id_transaksi","tanggal_masuk","nama_pasien","no_rekam_medis","alamat","tanggal_lahir","umur","jenis_kelamin","nama_orang_tua");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_igd' => 'required|numeric',
				'id_transaksi' => 'required|numeric',
				'tanggal_masuk' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'umur' => 'required',
				'jenis_kelamin' => 'required',
				'nama_orang_tua' => 'required',
			);
			$this->sanitize_array = array(
				'id_igd' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
				'tanggal_masuk' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'nama_orang_tua' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("rawat_inap_anak");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Rawat Inap Anak";
		$this->render_view("rawat_inap_anak/add.php");
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
		$fields = $this->fields = array("id","nama_orang_tua");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_orang_tua' => 'required',
			);
			$this->sanitize_array = array(
				'nama_orang_tua' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("rawat_inap_anak.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("rawat_inap_anak");
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
						return	$this->redirect("rawat_inap_anak");
					}
				}
			}
		}
		$db->where("rawat_inap_anak.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Rawat Inap Anak";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("rawat_inap_anak/edit.php", $data);
	}
}
