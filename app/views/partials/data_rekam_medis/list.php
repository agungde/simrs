<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_rekam_medis/add");
$can_edit = ACL::is_allowed("data_rekam_medis/edit");
$can_view = ACL::is_allowed("data_rekam_medis/view");
$can_delete = ACL::is_allowed("data_rekam_medis/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "list-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data From Controller
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_footer = $this->show_footer;
$show_pagination = $this->show_pagination;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-white p-1 mb-1">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Detile Rekam Medis <?php if(!empty($_GET['detile_precord'])){ echo $_GET['detile_precord'];}?></h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-sm-6 comp-grid">
                    <div class=""><?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        //$koneksi=open_connection();
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        if(!empty($_GET['detile_precord'])){
                        $sqlcek1 = mysqli_query($koneksi,"select * from rekam_medis WHERE no_rekam_medis='".$_GET['detile_precord']."'");
                        $rows1 = mysqli_num_rows($sqlcek1);
                        if ($rows1 <> 0) {
                        $row= mysqli_fetch_assoc($sqlcek1); 
                        ?>
                        <div id="page-report-body" class="table-responsive">
                            <table class=" bg-white">
                                <tr><td>
                                    <table >
                                        <tr>
                                            <th align="left"> Nama Pasien: </th>
                                            <td >
                                                &nbsp;&nbsp;    <?php echo $row['nama_pasien']; ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <th align="left"> Alamat: </th>
                                            <td >
                                                &nbsp;&nbsp; <?php echo $row['alamat']; ?> 
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td >  
                                    <table >
                                        <tr>
                                            <th align="left"> &nbsp;&nbsp;Tanggal Lahir</th>
                                            <td >
                                                <?php echo $row['tanggal_lahir']; ?> 
                                            </td>
                                        </tr> 
                                        <tr>
                                            <th align="left">&nbsp;&nbsp;Umur: </th>
                                            <td >
                                                &nbsp;&nbsp <?php echo $row['umur']; ?> 
                                            </td>
                                        </tr>     
                                    </table>         
                                </td>  
                            </tr>
                        </table>   
                    </div>
                    <?php
                    }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-3 comp-grid">
                <div class=""><script>
                    function validateFilter() { 
                    // document.forms['autoform'].submit();
                    //document.getElementById('autobtn').click();
                    var tgl =  document.forms["filter"]["data_tanggal"].value; 
                    if(tgl==""){
                    document.getElementById("data_tanggal").focus();
                    document.getElementById('tglerror').innerHTML = "Please Select Date!!";
                    setTimeout(function(){
                    $('#tglerror').hide();
                    clearerror();
                    }, 5000);
                    return false;
                    }
                    document.getElementById("filter").submit();
                    }   
                    function clearerror() { 
                    $("#tglerror").html("");
                    $("#tglerror").show();
                    }
                </script>
                <form method="get" name="filter"  id="filter" action="<?php print_link($current_page) ?>" class="form filter-form">
                    <div class="input-group"><input type="hidden" name="detile_precord" value="<?php echo $_GET['detile_precord'];?>">
                        <input id="data_tanggal" class="form-control datepicker  datepicker"  value="<?php echo $this->set_field_value('data_tanggal');?>" type="datetime"  name="data_tanggal" placeholder="Tanggal" data-enable-time="" data-date-format="Y-m-d" data-alt-format="M j, Y" data-inline="false" data-no-calendar="false" data-mode="single" required/>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <div class="input-group-append">
                                <button type="button" id="autobtn" class="btn btn-primary" onclick="validateFilter();" >Filter</button>
                            </div><span id="tglerror" style="color:red"></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12 comp-grid">
                <?php $this :: display_page_errors(); ?>
                <div  class=" animated fadeIn page-content">
                    <div id="data_rekam_medis-list-records">
                        <div id="page-report-body" class="table-responsive">
                            <table class="table  table-sm text-left">
                                <thead class="table-header bg-success text-dark">
                                    <tr>
                                        <th  class="td-tanggal"> Tanggal</th>
                                        <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                        <th  class="td-dokter_pemeriksa"> Dokter Pemeriksa</th>
                                        <th  class="td-keluhan"> Keluhan</th>
                                        <th  class="td-diagnosa"> Diagnosa</th>
                                        <th  class="td-resep_obat"> Resep Obat</th>
                                        <th  class="td-assesment_triase"> Assesment Triase</th>
                                        <th  class="td-assesment_medis"> Assesment Medis</th>
                                        <th  class="td-pemeriksaan_fisik"> Pemeriksaan Fisik</th>
                                        <th class="td-btn"></th>
                                    </tr>
                                </thead>
                                <?php
                                if(!empty($records)){
                                ?>
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
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
                                        <td class="td-dokter_pemeriksa"> <?php echo $data['dokter_pemeriksa']; ?></td>
                                        <td class="td-keluhan"> <?php echo $data['keluhan']; ?></td>
                                        <td class="td-diagnosa"> <span>  <?php
                                            $usrnam  = "".USER_NAME;
                                            $id_user = "".USER_ID;
                                            $dbhost  = "".DB_HOST;
                                            $dbuser  = "".DB_USERNAME;
                                            $dbpass  = "".DB_PASSWORD;
                                            $dbname  = "".DB_NAME;
                                            $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                            $idtrace = "$id_user$usrnam";
                                            $linksite="".SITE_ADDR;
                                            $iddiagnosa=$data['diagnosa'];
                                            $appcek = mysqli_query($koneksi,"select * from diagnosa WHERE id='$iddiagnosa'");
                                            $roapp = mysqli_num_rows($appcek );
                                            if ($roapp  <> 0) {
                                            $datai = mysqli_fetch_assoc($appcek);
                                            $iddiag=$datai['id'];
                                            $description=$datai['description'];
                                            ?>
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("diagnosa/view/$iddiag");?>">
                                                <?php
                                                }else{
                                                ?>
                                                <a size="sm" class="btn btn-sm btn-primary page-modal" href="#">
                                                    <?php }?>
                                                    <i class="fa fa-eye"></i>                                                   
                                                <?php echo $description; ?></a></span></td>
                                                <td class="td-resep_obat"> <?php echo $data['resep_obat']; ?></td>
                                                <td class="td-assesment_triase"> <span>
                                                    <?php
                                                    $norm=$data['no_rekam_medis'];
                                                    $id_daftar=$data['id_daftar'];  
                                                    $qutr = mysqli_query($koneksi, "SELECT * from assesment_triase WHERE id_daftar='$id_daftar' and no_rekam_medis='$norm'")
                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                    $rotr = mysqli_num_rows($qutr);
                                                    if ($rotr <> 0) {
                                                    $ctr= mysqli_fetch_assoc($qutr);
                                                    $idtri=$ctr['id_triase'];
                                                    ?>
                                                    <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip page-modal" href="<?php  print_link("assesment_triase/triase/$idtri?precord=$norm&datprecord=$idtr");?>">
                                                    <i class="fa fa-eye"></i> Lihat Assesment Triase</a>
                                                    <?php
                                                    //echo $data['assesment_triase'];
                                                ?></span></td>
                                                <td class="td-assesment_medis"> <span><?php     $norm=$data['no_rekam_medis'];
                                                    $id_daftar=$data['id_daftar'];
                                                    $qutripm = mysqli_query($koneksi, "SELECT * from assesment_medis WHERE id_daftar='$id_daftar' and no_rekam_medis='$norm'")
                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                    $rotripm = mysqli_num_rows($qutripm);
                                                    if ($rotripm <> 0) {
                                                    $ctripm= mysqli_fetch_assoc($qutripm);
                                                    $idopm=$ctripm['id'];
                                                    ?>
                                                    <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("assesment_medis/view/$idopm?precord=$ciphertext&datprecord=$rec_id");?>">
                                                    <i class="fa fa-send"></i>  Lihat Assesment Medis</a> 
                                                <?php } ?></span></td>
                                                <td class="td-pemeriksaan_fisik"> <span><?php   $norm=$data['no_rekam_medis'];
                                                    $id_daftar=$data['id_daftar'];
                                                    $qutrif = mysqli_query($koneksi, "SELECT * from pemeriksaan_fisik WHERE id_daftar='$id_daftar' and no_rekam_medis='$norm'")
                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                    $rotrif = mysqli_num_rows($qutrif);
                                                    if ($rotrif <> 0) {
                                                    $ctrif= mysqli_fetch_assoc($qutrif);
                                                    $idtrif=$ctrif['id_fisik'];
                                                    ?>
                                                    <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("pemeriksaan_fisik/view/$idtrif?precord=$ciphertext&datprecord=$rec_id");?>">
                                                    <i class="fa fa-send"></i> Lihat Pemeriksaan Fisik</a>                                
                                                    <?php
                                                } ?></span></td>
                                                <td class="page-list-action td-btn">
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php if($can_view){ ?>
                                                            <a class="dropdown-item page-modal" href="<?php print_link("data_rekam_medis/view/$rec_id"); ?>">
                                                                <i class="fa fa-eye"></i> View 
                                                            </a>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php 
                                            }
                                            ?>
                                            <!--endrecord-->
                                        </tbody>
                                        <tbody class="search-data" id="search-data-<?php echo $page_element_id; ?>"></tbody>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                    <?php 
                                    if(empty($records)){
                                    ?>
                                    <h4 class="bg-light text-center border-top text-muted animated bounce  p-3">
                                        <i class="fa fa-ban"></i> No record found
                                    </h4>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if( $show_footer && !empty($records)){
                                ?>
                                <div class=" border-top mt-2">
                                    <div class="row justify-content-center">    
                                        <div class="col-md-auto justify-content-center">    
                                            <div class="p-3 d-flex justify-content-between">    
                                            </div>
                                        </div>
                                        <div class="col">   
                                            <?php
                                            if($show_pagination == true){
                                            $pager = new Pagination($total_records, $record_count);
                                            $pager->route = $this->route;
                                            $pager->show_page_count = true;
                                            $pager->show_record_count = true;
                                            $pager->show_page_limit =true;
                                            $pager->limit_count = $this->limit_count;
                                            $pager->show_page_number_list = true;
                                            $pager->pager_link_range=5;
                                            $pager->render();
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
