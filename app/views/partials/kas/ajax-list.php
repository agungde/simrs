<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("kas/add");
$can_edit = ACL::is_allowed("kas/edit");
$can_view = ACL::is_allowed("kas/view");
$can_delete = ACL::is_allowed("kas/delete");
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
    <td class="td-keterangan"> <?php echo $data['keterangan']; ?></td>
    <td class="td-debet"> <span>Rp.<?php echo number_format($data['debet'],0,",",".");?></span></td>
    <td class="td-kredit"> <span>Rp.<?php echo number_format($data['kredit'],0,",",".");?></span></td>
    <td class="td-saldo"> <span>Rp.<?php echo number_format($data['saldo'],0,",",".");?></span></td>
    <td class="td-kasir">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['kasir'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
        </a>
    </td>
    <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
    <td class="td-kas_awal"> <span>Rp.<?php echo number_format($data['kas_awal'],0,",",".");?></span></td>
    <td class="td-transaksi">
        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_bank/view/" . urlencode($data['transaksi'])) ?>">
            <i class="fa fa-eye"></i> <?php echo $data['data_bank_nama_bank'] ?>
        </a>
    </td>
    <td class="td-saldo_cash"> <span>Rp.<?php echo number_format($data['saldo_cash'],0,",",".");?></span></td>
    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
    <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
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
