<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("permintaan_barang/add");
$can_edit = ACL::is_allowed("permintaan_barang/edit");
$can_view = ACL::is_allowed("permintaan_barang/view");
$can_delete = ACL::is_allowed("permintaan_barang/delete");
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
$rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
$counter++;
?>
<tr>
    <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
    <td class="td-no_request"> <?php echo $data['no_request']; ?></td>
    <td class="td-action"> <span>
        <?php 
        $usrnam  = "".USER_NAME;
        $id_user = "".USER_ID;
        $dbhost  = "".DB_HOST;
        $dbuser  = "".DB_USERNAME;
        $dbpass  = "".DB_PASSWORD;
        $dbname  = "".DB_NAME;
        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
        $idtrace = "$id_user$usrnam";    
        $key="dermawangroup";
        $plaintext = $data['no_request'];
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        //if($data['setatus']=="Register"){
        
        ?>
        <div class="dropup export-btn-holder mx-1">
            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-edit"></i>Action
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="btn btn-sm btn-primary has-tooltip" style="margin-top:3px;" href="<?php  print_link("data_permintaan_barang/detile?csrf_token=$csrf_token&detile_request=".$data['no_request']);?>">
                <i class="fa fa-eye "></i>Detile Permintaan Barang</a>
            </div>
        </div> 
    </span></td>
    <td class="td-category_barang">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("category_barang/view/" . urlencode($data['category_barang'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['category_barang_category'] ?>
        </a>
    </td>
    <td class="td-divisi"> <?php echo $data['divisi']; ?></td>
    <td class="td-bagian"> <span><?php 
        if($data['divisi']=="RANAP"){
        $queryb = mysqli_query($koneksi, "select * from nama_kamar_ranap WHERE id='".$data['bagian']."'")
        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
        // ambil jumlah baris data hasil query
        $rowsb = mysqli_num_rows($queryb);
        if ($rowsb <> 0) {
        $row   = mysqli_fetch_assoc($queryb); 
        echo $row['nama_kamar'];
        }
        }else{
        echo $data['bagian']; 
    }?></span></td>
    <td class="td-approval"><?php Html :: page_img($data['approval'],50,50,1); ?></td>
    <td class="td-setatus"> <?php
        if($data['setatus']=="Di Terima Dan Closed"){
        ?>
        <span style="border-radius: 8px; background-color: #1eff8d; color: dark; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
        <?php
        }else if($data['setatus']=="Register"){
        ?>
        <span style="border-radius: 8px; background-color: #000000; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
        <?php
        }else{
        ?>
        <span ><?php echo $data['setatus']; ?></span>
        <?php
        }
    ?></td>
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
