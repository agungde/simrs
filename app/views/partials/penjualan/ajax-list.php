<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("penjualan/add");
$can_edit = ACL::is_allowed("penjualan/edit");
$can_view = ACL::is_allowed("penjualan/view");
$can_delete = ACL::is_allowed("penjualan/delete");
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
$rec_id = (!empty($data['id_penjualan']) ? urlencode($data['id_penjualan']) : null);
$counter++;
?>
<tr>
    <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
    <td class="td-no_invoice"> <span>
        <?php
        $bayar=$data['bayar'];
        $key="dermawangroup";
        $plaintext = "$rec_id";
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        
        if($bayar=="" or $bayar=="0"){
        // echo $data['nama_pelanggan']; 
        $print="<i class=\"fa fa-eye\"></i>Lihat";
        $lihat="&view=Detile";
        }else{
        $print="<i class=\"fa fa-print\"></i>Print";
        $lihat="";
        ?> 
        <?php }?>
        <a class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("penjualan/invoice?precord=$ciphertext$lihat");?>">                                           
        <div><?php echo $data['no_invoice']; ?></div><?php echo $print; ?></a>   
    </span></td>
    <td class="td-nama_pelanggan"> <?php echo $data['nama_pelanggan']; ?></td>
    <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
    <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
    <td class="td-total_jumlah"> <?php echo $data['total_jumlah']; ?></td>
    <td class="td-total_harga_beli"> <span>Rp.<?php echo number_format($data['total_harga_beli'],0,",",".");
        $satuanbeli=$data['total_harga_beli'] / $data['total_jumlah'];
    ?> (@<?php echo number_format($satuanbeli,0,",",".");?>)</span></td>
    <td class="td-total_harga_jual"> <span>Rp.<?php echo number_format($data['total_harga_jual'],0,",",".");
        $satuanjual=$data['total_harga_jual'] / $data['total_jumlah'];
    ?> (@<?php echo number_format($satuanjual,0,",",".");?>)</span></td>
    <td class="td-total_diskon"> <span>Rp.<?php echo number_format($data['total_diskon'],0,",",".");?></span></td>
    <td class="td-trx"> <span><?php 
        if($data['trx']=="Jual"){
        echo "Resep Luar";
        }else{
    echo $data['trx']; } ?></span></td>
    <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
    <td class="td-bayar"> <span>Rp.<?php echo number_format($data['bayar'],0,",",".");?></span></td>
    <td class="td-kembalian"> <span>Rp.<?php echo number_format($data['kembalian'],0,",",".");?></span></td>
    <td class="td-operator"> <span><?php
        $id_user = "".USER_ID;
        $dbhost  = "".DB_HOST;
        $dbuser  = "".DB_USERNAME;
        $dbpass  = "".DB_PASSWORD;
        $dbname  = "".DB_NAME;
        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
        
        $sql = mysqli_query($koneksi,"select * from user_login WHERE id_userlogin='".$data['operator']."'");
        while ($row=mysqli_fetch_array($sql)){
        $namaop=$row['nama'];
        }
    echo $namaop; ?></span></td>
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
