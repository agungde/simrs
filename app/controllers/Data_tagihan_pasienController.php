<?php 
/**
 * Data_tagihan_pasien Page Controller
 * @category  Controller
 */
class Data_tagihan_pasienController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "data_tagihan_pasien";
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
			"tanggal", 
			"no_rekam_medis", 
			"pasien", 
			"keterangan", 
			"total_tagihan", 
			"setatus");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				data_tagihan_pasien.id LIKE ? OR 
				data_tagihan_pasien.id_data LIKE ? OR 
				data_tagihan_pasien.tanggal LIKE ? OR 
				data_tagihan_pasien.no_rekam_medis LIKE ? OR 
				data_tagihan_pasien.pasien LIKE ? OR 
				data_tagihan_pasien.nama_tagihan LIKE ? OR 
				data_tagihan_pasien.keterangan LIKE ? OR 
				data_tagihan_pasien.total_tagihan LIKE ? OR 
				data_tagihan_pasien.date_created LIKE ? OR 
				data_tagihan_pasien.setatus LIKE ? OR 
				data_tagihan_pasien.id_transaksi LIKE ? OR 
				data_tagihan_pasien.no_tag LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "data_tagihan_pasien/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("data_tagihan_pasien.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		if(!empty($request->data_tagihan_pasien_tanggal)){
			$vals = explode("-to-", str_replace(" ", "", $request->data_tagihan_pasien_tanggal));
			$startdate = $vals[0];
			$enddate = $vals[1];
			$db->where("data_tagihan_pasien.tanggal BETWEEN '$startdate' AND '$enddate'");
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
		$page_title = $this->view->page_title = "Data Pendapatan";
		$view_name = (is_ajax() ? "data_tagihan_pasien/ajax-list.php" : "data_tagihan_pasien/list.php");
		$this->render_view($view_name, $data);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function embalase($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("id_data","nama_tagihan","pasien","tanggal","total_tagihan","no_rekam_medis","setatus","id_transaksi","keterangan");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_data' => 'required',
				'nama_tagihan' => 'required',
				'pasien' => 'required',
				'tanggal' => 'required',
				'total_tagihan' => 'required|numeric',
				'no_rekam_medis' => 'required',
				'setatus' => 'required',
				'id_transaksi' => 'required',
				'keterangan' => 'required',
			);
			$this->sanitize_array = array(
				'id_data' => 'sanitize_string',
				'nama_tagihan' => 'sanitize_string',
				'pasien' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'total_tagihan' => 'sanitize_string',
				'no_rekam_medis' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'id_transaksi' => 'sanitize_string',
				'keterangan' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
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
 $id_transaksi = $_POST['id_transaksi'];
 $totag        = $_POST['total_tagihan'];
 $totr         = $_POST['tagihan_r'];
 $totall       = $totag + $totr;
 $quetrx= mysqli_query($koneksi, "select * from transaksi WHERE id='$id_transaksi'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rotrx = mysqli_num_rows($quetrx);
  if ($rotrx <> 0) {
        $dattrx      = mysqli_fetch_assoc($quetrx);
        $idtrx       = $dattrx['id'];  
        $tottagawal  = $dattrx['total_tagihan'];
        $tottagakhir = $tottagawal + $totall;
        mysqli_query($koneksi, "UPDATE transaksi SET total_tagihan='$tottagakhir' WHERE id='$idtrx'"); 
  } 
    mysqli_query($koneksi, "INSERT INTO `data_tagihan_pasien`(`id_transaksi`, `id_data`, `nama_tagihan`, `keterangan`, `tanggal`, `no_rekam_medis`, `pasien`, `setatus`, `total_tagihan`) VALUES ('$id_transaksi','".$_POST['id_data']."','Tambahan','Tagihan Tambahan','".$_POST['tanggal']."','".$_POST['no_rekam_medis']."','".$_POST['pasien']."','Register','$totr')"); 
$this->set_flash_msg("Tagihan Embalase Berhasil Di Simpan!! ", "success");
return  $this->redirect("transaksi");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("data_tagihan_pasien");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Data Tagihan Pasien";
		$this->render_view("data_tagihan_pasien/embalase.php");
	}
}
