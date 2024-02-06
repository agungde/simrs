<?php 
/**
 * Data_rekam_medis Page Controller
 * @category  Controller
 */
class Data_rekam_medisController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_rekam_medis";
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
		$fields = array("data_rekam_medis.id", 
			"data_rekam_medis.id_daftar", 
			"data_rekam_medis.tanggal", 
			"data_rekam_medis.no_rekam_medis", 
			"data_rekam_medis.nama_poli", 
			"data_poli.nama_poli AS data_poli_nama_poli", 
			"data_rekam_medis.dokter_pemeriksa", 
			"data_rekam_medis.pasien", 
			"data_rekam_medis.tinggi", 
			"data_rekam_medis.berat_badan", 
			"data_rekam_medis.tensi", 
			"data_rekam_medis.suhu_badan", 
			"data_rekam_medis.keluhan", 
			"data_rekam_medis.diagnosa", 
			"data_rekam_medis.resep_obat", 
			"data_rekam_medis.persetujuan_tindakan", 
			"data_rekam_medis.umur", 
			"data_rekam_medis.assesment_triase", 
			"data_rekam_medis.assesment_medis", 
			"data_rekam_medis.pemeriksaan_fisik");
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
				data_rekam_medis.id LIKE ? OR 
				data_rekam_medis.id_daftar LIKE ? OR 
				data_rekam_medis.tanggal LIKE ? OR 
				data_rekam_medis.no_rekam_medis LIKE ? OR 
				data_rekam_medis.nama_pasien LIKE ? OR 
				data_rekam_medis.nama_poli LIKE ? OR 
				data_rekam_medis.dokter_pemeriksa LIKE ? OR 
				data_rekam_medis.pasien LIKE ? OR 
				data_rekam_medis.tinggi LIKE ? OR 
				data_rekam_medis.berat_badan LIKE ? OR 
				data_rekam_medis.tensi LIKE ? OR 
				data_rekam_medis.suhu_badan LIKE ? OR 
				data_rekam_medis.tindakan LIKE ? OR 
				data_rekam_medis.keluhan LIKE ? OR 
				data_rekam_medis.diagnosa LIKE ? OR 
				data_rekam_medis.resep_obat LIKE ? OR 
				data_rekam_medis.persetujuan_tindakan LIKE ? OR 
				data_rekam_medis.rujukan LIKE ? OR 
				data_rekam_medis.hasil_laboratorium_radiologi LIKE ? OR 
				data_rekam_medis.date_created LIKE ? OR 
				data_rekam_medis.date_updated LIKE ? OR 
				data_rekam_medis.umur LIKE ? OR 
				data_rekam_medis.alergi_obat LIKE ? OR 
				data_rekam_medis.catatan_medis LIKE ? OR 
				data_rekam_medis.assesment_triase LIKE ? OR 
				data_rekam_medis.assesment_medis LIKE ? OR 
				data_rekam_medis.pemeriksaan_fisik LIKE ? OR 
				data_rekam_medis.perintah_opname LIKE ? OR 
				data_rekam_medis.keterangan_rujukan LIKE ? OR 
				data_rekam_medis.pemeriksaan_tambahan LIKE ? OR 
				data_rekam_medis.keterangan_tambahan LIKE ? OR 
				data_rekam_medis.nama_file LIKE ? OR 
				data_rekam_medis.nama_file_ket LIKE ? OR 
				data_rekam_medis.idapp LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_rekam_medis/search.php";
		}
		$db->join("data_poli", "data_rekam_medis.nama_poli = data_poli.id_poli", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_rekam_medis.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Rekam Medis";
		$this->render_view("data_rekam_medis/list.php", $data); //render the full page
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
		$fields = array("data_rekam_medis.id", 
			"data_rekam_medis.tanggal", 
			"data_rekam_medis.no_rekam_medis", 
			"data_rekam_medis.nama_poli", 
			"data_poli.nama_poli AS data_poli_nama_poli", 
			"data_rekam_medis.nama_pasien", 
			"data_rekam_medis.tinggi", 
			"data_rekam_medis.berat_badan", 
			"data_rekam_medis.tensi", 
			"data_rekam_medis.suhu_badan", 
			"data_rekam_medis.keluhan", 
			"data_rekam_medis.diagnosa", 
			"diagnosa.description AS diagnosa_description", 
			"data_rekam_medis.resep_obat", 
			"data_rekam_medis.persetujuan_tindakan", 
			"data_rekam_medis.dokter_pemeriksa", 
			"data_rekam_medis.rujukan", 
			"data_rekam_medis.pasien", 
			"data_rekam_medis.umur", 
			"data_rekam_medis.alergi_obat", 
			"data_rekam_medis.perintah_opname");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_rekam_medis.id", $rec_id);; //select record based on primary key
		}
		$db->join("data_poli", "data_rekam_medis.nama_poli = data_poli.id_poli", "INNER");
		$db->join("diagnosa", "data_rekam_medis.diagnosa = diagnosa.id", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Rekam Medis";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_rekam_medis/view.php", $record);
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
			$fields = $this->fields = array("tanggal","no_rekam_medis","nama_poli","nama_pasien","tensi","suhu_badan","tinggi","berat_badan","keluhan","diagnosa","dokter_pemeriksa","pasien","id_daftar","alergi_obat","catatan_medis");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'keluhan' => 'required',
				'dokter_pemeriksa' => 'required',
				'pasien' => 'required',
				'id_daftar' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'tensi' => 'sanitize_string',
				'suhu_badan' => 'sanitize_string',
				'tinggi' => 'sanitize_string',
				'berat_badan' => 'sanitize_string',
				'keluhan' => 'sanitize_string',
				'diagnosa' => 'sanitize_string',
				'dokter_pemeriksa' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
				'alergi_obat' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
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
 $iddaftar = $_POST['id_daftar'];
 $pasien   = $_POST['pasien'];
            /////////////////////////////Tindakan//////////////////////////////////////////
