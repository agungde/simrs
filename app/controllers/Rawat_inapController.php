<?php 
/**
 * Rawat_inap Page Controller
 * @category  Controller
 */
class Rawat_inapController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "rawat_inap";
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
		$fields = array("rawat_inap.id", 
			"rawat_inap.id_igd", 
			"rawat_inap.tanggal_masuk", 
			"rawat_inap.no_rekam_medis", 
			"rawat_inap.nama_pasien", 
			"rawat_inap.tl", 
			"rawat_inap.tanggal_lahir", 
			"rawat_inap.umur", 
			"rawat_inap.jenis_kelamin", 
			"rawat_inap.alamat", 
			"rawat_inap.poli", 
			"data_poli.nama_poli AS data_poli_nama_poli", 
			"rawat_inap.pasien", 
			"rawat_inap.dokter_pengirim", 
			"rawat_inap.dokter_rawat_inap", 
			"data_dokter.nama_dokter AS data_dokter_nama_dokter", 
			"rawat_inap.action", 
			"rawat_inap.pemeriksaan_fisik", 
			"rawat_inap.catatan_medis", 
			"rawat_inap.tindakan", 
			"rawat_inap.resep_obat", 
			"rawat_inap.lab", 
			"rawat_inap.assesment_medis", 
			"rawat_inap.rekam_medis", 
			"rawat_inap.pembayaran", 
			"data_bank.nama_bank AS data_bank_nama_bank", 
			"rawat_inap.setatus_bpjs", 
			"rawat_inap.kamar_kelas", 
			"rawat_inap.nama_kamar", 
			"rawat_inap.no_kamar", 
			"rawat_inap.no_ranjang", 
			"rawat_inap.setatus", 
			"rawat_inap.tanggal_keluar", 
			"rawat_inap.id_poli", 
			"rawat_inap.operator", 
			"user_login.nama AS user_login_nama", 
			"rawat_inap.id_transaksi");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				rawat_inap.id LIKE ? OR 
				rawat_inap.id_igd LIKE ? OR 
				rawat_inap.tanggal_masuk LIKE ? OR 
				rawat_inap.no_rekam_medis LIKE ? OR 
				rawat_inap.nama_pasien LIKE ? OR 
				rawat_inap.tl LIKE ? OR 
				rawat_inap.tanggal_lahir LIKE ? OR 
				rawat_inap.umur LIKE ? OR 
				rawat_inap.jenis_kelamin LIKE ? OR 
				rawat_inap.alamat LIKE ? OR 
				rawat_inap.poli LIKE ? OR 
				rawat_inap.pasien LIKE ? OR 
				rawat_inap.dokter_pengirim LIKE ? OR 
				rawat_inap.dokter_rawat_inap LIKE ? OR 
				rawat_inap.action LIKE ? OR 
				rawat_inap.pemeriksaan_fisik LIKE ? OR 
				rawat_inap.catatan_medis LIKE ? OR 
				rawat_inap.tindakan LIKE ? OR 
				rawat_inap.resep_obat LIKE ? OR 
				rawat_inap.lab LIKE ? OR 
				rawat_inap.assesment_medis LIKE ? OR 
				rawat_inap.rekam_medis LIKE ? OR 
				rawat_inap.pembayaran LIKE ? OR 
				rawat_inap.setatus_bpjs LIKE ? OR 
				rawat_inap.kamar_kelas LIKE ? OR 
				rawat_inap.nama_kamar LIKE ? OR 
				rawat_inap.no_kamar LIKE ? OR 
				rawat_inap.no_ranjang LIKE ? OR 
				rawat_inap.setatus LIKE ? OR 
				rawat_inap.tanggal_keluar LIKE ? OR 
				rawat_inap.no_hp LIKE ? OR 
				rawat_inap.email LIKE ? OR 
				rawat_inap.no_ktp LIKE ? OR 
				rawat_inap.penanggung_jawab LIKE ? OR 
				rawat_inap.id_penanggung_jawab LIKE ? OR 
				rawat_inap.alamat_penanggung_jawab LIKE ? OR 
				rawat_inap.no_hp_penanggung_jawab LIKE ? OR 
				rawat_inap.hubungan LIKE ? OR 
				rawat_inap.rawat_inap LIKE ? OR 
				rawat_inap.back_link LIKE ? OR 
				rawat_inap.id_poli LIKE ? OR 
				rawat_inap.operator LIKE ? OR 
				rawat_inap.date_created LIKE ? OR 
				rawat_inap.date_updated LIKE ? OR 
				rawat_inap.id_transaksi LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "rawat_inap/search.php";
		}
		$db->join("data_poli", "rawat_inap.poli = data_poli.id_poli", "INNER");
		$db->join("data_dokter", "rawat_inap.dokter_rawat_inap = data_dokter.id_dokter", "INNER");
		$db->join("data_bank", "rawat_inap.pembayaran = data_bank.id_databank", "INNER");
		$db->join("user_login", "rawat_inap.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("rawat_inap.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		if(!empty($request->rawat_inap_nama_kamar)){
			$val = $request->rawat_inap_nama_kamar;
			$db->where("rawat_inap.nama_kamar", $val , "=");
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
		$page_title = $this->view->page_title = "Rawat Inap";
		$this->render_view("rawat_inap/list.php", $data); //render the full page
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
		$fields = array("rawat_inap.id", 
			"rawat_inap.tanggal_masuk", 
			"rawat_inap.pasien", 
			"rawat_inap.nama_pasien", 
			"rawat_inap.no_rekam_medis", 
			"rawat_inap.alamat", 
			"rawat_inap.jenis_kelamin", 
			"rawat_inap.dokter_pengirim", 
			"rawat_inap.dokter_rawat_inap", 
			"data_dokter.nama_dokter AS data_dokter_nama_dokter", 
			"rawat_inap.tl", 
			"rawat_inap.no_ktp", 
			"rawat_inap.tanggal_lahir", 
			"rawat_inap.umur", 
			"rawat_inap.no_hp", 
			"rawat_inap.email", 
			"rawat_inap.pembayaran", 
			"data_bank.nama_bank AS data_bank_nama_bank", 
			"rawat_inap.penanggung_jawab", 
			"rawat_inap.id_penanggung_jawab", 
			"rawat_inap.alamat_penanggung_jawab", 
			"rawat_inap.no_hp_penanggung_jawab", 
			"rawat_inap.hubungan", 
			"rawat_inap.rawat_inap", 
			"rawat_inap.setatus_bpjs", 
			"rawat_inap.setatus", 
			"rawat_inap.operator", 
			"user_login.nama AS user_login_nama", 
			"rawat_inap.kamar_kelas", 
			"rawat_inap.nama_kamar", 
			"rawat_inap.no_kamar", 
			"rawat_inap.no_ranjang", 
			"rawat_inap.poli", 
			"data_poli.nama_poli AS data_poli_nama_poli", 
			"rawat_inap.tanggal_keluar");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("rawat_inap.id", $rec_id);; //select record based on primary key
		}
		$db->join("data_dokter", "rawat_inap.dokter_rawat_inap = data_dokter.id_dokter", "INNER");
		$db->join("data_bank", "rawat_inap.pembayaran = data_bank.id_databank", "INNER");
		$db->join("user_login", "rawat_inap.operator = user_login.id_userlogin", "INNER");
		$db->join("data_poli", "rawat_inap.poli = data_poli.id_poli", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Rawat Inap";
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
		return $this->render_view("rawat_inap/view.php", $record);
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
			$fields = $this->fields = array("id_igd","tanggal_masuk","pasien","dokter_pengirim","pembayaran","setatus_bpjs","tl","nama_pasien","no_rekam_medis","poli","dokter_rawat_inap","no_ktp","alamat","tanggal_lahir","jenis_kelamin","umur","no_hp","email","penanggung_jawab","id_penanggung_jawab","alamat_penanggung_jawab","no_hp_penanggung_jawab","hubungan","id_transaksi");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal_masuk' => 'required',
				'pasien' => 'required',
				'dokter_pengirim' => 'required',
				'pembayaran' => 'required',
				'setatus_bpjs' => 'required',
				'nama_pasien' => 'required',
				'poli' => 'required',
				'dokter_rawat_inap' => 'required',
				'no_ktp' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'jenis_kelamin' => 'required',
				'umur' => 'required',
				'penanggung_jawab' => 'required',
				'id_penanggung_jawab' => 'required',
				'alamat_penanggung_jawab' => 'required',
				'no_hp_penanggung_jawab' => 'required',
				'hubungan' => 'required',
				'id_transaksi' => 'required',
			);
			$this->sanitize_array = array(
				'id_igd' => 'sanitize_string',
				'tanggal_masuk' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'setatus_bpjs' => 'sanitize_string',
				'tl' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'poli' => 'sanitize_string',
				'dokter_rawat_inap' => 'sanitize_string',
				'no_ktp' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'email' => 'sanitize_string',
				'penanggung_jawab' => 'sanitize_string',
				'id_penanggung_jawab' => 'sanitize_string',
				'alamat_penanggung_jawab' => 'sanitize_string',
				'no_hp_penanggung_jawab' => 'sanitize_string',
				'hubungan' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
$idigd       = $_POST['id_igd'];
if($idigd=="" or $idigd=="0"){
}else{
mysqli_query($koneksi,"UPDATE igd SET rawat_inap='Register' WHERE id_igd='$idigd'");
}
 $tgl = $_POST['tanggal_masuk'];
 $jam = $tgl;
 $querml = mysqli_query($koneksi, "select * from data_pasien WHERE no_rekam_medis='$no_rekam_medis'")  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rorml = mysqli_num_rows($querml);
  if ($rorml <> 0) {
      $dalm = mysqli_fetch_assoc($querml);
       $rmlm = $dalm['rm'];
  }
   $querml = mysqli_query($koneksi, "select * from data_pasien WHERE no_rekam_medis='$no_rekam_medis'")  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rorml = mysqli_num_rows($querml);
  if ($rorml <> 0) {
      $dalm = mysqli_fetch_assoc($querml);
       $rmlm = $dalm['rm'];
  } 
    $tgl = $_POST['tanggal_masuk'];
  $no_rekam_medis = $_POST['no_rekam_medis'];
 $jam = $tgl;  
 mysqli_query($koneksi,"INSERT INTO `data_rm`(`nama_pasien`,`id_daftar`,`tanggal`, `jam`, `no_rekam_medis`, `rm_lama`,`rawat_inap`,`setatus`) VALUES ('$nama_pasien','$rec_id','$tgl','$jam','$no_rekam_medis','$rmlm','RAWAT INAP','Register')");
$db->rawQuery("UPDATE rawat_inap SET setatus='Register', operator='".USER_ID."' WHERE id='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("rawat_inap");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Rawat Inap";
		$this->render_view("rawat_inap/add.php");
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
		$fields = $this->fields = array("id","pembayaran","poli","dokter_rawat_inap","penanggung_jawab","id_penanggung_jawab","alamat_penanggung_jawab","no_hp_penanggung_jawab","hubungan");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'pembayaran' => 'required',
				'poli' => 'required',
				'dokter_rawat_inap' => 'required',
				'penanggung_jawab' => 'required',
				'id_penanggung_jawab' => 'required',
				'alamat_penanggung_jawab' => 'required',
				'no_hp_penanggung_jawab' => 'required',
				'hubungan' => 'required',
			);
			$this->sanitize_array = array(
				'pembayaran' => 'sanitize_string',
				'poli' => 'sanitize_string',
				'dokter_rawat_inap' => 'sanitize_string',
				'penanggung_jawab' => 'sanitize_string',
				'id_penanggung_jawab' => 'sanitize_string',
				'alamat_penanggung_jawab' => 'sanitize_string',
				'no_hp_penanggung_jawab' => 'sanitize_string',
				'hubungan' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("rawat_inap.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("rawat_inap");
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
						return	$this->redirect("rawat_inap");
					}
				}
			}
		}
		$db->where("rawat_inap.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Rawat Inap";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("rawat_inap/edit.php", $data);
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
		$db->where("rawat_inap.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("rawat_inap");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function operasi($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"id_igd", 
			"tanggal_masuk", 
			"no_rekam_medis", 
			"no_ktp", 
			"nama_pasien", 
			"alamat", 
			"tanggal_lahir", 
			"jenis_kelamin", 
			"umur", 
			"no_hp", 
			"email", 
			"pembayaran", 
			"penanggung_jawab", 
			"id_penanggung_jawab", 
			"alamat_penanggung_jawab", 
			"no_hp_penanggung_jawab", 
			"hubungan", 
			"rawat_inap", 
			"setatus_bpjs", 
			"back_link", 
			"action", 
			"setatus", 
			"tindakan", 
			"operator", 
			"date_created", 
			"date_updated", 
			"pasien", 
			"id_poli", 
			"kamar_kelas", 
			"nama_kamar", 
			"no_kamar", 
			"no_ranjang", 
			"dokter_pengirim", 
			"dokter_rawat_inap", 
			"poli", 
			"id_transaksi", 
			"resep_obat", 
			"lab", 
			"catatan_medis", 
			"tl", 
			"assesment_medis", 
			"pemeriksaan_fisik", 
			"rekam_medis", 
			"tanggal_keluar");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				rawat_inap.id LIKE ? OR 
				rawat_inap.id_igd LIKE ? OR 
				rawat_inap.tanggal_masuk LIKE ? OR 
				rawat_inap.no_rekam_medis LIKE ? OR 
				rawat_inap.no_ktp LIKE ? OR 
				rawat_inap.nama_pasien LIKE ? OR 
				rawat_inap.alamat LIKE ? OR 
				rawat_inap.tanggal_lahir LIKE ? OR 
				rawat_inap.jenis_kelamin LIKE ? OR 
				rawat_inap.umur LIKE ? OR 
				rawat_inap.no_hp LIKE ? OR 
				rawat_inap.email LIKE ? OR 
				rawat_inap.pembayaran LIKE ? OR 
				rawat_inap.penanggung_jawab LIKE ? OR 
				rawat_inap.id_penanggung_jawab LIKE ? OR 
				rawat_inap.alamat_penanggung_jawab LIKE ? OR 
				rawat_inap.no_hp_penanggung_jawab LIKE ? OR 
				rawat_inap.hubungan LIKE ? OR 
				rawat_inap.rawat_inap LIKE ? OR 
				rawat_inap.setatus_bpjs LIKE ? OR 
				rawat_inap.back_link LIKE ? OR 
				rawat_inap.action LIKE ? OR 
				rawat_inap.setatus LIKE ? OR 
				rawat_inap.tindakan LIKE ? OR 
				rawat_inap.operator LIKE ? OR 
				rawat_inap.date_created LIKE ? OR 
				rawat_inap.date_updated LIKE ? OR 
				rawat_inap.pasien LIKE ? OR 
				rawat_inap.id_poli LIKE ? OR 
				rawat_inap.kamar_kelas LIKE ? OR 
				rawat_inap.nama_kamar LIKE ? OR 
				rawat_inap.no_kamar LIKE ? OR 
				rawat_inap.no_ranjang LIKE ? OR 
				rawat_inap.dokter_pengirim LIKE ? OR 
				rawat_inap.dokter_rawat_inap LIKE ? OR 
				rawat_inap.poli LIKE ? OR 
				rawat_inap.id_transaksi LIKE ? OR 
				rawat_inap.resep_obat LIKE ? OR 
				rawat_inap.lab LIKE ? OR 
				rawat_inap.catatan_medis LIKE ? OR 
				rawat_inap.tl LIKE ? OR 
				rawat_inap.assesment_medis LIKE ? OR 
				rawat_inap.pemeriksaan_fisik LIKE ? OR 
				rawat_inap.rekam_medis LIKE ? OR 
				rawat_inap.tanggal_keluar LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "rawat_inap/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("rawat_inap.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Rawat Inap";
		$view_name = (is_ajax() ? "rawat_inap/ajax-operasi.php" : "rawat_inap/operasi.php");
		$this->render_view($view_name, $data);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function resep($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("id_igd","tanggal_masuk","no_rekam_medis","no_ktp","nama_pasien","alamat","tanggal_lahir","jenis_kelamin","umur","no_hp","email","pembayaran","penanggung_jawab","id_penanggung_jawab","alamat_penanggung_jawab","no_hp_penanggung_jawab","hubungan","rawat_inap","setatus_bpjs","back_link","action","setatus","tindakan","operator","date_created","date_updated","pasien","id_poli","kamar_kelas","nama_kamar","no_kamar","no_ranjang","dokter_pengirim","dokter_rawat_inap","poli","id_transaksi","resep_obat","lab","catatan_medis","tl","assesment_medis","pemeriksaan_fisik","rekam_medis","tanggal_keluar");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_igd' => 'required|numeric',
				'tanggal_masuk' => 'required',
				'no_rekam_medis' => 'required',
				'no_ktp' => 'required|numeric',
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'jenis_kelamin' => 'required',
				'umur' => 'required',
				'no_hp' => 'required',
				'email' => 'required|valid_email',
				'pembayaran' => 'required|numeric',
				'penanggung_jawab' => 'required',
				'id_penanggung_jawab' => 'required',
				'alamat_penanggung_jawab' => 'required',
				'no_hp_penanggung_jawab' => 'required',
				'hubungan' => 'required',
				'rawat_inap' => 'required',
				'setatus_bpjs' => 'required',
				'back_link' => 'required',
				'action' => 'required',
				'setatus' => 'required',
				'tindakan' => 'required',
				'operator' => 'required|numeric',
				'date_created' => 'required',
				'date_updated' => 'required',
				'pasien' => 'required',
				'id_poli' => 'required|numeric',
				'kamar_kelas' => 'required|numeric',
				'nama_kamar' => 'required',
				'no_kamar' => 'required',
				'no_ranjang' => 'required',
				'dokter_pengirim' => 'required|numeric',
				'dokter_rawat_inap' => 'required|numeric',
				'poli' => 'required|numeric',
				'id_transaksi' => 'required|numeric',
				'resep_obat' => 'required|numeric',
				'lab' => 'required',
				'catatan_medis' => 'required',
				'tl' => 'required',
				'assesment_medis' => 'required',
				'pemeriksaan_fisik' => 'required',
				'rekam_medis' => 'required',
				'tanggal_keluar' => 'required',
			);
			$this->sanitize_array = array(
				'id_igd' => 'sanitize_string',
				'tanggal_masuk' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'no_ktp' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'email' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'penanggung_jawab' => 'sanitize_string',
				'id_penanggung_jawab' => 'sanitize_string',
				'alamat_penanggung_jawab' => 'sanitize_string',
				'no_hp_penanggung_jawab' => 'sanitize_string',
				'hubungan' => 'sanitize_string',
				'rawat_inap' => 'sanitize_string',
				'setatus_bpjs' => 'sanitize_string',
				'back_link' => 'sanitize_string',
				'action' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'date_created' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'id_poli' => 'sanitize_string',
				'kamar_kelas' => 'sanitize_string',
				'nama_kamar' => 'sanitize_string',
				'no_kamar' => 'sanitize_string',
				'no_ranjang' => 'sanitize_string',
				'dokter_pengirim' => 'sanitize_string',
				'dokter_rawat_inap' => 'sanitize_string',
				'poli' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
				'resep_obat' => 'sanitize_string',
				'lab' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
				'tl' => 'sanitize_string',
				'assesment_medis' => 'sanitize_string',
				'pemeriksaan_fisik' => 'sanitize_string',
				'rekam_medis' => 'sanitize_string',
				'tanggal_keluar' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("rawat_inap");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Rawat Inap";
		$this->render_view("rawat_inap/resep.php");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function chekin($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("id_igd","setatus","pasien","id_poli","assesment_medis","pemeriksaan_fisik","rekam_medis","tanggal_keluar");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_igd' => 'required',
				'setatus' => 'required',
				'pasien' => 'required',
				'id_poli' => 'required',
				'assesment_medis' => 'required',
				'pemeriksaan_fisik' => 'required',
				'rekam_medis' => 'required',
				'tanggal_keluar' => 'required',
			);
			$this->sanitize_array = array(
				'id_igd' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'id_poli' => 'sanitize_string',
				'assesment_medis' => 'sanitize_string',
				'pemeriksaan_fisik' => 'sanitize_string',
				'rekam_medis' => 'sanitize_string',
				'tanggal_keluar' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("rawat_inap");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Rawat Inap";
		$this->render_view("rawat_inap/chekin.php");
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function pulang($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("rawat_inap.id", 
			"rawat_inap.id_igd", 
			"rawat_inap.tanggal_masuk", 
			"rawat_inap.no_rekam_medis", 
			"rawat_inap.nama_pasien", 
			"rawat_inap.alamat", 
			"rawat_inap.tanggal_lahir", 
			"rawat_inap.jenis_kelamin", 
			"rawat_inap.umur", 
			"rawat_inap.pasien", 
			"rawat_inap.id_poli", 
			"rawat_inap.nama_kamar", 
			"rawat_inap.no_kamar", 
			"rawat_inap.no_ranjang", 
			"rawat_inap.dokter_rawat_inap", 
			"data_dokter.nama_dokter AS data_dokter_nama_dokter", 
			"rawat_inap.id_transaksi", 
			"rawat_inap.tanggal_keluar");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("rawat_inap.id", $rec_id);; //select record based on primary key
		}
		$db->join("data_dokter", "rawat_inap.dokter_rawat_inap = data_dokter.id_dokter", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Rawat Inap";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("rawat_inap/pulang.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function kunjungan($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal_masuk","no_rekam_medis","nama_pasien","id_transaksi","tanggal_keluar");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal_masuk' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'id_transaksi' => 'required',
				'tanggal_keluar' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal_masuk' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
				'tanggal_keluar' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("rawat_inap");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add Kunjungan Dukter";
		$this->render_view("rawat_inap/kunjungan.php");
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function fisik($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id", 
			"id_igd", 
			"tanggal_masuk", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"tanggal_lahir", 
			"jenis_kelamin", 
			"nama_kamar", 
			"no_kamar", 
			"no_ranjang", 
			"id_transaksi", 
			"tanggal_keluar");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("rawat_inap.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Rawat Inap";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("rawat_inap/fisik.php", $record);
	}
}
