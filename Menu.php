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
			'icon' => '<i class="facon facon-home "></i>'
		),
		array(
			'path' => 'antrian', 
			'label' => 'Antrian', 
			'icon' => '<i class="facon facon-user "></i>'
		,
		'submenu' => array(
		array(
			'path' => 'antrian', 
			'label' => 'Antrian', 
			'icon' => '<i class="facon facon-user "></i>'
		),
			array(
			'path' => 'antrian/ambilnomor', 
			'label' => 'Cetak NO Antrean', 
			'icon' => '<i class="facon facon-user "></i>'
		),
				array(
			'path' => 'antrian/panggil', 
			'label' => 'Panggil Antrian', 
			'icon' => '<i class="facon facon-user "></i>'
		)
		)
		),
		array(
			'path' => 'pendaftaran_poli', 
			'label' => 'Pelayanan Rawat Jalan', 
			'icon' => '<i class="facon facon-jalan"></i>',
'submenu' => array(
		array(
			'path' => 'pendaftaran_poli', 
			'label' => 'Pendaftaran Poli', 
			'icon' => '<i class="facon facon-poli "></i>'
		),
			array(
			'path' => 'aturan_pakai', 
			'label' => 'Aturan Pakai Resep Obat', 
			'icon' => '<i class="facon facon-poli "></i>'
		),
		array(
			'path' => 'appointment', 
			'label' => 'Appointment', 
			'icon' => '<i class="facon facon-app "></i>'
		),
		
		array(
			'path' => 'data_pasien', 
			'label' => 'Data Pasien', 
			'icon' => '<i class="facon facon-pasien "></i>'
		),
		
		array(
			'path' => 'data_dokter', 
			'label' => 'Data Dokter', 
			'icon' => '<i class="facon facon-dokter "></i>'
		),
		
		array(
			'path' => 'jadwal_dokter', 
			'label' => 'Jadwal Dokter', 
			'icon' => '<i class="facon facon-jadok "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="facon facon-per "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang', 
			'icon' => '<i class="facon facon-po "></i>'
		)
	)
		),
		
		array(
			'path' => 'transaksi', 
			'label' => 'Kasir', 
			'icon' => '<i class="facon facon-kasir "></i>',
'submenu' => array(
		array(
			'path' => 'transaksi', 
			'label' => 'Kasir', 
			'icon' => '<i class="facon facon-kasir "></i>'
		),
		
		array(
			'path' => 'kas', 
			'label' => 'Kas', 
			'icon' => '<i class="facon facon-kasir "></i>'
		),
		array(
			'path' => 'data_key', 
			'label' => 'PIN dan Password', 
			'icon' => '<i class="facon facon-kasir "></i>'
		),
		array(
			'path' => 'transaksi/debet', 
			'label' => 'Input Kas Kecil', 
			'icon' => '<i class="facon facon-kasir "></i>'
		),
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="facon facon-per "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang', 
			'icon' => '<i class="facon facon-po "></i>'
		)
	)
		),
		
		array(
			'path' => 'resep_obat', 
			'label' => 'Apotik', 
			'icon' => '<i class="facon facon-apotek "></i>',
'submenu' => array(
		array(
			'path' => 'resep_obat', 
			'label' => 'Resep Obat', 
			'icon' => '<i class="facon facon-reso "></i>'
		),
		
		array(
			'path' => 'pelanggan', 
			'label' => 'Pelanggan', 
			'icon' => '<i class="facon facon-pel "></i>'
		),
		
		array(
			'path' => 'penjualan', 
			'label' => 'Penjualan', 
			'icon' => '<i class="fa fa-shopping-cart "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="facon facon-per "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang ', 
			'icon' => '<i class="facon facon-po "></i>'
		),
		
		array(
			'path' => 'laporan_setok', 
			'label' => 'Stok Aktual', 
			'icon' => '<i class="facon facon-barang "></i>'
		),
		
		array(
			'path' => '/', 
			'label' => 'Laporan Stok keluar', 
			'icon' => '<i class="facon facon-barang "></i>',
'submenu' => array(
		array(
			'path' => 'penjualan', 
			'label' => 'Penjualan Luar', 
			'icon' => '<i class="facon facon-po "></i>'
		),
		
		array(
			'path' => 'data_resep', 
			'label' => 'Penjualan Resep', 
			'icon' => '<i class="facon facon-barang "></i>'
		)
	)
		),
		
		array(
			'path' => '/', 
			'label' => 'Laporan Stok Masuk', 
			'icon' => '<i class="facon facon-per "></i>',
'submenu' => array(
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="facon facon-per "></i>'
		),
		
		array(
			'path' => 'permintaan_barang_resep', 
			'label' => 'Permintaan Barang Resep', 
			'icon' => '<i class="facon facon-barang "></i>'
		)
	)
		)
	)
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'UMUM', 
			'icon' => '<i class="facon facon-kelas "></i>',