$kettindakan = "";
if(isset($_POST['tindakan'])){
 $cektindakan = $_POST['tindakan'];
    if(!empty( $cektindakan)){
        for($a = 0; $a < count( $cektindakan); $a++){
            if(!empty( $cektindakan[$a])){
                $idtin =  $cektindakan[$a];
 $res = mysqli_query($koneksi, "SELECT * FROM list_biaya_tindakan WHERE id='$idtin'"); 
 while ($rowii=mysqli_fetch_array($res)){
     $biaya_tindakan = $rowii['harga'];
     $tindakan       = $rowii['nama_tindakan'];
 }
 mysqli_query($koneksi,"INSERT INTO `data_tindakan` (`tindakan`,`pasien`,`nama_tindakan`,`id_daftar`, `harga`) VALUES ('Tindakan Dari $pasien','$pasien','$tindakan',' $iddaftar', '$biaya_tindakan')"); 
if($kettindakan==""){
$kettindakan = "$tindakan";
}else{
    $kettindakan = "$kettindakan $tindakan";
}
            }
        }
    }    
}
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
$db->rawQuery("UPDATE data_rekam_medis SET tindakan='$kettindakan' WHERE id='$rec_id'");
$no_rekam_medis = $_POST['no_rekam_medis'];
//$iddaftar       = $_POST['id_daftar'];
$pasien        = $_POST['pasien'];
$catatan_medis = $_POST['catatan_medis'];
if($pasien=="IGD"){
     $sqlcek1 = mysqli_query($koneksi,"select * from igd WHERE id_igd='$iddaftar'");
$rows1 = mysqli_num_rows($sqlcek1);
  if ($rows1 <> 0) {
$row= mysqli_fetch_assoc($sqlcek1); 
 $no_rekam_medis = $row['no_rekam_medis'];
 $nama_pasien    = $row['nama_pasien'];
 $alamat         = $row['alamat'];
 $no_hp          = $row['no_hp'];
 $tanggal_lahir  = $row['tanggal_lahir'];
 $jenis_kelamin  = $row['jenis_kelamin'];
 $email          = $row['email'];
 $umur           = $row['umur'];
 $iddokter       = $row['dokter'];
 $tinggi         = "";
 $berat_badan    = "";
 $tensi          = "";
$suhu_badan="";
 $tanggal=$row['tanggal_masuk'];
 $keluhan=$row['keluhan'];
 $pembayaran=$row['pembayaran'];
  $alergi_obat=$row['alergi_obat'];
  $pasien=$row['pasien'];
  // $nama_poli=$pasien;
}
  $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$iddokter'");
while ($row3=mysqli_fetch_array($sqlcek3)){
    $nama_dokter=$row3['nama_dokter'];
     $nama_poli=$row3['specialist'];
}
 // $namapoli="";
}else if($pasien=="RANAP"){
     $sqlcek1 = mysqli_query($koneksi,"select * from rawat_inap WHERE id='$iddaftar'");
$rows1 = mysqli_num_rows($sqlcek1);
  if ($rows1 <> 0) {
$row= mysqli_fetch_assoc($sqlcek1); 
 $no_rekam_medis=$row['no_rekam_medis'];
 $nama_pasien=$row['nama_pasien'];
 $alamat=$row['alamat'];
 $no_hp=$row['no_hp'];
 $tanggal_lahir=$row['tanggal_lahir'];
 $jenis_kelamin=$row['jenis_kelamin'];
 $email=$row['email'];
 $umur=$row['umur'];
 $iddokter=$row['dokter_rawat_inap'];
 $tinggi="";
 $berat_badan="";
 $tensi="";
$suhu_badan="";
 $tanggal=$row['tanggal_masuk'];
 // $keluhan=$row['keluhan'];
  $nama_poli = $row['poli'];
 $pembayaran=$row['pembayaran'];
  $alergi_obat=$row['alergi_obat'];
  //$nama_poli=$pasien;
}
  $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$iddokter'");
while ($row3=mysqli_fetch_array($sqlcek3)){
    $nama_dokter = $row3['nama_dokter'];
    // $nama_poli = $row3['specialist'];
}
 $sqlcek4 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$nama_poli'");
while ($row4=mysqli_fetch_array($sqlcek4)){
    $namapoli=$row4['nama_poli'];
}
// $namapoli="";
}else if($pasien=="RANAP ANAK"){
     $sqlcek1 = mysqli_query($koneksi,"select * from ranap_anak WHERE id='$iddaftar'");
$rows1 = mysqli_num_rows($sqlcek1);
  if ($rows1 <> 0) {
$row= mysqli_fetch_assoc($sqlcek1); 
 $no_rekam_medis = $row['no_rekam_medis'];
 $nama_pasien    = $row['nama_pasien'];
 $alamat         = $row['alamat'];
 $no_hp          = $row['no_hp'];
 $tanggal_lahir  = $row['tanggal_lahir'];
 $jenis_kelamin  = $row['jenis_kelamin'];
 $email          = $row['email'];
 $umur           = $row['umur'];
 $iddokter       = $row['dokter_ranap_anak'];
 $tinggi         = "";
 $berat_badan    = "";
 $tensi          = "";
$suhu_badan="";
 $tanggal=$row['tanggal_masuk'];
 // $keluhan=$row['keluhan'];
  $nama_poli = $row['poli'];
 $pembayaran=$row['pembayaran'];
  $alergi_obat=$row['alergi_obat'];
  //$nama_poli=$pasien;
}
  $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$iddokter'");
while ($row3=mysqli_fetch_array($sqlcek3)){
    $nama_dokter = $row3['nama_dokter'];
    // $nama_poli = $row3['specialist'];
}
 $sqlcek4 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$nama_poli'");
while ($row4=mysqli_fetch_array($sqlcek4)){
    $namapoli=$row4['nama_poli'];
}
// $namapoli="";
}else{ 
 $sqlcek1 = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_pendaftaran_poli='$iddaftar'");
$rows1 = mysqli_num_rows($sqlcek1);
  if ($rows1 <> 0) {
$row= mysqli_fetch_assoc($sqlcek1); 
 $no_rekam_medis = $row['no_rekam_medis'];
 $nama_pasien    = $row['nama_pasien'];
 $alamat         = $row['alamat'];
 $no_hp          = $row['no_hp'];
 $tanggal_lahir  = $row['tanggal_lahir'];
 $jenis_kelamin  = $row['jenis_kelamin'];
 $email          = $row['email'];
 $umur           = $row['umur'];
 $tinggi         = $row['tinggi'];
 $berat_badan    = $row['berat_badan'];
 $tensi          = $row['tensi'];
$suhu_badan = $row['suhu_badan'];
$iddokter   = $row['dokter'];
 $tanggal=$row['tanggal'];
 $keluhan=$row['keluhan'];
 $pembayaran=$row['pembayaran'];
  $alergi_obat=$row['alergi_obat'];
  $nama_poli=$row['nama_poli'];
}
$sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$iddokter'");
while ($row3=mysqli_fetch_array($sqlcek3)){
    $nama_dokter=$row3['nama_dokter'];
    //  $nama_poli=$row3['specialist'];
}
 $sqlcek4 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$nama_poli'");
while ($row4=mysqli_fetch_array($sqlcek4)){
    $namapoli=$row4['nama_poli'];
}
}
if($pasien=="IGD"){
$nama_poli = "IGD";
}else{
    $nama_poli = $namapoli;
}
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
$umurnya = hitung_umur("$tanggal_lahir");
$qucekrekam = mysqli_query($koneksi,"select * from rekam_medis WHERE no_rekam_medis='$no_rekam_medis'");
  $rowsrek = mysqli_num_rows($qucekrekam);
