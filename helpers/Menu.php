<?php
/**
 * Menu Items
 * All Project Menu
 * @category  Menu List
 */

class Menu{
	
	
			public static $navbarsideleft = array(
		array(
			'path' => 'home', 
			'label' => 'Home', 
			'icon' => '<i class="fa fa-tachometer "></i>'
		),
		
		array(
			'path' => 'pendaftaran_poli', 
			'label' => 'Rawat Jalan', 
			'icon' => '<i class="fa fa-medkit "></i>','submenu' => array(
		array(
			'path' => 'pendaftaran_poli', 
			'label' => 'Pendaftaran Poli', 
			'icon' => '<i class="fa fa-hospital-o "></i>'
		),
		
		array(
			'path' => 'appointment', 
			'label' => 'Appointment', 
			'icon' => '<i class="fa fa-user "></i>'
		),
		
		array(
			'path' => 'data_pasien', 
			'label' => 'Data Pasien', 
			'icon' => '<i class="fa fa-user-plus "></i>'
		),
		
		array(
			'path' => 'data_permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="fa fa-shopping-cart "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'antrian/panggil', 
			'label' => 'Antrian', 
			'icon' => '<i class="fa fa-microphone "></i>'
		)
	)
		),
		
		array(
			'path' => 'transaksi', 
			'label' => 'Kasir', 
			'icon' => '<i class="fa fa-calculator "></i>','submenu' => array(
		array(
			'path' => 'transaksi', 
			'label' => 'Kasir', 
			'icon' => '<i class="fa fa-calculator "></i>'
		),
		
		array(
			'path' => 'kas', 
			'label' => 'Kas', 
			'icon' => '<i class="fa fa-money "></i>'
		),
		
		array(
			'path' => 'data_permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		)
	)
		),
		
		array(
			'path' => 'resep_obat', 
			'label' => 'Apotik', 
			'icon' => '<i class="fa fa-flask "></i>','submenu' => array(
		array(
			'path' => 'resep_obat', 
			'label' => 'Resep Obat', 
			'icon' => '<i class="fa fa-flask "></i>'
		),
		
		array(
			'path' => 'pelanggan', 
			'label' => 'Pelanggan', 
			'icon' => '<i class="fa fa-users "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="fa fa-folder-open-o "></i>'
		),
		
		array(
			'path' => 'penjualan', 
			'label' => 'Penjualan', 
			'icon' => '<i class="fa fa-dollar "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'laporan_setok', 
			'label' => 'Input Stok Actual', 
			'icon' => '<i class="fa fa-list "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Laporan Barang Masuk', 
			'icon' => '<i class="fa fa-calendar "></i>'
		),
		
		array(
			'path' => 'resep_obat', 
			'label' => 'Laporan Barang Keluar', 
			'icon' => '<i class="fa fa-shopping-basket "></i>'
		),
		
		array(
			'path' => 'permintaan_barang_resep', 
			'label' => 'Permintaan Barang Resep', 
			'icon' => '<i class="fa fa-folder-open-o "></i>'
		)
	)
		),
		
		array(
			'path' => 'permintaan_barang/approval', 
			'label' => 'UMUM', 
			'icon' => '<i class="fa fa-file-archive-o "></i>','submenu' => array(
		array(
			'path' => 'permintaan_barang/approval', 
			'label' => 'Approv Permintaan Barang', 
			'icon' => '<i class="fa fa-database "></i>'
		)
	)
		),
		
		array(
			'path' => 'igd', 
			'label' => 'IGD', 
			'icon' => '<i class="fa fa-ambulance "></i>','submenu' => array(
		array(
			'path' => 'igd', 
			'label' => 'Pendaftaran IGD', 
			'icon' => '<i class="fa fa-calendar-plus-o "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="fa fa-folder-open-o "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		)
	)
		),
		
		array(
			'path' => 'rawat_inap', 
			'label' => 'Rawat Inap', 
			'icon' => '<i class="fa fa-bed "></i>','submenu' => array(
		array(
			'path' => 'rawat_inap', 
			'label' => 'Pendaftaran Rawat Inap', 
			'icon' => '<i class="fa fa-calendar-plus-o "></i>'
		),
		
		array(
			'path' => 'data_kamar', 
			'label' => 'Data Kamar', 
			'icon' => '<i class="fa fa-bed "></i>'
		),
		
		array(
			'path' => 'rekam_medis', 
			'label' => 'Legalitas Peserta', 
			'icon' => '<i class="fa fa-balance-scale "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		)
	)
		),
		
		array(
			'path' => 'operasi', 
			'label' => 'Operasi', 
			'icon' => '<i class="fa fa-bed "></i>','submenu' => array(
		array(
			'path' => 'operasi', 
			'label' => 'Pendaftaran Operasi', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		)
	)
		),
		
		array(
			'path' => 'setok_barang', 
			'label' => 'Gudang ', 
			'icon' => '<i class="fa fa-bank "></i>','submenu' => array(
		array(
			'path' => 'pembelian/obat', 
			'label' => 'Pembelian Obat', 
			'icon' => '<i class="fa fa-shopping-basket "></i>'
		),
		
		array(
			'path' => 'pembelian/alkes', 
			'label' => 'Pembelian Alkes', 
			'icon' => '<i class="fa fa-shopping-cart "></i>'
		),
		
		array(
			'path' => 'pembelian/atk', 
			'label' => 'Pembelian ATK', 
			'icon' => '<i class="fa fa-shopping-cart "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang Unit', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'permintaan_barang_resep', 
			'label' => 'Permintaan Barang Resep', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'laporan_setok', 
			'label' => 'Laporan Stok', 
			'icon' => '<i class="fa fa-calendar-check-o "></i>'
		),
		
		array(
			'path' => 'data_setok', 
			'label' => 'Data Stok Unit', 
			'icon' => '<i class="fa fa-calendar-check-o "></i>'
		),
		
		array(
			'path' => 'setok_barang', 
			'label' => 'Setokl Gudang', 
			'icon' => '<i class="fa fa-database "></i>'
		)
	)
		),
		
		array(
			'path' => 'pendaftaran_lab', 
			'label' => 'Laboratorium', 
			'icon' => '<i class="fa fa-hourglass-1 "></i>','submenu' => array(
		array(
			'path' => 'pendaftaran_lab', 
			'label' => 'Pendaftaran Lab', 
			'icon' => '<i class="fa fa-calendar-check-o "></i>'
		),
		
		array(
			'path' => 'hasil_lab', 
			'label' => 'Hasil Lab', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'nama_pemeriksaan_lab', 
			'label' => 'Nama Pemeriksaan Lab', 
			'icon' => '<i class="fa fa-file-text "></i>'
		),
		
		array(
			'path' => 'jenis_pemeriksaan_lab', 
			'label' => 'Jenis Pemeriksaan Lab', 
			'icon' => '<i class="fa fa-file-text "></i>'
		),
		
		array(
			'path' => 'surat_pengantar_lab', 
			'label' => 'Surat Pengantar Lab', 
			'icon' => '<i class="fa fa-file-text "></i>'
		),
		
		array(
			'path' => 'hasil_lab_luar', 
			'label' => 'Hasil Lab Luar', 
			'icon' => '<i class="fa fa-file-text "></i>'
		)
	)
		),
		
		array(
			'path' => 'data_bank', 
			'label' => 'Data Master', 
			'icon' => '<i class="fa fa-folder-open "></i>','submenu' => array(
		array(
			'path' => 'data_owner', 
			'label' => 'Data Owner', 
			'icon' => '<i class="fa fa-user-secret "></i>'
		),
		
		array(
			'path' => 'data_barang', 
			'label' => 'Data Barang', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'setok_barang', 
			'label' => 'Setok Barang', 
			'icon' => '<i class="fa fa-calendar-check-o "></i>'
		),
		
		array(
			'path' => 'data_bank', 
			'label' => 'Data Bank', 
			'icon' => '<i class="fa fa-bank "></i>'
		),
		
		array(
			'path' => 'category_barang', 
			'label' => 'Category Barang', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'user_login', 
			'label' => 'User Login', 
			'icon' => '<i class="fa fa-users "></i>'
		),
		
		array(
			'path' => 'data_diskon', 
			'label' => 'Data Diskon', 
			'icon' => '<i class="fa fa-money "></i>'
		),
		
		array(
			'path' => 'satuan', 
			'label' => 'Satuan', 
			'icon' => '<i class="fa fa-list "></i>'
		),
		
		array(
			'path' => 'data_kamar', 
			'label' => 'Data Kamar', 
			'icon' => '<i class="fa fa-bed "></i>'
		),
		
		array(
			'path' => 'data_kelas', 
			'label' => 'Data Kelas', 
			'icon' => '<i class="fa fa-th-list "></i>'
		),
		
		array(
			'path' => 'data_dokter', 
			'label' => 'Data Dokter', 
			'icon' => '<i class="fa fa-user-md "></i>'
		),
		
		array(
			'path' => 'data_poli', 
			'label' => 'Data Poli', 
			'icon' => '<i class="fa fa-medkit "></i>'
		),
		
		array(
			'path' => 'list_biaya_tindakan', 
			'label' => 'List Biaya Tindakan', 
			'icon' => '<i class="fa fa-list-ul "></i>'
		),
		
		array(
			'path' => 'data_key', 
			'label' => 'Data Key', 
			'icon' => '<i class="fa fa-key "></i>'
		),
		
		array(
			'path' => 'operasi', 
			'label' => 'Operasi', 
			'icon' => '<i class="fa fa-bed "></i>'
		),
		
		array(
			'path' => 'role_permissions', 
			'label' => 'Role Permissions', 
			'icon' => '<i class="fa fa-hand-paper-o "></i>'
		),
		
		array(
			'path' => 'roles', 
			'label' => 'Roles', 
			'icon' => '<i class="fa fa-hand-paper-o "></i>'
		),
		
		array(
			'path' => 'data_pasien', 
			'label' => 'Data Pasien', 
			'icon' => '<i class="fa fa-users "></i>'
		),
		
		array(
			'path' => 'jadwal_dokter', 
			'label' => 'Jadwal Dokter', 
			'icon' => '<i class="fa fa-calendar-plus-o "></i>'
		),
		
		array(
			'path' => 'rekam_medis', 
			'label' => 'Rekam Medis', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'data_loket', 
			'label' => 'Data Loket', 
			'icon' => '<i class="fa fa-users "></i>'
		),
		
		array(
			'path' => 'aturan_pakai', 
			'label' => 'Aturan Pakai', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		)
	)
		),
		
		array(
			'path' => 'data_tagihan_pasien', 
			'label' => 'Rekapitulasi', 
			'icon' => '<i class="fa fa-money "></i>','submenu' => array(
		array(
			'path' => 'data_tagihan_pasien', 
			'label' => 'Pendapatan', 
			'icon' => '<i class="fa fa-money "></i>'
		),
		
		array(
			'path' => '/', 
			'label' => 'Beban', 
			'icon' => '<i class="fa fa-money "></i>'
		)
	)
		),
		
		array(
			'path' => 'biodata', 
			'label' => 'Biodata', 
			'icon' => '<i class="fa fa-user-plus "></i>','submenu' => array(
		array(
			'path' => 'biodata', 
			'label' => 'Biodata', 
			'icon' => '<i class="fa fa-user-plus "></i>'
		),
		
		array(
			'path' => 'rekam_medis/history', 
			'label' => 'Riwayat Layanan', 
			'icon' => '<i class="fa fa-user-plus "></i>'
		)
	)
		),
		
		array(
			'path' => 'data_pasien/rekap_pasien', 
			'label' => 'Rekap Pasien', 
			'icon' => '<i class="fa fa-users "></i>'
		),
		
		array(
			'path' => 'data_rm', 
			'label' => 'Data Rm', 
			'icon' => '<i class="fa fa-database "></i>'
		),
		
		array(
			'path' => 'data_kelahiran', 
			'label' => 'Data Kelahiran', 
			'icon' => '<i class="fa fa-user "></i>'
		),
		
		array(
			'path' => 'ranap_anak', 
			'label' => 'Ranap Anak', 
			'icon' => '<i class="fa fa-bed "></i>'
		),
		
		array(
			'path' => 'ranap_bersalin', 
			'label' => 'Ranap Bersalin', 
			'icon' => '<i class="fa fa-bed "></i>'
		),
		
		array(
			'path' => 'ranap_perina', 
			'label' => 'Ranap Perina', 
			'icon' => '<i class="fa fa-bed "></i>'
		),
		
		array(
			'path' => 'type_category', 
			'label' => 'Type Category', 
			'icon' => '<i class="fa fa-folder-open "></i>'
		),
		
		array(
			'path' => 'integrasi_satu_ehat', 
			'label' => 'Integrasi Satu Ehat', 
			'icon' => '','submenu' => array(
		array(
			'path' => 'auth', 
			'label' => 'Auth', 
			'icon' => ''
		),
		
		array(
			'path' => 'id_organization', 
			'label' => 'Id Organization', 
			'icon' => ''
		),
		
		array(
			'path' => 'praktitioner', 
			'label' => 'Praktitioner', 
			'icon' => ''
		),
		
		array(
			'path' => 'location', 
			'label' => 'Location', 
			'icon' => ''
		),
		
		array(
			'path' => 'encounter', 
			'label' => 'Encounter', 
			'icon' => ''
		),
		
		array(
			'path' => 'condition', 
			'label' => 'Condition', 
			'icon' => ''
		),
		
		array(
			'path' => 'observation', 
			'label' => 'Observation', 
			'icon' => ''
		)
	)
		)
	);
		
	
	
			public static $active = array(
		array(
			"value" => "Ya", 
			"label" => "Ya", 
		),
		array(
			"value" => "Tidak", 
			"label" => "Tidak", 
		),);
		
			public static $jenis_kelamin = array(
		array(
			"value" => "Laki-Laki", 
			"label" => "Laki-Laki", 
		),
		array(
			"value" => "Perempuan", 
			"label" => "Perempuan", 
		),);
		
			public static $tl = array(
		array(
			"value" => "TN", 
			"label" => "TN", 
		),
		array(
			"value" => "NY", 
			"label" => "NY", 
		),
		array(
			"value" => "AN", 
			"label" => "AN", 
		),
		array(
			"value" => "BY", 
			"label" => "BY", 
		),);
		
			public static $category = array(
		array(
			"value" => "POLI", 
			"label" => "POLI", 
		),
		array(
			"value" => "LABORATORIUM", 
			"label" => "LABORATORIUM", 
		),
		array(
			"value" => "RADIOLOGI", 
			"label" => "RADIOLOGI", 
		),);
		
			public static $jenis_kelamin2 = array(
		array(
			"value" => "Laki-Laki", 
			"label" => "Laki-Laki", 
		),
		array(
			"value" => "Permpuan", 
			"label" => "Permpuan", 
		),);
		
			public static $kelipatan = array(
		array(
			"value" => "Tidak", 
			"label" => "Tidak", 
		),
		array(
			"value" => "Ya", 
			"label" => "Ya", 
		),);
		
			public static $setatus_bpjs = array(
		array(
			"value" => "Non BPJS", 
			"label" => "Non BPJS", 
		),
		array(
			"value" => "Active", 
			"label" => "Active", 
		),
		array(
			"value" => "Non Active", 
			"label" => "Non Active", 
		),);
		
			public static $rawat_inap = array(
		array(
			"value" => "Yes", 
			"label" => "Yes", 
		),
		array(
			"value" => "No", 
			"label" => "No", 
		),);
		
			public static $level = array(
		array(
			"value" => "Segera", 
			"label" => "Segera", 
		),
		array(
			"value" => "Gawat", 
			"label" => "Gawat", 
		),
		array(
			"value" => "Sedang", 
			"label" => "Sedang", 
		),);
		
			public static $scor_gcs = array(
		array(
			"value" => "E", 
			"label" => "E", 
		),
		array(
			"value" => "M", 
			"label" => "M", 
		),
		array(
			"value" => "Y", 
			"label" => "Y", 
		),);
		
			public static $kondisi_umum = array(
		array(
			"value" => "Baik", 
			"label" => "Baik", 
		),
		array(
			"value" => "Pucat", 
			"label" => "Pucat", 
		),
		array(
			"value" => "Tampak Sakit", 
			"label" => "Tampak Sakit", 
		),
		array(
			"value" => "Lemah", 
			"label" => "Lemah", 
		),
		array(
			"value" => "Sesak", 
			"label" => "Sesak", 
		),
		array(
			"value" => "Kejang", 
			"label" => "Kejang", 
		),
		array(
			"value" => "Lainnya", 
			"label" => "Lainnya", 
		),);
		
			public static $instruksi_selanjutnya = array(
		array(
			"value" => "Rawat Inap", 
			"label" => "Rawat Inap", 
		),
		array(
			"value" => "Rawat Jalan", 
			"label" => "Rawat Jalan", 
		),
		array(
			"value" => "Observasi", 
			"label" => "Observasi", 
		),
		array(
			"value" => "Pulang", 
			"label" => "Pulang", 
		),
		array(
			"value" => "Konsultasi", 
			"label" => "Konsultasi", 
		),);
		
			public static $penggunaan = array(
		array(
			"value" => "FAST", 
			"label" => "FAST", 
		),
		array(
			"value" => "MEDIUM", 
			"label" => "MEDIUM", 
		),
		array(
			"value" => "SLOW", 
			"label" => "SLOW", 
		),);
		
}