<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("appointment/add");
$can_edit = ACL::is_allowed("appointment/edit");
$can_view = ACL::is_allowed("appointment/view");
$can_delete = ACL::is_allowed("appointment/delete");
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
<section class="page ajax-page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-white p-1 mb-1">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Appointment</h4>
                </div>
                <div class="col-md-4 comp-grid">
                    <div class="">
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost="".DB_HOST;
                        $dbuser="".DB_USERNAME;
                        $dbpass="".DB_PASSWORD;
                        $dbname="".DB_NAME;
                        //$koneksi=open_connection();
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $cekdata1="";
                        $sqlcek1 = mysqli_query($koneksi,"select * from user_login WHERE id_userlogin='$id_user'");
                        while ($row1=mysqli_fetch_array($sqlcek1)){
                        $cekdata1=$row1['user_role_id'];
                        }
                        if($cekdata1=="2"){
                    echo"</br></br>";
                    } else{
                    ?>
                    <div> <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("data_pasien?appointment=true");?>">
                    <i class="fa fa-plus "></i>Add Appointment</a></div>
                    <?php }?>
                </div>
            </div>
            <div class="col-sm-4 ">
                <div class="">
                    <?php
                    $id_user = "".USER_ID;
                    $dbhost="".DB_HOST;
                    $dbuser="".DB_USERNAME;
                    $dbpass="".DB_PASSWORD;
                    $dbname="".DB_NAME;
                    //$koneksi=open_connection();
                    $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                    $cekdata1="";
                    $sqlcek1 = mysqli_query($koneksi,"select * from user_login WHERE id_userlogin='$id_user'");
                    while ($row1=mysqli_fetch_array($sqlcek1)){
                    $cekdata1=$row1['user_role_id'];
                    }
                    if($cekdata1=="2"){
                echo"</br></br>";
                } else{
                ?>
                <div>
                    <form  class="search" action="<?php print_link("appointment"); ?>" method="get">
                        <div class="input-group">
                            <input value="" class="form-control" type="text" name="search"  placeholder="Search" />
                            <div class="input-group-append">
                                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php }?>
            </div>
        </div>
        <div class="col-md-12 comp-grid">
            <div class="">
                <!-- Page bread crumbs components-->
                <?php
                if(!empty($field_name) || !empty($_GET['search'])){
                ?>
                <hr class="sm d-block d-sm-none" />
                <nav class="page-header-breadcrumbs mt-2" aria-label="breadcrumb">
                    <ul class="breadcrumb m-0 p-1">
                        <?php
                        if(!empty($field_name)){
                        ?>
                        <li class="breadcrumb-item">
                            <a class="text-decoration-none" href="<?php print_link('appointment'); ?>">
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <?php echo (get_value("tag") ? get_value("tag")  :  make_readable($field_name)); ?>
                        </li>
                        <li  class="breadcrumb-item active text-capitalize font-weight-bold">
                            <?php echo (get_value("label") ? get_value("label")  :  make_readable(urldecode($field_value))); ?>
                        </li>
                        <?php 
                        }   
                        ?>
                        <?php
                        if(get_value("search")){
                        ?>
                        <li class="breadcrumb-item">
                            <a class="text-decoration-none" href="<?php print_link('appointment'); ?>">
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item text-capitalize">
                            Search
                        </li>
                        <li  class="breadcrumb-item active text-capitalize font-weight-bold"><?php echo get_value("search"); ?></li>
                        <?php
                        }
                        ?>
                    </ul>
                </nav>
                <!--End of Page bread crumbs components-->
                <?php
                }
                ?>
            </div>
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
                    <div class="col-md-4 comp-grid">
                        <div class=""><div>
                            <?php if(!empty($_GET['appointment_tanggal'])){}else{?> 
                            <script>
                                window.onload = function(){
                                // document.forms['autoform'].submit();
                                document.getElementById('autobtn').click();
                                }   
                            </script>
                            <?php }?>
                            <form method="get" action="<?php print_link($current_page) ?>" class="form filter-form">
                                <div class="input-group">
                                    <input class="form-control datepicker  datepicker"  value="<?php echo $this->set_field_value('appointment_tanggal',date_now()); ?>" type="datetime"  name="appointment_tanggal" placeholder="Tanggal" data-enable-time="" data-date-format="Y-m-d" data-alt-format="M j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" id="autobtn">Filter</button>
                                        </div>
                                    </div>
                                </form>  
                            </div>
                        <div style="margin-bottom:3px;"></div></div>
                    </div>
                    <div class="col-md-12 comp-grid">
                        <?php $this :: display_page_errors(); ?>
                        <div  class=" animated fadeIn page-content">
                            <div id="appointment-list-records">
                                <div id="page-report-body" class="table-responsive">
                                    <?php Html::ajaxpage_spinner(); ?>
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <th  class="td-tanggal_appointment"> Tanggal Appointment</th>
                                                <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                                <th  class="td-no_antri_poli"> No Antri Poli</th>
                                                <th  class="td-nama_pasien"> Nama Pasien</th>
                                                <th  class="td-alamat"> Alamat</th>
                                                <th  class="td-nama_poli"> Nama Poli</th>
                                                <th  class="td-dokter"> Dokter</th>
                                                <th  class="td-no_hp"> No Hp</th>
                                                <th  class="td-jenis_kelamin"> Jenis Kelamin</th>
                                                <th  class="td-tanggal_lahir"> Tanggal Lahir</th>
                                                <th  class="td-email"> Email</th>
                                                <th  class="td-setatus"> Setatus</th>
                                                <th  class="td-keluhan"> Keluhan</th>
                                                <th  class="td-operator"> Operator</th>
                                                <th  class="td-date_created"> Date Created</th>
                                                <th  class="td-date_updated"> Date Updated</th>
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
                                            $rec_id = (!empty($data['id_appointment']) ? urlencode($data['id_appointment']) : null);
                                            $counter++;
                                            ?>
                                            <tr>
                                                <td class="td-tanggal_appointment"> <?php echo $data['tanggal_appointment']; ?></td>
                                                <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
                                                <td class="td-no_antri_poli"> <span><div size="sm" class="btn btn-sm btn-primary"><b><?php echo $data['no_antri_poli']; ?></b></div></span></td>
                                                <td class="td-nama_pasien"> <span>
                                                    <?php echo $data['nama_pasien']; ?>
                                                    <?php
                                                    $datapoli=$data['id_pendaftaran_poli']; 
                                                    $sekarang       = gmdate("Y-m-d", time() + 60 * 60 * 7);
                                                    // if($data['tanggal_appointment']=="$sekarang" and $data['setatus']==""){
                                                    if($data['setatus']==""){
                                                    ?>
                                                    <a class="btn btn-sm btn-primary has-tooltip" title="Edit This Record" href="<?php print_link("pendaftaran_poli/chekin/$datapoli"); ?>">
                                                        <i class="fa fa-edit"></i> Chekin
                                                    </a> 
                                                    <?php
                                                    }
                                                    // }
                                                    ?>
                                                </span></td>
                                                <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
                                                <td class="td-nama_poli">
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_poli/view/" . urlencode($data['nama_poli'])) ?>">
                                                        <i class="fa fa-eye"></i> <?php echo $data['data_poli_nama_poli'] ?>
                                                    </a>
                                                </td>
                                                <td class="td-dokter"> <span><?php
                                                    $id_user = "".USER_ID;
                                                    $dbhost  = "".DB_HOST;
                                                    $dbuser  = "".DB_USERNAME;
                                                    $dbpass  = "".DB_PASSWORD;
                                                    $dbname  = "".DB_NAME;
                                                    $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                    $sql = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='".$data['dokter']."'");
                                                    while ($row=mysqli_fetch_array($sql)){
                                                    $namadok=$row['nama_dokter'];
                                                    }
                                                echo $namadok; ?></span></td>
                                                <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
                                                <td class="td-jenis_kelamin"> <?php echo $data['jenis_kelamin']; ?></td>
                                                <td class="td-tanggal_lahir"> <?php echo $data['tanggal_lahir']; ?></td>
                                                <td class="td-email"><a href="<?php print_link("mailto:$data[email]") ?>"><?php echo $data['email']; ?></a></td>
                                                <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
                                                <td class="td-keluhan"> <?php echo $data['keluhan']; ?></td>
                                                <td class="td-operator">
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
                                                        <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
                                                    </a>
                                                </td>
                                                <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
                                                <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
                                                <td class="page-list-action td-btn">
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php if($can_view){ ?>
                                                            <a class="dropdown-item page-modal" href="<?php print_link("appointment/view/$rec_id"); ?>">
                                                                <i class="fa fa-eye"></i> View 
                                                            </a>
                                                            <?php } ?>
                                                            <?php if($can_edit){ ?>
                                                            <a class="dropdown-item page-modal" href="<?php print_link("appointment/edit/$rec_id"); ?>">
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
                                            $pager->ajax_page = true;
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