if ($rowsrek <> 0) {
mysqli_query($koneksi,"UPDATE rekam_medis SET nama_pasien='$nama_pasien',alamat='$alamat',no_hp='$no_hp',email='$email',tanggal_lahir='$tanggal_lahir',umur='$umurnya',jenis_kelamin='$jenis_kelamin' WHERE no_rekam_medis='$no_rekam_medis'");
    }else{
mysqli_query($koneksi, "INSERT INTO `rekam_medis`(`no_rekam_medis`, `nama_pasien`, `alamat`, `no_hp`, `email`, `jenis_kelamin`, `tanggal_lahir`, `umur`) VALUES ('$no_rekam_medis','$nama_pasien','$alamat','$no_hp','$email','$jenis_kelamin','$tanggal_lahir','$umurnya')"); 
    }
//////////////////////////////////////////////////////////////////////////////////
if($kettindakan=="") {
}else{
    $qujumtin = mysqli_query($koneksi, "SELECT SUM(harga) AS tot from data_tindakan WHERE id_daftar='$iddaftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
 $jumtin = mysqli_fetch_assoc($qujumtin);    
 $tottin = $jumtin['tot'];
  $quetrx= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrx = mysqli_num_rows($quetrx);
  if ($rotrx <> 0) {
        $dattrx      = mysqli_fetch_assoc($quetrx);
        $idtrx       = $dattrx['id'];  
        $tottagawal  = $dattrx['total_tagihan'];
        $tottagakhir = $tottagawal + $tottin;
        mysqli_query($koneksi, "UPDATE transaksi SET total_tagihan='$tottagakhir' WHERE id='$idtrx'"); 
  } 
 mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES (' $idtrx','$iddaftar','Tindakan','".$_POST['tanggal']."','$no_rekam_medis','$tottin','Register','POLI','$kettindakan')");
}
if($pasien=="POLI"){
///////////////////////////////////////Jasa Dokter/////////////////////
 $queoner= mysqli_query($koneksi, "SELECT * FROM `data_dokter` where id_dokter='$iddokter'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $roner = mysqli_num_rows($queoner);
  if ($roner <> 0) {
      $datoner                = mysqli_fetch_assoc($queoner);
      $jasa_poli              = $datoner['jasa_poli'];
      $jasa_kunjungan         = $datoner['jasa_kunjungan'];
      $tagihan_jasa_poli      = $datoner['tagihan_jasa_poli'];
      $tagihan_jasa_kunjungan = $datoner['tagihan_jasa_kunjungan'];
       }else{
           $biaya_layanan = "";
       }
   if($tagihan_jasa_poli=="" or $tagihan_jasa_poli=="Tidak"){
   }else{
  $quetrx= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$no_rekam_medis' and setatus_tagihan='Register'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrx = mysqli_num_rows($quetrx);
  if ($rotrx <> 0) {
        $dattrx      = mysqli_fetch_assoc($quetrx);
        $idtrx       = $dattrx['id'];  
        $tottagawal  = $dattrx['total_tagihan'];
        $tottagakhir = $tottagawal + $jasa_poli;
        mysqli_query($koneksi, "UPDATE transaksi SET total_tagihan='$tottagakhir' WHERE id='$idtrx'"); 
  } 
    mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES ('$idtrx','$iddokter','Jasa Dokter','".$_POST['tanggal']."','$no_rekam_medis','$jasa_poli','Register','POLI','Jasa Dokter Poli')");   
}
 ///////////////////////////////////////////////////////////////////////
}
 $db->rawQuery("UPDATE data_rekam_medis SET nama_poli='$nama_poli' WHERE id='$rec_id'");
if($catatan_medis==""){
}else{
    mysqli_query($koneksi,"INSERT INTO `catatan_medis` (`id_daftar`,`tanggal`,`no_rekam_medis`,`catatan_medis`,`pasien`,`nama_poli`,`dokter`) VALUES ('$iddaftar','".$_POST['tanggal']."','$no_rekam_medis','$catatan_medis','$pasien','$nama_poli','$nama_dokter')");   
}
 $db->rawQuery("UPDATE data_rekam_medis SET umur='$umurnya' WHERE id='$rec_id'");
mysqli_query($koneksi,"UPDATE rekam_medis SET umur='$umurnya', date_updated='".date("Y-m-d H:i:s")."' WHERE no_rekam_medis='$no_rekam_medis'");
//mysqli_query($koneksi, "UPDATE pendaftaran_poli SET setatus='Closed' WHERE id_pendaftaran_poli='$iddaftar'");
$this->set_flash_msg("Rekam Medis Berhasil Di Simpan!! ", "success");
if($pasien=="IGD"){
 return  $this->redirect("igd");
}else if($pasien=="RANAP"){
 return  $this->redirect("rawat_inap");
 }else if($pasien=="RANAP ANAK"){
 return  $this->redirect("rawnap_anak");
 }else if($pasien=="RANAP BERSALIN"){
 return  $this->redirect("rawnap_bersalin");
 }else if($pasien=="RANAP PERINA"){
 return  $this->redirect("rawnap_perina");
}else{
 return  $this->redirect("pendaftaran_poli");
}
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_rekam_medis");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Rekam Medis";
		$this->render_view("data_rekam_medis/add.php");
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
		$fields = $this->fields = array("id","tensi","suhu_badan","tinggi","berat_badan");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
			);
			$this->sanitize_array = array(
				'tensi' => 'sanitize_string',
				'suhu_badan' => 'sanitize_string',
				'tinggi' => 'sanitize_string',
				'berat_badan' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_rekam_medis.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_rekam_medis");
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
						return	$this->redirect("data_rekam_medis");
					}
				}
			}
		}
		$db->where("data_rekam_medis.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Rekam Medis";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_rekam_medis/edit.php", $data);
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
		$db->where("data_rekam_medis.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("data_rekam_medis");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function catatan_medis($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal","no_rekam_medis","nama_poli","nama_pasien","tinggi","berat_badan","tensi","suhu_badan","resep_obat","persetujuan_tindakan","dokter_pemeriksa","pasien","id_daftar","umur","alergi_obat","catatan_medis");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'no_rekam_medis' => 'required',
				'nama_poli' => 'required',
				'nama_pasien' => 'required',
				'tinggi' => 'required',
				'berat_badan' => 'required',
				'tensi' => 'required',
				'suhu_badan' => 'required',
				'resep_obat' => 'required',
				'persetujuan_tindakan' => 'required',
				'dokter_pemeriksa' => 'required',
				'pasien' => 'required',
				'id_daftar' => 'required|numeric',
				'umur' => 'required',
				'alergi_obat' => 'required',
				'catatan_medis' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'tinggi' => 'sanitize_string',
				'berat_badan' => 'sanitize_string',
				'tensi' => 'sanitize_string',
				'suhu_badan' => 'sanitize_string',
				'resep_obat' => 'sanitize_string',
				'persetujuan_tindakan' => 'sanitize_string',
				'dokter_pemeriksa' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'id_daftar' => 'sanitize_string',
				'umur' => 'sanitize_string',
				'alergi_obat' => 'sanitize_string',
				'catatan_medis' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_rekam_medis");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Rekam Medis";
		$this->render_view("data_rekam_medis/catatan_medis.php");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function riwayat($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_poli", 
			"keluhan", 
			"diagnosa", 
			"resep_obat", 
			"dokter_pemeriksa", 
			"alergi_obat");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_rekam_medis.id LIKE ? OR 
				data_rekam_medis.tanggal LIKE ? OR 
				data_rekam_medis.no_rekam_medis LIKE ? OR 
				data_rekam_medis.nama_poli LIKE ? OR 
				data_rekam_medis.nama_pasien LIKE ? OR 
				data_rekam_medis.tinggi LIKE ? OR 
				data_rekam_medis.berat_badan LIKE ? OR 
				data_rekam_medis.tensi LIKE ? OR 
				data_rekam_medis.suhu_badan LIKE ? OR 
				data_rekam_medis.tindakan LIKE ? OR 
				data_rekam_medis.keluhan LIKE ? OR 
				data_rekam_medis.diagnosa LIKE ? OR 
				data_rekam_medis.resep_obat LIKE ? OR 
				data_rekam_medis.persetujuan_tindakan LIKE ? OR 
				data_rekam_medis.dokter_pemeriksa LIKE ? OR 
				data_rekam_medis.rujukan LIKE ? OR 
				data_rekam_medis.hasil_laboratorium_radiologi LIKE ? OR 
				data_rekam_medis.date_created LIKE ? OR 
				data_rekam_medis.date_updated LIKE ? OR 
				data_rekam_medis.pasien LIKE ? OR 
				data_rekam_medis.id_daftar LIKE ? OR 
				data_rekam_medis.umur LIKE ? OR 
				data_rekam_medis.alergi_obat LIKE ? OR 
				data_rekam_medis.catatan_medis LIKE ? OR 
				data_rekam_medis.assesment_triase LIKE ? OR 
				data_rekam_medis.assesment_medis LIKE ? OR 
				data_rekam_medis.pemeriksaan_fisik LIKE ? OR 
				data_rekam_medis.perintah_opname LIKE ? OR 
				data_rekam_medis.keterangan_rujukan LIKE ? OR 
				data_rekam_medis.pemeriksaan_tambahan LIKE ? OR 
				data_rekam_medis.keterangan_tambahan LIKE ? OR 
				data_rekam_medis.nama_file LIKE ? OR 
				data_rekam_medis.nama_file_ket LIKE ? OR 
				data_rekam_medis.idapp LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_rekam_medis/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_rekam_medis.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Rekam Medis";
		$this->render_view("data_rekam_medis/riwayat.php", $data); //render the full page
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function detile($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"id_daftar", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_poli", 
			"nama_pasien", 
			"pasien", 
			"dokter_pemeriksa", 
			"keluhan", 
			"pemeriksaan_fisik", 
			"tindakan", 
			"resep_obat", 
			"diagnosa", 
			"hasil_laboratorium_radiologi", 
			"alergi_obat", 
			"assesment_triase", 
			"assesment_medis", 
			"catatan_medis");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_rekam_medis.id LIKE ? OR 
				data_rekam_medis.id_daftar LIKE ? OR 
				data_rekam_medis.tanggal LIKE ? OR 
				data_rekam_medis.no_rekam_medis LIKE ? OR 
				data_rekam_medis.nama_poli LIKE ? OR 
				data_rekam_medis.nama_pasien LIKE ? OR 
				data_rekam_medis.pasien LIKE ? OR 
				data_rekam_medis.tinggi LIKE ? OR 
				data_rekam_medis.berat_badan LIKE ? OR 
				data_rekam_medis.tensi LIKE ? OR 
				data_rekam_medis.dokter_pemeriksa LIKE ? OR 
				data_rekam_medis.suhu_badan LIKE ? OR 
				data_rekam_medis.keluhan LIKE ? OR 
				data_rekam_medis.pemeriksaan_fisik LIKE ? OR 
				data_rekam_medis.tindakan LIKE ? OR 
				data_rekam_medis.resep_obat LIKE ? OR 
				data_rekam_medis.diagnosa LIKE ? OR 
				data_rekam_medis.persetujuan_tindakan LIKE ? OR 
				data_rekam_medis.rujukan LIKE ? OR 
				data_rekam_medis.hasil_laboratorium_radiologi LIKE ? OR 
				data_rekam_medis.date_created LIKE ? OR 
				data_rekam_medis.date_updated LIKE ? OR 
				data_rekam_medis.umur LIKE ? OR 
				data_rekam_medis.alergi_obat LIKE ? OR 
				data_rekam_medis.assesment_triase LIKE ? OR 
				data_rekam_medis.assesment_medis LIKE ? OR 
				data_rekam_medis.catatan_medis LIKE ? OR 
				data_rekam_medis.perintah_opname LIKE ? OR 
				data_rekam_medis.keterangan_rujukan LIKE ? OR 
				data_rekam_medis.pemeriksaan_tambahan LIKE ? OR 
				data_rekam_medis.keterangan_tambahan LIKE ? OR 
				data_rekam_medis.nama_file LIKE ? OR 
				data_rekam_medis.nama_file_ket LIKE ? OR 
				data_rekam_medis.idapp LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_rekam_medis/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_rekam_medis.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Rekam Medis";
		$this->render_view("data_rekam_medis/detile.php", $data); //render the full page
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function tensiview($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_pasien", 
			"umur", 
			"pasien");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("data_rekam_medis.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Data Rekam Medis";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("data_rekam_medis/tensiview.php", $record);
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function tensi($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","tinggi","berat_badan","tensi","suhu_badan","date_updated");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tensi' => 'required',
				'suhu_badan' => 'required',
			);
			$this->sanitize_array = array(
				'tinggi' => 'sanitize_string',
				'berat_badan' => 'sanitize_string',
				'tensi' => 'sanitize_string',
				'suhu_badan' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_rekam_medis.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_rekam_medis");
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
						return	$this->redirect("data_rekam_medis");
					}
				}
			}
		}
		$db->where("data_rekam_medis.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Rekam Medis";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_rekam_medis/tensi.php", $data);
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function rm($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_poli", 
			"nama_pasien", 
			"dokter_pemeriksa", 
			"keluhan", 
			"pemeriksaan_fisik", 
			"tindakan", 
			"resep_obat", 
			"catatan_medis", 
			"diagnosa", 
			"pasien", 
			"alergi_obat", 
			"id_daftar", 
			"hasil_laboratorium_radiologi", 
			"idapp");
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
				data_rekam_medis.id LIKE ? OR 
				data_rekam_medis.tanggal LIKE ? OR 
				data_rekam_medis.no_rekam_medis LIKE ? OR 
				data_rekam_medis.nama_poli LIKE ? OR 
				data_rekam_medis.nama_pasien LIKE ? OR 
				data_rekam_medis.tinggi LIKE ? OR 
				data_rekam_medis.berat_badan LIKE ? OR 
				data_rekam_medis.tensi LIKE ? OR 
				data_rekam_medis.suhu_badan LIKE ? OR 
				data_rekam_medis.dokter_pemeriksa LIKE ? OR 
				data_rekam_medis.keluhan LIKE ? OR 
				data_rekam_medis.pemeriksaan_fisik LIKE ? OR 
				data_rekam_medis.tindakan LIKE ? OR 
				data_rekam_medis.resep_obat LIKE ? OR 
				data_rekam_medis.catatan_medis LIKE ? OR 
				data_rekam_medis.diagnosa LIKE ? OR 
				data_rekam_medis.persetujuan_tindakan LIKE ? OR 
				data_rekam_medis.rujukan LIKE ? OR 
				data_rekam_medis.date_created LIKE ? OR 
				data_rekam_medis.date_updated LIKE ? OR 
				data_rekam_medis.pasien LIKE ? OR 
				data_rekam_medis.alergi_obat LIKE ? OR 
				data_rekam_medis.id_daftar LIKE ? OR 
				data_rekam_medis.hasil_laboratorium_radiologi LIKE ? OR 
				data_rekam_medis.umur LIKE ? OR 
				data_rekam_medis.assesment_triase LIKE ? OR 
				data_rekam_medis.assesment_medis LIKE ? OR 
				data_rekam_medis.perintah_opname LIKE ? OR 
				data_rekam_medis.keterangan_rujukan LIKE ? OR 
				data_rekam_medis.pemeriksaan_tambahan LIKE ? OR 
				data_rekam_medis.keterangan_tambahan LIKE ? OR 
				data_rekam_medis.nama_file LIKE ? OR 
				data_rekam_medis.nama_file_ket LIKE ? OR 
				data_rekam_medis.idapp LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_rekam_medis/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_rekam_medis.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Rekam Medis";
		$this->render_view("data_rekam_medis/rm.php", $data); //render the full page
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function pemtambahan($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("no_rekam_medis","nama_pasien","nama_file","pemeriksaan_tambahan");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'nama_file' => 'required',
				'pemeriksaan_tambahan' => 'required',
			);
			$this->sanitize_array = array(
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'nama_file' => 'sanitize_string',
				'pemeriksaan_tambahan' => 'sanitize_string',
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
$datid     = $_POST['datid'];
$nama_file = $_POST['nama_file'];
$pemeriksaan_tambahan     = $_POST['pemeriksaan_tambahan'];
 $queryb = mysqli_query($koneksi, "select * from data_rekam_medis WHERE id='$datid'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rowsb = mysqli_num_rows($queryb);
  if ($rowsb <> 0) {
      $row      = mysqli_fetch_assoc($queryb);
      $pemtam   = $row['pemeriksaan_tambahan'];
      $namfile  = $row['nama_file'];
      $iddaftar = $row['id_daftar'];
  }
if($pemtam==""){
$pemtam = $pemeriksaan_tambahan;
}else{
    $pemtam = $pemtam.",".$pemeriksaan_tambahan;
}
if($namfile==""){
$namfile = $nama_file;
}else{
    $namfile = $namfile.",".$nama_file;
}
$key="dermawangroup";
                                            $plaintext      = "$iddaftar";
                                            $ivlen          = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                            $iv             = openssl_random_pseudo_bytes($ivlen);
                                            $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                            $hmac           = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                            $ciphertext     = base64_encode( $iv.$hmac.$ciphertext_raw );
mysqli_query($koneksi, "UPDATE data_rekam_medis SET nama_file='$namfile', pemeriksaan_tambahan='$pemtam' WHERE id='$datid'");
$this->set_flash_msg("Add Upload Berhasil Di Simpan!! ", "success");
 return  $this->redirect("pendaftaran_poli/dokter?precord=$ciphertext");
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_rekam_medis");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Rekam Medis";
		$this->render_view("data_rekam_medis/pemtambahan.php");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function datfile($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_poli", 
			"nama_pasien", 
			"tinggi", 
			"berat_badan", 
			"tensi", 
			"suhu_badan", 
			"tindakan", 
			"keluhan", 
			"diagnosa", 
			"resep_obat", 
			"persetujuan_tindakan", 
			"dokter_pemeriksa", 
			"rujukan", 
			"hasil_laboratorium_radiologi", 
			"date_created", 
			"date_updated", 
			"pasien", 
			"id_daftar", 
			"umur", 
			"alergi_obat", 
			"catatan_medis", 
			"assesment_triase", 
			"assesment_medis", 
			"pemeriksaan_fisik", 
			"perintah_opname", 
			"keterangan_rujukan", 
			"pemeriksaan_tambahan", 
			"keterangan_tambahan", 
			"nama_file", 
			"nama_file_ket", 
			"idapp");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_rekam_medis.id LIKE ? OR 
				data_rekam_medis.tanggal LIKE ? OR 
				data_rekam_medis.no_rekam_medis LIKE ? OR 
				data_rekam_medis.nama_poli LIKE ? OR 
				data_rekam_medis.nama_pasien LIKE ? OR 
				data_rekam_medis.tinggi LIKE ? OR 
				data_rekam_medis.berat_badan LIKE ? OR 
				data_rekam_medis.tensi LIKE ? OR 
				data_rekam_medis.suhu_badan LIKE ? OR 
				data_rekam_medis.tindakan LIKE ? OR 
				data_rekam_medis.keluhan LIKE ? OR 
				data_rekam_medis.diagnosa LIKE ? OR 
				data_rekam_medis.resep_obat LIKE ? OR 
				data_rekam_medis.persetujuan_tindakan LIKE ? OR 
				data_rekam_medis.dokter_pemeriksa LIKE ? OR 
				data_rekam_medis.rujukan LIKE ? OR 
				data_rekam_medis.hasil_laboratorium_radiologi LIKE ? OR 
				data_rekam_medis.date_created LIKE ? OR 
				data_rekam_medis.date_updated LIKE ? OR 
				data_rekam_medis.pasien LIKE ? OR 
				data_rekam_medis.id_daftar LIKE ? OR 
				data_rekam_medis.umur LIKE ? OR 
				data_rekam_medis.alergi_obat LIKE ? OR 
				data_rekam_medis.catatan_medis LIKE ? OR 
				data_rekam_medis.assesment_triase LIKE ? OR 
				data_rekam_medis.assesment_medis LIKE ? OR 
				data_rekam_medis.pemeriksaan_fisik LIKE ? OR 
				data_rekam_medis.perintah_opname LIKE ? OR 
				data_rekam_medis.keterangan_rujukan LIKE ? OR 
				data_rekam_medis.pemeriksaan_tambahan LIKE ? OR 
				data_rekam_medis.keterangan_tambahan LIKE ? OR 
				data_rekam_medis.nama_file LIKE ? OR 
				data_rekam_medis.nama_file_ket LIKE ? OR 
				data_rekam_medis.idapp LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_rekam_medis/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_rekam_medis.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Data Rekam Medis";
		$this->render_view("data_rekam_medis/datfile.php", $data); //render the full page
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function kettambahan($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("no_rekam_medis","nama_pasien","nama_file_ket","keterangan_tambahan");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'nama_file_ket' => 'required',
				'keterangan_tambahan' => 'required',
			);
			$this->sanitize_array = array(
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'nama_file_ket' => 'sanitize_string',
				'keterangan_tambahan' => 'sanitize_string',
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
$datid                = $_POST['datid'];
$nama_file_ket        = $_POST['nama_file_ket'];
$keterangan_tambahan = $_POST['keterangan_tambahan'];
 $queryb = mysqli_query($koneksi, "select * from data_rekam_medis WHERE id='$datid'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rowsb = mysqli_num_rows($queryb);
  if ($rowsb <> 0) {
      $row        = mysqli_fetch_assoc($queryb);
      $kettam     = $row['keterangan_tambahan'];
      $namfileket = $row['nama_file_ket'];
      $iddaftar   = $row['id_daftar'];
  }
  if($kettam==""){
  $kettam = $keterangan_tambahan;
}else{
    $kettam = $kettam.",".$keterangan_tambahan;
}
if($namfileket==""){
$namfileket = $nama_file_ket;
}else{
    $namfileket = $namfileket.",".$nama_file_ket;
}
$key="dermawangroup";
                                            $plaintext      = "$iddaftar";
                                            $ivlen          = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                            $iv             = openssl_random_pseudo_bytes($ivlen);
                                            $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                            $hmac           = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                            $ciphertext     = base64_encode( $iv.$hmac.$ciphertext_raw );
mysqli_query($koneksi, "UPDATE data_rekam_medis SET nama_file_ket='$namfileket', keterangan_tambahan='$kettam' WHERE id='$datid'");
$this->set_flash_msg("Add Upload Berhasil Di Simpan!! ", "success");
 return  $this->redirect("pendaftaran_poli/dokter?precord=$ciphertext");
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_rekam_medis");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Rekam Medis";
		$this->render_view("data_rekam_medis/kettambahan.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function diagnosa($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","diagnosa");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'diagnosa' => 'required',
			);
			$this->sanitize_array = array(
				'diagnosa' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("data_rekam_medis.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			$key            = "dermawangroup";
$plaintext      = "".$_POST['id_daftar'];
$ivlen          = openssl_cipher_iv_length($cipher="AES-128-CBC");
$iv             = openssl_random_pseudo_bytes($ivlen);
$ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
$hmac           = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
$ciphertext     = base64_encode( $iv.$hmac.$ciphertext_raw );
$this->set_flash_msg("Diagnosa Berhasil Di Simpan!! ", "success");
return  $this->redirect("pendaftaran_poli/dokter?precord=$ciphertext&datrm=".$_POST['no_rekam_medis']);
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("data_rekam_medis");
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
						return	$this->redirect("data_rekam_medis");
					}
				}
			}
		}
		$db->where("data_rekam_medis.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Data Rekam Medis";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("data_rekam_medis/diagnosa.php", $data);
	}
}
