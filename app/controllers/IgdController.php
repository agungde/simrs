<?php 
/**
 * Igd Page Controller
 * @category  Controller
 */
class IgdController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "igd";
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
		$fields = array("igd.id_igd", 
			"igd.tanggal_masuk", 
			"igd.no_rekam_medis", 
			"igd.nama_pasien", 
			"igd.tl", 
			"igd.tanggal_lahir", 
			"igd.umur", 
			"igd.jenis_kelamin", 
			"igd.alamat", 
			"igd.dokter", 
			"data_dokter.nama_dokter AS data_dokter_nama_dokter", 
			"igd.assesment_triase", 
			"igd.pemeriksaan_fisik", 
			"igd.catatan_medis", 
			"igd.tindakan", 
			"igd.lab", 
			"igd.resep_obat", 
			"igd.rekam_medis", 
			"igd.assesment_medis", 
			"igd.action", 
			"igd.rawat_inap", 
			"igd.pembayaran", 
			"data_bank.nama_bank AS data_bank_nama_bank", 
			"igd.setatus_bpjs", 
			"igd.setatus", 
			"igd.tanggal_keluar");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(!empty($request->igd_setatus)){
    $set = $request->igd_setatus;
    if(!empty($request->igd_tanggal)){
        $val = $request->igd_tanggal;
    $db->where("setatus='$set' and DATE(igd.tanggal_masuk)", $val , "=");
    }else{
        $db->where("setatus='$set'");
    }
    // $db->where("setatus_tagihan='$set' and DATE(transaksi.tanggal)", $val , "=");
        }
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				igd.id_igd LIKE ? OR 
				igd.tanggal_masuk LIKE ? OR 
				igd.no_rekam_medis LIKE ? OR 
				igd.nama_pasien LIKE ? OR 
				igd.tl LIKE ? OR 
				igd.tanggal_lahir LIKE ? OR 
				igd.umur LIKE ? OR 
				igd.jenis_kelamin LIKE ? OR 
				igd.alamat LIKE ? OR 
				igd.dokter LIKE ? OR 
				igd.assesment_triase LIKE ? OR 
				igd.pemeriksaan_fisik LIKE ? OR 
				igd.catatan_medis LIKE ? OR 
				igd.tindakan LIKE ? OR 
				igd.lab LIKE ? OR 
				igd.resep_obat LIKE ? OR 
				igd.rekam_medis LIKE ? OR 
				igd.assesment_medis LIKE ? OR 
				igd.action LIKE ? OR 
				igd.rawat_inap LIKE ? OR 
				igd.no_hp LIKE ? OR 
				igd.email LIKE ? OR 
				igd.pembayaran LIKE ? OR 
				igd.penanggung_jawab LIKE ? OR 
				igd.id_penanggung_jawab LIKE ? OR 
				igd.alamat_penanggung_jawab LIKE ? OR 
				igd.no_hp_penanggung_jawab LIKE ? OR 
				igd.hubungan LIKE ? OR 
				igd.setatus_bpjs LIKE ? OR 
				igd.back_link LIKE ? OR 
				igd.setatus LIKE ? OR 
				igd.tanggal_keluar LIKE ? OR 
				igd.operator LIKE ? OR 
				igd.date_created LIKE ? OR 
				igd.date_updated LIKE ? OR 
				igd.pasien LIKE ? OR 
				igd.no_ktp LIKE ? OR 
				igd.id_transaksi LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "igd/search.php";
		}
		$db->join("data_dokter", "igd.dokter = data_dokter.id_dokter", "INNER");
		$db->join("data_bank", "igd.pembayaran = data_bank.id_databank", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("igd.id_igd", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Igd";
		$view_name = (is_ajax() ? "igd/ajax-list.php" : "igd/list.php");
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
		$fields = array("igd.id_igd", 
			"igd.tanggal_masuk", 
			"igd.no_rekam_medis", 
			"igd.nama_pasien", 
			"igd.alamat", 
			"igd.dokter", 
			"data_dokter.nama_dokter AS data_dokter_nama_dokter", 
			"igd.tanggal_lahir", 
			"igd.jenis_kelamin", 
			"igd.umur", 
			"igd.no_hp", 
			"igd.email", 
			"igd.pembayaran", 
			"data_bank.nama_bank AS data_bank_nama_bank", 
			"igd.penanggung_jawab", 
			"igd.id_penanggung_jawab", 
			"igd.alamat_penanggung_jawab", 
			"igd.no_hp_penanggung_jawab", 
			"igd.hubungan", 
			"igd.rawat_inap", 
			"igd.setatus_bpjs", 
			"igd.setatus", 
			"igd.tanggal_keluar");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("igd.id_igd", $rec_id);; //select record based on primary key
		}
		$db->join("data_dokter", "igd.dokter = data_dokter.id_dokter", "INNER");
		$db->join("data_bank", "igd.pembayaran = data_bank.id_databank", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Igd";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("igd/view.php", $record);
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
			$fields = $this->fields = array("tanggal_masuk","tl","nama_pasien","no_ktp","alamat","tanggal_lahir","jenis_kelamin","no_hp","email","pembayaran","setatus_bpjs","dokter","penanggung_jawab","id_penanggung_jawab","alamat_penanggung_jawab","no_hp_penanggung_jawab","hubungan","rawat_inap","back_link","no_rekam_medis","pasien");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal_masuk' => 'required',
				'nama_pasien' => 'required',
				'no_ktp' => 'required|numeric|min_numeric,16',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'jenis_kelamin' => 'required',
				'email' => 'valid_email',
				'pembayaran' => 'required',
				'setatus_bpjs' => 'required',
				'dokter' => 'required',
				'penanggung_jawab' => 'required',
				'id_penanggung_jawab' => 'required',
				'alamat_penanggung_jawab' => 'required',
				'no_hp_penanggung_jawab' => 'required',
				'hubungan' => 'required',
				'back_link' => 'required',
				'pasien' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal_masuk' => 'sanitize_string',
				'tl' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_ktp' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'email' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'setatus_bpjs' => 'sanitize_string',
				'dokter' => 'sanitize_string',
				'penanggung_jawab' => 'sanitize_string',
				'id_penanggung_jawab' => 'sanitize_string',
				'alamat_penanggung_jawab' => 'sanitize_string',
				'no_hp_penanggung_jawab' => 'sanitize_string',
				'hubungan' => 'sanitize_string',
				'rawat_inap' => 'sanitize_string',
				'back_link' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'pasien' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$usrnam       = "".USER_NAME;
$id_user      = "".USER_ID;
$dbhost       = "".DB_HOST;
$dbuser       = "".DB_USERNAME;
$dbpass       = "".DB_PASSWORD;
$dbname       = "".DB_NAME;
$koneksi      = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace      = "$id_user$usrnam";
$tanggallahir = $_POST['tanggal_lahir'];
$sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
    $thn  = substr($tanggallahir, 0, 4);
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
$umurnya = hitung_umur("$tanggallahir");
$pembayaran     = $_POST['pembayaran'];
$setatus_bpjs   = $_POST['setatus_bpjs'];
$pasien         = $_POST['pasien'];
$cekinap = $_POST['rawat_inap']; 
$no_ktp         = $_POST['no_ktp'];
$no_rekam_medis = $_POST['no_rekam_medis'];
$email          = $_POST['email'];
if($no_rekam_medis==""){
     mysqli_query($koneksi,"INSERT INTO `data_pasien` (`no_ktp`,`nama_pasien`, `tanggal_lahir`, `no_hp`, `alamat`, `jenis_kelamin`, `umur`, `email`) VALUES ('".$_POST['no_ktp']."','".$_POST['nama_pasien']."', '".$_POST['tanggal_lahir']."', '".$_POST['no_hp']."', '".$_POST['alamat']."', '".$_POST['jenis_kelamin']."', '$umurnya', '$email')"); 
$csls = mysqli_query($koneksi,"select * from data_pasien where  no_ktp='$no_ktp'");
while ($rowsls=mysqli_fetch_array($csls )){
    $tracesid = trim($rowsls['id_pasien']);
}
$no_rekam_medis = "RMP$tracesid";
mysqli_query($koneksi,"UPDATE data_pasien SET no_rekam_medis='$no_rekam_medis' WHERE id_pasien='$tracesid'");
$db->rawQuery("UPDATE igd SET umur='$umurnya', no_rekam_medis='$no_rekam_medis' WHERE id_igd='$rec_id'");
}
if($cekinap==""){
$cekinap = "None";
}
$email          = $_POST['email'];
$tl             = $_POST['tl'];
$alamat         = $_POST['alamat'];
$nama_pasien    = $_POST['nama_pasien'];
mysqli_query($koneksi, "UPDATE data_pasien SET nama_pasien='$nama_pasien', tl='$tl', alamat='$alamat', umur='$umurnya', no_ktp='$no_ktp', email='$email' WHERE no_rekam_medis='$no_rekam_medis'");
//mysqli_query($koneksi,"UPDATE data_pasien SET umur='$umurnya' WHERE no_rekam_medis='$no_rekam_medis'");
$db->rawQuery("UPDATE igd SET umur='$umurnya', setatus='Register', rawat_inap='$cekinap', operator='".USER_ID."' WHERE id_igd='$rec_id'");
////////////////////////////////////////////////Tagihan//////////////////////////////
$namepoli = "IGD";
 $quetrx= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register' and poli='$namepoli'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrx = mysqli_num_rows($quetrx);
  if ($rotrx <> 0) {
  }else{
      mysqli_query($koneksi,"INSERT INTO `transaksi` (`setatus_bpjs`,`pembayaran`, `no_rekam_medis`, `tanggal`, `nama_pasien`, `alamat`, `no_hp`,`pasien`,`poli`,`setatus_tagihan`,`transaksi`) VALUES ('".$_POST['setatus_bpjs']."','".$_POST['pembayaran']."', '$no_rekam_medis', '".$_POST['tanggal_masuk']."', '".$_POST['nama_pasien']."', '".$_POST['alamat']."', '".$_POST['no_hp']."', '$namepoli', '$namepoli','Register','IGD')"); 
  }
  $quetrxb= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register' and poli='$namepoli'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrxb = mysqli_num_rows($quetrxb);
  if ($rotrxb <> 0) {
        $dattrxb    = mysqli_fetch_assoc($quetrxb);
        $idtrx      = $dattrxb['id'];  
        $no_invoice = "INVIGD$idtrx";
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
      $total_harga = $hargapasienlama;
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
      }    
$quetag = mysqli_query($koneksi, "select * from data_tagihan_pasien WHERE id_data='$rec_id'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotag = mysqli_num_rows($quetag);
  if ($rotag <> 0) {
      }else{ 
          mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES ('$idtrx','$rec_id','$datapasien','".date("Y-m-d H:i:s")."','$no_rekam_medis','$total_harga','Register','IGD','$datapasien')");
  }
}
$queryjum = mysqli_query($koneksi, "SELECT SUM(total_tagihan) AS tot from data_tagihan_pasien WHERE id_transaksi='$idtrx'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$sumjum = mysqli_fetch_assoc($queryjum); 
$tottag = $sumjum['tot'];  
 mysqli_query($koneksi, "UPDATE transaksi SET total_tagihan='$tottag' WHERE id='$idtrx'"); 
 $tgl = $_POST['tanggal_masuk'];
 $jam = $tgl;
 $querml = mysqli_query($koneksi, "select * from data_pasien WHERE no_rekam_medis='$no_rekam_medis'")  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rorml = mysqli_num_rows($querml);
  if ($rorml <> 0) {
      $dalm = mysqli_fetch_assoc($querml);
       $rmlm = $dalm['rm'];
  }
   mysqli_query($koneksi,"INSERT INTO `data_rm`(`nama_pasien`,`id_daftar`,`tanggal`, `jam`, `no_rekam_medis`, `rm_lama`,`igd`,`setatus`) VALUES ('$nama_pasien','$rec_id','$tgl','$jam','$no_rekam_medis','$rmlm','IGD','Register')");
 $db->rawQuery("UPDATE igd SET id_transaksi='$idtrx' WHERE id_igd='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("igd");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Igd";
		$this->render_view("igd/add.php");
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
		$fields = $this->fields = array("id_igd","tl","nama_pasien","no_ktp","alamat","tanggal_lahir","jenis_kelamin","no_hp","email","pembayaran","setatus_bpjs","dokter","penanggung_jawab","id_penanggung_jawab","alamat_penanggung_jawab","no_hp_penanggung_jawab","hubungan","rawat_inap","back_link","no_rekam_medis","pasien");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_pasien' => 'required',
				'no_ktp' => 'required|numeric|min_numeric,16',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'jenis_kelamin' => 'required',
				'email' => 'valid_email',
				'pembayaran' => 'required',
				'setatus_bpjs' => 'required',
				'dokter' => 'required',
				'penanggung_jawab' => 'required',
				'id_penanggung_jawab' => 'required',
				'alamat_penanggung_jawab' => 'required',
				'no_hp_penanggung_jawab' => 'required',
				'hubungan' => 'required',
				'back_link' => 'required',
				'pasien' => 'required',
			);
			$this->sanitize_array = array(
				'tl' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'no_ktp' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'email' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'setatus_bpjs' => 'sanitize_string',
				'dokter' => 'sanitize_string',
				'penanggung_jawab' => 'sanitize_string',
				'id_penanggung_jawab' => 'sanitize_string',
				'alamat_penanggung_jawab' => 'sanitize_string',
				'no_hp_penanggung_jawab' => 'sanitize_string',
				'hubungan' => 'sanitize_string',
				'rawat_inap' => 'sanitize_string',
				'back_link' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'pasien' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("igd.id_igd", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("igd");
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
						return	$this->redirect("igd");
					}
				}
			}
		}
		$db->where("igd.id_igd", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Igd";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("igd/edit.php", $data);
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function tindakan($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id_igd", 
			"nama_pasien", 
			"alamat", 
			"tanggal_lahir", 
			"umur", 
			"no_hp", 
			"penanggung_jawab", 
			"id_penanggung_jawab", 
			"alamat_penanggung_jawab", 
			"no_hp_penanggung_jawab", 
			"hubungan", 
			"jenis_kelamin", 
			"email", 
			"pembayaran", 
			"setatus_bpjs", 
			"rawat_inap", 
			"back_link", 
			"tanggal_masuk", 
			"no_rekam_medis", 
			"action", 
			"setatus", 
			"dokter", 
			"tindakan", 
			"operator", 
			"date_created", 
			"date_updated", 
			"pasien", 
			"no_ktp", 
			"tanggal_keluar", 
			"id_transaksi", 
			"resep_obat", 
			"lab", 
			"catatan_medis", 
			"tl", 
			"assesment_triase", 
			"assesment_medis", 
			"pemeriksaan_fisik", 
			"rekam_medis");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				igd.id_igd LIKE ? OR 
				igd.nama_pasien LIKE ? OR 
				igd.alamat LIKE ? OR 
				igd.tanggal_lahir LIKE ? OR 
				igd.umur LIKE ? OR 
				igd.no_hp LIKE ? OR 
				igd.penanggung_jawab LIKE ? OR 
				igd.id_penanggung_jawab LIKE ? OR 
				igd.alamat_penanggung_jawab LIKE ? OR 
				igd.no_hp_penanggung_jawab LIKE ? OR 
				igd.hubungan LIKE ? OR 
				igd.jenis_kelamin LIKE ? OR 
				igd.email LIKE ? OR 
				igd.pembayaran LIKE ? OR 
				igd.setatus_bpjs LIKE ? OR 
				igd.rawat_inap LIKE ? OR 
				igd.back_link LIKE ? OR 
				igd.tanggal_masuk LIKE ? OR 
				igd.no_rekam_medis LIKE ? OR 
				igd.action LIKE ? OR 
				igd.setatus LIKE ? OR 
				igd.dokter LIKE ? OR 
				igd.tindakan LIKE ? OR 
				igd.operator LIKE ? OR 
				igd.date_created LIKE ? OR 
				igd.date_updated LIKE ? OR 
				igd.pasien LIKE ? OR 
				igd.no_ktp LIKE ? OR 
				igd.tanggal_keluar LIKE ? OR 
				igd.id_transaksi LIKE ? OR 
				igd.resep_obat LIKE ? OR 
				igd.lab LIKE ? OR 
				igd.catatan_medis LIKE ? OR 
				igd.tl LIKE ? OR 
				igd.assesment_triase LIKE ? OR 
				igd.assesment_medis LIKE ? OR 
				igd.pemeriksaan_fisik LIKE ? OR 
				igd.rekam_medis LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "igd/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("igd.id_igd", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Igd";
		$view_name = (is_ajax() ? "igd/ajax-tindakan.php" : "igd/tindakan.php");
		$this->render_view($view_name, $data);
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
		$fields = array("id_igd", 
			"nama_pasien", 
			"alamat", 
			"tanggal_lahir", 
			"umur", 
			"no_hp", 
			"penanggung_jawab", 
			"id_penanggung_jawab", 
			"alamat_penanggung_jawab", 
			"no_hp_penanggung_jawab", 
			"hubungan", 
			"jenis_kelamin", 
			"email", 
			"pembayaran", 
			"setatus_bpjs", 
			"rawat_inap", 
			"back_link", 
			"tanggal_masuk", 
			"no_rekam_medis", 
			"action", 
			"setatus", 
			"dokter", 
			"tindakan", 
			"operator", 
			"date_created", 
			"date_updated", 
			"pasien", 
			"no_ktp", 
			"tanggal_keluar", 
			"id_transaksi", 
			"resep_obat", 
			"lab", 
			"catatan_medis", 
			"tl", 
			"assesment_triase", 
			"assesment_medis", 
			"pemeriksaan_fisik", 
			"rekam_medis");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				igd.id_igd LIKE ? OR 
				igd.nama_pasien LIKE ? OR 
				igd.alamat LIKE ? OR 
				igd.tanggal_lahir LIKE ? OR 
				igd.umur LIKE ? OR 
				igd.no_hp LIKE ? OR 
				igd.penanggung_jawab LIKE ? OR 
				igd.id_penanggung_jawab LIKE ? OR 
				igd.alamat_penanggung_jawab LIKE ? OR 
				igd.no_hp_penanggung_jawab LIKE ? OR 
				igd.hubungan LIKE ? OR 
				igd.jenis_kelamin LIKE ? OR 
				igd.email LIKE ? OR 
				igd.pembayaran LIKE ? OR 
				igd.setatus_bpjs LIKE ? OR 
				igd.rawat_inap LIKE ? OR 
				igd.back_link LIKE ? OR 
				igd.tanggal_masuk LIKE ? OR 
				igd.no_rekam_medis LIKE ? OR 
				igd.action LIKE ? OR 
				igd.setatus LIKE ? OR 
				igd.dokter LIKE ? OR 
				igd.tindakan LIKE ? OR 
				igd.operator LIKE ? OR 
				igd.date_created LIKE ? OR 
				igd.date_updated LIKE ? OR 
				igd.pasien LIKE ? OR 
				igd.no_ktp LIKE ? OR 
				igd.tanggal_keluar LIKE ? OR 
				igd.id_transaksi LIKE ? OR 
				igd.resep_obat LIKE ? OR 
				igd.lab LIKE ? OR 
				igd.catatan_medis LIKE ? OR 
				igd.tl LIKE ? OR 
				igd.assesment_triase LIKE ? OR 
				igd.assesment_medis LIKE ? OR 
				igd.pemeriksaan_fisik LIKE ? OR 
				igd.rekam_medis LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "igd/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("igd.id_igd", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Igd";
		$view_name = (is_ajax() ? "igd/ajax-operasi.php" : "igd/operasi.php");
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
			$fields = $this->fields = array("nama_pasien","alamat","tanggal_lahir","umur","no_hp","penanggung_jawab","id_penanggung_jawab","alamat_penanggung_jawab","no_hp_penanggung_jawab","hubungan","jenis_kelamin","email","pembayaran","setatus_bpjs","rawat_inap","back_link","tanggal_masuk","no_rekam_medis","action","setatus","dokter","tindakan","operator","date_created","date_updated","pasien","no_ktp","tanggal_keluar","id_transaksi","resep_obat","lab","catatan_medis","tl","assesment_triase","assesment_medis","pemeriksaan_fisik","rekam_medis");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'umur' => 'required',
				'no_hp' => 'required',
				'penanggung_jawab' => 'required',
				'id_penanggung_jawab' => 'required',
				'alamat_penanggung_jawab' => 'required',
				'no_hp_penanggung_jawab' => 'required',
				'hubungan' => 'required',
				'jenis_kelamin' => 'required',
				'email' => 'required|valid_email',
				'pembayaran' => 'required|numeric',
				'setatus_bpjs' => 'required',
				'rawat_inap' => 'required',
				'back_link' => 'required',
				'tanggal_masuk' => 'required',
				'no_rekam_medis' => 'required',
				'action' => 'required',
				'setatus' => 'required',
				'dokter' => 'required|numeric',
				'tindakan' => 'required',
				'operator' => 'required|numeric',
				'date_created' => 'required',
				'date_updated' => 'required',
				'pasien' => 'required',
				'no_ktp' => 'required|numeric',
				'tanggal_keluar' => 'required',
				'id_transaksi' => 'required|numeric',
				'resep_obat' => 'required',
				'lab' => 'required',
				'catatan_medis' => 'required',
				'tl' => 'required',
				'assesment_triase' => 'required',
				'assesment_medis' => 'required',
				'pemeriksaan_fisik' => 'required',
				'rekam_medis' => 'required',
			);
			$this->sanitize_array = array(
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'penanggung_jawab' => 'sanitize_string',
				'id_penanggung_jawab' => 'sanitize_string',
				'alamat_penanggung_jawab' => 'sanitize_string',
				'no_hp_penanggung_jawab' => 'sanitize_string',
				'hubungan' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'email' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'setatus_bpjs' => 'sanitize_string',
				'rawat_inap' => 'sanitize_string',
				'back_link' => 'sanitize_string',
				'tanggal_masuk' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'action' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'dokter' => 'sanitize_string',
				'tindakan' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'date_created' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'no_ktp' => 'sanitize_string',
				'tanggal_keluar' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
				'resep_obat' => 'sanitize_string',
				'lab' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
				'tl' => 'sanitize_string',
				'assesment_triase' => 'sanitize_string',
				'assesment_medis' => 'sanitize_string',
				'pemeriksaan_fisik' => 'sanitize_string',
				'rekam_medis' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("igd");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Igd";
		$this->render_view("igd/resep.php");
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
		$fields = array("id_igd", 
			"tanggal_masuk", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"tanggal_lahir", 
			"pasien");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("igd.id_igd", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Igd";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("igd/triase.php", $record);
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function opname($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("igd.id_igd", 
			"igd.tanggal_masuk", 
			"igd.no_rekam_medis", 
			"igd.nama_pasien", 
			"igd.alamat", 
			"igd.tanggal_lahir", 
			"igd.dokter", 
			"data_dokter.nama_dokter AS data_dokter_nama_dokter");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("igd.id_igd", $rec_id);; //select record based on primary key
		}
		$db->join("data_dokter", "igd.dokter = data_dokter.id_dokter", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Igd";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("igd/opname.php", $record);
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
		$fields = $this->fields = array("id_igd","nama_pasien","alamat","tanggal_lahir","umur","no_hp","penanggung_jawab","id_penanggung_jawab","alamat_penanggung_jawab","no_hp_penanggung_jawab","hubungan","jenis_kelamin","email","pembayaran","setatus_bpjs","tanggal_masuk","no_rekam_medis","dokter","no_ktp","tl");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'tanggal_lahir' => 'required',
				'umur' => 'required',
				'no_hp' => 'required',
				'penanggung_jawab' => 'required',
				'id_penanggung_jawab' => 'required',
				'alamat_penanggung_jawab' => 'required',
				'no_hp_penanggung_jawab' => 'required',
				'hubungan' => 'required',
				'jenis_kelamin' => 'required',
				'email' => 'required|valid_email',
				'pembayaran' => 'required',
				'setatus_bpjs' => 'required',
				'tanggal_masuk' => 'required',
				'no_rekam_medis' => 'required',
				'dokter' => 'required',
				'no_ktp' => 'required|numeric',
				'tl' => 'required',
			);
			$this->sanitize_array = array(
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'tanggal_lahir' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'penanggung_jawab' => 'sanitize_string',
				'id_penanggung_jawab' => 'sanitize_string',
				'alamat_penanggung_jawab' => 'sanitize_string',
				'no_hp_penanggung_jawab' => 'sanitize_string',
				'hubungan' => 'sanitize_string',
				'jenis_kelamin' => 'sanitize_string',
				'email' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'setatus_bpjs' => 'sanitize_string',
				'tanggal_masuk' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'dokter' => 'sanitize_string',
				'no_ktp' => 'sanitize_string',
				'tl' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("igd.id_igd", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			$usrnam       = "".USER_NAME;
$id_user      = "".USER_ID;
$dbhost       = "".DB_HOST;
$dbuser       = "".DB_USERNAME;
$dbpass       = "".DB_PASSWORD;
$dbname       = "".DB_NAME;
$koneksi      = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace      = "$id_user$usrnam";
//$tanggallahir = $_POST['tanggal_lahir'];
$no_rekam_medis=$_POST['no_rekam_medis'];
$namepoli = "IGD";
 $quetrx= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register' and poli='$namepoli'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrx = mysqli_num_rows($quetrx);
  if ($rotrx <> 0) {
  }else{
      mysqli_query($koneksi,"INSERT INTO `transaksi` (`setatus_bpjs`,`pembayaran`, `no_rekam_medis`, `tanggal`, `nama_pasien`, `alamat`, `no_hp`,`pasien`,`poli`,`setatus_tagihan`,`transaksi`) VALUES ('".$_POST['setatus_bpjs']."','".$_POST['pembayaran']."', '$no_rekam_medis', '".$_POST['tanggal_masuk']."', '".$_POST['nama_pasien']."', '".$_POST['alamat']."', '".$_POST['no_hp']."', '$namepoli', '$namepoli','Register','IGD')"); 
  }
  $quetrxb= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register' and poli='$namepoli'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrxb = mysqli_num_rows($quetrxb);
  if ($rotrxb <> 0) {
        $dattrxb    = mysqli_fetch_assoc($quetrxb);
        $idtrx      = $dattrxb['id'];  
        $no_invoice = "INVIGD$idtrx";
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
      $total_harga = $hargapasienlama;
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
      }    
$quetag = mysqli_query($koneksi, "select * from data_tagihan_pasien WHERE id_data='$rec_id'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotag = mysqli_num_rows($quetag);
  if ($rotag <> 0) {
      }else{ 
          mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES ('$idtrx','$rec_id','$datapasien','".date("Y-m-d H:i:s")."','$no_rekam_medis','$total_harga','Register','IGD','$datapasien')");
  }
}
$queryjum = mysqli_query($koneksi, "SELECT SUM(total_tagihan) AS tot from data_tagihan_pasien WHERE id_transaksi='$idtrx'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$sumjum = mysqli_fetch_assoc($queryjum); 
$tottag = $sumjum['tot'];  
 mysqli_query($koneksi, "UPDATE transaksi SET total_tagihan='$tottag' WHERE id='$idtrx'"); 
 $tgl = $_POST['tanggal_masuk'];
 $jam = $tgl;
 $querml = mysqli_query($koneksi, "select * from data_pasien WHERE no_rekam_medis='$no_rekam_medis'")  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rorml = mysqli_num_rows($querml);
  if ($rorml <> 0) {
      $dalm = mysqli_fetch_assoc($querml);
       $rmlm = $dalm['rm'];
  }
   mysqli_query($koneksi,"INSERT INTO `data_rm`(`nama_pasien`,`id_daftar`,`tanggal`, `jam`, `no_rekam_medis`, `rm_lama`,`igd`,`setatus`) VALUES ('$nama_pasien','$rec_id','$tgl','$jam','$no_rekam_medis','$rmlm','IGD','Register')");
   $db->rawQuery("UPDATE igd SET id_transaksi='$idtrx', setatus='Register', pasien='IGD' WHERE id_igd='$rec_id'");  
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("igd");
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
						return	$this->redirect("igd");
					}
				}
			}
		}
		$db->where("igd.id_igd", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Igd";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("igd/chekin.php", $data);
	}
}
