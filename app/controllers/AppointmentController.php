<?php 
/**
 * Appointment Page Controller
 * @category  Controller
 */
class AppointmentController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "appointment";
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
		$fields = array("appointment.id_appointment", 
			"appointment.tanggal_appointment", 
			"appointment.no_rekam_medis", 
			"appointment.no_antri_poli", 
			"appointment.nama_pasien", 
			"appointment.alamat", 
			"appointment.nama_poli", 
			"data_poli.nama_poli AS data_poli_nama_poli", 
			"appointment.dokter", 
			"appointment.no_hp", 
			"appointment.jenis_kelamin", 
			"appointment.tanggal_lahir", 
			"appointment.email", 
			"appointment.setatus", 
			"appointment.keluhan", 
			"appointment.operator", 
			"user_login.nama AS user_login_nama", 
			"appointment.date_created", 
			"appointment.date_updated", 
			"appointment.id_pendaftaran_poli", 
			"appointment.tl", 
			"appointment.id_daftar");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	 $id_user = "".USER_ID;
 $dbhost="".DB_HOST;
$dbuser="".DB_USERNAME;
$dbpass="".DB_PASSWORD;
$dbname="".DB_NAME;
//$koneksi=open_connection();
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$sqlcek  = mysqli_query($koneksi,"select * from user_login WHERE id_userlogin='$id_user'");
while ($row=mysqli_fetch_array($sqlcek)){
    $cekdata = trim($row['user_role_id']);
}
$sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
if(!empty($request->appointment_tanggal)){
$val = $request->appointment_tanggal;
if($cekdata=="2"){
 $db->where("id_user='". USER_ID . "' and DATE(appointment.tanggal_appointment)", $val , "=");
}else{
 $db->where("DATE(appointment.tanggal_appointment)", $val , "=");
}
}
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				appointment.id_user LIKE ? OR 
				appointment.id_appointment LIKE ? OR 
				appointment.tanggal_appointment LIKE ? OR 
				appointment.no_rekam_medis LIKE ? OR 
				appointment.no_antri_poli LIKE ? OR 
				appointment.nama_pasien LIKE ? OR 
				appointment.alamat LIKE ? OR 
				appointment.nama_poli LIKE ? OR 
				appointment.dokter LIKE ? OR 
				appointment.no_hp LIKE ? OR 
				appointment.jenis_kelamin LIKE ? OR 
				appointment.tanggal_lahir LIKE ? OR 
				appointment.email LIKE ? OR 
				appointment.setatus LIKE ? OR 
				appointment.keluhan LIKE ? OR 
				appointment.operator LIKE ? OR 
				appointment.date_created LIKE ? OR 
				appointment.date_updated LIKE ? OR 
				appointment.id_pendaftaran_poli LIKE ? OR 
				appointment.no_ktp LIKE ? OR 
				appointment.tl LIKE ? OR 
				appointment.id_daftar LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "appointment/search.php";
		}
		$db->join("data_poli", "appointment.nama_poli = data_poli.id_poli", "INNER");
		$db->join("user_login", "appointment.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("appointment.id_appointment", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Appointment";
		$view_name = (is_ajax() ? "appointment/ajax-list.php" : "appointment/list.php");
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
		$fields = array("appointment.id_appointment", 
			"appointment.tanggal_appointment", 
			"appointment.no_rekam_medis", 
			"appointment.nama_pasien", 
			"appointment.alamat", 
			"appointment.nama_poli", 
			"data_poli.nama_poli AS data_poli_nama_poli", 
			"appointment.dokter", 
			"data_dokter.nama_dokter AS data_dokter_nama_dokter", 
			"appointment.no_antri_poli", 
			"appointment.no_hp", 
			"appointment.jenis_kelamin", 
			"appointment.tanggal_lahir", 
			"appointment.email", 
			"appointment.setatus", 
			"appointment.keluhan", 
			"appointment.operator", 
			"user_login.nama AS user_login_nama", 
			"appointment.tl", 
			"appointment.id_daftar");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("appointment.id_appointment", $rec_id);; //select record based on primary key
		}
		$db->join("data_poli", "appointment.nama_poli = data_poli.id_poli", "INNER");
		$db->join("data_dokter", "appointment.dokter = data_dokter.id_dokter", "INNER");
		$db->join("user_login", "appointment.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Appointment";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("appointment/view.php", $record);
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
			$fields = $this->fields = array("tanggal_appointment","no_rekam_medis","tl","nama_pasien","no_ktp","alamat","keluhan","nama_poli","dokter","no_hp","jenis_kelamin","tanggal_lahir","email");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal_appointment' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'no_ktp' => 'required',
				'alamat' => 'required',
				'keluhan' => 'required',
				'nama_poli' => 'required',
				'dokter' => 'required',
				'jenis_kelamin' => 'required',
				'tanggal_lahir' => 'required',
				'email' => 'valid_email',
			);
			$this->sanitize_array = array(
				'tanggal_appointment' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'tl' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_ktp' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'dokter' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'email' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
		# Statement to execute before adding record
		$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
//$koneksi=open_connection();
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$sekarang       = gmdate("Y-m-d", time() + 60 * 60 * 7);
$no_rekam_medis = trim($_POST['no_rekam_medis']);
$nama_poli      = trim($_POST['nama_poli']);
$tanggal        = trim($_POST['tanggal_appointment']);
 $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE no_rekam_medis='$no_rekam_medis' and tanggal='$tanggal' and nama_poli='$nama_poli'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rowsb = mysqli_num_rows($queryb);
  // cek hasil query
  // jika "no_antrian" sudah ada
  if ($rowsb <> 0) {
        $this->set_flash_msg("Data Pasien Sudah Terdaftar ", "warning");
 return  $this->redirect("pendaftaran_poli");
  }else{
  }
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
//$koneksi=open_connection();
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$sqlcek1 = mysqli_query($koneksi,"select * from user_login WHERE id_userlogin='$id_user'");
while ($row=mysqli_fetch_array($sqlcek1)){
$cekdata1 = $row['user_role_id'];
if($cekdata1=="2"){
mysqli_query($koneksi,"UPDATE appointment SET id_user='$id_user' WHERE id_appointment='$rec_id'");
}else{
    $db->rawQuery("UPDATE appointment SET operator='".USER_ID."' WHERE id_appointment='$rec_id'");
}
}
  // membuat "no_antrian"
  // sql statement untuk menampilkan data "no_antrian" terakhir pada tabel "tbl_antrian" berdasarkan "tanggal"
  $tglpesan = trim($_POST['tanggal_appointment']);
  $query = mysqli_query($koneksi, "SELECT max(no_antri_poli) as nomor from pendaftaran_poli WHERE nama_poli='$nama_poli' and tanggal='$tglpesan'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rows = mysqli_num_rows($query);
  // cek hasil query
  // jika "no_antrian" sudah ada
  if ($rows <> 0) {
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);
    // "no_antrian" = "no_antrian" yang terakhir + 1
    $no_antrian = $data['nomor'] + 1;
  }
  // jika "no_antrian" belum ada
  else {
    // "no_antrian" = 1
    $no_antrian = 1;
  }
$no_antri_poli = $no_antrian;
$sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
    $thn  = substr($_POST['tanggal_lahir'], 0, 4);
    $taun = date("Y");
    $umur = $taun - $thn;
    $umur = substr($umur, 0, 2);
function hitung_umur($thn){
    $birthDate = new DateTime($thn);
    $today = new DateTime("today");
    if ($birthDate > $today) { 
        exit("0 tahun 0 bulan 0 hari");
    }
    $y = $today->diff($birthDate)->y;
    $m = $today->diff($birthDate)->m;
    $d = $today->diff($birthDate)->d;
    return $y."Tahun ".$m."Bulan ".$d."Hari";
}
$umurnya = hitung_umur($_POST['tanggal_lahir']);
mysqli_query($koneksi,"INSERT INTO `pendaftaran_poli` (`no_ktp`,`umur`,`email`,`keluhan`,`nama_pasien`, `nama_poli`, `dokter`, `no_rekam_medis`, `no_hp`, `alamat`, `jenis_kelamin`, `tanggal_lahir`, `tanggal`, `id_appointment`) VALUES ('".$_POST['no_ktp']."','$umurnya','".$_POST['email']."','".$_POST['keluhan']."','".$_POST['nama_pasien']."', '".$_POST['nama_poli']."', '".$_POST['dokter']."', '".$_POST['no_rekam_medis']."', '".$_POST['no_hp']."', '".$_POST['alamat']."', '".$_POST['jenis_kelamin']."', '".$_POST['tanggal_lahir']."', '".$_POST['tanggal_appointment']."','$rec_id')"); 
 $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_appointment='$rec_id'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rowsb = mysqli_num_rows($queryb);
  if ($rowsb <> 0) {
$data   = mysqli_fetch_assoc($queryb);
$idpoli = $data['id_pendaftaran_poli'];
      $db->rawQuery("UPDATE appointment SET id_pendaftaran_poli='$idpoli' WHERE id_appointment='$rec_id'");
  }
$db->rawQuery("UPDATE appointment SET no_antri_poli='$no_antri_poli' WHERE id_appointment='$rec_id'");
//$pembayaran     = $_POST['pembayaran'];
//$setatus_bpjs   = $_POST['setatus_bpjs'];
$no_rekam_medis = trim($_POST['no_rekam_medis']);
$no_ktp         = $_POST['no_ktp'];
//$nama_poli      = $_POST['nama_poli'];
//$tanggal        = $_POST['tanggal'];
$email          = $_POST['email'];
$tl             = $_POST['tl'];
$alamat         = $_POST['alamat'];
$nama_pasien    = $_POST['nama_pasien'];
// mysqli_query($koneksi, "UPDATE data_pasien SET umur='$umurnya' WHERE no_rekam_medis='$no_rekam_medis'");
     mysqli_query($koneksi, "UPDATE data_pasien SET nama_pasien='$nama_pasien', tl='$tl', alamat='$alamat', umur='$umurnya', no_ktp='$no_ktp', email='$email' WHERE no_rekam_medis='$no_rekam_medis'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("appointment");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Appointment";
		$this->render_view("appointment/add.php");
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
		$fields = $this->fields = array("id_appointment","tanggal_appointment","no_rekam_medis","tl","nama_pasien","no_ktp","alamat","keluhan","nama_poli","dokter","no_hp","jenis_kelamin","tanggal_lahir","email");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal_appointment' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'no_ktp' => 'required',
				'alamat' => 'required',
				'keluhan' => 'required',
				'nama_poli' => 'required',
				'dokter' => 'required',
				'jenis_kelamin' => 'required',
				'tanggal_lahir' => 'required',
				'email' => 'valid_email',
			);
			$this->sanitize_array = array(
				'tanggal_appointment' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'tl' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_ktp' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'dokter' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'email' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("appointment.id_appointment", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
//$koneksi=open_connection();
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
//$no_antri_poli = "";
$sqlcek2 = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_appointment='$rec_id'");
while ($row2=mysqli_fetch_array($sqlcek2)){
    $no_antrian= $row2['no_antri_poli'];
     $namapoli = $row2['nama_poli'];
}
//$no_antri_poli = $no_antri_poli + 1;
if($_POST['nama_poli']==$namapoli){
}else{
$sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
    $thn  = substr($_POST['tanggal_lahir'], 0, 4);
    $taun = date("Y");
    $umur = $taun - $thn;
    $umur = substr($umur, 0, 2);
function hitung_umur($thn){
    $birthDate = new DateTime($thn);
    $today = new DateTime("today");
    if ($birthDate > $today) { 
        exit("0 tahun 0 bulan 0 hari");
    }
    $y = $today->diff($birthDate)->y;
    $m = $today->diff($birthDate)->m;
    $d = $today->diff($birthDate)->d;
    return $y."Tahun ".$m."Bulan ".$d."Hari";
}
$umurnya=hitung_umur("1980-12-01");
  $query = mysqli_query($koneksi, "SELECT max(no_antri_poli) as nomor from pendaftaran_poli WHERE nama_poli='$nama_poli' and tanggal='$tglpesan'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rows = mysqli_num_rows($query);
  // cek hasil query
  // jika "no_antrian" sudah ada
  if ($rows <> 0) {
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);
    // "no_antrian" = "no_antrian" yang terakhir + 1
    $no_antrian = $data['nomor'] + 1;
  }
  // jika "no_antrian" belum ada
  else {
    // "no_antrian" = 1
    $no_antrian = 1;
  }
}
$sqlcek1 = mysqli_query($koneksi,"select * from user_login WHERE id_userlogin='$id_user'");
while ($row=mysqli_fetch_array($sqlcek1)){
$cekdata1 = $row['user_role_id'];
if($cekdata1=="2"){
$db->rawQuery("UPDATE appointment SET no_antri_poli='$no_antrian', date_updated='".date("Y-m-d H:i:s")."' WHERE id_appointment='$rec_id'");
mysqli_query($koneksi, "UPDATE pendaftaran_poli SET umur='$umurnya', pembayaran=('".$_POST['pembayaran']."',keluhan='".$_POST['keluhan']."',tanggal='".$_POST['tanggal_appointment']."',nama_poli='".$_POST['nama_poli']."',dokter='".$_POST['dokter']."',no_antri_poli='$no_antrian',date_updated='".date("Y-m-d H:i:s")."' WHERE id_appointment='$rec_id'");
}else{
$db->rawQuery("UPDATE appointment SET no_antri_poli='$no_antrian',operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id_appointment='$rec_id'");
mysqli_query($koneksi, "UPDATE pendaftaran_poli SET umur='$umurnya', pembayaran=('".$_POST['pembayaran']."',keluhan='".$_POST['keluhan']."',tanggal='".$_POST['tanggal_appointment']."',nama_poli='".$_POST['nama_poli']."',dokter='".$_POST['dokter']."',no_antri_poli='$no_antrian',date_updated='".date("Y-m-d H:i:s")."',,operator='".USER_ID."' WHERE id_appointment='$rec_id'");
}
}
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("appointment");
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
						return	$this->redirect("appointment");
					}
				}
			}
		}
		$db->where("appointment.id_appointment", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Appointment";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("appointment/edit.php", $data);
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
		$db->where("appointment.id_appointment", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("appointment");
	}
}
