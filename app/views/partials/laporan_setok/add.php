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
    <div  class="p-2 mb-2">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <div class=""><div>
                        <?php
                        if(USER_ROLE==8){
                        $divisi = "IGD";
                        $bagian    = "IGD";    
                        }else if(USER_ROLE==6){
                        $divisi = "POLI";
                        $bagian    = $_SESSION[APP_ID.'user_data']['admin_poli'];
                        }else  if(USER_ROLE==13){
                        $divisi = "RANAP";
                        $bagian    = $_SESSION[APP_ID.'user_data']['admin_ranap'];   
                        }else  if(USER_ROLE==5){
                        $divisi = "FARMASI";
                        $bagian    = "FARMASI";     
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses!! Halaman Kusus!!');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php           
                        }
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        $linksite="".SITE_ADDR;    
                        $tanggal = gmdate("Y-m-d", time() + 60 * 60 * 7); 
                        $tagl=$tanggal;
                        //$ops=$id_user;
                        if(isset($_POST['proseslaporan'])){
                        $idlap=$_POST['idlap'];
                        for($a = 0; $a < count($idlap); $a++){
                        $idlaps = trim($idlap[$a]);
                        mysqli_query($koneksi, "UPDATE `laporan_setok` SET `setatus`='Closed' WHERE `id`='$idlaps'"); 
                        }
                        ?>
                        <script language="JavaScript">
                            alert('Proses Laporan Berhasil');
                            document.location='<?php print_link("laporan_setok"); ?>';
                        </script>
                        <?php
                        }
                        if(isset($_POST['datid'])){
                        $datid=$_POST['datid'];
                        // $kode=$_POST['kode_barang'];
                        //  $nama=$_POST['nama_barang'];
                        $set=$_POST['setok'];
                        //  $cate=$_POST['category_barang'];
                        //  $op=$_POST['operator'];
                        //  $jum=$_POST['jumlah'];
                        //  $divisi=$_POST['divisi'];
                        // $bagian=$_POST['bagian'];
                        //$stkawal=$_POST['setok_awal'];
                        for($a = 0; $a < count($datid); $a++){
                        // $kodes = trim($kode[$a]);
                        $datids= trim($datid[$a]);
                        // $namas= trim($nama[$a]);
                        // $jums= trim($jum[$a]);
                        $sets= trim($set[$a]);
                        // $cates= trim($cate[$a]);
                        //  $tgls= trim($tgl[$a]);
                        //  $divisis= trim($divisi[$a]);
                        // $bagians= trim($bagian[$a]);
                        // $stkawals= trim($stkawal[$a]);
                        $sqla = mysqli_query($koneksi, "SELECT * from data_setok WHERE id='$datids'");
                        $roa = mysqli_num_rows($sqla);
                        if ($roa <> 0) {
                        $rowa = mysqli_fetch_assoc($sqla); 
                        $kodes=$rowa['kode_barang'];
                        $namas=$rowa['nama_barang'];
                        $cates=$rowa['category_barang'];
                        $stkawals=$rowa['setok_awal'];
                        // $divisis=$rowa['divisi'];
                        // $bagians=$rowa['bagian'];
                        $jums=$rowa['jumlah'];
                        }  
                        $sqlcek10 = mysqli_query($koneksi, "SELECT * from catatan_barang WHERE lap='0' and id_data_setok='$datids' and setatus='Closed'");
                        $rows10 = mysqli_num_rows($sqlcek10);
                        if ($rows10 <> 0) {  
                        $sqlcek1 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS cjum from catatan_barang WHERE lap='0' and id_data_setok='$datids' and setatus='Closed'");
                        $row1 = mysqli_fetch_assoc($sqlcek1); 
                        $jumcat=$row1['cjum'];
                        }else{
                        $jumcat="0";
                        }
                        $sqlcek20 = mysqli_query($koneksi, "SELECT * from data_resep WHERE lap='0' and id_data_setok='$datids'");
                        $rows20 = mysqli_num_rows($sqlcek20);
                        if ($rows20 <> 0) {   
                        $row20 = mysqli_fetch_assoc($sqlcek20); 
                        $setatus=$row20['setatus'];
                        $pending=$row20['jumlah'];
                        if($setatus=="Closed"){
                        $pending="0";
                        }else{
                        $pending=$pending;
                        }
                        $sqlcek2 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS djum from data_resep WHERE lap='0' and id_data_setok='$datids' and setatus='Closed'");
                        $row2 = mysqli_fetch_assoc($sqlcek2); 
                        $jumdat=$row2['djum'];
                        }else{
                        $jumdat="0";
                        $pending="0";
                        }
                        $sqlcek30 = mysqli_query($koneksi, "SELECT * from data_penjualan WHERE lap='0' and id_data_setok='$datids' and trx='Jual'");
                        $rows30 = mysqli_num_rows($sqlcek30);
                        if ($rows30 <> 0) {
                        $row30 = mysqli_fetch_assoc($sqlcek30); 
                        $setatus=$row30['setatus'];
                        $pendingj=$row30['jumlah'];
                        if($setatus=="Closed"){
                        $pendingj="0";
                        }else{
                        $pendingj=$pendingj;
                        }    
                        $sqlcek3 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jjum from data_penjualan WHERE lap='0' and id_data_setok='$datids' and trx='Jual' and setatus='Closed'");
                        $row3 = mysqli_fetch_assoc($sqlcek3); 
                        $jumjual=$row3['jjum'];
                        }else{
                        $jumjual=0;
                        $pendingj="0";
                        }  
                        $totout=$jumcat + $jumdat + $jumjual; //////total keluar//////
                        $jumpen= $pendingj + $pending;  
                        $jomtot=$jums + $jumpen; //////Jumlah sistem + Pending keluar//////
                        if($sets >$jums){
                        $setokitung=$sets - $jumpen; /////apabila setok actual lebih besar dari jumlah sistem maka di kurangi pending keluar///////
                        }else{
                        $setokitung=$sets;
                        }
                        $allset=$setokitung + $totout;
                        $jumsistem=$jomtot + $totout;  ///Jumlah sistem + jumlah keluar///
                        $selisih=$stkawals - $allset;
                        mysqli_query($koneksi, "INSERT INTO `laporan_setok`(`jumlah_sistem`,`pending_keluar`,`setok_awal`,`id_data_setok`,`keluar`, `tanggal`, `kode_barang`, `nama_barang`, `category_barang`, `setok`, `jumlah`,`selisih`, `divisi`, `bagian`, `operator`) VALUES ('$jumsistem','$jumpen','$stkawals','$datids','$totout','$tagl','$kodes','$namas','$cates','$sets','$jums','$selisih','$divisi','$bagian','$id_user')");    
                        $sqlcek = mysqli_query($koneksi, "SELECT * from laporan_setok WHERE id_data_setok='$datids' and setatus='' ORDER BY id DESC");
                        $rows = mysqli_num_rows($sqlcek);
                        if ($rows <> 0) { 
                        $row = mysqli_fetch_assoc($sqlcek); 
                        $idlaporan=$row['id'];
                        }
                        $sqlcek11 = mysqli_query($koneksi, "SELECT * from catatan_barang WHERE lap='0' and id_data_setok='$datids' and setatus='Closed'");
                        $rows11 = mysqli_num_rows($sqlcek11);
                        if ($rows11 <> 0) {  
                        while ($row11=mysqli_fetch_array($sqlcek11)){
                        $idcat=$row11['id'];
                        mysqli_query($koneksi, "UPDATE `catatan_barang` SET `lap`='$idlaporan' WHERE `id`='$idcat'");
                        }
                        }
                        $sqlcek21 = mysqli_query($koneksi, "SELECT * from data_resep WHERE lap='0' and id_data_setok='$datids' and setatus='Closed'");
                        $rows21 = mysqli_num_rows($sqlcek21);
                        if ($rows21 <> 0) {  
                        while ($row21=mysqli_fetch_array($sqlcek21)){
                        $iddatres=$row21['id_data_resep'];
                        mysqli_query($koneksi, "UPDATE `data_resep` SET `lap`='$idlaporan' WHERE `id_data_resep`='$iddatres'");
                        }
                        }   
                        $sqlcek3 = mysqli_query($koneksi, "SELECT * from data_penjualan WHERE lap='0' and id_data_setok='$datids' and trx='Jual' and setatus='Closed'");
                        $rows3 = mysqli_num_rows($sqlcek3);
                        if ($rows3 <> 0) {  
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $iddtjual=$row3['id_data_penjualan'];
                        mysqli_query($koneksi, "UPDATE `data_penjualan` SET `lap`='$idlaporan' WHERE `id_data_penjualan`='$iddtjual'");
                        }
                        }    
                        mysqli_query($koneksi, "UPDATE `data_setok` SET `tanggal`='$tagl' WHERE `id`='$datids'");      
                        }
                        ?>
                        <script language="JavaScript">
                            alert('Data Berhasil Di Proses');
                            document.location='<?php print_link("laporan_setok/laporan"); ?>';
                        </script>
                        <?php   
                        }
                        ?>
                    </div>
                </div><h4 class="record-title">Input Stok Actual Divisi <?php echo $divisi;?></h4>
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
                <div  class=" p-3 animated fadeIn page-content">
                    <form id="laporan_setok-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("laporan_setok/add?csrf_token=$csrf_token") ?>" method="post"><input value="Laporan" type="hidden" required="" name="laporan"/>
                        <div id="data_setok-list-records">
                            <div id="page-report-body" class="table-responsive">
                                <table class="table  table-sm text-left">
                                    <thead class="table-header bg-success">
                                        <tr>
                                            <th  class="td-tanggal"> Tanggal</th>
                                            <th  class="td-kode_barang"> Kode Barang</th>
                                            <th  class="td-nama_barang"> Nama Barang</th>
                                            <th  class="td-category_barang"> Category Barang</th>
                                            <th  class="td-setok"> Jumlah Stok Actual</th>
                                            <th class="td-btn"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="page-data">
                                        <?php 
                                        $itung=0;
                                        $batas=16;
                                        $sqldat = mysqli_query($koneksi,"select * from data_setok WHERE divisi='$divisi' AND bagian='$bagian'");
                                        $rows1 = mysqli_num_rows($sqldat);
                                        if ($rows1 <> 0) {
                                        while ($datas=mysqli_fetch_array($sqldat)){            
                                        $kode_barang= $datas['kode_barang']; 
                                        $nama_barang= $datas['nama_barang'];
                                        $category_barang= $datas['category_barang'];
                                        $idstk= $datas['id']; 
                                        $jumlah= $datas['jumlah'];
                                        $tgl= $datas['tanggal'];
                                        $stkawal= $datas['setok_awal'];
                                        $sqlcek1 = mysqli_query($koneksi,"SELECT * FROM `category_barang` WHERE `id`='$category_barang'");
                                        $rows1 = mysqli_num_rows($sqlcek1);
                                        if ($rows1 <> 0) {
                                        $row= mysqli_fetch_assoc($sqlcek1); 
                                        $namcate=$row['category'];   
                                        }else{
                                        $namcate="" ;
                                        }
                                        if($tgl=="$tanggal") {}else{    
                                        if($itung < $batas){
                                        ?>
                                        <tr>
                                            <td class="td-tanggal">
                                                <input value="<?php echo $idstk;?>" type="hidden" required="" name="datid[]"/>
                                                    <?php echo $tanggal; ?>
                                                </td>
                                                <td class="td-kode_barang">
                                                    <?php echo $kode_barang; ?>                       
                                                </td>                 
                                                <td class="td-nama_barang">
                                                    <?php echo $nama_barang; ?>
                                                    <input id="ctrl-nama_barang"  value="<?php echo $nama_barang;?>" type="hidden" placeholder="Enter Nama Barang"  readonly required="" name="nama_barang[]"  class="form-control " />                          
                                                    </td>
                                                    <td class="td-category_barang"><?php echo $namcate;?>
                                                    </td>
                                                    <td class="td-setok">
                                                        <input id="ctrl-setok"  value="<?php  echo $this->set_field_value('setok',""); ?>" type="number" placeholder="Jumlah Stok Actual" step="1"  required="" name="setok[]"  class="form-control " />  
                                                        </td>
                                                    </tr>
                                                    <?php }
                                                    $itung++;
                                                    }
                                                    }
                                                    }?>    
                                                    <!--endrecord-->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>    
                                    <div class="form-group form-submit-btn-holder text-center mt-3">
                                        <div class="form-ajax-status"></div>
                                        <button class="btn btn-primary" type="button" onclick="laporanform()">
                                            Submit
                                            <i class="fa fa-send"></i>
                                        </button>
                                    </div>
                                </form>
                                <script>   
                                    function laporanform() { 
                                    //alert('Submit OK');
                                    $.ajax({
                                    url:"<?php print_link("ceksetok.php");?>",
                                    method:"POST",
                                    data: $('#laporan_setok-add-form').serialize(),
                                    dataType:"JSON",
                                    success:function(data)
                                    {
                                    var hasil=""+ data.passok; 
                                    if(hasil=="OK"){
                                    //document.getElementById("transaksi-shift-form").submit();
                                    var result = confirm("Apakah SemuaData Sudah Benar?");
                                    if (result == true) {
                                    //document.getElementById('autobtn').click();
                                    document.getElementById("laporan_setok-add-form").submit();
                                    return true;
                                    }
                                    else {
                                    return false;
                                    }
                                    }else{
                                    alert('Silahkan isi Jumlah Stok Actual!!');
                                    return false; 
                                    }       
                                    // alert('Data OK');
                                    }
                                    });
                                    }
                                </script>                                     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
