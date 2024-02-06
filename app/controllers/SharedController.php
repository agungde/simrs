<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * data_bank_kode_value_exist Model Action
     * @return array
     */
	function data_bank_kode_value_exist($val){
		$db = $this->GetModel();
		$db->where("kode", $val);
		$exist = $db->has("data_bank");
		return $exist;
	}

	/**
     * data_dokter_specialist_option_list Model Action
     * @return array
     */
	function data_dokter_specialist_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_poli AS value,nama_poli AS label FROM data_poli";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_pasien_no_ktp_value_exist Model Action
     * @return array
     */
	function data_pasien_no_ktp_value_exist($val){
		$db = $this->GetModel();
		$db->where("no_ktp", $val);
		$exist = $db->has("data_pasien");
		return $exist;
	}

	/**
     * data_pasien_rm_value_exist Model Action
     * @return array
     */
	function data_pasien_rm_value_exist($val){
		$db = $this->GetModel();
		$db->where("rm", $val);
		$exist = $db->has("data_pasien");
		return $exist;
	}

	/**
     * data_poli_kode_value_exist Model Action
     * @return array
     */
	function data_poli_kode_value_exist($val){
		$db = $this->GetModel();
		$db->where("kode", $val);
		$exist = $db->has("data_poli");
		return $exist;
	}

	/**
     * data_suplier_operator_option_list Model Action
     * @return array
     */
	function data_suplier_operator_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_userlogin AS value , username AS label FROM user_login ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * pembelian_category_barang_option_list Model Action
     * @return array
     */
	function pembelian_category_barang_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , id AS label FROM category_barang ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * penjualan_nama_pelanggan_option_list Model Action
     * @return array
     */
	function penjualan_nama_pelanggan_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_userlogin AS value , username AS label FROM user_login ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * penjualan_operator_option_list Model Action
     * @return array
     */
	function penjualan_operator_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_userlogin AS value , username AS label FROM user_login ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * satuan_operator_option_list Model Action
     * @return array
     */
	function satuan_operator_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_userlogin AS value , username AS label FROM user_login ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * biodata_no_ktp_value_exist Model Action
     * @return array
     */
	function biodata_no_ktp_value_exist($val){
		$db = $this->GetModel();
		$db->where("no_ktp", $val);
		$exist = $db->has("biodata");
		return $exist;
	}

	/**
     * appointment_nama_poli_option_list Model Action
     * @return array
     */
	function appointment_nama_poli_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_poli AS value,nama_poli AS label FROM data_poli WHERE category='POLI'";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * appointment_dokter_option_list Model Action
     * @return array
     */
	function appointment_dokter_option_list($lookup_nama_poli){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_dokter AS value,nama_dokter AS label FROM data_dokter WHERE specialist= ?"  ;
		$queryparams = array($lookup_nama_poli);
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * user_login_nama_value_exist Model Action
     * @return array
     */
	function user_login_nama_value_exist($val){
		$db = $this->GetModel();
		$db->where("nama", $val);
		$exist = $db->has("user_login");
		return $exist;
	}

	/**
     * user_login_username_value_exist Model Action
     * @return array
     */
	function user_login_username_value_exist($val){
		$db = $this->GetModel();
		$db->where("username", $val);
		$exist = $db->has("user_login");
		return $exist;
	}

	/**
     * resep_obat_tanggal_lahir_option_list Model Action
     * @return array
     */
	function resep_obat_tanggal_lahir_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_userlogin AS value , username AS label FROM user_login ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * resep_obat_nama_poli_option_list Model Action
     * @return array
     */
	function resep_obat_nama_poli_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_poli AS value , id_poli AS label FROM data_poli ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * resep_obat_name_option_list Model Action
     * @return array
     */
	function resep_obat_name_option_list($search_text = null){
		$arr = array();
		if(!empty($search_text)){
			$db = $this->GetModel();
			$sqltext = "SELECT id_barang AS value,nama_barang AS label FROM setok_barang WHERE category_barang='1' AND jumlah >1 AND nama_barang LIKE ? LIMIT 0,10" ;
			$queryparams = array("%$search_text%");
			$arr = $db->rawQuery($sqltext, $queryparams);
		}
		return $arr;
	}

	/**
     * data_resep_nama_poli_option_list Model Action
     * @return array
     */
	function data_resep_nama_poli_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_poli AS value , id_poli AS label FROM data_poli ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_resep_nama_obat_option_list Model Action
     * @return array
     */
	function data_resep_nama_obat_option_list($search_text = null){
		$arr = array();
		if(!empty($search_text)){
			$db = $this->GetModel();
			$sqltext = "SELECT id_barang AS value,nama_barang AS label FROM setok_barang WHERE category_barang='2' AND jumlah >0 AND nama_barang LIKE ? LIMIT 0,10" 
 ;
			$queryparams = array("%$search_text%");
			$arr = $db->rawQuery($sqltext, $queryparams);
		}
		return $arr;
	}

	/**
     * data_resep_aturan_minum_option_list Model Action
     * @return array
     */
	function data_resep_aturan_minum_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT aturan_pakai AS value,aturan_pakai AS label FROM aturan_pakai";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * pelanggan_nama_pelanggan_value_exist Model Action
     * @return array
     */
	function pelanggan_nama_pelanggan_value_exist($val){
		$db = $this->GetModel();
		$db->where("nama_pelanggan", $val);
		$exist = $db->has("pelanggan");
		return $exist;
	}

	/**
     * pelanggan_nama_pelanggan_option_list Model Action
     * @return array
     */
	function pelanggan_nama_pelanggan_option_list($search_text = null){
		$arr = array();
		if(!empty($search_text)){
			$db = $this->GetModel();
			$sqltext = "SELECT  DISTINCT id AS value,nama_pelanggan AS label FROM pelanggan"  ;
			$queryparams = array("%$search_text%");
			$arr = $db->rawQuery($sqltext, $queryparams);
		}
		return $arr;
	}

	/**
     * pelanggan_phone_value_exist Model Action
     * @return array
     */
	function pelanggan_phone_value_exist($val){
		$db = $this->GetModel();
		$db->where("phone", $val);
		$exist = $db->has("pelanggan");
		return $exist;
	}

	/**
     * nama_pemeriksaan_lab_jenis_pemeriksaan_option_list Model Action
     * @return array
     */
	function nama_pemeriksaan_lab_jenis_pemeriksaan_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,jenis_pemeriksaan AS label FROM jenis_pemeriksaan_lab";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * nama_pemeriksaan_lab_nama_pemeriksaan_value_exist Model Action
     * @return array
     */
	function nama_pemeriksaan_lab_nama_pemeriksaan_value_exist($val){
		$db = $this->GetModel();
		$db->where("nama_pemeriksaan", $val);
		$exist = $db->has("nama_pemeriksaan_lab");
		return $exist;
	}

	/**
     * pendaftaran_lab_jenis_pemeriksaan_option_list Model Action
     * @return array
     */
	function pendaftaran_lab_jenis_pemeriksaan_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,jenis_pemeriksaan AS label FROM jenis_pemeriksaan_lab";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * pendaftaran_lab_nama_pemeriksaan_option_list Model Action
     * @return array
     */
	function pendaftaran_lab_nama_pemeriksaan_option_list($lookup_jenis_pemeriksaan){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT jenis_pemeriksaan AS value,nama_pemeriksaan AS label FROM nama_pemeriksaan_lab WHERE jenis_pemeriksaan= ? ORDER BY id ASC"  
 ;
		$queryparams = array($lookup_jenis_pemeriksaan);
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_hasil_lab_nama_pemeriksaan_option_list Model Action
     * @return array
     */
	function data_hasil_lab_nama_pemeriksaan_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,nama_pemeriksaan AS label FROM nama_pemeriksaan_lab";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_hasil_lab_nilai_rujukan_option_list Model Action
     * @return array
     */
	function data_hasil_lab_nilai_rujukan_option_list($lookup_nama_pemeriksaan){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,nilai_rujukan AS label FROM nama_pemeriksaan_lab WHERE id= ? ORDER BY id ASC"    ;
		$queryparams = array($lookup_nama_pemeriksaan);
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_hasil_lab_diagnosa_option_list Model Action
     * @return array
     */
	function data_hasil_lab_diagnosa_option_list($search_text = null){
		$arr = array();
		if(!empty($search_text)){
			$db = $this->GetModel();
			$sqltext = "SELECT  DISTINCT id AS value,description AS label FROM diagnosa WHERE description LIKE ? LIMIT 0,20"   ;
			$queryparams = array("%$search_text%");
			$arr = $db->rawQuery($sqltext, $queryparams);
		}
		return $arr;
	}

	/**
     * category_barang_category_value_exist Model Action
     * @return array
     */
	function category_barang_category_value_exist($val){
		$db = $this->GetModel();
		$db->where("category", $val);
		$exist = $db->has("category_barang");
		return $exist;
	}

	/**
     * category_barang_operator_option_list Model Action
     * @return array
     */
	function category_barang_operator_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_userlogin AS value , username AS label FROM user_login ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_barang_kode_barang_value_exist Model Action
     * @return array
     */
	function data_barang_kode_barang_value_exist($val){
		$db = $this->GetModel();
		$db->where("kode_barang", $val);
		$exist = $db->has("data_barang");
		return $exist;
	}

	/**
     * data_barang_nama_barang_value_exist Model Action
     * @return array
     */
	function data_barang_nama_barang_value_exist($val){
		$db = $this->GetModel();
		$db->where("nama_barang", $val);
		$exist = $db->has("data_barang");
		return $exist;
	}

	/**
     * data_barang_satuan_option_list Model Action
     * @return array
     */
	function data_barang_satuan_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT jenis_satuan AS value,operator AS label FROM satuan";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_barang_category_barang_option_list Model Action
     * @return array
     */
	function data_barang_category_barang_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,category AS label FROM category_barang";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * diskon_penjualan_nama_diskon_option_list Model Action
     * @return array
     */
	function diskon_penjualan_nama_diskon_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_data_diskon AS value , id_data_diskon AS label FROM data_diskon ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * diskon_penjualan_kode_barang_option_list Model Action
     * @return array
     */
	function diskon_penjualan_kode_barang_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_barang AS value,nama_barang AS label FROM data_barang";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_tindakan_tindakan_option_list Model Action
     * @return array
     */
	function data_tindakan_tindakan_option_list($search_text = null){
		$arr = array();
		if(!empty($search_text)){
			$db = $this->GetModel();
			$sqltext = "SELECT  DISTINCT id AS value,nama_tindakan AS label FROM list_biaya_tindakan WHERE harga >0 AND nama_tindakan LIKE ? LIMIT 0,20"   ;
			$queryparams = array( "%$search_text%");
			$arr = $db->rawQuery($sqltext, $queryparams);
		}
		return $arr;
	}

	/**
     * data_kamar_kamar_kelas_option_list Model Action
     * @return array
     */
	function data_kamar_kamar_kelas_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_kelas AS value,nama_kelas AS label FROM data_kelas";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_kamar_nama_kamar_option_list Model Action
     * @return array
     */
	function data_kamar_nama_kamar_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,nama_kamar AS label FROM nama_kamar_ranap ORDER BY id ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * igd_pembayaran_option_list Model Action
     * @return array
     */
	function igd_pembayaran_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_databank AS value,nama_bank AS label FROM data_bank WHERE type='1' ORDER BY id_databank ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * igd_dokter_option_list Model Action
     * @return array
     */
	function igd_dokter_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_dokter AS value,nama_dokter AS label FROM data_dokter";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * permintaan_barang_category_barang_option_list Model Action
     * @return array
     */
	function permintaan_barang_category_barang_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , category AS label FROM category_barang ORDER BY value ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * permintaan_harga_nama_suplier_option_list Model Action
     * @return array
     */
	function permintaan_harga_nama_suplier_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_suplier AS value,nama AS label FROM data_suplier";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * permintaan_harga_category_barang_option_list Model Action
     * @return array
     */
	function permintaan_harga_category_barang_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , id AS label FROM category_barang ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * rawat_inap_pembayaran_option_list Model Action
     * @return array
     */
	function rawat_inap_pembayaran_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_databank AS value,nama_bank AS label FROM data_bank WHERE active='Ya' ORDER BY id_databank ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * rawat_inap_poli_option_list Model Action
     * @return array
     */
	function rawat_inap_poli_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_poli AS value,nama_poli AS label FROM data_poli";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * rawat_inap_dokter_rawat_inap_option_list Model Action
     * @return array
     */
	function rawat_inap_dokter_rawat_inap_option_list($lookup_poli){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_dokter AS value,nama_dokter AS label FROM data_dokter WHERE specialist= ?" ;
		$queryparams = array($lookup_poli);
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * pendaftaran_poli_nama_poli_option_list Model Action
     * @return array
     */
	function pendaftaran_poli_nama_poli_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT id_poli AS value,nama_poli AS label FROM data_poli WHERE category='POLI' ORDER BY id_poli ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * pendaftaran_poli_dokter_option_list Model Action
     * @return array
     */
	function pendaftaran_poli_dokter_option_list($lookup_nama_poli){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_dokter AS value,nama_dokter AS label FROM data_dokter WHERE specialist= ?" ;
		$queryparams = array($lookup_nama_poli);
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * pendaftaran_poli_pembayaran_option_list Model Action
     * @return array
     */
	function pendaftaran_poli_pembayaran_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_databank AS value,nama_bank AS label FROM data_bank WHERE type='1' ORDER BY id_databank ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * operasi_dokter_operasi_option_list Model Action
     * @return array
     */
	function operasi_dokter_operasi_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_dokter AS value,nama_dokter AS label FROM data_dokter";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * kas_kasir_option_list Model Action
     * @return array
     */
	function kas_kasir_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_userlogin AS value , username AS label FROM user_login ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * kas_transaksi_option_list Model Action
     * @return array
     */
	function kas_transaksi_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_databank AS value , id_databank AS label FROM data_bank ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * perintah_opname_diagnosa_option_list Model Action
     * @return array
     */
	function perintah_opname_diagnosa_option_list($search_text = null){
		$arr = array();
		if(!empty($search_text)){
			$db = $this->GetModel();
			$sqltext = "SELECT  DISTINCT id AS value,description AS label FROM diagnosa WHERE description LIKE ? LIMIT 0,20"  ;
			$queryparams = array("%$search_text%");
			$arr = $db->rawQuery($sqltext, $queryparams);
		}
		return $arr;
	}

	/**
     * assesment_medis_diagnosa_kerja_option_list Model Action
     * @return array
     */
	function assesment_medis_diagnosa_kerja_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , id AS label FROM diagnosa ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * assesment_medis_diagnosa_banding_option_list Model Action
     * @return array
     */
	function assesment_medis_diagnosa_banding_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , id AS label FROM diagnosa ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * assesment_medis_diteruskan_dokter_option_list Model Action
     * @return array
     */
	function assesment_medis_diteruskan_dokter_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_dokter AS value , username AS label FROM data_dokter ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_obat_kode_obat_value_exist Model Action
     * @return array
     */
	function data_obat_kode_obat_value_exist($val){
		$db = $this->GetModel();
		$db->where("kode_obat", $val);
		$exist = $db->has("data_obat");
		return $exist;
	}

	/**
     * data_obat_nama_obat_value_exist Model Action
     * @return array
     */
	function data_obat_nama_obat_value_exist($val){
		$db = $this->GetModel();
		$db->where("nama_obat", $val);
		$exist = $db->has("data_obat");
		return $exist;
	}

	/**
     * ijin_pulang_poli_option_list Model Action
     * @return array
     */
	function ijin_pulang_poli_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_poli AS value,nama_poli AS label FROM data_poli";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * ijin_pulang_dokter_option_list Model Action
     * @return array
     */
	function ijin_pulang_dokter_option_list($lookup_poli){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_dokter AS value,nama_dokter AS label FROM data_dokter WHERE specialist= ?" ;
		$queryparams = array($lookup_poli);
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * surat_pengantar_lab_hematologi_option_list Model Action
     * @return array
     */
	function surat_pengantar_lab_hematologi_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT nama_pemeriksaan AS value,nama_pemeriksaan AS label FROM hematologi";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * surat_pengantar_lab_imuniserologi_option_list Model Action
     * @return array
     */
	function surat_pengantar_lab_imuniserologi_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT inama_pemeriksaan AS value,inama_pemeriksaan AS label FROM imuniserologi";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * surat_pengantar_lab_kimia_klinik_option_list Model Action
     * @return array
     */
	function surat_pengantar_lab_kimia_klinik_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT nama_pemeriksaan AS value,nama_pemeriksaan AS label FROM kimia_klinik";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * surat_pengantar_lab_urin_faces_option_list Model Action
     * @return array
     */
	function surat_pengantar_lab_urin_faces_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT nama_pemeriksaan AS value,nama_pemeriksaan AS label FROM urine";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * surat_pengantar_lab_microbiologi_option_list Model Action
     * @return array
     */
	function surat_pengantar_lab_microbiologi_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT nama_pemeriksaan AS value,nama_pemeriksaan AS label FROM mikrobiologi";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * role_permissions_role_id_option_list Model Action
     * @return array
     */
	function role_permissions_role_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT role_id AS value,role_name AS label FROM roles";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * kunjungan_dokter_dokter_option_list Model Action
     * @return array
     */
	function kunjungan_dokter_dokter_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_dokter AS value , username AS label FROM data_dokter ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_kamar_anak_kamar_kelas_option_list Model Action
     * @return array
     */
	function data_kamar_anak_kamar_kelas_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_kelas AS value,nama_kelas AS label FROM data_kelas ORDER BY id_kelas ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_kamar_anak_nama_kamar_option_list Model Action
     * @return array
     */
	function data_kamar_anak_nama_kamar_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,nama_kamar AS label FROM nama_kamar_ranap_anak ORDER BY id ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_kamar_bersalin_kamar_kelas_option_list Model Action
     * @return array
     */
	function data_kamar_bersalin_kamar_kelas_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id_kelas AS value,nama_kelas AS label FROM data_kelas ORDER BY id_kelas ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_kamar_bersalin_nama_kamar_option_list Model Action
     * @return array
     */
	function data_kamar_bersalin_nama_kamar_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,nama_kamar AS label FROM nama_kamar_ranap_bersalin ORDER BY id ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_kamar_perina_kamar_kelas_option_list Model Action
     * @return array
     */
	function data_kamar_perina_kamar_kelas_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id_kelas AS value , id_kelas AS label FROM data_kelas ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_kamar_perina_nama_kamar_option_list Model Action
     * @return array
     */
	function data_kamar_perina_nama_kamar_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , id AS label FROM nama_kamar_ranap_perina ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_setok_category_barang_option_list Model Action
     * @return array
     */
	function data_setok_category_barang_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , id AS label FROM category_barang ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * permintaan_barang_resep_category_barang_option_list Model Action
     * @return array
     */
	function permintaan_barang_resep_category_barang_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , id AS label FROM category_barang ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * data_loket_nomor_value_exist Model Action
     * @return array
     */
	function data_loket_nomor_value_exist($val){
		$db = $this->GetModel();
		$db->where("nomor", $val);
		$exist = $db->has("data_loket");
		return $exist;
	}

}
