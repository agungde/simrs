<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_permintaan_barang/add");
$can_edit = ACL::is_allowed("data_permintaan_barang/edit");
$can_view = ACL::is_allowed("data_permintaan_barang/view");
$can_delete = ACL::is_allowed("data_permintaan_barang/delete");
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
    <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
    <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
    <td class="td-category_barang"> <?php 
        $qudtpab = mysqli_query($koneksi, "SELECT * from category_barang WHERE id='".$data['category_barang']."'")
        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
        $rodtpab = mysqli_num_rows($qudtpab);
        if ($rodtpab <> 0) {
        $cdt= mysqli_fetch_assoc($qudtpab);
        $categ=$cdt['category'];
        echo $categ;
        }else{
        echo $data['category_barang'];   
        }
    ?></td>
    <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
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
