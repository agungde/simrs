<?php 
/**
 * Permintaan_barang_resep Page Controller
 * @category  Controller
 */
class Permintaan_barang_resepController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "permintaan_barang_resep";
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
		$fields = array("permintaan_barang_resep.id", 
			"permintaan_barang_resep.id_transaksi", 
			"permintaan_barang_resep.tanggal", 
			"permintaan_barang_resep.actiom", 
			"permintaan_barang_resep.kode_barang", 
			"permintaan_barang_resep.nama_barang", 
			"permintaan_barang_resep.category_barang", 
			"category_barang.category AS category_barang_category", 
			"permintaan_barang_resep.jumlah", 
			"permintaan_barang_resep.divisi", 
			"permintaan_barang_resep.bagian", 
			"permintaan_barang_resep.setatus", 
			"permintaan_barang_resep.keterangan", 
			"permintaan_barang_resep.operator", 
			"permintaan_barang_resep.date_created", 
			"permintaan_barang_resep.date_updated", 
			"permintaan_barang_resep.id_data_resep");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				permintaan_barang_resep.id LIKE ? OR 
				permintaan_barang_resep.id_transaksi LIKE ? OR 
				permintaan_barang_resep.tanggal LIKE ? OR 
				permintaan_barang_resep.actiom LIKE ? OR 
				permintaan_barang_resep.kode_barang LIKE ? OR 
				permintaan_barang_resep.nama_barang LIKE ? OR 
				permintaan_barang_resep.category_barang LIKE ? OR 
				permintaan_barang_resep.jumlah LIKE ? OR 
				permintaan_barang_resep.divisi LIKE ? OR 
				permintaan_barang_resep.bagian LIKE ? OR 
				permintaan_barang_resep.setatus LIKE ? OR 
				permintaan_barang_resep.keterangan LIKE ? OR 
				permintaan_barang_resep.operator LIKE ? OR 
				permintaan_barang_resep.date_created LIKE ? OR 
				permintaan_barang_resep.date_updated LIKE ? OR 
				permintaan_barang_resep.id_data_resep LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "permintaan_barang_resep/search.php";
		}
		$db->join("category_barang", "permintaan_barang_resep.category_barang = category_barang.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("permintaan_barang_resep.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Permintaan Barang Resep";
		$this->render_view("permintaan_barang_resep/list.php", $data); //render the full page
	}
}
