<?php 
/**
 * Assesment_medis Page Controller
 * @category  Controller
 */
class Assesment_medisController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "assesment_medis";
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
			"id_daftar", 
			"tgl_masuk", 
			"no_rekam_medis", 
			"pasien", 
			"scor_gcs", 
			"td", 
			"dj", 
			"djj", 
			"sh", 
			"spo", 
			"nd", 
			"kondisi_umum", 
			"pemeriksaan_penunjang", 
			"diagnosa_kerja", 
			"diagnosa_banding", 
			"tindakan_pengobatan", 
			"instruksi_selanjutnya", 
			"diteruskan_dokter", 
			"keadaan_keluar_igd", 
			"ttd_dokter");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(!empty($request->precord)){
$rekam = $request->precord;
    $db->where("no_rekam_medis='$rekam'");
}else{
    if(!empty($request->limit_start)){
        }else{
               $this->set_flash_msg("URL Tidak Valid!! ", "danger");
               return  $this->redirect("");
        }
}
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				assesment_medis.id LIKE ? OR 
				assesment_medis.id_daftar LIKE ? OR 
				assesment_medis.tgl_masuk LIKE ? OR 
				assesment_medis.no_rekam_medis LIKE ? OR 
				assesment_medis.nama_pasien LIKE ? OR 
				assesment_medis.tanggal_lahir LIKE ? OR 
				assesment_medis.umur LIKE ? OR 
				assesment_medis.jenis_kelamin LIKE ? OR 
				assesment_medis.pasien LIKE ? OR 
				assesment_medis.tgl_keluar LIKE ? OR 
				assesment_medis.scor_gcs LIKE ? OR 
				assesment_medis.td LIKE ? OR 
				assesment_medis.dj LIKE ? OR 
				assesment_medis.djj LIKE ? OR 
				assesment_medis.sh LIKE ? OR 
				assesment_medis.spo LIKE ? OR 
				assesment_medis.nd LIKE ? OR 
				assesment_medis.kondisi_umum LIKE ? OR 
				assesment_medis.pemeriksaan_penunjang LIKE ? OR 
				assesment_medis.diagnosa_kerja LIKE ? OR 
				assesment_medis.diagnosa_banding LIKE ? OR 
				assesment_medis.tindakan_pengobatan LIKE ? OR 
				assesment_medis.instruksi_selanjutnya LIKE ? OR 
				assesment_medis.diteruskan_dokter LIKE ? OR 
				assesment_medis.keadaan_keluar_igd LIKE ? OR 
				assesment_medis.ttd_dokter LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "assesment_medis/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("assesment_medis.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Assesment Medis";
		$this->render_view("assesment_medis/list.php", $data); //render the full page
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
			"id_daftar", 
			"tgl_masuk", 
			"no_rekam_medis", 
			"nama_pasien", 
			"tanggal_lahir", 
			"umur", 
			"jenis_kelamin", 
			"tgl_keluar", 
			"scor_gcs", 
			"td", 
			"dj", 
			"djj", 
			"sh", 
			"spo", 
			"nd", 
			"kondisi_umum", 
			"pemeriksaan_penunjang", 
			"diagnosa_kerja", 
			"diagnosa_banding", 
			"tindakan_pengobatan", 
			"instruksi_selanjutnya", 
			"diteruskan_dokter", 
			"keadaan_keluar_igd", 
			"ttd_dokter", 
			"pasien");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("assesment_medis.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Assesment Medis";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("assesment_medis/view.php", $record);
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
			$fields = $this->fields = array("id_daftar","tgl_masuk","no_rekam_medis","nama_pasien","tanggal_lahir","umur","jenis_kelamin","scor_gcs","td","dj","djj","sh","spo","nd","kondisi_umum","pemeriksaan_penunjang","diagnosa_kerja","diagnosa_banding","tindakan_pengobatan","instruksi_selanjutnya","diteruskan_dokter","tgl_keluar","keadaan_keluar_igd","ttd_dokter","pasien");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required',
				'tgl_masuk' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'tanggal_lahir' => 'required',
				'umur' => 'required',
				'jenis_kelamin' => 'required',
				'td' => 'required',
				'sh' => 'required',
				'kondisi_umum' => 'required',
				'instruksi_selanjutnya' => 'required',
				'ttd_dokter' => 'required',
				'pasien' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'tgl_masuk' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'scor_gcs' => 'sanitize_string',
				'td' => 'sanitize_string',
				'dj' => 'sanitize_string',
				'djj' => 'sanitize_string',
				'sh' => 'sanitize_string',
				'spo' => 'sanitize_string',
				'nd' => 'sanitize_string',
				'kondisi_umum' => 'sanitize_string',
				'pemeriksaan_penunjang' => 'sanitize_string',
				'diagnosa_kerja' => 'sanitize_string',
				'diagnosa_banding' => 'sanitize_string',
				'tindakan_pengobatan' => 'sanitize_string',
				'instruksi_selanjutnya' => 'sanitize_string',
				'diteruskan_dokter' => 'sanitize_string',
				'tgl_keluar' => 'sanitize_string',
				'keadaan_keluar_igd' => 'sanitize_string',
				'ttd_dokter' => 'sanitize_string',
				'pasien' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		 unset($_SESSION['backlink']);
 $this->set_flash_msg("Assesment Madis Berhasil Di Simpan!! ", "success");
 $daripage = $_POST['pasien'];
if($daripage=="RANAP"){
return  $this->redirect("rawat_inap");
}else if($daripage=="RANAP ANAK"){
return  $this->redirect("rawnap_anak");
}else if($daripage=="RANAP PERINA"){
return  $this->redirect("rawnap_perina");
}else if($daripage=="RANAP BERSALIN"){
return  $this->redirect("rawnap_bersalin");
}else{
    return  $this->redirect("igd");
}
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("assesment_medis");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Assesment Medis";
		$this->render_view("assesment_medis/add.php");
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
		$fields = $this->fields = array("id","scor_gcs","td","dj","djj","sh","spo","nd","kondisi_umum","pemeriksaan_penunjang","diagnosa_kerja","diagnosa_banding","tindakan_pengobatan","instruksi_selanjutnya","diteruskan_dokter","tgl_keluar","keadaan_keluar_igd","ttd_dokter","pasien");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'td' => 'required',
				'sh' => 'required',
				'kondisi_umum' => 'required',
				'instruksi_selanjutnya' => 'required',
				'ttd_dokter' => 'required',
				'pasien' => 'required',
			);
			$this->sanitize_array = array(
				'scor_gcs' => 'sanitize_string',
				'td' => 'sanitize_string',
				'dj' => 'sanitize_string',
				'djj' => 'sanitize_string',
				'sh' => 'sanitize_string',
				'spo' => 'sanitize_string',
				'nd' => 'sanitize_string',
				'kondisi_umum' => 'sanitize_string',
				'pemeriksaan_penunjang' => 'sanitize_string',
				'diagnosa_kerja' => 'sanitize_string',
				'diagnosa_banding' => 'sanitize_string',
				'tindakan_pengobatan' => 'sanitize_string',
				'instruksi_selanjutnya' => 'sanitize_string',
				'diteruskan_dokter' => 'sanitize_string',
				'tgl_keluar' => 'sanitize_string',
				'keadaan_keluar_igd' => 'sanitize_string',
				'ttd_dokter' => 'sanitize_string',
				'pasien' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("assesment_medis.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("assesment_medis");
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
						return	$this->redirect("assesment_medis");
					}
				}
			}
		}
		$db->where("assesment_medis.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Assesment Medis";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("assesment_medis/edit.php", $data);
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
		$db->where("assesment_medis.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("assesment_medis");
	}
}
