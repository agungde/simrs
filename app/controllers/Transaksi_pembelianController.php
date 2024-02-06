<?php 
/**
 * Transaksi_pembelian Page Controller
 * @category  Controller
 */
class Transaksi_pembelianController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "transaksi_pembelian";
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
		$fields = array("kode_barang", 
			"nama_barang", 
			"jumlah", 
			"harga_beli", 
			"ppn", 
			"total_harga", 
			"tanggal_expired", 
			"id_transaksi_pembelian", 
			"tanggal_pembelian", 
			"diskon", 
			"setatus", 
			"total_diskon", 
			"category", 
			"divisi");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				transaksi_pembelian.id_pembelian LIKE ? OR 
				transaksi_pembelian.type_pembelian LIKE ? OR 
				transaksi_pembelian.id_suplier LIKE ? OR 
				transaksi_pembelian.nama_suplier LIKE ? OR 
				transaksi_pembelian.kode_barang LIKE ? OR 
				transaksi_pembelian.nama_barang LIKE ? OR 
				transaksi_pembelian.jumlah LIKE ? OR 
				transaksi_pembelian.harga_beli LIKE ? OR 
				transaksi_pembelian.ppn LIKE ? OR 
				transaksi_pembelian.total_harga LIKE ? OR 
				transaksi_pembelian.tanggal_expired LIKE ? OR 
				transaksi_pembelian.no_invoice LIKE ? OR 
				transaksi_pembelian.operator LIKE ? OR 
				transaksi_pembelian.idtrace LIKE ? OR 
				transaksi_pembelian.date_created LIKE ? OR 
				transaksi_pembelian.date_updated LIKE ? OR 
				transaksi_pembelian.id_transaksi_pembelian LIKE ? OR 
				transaksi_pembelian.tanggal_pembelian LIKE ? OR 
				transaksi_pembelian.diskon LIKE ? OR 
				transaksi_pembelian.setatus LIKE ? OR 
				transaksi_pembelian.total_diskon LIKE ? OR 
				transaksi_pembelian.databarang LIKE ? OR 
				transaksi_pembelian.satuan LIKE ? OR 
				transaksi_pembelian.category_barang LIKE ? OR 
				transaksi_pembelian.category LIKE ? OR 
				transaksi_pembelian.divisi LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "transaksi_pembelian/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("transaksi_pembelian.id_transaksi_pembelian", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Transaksi Pembelian";
		$this->render_view("transaksi_pembelian/list.php", $data); //render the full page
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
		$fields = array("kode_barang", 
			"nama_barang", 
			"jumlah", 
			"harga_beli", 
			"ppn", 
			"total_harga", 
			"tanggal_expired", 
			"id_transaksi_pembelian", 
			"tanggal_pembelian", 
			"diskon", 
			"setatus", 
			"total_diskon", 
			"category", 
			"divisi");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("transaksi_pembelian.id_transaksi_pembelian", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Transaksi Pembelian";
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
		return $this->render_view("transaksi_pembelian/view.php", $record);
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
			$fields = $this->fields = array("kode_barang","nama_barang","jumlah","harga_beli","ppn","total_harga","tanggal_expired","no_invoice","tanggal_pembelian","diskon","category");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'jumlah' => 'required|numeric',
				'harga_beli' => 'required|numeric',
				'ppn' => 'required',
				'total_harga' => 'required|numeric',
				'tanggal_expired' => 'required',
				'no_invoice' => 'required',
				'tanggal_pembelian' => 'required',
				'diskon' => 'required|numeric',
				'category' => 'required',
			);
			$this->sanitize_array = array(
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'jumlah' => 'sanitize_string',
				'harga_beli' => 'sanitize_string',
				'ppn' => 'sanitize_string',
				'total_harga' => 'sanitize_string',
				'tanggal_expired' => 'sanitize_string',
				'no_invoice' => 'sanitize_string',
				'tanggal_pembelian' => 'sanitize_string',
				'diskon' => 'sanitize_string',
				'category' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("transaksi_pembelian");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Transaksi Pembelian";
		$this->render_view("transaksi_pembelian/add.php");
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
		$fields = $this->fields = array("jumlah","harga_beli","diskon");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'jumlah' => 'required|numeric',
				'harga_beli' => 'required|numeric',
				'diskon' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'jumlah' => 'sanitize_string',
				'harga_beli' => 'sanitize_string',
				'diskon' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("transaksi_pembelian.id_transaksi_pembelian", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
		# Statement to execute after adding record
			$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
$jumlahpos   = $_POST['jumlah'];
$harga_beli  = $_POST['harga_beli'];
$diskon      = $_POST['diskon'];
$totalharga  = $jumlahpos * $harga_beli;
$totaldiskon = $jumlahpos * $diskon;
$db->rawQuery("UPDATE transaksi_pembelian SET total_harga='$totalharga',total_diskon='$totaldiskon' WHERE id_transaksi_pembelian='$rec_id'");    
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("transaksi_pembelian");
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
						return	$this->redirect("transaksi_pembelian");
					}
				}
			}
		}
		$db->where("transaksi_pembelian.id_transaksi_pembelian", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Transaksi Pembelian";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("transaksi_pembelian/edit.php", $data);
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
	#Statement to execute before delete record
	$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
$query = mysqli_query($koneksi, "SELECT * from transaksi_pembelian where id_transaksi_pembelian='$rec_id'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rows = mysqli_num_rows($query);
 if ($rows <> 0) {
     $data         = mysqli_fetch_assoc($query);
     $id_pembelian = $data['id_pembelian'];
}
if($rows=="1"){
 mysqli_query($koneksi, "DELETE FROM pembelian WHERE id_pembelian='$id_pembelian'");
}
	# End of before delete statement
		$db->where("transaksi_pembelian.id_transaksi_pembelian", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("transaksi_pembelian");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function pembelian($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("type_pembelian","nama_barang","jumlah","harga_beli","ppn","tanggal_expired","tanggal_pembelian","diskon","databarang","category_barang","category");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'type_pembelian' => 'required',
				'nama_barang' => 'required',
				'jumlah' => 'required|numeric',
				'harga_beli' => 'required|numeric',
				'ppn' => 'required',
				'tanggal_expired' => 'required',
				'tanggal_pembelian' => 'required',
				'diskon' => 'required|numeric',
				'databarang' => 'required',
				'category_barang' => 'numeric',
			);
			$this->sanitize_array = array(
				'type_pembelian' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'jumlah' => 'sanitize_string',
				'harga_beli' => 'sanitize_string',
				'ppn' => 'sanitize_string',
				'tanggal_expired' => 'sanitize_string',
				'tanggal_pembelian' => 'sanitize_string',
				'diskon' => 'sanitize_string',
				'databarang' => 'sanitize_string',
				'category_barang' => 'sanitize_string',
				'category' => 'sanitize_string',
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
$noinvoice  = $_POST['no_invoice'];
$search     = $_POST['nama_barang'];
$jumlahpost = $_POST['jumlah'];
$hargapost  = $_POST['harga_beli'];
$diskonpost = $_POST['diskon'];
//$tanggal    = $_POST['tanggal'];
$databarang    = $_POST['databarang'];
$typepembelian = $_POST['type_pembelian'];
$postcate = $_POST['category_barang'];
$category= $_POST['category'];
$queryce = mysqli_query($koneksi, "SELECT * from pembelian where no_invoice='$noinvoice' and setatus='Closed'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rowsce = mysqli_num_rows($queryce);
  if ($rowsce <> 0) {
      $datace = mysqli_fetch_assoc($queryce);
  $this->set_flash_msg("Product Sudah Di Input!!", "danger");
return  $this->redirect("transaksi_pembelian/pembelian?databarang=true&category=$category");
}
if($databarang=="True"){
$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$query       = mysqli_query($koneksi, "SELECT * from transaksi_pembelian where nama_barang='$nama_barang' and idtrace='$idtrace'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rows = mysqli_num_rows($query);
  if ($rows <> 0) {
    $data        = mysqli_fetch_assoc($query);
            $this->set_flash_msg("Product Sudah Di Input!!", "danger");
return  $this->redirect("transaksi_pembelian/pembelian?databarang=true&category=$category");
}
$queryd = mysqli_query($koneksi, "SELECT * from data_barang where nama_barang='$nama_barang'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rowsd = mysqli_num_rows($queryd);
  if ($rowsd <> 0) {
      // $data        = mysqli_fetch_assoc($query);
      $this->set_flash_msg("Nama Barang Sudah Ada Di Data Barang!!", "danger");
       return  $this->redirect("transaksi_pembelian/pembelian?databarang=true&category=$category");
}   
}else{
$query      = mysqli_query($koneksi, "SELECT * from setok_barang where kode_barang='$search' or nama_barang='$search'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rows = mysqli_num_rows($query);
  // cek hasil query
  // jika "no_antrian" sudah ada
  if ($rows <> 0) {
    // ambil data hasil query
    $data        = mysqli_fetch_assoc($query);
    $idbarang    = $data['id_barang'];
    $kode_barang = $data['kode_barang'];
    $nama_barang = $data['nama_barang'];
    $satuan      = $data['satuan'];
    $harga_beli  = $data['harga_beli'];  
    $harga_jual  = $data['harga_jual'];  
    $jumlah      = $data['jumlah'];
    }else{
        $this->set_flash_msg("Product Tidak Di Temukan!!", "danger");
        // return  $this->redirect("transaksi_pembelian/pembelian");
   if($typepembelian=="PO"){
  return  $this->redirect("transaksi_pembelian/pembelian?pembelian=PO&category=$category");
  }else{
      return  $this->redirect("transaksi_pembelian/pembelian?category=$category");
  }
    }
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
$noinvoice  = $_POST['no_invoice'];
$suplier    = $_POST['suplier'];
$search     = $_POST['nama_barang'];
$jumlahpost = $_POST['jumlah'];
$hargapost  = $_POST['harga_beli'];
$diskonpost = $_POST['diskon'];
//$tanggal    = $_POST['tanggal'];
$typep      = $_POST['type_pembelian'];
$databarang = $_POST['databarang'];
$tanggalp   = $_POST['tanggal_pembelian'];
$postcate   = $_POST['category_barang'];
$category= $_POST['category'];
   $queryp = mysqli_query($koneksi, "select * from pembelian WHERE no_invoice='$noinvoice'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rowsp = mysqli_num_rows($queryp);
  if ($rowsp <> 0) {
       $datap = mysqli_fetch_assoc($queryp);
       $id_pembelian=$datap['id_pembelian'];
       $no_invoice=$datap['no_invoice'];
  }else{
mysqli_query($koneksi, "INSERT INTO `pembelian` (`category_barang`,`no_invoice`, `tanggal_pembelian`) VALUES ('$postcate','$noinvoice','$tanggalp')"); 
 }    
$querypm = mysqli_query($koneksi, "select * from pembelian WHERE no_invoice='$noinvoice'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
 $rowspm = mysqli_num_rows($querypm);
if ($rowspm <> 0) {
$datapm = mysqli_fetch_assoc($querypm);
 $id_pembelian = $datapm['id_pembelian'];
 }  
if($suplier==""){
}else{
          $quersp = mysqli_query($koneksi, "select * from data_suplier WHERE id_suplier='$suplier'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                  $rowsp = mysqli_num_rows($quersp);
                                  if ($rowsp <> 0) {
                                      $datasp = mysqli_fetch_assoc($quersp);
                                       $nama   = $datasp['nama'];
                                       $alamat = $datasp['alamat'];
                                       $no_hp  = $datasp['no_hp'];
                                }
  $db->rawQuery("UPDATE transaksi_pembelian SET id_suplier='$suplier', nama_suplier='$nama' WHERE id_transaksi_pembelian='$rec_id'");  
  mysqli_query($koneksi, "UPDATE pembelian SET id_suplier='$suplier', nama_suplier='$nama', alamat='$alamat',no_hp='$no_hp' WHERE id_pembelian='$id_pembelian'"); 
}
    $totharga   = $jumlahpost * $hargapost;
    $totdiskon  = $jumlahpost * $diskonpost;
    $totalharga = $totharga - $totdiskon;
    $db->rawQuery("UPDATE transaksi_pembelian SET id_pembelian='$id_pembelian',no_invoice='$noinvoice', total_diskon='$totdiskon', total_harga='$totalharga', idtrace='$idtrace', kode_barang='$kode_barang', nama_barang='$nama_barang' WHERE id_transaksi_pembelian='$rec_id'");
if($databarang=="True"){
 $db->rawQuery("UPDATE transaksi_pembelian SET satuan='".$_POST['satuan']."',category_barang='".$_POST['category_barang']."' WHERE id_transaksi_pembelian='$rec_id'");   
 $this->set_flash_msg("Record Add successfully", "success");
    return  $this->redirect("transaksi_pembelian/pembelian?databarang=true&category=$category");
}else{
if($typep=="PO"){
$this->set_flash_msg("Record Add successfully", "success");
return  $this->redirect("transaksi_pembelian/pembelian?pembelian=PO&category=$category");
}else{
    $this->set_flash_msg("Record Add successfully", "success");
    return  $this->redirect("transaksi_pembelian/pembelian?category=$category");
}
}
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("transaksi_pembelian");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Transaksi Pembelian";
		$this->render_view("transaksi_pembelian/pembelian.php");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function proses($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("no_invoice","satuan","category_barang","category","divisi");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'no_invoice' => 'required',
				'satuan' => 'required',
				'category_barang' => 'required|numeric',
				'category' => 'required',
				'divisi' => 'required',
			);
			$this->sanitize_array = array(
				'no_invoice' => 'sanitize_string',
				'satuan' => 'sanitize_string',
				'category_barang' => 'sanitize_string',
				'category' => 'sanitize_string',
				'divisi' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("transaksi_pembelian");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Transaksi Pembelian";
		$this->render_view("transaksi_pembelian/proses.php");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function suplier($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("nama_suplier","category","divisi");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'nama_suplier' => 'required',
				'category' => 'required',
				'divisi' => 'required',
			);
			$this->sanitize_array = array(
				'nama_suplier' => 'sanitize_string',
				'category' => 'sanitize_string',
				'divisi' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("transaksi_pembelian");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Transaksi Pembelian";
		$this->render_view("transaksi_pembelian/suplier.php");
	}
}
