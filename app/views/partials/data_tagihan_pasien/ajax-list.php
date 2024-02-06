<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_tagihan_pasien/add");
$can_edit = ACL::is_allowed("data_tagihan_pasien/edit");
$can_view = ACL::is_allowed("data_tagihan_pasien/view");
$can_delete = ACL::is_allowed("data_tagihan_pasien/delete");
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
    <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
    <td class="td-pasien"> <?php echo $data['pasien']; ?></td>
    <td class="td-keterangan"> <?php echo $data['keterangan']; ?></td>
    <td class="td-total_tagihan"> <span><?php echo "Rp ".number_format ( $data['total_tagihan'] ); ?></span> </td>
    <td class="td-setatus"> <?php
        if($data['setatus']=="Closed"){
        ?>
        <span style="border-radius: 8px; background-color:     #DC143C; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
        <?php
        }else if($data['setatus']=="Register"){
        ?>
        <span style="border-radius: 8px; background-color: #1E90FF; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
        <?php
        }else{
        ?>
        <span ><?php echo $data['setatus']; ?></span>
        <?php
        }
        ?>
    </td>
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
