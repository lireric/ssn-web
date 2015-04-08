<?php
error_reporting(E_ALL ^ E_NOTICE);
//require_once 'ssn_conf.php';
require_once 'ssn_conf.php';
$ssn_lang = $_COOKIE["ssn-lang"];
$ssn_pswd = $_COOKIE["ssn-p"];
$ssn_user = $_COOKIE["ssn-u"];
$ssn_user_name = $_COOKIE["ssn-uname"];
$ssn_acc = $_COOKIE["ssn-acc"];
$pg = stripslashes ( $_GET["pg"] );
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8' />
<!--    <meta http-equiv="X-UA-Compatible" content="chrome=1" /> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SSN control center" />

<link href="css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
<link href="css/jquery.dataTables.yadcf.css" rel="stylesheet" type="text/css" />
<link href="css/chosen.css" rel="stylesheet" />
<link href="css/bootstrap.min.css" rel="stylesheet" />
<link href="css/bootstrap-theme.min.css" rel="stylesheet" />
<!--<link href="css/jquery-ui.min.css" rel="stylesheet" type="text/css" />-->
<link href="css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="css/jquery-ui.theme.min.css" rel="stylesheet" type="text/css" />
<link href="css/jquery-ui.structure.min.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<link href="css/vis.css" rel="stylesheet"/>
<?php if ( $pg === 'login' ) : ?><link href="css/signin.css" rel="stylesheet"><?php endif; ?>

<!-- Custom styles for this template -->
<link href="css/navbar-fixed-top.css" rel="stylesheet"/>
<link href="css/dataTables.jqueryui.css" rel="stylesheet"/>

<script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
<!--<script src="js/jquery.dataTables.min.js" type="text/javascript" charset="utf8"></script>-->
<script src="js/jquery.dataTables.js" type="text/javascript" charset="utf8"></script>
<script src="js/jquery.dataTables.yadcf-ssn.js"></script>
<script src="js/chosen.jquery.min.js" type="text/javascript"></script>
<script src="js/moment-with-locales.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/jquery.datetimepicker.js"></script>
<script src="js/vis.min.js"></script>
<script src="js/sha256.js"></script>

<script src="js/ssn-helpers.js"></script>


    
    <title>SSN control center</title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

 <style>
	#external_filter_container_wrapper {
	  margin-bottom: 20px;
	}
 </style>   
 </head>

 <body>
 <script>
