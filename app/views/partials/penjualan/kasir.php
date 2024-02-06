<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("penjualan/add");
$can_edit = ACL::is_allowed("penjualan/edit");
$can_view = ACL::is_allowed("penjualan/view");
$can_delete = ACL::is_allowed("penjualan/delete");
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
                    <h4 class="record-title">Penjualan</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("penjualan/add") ?>">
                        <i class="fa fa-plus"></i>                              
                        Add New Penjualan 
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('penjualan/'); ?>" method="get">
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
                                        <a class="text-decoration-none" href="<?php print_link('penjualan'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('penjualan'); ?>">
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
                            <form method="get" action="<?php print_link($current_page) ?>" class="form filter-form">
                                <div class="input-group">
                                    <input class="form-control datepicker  datepicker"  value="<?php echo $this->set_field_value('penjualan_tanggal'); ?>" type="datetime"  name="penjualan_tanggal" placeholder="Tanggal" data-enable-time="" data-date-format="Y-m-d" data-alt-format="M j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        &nbsp;&nbsp;
                                        <select required=""  name="penjualan_setatus"  placeholder="Select a value ..."    class="custom-select" >
                                            <option  value="Register" >Register</option>
                                            <option  value="Closed">Closed</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" id="autobtn">Filter</button>
                                        </div>
                                    </div>
                                </form>  
                            </div>
                            <div style="margin-bottom:3px;"></div>
                        </div>
                    </div>
                    <div class="col-md-12 comp-grid">
                        <?php $this :: display_page_errors(); ?>
                        <div  class=" animated fadeIn page-content">
                            <div id="penjualan-kasir-records">
                                <div id="page-report-body" class="table-responsive">
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success">
                                            <tr>
                                                <th  class="td-tanggal"> Tanggal</th>
                                                <th  class="td-no_invoice"> No Invoice</th>
                                                <th  class="td-total_jumlah"> Total Jumlah</th>
                                                <th  class="td-total_harga_jual"> Total Harga Jual</th>
                                                <th  class="td-trx"> Transaksi</th>
                                                <th  class="td-trx"> Status</th>
                                                <th  class="td-date_created"> Date Created</th>
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
                                            $rec_id = (!empty($data['id_penjualan']) ? urlencode($data['id_penjualan']) : null);
                                            $counter++;
                                            ?>
                                            <tr>
                                                <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
                                                <td class="td-no_invoice"> <?php echo $data['no_invoice']; ?></td>
                                                <td class="td-total_jumlah"> <?php echo $data['total_jumlah']; ?></td>
                                                <td class="td-total_harga_jual"> <?php echo $data['total_harga_jual']; ?></td>
                                                <td class="td-trx"> <span><?php 
                                                    if($data['trx']=="Jual"){
                                                    echo "Resep Luar";
                                                    }else{
                                                echo $data['trx']; } ?></span></td>
                                                <td class="td-setatus">        <?php
                                                    if($data['setatus']=="Closed"){
                                                    ?>
                                                    <span style="border-radius: 8px; background-color: #DC143C; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
                                                    <?php
                                                    }else if($data['setatus']=="Register"){
                                                    ?>
                                                    <span style="border-radius: 8px; background-color:  #1E90FF; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
                                                    <?php
                                                    }else{
                                                    ?>
                                                    <span style="border-radius: 8px; background-color: #228B22; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>                   
                                                <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
                                                <td class="page-list-action td-btn">
                                                    <?php 
                                                    if($data['setatus']=="Register"){?>
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <a class="dropdown-item page-modal" href="<?php print_link("penjualan/bayar?precord=".$data['no_invoice']); ?>">
                                                                <i class="fa fa-send"></i> Bayar
                                                            </a>
                                                        </ul>
                                                    </div>
                                                    <?php }?>
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
                                                <button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("penjualan/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
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
