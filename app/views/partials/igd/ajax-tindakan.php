<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("igd/add");
$can_edit = ACL::is_allowed("igd/edit");
$can_view = ACL::is_allowed("igd/view");
$can_delete = ACL::is_allowed("igd/delete");
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
$rec_id = (!empty($data['id_igd']) ? urlencode($data['id_igd']) : null);
$counter++;
?>
<tr>
    <td class="td-id_igd"><a href="<?php print_link("igd/view/$data[id_igd]") ?>"><?php echo $data['id_igd']; ?></a></td>
    <td class="td-nama_pasien"> <?php echo $data['nama_pasien']; ?></td>
    <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
    <td class="td-tanggal_lahir"> <?php echo $data['tanggal_lahir']; ?></td>
    <td class="td-umur"> <?php echo $data['umur']; ?></td>
    <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
    <td class="td-penanggung_jawab"> <?php echo $data['penanggung_jawab']; ?></td>
    <td class="td-id_penanggung_jawab"> <?php echo $data['id_penanggung_jawab']; ?></td>
    <td class="td-alamat_penanggung_jawab"> <?php echo $data['alamat_penanggung_jawab']; ?></td>
    <td class="td-no_hp_penanggung_jawab"> <?php echo $data['no_hp_penanggung_jawab']; ?></td>
    <td class="td-hubungan"> <?php echo $data['hubungan']; ?></td>
    <td class="td-jenis_kelamin"> <?php echo $data['jenis_kelamin']; ?></td>
    <td class="td-email"><a href="<?php print_link("mailto:$data[email]") ?>"><?php echo $data['email']; ?></a></td>
    <td class="td-pembayaran"> <?php echo $data['pembayaran']; ?></td>
    <td class="td-setatus_bpjs"> <?php echo $data['setatus_bpjs']; ?></td>
    <td class="td-rawat_inap"> <?php echo $data['rawat_inap']; ?></td>
    <td class="td-back_link"> <?php echo $data['back_link']; ?></td>
    <td class="td-tanggal_masuk"> <?php echo $data['tanggal_masuk']; ?></td>
    <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
    <td class="td-action"> <?php echo $data['action']; ?></td>
    <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
    <td class="td-dokter"> <?php echo $data['dokter']; ?></td>
    <td class="td-tindakan"> <?php echo $data['tindakan']; ?></td>
    <td class="td-operator"> <?php echo $data['operator']; ?></td>
    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
    <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
    <td class="td-pasien"> <?php echo $data['pasien']; ?></td>
    <td class="td-no_ktp"> <?php echo $data['no_ktp']; ?></td>
    <td class="td-tanggal_keluar"> <?php echo $data['tanggal_keluar']; ?></td>
    <td class="td-id_transaksi"> <?php echo $data['id_transaksi']; ?></td>
    <td class="td-resep_obat"> <?php echo $data['resep_obat']; ?></td>
    <td class="td-lab"> <?php echo $data['lab']; ?></td>
    <td class="td-catatan_medis"> <?php echo $data['catatan_medis']; ?></td>
    <td class="td-tl"> <?php echo $data['tl']; ?></td>
    <td class="td-assesment_triase"> <?php echo $data['assesment_triase']; ?></td>
    <td class="td-assesment_medis"> <?php echo $data['assesment_medis']; ?></td>
    <td class="td-pemeriksaan_fisik"> <?php echo $data['pemeriksaan_fisik']; ?></td>
    <td class="td-rekam_medis"> <?php echo $data['rekam_medis']; ?></td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_view){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("igd/view/$rec_id"); ?>">
                    <i class="fa fa-eye"></i> View 
                </a>
                <?php } ?>
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("igd/edit/$rec_id"); ?>">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <?php } ?>
            </ul>
        </div>
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
