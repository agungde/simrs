<?php 
/**
 * Laporan_setok Page Controller
 * @category  Controller
 */
class Laporan_setokController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "laporan_setok";
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
		$fields = array("laporan_setok.id", 
			"laporan_setok.tanggal", 
			"laporan_setok.kode_barang", 
			"laporan_setok.nama_barang", 
			"laporan_setok.category_barang", 
			"category_barang.category AS category_barang_category", 
			"laporan_setok.setok_awal", 
			"laporan_setok.keluar", 
			"laporan_setok.setok", 
			"laporan_setok.jumlah", 
			"laporan_setok.pending_keluar", 
			"laporan_setok.selisih", 
			"laporan_setok.divisi", 
			"laporan_setok.bagian", 
			"laporan_setok.date_created", 
			"laporan_setok.setatus", 
			"laporan_setok.id_data_setok", 
			"laporan_setok.id_data_resep", 
			"laporan_setok.jumlah_sistem");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	  $tanggal = gmdate("Y-m-d", time() + 60 * 60 * 7); 
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
     $db->where("divisi='$divisi' AND bagian='$bag' and setatus='Closed' and tanggal='$tanggal'");      
     }else{
         $db->where("setatus='Closed'"); 
     }
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				laporan_setok.id LIKE ? OR 
				laporan_setok.tanggal LIKE ? OR 
				laporan_setok.kode_barang LIKE ? OR 
				laporan_setok.nama_barang LIKE ? OR 
				laporan_setok.category_barang LIKE ? OR 
				laporan_setok.setok_awal LIKE ? OR 
				laporan_setok.keluar LIKE ? OR 
				laporan_setok.setok LIKE ? OR 
				laporan_setok.jumlah LIKE ? OR 
				laporan_setok.pending_keluar LIKE ? OR 
				laporan_setok.selisih LIKE ? OR 
				laporan_setok.divisi LIKE ? OR 
				laporan_setok.bagian LIKE ? OR 
				laporan_setok.operator LIKE ? OR 
				laporan_setok.date_created LIKE ? OR 
				laporan_setok.date_updated LIKE ? OR 
				laporan_setok.setatus LIKE ? OR 
				laporan_setok.id_data_setok LIKE ? OR 
				laporan_setok.id_data_resep LIKE ? OR 
				laporan_setok.jumlah_sistem LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "laporan_setok/search.php";
		}
		$db->join("category_barang", "laporan_setok.category_barang = category_barang.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("laporan_setok.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Laporan Setok";
		$this->render_view("laporan_setok/list.php", $data); //render the full page
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
			$fields = $this->fields = array("setok");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'setok' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'setok' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("laporan_setok");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Laporan Setok";
		$this->render_view("laporan_setok/add.php");
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
		$fields = $this->fields = array("id","kode_barang","nama_barang","setok","divisi","bagian");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'kode_barang' => 'required',
				'nama_barang' => 'required',
				'setok' => 'required|numeric',
				'divisi' => 'required',
				'bagian' => 'required',
			);
			$this->sanitize_array = array(
				'kode_barang' => 'sanitize_string',
				'nama_barang' => 'sanitize_string',
				'setok' => 'sanitize_string',
				'divisi' => 'sanitize_string',
				'bagian' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("laporan_setok.id", $rec_id);;
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
$sqla    = mysqli_query($koneksi, "SELECT * from laporan_setok WHERE id='$rec_id'");
  $roa  = mysqli_num_rows($sqla);
  if ($roa <> 0) {
     $rowa = mysqli_fetch_assoc($sqla); 
     // $kodes=$rowa['kode_barang'];
     $jumpen = $rowa['pending_keluar'];
     //   $cates=$rowa['category_barang'];
          $stkawals = $rowa['setok_awal'];
          $sets     = $rowa['setok'];
          $keluar   = $rowa['keluar'];
        $jums=$rowa['jumlah'];
}  
    ///$totout=$jumcat + $jumdat + $jumjual; //////total keluar//////
    //$jumpen= $pendingj + $pending;  
    //$jomtot=$jums + $jumpen; //////Jumlah sistem + Pending keluar//////
 if($sets >$jums){
     $setokitung=$sets - $jumpen; /////apabila setok actual lebih besar dari jumlah sistem maka di kurangi pending keluar///////
 }else{
    $setokitung=$sets;
 }
   $allset=$setokitung + $keluar;
    $jumsistem=$jomtot + $totout;  ///Jumlah sistem + jumlah keluar///
    $selisih=$stkawals - $allset;
 $db->rawQuery("UPDATE laporan_setok SET selisih='$selisih' WHERE id='$rec_id'");  
$this->set_flash_msg("Data Berhasil Di Update!!", "success");
return  $this->redirect("laporan_setok/laporan"); 
		# End of after update statement
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("laporan_setok");
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
						return	$this->redirect("laporan_setok");
					}
				}
			}
		}
		$db->where("laporan_setok.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Laporan Setok";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("laporan_setok/edit.php", $data);
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function laporan($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("laporan_setok.id", 
			"laporan_setok.tanggal", 
			"laporan_setok.kode_barang", 
			"laporan_setok.nama_barang", 
			"laporan_setok.category_barang", 
			"category_barang.category AS category_barang_category", 
			"laporan_setok.setok_awal", 
			"laporan_setok.setok", 
			"laporan_setok.jumlah", 
			"laporan_setok.selisih", 
			"laporan_setok.divisi", 
			"laporan_setok.bagian", 
			"laporan_setok.operator", 
			"laporan_setok.date_created", 
			"laporan_setok.setatus", 
			"laporan_setok.keluar", 
			"laporan_setok.id_data_setok", 
			"laporan_setok.pending_keluar", 
			"laporan_setok.id_data_resep", 
			"laporan_setok.jumlah_sistem");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	     if(USER_ROLE==8){
        $divisi = "IGD";
        $bag    = "IGD";
        $db->where("divisi='$divisi' AND bagian='$bag' and setatus=''");      
 }else if(USER_ROLE==6){
       $divisi = "POLI";
       $bag    = $_SESSION[APP_ID.'user_data']['admin_poli'];
       $db->where("divisi='$divisi' AND bagian='$bag' and setatus=''");     
       }else  if(USER_ROLE==13){
$divisi = "RANAP";
$bag    = $_SESSION[APP_ID.'user_data']['admin_ranap'];   
 $db->where("divisi='$divisi' AND bagian='$bag' and setatus=''");  
 }else  if(USER_ROLE==5){
     $divisi = "FARMASI";
     $bag    = "FARMASI";
     $db->where("divisi='$divisi' AND bagian='$bag' and setatus=''");      
     }else{
         $this->set_flash_msg("Halaman Terbatas!!", "danger");
        return  $this->redirect("");       
     }
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				laporan_setok.id LIKE ? OR 
				laporan_setok.tanggal LIKE ? OR 
				laporan_setok.kode_barang LIKE ? OR 
				laporan_setok.nama_barang LIKE ? OR 
				laporan_setok.category_barang LIKE ? OR 
				laporan_setok.setok_awal LIKE ? OR 
				laporan_setok.setok LIKE ? OR 
				laporan_setok.jumlah LIKE ? OR 
				laporan_setok.selisih LIKE ? OR 
				laporan_setok.divisi LIKE ? OR 
				laporan_setok.bagian LIKE ? OR 
				laporan_setok.operator LIKE ? OR 
				laporan_setok.date_created LIKE ? OR 
				laporan_setok.date_updated LIKE ? OR 
				laporan_setok.setatus LIKE ? OR 
				laporan_setok.keluar LIKE ? OR 
				laporan_setok.id_data_setok LIKE ? OR 
				laporan_setok.pending_keluar LIKE ? OR 
				laporan_setok.id_data_resep LIKE ? OR 
				laporan_setok.jumlah_sistem LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "laporan_setok/search.php";
		}
		$db->join("category_barang", "laporan_setok.category_barang = category_barang.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("laporan_setok.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Laporan Setok";
		$this->render_view("laporan_setok/laporan.php", $data); //render the full page
	}
}
