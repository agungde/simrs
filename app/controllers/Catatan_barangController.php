<?php 
/**
 * Catatan_barang Page Controller
 * @category  Controller
 */
class Catatan_barangController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "catatan_barang";
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
		$fields = array("catatan_barang.id", 
			"catatan_barang.tanggal", 
			"catatan_barang.kode_barang", 
			"catatan_barang.nama_barang", 
			"catatan_barang.category_barang", 
			"category_barang.category AS category_barang_category", 
			"catatan_barang.jumlah", 
			"catatan_barang.divisi", 
			"catatan_barang.bagian", 
			"catatan_barang.keterangan", 
			"catatan_barang.setatus", 
			"catatan_barang.date_created", 
			"catatan_barang.lap", 
			"catatan_barang.id_data_setok");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	     if(USER_ROLE==8){
        $divisi = "IGD";
        $bag    = "IGD";
        $db->where("divisi='$divisi' AND bagian='$bag' and setatus='Closed'");      
 }else if(USER_ROLE==6){
       $divisi = "POLI";
       $bag    = $_SESSION[APP_ID.'user_data']['admin_poli'];
       $db->where("divisi='$divisi' AND bagian='$bag' and setatus='Closed'");     
       }else  if(USER_ROLE==13){
$divisi = "RANAP";
$bag    = $_SESSION[APP_ID.'user_data']['admin_ranap'];   
 $db->where("divisi='$divisi' AND bagian='$bag' and setatus='Closed'");  
 }else  if(USER_ROLE==5){
     $divisi = "FARMASI";
     $bag    = "FARMASI";
     $db->where("divisi='$divisi' AND bagian='$bag' and setatus='Closed'");      
  }else  if(USER_ROLE==20){
      $divisi = "GUDANG";
      $bag    = "GUDANG";
      $db->where("divisi='$divisi' AND bagian='$bag' and setatus='Closed'");      
       }
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				catatan_barang.id LIKE ? OR 
				catatan_barang.tanggal LIKE ? OR 
				catatan_barang.kode_barang LIKE ? OR 
				catatan_barang.nama_barang LIKE ? OR 
				catatan_barang.category_barang LIKE ? OR 
				catatan_barang.jumlah LIKE ? OR 
				catatan_barang.divisi LIKE ? OR 
				catatan_barang.bagian LIKE ? OR 
				catatan_barang.keterangan LIKE ? OR 
				catatan_barang.operator LIKE ? OR 
				catatan_barang.setatus LIKE ? OR 
				catatan_barang.date_created LIKE ? OR 
				catatan_barang.date_updated LIKE ? OR 
				catatan_barang.lap LIKE ? OR 
				catatan_barang.id_data_setok LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "catatan_barang/search.php";
		}
		$db->join("category_barang", "catatan_barang.category_barang = category_barang.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("catatan_barang.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Catatan Barang";
		$this->render_view("catatan_barang/list.php", $data); //render the full page
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
			$fields = $this->fields = array("tanggal","kode_barang","nama_barang","category_barang","jumlah","divisi","bagian","keterangan","operator","id_data_setok");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'category_barang' => 'required',
				'jumlah' => 'required|numeric',
				'divisi' => 'required',
				'bagian' => 'required',
				'keterangan' => 'required',
				'operator' => 'required',
				'id_data_setok' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'category_barang' => 'sanitize_string',
				'jumlah' => 'sanitize_string',
				'divisi' => 'sanitize_string',
				'bagian' => 'sanitize_string',
				'keterangan' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'id_data_setok' => 'sanitize_string',
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
$linksite="".SITE_ADDR;
$nambar      = $_POST['nama_barang'];
$divisi      = $_POST['divisi'];
$bagian      = $_POST['bagian'];
$jumpos      = $_POST['jumlah'];
$tanggal     = $_POST['tanggal'];
$id_data_setok = $_POST['id_data_setok'];
  $sqldat = mysqli_query($koneksi,"select * from catatan_barang WHERE id_data_setok='$id_data_setok' and tanggal='$tanggal'");
$rodat = mysqli_num_rows($sqldat);
if ($rodat <> 0) {
    $this->set_flash_msg("Nama Barang ($nambar) Divisi $divisi Bagian $bagian  Sudah Di Input!!", "danger");
        return  $this->redirect("catatan_barang/add");
    }
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("catatan_barang");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Catatan Barang";
		$this->render_view("catatan_barang/add.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function catatan($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","tanggal","kode_barang","nama_barang","jumlah","keterangan");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'jumlah' => 'required|numeric',
				'keterangan' => 'required',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'jumlah' => 'sanitize_string',
				'keterangan' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("catatan_barang.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("catatan_barang");
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
						return	$this->redirect("catatan_barang");
					}
				}
			}
		}
		$db->where("catatan_barang.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Catatan Barang";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("catatan_barang/catatan.php", $data);
	}
}
