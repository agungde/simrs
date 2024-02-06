<?php 
/**
 * Assesment_triase Page Controller
 * @category  Controller
 */
class Assesment_triaseController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "assesment_triase";
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
		$fields = array("id_triase", 
			"tgl_masuk", 
			"jam", 
			"level", 
			"response_time", 
			"keadaan_ke_igd", 
			"rujukan_dari", 
			"tgl_rujukan", 
			"org_yg_bisa_di_hub", 
			"pasien_dr_poli", 
			"keterangan", 
			"dokter_pemeriksa", 
			"ttd_dokter", 
			"ttd_petugas", 
			"id_daftar");
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
				assesment_triase.id_triase LIKE ? OR 
				assesment_triase.tgl_masuk LIKE ? OR 
				assesment_triase.jam LIKE ? OR 
				assesment_triase.level LIKE ? OR 
				assesment_triase.response_time LIKE ? OR 
				assesment_triase.nama_pasien LIKE ? OR 
				assesment_triase.no_rekam_medis LIKE ? OR 
				assesment_triase.tgl_lahir LIKE ? OR 
				assesment_triase.umur LIKE ? OR 
				assesment_triase.jenis_kelamin LIKE ? OR 
				assesment_triase.alamat LIKE ? OR 
				assesment_triase.keadaan_ke_igd LIKE ? OR 
				assesment_triase.rujukan_dari LIKE ? OR 
				assesment_triase.tgl_rujukan LIKE ? OR 
				assesment_triase.org_yg_bisa_di_hub LIKE ? OR 
				assesment_triase.pasien_dr_poli LIKE ? OR 
				assesment_triase.keterangan LIKE ? OR 
				assesment_triase.dokter_pemeriksa LIKE ? OR 
				assesment_triase.ttd_dokter LIKE ? OR 
				assesment_triase.ttd_petugas LIKE ? OR 
				assesment_triase.id_daftar LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "assesment_triase/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("assesment_triase.id_triase", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Assesment Triase";
		$this->render_view("assesment_triase/list.php", $data); //render the full page
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
		$fields = array("id_triase", 
			"level", 
			"response_time", 
			"nama_pasien", 
			"no_rekam_medis", 
			"tgl_lahir", 
			"umur", 
			"jenis_kelamin", 
			"alamat", 
			"keadaan_ke_igd", 
			"rujukan_dari", 
			"tgl_rujukan", 
			"org_yg_bisa_di_hub", 
			"tgl_masuk", 
			"pasien_dr_poli", 
			"keterangan", 
			"jam", 
			"dokter_pemeriksa", 
			"ttd_dokter", 
			"ttd_petugas", 
			"id_daftar");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("assesment_triase.id_triase", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Assesment Triase";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("assesment_triase/view.php", $record);
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
			$fields = $this->fields = array("no_rekam_medis","nama_pasien","alamat","jenis_kelamin","tgl_lahir","umur","keadaan_ke_igd","rujukan_dari","tgl_rujukan","org_yg_bisa_di_hub","tgl_masuk","jam","dokter_pemeriksa","ttd_dokter","level","ttd_petugas","id_daftar");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'jenis_kelamin' => 'required',
				'tgl_lahir' => 'required',
				'umur' => 'required',
				'keadaan_ke_igd' => 'required',
				'org_yg_bisa_di_hub' => 'required',
				'tgl_masuk' => 'required',
				'jam' => 'required',
				'dokter_pemeriksa' => 'required',
				'ttd_dokter' => 'required',
				'level' => 'required',
				'ttd_petugas' => 'required',
				'id_daftar' => 'required',
			);
			$this->sanitize_array = array(
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'tgl_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'keadaan_ke_igd' => 'sanitize_string',
				'rujukan_dari' => 'sanitize_string',
				'tgl_rujukan' => 'sanitize_string',
				'org_yg_bisa_di_hub' => 'sanitize_string',
				'tgl_masuk' => 'sanitize_string',
				'jam' => 'sanitize_string',
				'dokter_pemeriksa' => 'sanitize_string',
				'ttd_dokter' => 'sanitize_string',
				'level' => 'sanitize_string',
				'ttd_petugas' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		//$postlevel = $_POST['level'];
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
   $queryb = mysqli_query($koneksi, "select * from assesment_triase WHERE id_triase='$rec_id'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rowsb = mysqli_num_rows($queryb);
  if ($rowsb <> 0) {
      $row       = mysqli_fetch_assoc($queryb); 
      $postlevel = $row['level'];
}
if($postlevel=="1"){
$db->rawQuery("UPDATE assesment_triase SET level='Resusitasi Segera', response_time='Segera' WHERE id_triase='$rec_id'");
}else if($postlevel=="2"){
$db->rawQuery("UPDATE assesment_triase SET level='Gawat Darurat', response_time='10 menit' WHERE id_triase='$rec_id'");
}else if($postlevel=="3"){
$db->rawQuery("UPDATE assesment_triase SET level='Urgent/ Darurat / Tidak Gawat', response_time='30 menit' WHERE id_triase='$rec_id'");
}else if($postlevel=="4"){
$db->rawQuery("UPDATE assesment_triase SET level='Semi Darurat', response_time='60 Menit' WHERE id_triase='$rec_id'");
}else if($postlevel=="5"){
$db->rawQuery("UPDATE assesment_triase SET level='Tidak Darurat', response_time='120 Menit' WHERE id_triase='$rec_id'");
}else if($postlevel=="6"){
$db->rawQuery("UPDATE assesment_triase SET level='Meninggal' WHERE id_triase='$rec_id'");
}
 unset($_SESSION['backlink']);
$this->set_flash_msg("Assesment Triase Berhasil Di Simpan!! ", "success");
return  $this->redirect("igd");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("assesment_triase");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Assesment Triase";
		$this->render_view("assesment_triase/add.php");
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
		$fields = $this->fields = array("id_triase","no_rekam_medis","nama_pasien","alamat","jenis_kelamin","tgl_lahir","umur","keadaan_ke_igd","rujukan_dari","tgl_rujukan","org_yg_bisa_di_hub","tgl_masuk","jam","dokter_pemeriksa","ttd_dokter","level","ttd_petugas","id_daftar");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'jenis_kelamin' => 'required',
				'tgl_lahir' => 'required',
				'umur' => 'required',
				'keadaan_ke_igd' => 'required',
				'org_yg_bisa_di_hub' => 'required',
				'tgl_masuk' => 'required',
				'jam' => 'required',
				'dokter_pemeriksa' => 'required',
				'ttd_dokter' => 'required',
				'level' => 'required',
				'ttd_petugas' => 'required',
				'id_daftar' => 'required',
			);
			$this->sanitize_array = array(
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'tgl_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'keadaan_ke_igd' => 'sanitize_string',
				'rujukan_dari' => 'sanitize_string',
				'tgl_rujukan' => 'sanitize_string',
				'org_yg_bisa_di_hub' => 'sanitize_string',
				'tgl_masuk' => 'sanitize_string',
				'jam' => 'sanitize_string',
				'dokter_pemeriksa' => 'sanitize_string',
				'ttd_dokter' => 'sanitize_string',
				'level' => 'sanitize_string',
				'ttd_petugas' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("assesment_triase.id_triase", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("assesment_triase");
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
						return	$this->redirect("assesment_triase");
					}
				}
			}
		}
		$db->where("assesment_triase.id_triase", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Assesment Triase";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("assesment_triase/edit.php", $data);
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
		$db->where("assesment_triase.id_triase", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("assesment_triase");
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function triase($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id_triase", 
			"tgl_masuk", 
			"jam", 
			"nama_pasien", 
			"no_rekam_medis", 
			"tgl_lahir", 
			"umur", 
			"jenis_kelamin", 
			"alamat", 
			"keadaan_ke_igd", 
			"rujukan_dari", 
			"tgl_rujukan", 
			"org_yg_bisa_di_hub", 
			"pasien_dr_poli", 
			"keterangan", 
			"dokter_pemeriksa", 
			"level", 
			"response_time", 
			"ttd_dokter", 
			"ttd_petugas", 
			"id_daftar");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("assesment_triase.id_triase", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Assesment Triase";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("assesment_triase/triase.php", $record);
	}
}