var ssn_lang = getCookie("ssn-lang");
var ssn_pswd = getCookie("ssn-p");
var ssn_acc = getCookie("ssn-acc");
var ssn_user = getCookie("ssn-u");
</script>
 
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_proj' ); ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        <?php if ( $ssn_user != '' ) : ?>
          <ul class="nav navbar-nav navbar-left">
            <li <?php echo ($pg === 'short') ? " class=\"active\" " : "" ?>><a href="?pg=short"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_short' ); ?></a></li>
            <li <?php echo ($pg === 'dt') ? " class=\"active\" " : "" ?>><a href="?pg=dt"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_detail' ); ?><span class="sr-only">(current)</span></a></li>
            <li <?php echo ($pg === 'graph') ? " class=\"active\" " : "" ?>><a href="?pg=graph"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_graph' ); ?></a></li>
            <li <?php echo ($pg === 'cmd') ? " class=\"active\" " : "" ?>><a href="?pg=cmd"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_commands' ); ?></a></li>
          </ul>
		<?php endif; ?>

          <ul class="nav navbar-nav navbar-right">
            <li <?php echo ($pg === '') ? " class=\"active\" " : "" ?>><a href="?"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_home' ); ?></a></li>
            <li <?php echo ($pg === 'about') ? " class=\"active\" " : "" ?>><a href="#about"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_about' ); ?></a></li>
            <li <?php echo ($pg === 'login') ? " class=\"active\" " : "" ?>>
            <?php if ($ssn_user == '') { echo '<a href="?pg=login">'.SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_login' ); }
            else { echo $ssn_user_name.'<a style="font-size: 10px;padding-top: 0px;" href="?pg=logout">'.SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_logout' ); } 
            ?></a></li>
	    <li/>

            <li id="en" <?php echo ($ssn_lang === 'en') ? " class=\"active\" " : "" ?>><a href="#" onclick="ssn_lang_chg(this)">en</a></li>
            <li id="ru" <?php echo ($ssn_lang === 'ru') ? " class=\"active\" " : "" ?>><a href="#" onclick="ssn_lang_chg(this)">ru</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


<?php
// ------------------------------------------------------------- pg = ''
// main page:
if ( $pg === '' ) : ?>

<div >
        <h1><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_title' ); ?></h1>
      <div class="row">
        <div class="col-sm-6">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_short' ); ?></h3>
            </div>
            <div class="panel-body">
              <?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_short_text' ); ?>
              <br/><a href="?pg=short">
              <button type="button" class="btn btn-lg btn-primary"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_short' ); ?></button>
              </a>
              
            </div>
          </div>
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_detail' ); ?></h3>
            </div>
            <div class="panel-body">
              <?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_detail_text' ); ?>
              <br/><a href="?pg=dt">
              <button type="button" class="btn btn-lg btn-primary"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_detail' ); ?></button>
              </a>
              </div>
          </div>
       </div><!-- /.col-sm-6 -->
       <div class="col-sm-6">

          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_graph' ); ?></h3>
            </div>
            <div class="panel-body">
              <?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_graph_text' ); ?>
              <br/><a href="?pg=graph">
              <button type="button" class="btn btn-lg btn-primary"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_graph' ); ?></button>
              </a>
            </div>
          </div>
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_commands' ); ?></h3>
            </div>
            <div class="panel-body">
              <?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_cmd_text' ); ?>
              <br/><a href="?pg=cmd">
              <button type="button" class="btn btn-lg btn-primary"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'main_menu_commands' ); ?></button>
              </a>
            </div>
          </div>
       </div><!-- /.col-sm-6 -->
    </div>        

</div>

</br>

<?php 
// ------------------------------------------------------------- ^^^^^^^^
endif; ?>

<?php
// ------------------------------------------------------------- pg = 'dt'
// detail page:
if ( ($pg === 'dt') && ($ssn_user != '') ) : ?>
<script src="js/ssn_pg_dt.js"  class="init"></script>

<h2 style="text-align:left;"><span class="label label-info"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_name' ); ?></span></h2>
</br>

<!--
      <div id="external_filter_container_wrapper">
      <div id="external_filter_container"></div>
      </div>
-->
<div id="entrys_table_manual_wrapper" class="dataTables_wrapper no-footer fg-toolbar ui-toolbar ui-widget-header ui-helper-clearfix ui-corner-tl ui-corner-tr">
		<table id="ssn_data" class="ssn_data display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th width="5%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_id' ); ?></th>
						<th width="5%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_obj' ); ?></th>
						<th width="10%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_device' ); ?></th>
						<th width="10%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_index' ); ?></th>
						<th width="10%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_value' ); ?></th>
						<th width="30%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_time_dev' ); ?></th>
						<th width="30%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_time_store' ); ?></th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						<th width="5%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_id' ); ?></th>
						<th width="5%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_obj' ); ?></th>
						<th width="10%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_device' ); ?></th>
						<th width="10%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_index' ); ?></th>
						<th width="10%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_value' ); ?></th>
						<th width="30%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_time_dev' ); ?></th>
						<th width="30%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_time_store' ); ?></th>
					</tr>
				</tfoot>
		</table>
</div>
<?php 
// ------------------------------------------------------------- ^^^^^^^^
endif; ?>

<?php
// ------------------------------------------------------------- pg = 'short'
// short page:
if ( ($pg === 'short') && ($ssn_user != '') ) : ?>
<script src="js/ssn_pg_short.js"  class="init"></script>

<div class="container_wrapper">
<div class="container">
<h2 style="text-align:left;"><span class="label label-info"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_name' ); ?></span></h2>
</br>

  <div id="external_filter_container_wrapper">
<table border="0" width="100%">
<tr>
<td>
       <label><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_time_store' ); ?></label>
       <div id="external_filter_container_date_store"></div>
</td>
<td>
       <label><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_index' ); ?></label>
       <div id="external_filter_container_index"></div>
</td>
</tr>
<tr>
<td>
       <label><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_device' ); ?></label>
       <div id="external_filter_container_device"></div>
</td>
<td>
       <label><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_obj' ); ?></label>
       <div id="external_filter_container_obj"></div>
</td>
</tr>
</table>
</div>

</div>
<div class="container">
<!--<div id="ssn_data_manual_wrapper">-->
<div id="ssn_data_manual_wrapper" class="fg-toolbar ui-toolbar ui-widget-header ui-helper-clearfix ui-corner-tl ui-corner-tr">
	<table class="ssn_data display" cellspacing="0" width="100%">
		<thead>
		<tr>
			<th width="5%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_id' ); ?></th>
			<th width="5%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_obj' ); ?></th>
			<th width="10%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_device' ); ?></th>
			<th width="10%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_index' ); ?></th>
			<th width="10%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_value' ); ?></th>
			<th width="30%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_time_dev' ); ?></th>
			<th width="30%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_time_store' ); ?></th>
		</tr>
		</thead>
        	<tfoot>
		<tr>
			<th width="5%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_id' ); ?></th>
			<th width="5%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_obj' ); ?></th>
			<th width="10%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_device' ); ?></th>
			<th width="10%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_index' ); ?></th>
			<th width="10%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_value' ); ?></th>
			<th width="30%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_time_dev' ); ?></th>
			<th width="30%"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_time_store' ); ?></th>
		</tr>
		</tfoot>
	</table>
</div>
</div>
</div>
</div>

<?php 
// ------------------------------------------------------------- ^^^^^^^^
endif; ?>


<?php
// ------------------------------------------------------------- pg = 'graph'
// graph page:
if ( ($pg === 'graph') && ($ssn_user != '') ) : ?>
<script src="js/ssn_pg_graph.js"  class="init"></script>

<div class="container_wrapper">
	<div class="container">
	<h2 style="text-align:left;"><span class="label label-info"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_name' ); ?></span></h2>
	</br>

<table border="0" width="100%" cellpadding="10px">
<tr>
<td width="30%">
       <label><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_time_store' ); ?></label>
       <div id="external_filter_container_date_store">
	from: <input style="width: 120px;" type="text" class="data_time_store" value="" id="data_time_store_from"/>
	to: <input style="width: 120px;" type="text" class="data_time_store" value="" id="data_time_store_to"/>
	</div>
</td>
<td width="10%">
       <label><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_index' ); ?></label>
       <div id="external_filter_container_index">
  <select class="index_select_box" data-placeholder="Select Your Options" multiple="true">
    <option value="0" selected>0</option>
    <option value="1">1</option>
  </select>
	</div>
</td>
<td width="60%" style="padding-left: 10px;">
       <label><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'table_data_device' ); ?></label>
       <div id="external_filter_container_device">
