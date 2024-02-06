<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("nama_pemeriksaan_lab/add");
$can_edit = ACL::is_allowed("nama_pemeriksaan_lab/edit");
$can_view = ACL::is_allowed("nama_pemeriksaan_lab/view");
$can_delete = ACL::is_allowed("nama_pemeriksaan_lab/delete");
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
    <td class="td-jenis_pemeriksaan"> <span><?php //echo $data['diagnosa'];
        $id_user = "".USER_ID;
        $dbhost  = "".DB_HOST;
        $dbuser  = "".DB_USERNAME;
        $dbpass  = "".DB_PASSWORD;
        $dbname  = "".DB_NAME;
        //$koneksi=open_connection();
        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
        $idjen=$data['jenis_pemeriksaan'];
        if($idjen=="" or $idjen=="0"){
        }else{
        $queryd = mysqli_query($koneksi, "SELECT * from jenis_pemeriksaan_lab WHERE id='$idjen'")
        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
        $rowsd = mysqli_num_rows($queryd);
        if ($rowsd <> 0) {
        $datacekd= mysqli_fetch_assoc($queryd);
        $namjen=$datacekd['jenis_pemeriksaan'];
        }else{
        $namjen="" ;
        }
        echo $namjen;
        }
    ?></span></td>
    <td class="td-nama_pemeriksaan"> <?php echo $data['nama_pemeriksaan']; ?></td>
    <td class="td-nilai_rujukan"> <?php echo $data['nilai_rujukan']; ?></td>
    <td class="td-satuan"> <?php echo $data['satuan']; ?></td>
    <td class="td-harga"> <span><?php echo number_format($data['harga'],0,",","."); ?></span></td>
    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
    <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
    <td class="page-list-action td-btn">
        <div class="dropdown" >
            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                <i class="fa fa-bars"></i> 
            </button>
            <ul class="dropdown-menu">
                <?php if($can_view){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("nama_pemeriksaan_lab/view/$rec_id"); ?>">
                    <i class="fa fa-eye"></i> View 
                </a>
                <?php } ?>
                <?php if($can_edit){ ?>
                <a class="dropdown-item page-modal" href="<?php print_link("nama_pemeriksaan_lab/edit/$rec_id"); ?>">
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
