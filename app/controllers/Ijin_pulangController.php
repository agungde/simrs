<?php 
/**
 * Ijin_pulang Page Controller
 * @category  Controller
 */
class Ijin_pulangController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "ijin_pulang";
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
			"tanggal", 
			"nama_pasien", 
			"no_rekam_medis", 
			"jenis_kelamin", 
			"alamat", 
			"dokter", 
			"keterangan", 
			"kamar_kelas", 
			"nama_kamar", 
			"no_kamar", 
			"no_ranjang", 
			"ttd", 
			"kontrol", 
			"tanggal_kontrol", 
			"poli", 
			"id_transaksi");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				ijin_pulang.id LIKE ? OR 
				ijin_pulang.id_daftar LIKE ? OR 
				ijin_pulang.tanggal LIKE ? OR 
				ijin_pulang.nama_pasien LIKE ? OR 
				ijin_pulang.no_rekam_medis LIKE ? OR 
				ijin_pulang.jenis_kelamin LIKE ? OR 
				ijin_pulang.alamat LIKE ? OR 
				ijin_pulang.dokter LIKE ? OR 
				ijin_pulang.keterangan LIKE ? OR 
				ijin_pulang.kamar_kelas LIKE ? OR 
				ijin_pulang.nama_kamar LIKE ? OR 
				ijin_pulang.no_kamar LIKE ? OR 
				ijin_pulang.no_ranjang LIKE ? OR 
				ijin_pulang.ttd LIKE ? OR 
				ijin_pulang.kontrol LIKE ? OR 
				ijin_pulang.tanggal_kontrol LIKE ? OR 
				ijin_pulang.poli LIKE ? OR 
				ijin_pulang.id_transaksi LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "ijin_pulang/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("ijin_pulang.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Ijin Pulang";
		$this->render_view("ijin_pulang/list.php", $data); //render the full page
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
			"tanggal", 
			"nama_pasien", 
			"no_rekam_medis", 
			"jenis_kelamin", 
			"alamat", 
			"poli", 
			"dokter", 
			"keterangan", 
			"kamar_kelas", 
			"nama_kamar", 
			"no_kamar", 
			"no_ranjang", 
			"ttd", 
			"kontrol", 
			"tanggal_kontrol", 
			"id_transaksi");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("ijin_pulang.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Ijin Pulang";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("ijin_pulang/view.php", $record);
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
			$fields = $this->fields = array("id_daftar","tanggal","nama_pasien","no_rekam_medis","jenis_kelamin","alamat","keterangan","ttd","kamar_kelas","nama_kamar","no_kamar","no_ranjang","kontrol","tanggal_kontrol","poli","dokter","id_transaksi");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required',
				'tanggal' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'jenis_kelamin' => 'required',
				'alamat' => 'required',
				'keterangan' => 'required',
				'ttd' => 'required',
				'kontrol' => 'required',
				'poli' => 'required',
				'id_transaksi' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'keterangan' => 'sanitize_string',
				'ttd' => 'sanitize_string',
				'kamar_kelas' => 'sanitize_string',
				'nama_kamar' => 'sanitize_string',
				'no_kamar' => 'sanitize_string',
				'no_ranjang' => 'sanitize_string',
				'kontrol' => 'sanitize_string',
				'tanggal_kontrol' => 'sanitize_string',
				'poli' => 'sanitize_string',
				'dokter' => 'sanitize_string',
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
$postkontrol = $_POST['kontrol'];
$postpoli    = $_POST['poli'];
$postdokter  = $_POST['dokter'];
$tglkontrol  = $_POST['tanggal_kontrol'];
$id_daftar   = $_POST['id_daftar'];
$darecord= $_POST['darecord'];
if($darecord=="RANAP"){
$darecord = "rawat_inap";
}else{
    $darecord = $darecord;
}
   $queryb = mysqli_query($koneksi, "select * from $darecord WHERE id='$id_daftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rowsb = mysqli_num_rows($queryb);
  if ($rowsb <> 0) {
      $row   = mysqli_fetch_assoc($queryb); 
 $no_rekam_medis=$row['no_rekam_medis'];
 $nama_pasien=$row['nama_pasien'];
 $alamat=$row['alamat'];
 $no_hp=$row['no_hp'];
 $tanggal_lahir=$row['tanggal_lahir'];
 $email=$row['email'];
 $umur=$row['umur'];
$no_ktp=$row['no_ktp'];
$jenis_kelamin=$row['jenis_kelamin'];
$pembayaran=$row['pembayaran'];
$setatus_bpjs=$row['setatus_bpjs'];
 $kamar_kelas=$row['kamar_kelas'];
  $nama_kamar=$row['nama_kamar'];
   $no_kamar=$row['no_kamar'];
    $no_ranjang=$row['no_ranjang'];
    $tl = $row['tl'];
    $dokter_pengirim = $row['dokter_'.$darecord];
     $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter_pengirim'");
while ($row3=mysqli_fetch_array($sqlcek3)){
    $nama_dokter=$row3['nama_dokter'];
     $nama_poli=$row3['specialist'];
}
    $dokter=$dokter_pengirim;
}
if($postkontrol=="YA"){
mysqli_query($koneksi, "INSERT INTO `appointment`(`nama_poli`, `dokter`, `tl`, `nama_pasien`, `no_rekam_medis`, `no_hp`, `alamat`, `jenis_kelamin`, `tanggal_lahir`, `email`, `no_ktp`, `tanggal_appointment`) VALUES ('$postpoli','$postdokter','$tl','$nama_pasien','$no_rekam_medis','$no_hp','$alamat','$jenis_kelamin','$tanggal_lahir','$email','$no_ktp','$tglkontrol')");
}
unset($_SESSION['backlink']);
$this->set_flash_msg("Ijin Pulang Berhasil Di Simpan!! ", "success");
return  $this->redirect("$darecord");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("ijin_pulang");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Ijin Pulang";
		$this->render_view("ijin_pulang/add.php");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function pulang($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("id_daftar","tanggal","nama_pasien","no_rekam_medis","jenis_kelamin","alamat","keterangan","ttd","kontrol","tanggal_kontrol","poli","dokter","id_transaksi");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_daftar' => 'required',
				'tanggal' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'jenis_kelamin' => 'required',
				'alamat' => 'required',
				'keterangan' => 'required',
				'ttd' => 'required',
				'kontrol' => 'required',
				'id_transaksi' => 'required',
			);
			$this->sanitize_array = array(
				'id_daftar' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'keterangan' => 'sanitize_string',
				'ttd' => 'sanitize_string',
				'kontrol' => 'sanitize_string',
				'tanggal_kontrol' => 'sanitize_string',
				'poli' => 'sanitize_string',
				'dokter' => 'sanitize_string',
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
$postkontrol = $_POST['kontrol'];
$postpoli    = $_POST['poli'];
$postdokter  = $_POST['dokter'];
$tglkontrol  = $_POST['tanggal_kontrol'];
$id_daftar   = $_POST['id_daftar'];
$darecord    = $_POST['darecord'];
if($darecord=="igd"){
   $queryb = mysqli_query($koneksi, "select * from igd WHERE id_igd='$id_daftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
 }  else  if($darecord=="pendaftaran_poli"){
   $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$id_daftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
 }                                  
  $rowsb = mysqli_num_rows($queryb);
  if ($rowsb <> 0) {
      $row   = mysqli_fetch_assoc($queryb); 
 $no_rekam_medis=$row['no_rekam_medis'];
 $nama_pasien=$row['nama_pasien'];
 $alamat=$row['alamat'];
 $no_hp=$row['no_hp'];
 $tanggal_lahir=$row['tanggal_lahir'];
 $email=$row['email'];
 $umur=$row['umur'];
$no_ktp=$row['no_ktp'];
$jenis_kelamin=$row['jenis_kelamin'];
$pembayaran=$row['pembayaran'];
$setatus_bpjs=$row['setatus_bpjs'];
  $tl = $row['tl'];   
     $dokter_pengirim=$row['dokter'];
     $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter_pengirim'");
while ($row3=mysqli_fetch_array($sqlcek3)){
    $nama_dokter=$row3['nama_dokter'];
     $nama_poli=$row3['specialist'];
}
    $dokter=$dokter_pengirim;
}
if($postkontrol=="YA"){
mysqli_query($koneksi, "INSERT INTO `appointment`(`nama_poli`, `dokter`, `tl`, `nama_pasien`, `no_rekam_medis`, `no_hp`, `alamat`, `jenis_kelamin`, `tanggal_lahir`, `email`, `no_ktp`, `tanggal_appointment`) VALUES ('$postpoli','$postdokter','$tl','$nama_pasien','$no_rekam_medis','$no_hp','$alamat','$jenis_kelamin','$tanggal_lahir','$email','$no_ktp','$tglkontrol')");
}
if($darecord=="pendaftaran_poli"){
mysqli_query($koneksi, "UPDATE pendaftaran_poli SET setatus='Closed' WHERE id_pendaftaran_poli='$id_daftar'");
      mysqli_query($koneksi,"UPDATE data_rm SET setatus='Closed' WHERE id_daftar='$id_daftar' and no_rekam_medis='$no_rekam_medis'");
}
unset($_SESSION['backlink']);
$this->set_flash_msg("Ijin Pulang Berhasil Di Simpan!! ", "success");
return  $this->redirect("$darecord");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("ijin_pulang");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Ijin Pulang";
		$this->render_view("ijin_pulang/pulang.php");
	}
}
