<?php 
/**
 * Penjualan Page Controller
 * @category  Controller
 */
class PenjualanController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "penjualan";
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
		$fields = array("id_penjualan", 
			"tanggal", 
			"no_invoice", 
			"nama_pelanggan", 
			"alamat", 
			"no_hp", 
			"total_jumlah", 
			"total_harga_beli", 
			"total_harga_jual", 
			"total_diskon", 
			"trx", 
			"total_untung", 
			"ppn", 
			"setatus", 
			"bayar", 
			"kembalian", 
			"operator", 
			"date_created");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	  if(!empty($request->penjualan_name)){
    $trx = $request->penjualan_name;
if(!empty($request->penjualan_tanggal)){
    $val = $request->penjualan_tanggal;
    $db->where("trx='$trx' and setatus='Closed' and DATE(penjualan.tanggal)", $val , "=");
    }else{
       $db->where("trx='$trx' and setatus='Closed'");   
    }
    }else{
        $db->where("setatus='Closed'");    
    }
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				penjualan.id_penjualan LIKE ? OR 
				penjualan.tanggal LIKE ? OR 
				penjualan.no_invoice LIKE ? OR 
				penjualan.id_pelanggan LIKE ? OR 
				penjualan.nama_pelanggan LIKE ? OR 
				penjualan.alamat LIKE ? OR 
				penjualan.no_hp LIKE ? OR 
				penjualan.total_jumlah LIKE ? OR 
				penjualan.total_harga_beli LIKE ? OR 
				penjualan.total_harga_jual LIKE ? OR 
				penjualan.total_diskon LIKE ? OR 
				penjualan.trx LIKE ? OR 
				penjualan.total_untung LIKE ? OR 
				penjualan.id_jual LIKE ? OR 
				penjualan.ppn LIKE ? OR 
				penjualan.setatus LIKE ? OR 
				penjualan.bayar LIKE ? OR 
				penjualan.kembalian LIKE ? OR 
				penjualan.operator LIKE ? OR 
				penjualan.date_created LIKE ? OR 
				penjualan.date_updated LIKE ? OR 
				penjualan.resep LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "penjualan/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("penjualan.id_penjualan", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Penjualan";
		$view_name = (is_ajax() ? "penjualan/ajax-list.php" : "penjualan/list.php");
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
		$fields = array("id_penjualan", 
			"tanggal", 
			"nama_pelanggan", 
			"alamat", 
			"no_hp", 
			"total_jumlah", 
			"total_harga_beli", 
			"total_harga_jual", 
			"total_diskon", 
			"ppn", 
			"no_invoice", 
			"setatus", 
			"bayar", 
			"kembalian", 
			"trx");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("penjualan.id_penjualan", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Penjualan";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("penjualan/view.php", $record);
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
			$fields = $this->fields = array("id_penjualan","nama_pelanggan","alamat","ppn","id_pelanggan","tanggal","operator","no_hp","total_jumlah","total_harga_beli","total_harga_jual","total_diskon","total_untung","id_jual","no_invoice","setatus","bayar","kembalian","trx");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_penjualan' => 'required|numeric',
				'nama_pelanggan' => 'required',
				'alamat' => 'required',
				'ppn' => 'required',
				'id_pelanggan' => 'required|numeric',
				'tanggal' => 'required',
				'operator' => 'required',
				'no_hp' => 'required',
				'total_jumlah' => 'required|numeric',
				'total_harga_beli' => 'required|numeric',
				'total_harga_jual' => 'required|numeric',
				'total_diskon' => 'required',
				'total_untung' => 'required|numeric',
				'id_jual' => 'required',
				'no_invoice' => 'required',
				'setatus' => 'required',
				'bayar' => 'required|numeric',
				'kembalian' => 'required|numeric',
				'trx' => 'required',
			);
			$this->sanitize_array = array(
				'id_penjualan' => 'sanitize_string',
				'nama_pelanggan' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'ppn' => 'sanitize_string',
				'id_pelanggan' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'total_jumlah' => 'sanitize_string',
				'total_harga_beli' => 'sanitize_string',
				'total_harga_jual' => 'sanitize_string',
				'total_diskon' => 'sanitize_string',
				'total_untung' => 'sanitize_string',
				'id_jual' => 'sanitize_string',
				'no_invoice' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'bayar' => 'sanitize_string',
				'kembalian' => 'sanitize_string',
				'trx' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$db->rawQuery("UPDATE penjualan SET operator='".USER_ID."' WHERE id_penjualan='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("penjualan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Penjualan";
		$this->render_view("penjualan/add.php");
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
		$fields = $this->fields = array("id_penjualan","nama_pelanggan","alamat","ppn","id_pelanggan","tanggal","operator","no_hp","total_jumlah","total_harga_beli","total_harga_jual","total_diskon","total_untung","id_jual","no_invoice","setatus","bayar","kembalian","trx");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'id_penjualan' => 'required|numeric',
				'nama_pelanggan' => 'required',
				'alamat' => 'required',
				'ppn' => 'required',
				'id_pelanggan' => 'required|numeric',
				'tanggal' => 'required',
				'operator' => 'required',
				'no_hp' => 'required',
				'total_jumlah' => 'required|numeric',
				'total_harga_beli' => 'required|numeric',
				'total_harga_jual' => 'required|numeric',
				'total_diskon' => 'required',
				'total_untung' => 'required|numeric',
				'id_jual' => 'required',
				'no_invoice' => 'required',
				'setatus' => 'required',
				'bayar' => 'required|numeric',
				'kembalian' => 'required|numeric',
				'trx' => 'required',
			);
			$this->sanitize_array = array(
				'id_penjualan' => 'sanitize_string',
				'nama_pelanggan' => 'sanitize_string',
				'alamat' => 'sanitize_string',
				'ppn' => 'sanitize_string',
				'id_pelanggan' => 'sanitize_string',
				'tanggal' => 'sanitize_string',
				'operator' => 'sanitize_string',
				'no_hp' => 'sanitize_string',
				'total_jumlah' => 'sanitize_string',
				'total_harga_beli' => 'sanitize_string',
				'total_harga_jual' => 'sanitize_string',
				'total_diskon' => 'sanitize_string',
				'total_untung' => 'sanitize_string',
				'id_jual' => 'sanitize_string',
				'no_invoice' => 'sanitize_string',
				'setatus' => 'sanitize_string',
				'bayar' => 'sanitize_string',
				'kembalian' => 'sanitize_string',
				'trx' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("penjualan.id_penjualan", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("penjualan");
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
						return	$this->redirect("penjualan");
					}
				}
			}
		}
		$db->where("penjualan.id_penjualan", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Penjualan";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("penjualan/edit.php", $data);
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
		$db->where("penjualan.id_penjualan", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("penjualan");
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
		$fields = array("id_penjualan", 
			"nama_pelanggan", 
			"alamat", 
			"ppn", 
			"id_pelanggan", 
			"tanggal", 
			"date_created", 
			"operator", 
			"date_updated", 
			"no_hp", 
			"total_jumlah", 
			"total_harga_beli", 
			"total_harga_jual", 
			"total_diskon", 
			"total_untung", 
			"id_jual", 
			"no_invoice", 
			"setatus", 
			"bayar", 
			"kembalian", 
			"resep", 
			"trx");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				penjualan.id_penjualan LIKE ? OR 
				penjualan.nama_pelanggan LIKE ? OR 
				penjualan.alamat LIKE ? OR 
				penjualan.ppn LIKE ? OR 
				penjualan.id_pelanggan LIKE ? OR 
				penjualan.tanggal LIKE ? OR 
				penjualan.date_created LIKE ? OR 
				penjualan.operator LIKE ? OR 
				penjualan.date_updated LIKE ? OR 
				penjualan.no_hp LIKE ? OR 
				penjualan.total_jumlah LIKE ? OR 
				penjualan.total_harga_beli LIKE ? OR 
				penjualan.total_harga_jual LIKE ? OR 
				penjualan.total_diskon LIKE ? OR 
				penjualan.total_untung LIKE ? OR 
				penjualan.id_jual LIKE ? OR 
				penjualan.no_invoice LIKE ? OR 
				penjualan.setatus LIKE ? OR 
				penjualan.bayar LIKE ? OR 
				penjualan.kembalian LIKE ? OR 
				penjualan.resep LIKE ? OR 
				penjualan.trx LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "penjualan/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("penjualan.id_penjualan", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Penjualan";
		$this->render_view("penjualan/invoice.php", $data); //render the full page
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function kasir($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id_penjualan", 
			"tanggal", 
			"no_invoice", 
			"total_jumlah", 
			"total_harga_jual", 
			"setatus", 
			"trx", 
			"date_created");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
	#Statement to execute before list record
	if(!empty($request->penjualan_tanggal)){
    $val = $request->penjualan_tanggal;
    $set = $request->penjualan_setatus;
    $db->where("trx='Jual' and setatus='$set' and DATE(penjualan.tanggal)", $val , "=");
    }else{
        $db->where("setatus='Register' or setatus='Closed' and trx='Jual'");  
    }
	# End of before list statement
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				penjualan.id_penjualan LIKE ? OR 
				penjualan.tanggal LIKE ? OR 
				penjualan.no_invoice LIKE ? OR 
				penjualan.id_pelanggan LIKE ? OR 
				penjualan.nama_pelanggan LIKE ? OR 
				penjualan.alamat LIKE ? OR 
				penjualan.total_jumlah LIKE ? OR 
				penjualan.total_harga_jual LIKE ? OR 
				penjualan.ppn LIKE ? OR 
				penjualan.no_hp LIKE ? OR 
				penjualan.total_harga_beli LIKE ? OR 
				penjualan.total_diskon LIKE ? OR 
				penjualan.total_untung LIKE ? OR 
				penjualan.id_jual LIKE ? OR 
				penjualan.setatus LIKE ? OR 
				penjualan.bayar LIKE ? OR 
				penjualan.kembalian LIKE ? OR 
				penjualan.resep LIKE ? OR 
				penjualan.trx LIKE ? OR 
				penjualan.operator LIKE ? OR 
				penjualan.date_created LIKE ? OR 
				penjualan.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "penjualan/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("penjualan.id_penjualan", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Penjualan";
		$this->render_view("penjualan/kasir.php", $data); //render the full page
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function bayar($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("tanggal","no_invoice","total_harga_jual","bayar","kembalian");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'tanggal' => 'required',
				'no_invoice' => 'required',
				'total_harga_jual' => 'required|numeric',
				'bayar' => 'required|numeric',
				'kembalian' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'tanggal' => 'sanitize_string',
				'no_invoice' => 'sanitize_string',
				'total_harga_jual' => 'sanitize_string',
				'bayar' => 'sanitize_string',
				'kembalian' => 'sanitize_string',
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
 $noinvoice = $_POST['noinvoice'];
        $id_penjualan=$_POST['id_penjualan'];
 ///////////////////////////////////////////////////////////////////////////////////////////////
$tanggaltrx    = $_POST['tanggal_transaksi'];
 $type_transaksi=$_POST['type_transaksi'];
   $siatag=$_POST['bayar'] - $_POST['kembalian'];
   $keterangan="Pembayaran Invoice $noinvoice";
        $queryn = mysqli_query($koneksi, "SELECT * FROM `kas` where transaksi='2' ORDER BY `id` DESC")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
 $rowsn = mysqli_num_rows($queryn);
  if ($rowsn <> 0) {
      $datacekn= mysqli_fetch_assoc($queryn);
     $saldoawaln = $datacekn['saldo_cash'];
     }else{
         $saldoawaln = "0";
     }
     if($type_transaksi==2){
     $saldocash=$saldoawaln + $siatag;
     }else{
         $saldocash="0";
     }
$query = mysqli_query($koneksi, "SELECT * FROM `kas` ORDER BY `id` DESC")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
 $rows = mysqli_num_rows($query);
  if ($rows <> 0) {
      $datacek= mysqli_fetch_assoc($query);
     $saldoawal = $datacek['saldo'];
     }else{
         $saldoawal = "0";
     }
     $saldoahir = $saldoawal + $siatag;
     $keterangan="Pembayaran No Invoice $noinvoice";
     mysqli_query($koneksi, "INSERT INTO `kas`(`tanggal`, `debet`, `keterangan`, `saldo`, `kasir`, `setatus`, `transaksi`, `saldo_cash`) VALUES ('$tanggaltrx','$siatag','$keterangan','$saldoahir','$id_user','Register','$type_transaksi','$saldocash')"); 
     mysqli_query($koneksi, "UPDATE penjualan  SET setatus='Closed', date_updated='".date("Y-m-d H:i:s")."'   WHERE id_penjualan='$id_penjualan'")
                                     or die('Ada kesalahan pada query update : ' . mysqli_error($koneksi));
 mysqli_query($koneksi, "UPDATE data_penjualan   SET setatus='Closed', date_updated='".date("Y-m-d H:i:s")."'   WHERE id_penjualan='$id_penjualan'")
                                     or die('Ada kesalahan pada query update : ' . mysqli_error($koneksi)); 
  $this->set_flash_msg("Proses Bayar Berhasil", "success");
return  $this->redirect("penjualan/kasir");                                   
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("penjualan");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Penjualan";
		$this->render_view("penjualan/bayar.php");
	}
}
