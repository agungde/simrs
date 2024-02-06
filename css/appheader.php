<link rel="stylesheet" href="<?php $linksite="".SITE_ADDR; echo $linksite; ?>facon.css" />
<div id="topbar" class="navbar navbar-expand-md fixed-top navbar-light bg-white">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php print_link(HOME_PAGE) ?>">
            <img class="img-responsive" src="<?php print_link(SITE_LOGO); ?>" /> <?php echo SITE_NAME ?>
            </a>
            <?php 
            if(user_login_status() == true ){ 
            ?>
            <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            </button>
            <button type="button" id="sidebarCollapse" class="btn btn-white">
                <span class="navbar-toggler-icon" ></span>
            </button>
			<script>
	

 function menclick() {
	  <?php if(USER_ROLE==3){?>
document.getElementById("sidebarCollapse").click();	
	  <?php }?>
 }


			
    function BPJSopenTab() {
   // window.open("https://pcarejkn.bpjs-kesehatan.go.id/eclaim/", "_SELF");
    window.location.href = 'https://pcarejkn.bpjs-kesehatan.go.id/eclaim/';
    }
	    function BAYARopenTab() {
   // window.open("https://invoice.xendit.co/od/kasihibu", "__SELF");
    window.location.href = '<?php print_link('transaksi/pay') ?>';
    }
  </script>   <?php   
			require('liveapp.php');
			//include 'liveapp.php';
			//require(SYSTEM_DIR . 'liveapp.php');
            ?>
			<?php 
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			?>
            <div class="navbar-collapse collapse navbar-responsive-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <?php 
                            if(!empty(USER_PHOTO)){
                            ?>
                            <img class="img-fluid" style="height:30px;" src="<?php print_link(set_img_src(USER_PHOTO,30,30)); ?>" />
                                <?php
                                }
                                else{
                                ?>
                                <span class="avatar-icon"><img class="img-fluid" style="height:30px;" src="<?php print_link("");?>assets/img/Icons/Data Pasien.png" /></span>
                                <?php
                                }
                                ?>
                                <span>Hi <?php echo ucwords(NAMA); ?> !</span>
                            </a>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item" href="<?php print_link('account') ?>"><i class="fa fa-user"></i> My Account</a>
                                <a class="dropdown-item" href="<?php print_link('index/logout?csrf_token=' . Csrf::$token) ?>"><i class="fa fa-sign-out"></i> Logout</a>
                            </ul>
                        </li>
                    </ul>
                </div>
                <?php 
                } 
                ?>
            </div>
        </div>
        <?php 
        if(user_login_status() == true ){ 
        ?>
        <nav id="sidebar" class="navbar-light bg-white">
            <ul class="nav navbar-nav w-100 flex-column align-self-start">
                <li class="menu-profile text-center nav-item">
   
                    </li>
                </ul>
                <?php Html :: render_menu(Menu :: $navbarsideleft  , "nav navbar-nav w-100 flex-column align-self-start"  , "accordion"); ?>
            </nav>
            <?php 
            } 
            ?>