<!--  <select class="device_select_box" data-placeholder="Select Your Options" multiple="true"></select> -->
	</div>
</td>
</tr>
</table>
<br/>
	</div>
	<div class="container">
		<div id="visualization"></div>
	</div>
</div>


<?php 
// ------------------------------------------------------------- ^^^^^^^^
endif; ?>

<?php
// ------------------------------------------------------------- pg = 'cmd'
// commands page:
if ( ($pg === 'cmd') && ($ssn_user != '') ) : ?>
<script src="js/ssn_pg_cmd.js"  class="init"></script>

<div class="container_wrapper">
	<div class="container">
	<h2 style="text-align:left;"><span class="label label-info"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'ssn_commands_title' ); ?></span></h2>
	
	</br>

<table width="100%" class="table table-striped">
        <thead>
              <tr>
                <th><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'ssn_commands_table_head_devs' ); ?>
                <div style="margin-right: 2px; float: right;"><img src="images/fav_star20.png"/> <input type="checkbox" id="ch_fav_filter" onchange="ssn_select_fav_devices()"/></div>
                </th>
              </tr>
        </thead>
        <tbody class="ssn_devs_table"></tbody>
</table>
<br/>
	</div>
</div>


<?php 
// ------------------------------------------------------------- ^^^^^^^^
endif; ?>

<?php
// ------------------------------------------------------------- pg = 'login'
// login page:
if ( $pg === 'login' ) : ?>

<script type="text/javascript" language="javascript">
var user_info;
var pswd;

function ssn_login() {
	pswd = CryptoJS.SHA256($("#inputPassword")[0].value).toString(CryptoJS.enc.Hex);

var jqxhr_user_data = $.getJSON( "http://192.168.1.114/ssn/auth.php", 
{
u: $("#inputLogin")[0].value,
p: pswd,
r: $("#remember-me")[0].checked
})
.success(function(data) {
	console.log( "auth WS return response" );
	user_info = data;
	var exdays = ($("#remember-me")[0].checked == true)?365:0;

	if (user_info.length == 0) {
		console.log( "auth failed" );
		$("#msg_container")[0].innerHTML = '<div class="alert alert-danger" role="alert"><br/><strong>Login failed!</strong> Check login/password. </div>';

	} else {
		console.log( "auth success: user="+ user_info.user_name);
		user_info.user_name
		setCookie("ssn-u", user_info.user_login, exdays);
		setCookie("ssn-uname", user_info.user_name, exdays);
		setCookie("ssn-p", pswd, exdays);
		setCookie("ssn-acc", user_info.acc_id, exdays);

		$("#msg_container")[0].innerHTML = '<div class="alert alert-success" role="alert"><br/><strong>Hellow '+user_info.user_name+'!</strong> Welcome to SSN. </div>';
		
		window.location.assign(window.location.origin+window.location.pathname+"?");
	}

})
.fail(function() {
console.log( "error getting auth data" );
});



}

</script>

    <div class="container">

    <div class="form-signin">
        <h2 class="form-signin-heading"><?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'login_message' ); ?></h2>
        <label for="inputLogin" class="sr-only">Login</label>
        <input type="login" id="inputLogin" class="form-control" placeholder="Login" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" id="remember-me" value="remember-me"> <?php echo SSN_PREFS::ssn_get_text ($ssn_lang, 'login_remember_me' ); ?>
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block"  id="btn_login" onclick="ssn_login()">Sign in</button>
        </div>
      
      <div id="msg_container"></div>

    </div> <!-- /container -->
<?php 
// ------------------------------------------------------------- ^^^^^^^^
endif; ?>

<?php
// ------------------------------------------------------------- pg = 'logout'
if ( $pg === 'logout' ) : 
?>
<script type="text/javascript" language="javascript">

setCookie("ssn-u", "", -1);
setCookie("ssn-p", "", -1);
setCookie("ssn-uname", "", -1);
setCookie("ssn-acc", "", -1);

window.location.assign(window.location.origin+window.location.pathname+"?pg=login");
</script>


<?php 
// ------------------------------------------------------------- ^^^^^^^^
endif; ?>

 </body>
</html>