'submenu' => array(
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Approv Permintaan Barang', 
			'icon' => '<i class="facon facon-per "></i>'
		)
	)
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Gudang / Stokist', 
			'icon' => '<i class="facon facon-pur "></i>',
'submenu' => array(
		array(
			'path' => 'pembelian/obat', 
			'label' => 'Pembelian Obat', 
			'icon' => '<i class="facon facon-beli-obat "></i>'
		),
		
		array(
			'path' => 'pembelian/alkes', 
			'label' => 'Pembelian Alkes', 
			'icon' => '<i class="facon facon-beli-alkes "></i>'
		),
		
		array(
			'path' => 'pembelian/atk', 
			'label' => 'Pembelian ATK', 
			'icon' => '<i class="facon facon-beli-atk "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="facon facon-po "></i>'
		),
		
		array(
			'path' => 'permintaan_barang_resep', 
			'label' => 'Permintaan Barang Resep', 
			'icon' => '<i class="fa fa-file "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang', 
			'icon' => '<i class="facon facon-po "></i>'
		),
		
		array(
			'path' => 'laporan_setok', 
			'label' => 'Stok Aktual ', 
			'icon' => '<i class="facon facon-po "></i>'
		),
		
		array(
			'path' => '/', 
			'label' => 'stok Barang Keluar', 
			'icon' => '<i class="facon facon-po "></i>',
'submenu' => array(
		array(
			'path' => 'penjualan', 
			'label' => 'Penjualan Luar', 
			'icon' => '<i class="facon facon-barang "></i>'
		),
		
		array(
			'path' => 'data_resep', 
			'label' => 'Penjualan Resep', 
			'icon' => '<i class="facon facon-po "></i>'
		)
	)
		),
		
		array(
			'path' => '/', 
			'label' => 'Setok Barang Masuk', 
			'icon' => '<i class="facon facon-per "></i>',
'submenu' => array(
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="facon facon-per "></i>'
		),
		
		array(
			'path' => 'permintaan_barang_resep', 
			'label' => 'Permintaan Barang Resep', 
			'icon' => '<i class="facon facon-per "></i>'
		)
	)
		)
	)
		),
		
		array(
			'path' => '/', 
			'label' => 'Unit Rekam Medis', 
			'icon' => '<i class="facon facon-rm "></i>',
'submenu' => array(
		array(
			'path' => 'rekam_medis', 
			'label' => 'Rekam Medis', 
			'icon' => '<i class="facon facon-rm "></i>'
		),
		
		array(
			'path' => 'data_rm', 
			'label' => 'Data Rm', 
			'icon' => '<i class="fa fa-database "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="facon facon-per "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang', 
			'icon' => '<i class="facon facon-po "></i>'
		)
	)
		),
		
		array(
			'path' => 'igd', 
			'label' => 'IGD', 
			'icon' => '<i class="facon facon-igd "></i>',
'submenu' => array(
		array(
			'path' => 'igd', 
			'label' => 'Pendaftaran IGD', 
			'icon' => '<i class="facon facon-poli "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="facon facon-per "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang ', 
			'icon' => '<i class="facon facon-po "></i>'
		),
		
		array(
			'path' => 'laporan_setok', 
			'label' => 'Stok Aktual', 
			'icon' => '<i class="facon facon-po "></i>'
		),
		
		array(
			'path' => '/', 
			'label' => 'Setok Barang Masuk', 
			'icon' => '<i class="facon facon-per "></i>',
'submenu' => array(
		array(
			'path' => '//Index', 
			'label' => 'Setok Barang Masuk', 
			'icon' => '<i class="facon facon-per "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="facon facon-barang "></i>'
		)
	)
		)
	)
		),
		
		array(
			'path' => 'pendaftaran_lab', 
			'label' => 'Laboratorium', 
			'icon' => '<i class="facon facon-lab "></i>',
'submenu' => array(
		array(
			'path' => 'pendaftaran_lab', 
			'label' => 'Pendaftaran Lab', 
			'icon' => '<i class="facon facon-lab-daftar "></i>'
		),
		
		array(
			'path' => 'hasil_lab', 
			'label' => 'Hasil Lab', 
			'icon' => '<i class="facon facon-lab-hasil "></i>'
		),
		
		array(
			'path' => 'nama_pemeriksaan_lab', 
			'label' => 'Nama Pemeriksaan Lab', 
			'icon' => '<i class="facon facon-lab-nama "></i>'
		),
		
		array(
			'path' => 'jenis_pemeriksaan_lab', 
			'label' => 'Jenis Pemeriksaan Lab', 
			'icon' => '<i class="facon facon-lab-jenis "></i>'
		),
		
		array(
			'path' => 'surat_pengantar_lab', 
			'label' => 'Surat Pengantar Lab', 
			'icon' => '<i class="fa fa-file-image-o "></i>'
		),
		
		array(
			'path' => 'hasil_lab_luar', 
			'label' => 'Hasil Lab Luar', 
			'icon' => '<i class="fa fa-file-image-o "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="facon facon-per "></i>'
		),
		
		array(
			'path' => 'laporan_setok', 
			'label' => 'Stok Aktual', 
			'icon' => '<i class="facon facon-po "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang', 
			'icon' => '<i class="facon facon-po "></i>'
		)
	)
		),
		
		array(
			'path' => 'rawat_inap', 
			'label' => 'Pelayanan Rawat Inap', 
			'icon' => '<i class="facon facon-inap "></i>',
'submenu' => array(
		array(
			'path' => 'rawat_inap', 
			'label' => 'Pendaftaran Rawat Inap', 
			'icon' => '<i class="facon facon-inap "></i>'
		),
			array(
			'path' => 'nama_kamar_ranap', 
			'label' => 'Kamar Rawat Inap', 
			'icon' => '<i class="facon facon-inap "></i>'
		),
		array(
			'path' => 'data_kamar', 
			'label' => 'Data Kamar', 
			'icon' => '<i class="facon facon-kamar "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="facon facon-per "></i>'
		),
		
		array(
			'path' => 'catatan_barang', 
			'label' => 'Catatan Barang', 
			'icon' => '<i class="facon facon-po "></i>'
		),
		
		array(
			'path' => '/', 
			'label' => 'Barang Keluar', 
			'icon' => '<i class="facon facon-po "></i>',
'submenu' => array(
		array(
			'path' => 'rawat_inap/Index', 
			'label' => 'Barang Masuk', 
			'icon' => '<i class="facon facon-per "></i>'
		),
		
		array(
			'path' => 'penjualan', 
			'label' => 'Penjualan Resep', 
			'icon' => '<i class="facon facon-po "></i>'
		),
		
		array(
			'path' => 'data_resep', 
			'label' => 'Penjualan Luar', 
			'icon' => '<i class="facon facon-barang "></i>'
		)
	)
		),
		
		array(
			'path' => '/', 
			'label' => 'Barang Masuk', 
			'icon' => '<i class="facon facon-per "></i>',
'submenu' => array(
		array(
			'path' => '//Index', 
			'label' => 'Barang Keluar', 
			'icon' => '<i class="facon facon-po "></i>'
		),
		
		array(
			'path' => 'permintaan_barang', 
			'label' => 'Permintaan Barang', 
			'icon' => '<i class="facon facon-per "></i>'
		),
		
		array(
			'path' => 'permintaan_barang_resep', 
			'label' => 'Permintaan Barang Resep', 
			'icon' => '<i class="facon facon-per "></i>'
		)
	)
		)
	)
		),
		
		array(
			'path' => 'ranap_anak', 
			'label' => 'Rawat Inap Anak', 
			'icon' => '<i class="facon facon-inap "></i>',
'submenu' => array(
		array(
			'path' => 'ranap_anak', 
			'label' => 'Pendaftaran Ranap Anak', 
			'icon' =>  '<i class="facon facon-inap "></i>',
		)
	)
		),
		
		array(
			'path' => 'ranap_perina', 
			'label' => 'Ruang Perina', 
			'icon' => '<i class="facon facon-inap "></i>',
'submenu' => array(
		array(
			'path' => 'ranap_perina', 
			'label' => 'Pendaftaran Perina', 
			'icon' =>  '<i class="facon facon-inap "></i>',
		)
	)
		),
		
		array(
			'path' => 'ranap_bersalin', 
			'label' => 'Ruang Bersalin', 
			'icon' => '<i class="facon facon-inap "></i>',
'submenu' => array(
		array(
			'path' => 'ranap_bersalin', 
			'label' => 'Pendaftaran_bersalin', 
			'icon' =>  '<i class="facon facon-inap "></i>',
			),
		array(
			'path' => 'Data_kelahiran', 
			'label' => 'Data Kelahiran ', 
			'icon' =>  '<i class="facon facon-inap "></i>',	
		)
	)
		),
		
		array(
			'path' => 'operasi', 
			'label' => 'Operasi', 
			'icon' => '<i class="facon facon-inap "></i>',
'submenu' => array(
		array(
			'path' => 'operasi', 
			'label' => 'Pendaftaran Operasi', 
			'icon' =>  '<i class="facon facon-inap "></i>',
		)
	)
		),
		
		array(
			'path' => 'data_bank', 
			'label' => 'Data Master', 
			'icon' => '<i class="facon facon-hospital "></i>',
'submenu' => array(
		array(
			'path' => 'data_owner', 
			'label' => 'Data Owner', 
			'icon' => '<i class="facon facon-hospital "></i>'
		),
			array(
			'path' => 'aturan_pakai', 
			'label' => 'Aturan Pakai Resep Obat', 
			'icon' => '<i class="facon facon-hospital "></i>'
		),
		
				array(
			'path' => 'nama_kamar_ranap', 
			'label' => 'Nama Kamar Rawat Inap', 
			'icon' => '<i class="facon facon-hospital "></i>'
		),
		array(
			'path' => 'data_barang', 
			'label' => 'Data Barang', 
			'icon' => '<i class="facon facon-barang "></i>'
		),
		
		array(
			'path' => 'setok_barang', 
			'label' => 'Setok Barang', 
			'icon' => '<i class="facon facon-barang-setok "></i>'
		),
		
		array(
			'path' => 'data_bank', 
			'label' => 'Data Bank', 
			'icon' => '<i class="facon facon-bank "></i>'
		),
		
		array(
			'path' => 'category_barang', 
			'label' => 'Category Barang', 
			'icon' => '<i class="facon facon-cate-barang "></i>'
		),
		
		array(
			'path' => 'user_login', 
			'label' => 'User Login', 
			'icon' => '<i class="facon facon-user "></i>'
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
			'icon' => '<i class="facon facon-kamar "></i>'
		),
		
		array(
			'path' => 'data_kelas', 
			'label' => 'Data Kelas', 
			'icon' => '<i class="facon facon-kelas "></i>'
		),
		
		array(
			'path' => 'data_dokter', 
			'label' => 'Data Dokter', 
			'icon' => '<i class="facon facon-dokter "></i>'
		),
		
		array(
			'path' => 'data_poli', 
			'label' => 'Data Poli', 
			'icon' => '<i class="facon facon-poli "></i>'
		),
		
		array(
			'path' => 'list_biaya_tindakan', 
			'label' => 'List Biaya Tindakan', 
			'icon' => '<i class="facon facon-biaya "></i>'
		),
		
		array(
			'path' => 'data_key', 
			'label' => 'Data Key', 
			'icon' => '<i class="fa fa-key "></i>'
		),
		
		array(
			'path' => 'operasi', 
			'label' => 'Operasi', 
			'icon' => '<i class="fa fa-user-md "></i>'
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
			'icon' => '<i class="facon facon-pasien "></i>'
		),
		
		array(
			'path' => 'jadwal_dokter', 
			'label' => 'Jadwal Dokter', 
			'icon' => '<i class="facon facon-jadok "></i>'
		)
	)
		),
		
		array(
			'path' => 'data_poli', 
			'label' => 'Rekapitulasi', 
			'icon' => '<i class="facon facon-kasir "></i>',
'submenu' => array(
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
			'icon' => '<i class="facon facon-bio "></i>',
'submenu' => array(
		array(
			'path' => 'biodata', 
			'label' => 'Biodata', 
			'icon' => '<i class="facon facon-pasien "></i>'
		),
		
		array(
			'path' => 'rekam_medis/history', 
			'label' => 'Riwayat Layanan', 
			'icon' => '<i class="facon facon-jadok "></i>'
		)
	)
		),
		
		array(
			'path' => 'data_pasien/rekap_pasien', 
			'label' => 'Rekap Pasien', 
			'icon' => '<i class="fa fa-users "></i>'
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
		
			public static $pasien = array(
		array(
			"value" => "IGD", 
			"label" => "IGD", 
		),
		array(
			"value" => "POLI", 
			"label" => "POLI", 
		),);
		
			public static $setatus_bpjs2 = array(
		array(
			"value" => "Non BPJS", 
			"label" => "Non BPJS", 
		),
		array(
			"value" => "Active", 
			"label" => "Active", 
		),
		array(
			"value" => "Non BPJS", 
			"label" => "Non Bpjs", 
		),);
		
			public static $setatus = array(
		array(
			"value" => "Register", 
			"label" => "Chekin", 
		),
		array(
			"value" => "Cancel", 
			"label" => "Cancel", 
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
		
			public static $kontrol = array(
		array(
			"value" => "YA", 
			"label" => "YA", 
		),
		array(
			"value" => "TIDAK", 
			"label" => "TIDAK", 
		),);
		
}