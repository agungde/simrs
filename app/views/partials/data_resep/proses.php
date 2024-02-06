<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <div class="">        <div  class="p-2 mb-2">
                        <div class="container-fluid">
                            <div class="row ">
                                <div class="col ">
                                    <h4 class="record-title"><?php
                                        if(!empty($_GET['print'])){
                                        echo "Print Resep Obat";
                                        }else{
                                        if(!empty($_GET['view'])){
                                        echo "Detile Resep Obat";
                                        }else{
                                        echo "Proses Resep Obat";
                                        }
                                        }
                                    ?></h4>
                                </div>
                                <div class="col-md-12 comp-grid">
                                </div>
                            </div>
                        </div>
                    </div></div>
                </div>
            </div>
        </div>
    </div>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-7 comp-grid">
                    <div class=""><div >
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        //$koneksi=open_connection();
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        if(!empty($_GET['precord'])){
                        $ciphertext = $_GET['precord'];
                        $ciphertext=str_replace(' ', '+', $ciphertext);
                        $key="dermawangroup";
                        $c = base64_decode($ciphertext);
                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                        $iv = substr($c, 0, $ivlen);
                        $hmac = substr($c, $ivlen, $sha2len=32);
                        $ciphertext_raw = substr($c, $ivlen+$sha2len);
                        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                        if (hash_equals($hmac, $calcmac))// timing attack safe comparison
                        {
                        // echo $original_plaintext."\n";
                        }
                        $precord="$original_plaintext";
                        $sql = mysqli_query($koneksi,"select * from resep_obat WHERE id_resep_obat='$original_plaintext'");
                        while ($row=mysqli_fetch_array($sql)){
                        $rekam=$row['no_rekam_medis'];
                        $tgl=$row['tanggal'];
                        $nama_dokter=$row['nama_dokter'];
                        $pasien=$row['pasien'];
                        }
                        $sqlcek2 = mysqli_query($koneksi,"select * from data_resep WHERE id_resep_obat='$original_plaintext'");
                        while ($row2=mysqli_fetch_array($sqlcek2)){
                        $norekam=$row2['no_rekam_medis'];
                        $alamat=$row2['alamat'];
                        $nama_pasien=$row2['nama_pasien'];
                        $tanggal_lahir=$row2['tanggal_lahir'];
                        $tanggal=$row2['tanggal'];
                        $umur=$row2['umur'];
                        }
                        ?>
                        <table > 
                            <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Pasien</b></td> <td>&nbsp;:&nbsp;</td><td><?php echo $pasien;?></td> </tr>
                            <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Tanggal</b></td> <td>&nbsp;:&nbsp;</td><td><?php echo $tanggal;?></td> </tr>
                            <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<b>No Rekam</b></td> <td>&nbsp;:&nbsp;</td><td><?php echo $norekam;?></td> </tr>
                            <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Nama Pasien</b></td> <td>&nbsp;:&nbsp;</td> <td><?php echo $nama_pasien;?></td>
                                <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Alamat</b></td> <td>&nbsp;:&nbsp;</td> <td><?php echo $alamat;?></td>
                                    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Tgl Lahir</b></td> <td>&nbsp;:&nbsp;</td><td><?php echo $tanggal_lahir;?></td> </tr>
                                    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Umur</b></td> <td>&nbsp;:&nbsp;</td><td><?php echo $umur;?></td> </tr>
                                    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<b>No Resep</b></td> <td>&nbsp;:&nbsp;</td><td><?php echo $original_plaintext;?></td> </tr>
                                    <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Nama Dokter</b></td> <td>&nbsp;:&nbsp;</td><td><?php echo $nama_dokter;?></td> </tr>
                                </table>
                                <?php
                                }else{
                                if(isset($_POST['proses'])){
                                $idresep = $_POST['proses'];
                                $oid = $_POST['oid'];
                                $trx = $_POST['trx'];
                                //echo "$uname";
                                if(!empty($oid)){
                                for($a = 0; $a < count($oid); $a++){
                                if(!empty($oid[$a])){
                                $oids = $oid[$a];
                                $trxs = $trx[$a];
                                if($trxs=="" or $trxs=="0"){}else{
                                $querydp = mysqli_query($koneksi, "select * from data_penjualan WHERE id_transaksi='$trxs'")
                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                // ambil jumlah baris data hasil query
                                $rowsdp = mysqli_num_rows($querydp);
                                if ($rowsdp <> 0) {
                                $rowdp   = mysqli_fetch_assoc($querydp); 
                                $idpnj=$rowdp['id_penjualan'];                                  
                                }
                                mysqli_query($koneksi,"update penjualan set setatus='Closed' where id_penjualan='$idpnj'");
                                mysqli_query($koneksi,"update data_penjualan set setatus='Closed' where  id_transaksi='$trxs'");                                   
                                }
                                $queryb = mysqli_query($koneksi, "select * from permintaan_barang_resep WHERE id_data_resep='$oids'")
                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                // ambil jumlah baris data hasil query
                                $rowsb = mysqli_num_rows($queryb);
                                if ($rowsb <> 0) {
                                $queryd = mysqli_query($koneksi, "select * from data_resep WHERE id_data_resep='$oids'")
                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                // ambil jumlah baris data hasil query
                                $rowsd = mysqli_num_rows($queryd);
                                if ($rowsd <> 0) {
                                $rowd   = mysqli_fetch_assoc($queryd); 
                                $id_data_setok=$rowd['id_data_setok'];
                                $jumlahr=$rowd['jumlah'];
                                }                           
                                $querye = mysqli_query($koneksi, "select * from data_setok WHERE id='$id_data_setok'")
                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                // ambil jumlah baris data hasil query
                                $rowse = mysqli_num_rows($querye);
                                if ($rowse <> 0) {
                                $rowe   = mysqli_fetch_assoc($querye); 
                                $jumawal=$rowe['jumlah'];
                                }                            
                                $sisaset=$jumawal - $jumlahr;    
                                mysqli_query($koneksi,"update data_setok set jumlah='$sisaset' where id='$id_data_setok'");
                                }
                                mysqli_query($koneksi,"update data_resep set setatus='Closed' where id_data_resep='$oids'");
                                }
                                }
                                }
                                mysqli_query($koneksi,"update resep_obat set date_updated='".date("Y-m-d H:i:s")."', operator='".USER_ID."', setatus='Closed', action='Closed' where id_resep_obat='$idresep'"); 
                                ?>
                                <script language="JavaScript">
                                    alert('Proses Closed Resep Obat Berhasil');
                                    document.location='<?php print_link("resep_obat"); ?>';
                                </script>
                                <?php 
                                }
                                //  mysqli_query($koneksi,"select * from data_resep WHERE no_rekam_medis='$precord' and setatus='Register'");
                                else{
                                ?>
                                <script language="JavaScript">
                                    alert('Dilarang Akses Add Langsung');
                                    document.location='<?php print_link(""); ?>';
                                </script>
                                <?php 
                                }
                                }?>
                            </div></div>
                            <?php $this :: display_page_errors(); ?>
                            <div  class="bg-light p-3 animated fadeIn page-content">
                                <?php
                                $key="dermawangroup";
                                $plaintext1 = "$id_user";
                                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                $iv = openssl_random_pseudo_bytes($ivlen);
                                $ciphertext_raw1 = openssl_encrypt($plaintext1, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                $hmac = hash_hmac('sha256', $ciphertext_raw1, $key, $as_binary=true);
                                $ciphertext1 = base64_encode( $iv.$hmac.$ciphertext_raw1 );
                                $reseosave="";
                                $nonracikshow="";
                                $racikshow="";
                                $itung=1;
                                $Queryd = "SELECT * FROM data_resep where id_resep_obat='$original_plaintext'";
                                $ExecQueryd = MySQLi_query($koneksi, $Queryd);
                                $rowsd = mysqli_num_rows($ExecQueryd);
                                if ($rowsd <> 0) {
                                while ($rowd=mysqli_fetch_array($ExecQueryd)){
                                $racikanke= $rowd['racikan'];
                                $idresepo= $rowd['id_resp_obat'];
                                $namobar= $rowd['nama_obat'];
                                $atminum= $rowd['aturan_minum'];
                                $nonjum=$rowd['jumlah'];
                                $nonjum=$rowd['jumlah'];
                                if($racikanke=="0"){
                            $nonrac="Nama Obat $namobar Jumlah  $nonjum Aturan Minum $atminum</br>";
                            $nonracikshow="$nonracikshow$nonrac";
                            $racikanresep="";
                            }else{
                            if($itung==$racikanke){
                            $racikanresep="Ya";
                            }else{
                            $racikanresep="Ya";
                            $itung=$itung + 1;
                            }
                            }
                            }
                            }else{
                            $racikanresep="";
                            }
                            $queryc1 = mysqli_query($koneksi, "SELECT COUNT(*) AS rl from data_resep WHERE id_resep_obat='$original_plaintext' and racikan='0' and tebus_resep=''")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                            $rowsc1 = mysqli_num_rows($queryc1);
                            if ($rowsc1 <> 0) {
                            $datnum1=mysqli_fetch_assoc($queryc1);
                            $itungdl=$datnum1['rl'];
                            }else{
                            $itungdl="0";
                            }
                            $queryc1r = mysqli_query($koneksi, "SELECT COUNT(*) AS rlr from data_resep WHERE id_resep_obat='$original_plaintext' and racikan='0' and tebus_resep='Luar'")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                            $rowsc1r = mysqli_num_rows($queryc1r);
                            if ($rowsc1r <> 0) {
                            $datnum1r=mysqli_fetch_assoc($queryc1r);
                            $itunglr=$datnum1r['rlr'];
                            }else{
                            $itunglr="0";
                            }
                            ?>
                            <?php
                            $query = mysqli_query($koneksi, "select * from data_owner")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                            $rows = mysqli_num_rows($query);
                            if ($rows <> 0) {
                            $data       = mysqli_fetch_assoc($query);
                            $nama_clinik = $data['nama'];
                            $alamat_clinik= $data['alamat'];
                            $email= $data['email'];
                            $phone= $data['phone'];
                            $logo= $data['logo'];
                        $alphon="$alamat_clinik</br>$phone";
                        $namclin="$nama_clinik";
                        }else{
                        $alphon="Print Transaksi";
                        $namclin="Clinik Medic+";
                        $logo="";
                        }
                        ?>  
                        <div class="col-md-12 comp-grid">
                            <div  class=" animated fadeIn page-content">
                                <div id="page-report-body" class="table-responsive">
                                    <form action="<?php  print_link("data_resep/proses?csrf_token=$csrf_token");?>" method="POST">
                                        <?php
                                        if($itunglr=="0"){ }else{
                                        $reseosave="Ya";
                                    echo "<b>Resep Obat Tebus Luar</b></br>";
                                    ?>
                                    <table style="width:100%">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <th style="background-color: #228b22; color:#fff;">Nama Obat</th>
                                                <th style="background-color: #228b22; color:#fff;">Jumlah</th>
                                                <th style="background-color: #228b22; color:#fff;">Aturan</th>
                                                <th style="background-color: #228b22; color:#fff;">Action</th>
                                            </tr>
                                            </thead><tbody class="page-data">
                                            <?php
                                            $Querrslr = "SELECT * FROM data_resep where id_resep_obat='$original_plaintext' and racikan='0' and tebus_resep='Luar'";
                                            $ExecQuerrslr = MySQLi_query($koneksi, $Querrslr);
                                            while ($ronlr=mysqli_fetch_array($ExecQuerrslr)){
                                            $namobarl= $ronlr['nama_obat'];
                                            $iddatal= $ronlr['id_data_resep'];
                                            $atminuml= $ronlr['aturan_minum'];
                                            $nonjuml=$ronlr['jumlah'];
                                            $keterl=$ronlr['keterangan'];
                                            $tanggal=$ronlr['tanggal'];
                                            $norm=$ronlr['no_rekam_medis'];
                                            $nama_pasien=$ronlr['nama_pasien'];
                                            ?>
                                            <tr><td> <?php echo $namobarl;?></td><td>&nbsp;&nbsp; <?php echo $nonjuml;?></td><td>&nbsp;&nbsp; <?php echo $atminuml;?></td><td>
                                                <input type="hidden" name="oid[]" value="<?php echo $ronlr['id_data_resep']; ?>"/>
                                                    <input type="hidden" name="trx[]" value="<?php echo $ronlr['id_transaksi']; ?>"/>
                                                    </td></tr>
                                                    <?php
                                                    }
                                                echo "</tbody></table>";
                                                }
                                                if($itungdl=="0"){ }else{  
                                                $reseosave="Ya";
                                            echo "<b>Resep Obat</b></br>";
                                            ?>
                                            <table style="width:100%"><tr>
                                                <th style="background-color: #228b22; color:#fff;">Nama Obat</th>
                                                <th style="background-color: #228b22; color:#fff;">Jumlah</th>
                                                <th style="background-color: #228b22; color:#fff;">Aturan</th>
                                                <?php if(USER_ROLE==5 or USER_ROLE==1){?>
                                                <th style="background-color: #228b22; color:#fff;">Ket Stok</th>
                                                <?php }?>
                                                <th style="background-color: #228b22; color:#fff;">Action</th>
                                            </tr>
                                            <?php
                                            $Querrsdl = "SELECT * FROM data_resep where id_resep_obat='$original_plaintext' and racikan='0' and tebus_resep='' ";
                                            $ExecQuerrsdl = MySQLi_query($koneksi, $Querrsdl);
                                            while ($ron=mysqli_fetch_array($ExecQuerrsdl)){
                                            $namobar= $ron['nama_obat'];
                                            $iddata= $ron['id_data_resep'];
                                            $atminum= $ron['aturan_minum'];
                                            $nonjum=$ron['jumlah'];
                                            $keter=$ron['keterangan'];
                                            $tanggal=$ron['tanggal'];
                                            $ketsetok=$ron['ket_setok'];
                                            $norm=$ron['no_rekam_medis'];
                                            $nama_pasien=$ron['nama_pasien'];
                                            ?>
                                            <tr><td> <?php echo $namobar;?></td><td>&nbsp;&nbsp; <?php echo $nonjum;?></td><td>&nbsp;&nbsp; <?php echo $atminum;?></td>
                                                <?php if(USER_ROLE==5 or USER_ROLE==1){?>
                                                <td>&nbsp;&nbsp; <?php echo $ketsetok;?></td>
                                                <?php }?>
                                                <td>
                                                    <input type="hidden" name="oid[]" value="<?php echo $ron['id_data_resep']; ?>"/>
                                                        <input type="hidden" name="trx[]" value="<?php echo $ron['id_transaksi']; ?>"/>
                                                            <div align="center" id="divToPrint<?php echo $ron['id_obat']; ?>" style="display:none;">
                                                                <div   style="width:290px;height:auto;">
                                                                    <!DOCTYPE html>
                                                                    <html>
                                                                        <head>
                                                                            <title>Print Resep</title>
                                                                            <style>
                                                                                @page {
                                                                                margin: 0px;
                                                                                font-family: Arial, Helvetica, sans-serif;
                                                                                }
                                                                                body,
                                                                                h1,
                                                                                h2,
                                                                                h3,
                                                                                h4,
                                                                                h5,
                                                                                h6 {
                                                                                margin: 0px;
                                                                                padding: 0px;
                                                                                font-family: Arial, Helvetica, sans-serif;
                                                                                }
                                                                                small {
                                                                                font-size: 12px;
                                                                                color: #888;
                                                                                }
                                                                                .ajax-page-load-indicator {
                                                                                display: none;
                                                                                visibility: hidden;
                                                                                }
                                                                                #report-header {
                                                                                position: relative;
                                                                                border-top: 1px solid #0066cc;
                                                                                border-bottom: 1px solid #0066cc;
                                                                                background: #fafafa;
                                                                                padding: 3px;
                                                                                }
                                                                                #report-strip {
                                                                                position: relative;
                                                                                border-bottom: 3px solid #0066cc;
                                                                                margin-bottom: 5px;
                                                                                margin-top: 5px;
                                                                                }
                                                                                #report-header table{
                                                                                margin:0;
                                                                                }
                                                                                #report-header .sub-title {
                                                                                font-size: small;
                                                                                color: #888;
                                                                                }
                                                                                #report-header img {
                                                                                height: 30px;
                                                                                width: 30px;
                                                                                }
                                                                                #report-title {
                                                                                background: #fafafa;
                                                                                margin-top: 20px;
                                                                                margin-bottom: 20px;
                                                                                padding: 10px 20px;
                                                                                font-size: 24px;
                                                                                }
                                                                                #report-body{
                                                                                padding: 2px;
                                                                                }
                                                                                #report-footer {
                                                                                padding: 10px;
                                                                                background: #fafafa;
                                                                                border-top: 2px solid #0066cc;
                                                                                position: absolute;
                                                                                bottom: 0;
                                                                                left:0;
                                                                                width: 98%;
                                                                                overflow: hidden;
                                                                                margin: 0 auto;
                                                                                }
                                                                                #report-footer table{
                                                                                margin: 0;
                                                                                overflow: hidden;
                                                                                }
                                                                                .table-responsive.table-bordered {
                                                                                border: 0;
                                                                                }
                                                                            </style>
                                                                        </head>
                                                                        <?php
                                                                        $quetrx= mysqli_query($koneksi, "SELECT * FROM data_pasien where no_rekam_medis='$norm'")
                                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                        // ambil jumlah baris data hasil query
                                                                        $rotrx = mysqli_num_rows($quetrx);
                                                                        if ($rotrx <> 0) {
                                                                        $dattrx      = mysqli_fetch_assoc($quetrx);
                                                                        $tanggal_lahir=$dattrx['tanggal_lahir'];
                                                                        $tl=$dattrx['tl'];
                                                                        // $norm=$dattrx['no_rekam_medis'];
                                                                        }
                                                                        ?>
                                                                        <body>
                                                                            <div align="center" id="report-header">
                                                                                <table class="table table-sm">
                                                                                    <tr>
                                                                                        <th align="left" valign="middle" width="30">
                                                                                            <?php
                                                                                            if(!empty($logo)){
                                                                                            ?><?php Html :: page_img($logo,30,30,1); ?>
                                                                                            <?php
                                                                                            }else{
                                                                                            ?>
                                                                                            <img src="<?php  print_link("".SITE_FAVICON);?>">
                                                                                                <?php
                                                                                                }?>
                                                                                            </th>
                                                                                            <th align="left" valign="middle">
                                                                                                <h3 class="company-name"><?php echo $namclin;?></h3>
                                                                                            </th>
                                                                                        </tr>
                                                                                    </table>
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td align="middle" valign="middle">
                                                                                                <div >
                                                                                                    <?php echo $alphon;?>
                                                                                                </div>
                                                                                            </td>    
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>   
                                                                                <div id="report-body">
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td valign="left">
                                                                                                <div align="left"> TGL: <?php echo $tanggal;?> </div>   
                                                                                            </td>
                                                                                            <td>&nbsp;&nbsp;</td>
                                                                                            <td  valign="right">
                                                                                                <div align="right">No RM: <?php echo $norm;?> </div>    
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    <div align="center"><b><?php echo $tl;?> <?php echo $nama_pasien;?></b></div>
                                                                                    <div align="center">TGL Lahir: <?php echo $tanggal_lahir;?></div>
                                                                                    <div align="center"><b><?php echo $atminum;?></b></div>
                                                                                    <div align="left"><?php echo $namobar;?> (<?php echo $nonjum;?>)</div>  
                                                                                </div>
                                                                            </body>
                                                                        </html> 
                                                                    </div>
                                                                </div>
                                                                <input type="button" class="btn btn-sm btn-primary has-tooltip"value="Print Label" onclick="PrintDiv<?php echo $ron['id_obat']; ?>();" />
                                                                </td></tr>
                                                                <script type="text/javascript">     
                                                                    function PrintDiv<?php echo $ron['id_obat']; ?>() {    
                                                                    var divToPrint = document.getElementById('divToPrint<?php echo $ron['id_obat']; ?>');
                                                                    var popupWin = window.open('<?php  print_link("data_resep/proses?csrf_token=$csrf_token&precord=$ciphertext&print=$ciphertext&resep=Luar&proses=print");?>', '_blank');
                                                                    popupWin.document.open();
                                                                    popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
                                                                        popupWin.document.close();
                                                                        }
                                                                    </script>
                                                                    <?php
                                                                    }
                                                                echo "</table>";
                                                                }
                                                                //////////////////////////////////
                                                                if($racikanresep=="Ya"){
                                                                for ($x = 1; $x <= $itung; $x++) {
                                                                $Quercek = "SELECT * FROM data_resep where id_resep_obat='$original_plaintext' and racikan='$x'";
                                                                $ExecQuercek = MySQLi_query($koneksi, $Quercek);
                                                                while ($datcek=mysqli_fetch_array($ExecQuercek)){
                                                                $cekluarracik= $datcek['tebus_resep'];
                                                                }
                                                                if($cekluarracik==""){
                                                                $luarshow="";
                                                                }else{
                                                                $luarshow="Tebus Luar";
                                                                }
                                                                $Quer = "SELECT * FROM data_resep where id_resep_obat='$original_plaintext' and racikan='$x'";
                                                                $ExecQuer = MySQLi_query($koneksi, $Quer);
                                                            echo "<b>Racikan Ke $x $luarshow</b></br>";
                                                            ?>
                                                            <table style="width:100%">
                                                                <tr>
                                                                    <th style="background-color: #228b22; color:#fff;">Nama Obat</th>
                                                                    <th style="background-color: #228b22; color:#fff;">Jumlah</th>
                                                                    <?php if(USER_ROLE==5 or USER_ROLE==1){?>
                                                                    <th style="background-color: #228b22; color:#fff;">Ket Stok</th>
                                                                    <?php }?>
                                                                    <th style="background-color: #228b22; color:#fff;">Action</th>
                                                                </tr>
                                                                <?php
                                                                while ($rorac=mysqli_fetch_array($ExecQuer)){
                                                                $iddata= $rorac['id_data_resep'];
                                                                $namobar= $rorac['nama_obat'];
                                                                $atminum= $rorac['aturan_minum'];
                                                                $nonjum=$rorac['jumlah'];
                                                                $keter=$rorac['keterangan'];
                                                                $tanggal=$rorac['tanggal'];
                                                                $ketsetok=$rorac['ket_setok'];
                                                                $norm=$rorac['no_rekam_medis'];
                                                                $nama_pasien=$rorac['nama_pasien'];
                                                                ?>
                                                                <tr><td> <?php echo $namobar;?></td><td>&nbsp;&nbsp; <?php echo $nonjum;?></td>
                                                                    <?php if(USER_ROLE==5 or USER_ROLE==1){?>
                                                                    <td>&nbsp;&nbsp; <?php echo $ketsetok;?></td><?php }?>
                                                                    <td>
                                                                        <input type="hidden" name="oid[]" value="<?php echo $rorac['id_data_resep']; ?>"/>
                                                                            <input type="hidden" name="trx[]" value="<?php echo $ron['id_transaksi']; ?>"/>
                                                                            </td></tr>
                                                                            <?php       
                                                                            }
                                                                            echo "<tr><td>Aturan Minum : </br>$atminum</td>  <td>Keterangan : </br>$keter</td> <td>";?> 
                                                                            <div align="center" id="divToPrintracik" style="display:none;">
                                                                                <div   style="width:290px;height:auto;">
                                                                                    <!DOCTYPE html>
                                                                                    <html>
                                                                                        <head>
                                                                                            <title>Print Resep</title>
                                                                                            <style>
                                                                                                @page {
                                                                                                margin: 0px;
                                                                                                font-family: Arial, Helvetica, sans-serif;
                                                                                                }
                                                                                                body,
                                                                                                h1,
                                                                                                h2,
                                                                                                h3,
                                                                                                h4,
                                                                                                h5,
                                                                                                h6 {
                                                                                                margin: 0px;
                                                                                                padding: 0px;
                                                                                                font-family: Arial, Helvetica, sans-serif;
                                                                                                }
                                                                                                small {
                                                                                                font-size: 12px;
                                                                                                color: #888;
                                                                                                }
                                                                                                .ajax-page-load-indicator {
                                                                                                display: none;
                                                                                                visibility: hidden;
                                                                                                }
                                                                                                #report-header {
                                                                                                position: relative;
                                                                                                border-top: 1px solid #0066cc;
                                                                                                border-bottom: 1px solid #0066cc;
                                                                                                background: #fafafa;
                                                                                                padding: 3px;
                                                                                                }
                                                                                                #report-strip {
                                                                                                position: relative;
                                                                                                border-bottom: 3px solid #0066cc;
                                                                                                margin-bottom: 5px;
                                                                                                margin-top: 5px;
                                                                                                }
                                                                                                #report-header table{
                                                                                                margin:0;
                                                                                                }
                                                                                                #report-header .sub-title {
                                                                                                font-size: small;
                                                                                                color: #888;
                                                                                                }
                                                                                                #report-header img {
                                                                                                height: 30px;
                                                                                                width: 30px;
                                                                                                }
                                                                                                #report-title {
                                                                                                background: #fafafa;
                                                                                                margin-top: 20px;
                                                                                                margin-bottom: 20px;
                                                                                                padding: 10px 20px;
                                                                                                font-size: 24px;
                                                                                                }
                                                                                                #report-body{
                                                                                                padding: 2px;
                                                                                                }
                                                                                                #report-footer {
                                                                                                padding: 10px;
                                                                                                background: #fafafa;
                                                                                                border-top: 2px solid #0066cc;
                                                                                                position: absolute;
                                                                                                bottom: 0;
                                                                                                left:0;
                                                                                                width: 98%;
                                                                                                overflow: hidden;
                                                                                                margin: 0 auto;
                                                                                                }
                                                                                                #report-footer table{
                                                                                                margin: 0;
                                                                                                overflow: hidden;
                                                                                                }
                                                                                                .table-responsive.table-bordered {
                                                                                                border: 0;
                                                                                                }
                                                                                            </style>
                                                                                        </head>
                                                                                        <?php
                                                                                        $quetrx= mysqli_query($koneksi, "SELECT * FROM data_pasien where no_rekam_medis='$norm'")
                                                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                        // ambil jumlah baris data hasil query
                                                                                        $rotrx = mysqli_num_rows($quetrx);
                                                                                        if ($rotrx <> 0) {
                                                                                        $dattrx      = mysqli_fetch_assoc($quetrx);
                                                                                        $tanggal_lahir=$dattrx['tanggal_lahir'];
                                                                                        $tl=$dattrx['tl'];
                                                                                        // $norm=$dattrx['no_rekam_medis'];
                                                                                        }
                                                                                        ?>
                                                                                        <body>
                                                                                            <div align="center" id="report-header">
                                                                                                <table class="table table-sm">
                                                                                                    <tr>
                                                                                                        <th align="left" valign="middle" width="30">
                                                                                                            <?php
                                                                                                            if(!empty($logo)){
                                                                                                            ?><?php Html :: page_img($logo,30,30,1); ?>
                                                                                                            <?php
                                                                                                            }else{
                                                                                                            ?>
                                                                                                            <img src="<?php  print_link("".SITE_FAVICON);?>">
                                                                                                                <?php
                                                                                                                }?>
                                                                                                            </th>
                                                                                                            <th align="left" valign="middle">
                                                                                                                <h3 class="company-name"><?php echo $namclin;?></h3>
                                                                                                            </th>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                    <table>
                                                                                                        <tr>
                                                                                                            <td align="middle" valign="middle">
                                                                                                                <div >
                                                                                                                    <?php echo $alphon;?>
                                                                                                                </div>
                                                                                                            </td>    
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </div>   
                                                                                                <div id="report-body">
                                                                                                    <table>
                                                                                                        <tr>
                                                                                                            <td valign="left">
                                                                                                                <div align="left"> TGL: <?php echo $tanggal;?> </div>   
                                                                                                            </td>
                                                                                                            <td>&nbsp;&nbsp;</td>
                                                                                                            <td  valign="right">
                                                                                                                <div align="right">No RM: <?php echo $norm;?> </div>    
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                    <div align="center"><b><?php echo $tl;?> <?php echo $nama_pasien;?></b></div>
                                                                                                    <div align="center">TGL Lahir: <?php echo $tanggal_lahir;?></div>
                                                                                                    <div align="center"><b><?php echo $atminum;?></b></div>
                                                                                                </div>
                                                                                            </body>
                                                                                        </html> 
                                                                                    </div>
                                                                                </div>
                                                                                <input type="button" class="btn btn-sm btn-primary has-tooltip"value="Print Label" onclick="PrintDivracik();" /> 
                                                                                <script type="text/javascript">     
                                                                                    function PrintDivracik() {    
                                                                                    var divToPrint = document.getElementById('divToPrintracik');
                                                                                    var popupWin = window.open('<?php  print_link("data_resep/proses?csrf_token=$csrf_token&precord=$ciphertext&print=$ciphertext&resep=Luar&proses=print");?>', '_blank');
                                                                                    popupWin.document.open();
                                                                                    popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
                                                                                        popupWin.document.close();
                                                                                        }
                                                                                    </script>
                                                                                    <?php
                                                                                echo "</td></tr></table>";
                                                                                }
                                                                                $reseosave="Ya";
                                                                                }
                                                                                // if(!empty($_GET['resep'])){
                                                                                //  if($resepget=="Luar"){
                                                                                ?>
                                                                                <?php
                                                                                $key="dermawangroup";
                                                                                $plaintext = "$original_plaintext";
                                                                                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                                                $iv = openssl_random_pseudo_bytes($ivlen);
                                                                                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                                                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                                                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                                                ?>
                                                                                <script type="text/javascript">     
                                                                                    function PrintDiv() {    
                                                                                    var divToPrint = document.getElementById('divToPrint');
                                                                                    var popupWin = window.open('<?php  print_link("data_resep/proses?csrf_token=$csrf_token&precord=$ciphertext&print=$ciphertext&resep=Luar&proses=print");?>', '_blank');
                                                                                    popupWin.document.open();
                                                                                    popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
                                                                                        popupWin.document.close();
                                                                                        }
                                                                                    </script>
                                                                                </br>
                                                                                <?php
                                                                                if(!empty($_GET['print'])){
                                                                                if(!empty($_GET['resep'])){
                                                                                ?> 
                                                                                <input type="button" class="btn btn-sm btn-primary has-tooltip"value="Print Resep Obat Luar" onclick="PrintDiv();" />
                                                                                <?php
                                                                                }else{
                                                                                ?>
                                                                                <input type="button" class="btn btn-sm btn-primary has-tooltip"value="Print Copy Resep" onclick="PrintDiv();" />
                                                                                <?php
                                                                                }
                                                                                }else{
                                                                                if(!empty($_GET['view'])){
                                                                                // echo "Detile Resep Obat";
                                                                                }else{
                                                                                $setcek="";
                                                                                $sqlceko = mysqli_query($koneksi,"SELECT * FROM data_resep where id_resep_obat='$original_plaintext'");
                                                                                while ($datpob = MySQLi_fetch_array($sqlceko)) {
                                                                                $sqlcekper = mysqli_query($koneksi,"select * from permintaan_barang_resep WHERE id_data_resep='".$datpob['id_data_resep']."'"); 
                                                                                while ($datpo = MySQLi_fetch_array($sqlcekper)) { 
                                                                                $seto=$datpo['setatus'];  
                                                                                if($seto=="Di Terima Dan Closed"){
                                                                                }else{
                                                                                $setcek="ya"; 
                                                                                }
                                                                                }
                                                                                }
                                                                                if($setcek==""){
                                                                                ?>
                                                                                <button type="submit" class="btn btn-success" name="proses" value="<?php echo $original_plaintext;?>">Proses Closed Resep Obat</button>
                                                                                <?php                            
                                                                                }else{
                                                                                echo "Barang Dari Gudang Belum Di Terima!, Belum Bisa Di Proses Closed";
                                                                                }
                                                                                }
                                                                                } 
                                                                                ?>
                                                                            </form>
                                                                        </div>
                                                                    </div></div>
                                                                    <div align="center" id="divToPrint" style="display:none;">
                                                                        <div  align="center" style="width:300px;height:auto;">
                                                                            <?php $id_user = "".USER_ID;
                                                                            $dbhost  = "".DB_HOST;
                                                                            $dbuser  = "".DB_USERNAME;
                                                                            $dbpass  = "".DB_PASSWORD;
                                                                            $dbname  = "".DB_NAME;
                                                                            //$koneksi=open_connection();
                                                                            $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                                            if(!empty($_GET['precord'])){
                                                                            $ciphertext = $_GET['precord'];
                                                                            $ciphertext=str_replace(' ', '+', $ciphertext);
                                                                            $key="dermawangroup";
                                                                            $c = base64_decode($ciphertext);
                                                                            $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                                            $iv = substr($c, 0, $ivlen);
                                                                            $hmac = substr($c, $ivlen, $sha2len=32);
                                                                            $ciphertext_raw = substr($c, $ivlen+$sha2len);
                                                                            $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                                            $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                                            if (hash_equals($hmac, $calcmac))// timing attack safe comparison
                                                                            {
                                                                            // echo $original_plaintext."\n";
                                                                            }
                                                                            $precord="$original_plaintext";
                                                                            $sql = mysqli_query($koneksi,"select * from resep_obat WHERE id_resep_obat='$original_plaintext'");
                                                                            while ($row=mysqli_fetch_array($sql)){
                                                                            $rekam=$row['no_rekam_medis'];
                                                                            $tgl=$row['tanggal'];
                                                                            $nama_dokter=$row['nama_dokter'];
                                                                            }
                                                                            $sqlcek2 = mysqli_query($koneksi,"select * from data_resep WHERE id_resep_obat='$original_plaintext'");
                                                                            while ($row2=mysqli_fetch_array($sqlcek2)){
                                                                            $norekam=$row2['no_rekam_medis'];
                                                                            $alamat=$row2['alamat'];
                                                                            $nama_pasien=$row2['nama_pasien'];
                                                                            $tanggal_lahir=$row2['tanggal_lahir'];
                                                                            $tanggal=$row2['tanggal'];
                                                                            $umur=$row2['umur'];
                                                                            }
                                                                            ?>
                                                                            <!DOCTYPE html>
                                                                            <html>
                                                                                <head>
                                                                                    <title>Print Resep</title>
                                                                                    <style>
                                                                                        @page {
                                                                                        margin: 0px;
                                                                                        font-family: Arial, Helvetica, sans-serif;
                                                                                        }
                                                                                        body,
                                                                                        h1,
                                                                                        h2,
                                                                                        h3,
                                                                                        h4,
                                                                                        h5,
                                                                                        h6 {
                                                                                        margin: 0px;
                                                                                        padding: 0px;
                                                                                        font-family: Arial, Helvetica, sans-serif;
                                                                                        }
                                                                                        small {
                                                                                        font-size: 12px;
                                                                                        color: #888;
                                                                                        }
                                                                                        .ajax-page-load-indicator {
                                                                                        display: none;
                                                                                        visibility: hidden;
                                                                                        }
                                                                                        #report-header {
                                                                                        position: relative;
                                                                                        border-top: 3px solid #0066cc;
                                                                                        border-bottom: 3px solid #0066cc;
                                                                                        background: #fafafa;
                                                                                        padding: 10px;
                                                                                        }
                                                                                        #report-strip {
                                                                                        position: relative;
                                                                                        border-bottom: 3px solid #0066cc;
                                                                                        margin-bottom: 5px;
                                                                                        margin-top: 5px;
                                                                                        }
                                                                                        #report-header table{
                                                                                        margin:0;
                                                                                        }
                                                                                        #report-header .sub-title {
                                                                                        font-size: small;
                                                                                        color: #888;
                                                                                        }
                                                                                        #report-header img {
                                                                                        height: 50px;
                                                                                        width: 50px;
                                                                                        }
                                                                                        #report-title {
                                                                                        background: #fafafa;
                                                                                        margin-top: 20px;
                                                                                        margin-bottom: 20px;
                                                                                        padding: 10px 20px;
                                                                                        font-size: 24px;
                                                                                        }
                                                                                        #report-body{
                                                                                        padding: 2px;
                                                                                        }
                                                                                        #report-footer {
                                                                                        padding: 10px;
                                                                                        background: #fafafa;
                                                                                        border-top: 2px solid #0066cc;
                                                                                        position: absolute;
                                                                                        bottom: 0;
                                                                                        left:0;
                                                                                        width: 98%;
                                                                                        overflow: hidden;
                                                                                        margin: 0 auto;
                                                                                        }
                                                                                        #report-footer table{
                                                                                        margin: 0;
                                                                                        overflow: hidden;
                                                                                        }
                                                                                        .table-responsive.table-bordered {
                                                                                        border: 0;
                                                                                        }
                                                                                    </style>
                                                                                </head>
                                                                                <?php
                                                                                $query = mysqli_query($koneksi, "select * from data_owner")
                                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                $rows = mysqli_num_rows($query);
                                                                                if ($rows <> 0) {
                                                                                $datao       = mysqli_fetch_assoc($query);
                                                                                $nama_clinik = $datao['nama'];
                                                                                $alamat_clinik= $datao['alamat'];
                                                                                $email= $datao['email'];
                                                                                $phone= $datao['phone'];
                                                                                $logo= $datao['logo'];
                                                                            $infoown="$nama_clinik</br>$alamat_clinik</br>$email</br>$phone";
                                                                            }else{
                                                                            $infoown="Print Resep Obat";
                                                                            }
                                                                            ?>
                                                                            <body>
                                                                                <div id="report-header">
                                                                                    <table class="table table-sm">
                                                                                        <tr>
                                                                                            <th align="left" valign="middle" width="50">
                                                                                                <?php
                                                                                                if(!empty($logo)){
                                                                                                ?><?php Html :: page_img($logo,40,40,1); ?>
                                                                                                <?php
                                                                                                }else{
                                                                                                ?>
                                                                                                <img src="<?php  print_link("".SITE_FAVICON);?>">
                                                                                                    <?php
                                                                                                    }?>
                                                                                                </th>
                                                                                                <th align="right" valign="middle">
                                                                                                    <div class="company-info">
                                                                                                        <?php echo $infoown;?>
                                                                                                    </div>
                                                                                                </th>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>   
                                                                                    <div id="report-body">
                                                                                        <div class="ajax-page-load-indicator" style="display:none">
                                                                                            <div class="text-center d-flex justify-content-center load-indicator">
                                                                                                <span class="loader mr-3"></span>
                                                                                                <span class="font-weight-bold">Loading...</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <table id="report-strip">
                                                                                            <tr><td><b>Tanggal</b></td> <td>&nbsp;:&nbsp;</td><td><?php echo $tanggal;?></td> </tr>
                                                                                            <tr><td><b>No Rekam</b></td> <td>&nbsp;:&nbsp;</td><td><?php echo $norekam;?></td> </tr>
                                                                                            <tr><td><b>Nama Pasien</b></td> <td>&nbsp;:&nbsp;</td> <td><?php echo $nama_pasien;?></td>
                                                                                                <tr><td><b>Alamat</b></td> <td>&nbsp;:&nbsp;</td> <td><?php echo $alamat;?></td>
                                                                                                    <tr><td><b>Tgl Lahir</b></td> <td>&nbsp;:&nbsp;</td><td><?php echo $tanggal_lahir;?></td> </tr>
                                                                                                    <tr><td><b>Umur</b></td> <td>&nbsp;:&nbsp;</td><td><?php echo $umur;?></td> </tr>
                                                                                                    <tr><td><b>No Resep</b></td> <td>&nbsp;:&nbsp;</td><td><?php echo $original_plaintext;?></td> </tr>
                                                                                                    <tr><td><b>Nama Dokter</b></td> <td>&nbsp;:&nbsp;</td><td><?php echo $nama_dokter;?></td> </tr>
                                                                                                </table>
                                                                                                <table  align="left" id="report-strip">
                                                                                                    <thead align="left">
                                                                                                        <tr>
                                                                                                            <th  align="left">Nama Obat</th>
                                                                                                            <th  align="left" style="width:120px;">Aturan Minum</th>
                                                                                                            <th  align="left" width="auto">QTY</th>
                                                                                                        </tr></thead>
                                                                                                        <tbody class="page-data" id="page-data-list-page-ai3xsqp1b4me">
                                                                                                            <!--record-->
                                                                                                            <?php
                                                                                                            if(!empty($_GET['resep'])){
                                                                                                            $resepget=$_GET['resep'];
                                                                                                            if($resepget=="Luar"){
                                                                                                            $cek2 = mysqli_query($koneksi,"select * from data_resep WHERE id_resep_obat='$original_plaintext' and tebus_resep='Luar'");
                                                                                                            }else{
                                                                                                            $cek2 = mysqli_query($koneksi,"select * from data_resep WHERE id_resep_obat='$original_plaintext'");  
                                                                                                            }
                                                                                                            }else{
                                                                                                            $cek2 = mysqli_query($koneksi,"select * from data_resep WHERE id_resep_obat='$original_plaintext'");
                                                                                                            }
                                                                                                            while ($data=mysqli_fetch_array($cek2)){
                                                                                                            // $nama_dokter=$data['nama_dokter'];       
                                                                                                            ?>  <tr>   <input type="hidden" name="oid[]" value="<?php echo $data['id_data_resep']; ?>"/>
                                                                                                                <input type="hidden" name="trx[]" value="<?php echo $ron['id_transaksi']; ?>"/>
                                                                                                                    <td><?php echo $data['nama_obat']; ?></td>  
                                                                                                                    <td><?php echo $data['aturan_minum']; ?></td> 
                                                                                                                    <td><?php echo $data['jumlah']; ?></td>  
                                                                                                                </tr> 
                                                                                                                <?php }
                                                                                                            ?></tbody>
                                                                                                        </table>  
                                                                                                    </div>
                                                                                                </body>
                                                                                            </html>
                                                                                            <?php }
                                                                                            ?>  
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
