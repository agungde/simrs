<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("resep_obat/add");
$can_edit = ACL::is_allowed("resep_obat/edit");
$can_view = ACL::is_allowed("resep_obat/view");
$can_delete = ACL::is_allowed("resep_obat/delete");
?>
<?php
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
if (!empty($records)) {
?>
<!--record-->
<?php
$counter = 0;
foreach($records as $data){
$rec_id = (!empty($data['id_resep_obat']) ? urlencode($data['id_resep_obat']) : null);
$counter++;
?>
<tr>
    <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
    <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
    <td class="td-nama_pasien"> <?php echo $data['nama_pasien']; ?></td>
    <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
    <td class="td-tanggal_lahir"> <?php echo $data['tanggal_lahir']; ?></td>
    <td class="td-setatus"> <span><?php echo $data['setatus']; ?></span></td>
    <td class="td-pembayaran"> <?php echo $data['pembayaran']; ?></td>
    <td class="td-action"> <span>
        <?php
        $id_user = "".USER_ID;
        $dbhost="".DB_HOST;
        $dbuser="".DB_USERNAME;
        $dbpass="".DB_PASSWORD;
        $dbname="".DB_NAME;
        //$koneksi=open_connection();
        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
        
        $sql = mysqli_query($koneksi,"select * from user_login WHERE id_userlogin='$id_user'");
        while ($row=mysqli_fetch_array($sql)){
        $user_role_id=$row['user_role_id'];
        //$nama_poli=$row['nama_poli'];
        }
        $key="dermawangroup";
        $plaintext = "$rec_id";
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        if($data['pembayaran']=="Lunas"){
        if($data['action']=="Closed"){
        //echo $data['action'];
        if($user_role_id=="3"){
        ?>
        <a class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("data_resep/proses?csrf_token=$csrf_token&precord=$ciphertext&view=$ciphertext");?>"
        <i class="fa fa-send"></i>Lihat Resep</a> 
        <?php
        }else{ ?>
        <a class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("data_resep/proses?csrf_token=$csrf_token&precord=$ciphertext&print=$ciphertext&copy=$ciphertext&proses=print");?>"
        <i class="fa fa-print "></i>Print Copy Resep</a>  
        <?php }
        }else{
        ?>
        <a class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("data_resep/proses?csrf_token=$csrf_token&prosesobat=true&precord=$ciphertext");?>"
        <i class="fa fa-send"></i>Proses Resep</a>  
        <?php } }else{
        if($data['pembayaran']=="BPJS"){
        ?>
        <a class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("data_resep/proses?csrf_token=$csrf_token&prosesobat=true&precord=$ciphertext");?>"
        <i class="fa fa-send"></i>Proses Resep</a>  
        <?php
        }else{
        //if($user_role_id=="3"){
        ?>
        <a class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("data_resep/proses?csrf_token=$csrf_token&precord=$ciphertext&view=$ciphertext");?>"
        <i class="fa fa-send"></i>Lihat Resep</a> <?php
        //}
        }
        }
        if($data['pembayaran']=="Luar"){
        if($user_role_id=="3"){
        ?>
        <a class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("data_resep/proses?csrf_token=$csrf_token&precord=$ciphertext&view=$ciphertext");?>"
        <i class="fa fa-send"></i>Lihat Resep</a> <?php
        }else{
        ?>
        <a class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("data_resep/proses?csrf_token=$csrf_token&precord=$ciphertext&print=$ciphertext&resep=Luar&proses=print");?>"
        <i class="fa fa-print "></i>Print Resep</a>  
        <?php } } 
        ?> 
    </span></td>
    <td class="td-pasien"> <?php echo $data['pasien']; ?></td>
    <td class="td-nama_poli"> <span><?php
        $queryb = mysqli_query($koneksi, "select * from data_poli WHERE id_poli='".$data['nama_poli']."'")
        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
        // ambil jumlah baris data hasil query
        $rowsb = mysqli_num_rows($queryb);
        if ($rowsb <> 0) {
        $row   = mysqli_fetch_assoc($queryb); 
        //$no_rekam_medis=$row['no_rekam_medis'];
        echo $row['nama_poli'];
        }else{
        echo $data['nama_poli']; 
    }?></span></td>
    <td class="td-umur"> <?php echo $data['umur']; ?></td>
    <td class="td-nama_dokter"> <?php echo $data['nama_dokter']; ?></td>
    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
</tr>
<?php 
}
?>
<?php
} else {
?>
<td class="no-record-found col-12" colspan="100">
    <h4 class="text-muted text-center ">
        No Record Found
    </h4>
</td>
<?php
}
?>
