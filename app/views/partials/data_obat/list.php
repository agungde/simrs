<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_obat/add");
$can_edit = ACL::is_allowed("data_obat/edit");
$can_view = ACL::is_allowed("data_obat/view");
$can_delete = ACL::is_allowed("data_obat/delete");
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
    <div  class="bg-light p-3 mb-3">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Data Obat</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("data_obat/add") ?>">
                        <i class="fa fa-plus"></i>                              
                        Add New Data Obat 
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('data_obat'); ?>" method="get">
                        <div class="input-group">
                            <input value="<?php echo get_value('search'); ?>" class="form-control" type="text" name="search"  placeholder="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
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
                                        <a class="text-decoration-none" href="<?php print_link('data_obat'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('data_obat'); ?>">
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
            <div class="container">
                <div class="row ">
                    <div class="col-sm-7 comp-grid">
                        <div class=""><div><?php
                            $usrnam  = "".USER_NAME;
                            $id_user = "".USER_ID;
                            $dbhost  = "".DB_HOST;
                            $dbuser  = "".DB_USERNAME;
                            $dbpass  = "".DB_PASSWORD;
                            $dbname  = "".DB_NAME;
                            $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                            $idtrace = "$id_user$usrnam";
                            $query       = mysqli_query($koneksi, "SELECT * from data_obat_temp where idtrace='$idtrace'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                            $rows = mysqli_num_rows($query);
                            if ($rows <> 0) {
                            ?>
                            <a class="btn btn-sm btn-primary has-tooltip"  href="<?php print_link("data_obat_temp"); ?>">                         
                                <i class="fa fa-plus "></i>
                                Lihat Impor Data
                            </a> 
                            <?php
                            }else{
                            ?>
                            <form id="data_barang-impor-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_obat/impor?csrf_token=$csrf_token") ?>" method="post">
                                <table>
                                    <tr><th></th><th>Category</th><th></th></tr>
                                    <tr>
                                        <td >
                                            <div class="custom-file" >
                                                <input type="file" class="custom-file-input" id="customFile" accept=".xlsx,.xls" name="impordata" required="">
                                                    <label class="custom-file-label" for="customFile"><i class="fa fa-cloud-upload"></i>Impor Data</label>
                                                </div>
                                            </td>
                                            <td>
                                                <select name="category" class="form-control" required="">
                                                    <?php
                                                    //data_barang_category_barang
                                                    if(!empty($_GET['data_barang_category_barang'])){
                                                    $idcategory=$_GET['data_barang_category_barang'];
                                                    $idcategory=$idcategory;
                                                    }else{
                                                    $idcategory="1";
                                                    }
                                                    $sql = mysqli_query($koneksi,"select * from category_barang");
                                                    while ($row=mysqli_fetch_array($sql)){
                                                    $idcat=$row['id'];
                                                    $category=$row['category'];
                                                    if($idcategory=="$idcat" ){
                                                    $selected="selected";
                                                    }else{
                                                    $selected="";
                                                    }
                                                    echo"<option value=\"$idcat\"  $selected>$category</option>";
                                                    }
                                                    ?>
                                                </select>     
                                            </td>
                                            <td>
                                                <input name="upload" type="Submit" value="Impor" class="btn btn-primary">
                                                </td>
                                            </tr></table>
                                        </form>
                                        <?php }?>
                                    </div>
                                    <script>
                                        // Add the following code if you want the name of the file appear on select
                                        $(".custom-file-input").on("change", function() {
                                        var fileName = $(this).val().split("\\").pop();
                                        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                        });
                                    </script></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  class="">
                        <div class="container-fluid">
                            <div class="row ">
                                <div class="col-md-12 comp-grid">
                                    <?php $this :: display_page_errors(); ?>
                                    <div  class=" animated fadeIn page-content">
                                        <div id="data_obat-list-records">
                                            <div id="page-report-body" class="table-responsive">
                                                <table class="table  table-sm text-left">
                                                    <thead class="table-header bg-success text-dark">
                                                        <tr>
                                                            <th  class="td-kode_obat"> Kode Obat</th>
                                                            <th  class="td-penggunaan"> PENGGUNAAN</th>
                                                            <th  class="td-nama_obat"> NAMA OBAT</th>
                                                            <th  class="td-pbf"> PBF</th>
                                                            <th  class="td-hna"> HNA</th>
                                                            <th  class="td-hja"> HJA</th>
                                                            <th  class="td-tipe"> TIPE</th>
                                                            <th  class="td-satuan"> Satuan</th>
                                                            <th  class="td-operator"> Operator</th>
                                                            <th  class="td-tanggal_dibuat"> Tanggal Dibuat</th>
                                                            <th  class="td-tanggal_diperbarui"> Tanggal Diperbarui</th>
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
                                                            <td class="td-kode_obat"> <?php echo $data['kode_obat']; ?></td>
                                                            <td class="td-penggunaan"> <?php echo $data['penggunaan']; ?></td>
                                                            <td class="td-nama_obat"> <?php echo $data['nama_obat']; ?></td>
                                                            <td class="td-pbf"> <?php echo $data['pbf']; ?></td>
                                                            <td class="td-hna"><span>Rp.<?php echo number_format($data['hna'],0,",","."); ?></span></td>
                                                            <td class="td-hja"> <span>Rp.<?php echo number_format($data['hja'],0,",","."); ?></span></td>
                                                            <td class="td-tipe"> <?php echo $data['tipe']; ?></td>
                                                            <td class="td-satuan"> <?php echo $data['satuan']; ?></td>
                                                            <td class="td-operator"> <?php echo $data['operator']; ?></td>
                                                            <td class="td-tanggal_dibuat"> <?php echo $data['tanggal_dibuat']; ?></td>
                                                            <td class="td-tanggal_diperbarui"> <?php echo $data['tanggal_diperbarui']; ?></td>
                                                            <td class="page-list-action td-btn">
                                                                <div class="dropdown" >
                                                                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                                        <i class="fa fa-bars"></i> 
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <?php if($can_view){ ?>
                                                                        <a class="dropdown-item page-modal" href="<?php print_link("data_obat/view/$rec_id"); ?>">
                                                                            <i class="fa fa-eye"></i> View 
                                                                        </a>
                                                                        <?php } ?>
                                                                        <?php if($can_edit){ ?>
                                                                        <a class="dropdown-item page-modal" href="<?php print_link("data_obat/edit/$rec_id"); ?>">
                                                                            <i class="fa fa-edit"></i> Edit
                                                                        </a>
                                                                        <?php } ?>
                                                                        <?php if($can_delete){ ?>
                                                                        <a  class="dropdown-item record-delete-btn" href="<?php print_link("data_obat/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                                                            <i class="fa fa-times"></i> Delete 
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
                                                            <?php if($can_delete){ ?>
                                                            <button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("data_obat/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
                                                                <i class="fa fa-times"></i> Delete Selected
                                                            </button>
                                                            <?php } ?>
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
