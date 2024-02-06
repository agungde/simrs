<?php 
/**
 * Permintaan_harga Page Controller
 * @category  Controller
 */
class Permintaan_hargaController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "permintaan_harga";
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
		$fields = array("permintaan_harga.id", 
			"permintaan_harga.tanggal", 
			"permintaan_harga.no_request", 
			"permintaan_harga.id_suplier", 
			"permintaan_harga.nama_suplier", 
			"permintaan_harga.action", 
			"permintaan_harga.alamat", 
			"permintaan_harga.no_hp", 
			"permintaan_harga.email", 
			"permintaan_harga.category_barang", 
			"category_barang.category AS category_barang_category", 
			"permintaan_harga.total_jumlah", 
			"permintaan_harga.operator", 
			"user_login.nama AS user_login_nama", 
			"permintaan_harga.setatus", 
			"permintaan_harga.date_created", 
			"permintaan_harga.date_updated");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				permintaan_harga.id LIKE ? OR 
				permintaan_harga.tanggal LIKE ? OR 
				permintaan_harga.no_request LIKE ? OR 
				permintaan_harga.id_suplier LIKE ? OR 
				permintaan_harga.nama_suplier LIKE ? OR 
				permintaan_harga.action LIKE ? OR 
				permintaan_harga.alamat LIKE ? OR 
				permintaan_harga.no_hp LIKE ? OR 
				permintaan_harga.email LIKE ? OR 
				permintaan_harga.category_barang LIKE ? OR 
				permintaan_harga.total_jumlah LIKE ? OR 
				permintaan_harga.operator LIKE ? OR 
				permintaan_harga.setatus LIKE ? OR 
				permintaan_harga.date_created LIKE ? OR 
				permintaan_harga.date_updated LIKE ? OR 
				permintaan_harga.idtrace LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "permintaan_harga/search.php";
		}
		$db->join("category_barang", "permintaan_harga.category_barang = category_barang.id", "INNER");
		$db->join("user_login", "permintaan_harga.operator = user_login.id_userlogin", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("permintaan_harga.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Permintaan Harga";
		$view_name = (is_ajax() ? "permintaan_harga/ajax-list.php" : "permintaan_harga/list.php");
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
		$fields = array("permintaan_harga.id", 
			"permintaan_harga.tanggal", 
			"permintaan_harga.no_request", 
			"permintaan_harga.id_suplier", 
			"permintaan_harga.nama_suplier", 
			"permintaan_harga.alamat", 
			"permintaan_harga.no_hp", 
			"permintaan_harga.email", 
			"permintaan_harga.category_barang", 
			"category_barang.category AS category_barang_category", 
			"permintaan_harga.total_jumlah", 
			"permintaan_harga.operator", 
			"user_login.nama AS user_login_nama", 
			"permintaan_harga.setatus", 
			"permintaan_harga.date_created", 
			"permintaan_harga.date_updated", 
			"permintaan_harga.action");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("permintaan_harga.id", $rec_id);; //select record based on primary key
		}
		$db->join("category_barang", "permintaan_harga.category_barang = category_barang.id", "INNER");
		$db->join("user_login", "permintaan_harga.operator = user_login.id_userlogin", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Permintaan Harga";
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
		return $this->render_view("permintaan_harga/view.php", $record);
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
			$fields = $this->fields = array("tanggal","nama_suplier","category_barang","no_request");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'nama_suplier' => 'required',
				'category_barang' => 'required',
				'no_request' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'nama_suplier' => 'sanitize_string',
				'category_barang' => 'sanitize_string',
				'no_request' => 'sanitize_string',
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
$norequest      = $_POST['no_request'];
$namasuplier    = $_POST['nama_suplier'];
$tanggal        = $_POST['tanggal'];
$categorybarang = $_POST['category_barang'];
$query = mysqli_query($koneksi, "SELECT * from permintaan_harga where no_request='$norequest'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rows = mysqli_num_rows($query);
  // cek hasil query
  // jika "no_antrian" sudah ada
  if ($rows <> 0) {
    // ambil data hasil query
    // $data        = mysqli_fetch_assoc($query);
    // $idbarang = $data['id_barang'];
    // $kode_barang = $data['kode_barang'];
    // $nama_barang = $data['nama_barang'];
    // $satuan      = $data['satuan'];
    // $harga_beli  = $data['harga_beli'];  
    // $harga_jual = $data['harga_jual'];  
    // $jumlah     = $data['jumlah'];
    // if($jumlah<1){
        $this->set_flash_msg("Permintaan Harga Sudah di Input!!", "danger");
        return  $this->redirect("permintaan_harga");
    // }
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
$norequest      = $_POST['no_request'];
$namasuplier    = $_POST['nama_suplier'];
$tanggal        = $_POST['tanggal'];
$categorybarang = $_POST['category_barang'];
$query = mysqli_query($koneksi, "SELECT * from data_suplier where id_suplier='$namasuplier'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows = mysqli_num_rows($query);
  if ($rows <> 0) {
     $data    = mysqli_fetch_assoc($query);
     $idsup   = $data['id_suplier'];
     $namasup = $data['nama'];
     $alamat  = $data['alamat'];
     $no_hp   = $data['no_hp'];
     $email   = $data['email'];
    // $harga_beli  = $data['harga_beli'];  
    // $harga_jual = $data['harga_jual'];  
    // $jumlah     = $data['jumlah'];
    // if($jumlah<1){
        // $this->set_flash_msg("Permintaan Sudah di Input!!", "danger");
        // return  $this->redirect("transaksi_penjualan/penjualan");
    // }
    $db->rawQuery("UPDATE permintaan_harga SET email='$email', id_suplier='$idsup', nama_suplier='$namasup', alamat='$alamat', no_hp='$no_hp' WHERE id='$rec_id'");
    }
$query1 = mysqli_query($koneksi, "SELECT * from data_permintaan_barang where no_request='$norequest'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rows1 = mysqli_num_rows($query1);
  if ($rows1 <> 0) {
      // $data1 = mysqli_fetch_assoc($query1);
      while ($datapp = MySQLi_fetch_array($query1)) {
          mysqli_query($koneksi, "INSERT INTO `data_permintaan_harga`(`id_permintaan_harga`, `no_request`, `tanggal`, `id_suplier`, `nama_suplier`, `alamat`, `no_hp`, `email`, `kode_barang`, `nama_barang`, `category_barang`, `jumlah`, `operator`) VALUES ('$rec_id','$norequest','$tanggal','$idsup','$namasup','$alamat','$no_hp','$email','".$datapp['kode_barang']."','".$datapp['nama_barang']."','".$datapp['category_barang']."','".$datapp['jumlah']."','$id_user')");
      }
 }
 $queryjum = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jum from data_permintaan_barang WHERE no_request='$norequest'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$sumjum = mysqli_fetch_assoc($queryjum); 
$totjum=$sumjum['jum'];
mysqli_query($koneksi, "UPDATE permintaan_harga SET operator='$id_user', total_jumlah='$totjum', setatus='Register' WHERE no_request='$norequest'"); 
mysqli_query($koneksi, "UPDATE permintaan_barang SET setatus='Closed' WHERE no_request='$norequest'"); 
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("permintaan_harga");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Permintaan Harga";
		$this->render_view("permintaan_harga/add.php");
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
		$fields = $this->fields = array("id","tanggal","nama_suplier","category_barang","no_request");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'nama_suplier' => 'required',
				'category_barang' => 'required',
				'no_request' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'nama_suplier' => 'sanitize_string',
				'category_barang' => 'sanitize_string',
				'no_request' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("permintaan_harga.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("permintaan_harga");
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
						return	$this->redirect("permintaan_harga");
					}
				}
			}
		}
		$db->where("permintaan_harga.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Permintaan Harga";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("permintaan_harga/edit.php", $data);
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
		$db->where("permintaan_harga.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("permintaan_harga");
	}
}
