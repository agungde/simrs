<?php 
/**
 * Transaksi Page Controller
 * @category  Controller
 */
class TransaksiController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "transaksi";
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
		$fields = array("transaksi.id", 
			"transaksi.id_exsternal", 
			"transaksi.no_invoice", 
			"transaksi.tanggal", 
			"transaksi.no_rekam_medis", 
			"transaksi.nama_pasien", 
			"transaksi.action", 
			"transaksi.setatus_tagihan", 
			"transaksi.pembayaran", 
			"data_bank.nama_bank AS data_bank_nama_bank", 
			"transaksi.setatus_bpjs", 
			"transaksi.total_tagihan", 
			"transaksi.deposit", 
			"transaksi.sisa_tagihan", 
			"transaksi.poli");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(!empty($request->transaksi_setatus)){
    $set = $request->transaksi_setatus;
if(!empty($request->transaksi_tanggal)){
    $val = $request->transaksi_tanggal;
    $db->where("setatus_tagihan='$set' and DATE(transaksi.tanggal)", $val , "=");
    }else{
        $db->where("setatus_tagihan='$set'");
    }
    // $db->where("setatus_tagihan='$set' and DATE(transaksi.tanggal)", $val , "=");
        }
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				transaksi.id LIKE ? OR 
				transaksi.id_exsternal LIKE ? OR 
				transaksi.no_invoice LIKE ? OR 
				transaksi.tanggal LIKE ? OR 
				transaksi.no_rekam_medis LIKE ? OR 
				transaksi.nama_pasien LIKE ? OR 
				transaksi.alamat LIKE ? OR 
				transaksi.no_hp LIKE ? OR 
				transaksi.action LIKE ? OR 
				transaksi.setatus_tagihan LIKE ? OR 
				transaksi.pembayaran LIKE ? OR 
				transaksi.setatus_bpjs LIKE ? OR 
				transaksi.total_tagihan LIKE ? OR 
				transaksi.deposit LIKE ? OR 
				transaksi.sisa_tagihan LIKE ? OR 
				transaksi.bayar LIKE ? OR 
				transaksi.pasien LIKE ? OR 
				transaksi.poli LIKE ? OR 
				transaksi.kembalian LIKE ? OR 
				transaksi.transaksi LIKE ? OR 
				transaksi.operator LIKE ? OR 
				transaksi.date_created LIKE ? OR 
				transaksi.date_updated LIKE ? OR 
				transaksi.kas_awal LIKE ? OR 
				transaksi.kas_akhir LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "transaksi/search.php";
		}
		$db->join("data_bank", "transaksi.pembayaran = data_bank.id_databank", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("transaksi.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Transaksi";
		$view_name = (is_ajax() ? "transaksi/ajax-list.php" : "transaksi/list.php");
		$this->render_view($view_name, $data);
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
			$fields = $this->fields = array("no_invoice","tanggal","no_rekam_medis","nama_pasien","alamat","no_hp","pasien","poli","pembayaran","setatus_bpjs","deposit","sisa_tagihan","bayar","kembalian","setatus_tagihan","transaksi","operator","date_updated","action","kas_awal","kas_akhir","total_tagihan");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'no_invoice' => 'required',
				'tanggal' => 'required',
				'no_rekam_medis' => 'required',
				'nama_pasien' => 'required',
				'alamat' => 'required',
				'no_hp' => 'required',
				'pasien' => 'required',
				'poli' => 'required',
				'pembayaran' => 'required|numeric',
				'setatus_bpjs' => 'required',
				'deposit' => 'required|numeric',
				'sisa_tagihan' => 'required|numeric',
				'bayar' => 'required|numeric',
				'kembalian' => 'required|numeric',
				'setatus_tagihan' => 'required',
				'transaksi' => 'required',
				'operator' => 'required|numeric',
				'date_updated' => 'required',
				'action' => 'required',
				'kas_awal' => 'required|numeric',
				'kas_akhir' => 'required|numeric',
				'total_tagihan' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'no_invoice' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'nama_pasien' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'poli' => 'sanitize_string',
				'pembayaran' => 'sanitize_string',
				'setatus_bpjs' => 'sanitize_string',
				'deposit' => 'sanitize_string',
				'sisa_tagihan' => 'sanitize_string',
				'bayar' => 'sanitize_string',
				'kembalian' => 'sanitize_string',
				'setatus_tagihan' => 'sanitize_string',
				'transaksi' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
				'action' => 'sanitize_string',
				'kas_awal' => 'sanitize_string',
				'kas_akhir' => 'sanitize_string',
				'total_tagihan' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("transaksi");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Transaksi";
		$this->render_view("transaksi/add.php");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function invoice($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"no_invoice", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"no_hp", 
			"pasien", 
			"poli", 
			"pembayaran", 
			"setatus_bpjs", 
			"deposit", 
			"sisa_tagihan", 
			"bayar", 
			"kembalian", 
			"setatus_tagihan", 
			"transaksi", 
			"operator", 
			"date_created", 
			"date_updated", 
			"action", 
			"kas_awal", 
			"kas_akhir", 
			"id_exsternal", 
			"total_tagihan");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				transaksi.id LIKE ? OR 
				transaksi.no_invoice LIKE ? OR 
				transaksi.tanggal LIKE ? OR 
				transaksi.no_rekam_medis LIKE ? OR 
				transaksi.nama_pasien LIKE ? OR 
				transaksi.alamat LIKE ? OR 
				transaksi.no_hp LIKE ? OR 
				transaksi.pasien LIKE ? OR 
				transaksi.poli LIKE ? OR 
				transaksi.pembayaran LIKE ? OR 
				transaksi.setatus_bpjs LIKE ? OR 
				transaksi.deposit LIKE ? OR 
				transaksi.sisa_tagihan LIKE ? OR 
				transaksi.bayar LIKE ? OR 
				transaksi.kembalian LIKE ? OR 
				transaksi.setatus_tagihan LIKE ? OR 
				transaksi.transaksi LIKE ? OR 
				transaksi.operator LIKE ? OR 
				transaksi.date_created LIKE ? OR 
				transaksi.date_updated LIKE ? OR 
				transaksi.action LIKE ? OR 
				transaksi.kas_awal LIKE ? OR 
				transaksi.kas_akhir LIKE ? OR 
				transaksi.id_exsternal LIKE ? OR 
				transaksi.total_tagihan LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "transaksi/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("transaksi.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Transaksi";
		$this->render_view("transaksi/invoice.php", $data); //render the full page
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function deposit($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"no_invoice", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"no_hp", 
			"pasien", 
			"poli", 
			"pembayaran", 
			"setatus_bpjs", 
			"deposit", 
			"sisa_tagihan", 
			"bayar", 
			"kembalian", 
			"setatus_tagihan", 
			"transaksi", 
			"operator", 
			"date_created", 
			"date_updated", 
			"action", 
			"kas_awal", 
			"kas_akhir", 
			"id_exsternal", 
			"total_tagihan");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				transaksi.id LIKE ? OR 
				transaksi.no_invoice LIKE ? OR 
				transaksi.tanggal LIKE ? OR 
				transaksi.no_rekam_medis LIKE ? OR 
				transaksi.nama_pasien LIKE ? OR 
				transaksi.alamat LIKE ? OR 
				transaksi.no_hp LIKE ? OR 
				transaksi.pasien LIKE ? OR 
				transaksi.poli LIKE ? OR 
				transaksi.pembayaran LIKE ? OR 
				transaksi.setatus_bpjs LIKE ? OR 
				transaksi.deposit LIKE ? OR 
				transaksi.sisa_tagihan LIKE ? OR 
				transaksi.bayar LIKE ? OR 
				transaksi.kembalian LIKE ? OR 
				transaksi.setatus_tagihan LIKE ? OR 
				transaksi.transaksi LIKE ? OR 
				transaksi.operator LIKE ? OR 
				transaksi.date_created LIKE ? OR 
				transaksi.date_updated LIKE ? OR 
				transaksi.action LIKE ? OR 
				transaksi.kas_awal LIKE ? OR 
				transaksi.kas_akhir LIKE ? OR 
				transaksi.id_exsternal LIKE ? OR 
				transaksi.total_tagihan LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "transaksi/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("transaksi.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Transaksi";
		$this->render_view("transaksi/deposit.php", $data); //render the full page
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function proses($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"no_invoice", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"no_hp", 
			"pasien", 
			"poli", 
			"pembayaran", 
			"setatus_bpjs", 
			"deposit", 
			"sisa_tagihan", 
			"bayar", 
			"kembalian", 
			"setatus_tagihan", 
			"transaksi", 
			"operator", 
			"date_created", 
			"date_updated", 
			"action", 
			"kas_awal", 
			"kas_akhir", 
			"id_exsternal", 
			"total_tagihan");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				transaksi.id LIKE ? OR 
				transaksi.no_invoice LIKE ? OR 
				transaksi.tanggal LIKE ? OR 
				transaksi.no_rekam_medis LIKE ? OR 
				transaksi.nama_pasien LIKE ? OR 
				transaksi.alamat LIKE ? OR 
				transaksi.no_hp LIKE ? OR 
				transaksi.pasien LIKE ? OR 
				transaksi.poli LIKE ? OR 
				transaksi.pembayaran LIKE ? OR 
				transaksi.setatus_bpjs LIKE ? OR 
				transaksi.deposit LIKE ? OR 
				transaksi.sisa_tagihan LIKE ? OR 
				transaksi.bayar LIKE ? OR 
				transaksi.kembalian LIKE ? OR 
				transaksi.setatus_tagihan LIKE ? OR 
				transaksi.transaksi LIKE ? OR 
				transaksi.operator LIKE ? OR 
				transaksi.date_created LIKE ? OR 
				transaksi.date_updated LIKE ? OR 
				transaksi.action LIKE ? OR 
				transaksi.kas_awal LIKE ? OR 
				transaksi.kas_akhir LIKE ? OR 
				transaksi.id_exsternal LIKE ? OR 
				transaksi.total_tagihan LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "transaksi/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("transaksi.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Transaksi";
		$this->render_view("transaksi/proses.php", $data); //render the full page
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function debet($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal","kas_awal");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'kas_awal' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'kas_awal' => 'sanitize_string',
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
$koneksi    = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$tanggal    = $_POST['tanggal'];
$keterangan = trim($_POST['keterangan']);
$kas_awal   = $_POST['kas_awal'];
$nama       = $_POST['nama'];
$type_kas       = $_POST['type_kas'];
$query = mysqli_query($koneksi, "SELECT * FROM `kas` ORDER BY `id` DESC")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
 $rows = mysqli_num_rows($query);
  if ($rows <> 0) {
      $datacek= mysqli_fetch_assoc($query);
     $saldoawal = $datacek['saldo'];
     }else{
         $saldoawal = "0";
     }
     $saldoahir = $saldoawal + $kas_awal;
     mysqli_query($koneksi, "INSERT INTO `kas`(`tanggal`, `debet`, `keterangan`, `saldo`, `kasir`, `setatus`, `kas_awal`, `transaksi`, `saldo_cash`) VALUES ('$tanggal','$kas_awal','$keterangan','$saldoahir','$nama','Register','$kas_awal','$type_kas','$kas_awal')"); 
$this->set_flash_msg("Kas Awal Berhasil Di Simpan!! ", "success");
 return  $this->redirect("kas");
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("transaksi");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Transaksi";
		$this->render_view("transaksi/debet.php");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function kredit($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
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
$koneksi    = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$tanggal    = $_POST['tanggal'];
$keterangan = trim($_POST['keterangan']);
$jumlah     = $_POST['jumlah'];
$sisa_saldo = $_POST['sisa_saldo'];
$type_kas   = $_POST['type_kas'];
$query = mysqli_query($koneksi, "SELECT * FROM `kas` ORDER BY `id` DESC")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
 $rows = mysqli_num_rows($query);
  if ($rows <> 0) {
      $datacek = mysqli_fetch_assoc($query);
      $sal     = $datacek['saldo'];
     }
  $sisal = $sal - $jumlah;
  mysqli_query($koneksi, "INSERT INTO `kas`(`tanggal`, `kredit`, `keterangan`, `saldo`,`setatus`, `transaksi`, `saldo_cash`, `kas_awal`) VALUES ('$tanggal','$jumlah','$keterangan','$sisal','Register','$type_kas','$sisa_saldo','$sisa_saldo')"); 
$this->set_flash_msg("Penarikan Kas Tunai Berhasil!! ", "success");
 return  $this->redirect("kas");
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("transaksi");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Transaksi";
		$this->render_view("transaksi/kredit.php");
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function shift($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal","kas_awal","kas_akhir");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'kas_awal' => 'required|numeric',
				'kas_akhir' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'kas_awal' => 'sanitize_string',
				'kas_akhir' => 'sanitize_string',
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
$koneksi    = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$tanggal    = $_POST['tanggal'];
$keterangan = "Serah Terima Shift Kasir";
$kas_awal   = $_POST['kas_awal'];
$nama       = $_POST['nama'];
$querya = mysqli_query($koneksi, "SELECT * FROM `kas` ORDER BY `id` DESC")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                  $rowsa = mysqli_num_rows($querya);
                                  if ($rowsa <> 0) {
                                      $dataceka = mysqli_fetch_assoc($querya);
                                      $saldo    = $dataceka['saldo'];
     }
  mysqli_query($koneksi, "INSERT INTO `kas`(`keterangan`,`tanggal`, `saldo`, `kasir`, `setatus`, `kas_awal`, `saldo_cash`, `transaksi`) VALUES ('Serah Terima Shift Dan Kas Awal','$tanggal','$saldo','$nama','Register','$kas_awal','$kas_awal','2')"); 
  mysqli_query($koneksi, "UPDATE `kas` SET `setatus`='Closed' WHERE `kasir`=$id_user");    
     $this->set_flash_msg("Serah Terima Shift Kasir Berhasil Di Proses!! ", "success");
     session_unset();
$query = mysqli_query($koneksi, "SELECT * FROM `user_login` where id_userlogin='$nama'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
 $rows = mysqli_num_rows($query);
  if ($rows <> 0) {
      //  $datacek= mysqli_fetch_assoc($query);
     $userkasir = mysqli_fetch_array($query);
   set_session("user_data",  $userkasir);
  }
return  $this->redirect("transaksi");
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("transaksi");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Transaksi";
		$this->render_view("transaksi/shift.php");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function bpjs($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"no_invoice", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"no_hp", 
			"pasien", 
			"poli", 
			"pembayaran", 
			"setatus_bpjs", 
			"deposit", 
			"sisa_tagihan", 
			"bayar", 
			"kembalian", 
			"setatus_tagihan", 
			"transaksi", 
			"operator", 
			"date_created", 
			"date_updated", 
			"action", 
			"kas_awal", 
			"kas_akhir", 
			"id_exsternal", 
			"total_tagihan");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				transaksi.id LIKE ? OR 
				transaksi.no_invoice LIKE ? OR 
				transaksi.tanggal LIKE ? OR 
				transaksi.no_rekam_medis LIKE ? OR 
				transaksi.nama_pasien LIKE ? OR 
				transaksi.alamat LIKE ? OR 
				transaksi.no_hp LIKE ? OR 
				transaksi.pasien LIKE ? OR 
				transaksi.poli LIKE ? OR 
				transaksi.pembayaran LIKE ? OR 
				transaksi.setatus_bpjs LIKE ? OR 
				transaksi.deposit LIKE ? OR 
				transaksi.sisa_tagihan LIKE ? OR 
				transaksi.bayar LIKE ? OR 
				transaksi.kembalian LIKE ? OR 
				transaksi.setatus_tagihan LIKE ? OR 
				transaksi.transaksi LIKE ? OR 
				transaksi.operator LIKE ? OR 
				transaksi.date_created LIKE ? OR 
				transaksi.date_updated LIKE ? OR 
				transaksi.action LIKE ? OR 
				transaksi.kas_awal LIKE ? OR 
				transaksi.kas_akhir LIKE ? OR 
				transaksi.id_exsternal LIKE ? OR 
				transaksi.total_tagihan LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "transaksi/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("transaksi.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Transaksi";
		$this->render_view("transaksi/bpjs.php", $data); //render the full page
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function pay($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"no_invoice", 
			"tanggal", 
			"no_rekam_medis", 
			"nama_pasien", 
			"alamat", 
			"no_hp", 
			"pasien", 
			"poli", 
			"pembayaran", 
			"setatus_bpjs", 
			"deposit", 
			"sisa_tagihan", 
			"bayar", 
			"kembalian", 
			"setatus_tagihan", 
			"transaksi", 
			"operator", 
			"date_created", 
			"date_updated", 
			"action", 
			"kas_awal", 
			"kas_akhir", 
			"id_exsternal", 
			"total_tagihan");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				transaksi.id LIKE ? OR 
				transaksi.no_invoice LIKE ? OR 
				transaksi.tanggal LIKE ? OR 
				transaksi.no_rekam_medis LIKE ? OR 
				transaksi.nama_pasien LIKE ? OR 
				transaksi.alamat LIKE ? OR 
				transaksi.no_hp LIKE ? OR 
				transaksi.pasien LIKE ? OR 
				transaksi.poli LIKE ? OR 
				transaksi.pembayaran LIKE ? OR 
				transaksi.setatus_bpjs LIKE ? OR 
				transaksi.deposit LIKE ? OR 
				transaksi.sisa_tagihan LIKE ? OR 
				transaksi.bayar LIKE ? OR 
				transaksi.kembalian LIKE ? OR 
				transaksi.setatus_tagihan LIKE ? OR 
				transaksi.transaksi LIKE ? OR 
				transaksi.operator LIKE ? OR 
				transaksi.date_created LIKE ? OR 
				transaksi.date_updated LIKE ? OR 
				transaksi.action LIKE ? OR 
				transaksi.kas_awal LIKE ? OR 
				transaksi.kas_akhir LIKE ? OR 
				transaksi.id_exsternal LIKE ? OR 
				transaksi.total_tagihan LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "transaksi/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("transaksi.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Transaksi";
		$this->render_view("transaksi/pay.php", $data); //render the full page
	}
}
