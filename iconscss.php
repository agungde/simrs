
<?php
 header("Content-type: text/css; charset: UTF-8"); 
if (!function_exists('base_url')) {
    function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url;
    }
}



//class="facon facon-home ISO-8859-8
//class="facon facon-kasir

 ?>
.facon{
	 padding-top:-18px;
	 padding-left:18px;
	display:inline-block;
	font:normal normal normal 20px/1 FontAwesome;
	font-size:inherit;text-rendering:
	auto;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;
	}

    .facon-home:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/home.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }
    .facon-kasir:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Kasir.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }
	
    .facon-igd:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/IGD.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }		
	    .facon-igd-pen:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Pendaftaran IGD.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }	
	.facon-igd-per:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Permintaan Barang.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }
	.facon-igd-tin:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Form Tindakan Darurat.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }
	.facon-inap:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Pelayanan Rawat Inap.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }	
	.facon-inap-pen:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Pendaftaran IGD.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }	
	.facon-kamar:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Data Kamar.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }	
	.facon-legal:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Legalitas Peserta.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }	
	.facon-jalan:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Pelayanan Pasien.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }	
	.facon-poli:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Pendaftaran Poli.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }	
	.facon-app:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Appointment.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }	
	.facon-bio:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Biodata.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }	
	.facon-pasien:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Data Pasien.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }	
	.facon-jadok:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Jadwal Dokter.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }	
	.facon-rm:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Rekam Medis.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }	
	.facon-apotek:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Apotek.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }	
	.facon-reso:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Resep Obat.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-pel:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Pelanggan.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-per:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Permintaan Barang.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-pur:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Purchasing.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-beli-obat:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Pembelian Obat.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-beli-alkes:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Pembelian Obat.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-beli-atk:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Pembelian ATK.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-po:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Purchasing Order.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-lab:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Laboratorium.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-lab-daftar:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Pendaftaran Lab.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-lab-hasil:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Hasil Lab.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-lab-jenis:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Jenis Pemeriksaan Lab.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-lab-nama:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Nama Pemeriksaan Lab.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-hospital:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Hospital.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-barang:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Data Barang.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-barang-setok:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Stok Barang.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-bank:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Data Bank.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-cate-barang:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Kategori Barang.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-user:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/User Login.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-kelas:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Data Kelas.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-dokter:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Data Dokter.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-poli:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Data Poli.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-biaya:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/List Biaya Tindakan.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
	.facon-download:before{
        content: '';
        background:url('<?php echo base_url();?>assets/img/Icons/Templete Import Data Barang.png');
        background-size: 20px 20px;
        position: absolute;
        width:20px;
        height:20px;
        margin-left:-20px;
		margin-top:-18px;       
    }				
				
		
		