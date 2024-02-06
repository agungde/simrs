<?php 
/**
 * Pendaftaran_poli Page Controller
 * @category  Controller
 */
class Pendaftaran_poliController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "pendaftaran_poli";
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
		$fields = array("pendaftaran_poli.id_pendaftaran_poli", 
			"pendaftaran_poli.tanggal", 
			"pendaftaran_poli.no_rekam_medis", 
			"pendaftaran_poli.nama_pasien", 
			"pendaftaran_poli.tanggal_lahir", 
			"pendaftaran_poli.umur", 
			"pendaftaran_poli.jenis_kelamin", 
			"pendaftaran_poli.alamat", 
			"pendaftaran_poli.keluhan", 
			"pendaftaran_poli.no_antri_poli", 
			"pendaftaran_poli.nama_poli", 
			"pendaftaran_poli.dokter", 
			"data_dokter.nama_dokter AS data_dokter_nama_dokter", 
			"pendaftaran_poli.action", 
			"pendaftaran_poli.pemeriksaan_fisik", 
			"pendaftaran_poli.catatan_medis", 
			"pendaftaran_poli.tindakan", 
			"pendaftaran_poli.lab", 
			"pendaftaran_poli.rekam_medis", 
			"pendaftaran_poli.resep_obat", 
			"pendaftaran_poli.pembayaran", 
			"data_bank.nama_bank AS data_bank_nama_bank", 
			"pendaftaran_poli.setatus_bpjs", 
			"pendaftaran_poli.setatus", 
			"pendaftaran_poli.tl");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(!empty($request->pendaftaran_poli_tanggal)){
    $val = $request->pendaftaran_poli_tanggal;
    $set = $request->pendaftaran_poli_setatus;
        $valp = $request->pendaftaran_poli_nama_poli;
        if($valp==0){
            $db->where("setatus='$set' and DATE(pendaftaran_poli.tanggal)", $val , "=");
            }else{
                $db->where("setatus='$set' and nama_poli='$valp' and DATE(pendaftaran_poli.tanggal)", $val , "=");
            }
        }
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				pendaftaran_poli.id_pendaftaran_poli LIKE ? OR 
				pendaftaran_poli.id_appointment LIKE ? OR 
				pendaftaran_poli.tanggal LIKE ? OR 
				pendaftaran_poli.no_rekam_medis LIKE ? OR 
				pendaftaran_poli.nama_pasien LIKE ? OR 
				pendaftaran_poli.tanggal_lahir LIKE ? OR 
				pendaftaran_poli.umur LIKE ? OR 
				pendaftaran_poli.jenis_kelamin LIKE ? OR 
				pendaftaran_poli.alamat LIKE ? OR 
				pendaftaran_poli.keluhan LIKE ? OR 
				pendaftaran_poli.no_antri_poli LIKE ? OR 
				pendaftaran_poli.nama_poli LIKE ? OR 
				pendaftaran_poli.dokter LIKE ? OR 
				pendaftaran_poli.action LIKE ? OR 
				pendaftaran_poli.pemeriksaan_fisik LIKE ? OR 
				pendaftaran_poli.catatan_medis LIKE ? OR 
				pendaftaran_poli.tindakan LIKE ? OR 
				pendaftaran_poli.lab LIKE ? OR 
				pendaftaran_poli.rekam_medis LIKE ? OR 
				pendaftaran_poli.resep_obat LIKE ? OR 
				pendaftaran_poli.alergi_obat LIKE ? OR 
				pendaftaran_poli.pembayaran LIKE ? OR 
				pendaftaran_poli.setatus_bpjs LIKE ? OR 
				pendaftaran_poli.setatus LIKE ? OR 
				pendaftaran_poli.tinggi LIKE ? OR 
				pendaftaran_poli.berat_badan LIKE ? OR 
				pendaftaran_poli.tensi LIKE ? OR 
				pendaftaran_poli.suhu_badan LIKE ? OR 
				pendaftaran_poli.no_hp LIKE ? OR 
				pendaftaran_poli.email LIKE ? OR 
				pendaftaran_poli.penanggung_jawab LIKE ? OR 
				pendaftaran_poli.identitas_penanggung_jawab LIKE ? OR 
				pendaftaran_poli.operator LIKE ? OR 
				pendaftaran_poli.date_created LIKE ? OR 
				pendaftaran_poli.date_updated LIKE ? OR 
				pendaftaran_poli.no_ktp LIKE ? OR 
				pendaftaran_poli.tl LIKE ? OR 
				pendaftaran_poli.id_transaksi LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "pendaftaran_poli/search.php";
		}
		$db->join("data_dokter", "pendaftaran_poli.dokter = data_dokter.id_dokter", "INNER");
		$db->join("data_bank", "pendaftaran_poli.pembayaran = data_bank.id_databank", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("pendaftaran_poli.id_pendaftaran_poli", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Pendaftaran Poli";
		$view_name = (is_ajax() ? "pendaftaran_poli/ajax-list.php" : "pendaftaran_poli/list.php");
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
		$fields = array("pendaftaran_poli.id_pendaftaran_poli", 
			"pendaftaran_poli.tanggal", 
			"pendaftaran_poli.nama_poli", 
			"pendaftaran_poli.dokter", 
			"data_dokter.nama_dokter AS data_dokter_nama_dokter", 
			"pendaftaran_poli.pembayaran", 
			"data_bank.nama_bank AS data_bank_nama_bank", 
			"pendaftaran_poli.setatus_bpjs", 
			"pendaftaran_poli.nama_pasien", 
			"pendaftaran_poli.no_rekam_medis", 
			"pendaftaran_poli.no_antri_poli", 
			"pendaftaran_poli.keluhan", 
			"pendaftaran_poli.no_hp", 
			"pendaftaran_poli.alamat", 
			"pendaftaran_poli.jenis_kelamin", 
			"pendaftaran_poli.tanggal_lahir", 
			"pendaftaran_poli.umur", 
			"pendaftaran_poli.setatus", 
			"pendaftaran_poli.email", 
			"pendaftaran_poli.alergi_obat", 
			"pendaftaran_poli.id_transaksi");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("pendaftaran_poli.id_pendaftaran_poli", $rec_id);; //select record based on primary key
		}
		$db->join("data_dokter", "pendaftaran_poli.dokter = data_dokter.id_dokter", "INNER");
		$db->join("data_bank", "pendaftaran_poli.pembayaran = data_bank.id_databank", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Pendaftaran Poli";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("pendaftaran_poli/view.php", $record);
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
			$fields = $this->fields = array("tanggal","tl","nama_pasien","alamat","no_ktp","nama_poli","dokter","pembayaran","setatus_bpjs","keluhan","no_hp","jenis_kelamin","tanggal_lahir","no_rekam_medis","email");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'no_ktp' => 'required|numeric',
				'nama_poli' => 'required',
				'dokter' => 'required',
				'pembayaran' => 'required',
				'setatus_bpjs' => 'required',
				'keluhan' => 'required',
				'no_hp' => 'numeric',
				'jenis_kelamin' => 'required',
				'tanggal_lahir' => 'required',
				'email' => 'valid_email',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'tl' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_ktp' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'dokter' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'setatus_bpjs' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'email' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
		# Statement to execute before adding record
		$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
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
$umurnya=hitung_umur($_POST['tanggal_lahir']);
$pembayaran     = $_POST['pembayaran'];
$setatus_bpjs   = $_POST['setatus_bpjs'];
$no_rekam_medis = $_POST['no_rekam_medis'];
$no_ktp         = $_POST['no_ktp'];
$nama_poli      = $_POST['nama_poli'];
      $quetrx= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrx = mysqli_num_rows($quetrx);
  if ($rotrx <> 0) {
              $dattrx = mysqli_fetch_assoc($quetrx);
              $no_invoice      = $dattrx['no_invoice'];  
              $this->set_flash_msg("Selesaikan dulu Tagihan Pasien Invoice-> $no_invoice", "warning");
              return  $this->redirect("transaksi?search=$no_invoice");
  }
if($no_rekam_medis==""){
     mysqli_query($koneksi,"INSERT INTO `data_pasien` (`no_ktp`,`nama_pasien`, `tanggal_lahir`, `no_hp`, `alamat`, `jenis_kelamin`, `umur`, `email`) VALUES ('".$_POST['no_ktp']."','".$_POST['nama_pasien']."', '".$_POST['tanggal_lahir']."', '".$_POST['no_hp']."', '".$_POST['alamat']."', '".$_POST['jenis_kelamin']."', '$umurnya', '$email')"); 
$csls = mysqli_query($koneksi,"select * from data_pasien where  no_ktp='$no_ktp'");
while ($rowsls=mysqli_fetch_array($csls )){
    $tracesid = trim($rowsls['id_pasien']);
}
$no_rekam_medis = "RMP$tracesid";
mysqli_query($koneksi,"UPDATE data_pasien SET no_rekam_medis='$no_rekam_medis' WHERE id_pasien='$tracesid'");
}
$sql = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$nama_poli'");
while ($row=mysqli_fetch_array($sql)){
    $quota_pasien = $row['quota_pasien'];
    $namapoli     = $row['nama_poli'];
}
 $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE no_rekam_medis='$no_rekam_medis' and tanggal='$sekarang' and nama_poli='$nama_poli'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rowsb = mysqli_num_rows($queryb);
  // cek hasil query
  // jika "no_antrian" sudah ada
  if ($rowsb <> 0) {
      $datab   = mysqli_fetch_assoc($queryb);
      $setatus = $datab['setatus'];
          if($setatus=="Closed" or $setatus=="Register" ){
          $this->set_flash_msg("Data Pasien Sudah Terdaftar ", "warning");
 return  $this->redirect("pendaftaran_poli");
  }else{ 
    $query = mysqli_query($koneksi, "SELECT max(no_antri_poli) as nomor from pendaftaran_poli WHERE nama_poli='$nama_poli' and tanggal='$sekarang'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rows = mysqli_num_rows($query);
  if ($rows <> 0) {
    $data       = mysqli_fetch_assoc($query);
    $no_antrian = $data['nomor'] + 1;
    if ($no_antrian > $quota_pasien){
    $this->set_flash_msg("Quota Pasien ($namapoli) Sudah Penuh ", "warning");
 return  $this->redirect("pendaftaran_poli");
    }else {
      $quetrx= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrx = mysqli_num_rows($quetrx);
  if ($rotrx <> 0) {
              $dattrx = mysqli_fetch_assoc($quetrx);
              $no_invoice      = $dattrx['no_invoice'];  
              $this->set_flash_msg("Selesaikan dulu Tagihan Pasien Invoice-> $no_invoice", "warning");
              return  $this->redirect("transaksi?search=$no_invoice");
  }
    }
  }else {}
}
        $this->set_flash_msg("Data Pasien Sudah Terdaftar ", "warning");
 return  $this->redirect("pendaftaran_poli");
  }else{
  }
		# End of before add statement
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
$sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
$pembayaran     = $_POST['pembayaran'];
$setatus_bpjs   = $_POST['setatus_bpjs'];
$no_rekam_medis = trim($_POST['no_rekam_medis']);
$no_ktp         = $_POST['no_ktp'];
$nama_poli      = $_POST['nama_poli'];
$tanggal        = $_POST['tanggal'];
$email          = $_POST['email'];
$tl             = $_POST['tl'];
$alamat         = $_POST['alamat'];
$nama_pasien    = $_POST['nama_pasien'];
if($no_rekam_medis==""){
$csls = mysqli_query($koneksi,"select * from data_pasien where  no_ktp='$no_ktp' and nama_pasien='$nama_pasien'");
while ($rowsls=mysqli_fetch_array($csls )){
    $no_rekam_medis = trim($rowsls['no_rekam_medis']);
}
}
 $quepol = mysqli_query($koneksi, "select * from data_poli WHERE id_poli='$nama_poli'")  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $ropol = mysqli_num_rows($quepol);
  if ($ropol<> 0) {
            $dapol = mysqli_fetch_assoc($quepol);
            $napol = $dapol['nama_poli'];
  }
$tgl = $tanggal;
 $jam = time_now(); 
 $querml = mysqli_query($koneksi, "select * from data_pasien WHERE no_rekam_medis='$no_rekam_medis'")  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rorml = mysqli_num_rows($querml);
  if ($rorml <> 0) {
      $dalm = mysqli_fetch_assoc($querml);
       $rmlm = $dalm['rm'];
  }
   mysqli_query($koneksi,"INSERT INTO `data_rm`(`nama_pasien`,`id_daftar`,`tanggal`, `jam`, `no_rekam_medis`, `rm_lama`,`pendaftaran_poli`,`setatus`) VALUES ('$nama_pasien','$rec_id','$tgl','$jam','$no_rekam_medis','$rmlm','POLI $napol','Register')");
  $query = mysqli_query($koneksi, "SELECT max(no_antri_poli) as nomor from pendaftaran_poli WHERE nama_poli='$nama_poli' and tanggal='$sekarang'")
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
    $db->rawQuery("UPDATE pendaftaran_poli SET setatus='Register', umur='$umurnya', no_antri_poli='$no_antrian' WHERE id_pendaftaran_poli='$rec_id'");
  }
  // jika "no_antrian" belum ada
  else {
    // "no_antrian" = 1
    $no_antrian = 1;
    $db->rawQuery("UPDATE pendaftaran_poli SET setatus='Register', umur='$umurnya', no_antri_poli='$no_antrian' WHERE id_pendaftaran_poli='$rec_id'");
  }
    mysqli_query($koneksi, "UPDATE data_pasien SET nama_pasien='$nama_pasien', tl='$tl', alamat='$alamat', umur='$umurnya', no_ktp='$no_ktp', email='$email' WHERE no_rekam_medis='$no_rekam_medis'");
$db->rawQuery("UPDATE pendaftaran_poli SET operator='".USER_ID."' WHERE id_pendaftaran_poli='$rec_id'");
 $quedp= mysqli_query($koneksi, "select * from data_poli WHERE id_poli='".$_POST['nama_poli']."'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rodp = mysqli_num_rows($quedp);
  if ($rodp <> 0) {
      $datdp    = mysqli_fetch_assoc($quedp);
      $namepoli = $datdp['nama_poli'];
  }
  $quetrx= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrx = mysqli_num_rows($quetrx);
  if ($rotrx <> 0) {
  }else{
  mysqli_query($koneksi,"INSERT INTO `transaksi` (`setatus_bpjs`,`pembayaran`, `no_rekam_medis`, `tanggal`, `nama_pasien`, `alamat`, `no_hp`,`pasien`,`poli`,`setatus_tagihan`,`transaksi`) VALUES ('".$_POST['setatus_bpjs']."','".$_POST['pembayaran']."', '$no_rekam_medis', '".$_POST['tanggal']."', '".$_POST['nama_pasien']."', '".$_POST['alamat']."', '".$_POST['no_hp']."', 'POLI', '$namepoli','Register','Rawat Jalan')"); 
  }
  $quetrxb= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrxb = mysqli_num_rows($quetrxb);
  if ($rotrxb <> 0) {
        $dattrxb    = mysqli_fetch_assoc($quetrxb);
        $idtrx      = $dattrxb['id'];  
        $no_invoice = "INVRJLN$idtrx";
       mysqli_query($koneksi, "UPDATE transaksi SET no_invoice='$no_invoice' WHERE id='$idtrx'"); 
  }
   $db->rawQuery("UPDATE pendaftaran_poli SET id_transaksi='$idtrx' WHERE id_pendaftaran_poli='$rec_id'");
  $queoner= mysqli_query($koneksi, "SELECT * FROM `data_owner`")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $roner = mysqli_num_rows($queoner);
  if ($roner <> 0) {
      $datoner         = mysqli_fetch_assoc($queoner);
      $hargapasienbaru = $datoner['harga_layanan_pasien_baru'];
       $hargapasienlama = $datoner['harga_layanan_pasien_lama'];
       $biaya_layanan=$datoner['biaya_layanan'];
       }else{
           $biaya_layanan = "";
       }
   if($biaya_layanan=="" or $biaya_layanan=="Tidak"){
   }else{
  $querm= mysqli_query($koneksi, "select * from rekam_medis WHERE no_rekam_medis='$no_rekam_medis'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rorm = mysqli_num_rows($querm);
  if ($rorm <> 0) {
      // $datdp    = mysqli_fetch_assoc($quedp);
      // $namepoli = $datdp['nama_poli'];
      $datapasien  = "Layanan Pasien Lama";
      $total_harga = $hargapasienbaru;
      }else{
         $querml= mysqli_query($koneksi, "select * from data_pasien WHERE no_rekam_medis='$no_rekam_medis'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rorml = mysqli_num_rows($querml);
  if ($rorml <> 0) {
      $dalm = mysqli_fetch_assoc($querml);
       $rmlm = $dalm['rm'];
  }
if($rmlm==""){
          $datapasien  = "Layanan Pasien Baru";
           $total_harga = $hargapasienbaru; 
          }else{
      $datapasien  = "Layanan Pasien Lama";
      $total_harga = $hargapasienlama;      
          }          
          // $datapasien  = "Layanan Pasien Baru";
          //$total_harga = $hargapasienlama;
      }    
$quetag = mysqli_query($koneksi, "select * from data_tagihan_pasien WHERE id_data='$rec_id'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotag = mysqli_num_rows($quetag);
  if ($rotag <> 0) {
      }else{ 
          mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES ('$idtrx','$rec_id','$datapasien','$tanggal','$no_rekam_medis','$total_harga','Register','POLI','$datapasien')");
  }
 mysqli_query($koneksi, "UPDATE transaksi SET total_tagihan='$total_harga' WHERE id='$idtrx'"); 
}
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("pendaftaran_poli");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Pendaftaran Poli";
		$this->render_view("pendaftaran_poli/add.php");
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
		$fields = $this->fields = array("id_pendaftaran_poli","tanggal","nama_pasien","alamat","no_ktp","nama_poli","dokter","pembayaran","setatus_bpjs","keluhan","no_hp","jenis_kelamin","tanggal_lahir","no_rekam_medis","setatus","email");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'no_ktp' => 'required|numeric',
				'nama_poli' => 'required',
				'dokter' => 'required',
				'pembayaran' => 'required',
				'setatus_bpjs' => 'required',
				'keluhan' => 'required',
				'no_hp' => 'numeric',
				'jenis_kelamin' => 'required',
				'tanggal_lahir' => 'required',
				'setatus' => 'required',
				'email' => 'valid_email',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_ktp' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'dokter' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'setatus_bpjs' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'email' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("pendaftaran_poli.id_pendaftaran_poli", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("pendaftaran_poli");
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
						return	$this->redirect("pendaftaran_poli");
					}
				}
			}
		}
		$db->where("pendaftaran_poli.id_pendaftaran_poli", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Pendaftaran Poli";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("pendaftaran_poli/edit.php", $data);
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
		$db->where("pendaftaran_poli.id_pendaftaran_poli", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("pendaftaran_poli");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function chekin($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id_pendaftaran_poli","pembayaran","setatus_bpjs","nama_poli","dokter","nama_pasien","no_rekam_medis","alamat","jenis_kelamin","setatus");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'pembayaran' => 'required',
				'setatus_bpjs' => 'required',
				'nama_poli' => 'required',
				'dokter' => 'required',
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'alamat' => 'required',
				'jenis_kelamin' => 'required',
				'setatus' => 'required',
			);
			$this->sanitize_array = array(
				'pembayaran' => 'sanitize_string',
				'setatus_bpjs' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'dokter' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'setatus' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("pendaftaran_poli.id_pendaftaran_poli", $rec_id);;
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
$setatus = $_POST['setatus'];
$queryc = mysqli_query($koneksi, "SELECT * from pendaftaran_poli WHERE id_pendaftaran_poli='$rec_id'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                  $rowsc = mysqli_num_rows($queryc);
                                  if ($rowsc <> 0) {
                                      $datac          = mysqli_fetch_assoc($queryc);
                                      $no_rekam_medis = $datac['no_rekam_medis'];
                                      $tanggal_lahir = $datac['tanggal_lahir'];
                                      $tglpesan      = $datac['tanggal'];
                                      $no_hp         = $datac['no_hp'];
                                      $nama_poli     = $datac['nama_poli'];
}
if($setatus=="Cancel"){
mysqli_query($koneksi, "UPDATE appointment SET setatus='$setatus', no_antri_poli='$no_antrian',operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."',setatus='".$_POST['setatus']."' WHERE id_pendaftaran_poli='$rec_id'");
}else{                            
 $quepol = mysqli_query($koneksi, "select * from data_poli WHERE id_poli='$nama_poli'")  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $ropol = mysqli_num_rows($quepol);
  if ($ropol<> 0) {
            $dapol = mysqli_fetch_assoc($quepol);
            $napol = $dapol['nama_poli'];
  }
$tgl = $tglpesan;
 $jam = time_now(); 
 $querml = mysqli_query($koneksi, "select * from data_pasien WHERE no_rekam_medis='$no_rekam_medis'")  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rorml = mysqli_num_rows($querml);
  if ($rorml <> 0) {
      $dalm = mysqli_fetch_assoc($querml);
       $rmlm = $dalm['rm'];
  }
   mysqli_query($koneksi,"INSERT INTO `data_rm`(`nama_pasien`,`id_daftar`,`tanggal`, `jam`, `no_rekam_medis`, `rm_lama`,`pendaftaran_poli`,`setatus`) VALUES ('$nama_pasien','$rec_id','$tgl','$jam','$no_rekam_medis','$rmlm','POLI $napol','Register')");                 
$sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
    $thn  = substr($tanggal_lahir, 0, 4);
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
  $rows = mysqli_num_rows($query);
  if ($rows <> 0) {
    $data       = mysqli_fetch_assoc($query);
    $no_antrian = $data['nomor'] + 1;
  }else {
    $no_antrian = 1;
  }
$db->rawQuery("UPDATE pendaftaran_poli SET no_antri_poli='$no_antrian',operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."',setatus='".$_POST['setatus']."' WHERE id_pendaftaran_poli='$rec_id'");
mysqli_query($koneksi, "UPDATE appointment SET setatus='$setatus', no_antri_poli='$no_antrian',operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."',setatus='".$_POST['setatus']."' WHERE id_pendaftaran_poli='$rec_id'");
////////////////////////////////////////////////////////////////////////////////////////////////////////
$quedp= mysqli_query($koneksi, "select * from data_poli WHERE id_poli='".$_POST['nama_poli']."'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rodp = mysqli_num_rows($quedp);
  if ($rodp <> 0) {
      $datdp    = mysqli_fetch_assoc($quedp);
      $namepoli = $datdp['nama_poli'];
  }
  $quetrx= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register' and poli='$namepoli'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrx = mysqli_num_rows($quetrx);
  if ($rotrx <> 0) {
  }else{
   mysqli_query($koneksi,"INSERT INTO `transaksi` (`setatus_bpjs`,`pembayaran`, `no_rekam_medis`, `tanggal`, `nama_pasien`, `alamat`, `no_hp`,`pasien`,`poli`,`setatus_tagihan`,`transaksi`) VALUES ('".$_POST['setatus_bpjs']."','".$_POST['pembayaran']."', '$no_rekam_medis', '$tglpesan', '".$_POST['nama_pasien']."', '".$_POST['alamat']."', '$no_hp', 'POLI', '$namepoli','Register','Rawat Jalan')"); 
  }
  $quetrxb= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register' and poli='$namepoli'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrxb = mysqli_num_rows($quetrxb);
  if ($rotrxb <> 0) {
        $dattrxb    = mysqli_fetch_assoc($quetrxb);
        $idtrx      = $dattrxb['id'];  
        $no_invoice = "INVRJLN$idtrx";
       mysqli_query($koneksi, "UPDATE transaksi SET no_invoice='$no_invoice' WHERE id='$idtrx'"); 
  }
  $queoner= mysqli_query($koneksi, "SELECT * FROM `data_owner`")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $roner = mysqli_num_rows($queoner);
  if ($roner <> 0) {
      $datoner         = mysqli_fetch_assoc($queoner);
      $hargapasienbaru = $datoner['harga_layanan_pasien_baru'];
       $hargapasienlama = $datoner['harga_layanan_pasien_lama'];
       $biaya_layanan=$datoner['biaya_layanan'];
       }else{
           $biaya_layanan = "";
       }
   if($biaya_layanan=="" or $biaya_layanan=="Tidak"){
   }else{
  $querm= mysqli_query($koneksi, "select * from rekam_medis WHERE no_rekam_medis='$no_rekam_medis'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rorm = mysqli_num_rows($querm);
  if ($rorm <> 0) {
      // $datdp    = mysqli_fetch_assoc($quedp);
      // $namepoli = $datdp['nama_poli'];
      $datapasien  = "Layanan Pasien Lama";
      $total_harga = $hargapasienbaru;
      }else{
          $datapasien  = "Layanan Pasien Baru";
          $total_harga = $hargapasienlama;
      }    
$quetag = mysqli_query($koneksi, "select * from data_tagihan_pasien WHERE id_data='$rec_id'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotag = mysqli_num_rows($quetag);
  if ($rotag <> 0) {
      }else{ 
          mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES ('$idtrx','$rec_id','$datapasien','".date("Y-m-d H:i:s")."','$no_rekam_medis','$total_harga','Register','POLI','$datapasien')");
  }
}
$queryjum = mysqli_query($koneksi, "SELECT SUM(total_tagihan) AS tot from data_tagihan_pasien WHERE id_transaksi='$idtrx'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$sumjum = mysqli_fetch_assoc($queryjum); 
$tottag = $sumjum['tot'];  
 mysqli_query($koneksi, "UPDATE transaksi SET total_tagihan='$tottag' WHERE id='$idtrx'"); 
}
$db->rawQuery("UPDATE pendaftaran_poli SET id_transaksi='$idtrx' WHERE id_pendaftaran_poli='$rec_id'");
$this->set_flash_msg("Data Berhasil Di Updated", "success");
 return  $this->redirect("pendaftaran_poli");
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("pendaftaran_poli");
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
						return	$this->redirect("pendaftaran_poli");
					}
				}
			}
		}
		$db->where("pendaftaran_poli.id_pendaftaran_poli", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Pendaftaran Poli";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("pendaftaran_poli/chekin.php", $data);
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function verified($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id_pendaftaran_poli","nama_pasien","no_rekam_medis","alamat","jenis_kelamin","tanggal_lahir","umur","tanggal","tinggi","berat_badan","tensi","suhu_badan","alergi_obat");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_pasien' => 'required',
				'no_rekam_medis' => 'required',
				'alamat' => 'required',
				'jenis_kelamin' => 'required',
				'tanggal_lahir' => 'required',
				'umur' => 'required',
				'tanggal' => 'required',
				'tinggi' => 'required',
				'berat_badan' => 'required',
				'tensi' => 'required',
				'suhu_badan' => 'required',
			);
			$this->sanitize_array = array(
				'nama_pasien' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'tinggi' => 'sanitize_string',
				'berat_badan' => 'sanitize_string',
				'tensi' => 'sanitize_string',
				'suhu_badan' => 'sanitize_string',
				'alergi_obat' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("pendaftaran_poli.id_pendaftaran_poli", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("pendaftaran_poli");
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
						return	$this->redirect("pendaftaran_poli");
					}
				}
			}
		}
		$db->where("pendaftaran_poli.id_pendaftaran_poli", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Pendaftaran Poli";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("pendaftaran_poli/verified.php", $data);
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function poli($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id_pendaftaran_poli", 
			"id_appointment", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_pasien", 
			"jenis_kelamin", 
			"tanggal_lahir", 
			"alamat", 
			"umur", 
			"id_transaksi");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("pendaftaran_poli.id_pendaftaran_poli", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Pendaftaran Poli";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("pendaftaran_poli/poli.php", $record);
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function dokter($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id_pendaftaran_poli", 
			"id_appointment", 
			"pembayaran", 
			"setatus_bpjs", 
			"nama_poli", 
			"keluhan", 
			"no_antri_poli", 
			"dokter", 
			"nama_pasien", 
			"no_rekam_medis", 
			"no_hp", 
			"alamat", 
			"jenis_kelamin", 
			"tanggal_lahir", 
			"umur", 
			"setatus", 
			"tanggal", 
			"email", 
			"action", 
			"lab", 
			"operator", 
			"date_created", 
			"date_updated", 
			"penanggung_jawab", 
			"identitas_penanggung_jawab", 
			"tinggi", 
			"berat_badan", 
			"tensi", 
			"suhu_badan", 
			"no_ktp", 
			"tindakan", 
			"alergi_obat", 
			"resep_obat", 
			"catatan_medis", 
			"tl", 
			"id_transaksi", 
			"pemeriksaan_fisik", 
			"rekam_medis");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				pendaftaran_poli.id_pendaftaran_poli LIKE ? OR 
				pendaftaran_poli.id_appointment LIKE ? OR 
				pendaftaran_poli.pembayaran LIKE ? OR 
				pendaftaran_poli.setatus_bpjs LIKE ? OR 
				pendaftaran_poli.nama_poli LIKE ? OR 
				pendaftaran_poli.keluhan LIKE ? OR 
				pendaftaran_poli.no_antri_poli LIKE ? OR 
				pendaftaran_poli.dokter LIKE ? OR 
				pendaftaran_poli.nama_pasien LIKE ? OR 
				pendaftaran_poli.no_rekam_medis LIKE ? OR 
				pendaftaran_poli.no_hp LIKE ? OR 
				pendaftaran_poli.alamat LIKE ? OR 
				pendaftaran_poli.jenis_kelamin LIKE ? OR 
				pendaftaran_poli.tanggal_lahir LIKE ? OR 
				pendaftaran_poli.umur LIKE ? OR 
				pendaftaran_poli.setatus LIKE ? OR 
				pendaftaran_poli.tanggal LIKE ? OR 
				pendaftaran_poli.email LIKE ? OR 
				pendaftaran_poli.action LIKE ? OR 
				pendaftaran_poli.lab LIKE ? OR 
				pendaftaran_poli.operator LIKE ? OR 
				pendaftaran_poli.date_created LIKE ? OR 
				pendaftaran_poli.date_updated LIKE ? OR 
				pendaftaran_poli.penanggung_jawab LIKE ? OR 
				pendaftaran_poli.identitas_penanggung_jawab LIKE ? OR 
				pendaftaran_poli.tinggi LIKE ? OR 
				pendaftaran_poli.berat_badan LIKE ? OR 
				pendaftaran_poli.tensi LIKE ? OR 
				pendaftaran_poli.suhu_badan LIKE ? OR 
				pendaftaran_poli.no_ktp LIKE ? OR 
				pendaftaran_poli.tindakan LIKE ? OR 
				pendaftaran_poli.alergi_obat LIKE ? OR 
				pendaftaran_poli.resep_obat LIKE ? OR 
				pendaftaran_poli.catatan_medis LIKE ? OR 
				pendaftaran_poli.tl LIKE ? OR 
				pendaftaran_poli.id_transaksi LIKE ? OR 
				pendaftaran_poli.pemeriksaan_fisik LIKE ? OR 
				pendaftaran_poli.rekam_medis LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "pendaftaran_poli/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("pendaftaran_poli.id_pendaftaran_poli", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Pendaftaran Poli";
		$this->render_view("pendaftaran_poli/dokter.php", $data); //render the full page
	}
}
