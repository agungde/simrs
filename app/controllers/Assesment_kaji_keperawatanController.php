<?php 
/**
 * Assesment_kaji_keperawatan Page Controller
 * @category  Controller
 */
class Assesment_kaji_keperawatanController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "assesment_kaji_keperawatan";
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
		$fields = array("id_kaji", 
			"nama_pasien", 
			"no_rekam_medis", 
			"tgl_lahir", 
			"jenis_kelamin", 
			"tgl_masuk", 
			"perawat_pemeriksa", 
			"daftar_alergi", 
			"tanda_vital_kondisi_umum", 
			"BB", 
			"TD", 
			"RR", 
			"HG", 
			"TB", 
			"suhu", 
			"scrining_nutrisi", 
			"perubahan_ukuran_pakaian", 
			"terlihat_kurus", 
			"makan_dlm_dua_minggu", 
			"mual_muntah", 
			"diare", 
			"anokresia", 
			"factor_pemberat", 
			"penurunan_fungsi", 
			"status_gizi", 
			"catatan_gizi", 
			"lokasi_nyeri", 
			"waktu_nyer", 
			"pencetus_saat_nyeri", 
			"type_nyeri", 
			"nyeri");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				assesment_kaji_keperawatan.id_kaji LIKE ? OR 
				assesment_kaji_keperawatan.nama_pasien LIKE ? OR 
				assesment_kaji_keperawatan.no_rekam_medis LIKE ? OR 
				assesment_kaji_keperawatan.tgl_lahir LIKE ? OR 
				assesment_kaji_keperawatan.jenis_kelamin LIKE ? OR 
				assesment_kaji_keperawatan.tgl_masuk LIKE ? OR 
				assesment_kaji_keperawatan.perawat_pemeriksa LIKE ? OR 
				assesment_kaji_keperawatan.daftar_alergi LIKE ? OR 
				assesment_kaji_keperawatan.tanda_vital_kondisi_umum LIKE ? OR 
				assesment_kaji_keperawatan.BB LIKE ? OR 
				assesment_kaji_keperawatan.TD LIKE ? OR 
				assesment_kaji_keperawatan.RR LIKE ? OR 
				assesment_kaji_keperawatan.HG LIKE ? OR 
				assesment_kaji_keperawatan.TB LIKE ? OR 
				assesment_kaji_keperawatan.suhu LIKE ? OR 
				assesment_kaji_keperawatan.scrining_nutrisi LIKE ? OR 
				assesment_kaji_keperawatan.perubahan_ukuran_pakaian LIKE ? OR 
				assesment_kaji_keperawatan.terlihat_kurus LIKE ? OR 
				assesment_kaji_keperawatan.makan_dlm_dua_minggu LIKE ? OR 
				assesment_kaji_keperawatan.mual_muntah LIKE ? OR 
				assesment_kaji_keperawatan.diare LIKE ? OR 
				assesment_kaji_keperawatan.anokresia LIKE ? OR 
				assesment_kaji_keperawatan.factor_pemberat LIKE ? OR 
				assesment_kaji_keperawatan.penurunan_fungsi LIKE ? OR 
				assesment_kaji_keperawatan.status_gizi LIKE ? OR 
				assesment_kaji_keperawatan.catatan_gizi LIKE ? OR 
				assesment_kaji_keperawatan.lokasi_nyeri LIKE ? OR 
				assesment_kaji_keperawatan.waktu_nyer LIKE ? OR 
				assesment_kaji_keperawatan.pencetus_saat_nyeri LIKE ? OR 
				assesment_kaji_keperawatan.type_nyeri LIKE ? OR 
				assesment_kaji_keperawatan.nyeri LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "assesment_kaji_keperawatan/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("assesment_kaji_keperawatan.id_kaji", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Assesment Kaji Keperawatan";
		$this->render_view("assesment_kaji_keperawatan/list.php", $data); //render the full page
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
		$fields = array("id_kaji", 
			"nama_pasien", 
			"no_rekam_medis", 
			"tgl_lahir", 
			"jenis_kelamin", 
			"tgl_masuk", 
			"perawat_pemeriksa", 
			"daftar_alergi", 
			"tanda_vital_kondisi_umum", 
			"BB", 
			"TD", 
			"RR", 
			"HG", 
			"TB", 
			"suhu", 
			"scrining_nutrisi", 
			"perubahan_ukuran_pakaian", 
			"terlihat_kurus", 
			"makan_dlm_dua_minggu", 
			"mual_muntah", 
			"diare", 
			"anokresia", 
			"factor_pemberat", 
			"penurunan_fungsi", 
			"status_gizi", 
			"catatan_gizi", 
			"lokasi_nyeri", 
			"waktu_nyer", 
			"pencetus_saat_nyeri", 
			"type_nyeri", 
			"nyeri");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("assesment_kaji_keperawatan.id_kaji", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Assesment Kaji Keperawatan";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("assesment_kaji_keperawatan/view.php", $record);
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
			$fields = $this->fields = array("nama_pasien","no_rekam_medis","tgl_lahir","jenis_kelamin","tgl_masuk","perawat_pemeriksa","daftar_alergi","tanda_vital_kondisi_umum","BB","TD","RR","HG","TB","suhu","scrining_nutrisi","perubahan_ukuran_pakaian","terlihat_kurus","makan_dlm_dua_minggu","mual_muntah","diare","anokresia","factor_pemberat","penurunan_fungsi","status_gizi","catatan_gizi","lokasi_nyeri","waktu_nyer","pencetus_saat_nyeri","type_nyeri","nyeri");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'tgl_lahir' => 'required',
				'jenis_kelamin' => 'required',
				'tgl_masuk' => 'required',
				'perawat_pemeriksa' => 'required',
				'daftar_alergi' => 'required',
				'tanda_vital_kondisi_umum' => 'required',
				'BB' => 'required',
				'TD' => 'required',
				'RR' => 'required',
				'HG' => 'required',
				'TB' => 'required',
				'suhu' => 'required',
				'scrining_nutrisi' => 'required',
				'perubahan_ukuran_pakaian' => 'required',
				'terlihat_kurus' => 'required',
				'makan_dlm_dua_minggu' => 'required',
				'mual_muntah' => 'required',
				'diare' => 'required',
				'anokresia' => 'required',
				'factor_pemberat' => 'required',
				'penurunan_fungsi' => 'required',
				'status_gizi' => 'required',
				'catatan_gizi' => 'required',
				'lokasi_nyeri' => 'required',
				'waktu_nyer' => 'required',
				'pencetus_saat_nyeri' => 'required',
				'type_nyeri' => 'required',
				'nyeri' => 'required',
			);
			$this->sanitize_array = array(
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'tgl_lahir' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'tgl_masuk' => 'sanitize_string',
				'perawat_pemeriksa' => 'sanitize_string',
				'daftar_alergi' => 'sanitize_string',
				'tanda_vital_kondisi_umum' => 'sanitize_string',
				'BB' => 'sanitize_string',
				'TD' => 'sanitize_string',
				'RR' => 'sanitize_string',
				'HG' => 'sanitize_string',
				'TB' => 'sanitize_string',
				'suhu' => 'sanitize_string',
				'scrining_nutrisi' => 'sanitize_string',
				'perubahan_ukuran_pakaian' => 'sanitize_string',
				'terlihat_kurus' => 'sanitize_string',
				'makan_dlm_dua_minggu' => 'sanitize_string',
				'mual_muntah' => 'sanitize_string',
				'diare' => 'sanitize_string',
				'anokresia' => 'sanitize_string',
				'factor_pemberat' => 'sanitize_string',
				'penurunan_fungsi' => 'sanitize_string',
				'status_gizi' => 'sanitize_string',
				'catatan_gizi' => 'sanitize_string',
				'lokasi_nyeri' => 'sanitize_string',
				'waktu_nyer' => 'sanitize_string',
				'pencetus_saat_nyeri' => 'sanitize_string',
				'type_nyeri' => 'sanitize_string',
				'nyeri' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("assesment_kaji_keperawatan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Assesment Kaji Keperawatan";
		$this->render_view("assesment_kaji_keperawatan/add.php");
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
		$fields = $this->fields = array("id_kaji","nama_pasien","no_rekam_medis","tgl_lahir","jenis_kelamin","tgl_masuk","perawat_pemeriksa","daftar_alergi","tanda_vital_kondisi_umum","BB","TD","RR","HG","TB","suhu","scrining_nutrisi","perubahan_ukuran_pakaian","terlihat_kurus","makan_dlm_dua_minggu","mual_muntah","diare","anokresia","factor_pemberat","penurunan_fungsi","status_gizi","catatan_gizi","lokasi_nyeri","waktu_nyer","pencetus_saat_nyeri","type_nyeri","nyeri");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'tgl_lahir' => 'required',
				'jenis_kelamin' => 'required',
				'tgl_masuk' => 'required',
				'perawat_pemeriksa' => 'required',
				'daftar_alergi' => 'required',
				'tanda_vital_kondisi_umum' => 'required',
				'BB' => 'required',
				'TD' => 'required',
				'RR' => 'required',
				'HG' => 'required',
				'TB' => 'required',
				'suhu' => 'required',
				'scrining_nutrisi' => 'required',
				'perubahan_ukuran_pakaian' => 'required',
				'terlihat_kurus' => 'required',
				'makan_dlm_dua_minggu' => 'required',
				'mual_muntah' => 'required',
				'diare' => 'required',
				'anokresia' => 'required',
				'factor_pemberat' => 'required',
				'penurunan_fungsi' => 'required',
				'status_gizi' => 'required',
				'catatan_gizi' => 'required',
				'lokasi_nyeri' => 'required',
				'waktu_nyer' => 'required',
				'pencetus_saat_nyeri' => 'required',
				'type_nyeri' => 'required',
				'nyeri' => 'required',
			);
			$this->sanitize_array = array(
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'tgl_lahir' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'tgl_masuk' => 'sanitize_string',
				'perawat_pemeriksa' => 'sanitize_string',
				'daftar_alergi' => 'sanitize_string',
				'tanda_vital_kondisi_umum' => 'sanitize_string',
				'BB' => 'sanitize_string',
				'TD' => 'sanitize_string',
				'RR' => 'sanitize_string',
				'HG' => 'sanitize_string',
				'TB' => 'sanitize_string',
				'suhu' => 'sanitize_string',
				'scrining_nutrisi' => 'sanitize_string',
				'perubahan_ukuran_pakaian' => 'sanitize_string',
				'terlihat_kurus' => 'sanitize_string',
				'makan_dlm_dua_minggu' => 'sanitize_string',
				'mual_muntah' => 'sanitize_string',
				'diare' => 'sanitize_string',
				'anokresia' => 'sanitize_string',
				'factor_pemberat' => 'sanitize_string',
				'penurunan_fungsi' => 'sanitize_string',
				'status_gizi' => 'sanitize_string',
				'catatan_gizi' => 'sanitize_string',
				'lokasi_nyeri' => 'sanitize_string',
				'waktu_nyer' => 'sanitize_string',
				'pencetus_saat_nyeri' => 'sanitize_string',
				'type_nyeri' => 'sanitize_string',
				'nyeri' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("assesment_kaji_keperawatan.id_kaji", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("assesment_kaji_keperawatan");
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
						return	$this->redirect("assesment_kaji_keperawatan");
					}
				}
			}
		}
		$db->where("assesment_kaji_keperawatan.id_kaji", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Assesment Kaji Keperawatan";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("assesment_kaji_keperawatan/edit.php", $data);
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
		$db->where("assesment_kaji_keperawatan.id_kaji", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("assesment_kaji_keperawatan");
	}
}
