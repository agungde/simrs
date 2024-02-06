<?php 
/**
 * Transaksi_penjualan Page Controller
 * @category  Controller
 */
class Transaksi_penjualanController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "transaksi_penjualan";
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
		$fields = array("id_transaksi_penjualan", 
			"kode_barang", 
			"nama_barang", 
			"jumlah", 
			"harga", 
			"diskon", 
			"ppn", 
			"total_harga", 
			"no_invoice", 
			"id_data_setok");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				transaksi_penjualan.id_transaksi_penjualan LIKE ? OR 
				transaksi_penjualan.id_penjualan LIKE ? OR 
				transaksi_penjualan.id_pelanggan LIKE ? OR 
				transaksi_penjualan.tanggal LIKE ? OR 
				transaksi_penjualan.nama_pelanggan LIKE ? OR 
				transaksi_penjualan.alamat LIKE ? OR 
				transaksi_penjualan.no_hp LIKE ? OR 
				transaksi_penjualan.kode_barang LIKE ? OR 
				transaksi_penjualan.nama_barang LIKE ? OR 
				transaksi_penjualan.jumlah LIKE ? OR 
				transaksi_penjualan.harga LIKE ? OR 
				transaksi_penjualan.diskon LIKE ? OR 
				transaksi_penjualan.ppn LIKE ? OR 
				transaksi_penjualan.total_harga LIKE ? OR 
				transaksi_penjualan.total_bayar LIKE ? OR 
				transaksi_penjualan.nama_poli LIKE ? OR 
				transaksi_penjualan.operator LIKE ? OR 
				transaksi_penjualan.date_created LIKE ? OR 
				transaksi_penjualan.date_updated LIKE ? OR 
				transaksi_penjualan.id_jual LIKE ? OR 
				transaksi_penjualan.no_invoice LIKE ? OR 
				transaksi_penjualan.id_barang LIKE ? OR 
				transaksi_penjualan.id_data_setok LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "transaksi_penjualan/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("transaksi_penjualan.id_transaksi_penjualan", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Transaksi Penjualan";
		$view_name = (is_ajax() ? "transaksi_penjualan/ajax-list.php" : "transaksi_penjualan/list.php");
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
		$fields = array("id_transaksi_penjualan", 
			"id_penjualan", 
			"id_pelanggan", 
			"tanggal", 
			"nama_pelanggan", 
			"alamat", 
			"no_hp", 
			"kode_barang", 
			"nama_barang", 
			"jumlah", 
			"harga", 
			"total_harga", 
			"diskon", 
			"total_bayar", 
			"ppn", 
			"nama_poli", 
			"operator", 
			"date_created", 
			"date_updated", 
			"id_jual", 
			"no_invoice", 
			"id_data_setok");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("transaksi_penjualan.id_transaksi_penjualan", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Transaksi Penjualan";
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
		return $this->render_view("transaksi_penjualan/view.php", $record);
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
			$fields = $this->fields = array("kode_barang","nama_barang","jumlah","no_invoice");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'jumlah' => 'required|numeric',
				'no_invoice' => 'required',
			);
			$this->sanitize_array = array(
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'jumlah' => 'sanitize_string',
				'no_invoice' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("transaksi_penjualan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Transaksi Penjualan";
		$this->render_view("transaksi_penjualan/add.php");
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
		$fields = $this->fields = array("id_transaksi_penjualan","jumlah");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'jumlah' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'jumlah' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
		# Statement to execute after adding record
		$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
$jumlahpos = $_POST['jumlah'];
$query = mysqli_query($koneksi, "SELECT * from transaksi_penjualan where id_transaksi_penjualan='$rec_id' ") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows  = mysqli_num_rows($query);
  if ($rows <> 0) {
            $data        = mysqli_fetch_assoc($query);
            $idsetok     = $data['id_barang'];
            $jumlahs     = $data['jumlah'];
            $kode_barang = $data['kode_barang']; 
            $iddata      = $data['id_data_setok']; 
  }
         $queryb1 = mysqli_query($koneksi, "SELECT * from setok_barang where id_barang='$idsetok'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
         $rowsb1  = mysqli_num_rows($queryb1);
         if ($rowsb1 <> 0) {
             $datab1 = mysqli_fetch_assoc($queryb1);
     $harga_jual = $datab1['harga_jual'];
}       
 $queryb = mysqli_query($koneksi, "SELECT * from data_setok where id='$iddata' ") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rowsb  = mysqli_num_rows($queryb);
  if ($rowsb <> 0) {
      $datab   = mysqli_fetch_assoc($queryb);
      $jumlahb = $datab['jumlah'];
}
     if($jumlahpos>$jumlahs){
      $seli = $jumlahpos - $jumlahs;
     $stok = $jumlahb - $seli;
     mysqli_query($koneksi, "UPDATE data_setok SET jumlah='$stok' where id='$iddata' ");
  }
 if($jumlahpos<$jumlahs){
      $selis = $jumlahs - $jumlahpos;
      $stoks = $jumlahb + $selis;
      mysqli_query($koneksi, "UPDATE data_setok SET jumlah='$stoks' where id='$iddata' ");
   }
		# End of before update statement
				$db->where("transaksi_penjualan.id_transaksi_penjualan", $rec_id);;
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
$jumlahpos = $_POST['jumlah'];
$query = mysqli_query($koneksi, "SELECT * from transaksi_penjualan where id_transaksi_penjualan='$rec_id'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows  = mysqli_num_rows($query);
  if ($rows <> 0) {
            $data        = mysqli_fetch_assoc($query);
            $idsetok     = $data['id_barang'];
            $jumlahs     = $data['jumlah'];
            $kode_barang = $data['kode_barang']; 
  }
$queryb = mysqli_query($koneksi, "SELECT * from setok_barang where id_barang='$idsetok'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rowsb  = mysqli_num_rows($queryb);
  if ($rowsb <> 0) {
      $datab    = mysqli_fetch_assoc($queryb);
      $idbarang = $datab['id_barang'];
      $jumlahb  = $datab['jumlah'];
       $harga_jual = $datab['harga_jual'];
}
$totalharga = $harga_jual * $jumlahpos;
  $db->rawQuery("UPDATE transaksi_penjualan SET total_harga='$totalharga' WHERE id_transaksi_penjualan='$rec_id'");    
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("transaksi_penjualan");
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
						return	$this->redirect("transaksi_penjualan");
					}
				}
			}
		}
		$db->where("transaksi_penjualan.id_transaksi_penjualan", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Transaksi Penjualan";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("transaksi_penjualan/edit.php", $data);
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
$query = mysqli_query($koneksi, "SELECT * from transaksi_penjualan where id_transaksi_penjualan='$rec_id'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rows = mysqli_num_rows($query);
 if ($rows <> 0) {
     $data     = mysqli_fetch_assoc($query);
     $idbarang = $data['id_barang'];
    $jumlahdel = $data['jumlah'];
    $iddata    = $data['id_data_setok'];
        $id_penjualan = $data['id_penjualan'];
}
    $querybr = mysqli_query($koneksi, "SELECT * from data_setok where id='$iddata'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rowsbr = mysqli_num_rows($querybr);
  if ($rowsbr <> 0) {
      $databr   = mysqli_fetch_assoc($querybr);
      $idbarang = $databr['id_barang']; 
      $jumlahbr = $databr['jumlah'];     
     $tamb = $jumlahbr + $jumlahdel;
     mysqli_query($koneksi, "UPDATE data_setok SET jumlah='$tamb' WHERE id='$iddata'");   
  }
if($rows=="1"){
 mysqli_query($koneksi, "DELETE FROM penjualan WHERE id_penjualan='$id_penjualan'");
}
	# End of before delete statement
		$db->where("transaksi_penjualan.id_transaksi_penjualan", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("transaksi_penjualan");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function penjualan($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal","nama_barang","jumlah","no_invoice");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'nama_barang' => 'required',
				'jumlah' => 'required|numeric',
				'no_invoice' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'jumlah' => 'sanitize_string',
				'no_invoice' => 'sanitize_string',
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
$idpelanggan = $_POST['nama_pelanggan'];
$search      = $_POST['nama_barang'];
$jumlahpost  = $_POST['jumlah'];
$tanggal     = $_POST['tanggal'];
$cektgl = date("Y-m-d", strtotime($tanggal)); 
    $divisi="FARMASI";
    $bagian="FARMASI";
    $query = mysqli_query($koneksi, "SELECT * from data_setok where divisi='$divisi' and  bagian='$bagian' and  kode_barang='$search' or nama_barang='$search'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rows = mysqli_num_rows($query);
  // cek hasil query
  // jika "no_antrian" sudah ada
  if ($rows <> 0) {
    // ambil data hasil query
    $data        = mysqli_fetch_assoc($query);
     $kode     = $data['kode_barang'];
     $iddata   = $data['id'];
  $queryb = mysqli_query($koneksi, "select * from setok_barang WHERE kode_barang='$kode'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                         $idbarang = $row['id_barang'];
                        $harga_jual=$row['harga_jual'];
                        } 
    // $nama_barang = $data['nama_barang'];
    // $satuan      = $data['satuan'];
    // $harga_beli  = $data['harga_beli'];  
    //$harga_jual = $data['harga_jual'];  
    $jumlah     = $data['jumlah'];
    if($jumlah<1){
        $this->set_flash_msg("Product Telah Habis!!", "danger");
        return  $this->redirect("transaksi_penjualan/penjualan");
    }
    }else{
        $this->set_flash_msg("Product Tidak Di Temukan", "danger");
        return  $this->redirect("transaksi_penjualan/penjualan");
    }
    $queryc = mysqli_query($koneksi, "SELECT * from transaksi_penjualan where id_data_setok='$iddata'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rowsc = mysqli_num_rows($queryc);
  if ($rowsc <> 0) {   
       $datac   = mysqli_fetch_assoc($queryc);
       $jumlahc = $datac['jumlah'];
       $jumup   = $jumlahpost + $jumlahc;
       $totharga = $jumup * $harga_jual;
       $db->rawQuery("UPDATE transaksi_penjualan SET jumlah='$jumup', total_harga='$totharga' WHERE id_data_setok='$iddata'"); 
   $stok   = $jumlah - $jumlahpost;
   $queryb = mysqli_query($koneksi, "UPDATE data_setok SET jumlah='$stok' where id='$iddata'");
        $this->set_flash_msg("Product Berhasil Di Tambahkan", "success");
        return  $this->redirect("transaksi_penjualan/penjualan");
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
$idpelanggan = $_POST['nama_pelanggan'];
$search      = $_POST['nama_barang'];
$jumlahpost  = $_POST['jumlah'];
$tanggal     = $_POST['tanggal'];
$query = mysqli_query($koneksi, "SELECT * from setok_barang where id_barang='$idbarang'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
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
    }
 $queryp = mysqli_query($koneksi, "select * from penjualan WHERE id_jual='$idtrace' and DATE(penjualan.tanggal)='$cektgl'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rowsp = mysqli_num_rows($queryp);
  if ($rowsp <> 0) {
       $datap = mysqli_fetch_assoc($queryp);
       $id_penjualan=$datap['id_penjualan'];
       $no_invoice=$datap['no_invoice'];
  }else{
      mysqli_query($koneksi,"INSERT INTO `penjualan` (`id_jual`,`trx`) VALUES ('$idtrace','Jual')"); 
$quer = mysqli_query($koneksi, "select * from penjualan WHERE id_jual='$idtrace'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rowss = mysqli_num_rows($quer);
if ($rowss <> 0) {
    $datas        = mysqli_fetch_assoc($quer);
    $id_penjualan = $datas['id_penjualan'];
$no_invoice = "INVPNJ$id_penjualan";                                      
mysqli_query($koneksi, "UPDATE penjualan SET no_invoice='$no_invoice' WHERE id_penjualan='$id_penjualan'");                                      
  }   
  }  
if($idpelanggan==""){
$idpelanggan = "$no_invoice";
 mysqli_query($koneksi, "UPDATE penjualan SET tanggal='$tanggal', id_pelanggan='$idpelanggan' WHERE id_penjualan='$id_penjualan'");
 $db->rawQuery("UPDATE transaksi_penjualan SET id_pelanggan='$idpelanggan', id_penjualan='$id_penjualan',no_invoice='$no_invoice' WHERE id_transaksi_penjualan='$rec_id'");
}else{
    $querypl = mysqli_query($koneksi, "SELECT * from pelanggan where id='$idpelanggan'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rowspl = mysqli_num_rows($querypl);
  if ($rowspl <> 0) {
    $datapl      = mysqli_fetch_assoc($querypl);
    $idpelanggan = $datapl['id'];
   $nama_pelanggan = $datapl['nama_pelanggan'];
   $alamat         = $datapl['alamat'];
   $phone = $datapl['phone'];
   mysqli_query($koneksi, "UPDATE penjualan SET tanggal='$tanggal', id_pelanggan='$idpelanggan', nama_pelanggan='$nama_pelanggan',alamat='$alamat',no_hp='$phone' WHERE id_penjualan='$id_penjualan'");
   $db->rawQuery("UPDATE transaksi_penjualan SET id_pelanggan='$idpelanggan', nama_pelanggan='$nama_pelanggan',alamat='$alamat',no_hp='$phone', id_penjualan='$id_penjualan',no_invoice='$no_invoice' WHERE id_transaksi_penjualan='$rec_id'");
}    
}
$totalharga = $harga_jual * $jumlahpost;
$db->rawQuery("UPDATE transaksi_penjualan SET id_barang='$idbarang', kode_barang='$kode_barang', nama_barang='$nama_barang',harga='$harga_jual',total_harga='$totalharga ', id_jual='$idtrace', id_data_setok='$iddata' WHERE id_transaksi_penjualan='$rec_id'");
$queryb = mysqli_query($koneksi, "SELECT * from data_setok where id='$iddata'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rowsb  = mysqli_num_rows($queryb);
  if ($rowsb <> 0) {
      $datab   = mysqli_fetch_assoc($queryb);
      $jumlahb = $datab['jumlah'];
   $stok   = $jumlahb - $jumlahpost;
   $queryb = mysqli_query($koneksi, "UPDATE data_setok SET jumlah='$stok' where id='$iddata'");
}
return  $this->redirect("transaksi_penjualan/penjualan");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("transaksi_penjualan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Transaksi Penjualan";
		$this->render_view("transaksi_penjualan/penjualan.php");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function pelanggan($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("id_jual");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
			);
			$this->sanitize_array = array(
				'id_jual' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("transaksi_penjualan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Transaksi Penjualan";
		$this->render_view("transaksi_penjualan/pelanggan.php");
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
			$fields = $this->fields = array("id_penjualan","id_pelanggan","tanggal","nama_pelanggan","alamat","no_hp","kode_barang","nama_barang","jumlah","harga","total_harga","diskon","total_bayar","ppn","nama_poli","operator","date_created","date_updated","id_jual","no_invoice","id_barang","id_data_setok");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_penjualan' => 'required',
				'id_pelanggan' => 'required',
				'tanggal' => 'required',
				'nama_pelanggan' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'jumlah' => 'required|numeric',
				'harga' => 'required|numeric',
				'total_harga' => 'required|numeric',
				'diskon' => 'required|numeric',
				'total_bayar' => 'required|numeric',
				'ppn' => 'required|numeric',
				'nama_poli' => 'required',
				'operator' => 'required|numeric',
				'date_created' => 'required',
				'date_updated' => 'required',
				'id_jual' => 'required',
				'no_invoice' => 'required',
				'id_barang' => 'required|numeric',
				'id_data_setok' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'id_penjualan' => 'sanitize_string',
				'id_pelanggan' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'nama_pelanggan' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'jumlah' => 'sanitize_string',
				'harga' => 'sanitize_string',
				'total_harga' => 'sanitize_string',
				'diskon' => 'sanitize_string',
				'total_bayar' => 'sanitize_string',
				'ppn' => 'sanitize_string',
				'nama_poli' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'date_created' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
				'id_jual' => 'sanitize_string',
				'no_invoice' => 'sanitize_string',
				'id_barang' => 'sanitize_string',
				'id_data_setok' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("transaksi_penjualan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Transaksi Penjualan";
		$this->render_view("transaksi_penjualan/proses.php");
	}
}
