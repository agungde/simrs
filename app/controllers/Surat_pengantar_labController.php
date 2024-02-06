<?php 
/**
 * Surat_pengantar_lab Page Controller
 * @category  Controller
 */
class Surat_pengantar_labController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "surat_pengantar_lab";
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
		$fields = array("id_surat", 
			"tanggal", 
			"dari_poli", 
			"no_rekam_medis", 
			"nama_pasien", 
			"tgl_lahir", 
			"alamat", 
			"id_daftar");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				surat_pengantar_lab.id_surat LIKE ? OR 
				surat_pengantar_lab.tanggal LIKE ? OR 
				surat_pengantar_lab.dari_poli LIKE ? OR 
				surat_pengantar_lab.no_rekam_medis LIKE ? OR 
				surat_pengantar_lab.nama_pasien LIKE ? OR 
				surat_pengantar_lab.tgl_lahir LIKE ? OR 
				surat_pengantar_lab.alamat LIKE ? OR 
				surat_pengantar_lab.ruangan LIKE ? OR 
				surat_pengantar_lab.kelas LIKE ? OR 
				surat_pengantar_lab.hematologi LIKE ? OR 
				surat_pengantar_lab.imuniserologi LIKE ? OR 
				surat_pengantar_lab.kimia_klinik LIKE ? OR 
				surat_pengantar_lab.urin_faces LIKE ? OR 
				surat_pengantar_lab.microbiologi LIKE ? OR 
				surat_pengantar_lab.lain_lain LIKE ? OR 
				surat_pengantar_lab.ttd_dokter LIKE ? OR 
				surat_pengantar_lab.id_daftar LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "surat_pengantar_lab/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("surat_pengantar_lab.id_surat", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Surat Pengantar Lab";
		$this->render_view("surat_pengantar_lab/list.php", $data); //render the full page
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
		$fields = array("id_surat", 
			"nama_pasien", 
			"tgl_lahir", 
			"alamat", 
			"ruangan", 
			"kelas", 
			"hematologi", 
			"imuniserologi", 
			"kimia_klinik", 
			"urin_faces", 
			"microbiologi", 
			"lain_lain", 
			"dari_poli", 
			"ttd_dokter", 
			"tanggal", 
			"id_daftar", 
			"no_rekam_medis");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("surat_pengantar_lab.id_surat", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Surat Pengantar Lab";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("surat_pengantar_lab/view.php", $record);
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
			$fields = $this->fields = array("tanggal","dari_poli","no_rekam_medis","nama_pasien","tgl_lahir","alamat","ruangan","kelas","hematologi","imuniserologi","kimia_klinik","urin_faces","microbiologi","lain_lain","ttd_dokter","id_daftar");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'dari_poli' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'tgl_lahir' => 'required',
				'alamat' => 'required',
				'ttd_dokter' => 'required',
				'id_daftar' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'dari_poli' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'tgl_lahir' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'ruangan' => 'sanitize_string',
				'kelas' => 'sanitize_string',
				'hematologi' => 'sanitize_string',
				'imuniserologi' => 'sanitize_string',
				'kimia_klinik' => 'sanitize_string',
				'urin_faces' => 'sanitize_string',
				'microbiologi' => 'sanitize_string',
				'lain_lain' => 'sanitize_string',
				'ttd_dokter' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("surat_pengantar_lab");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Surat Pengantar Lab";
		$this->render_view("surat_pengantar_lab/add.php");
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
		$fields = $this->fields = array("id_surat","tanggal","dari_poli","no_rekam_medis","nama_pasien","tgl_lahir","alamat","ruangan","kelas","hematologi","imuniserologi","kimia_klinik","urin_faces","microbiologi","lain_lain","id_daftar");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'dari_poli' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'tgl_lahir' => 'required',
				'alamat' => 'required',
				'id_daftar' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'dari_poli' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'tgl_lahir' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'ruangan' => 'sanitize_string',
				'kelas' => 'sanitize_string',
				'hematologi' => 'sanitize_string',
				'imuniserologi' => 'sanitize_string',
				'kimia_klinik' => 'sanitize_string',
				'urin_faces' => 'sanitize_string',
				'microbiologi' => 'sanitize_string',
				'lain_lain' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("surat_pengantar_lab.id_surat", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("surat_pengantar_lab");
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
						return	$this->redirect("surat_pengantar_lab");
					}
				}
			}
		}
		$db->where("surat_pengantar_lab.id_surat", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Surat Pengantar Lab";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("surat_pengantar_lab/edit.php", $data);
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
		$db->where("surat_pengantar_lab.id_surat", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("surat_pengantar_lab");
	}
}
