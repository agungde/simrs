<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("setok_barang/add");
$can_edit = ACL::is_allowed("setok_barang/edit");
$can_view = ACL::is_allowed("setok_barang/view");
$can_delete = ACL::is_allowed("setok_barang/delete");
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
                    <h4 class="record-title">Setok Barang</h4>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('setok_barang'); ?>" method="get">
                        <div class="input-group">
                            <input value="<?php echo get_value('search'); ?>" class="form-control" type="text" name="search"  placeholder="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
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
                    <div class="col-md-12 comp-grid">
                        <div class="card mb-3 sticky-top">
                            <?php $menu_id = "menu-" . random_str(); ?>
                            <nav class="navbar navbar-expand-lg navbar-light">
                                <div class="h4">Filter by Category Barang</div>
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#<?php echo $menu_id ?>" aria-expanded="false">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                            </nav>
                            <div class="collapse collapse-lg " id="<?php echo $menu_id ?>">
                                <ul class="nav nav-pills">
                                    <?php 
                                    $option_list = $comp_model->setok_barang_setok_barangcategory_barang_option_list();
                                    if(!empty($option_list)){
                                    foreach($option_list as $option){
                                    $value = (!empty($option['value']) ? $option['value'] : null);
                                    $label = (!empty($option['label']) ? $option['label'] : $value);
                                    $nav_link = $this->set_current_page_link(array('setok_barang_category_barang' => $value , 'setok_barang_category_baranglabel' => $label) , false);
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo is_active_link('setok_barang_category_barang', $value); ?>" href="<?php print_link($nav_link) ?>">
                                            <?php echo $label; ?>
                                        </a>
                                    </li>
                                    <?php
                                    }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <?php $this :: display_page_errors(); ?>
                        <div class="filter-tags mb-2">
                            <?php
                            if(!empty(get_value('setok_barang_category_barang'))){
                            ?>
                            <div class="filter-chip card bg-light">
                                <b>Category Barang :</b> 
                                <?php 
                                if(get_value('setok_barang_category_baranglabel')){
                                echo get_value('setok_barang_category_baranglabel');
                                }
                                else{
                                echo get_value('setok_barang_category_barang');
                                }
                                $remove_link = unset_get_value('setok_barang_category_barang', $this->route->page_url);
                                ?>
                                <a href="<?php print_link($remove_link); ?>" class="close-btn">
                                    &times;
                                </a>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div  class=" animated fadeIn page-content">
                            <div id="setok_barang-list-records">
                                <div id="page-report-body" class="table-responsive">
                                    <?php Html::ajaxpage_spinner(); ?>
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <th  class="td-kode_barang"> Kode Barang</th>
                                                <th  class="td-nama_barang"> Nama Barang</th>
                                                <th  class="td-satuan"> Satuan</th>
                                                <th  class="td-harga_beli"> Harga Beli</th>
                                                <th  class="td-harga_jual"> Harga Jual</th>
                                                <th  class="td-jumlah"> Jumlah</th>
                                                <th  class="td-category_barang"> Category Barang</th>
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
                                            $rec_id = (!empty($data['id_barang']) ? urlencode($data['id_barang']) : null);
                                            $counter++;
                                            ?>
                                            <tr>
                                                <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
                                                <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
                                                <td class="td-satuan"> <?php echo $data['satuan']; ?></td>
                                                <td class="td-harga_beli"> <?php echo $data['harga_beli']; ?></td>
                                                <td class="td-harga_jual"> <?php echo $data['harga_jual']; ?></td>
                                                <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
                                                <td class="td-category_barang">
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("category_barang/view/" . urlencode($data['category_barang'])) ?>">
                                                        <i class="fa fa-eye"></i> <?php echo $data['category_barang_category'] ?>
                                                    </a>
                                                </td>
                                                <td class="td-operator">
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
                                                        <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
                                                    </a>
                                                </td>
                                                <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
                                                <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
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
