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
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <div class=""><div>
                        <?php
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        if(USER_ROLE==8){
                        $divisi="IGD";
                        $bagian="IGD";
                        }else if(USER_ROLE==6){
                        $divisi="POLI";
                        $bagian=$_SESSION[APP_ID.'user_data']['admin_poli'];
                        }else  if(USER_ROLE==13){
                        $divisi="RANAP";
                        $bagian=$_SESSION[APP_ID.'user_data']['admin_ranap'];   
                        }else if(USER_ROLE==5){
                        $divisi = "FARMASI";
                        $bag    = "FARMASI";   
                        $bagian=$bag;
                        }else{
                        $divisi="";
                        $bagian="";     
                        }
                        if(isset($_POST['norequest'])){
                        $norequest=$_POST['norequest'];
                        $divisi=$_POST['divisi'];
                        $queryjum = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jum from data_permintaan_barang WHERE no_request='$norequest'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $sumjum = mysqli_fetch_assoc($queryjum); 
                        $totjum=$sumjum['jum'];
                        mysqli_query($koneksi, "UPDATE permintaan_barang SET divisi='$divisi', total_jumlah='$totjum', setatus='Register' WHERE no_request='$norequest'"); 
                        mysqli_query($koneksi, "UPDATE data_permintaan_barang SET setatus='Register' WHERE no_request='$norequest'"); 
                        ?>
                        <script language="JavaScript">
                            alert('Permintaan Barang Berhasil Di Proses');
                            document.location='<?php print_link("permintaan_barang"); ?>';
                        </script>
                        <?php    
                        }
                        if(isset($_POST['kirim'])){ 
                        $kirim=$_POST['kirim'];
                        $token=$_POST['token'];
                        $qudtpab = mysqli_query($koneksi, "SELECT * from data_permintaan_barang WHERE no_request='$kirim'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        while ($datpb = MySQLi_fetch_array($qudtpab)) {
                        $kode= $datpb['kode_barang'];
                        $jumreq= $datpb['jumlah'];
                        $quset = mysqli_query($koneksi, "SELECT * from setok_barang WHERE kode_barang='$kode'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        while ($dats = MySQLi_fetch_array($quset)) {
                        $idset=$dats['id_barang'];
                        $setjum=$dats['jumlah'];
                        $siajum=$setjum - $jumreq; 
                        mysqli_query($koneksi,"UPDATE setok_barang SET jumlah='$siajum' WHERE id_barang='$idset'");
                        }
                        }
                        mysqli_query($koneksi,"UPDATE permintaan_barang SET setatus='Di Kirim', date_updated='".date("Y-m-d H:i:s")."' WHERE no_request='$kirim'");
                        ?>
                        <script language="JavaScript">
                            alert('Kirim Barang Berhasil Di Proses');
                            document.location='<?php print_link("permintaan_barang"); ?>';
                        </script>
                        <?php    
                        }
                        ////////////////////////////////   
                        if(isset($_POST['terimaresep'])){ 
                        $kirim=$_POST['terimaresep'];
                        $qur = mysqli_query($koneksi, "SELECT * from permintaan_barang_resep WHERE id='$kirim'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        while ($dar = MySQLi_fetch_array($qur)) {
                        $kode= $dar['kode_barang'];
                        $jumreq= $dar['jumlah'];
                        $nama_barang= $dar['nama_barang'];
                        $category_barang= $dar['category_barang'];
                        $operator= $dar['operator'];   
                        $id_data_resep= $dar['id_data_resep'];
                        $quset = mysqli_query($koneksi, "SELECT * from data_setok WHERE kode_barang='$kode' and divisi='FARMASI' and bagian='FARMASI'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        $rod = mysqli_num_rows($quset);
                        if ($rod <> 0) {
                        $cdt= mysqli_fetch_assoc($quset);
                        $iddat=$cdt['id'];
                        $datjum=$cdt['jumlah'];
                        $awaljum=$cdt['setok_awal'];
                        $jumawal=$awaljum + $jumreq;
                        $jumsek=$datjum + $jumreq;
                        mysqli_query($koneksi,"UPDATE data_setok SET setok_awal='$jumawal', jumlah='$jumsek' WHERE id='$iddat'");
                        }
                        mysqli_query($koneksi, "UPDATE permintaan_barang_resep SET setatus='Di Terima Dan Closed' WHERE id='$kirim'");  
                        mysqli_query($koneksi, "UPDATE data_resep SET id_data_setok='$iddat' WHERE id_data_resep='$id_data_resep'"); 
                        }   
                        ?>
                        <script language="JavaScript">
                            alert('Terima Barang Berhasil Di Proses');
                            document.location='<?php print_link("permintaan_barang_resep"); ?>';
                        </script>
                        <?php 
                        }
                        if(isset($_POST['terimaall'])){ 
                        $qur = mysqli_query($koneksi, "SELECT * from permintaan_barang_resep WHERE setatus='Di Kirim'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        while ($dar = MySQLi_fetch_array($qur)) {
                        $iddar=$dar['id'];
                        $kode= $dar['kode_barang'];
                        $jumreq= $dar['jumlah'];
                        $nama_barang= $dar['nama_barang'];
                        $category_barang= $dar['category_barang'];
                        $operator= $dar['operator'];   
                        $id_data_resep= $dar['id_data_resep'];
                        $quset = mysqli_query($koneksi, "SELECT * from data_setok WHERE kode_barang='$kode' and divisi='FARMASI' and bagian='FARMASI'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        $rod = mysqli_num_rows($quset);
                        if ($rod <> 0) {
                        $cdt= mysqli_fetch_assoc($quset);
                        $iddat=$cdt['id'];
                        $datjum=$cdt['jumlah'];
                        $awaljum=$cdt['setok_awal'];
                        $jumawal=$awaljum + $jumreq;
                        $jumsek=$datjum + $jumreq;
                        mysqli_query($koneksi,"UPDATE data_setok SET setok_awal='$jumawal', jumlah='$jumsek' WHERE id='$iddat'");
                        }
                        mysqli_query($koneksi, "UPDATE permintaan_barang_resep SET setatus='Di Terima Dan Closed' WHERE id='$iddar'"); 
                        mysqli_query($koneksi, "UPDATE data_resep SET id_data_setok='$iddat' WHERE id_data_resep='$id_data_resep'"); 
                        }      
                        ?>
                        <script language="JavaScript">
                            alert('Terima Semua Barang Berhasil Di Proses');
                            document.location='<?php print_link("permintaan_barang_resep"); ?>';
                        </script>
                        <?php 
                        }
                        ///////////////////////////////////////////
                        if(isset($_POST['kirimresep'])){ 
                        $kirim=$_POST['kirimresep'];
                        $qur = mysqli_query($koneksi, "SELECT * from permintaan_barang_resep WHERE id='$kirim'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        while ($dar = MySQLi_fetch_array($qur)) {
                        $kode= $dar['kode_barang'];
                        $jumreq= $dar['jumlah'];
                        $nama_barang= $dar['nama_barang'];
                        $category_barang= $dar['category_barang'];
                        $operator= $dar['operator'];   
                        $quset = mysqli_query($koneksi, "SELECT * from data_setok WHERE kode_barang='$kode' and divisi='FARMASI' and bagian='FARMASI'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        $rod = mysqli_num_rows($quset);
                        if ($rod <> 0) {
                        $cdt= mysqli_fetch_assoc($quset);
                        $iddat=$cdt['id'];
                        $datjum=$cdt['jumlah'];
                        $awaljum=$cdt['setok_awal'];
                        $jumawal=$awaljum + $jumreq;
                        $jumsek=$datjum + $jumreq;
                        //mysqli_query($koneksi,"UPDATE data_setok SET setok_awal='$jumawal', jumlah='$jumsek' WHERE id='$iddat'");
                        }else{
                        mysqli_query($koneksi,"INSERT INTO `data_setok`(`kode_barang`, `nama_barang`, `category_barang`, `divisi`, `bagian`) VALUES ('$kode','$nama_barang','$category_barang','FARMASI','FARMASI')");
                        }
                        mysqli_query($koneksi, "UPDATE permintaan_barang_resep SET setatus='Di Kirim' WHERE id='$kirim'");                         
                        }                            
                        ?>
                        <script language="JavaScript">
                            alert('Kirim Barang Berhasil Di Proses');
                            document.location='<?php print_link("permintaan_barang_resep"); ?>';
                        </script>
                        <?php  
                        }
                        if(isset($_POST['kirimall'])){ 
                        $qur = mysqli_query($koneksi, "SELECT * from permintaan_barang_resep WHERE setatus='Register'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        while ($dar = MySQLi_fetch_array($qur)) {
                        $iddar=$dar['id'];
                        $kode= $dar['kode_barang'];
                        $jumreq= $dar['jumlah'];
                        $nama_barang= $dar['nama_barang'];
                        $category_barang= $dar['category_barang'];
                        $operator= $dar['operator'];   
                        $quset = mysqli_query($koneksi, "SELECT * from data_setok WHERE kode_barang='$kode' and divisi='FARMASI' and bagian='FARMASI'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        $rod = mysqli_num_rows($quset);
                        if ($rod <> 0) {
                        $cdt= mysqli_fetch_assoc($quset);
                        $iddat=$cdt['id'];
                        $datjum=$cdt['jumlah'];
                        $awaljum=$cdt['setok_awal'];
                        $jumawal=$awaljum + $jumreq;
                        $jumsek=$datjum + $jumreq;
                        //mysqli_query($koneksi,"UPDATE data_setok SET setok_awal='$jumawal', jumlah='$jumsek' WHERE id='$iddat'");
                        }else{
                        mysqli_query($koneksi,"INSERT INTO `data_setok`(`kode_barang`, `nama_barang`, `category_barang`, `divisi`, `bagian`) VALUES ('$kode','$nama_barang','$category_barang','FARMASI','FARMASI')");
                        }
                        mysqli_query($koneksi, "UPDATE permintaan_barang_resep SET setatus='Di Kirim' WHERE id='$iddar'");                         
                        }                        
                        ?>
                        <script language="JavaScript">
                            alert('Kirim Semua Barang Berhasil Di Proses');
                            document.location='<?php print_link("permintaan_barang_resep"); ?>';
                        </script>
                        <?php    
                        }
                        if(isset($_POST['terima'])){ 
                        $terima=$_POST['terima'];
                        $token=$_POST['token'];
                        $qusets = mysqli_query($koneksi, "SELECT * from permintaan_barang WHERE no_request='$terima'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        $rods = mysqli_num_rows($qusets);
                        if ($rods <> 0) {
                        $cdts= mysqli_fetch_assoc($qusets);
                        $divisi= $cdts['divisi'];
                        $bagian= $cdts['bagian'];
                        }
                        $qudtpab = mysqli_query($koneksi, "SELECT * from data_permintaan_barang WHERE no_request='$terima'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        while ($datpb = MySQLi_fetch_array($qudtpab)) {
                        $idreq= $datpb['id'];   
                        $kode= $datpb['kode_barang'];
                        $jumreq= $datpb['jumlah'];
                        $nama_barang= $datpb['nama_barang'];
                        $category_barang= $datpb['category_barang'];
                        $operator= $datpb['operator'];
                        $quset = mysqli_query($koneksi, "SELECT * from data_setok WHERE kode_barang='$kode' and divisi='$divisi' and bagian='$bagian'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        $rod = mysqli_num_rows($quset);
                        if ($rod <> 0) {
                        $cdt= mysqli_fetch_assoc($quset);
                        $iddat=$cdt['id'];
                        $datjum=$cdt['jumlah'];
                        $awaljum=$cdt['setok_awal'];
                        $jumawal=$awaljum + $jumreq;
                        $jumsek=$datjum + $jumreq;
                        mysqli_query($koneksi,"UPDATE data_setok SET setok_awal='$jumawal', jumlah='$jumsek' WHERE id='$iddat'");
                        }else{
                        mysqli_query($koneksi,"INSERT INTO `data_setok`(`setok_awal`, `kode_barang`, `nama_barang`, `category_barang`, `jumlah`, `divisi`, `bagian`, `operator`) VALUES ('$jumreq','$kode','$nama_barang','$category_barang','$jumreq','$divisi','$bagian','$operator')");
                        }
                        $sqlc= mysqli_query($koneksi,"SELECT * from data_setok WHERE kode_barang='$kode' and divisi='$divisi' and bagian='$bagian'");
                        $roc = mysqli_num_rows($sqlc);
                        if ($roc <> 0) {
                        $datc=mysqli_fetch_assoc($sqlc);
                        $iddatsetok=$datc['id'];
                        }
                        mysqli_query($koneksi,"UPDATE data_permintaan_barang SET id_data_setok='$iddatsetok' WHERE id='$idreq'");                     
                        }
                        mysqli_query($koneksi,"UPDATE permintaan_barang SET setatus='Di Terima Dan Closed', date_updated='".date("Y-m-d H:i:s")."' WHERE no_request='$terima'");
                        ?>
                        <script language="JavaScript">
                            alert('Terima Barang Berhasil Di Proses');
                            document.location='<?php print_link("permintaan_barang"); ?>';
                        </script>
                        <?php    
                        }
                        $queryin = mysqli_query($koneksi, "SELECT * from permintaan_barang WHERE idtrace='$idtrace' and setatus=''")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsin = mysqli_num_rows($queryin);
                        if ($rowsin <> 0) {
                        $datain= mysqli_fetch_assoc($queryin);
                        $id=$datain['id'];
                        $no_request=$datain['no_request'];
                        $tanggal=$datain['tanggal'];
                        $category_barang=$datain['category_barang'];
                        // $tanggal_pembelian=$datain['tanggal_pembelian'];
                        // $databarang=$datain['databarang'];
                        // $nama_suplier=$datain['nama_suplier'];
                        // $type_pembelian=$datain['type_pembelian'];
                        // $namasuplier="$nama_suplier";
                        $qu = mysqli_query($koneksi, "SELECT * from category_barang WHERE id='$category_barang'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $ro = mysqli_num_rows($qu);
                        if ($ro <> 0) {
                        $dat= mysqli_fetch_assoc($qu);
                        $namacat=$dat['category'];
                        } 
                        } else{
                        $no_request="";
                        $tanggal="";
                        $category_barang="";
                        // $tanggal_pembelian="";
                        $namacat="";
                        //  $id_suplier="";
                        //  $type_pembelian="";
                        //  $databarang="";
                        //  $type_pembelian="";
                        } 
                        ?>    
                    </div></div><h4 class="record-title">Add Permintaan Barang <?php echo $namacat;?> Divisi <?php echo $divisi;?></h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-10 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-white p-1 animated fadeIn page-content">
                        <form id="data_permintaan_barang-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_permintaan_barang/add?csrf_token=$csrf_token") ?>" method="post">
                            <div>
                                <input type="hidden" name="divisi" value="<?php echo $divisi;?>">    
                                    <input type="hidden" name="idtrace" value="<?php echo $idtrace;?>"><input type="hidden" name="bagian" value="<?php echo $bagian;?>">
                                        <table class="table  table-striped table-sm text-left">
                                            <tbody class="page-data" id="page-data-list-page-pncu8qemil7z">
                                                <tr>
                                                    <td width="45%"> 
                                                        <div class="form-group ">
                                                            <div class="">
                                                                <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="input-group">
                                                                <?php
                                                                if($no_request==""){?>
                                                                <input id="ctrl-tanggal" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal',date_now()); ?>" type="datetime" name="tanggal" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <?php }else{?>
                                                                    <input class="form-control " id="ctrl-tanggal" name="tanggal"  value="<?php echo $tanggal;?>" readonly/>  
                                                                        <?php }?>
                                                                    </div>      
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group ">
                                                                    <div class="">
                                                                        <label class="control-label" for="category_barang">Category Barang <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="">
                                                                        <?php
                                                                        if($no_request==""){?>
                                                                        <div class="input-group">
                                                                            <select required=""  id="ctrl-category_barang" name="category_barang"  placeholder="Select a value ..."    class="custom-select" >
                                                                                <option value="">Select a value ...</option>
                                                                                <?php 
                                                                                $category_barang_options = $comp_model -> permintaan_barang_category_barang_option_list();
                                                                                if(!empty($category_barang_options)){
                                                                                foreach($category_barang_options as $option){
                                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                $selected = $this->set_field_selected('category_barang',$value, "");
                                                                                ?>
                                                                                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                                                    <?php echo $label; ?>
                                                                                </option>
                                                                                <?php
                                                                                }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <?php }else{?>
                                                                        <input class="form-control " id="ctrl-category_barang-show" name="category_barang-show"  value="<?php echo $namacat;?>" readonly/> 
                                                                            <input class="form-control " type="hidden" id="ctrl-category_barang" name="category_barang"  value="<?php echo $category_barang;?>" />  
                                                                                <?php }?>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                            </tbody>
                                                        </table> 
                                                        <table class="table  table-striped table-sm text-left">
                                                            <tbody class="page-data" id="page-data-list-page-pncu8qemil7z">
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group ">
                                                                            <div class="">
                                                                                <label class="control-label" for="nama_barang">Cari Kode/Nama Barang/Barcode <span class="text-danger">*</span></label>
                                                                            </div>
                                                                            <div class="">
                                                                                <input id="ctrl-nama_barang"  value="<?php  echo $this->set_field_value('nama_barang',""); ?>" type="text" placeholder="Cari Kode/Nama Barang/Barcode"  required="" name="nama_barang"  class="form-control " />
                                                                                </div>
                                                                            </div> 
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group ">
                                                                                <div class="">
                                                                                    <label class="control-label" for="jumlah">Jumlah <span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="">
                                                                                    <input id="ctrl-jumlah"  value="<?php  echo $this->set_field_value('jumlah',""); ?>" type="number" placeholder="Enter Jumlah" step="1"  required="" name="jumlah"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-primary" type="submit">
                                                                                    <i class="fa fa-plus "></i>
                                                                                    <i class="fa fa-shopping-cart "></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr></tbody>
                                                                    </table>  
                                                                    <div id="display" ></div>           
                                                                </div>
                                                            </form>
                                                            <table class="table  table-striped table-sm text-left">
                                                                <thead class="table-header bg-success text-dark">
                                                                    <tr>
                                                                        <th  class="td-kode_barang"> Kode Barang</th>
                                                                        <th  class="td-nama_barang"> Nama Barang</th>
                                                                        <th  class="td-jumlah"> Jumlah</th>
                                                                        <th class="td-btn"></th>
                                                                    </tr>                                                             </thead>  
                                                                    <tbody class="page-data" id="page-data-list-page-8rt4hbl3u9f5">
                                                                        <?php
                                                                        $query = mysqli_query($koneksi, "select * from data_permintaan_barang where no_request='$no_request'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                        // ambil jumlah baris data hasil query
                                                                        $rows = mysqli_num_rows($query);
                                                                        if ($rows <> 0) {
                                                                        while ($row=mysqli_fetch_array($query)){
                                                                        $idreq=$row['id'];
                                                                        $kode_barang=$row['kode_barang'];
                                                                        $nama_barang=$row['nama_barang'];
                                                                        $jumlah=$row['jumlah'];
                                                                        //$harga_beli=$row['harga_beli'];
                                                                        //$diskon=$row['diskon'];
                                                                        //$total_diskon=$row['total_diskon'];
                                                                        //$ppn=$row['ppn'];
                                                                        // $total_harga=$row['total_harga'];
                                                                        // $tanggal_expired=$row['tanggal_expired'];
                                                                        ?>
                                                                        <tr>
                                                                            <td class="td-kode_barang">
                                                                                <span>
                                                                                    <?php echo $kode_barang;?>
                                                                                </span>
                                                                            </td>
                                                                            <td class="td-nama_barang"> 
                                                                                <?php echo $nama_barang;?>
                                                                            </td>
                                                                            <td class="td-jumlah"><?php echo $jumlah;?></td>
                                                                            <th class="td-btn">
                                                                                <a class="btn btn-sm btn-info has-tooltip page-modal" title="Edit This Record" href="<?php print_link("data_permintaan_barang/edit/$idreq"); ?>">
                                                                                    <i class="fa fa-edit"></i> Edit
                                                                                </a>                 
                                                                                <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("data_permintaan_barang/delete/$idreq/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">                         
                                                                                    <i class="fa fa-times"></i>
                                                                                    Delete
                                                                                </a>
                                                                            </th>
                                                                        </tr>
                                                                        <?php
                                                                        }
                                                                        }
                                                                        ?>
                                                                    </tbody> 
                                                                </table> 
                                                                <style>
                                                                    a:hover {
                                                                    cursor: pointer;
                                                                    background-color: #F5F5DC;
                                                                    }
                                                                </style>
                                                                <script>
                                                                    function fill(Value) {
                                                                    $('#ctrl-nama_barang').val(Value);
                                                                    //Hiding "display" div in "search.php" file.
                                                                    $('#display').hide();
                                                                    }
                                                                    $(document).ready(function() {
                                                                    //On pressing a key on "Search box" in "search.php" file. This function will be called.
                                                                    $('#ctrl-nama_barang').val("").focus();
                                                                    $('#ctrl-nama_barang').keyup(function(e){
                                                                    var tex = $(this).val();
                                                                    console.log(tex);
                                                                    if(tex !=="" && e.keyCode===13){
                                                                    }
                                                                    e.preventDefault();
                                                                    //Assigning search box value to javascript variable named as "name".
                                                                    var name = $('#ctrl-nama_barang').val();
                                                                    //Validating, if "name" is empty.
                                                                    if (name == "") {
                                                                    //Assigning empty value to "display" div in "search.php" file.
                                                                    $("#display").html("");
                                                                    }
                                                                    //If name is not empty.
                                                                    else {
                                                                    //AJAX is called.
                                                                    $.ajax({
                                                                    //AJAX type is "Post".
                                                                    type: "POST",
                                                                    //Data will be sent to "ajax.php".
                                                                    url: "<?php print_link("caribarang.php") ?>",
                                                                    //Data, that will be sent to "ajax.php".
                                                                    // data: { search: name },
                                                                    data: $('#data_permintaan_barang-add-form').serialize(),
                                                                    //If result found, this funtion will be called.
                                                                    success: function(html) {
                                                                    //Assigning result to "display" div in "search.php" file.
                                                                    $("#display").html(html).show();
                                                                    }
                                                                    });
                                                                    }
                                                                    });
                                                                    });
                                                                </script>
                                                                <div> <form name="proses" id="proses" method="post" action="<?php print_link("data_permintaan_barang/add?csrf_token=$csrf_token") ?>">
                                                                    <input class="form-control " type="hidden"  name="divisi"  value="<?php echo $divisi;?>" />   <input type="hidden" name="bagian" value="<?php echo $bagian;?>">
                                                                        <?php if($no_request==""){
                                                                        }else{
                                                                        ?><input name="norequest" value="<?php echo $no_request;?>" type="hidden"/><?php   
                                                                            }
                                                                            ?><table class="table  table-striped table-sm text-left">
                                                                                <tbody class="page-data" id="page-data-list-page-pncu8qemil7z">
                                                                                    <!--record-->
                                                                                    <tr>
                                                                                        <td align="right">
                                                                                            <div class="form-ajax-status"></div>
                                                                                            <?php if ($no_request==""){}else{?>
                                                                                            <a class="btn btn-sm btn-info" onclick="prosestrx();" style="color: #fff;">
                                                                                                <i class="fa fa-send"></i> Proses Permintaan
                                                                                            </a><?php }?>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </form>
                                                                        </div> 
                                                                        <script>
                                                                            function prosestrx() {
                                                                            var result = confirm("Proses Permintaan Barang Divisi <?php echo $divisi;?>?");
                                                                            if (result == true) {
                                                                            //document.getElementById('autobtn').click();
                                                                            document.getElementById("proses").submit();
                                                                            return true;
                                                                            }
                                                                            else {
                                                                            return false;
                                                                            }
                                                                            }
                                                                        </script>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
