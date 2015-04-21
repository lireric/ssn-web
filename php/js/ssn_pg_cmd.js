//var dateTo = moment().format("X");
//var dateFrom = moment().subtract(1, 'day').format("X");
var devices_info;

// send command to hardware device
function ssn_send_command(elm) {
	var arr = elm.id.split("_"); // [1] - dev_id, [2] - srv, [3] - index
	var value = $("#inp_ctrl_"+arr[1]+"_"+arr[2])[0].value;
	var ws_log = "";
	var ws_result;
	var resStr;
	
	var jqxhr_dict_devs = $.getJSON( ws_server+"/data.php", 
			{
			u:  	ssn_user,
			p:  	ssn_pswd,
			obj:	0,
			dev: 	arr[1],
			srv: 	arr[2],
			value: 	value,
			index: 	arr[3]
			})
			.success(function(data) {
				ws_log = "success command sending";
				console.log(ws_log);
				ws_result = data;
				resStr = "";
				if (data.status == 0) {
					resStr = "Ok. " + data.comment;
				} else {
					resStr = "Error. "
				}
				$("#out_container_"+arr[1]+"_"+arr[2])[0].textContent = resStr;
			})
			.fail(function() {
				ws_log = "error command sending";
				console.log(ws_log);
				$("#out_container_"+arr[1]+"_"+arr[2])[0].textContent = ws_log;
			});

	$("#out_container_"+arr[1]+"_"+arr[2])[0].textContent = "calling web service...";
			
}

//-----------------------------------------------------------------------------------
function ssn_select_fav_devices() {

//	if ( ($("#ch_fav_filter")[0].checked == true) && ($("#ch_fav_filter-me")[0].checked != true)) continue;
	var sel_fav;
	var sel_nfav;
	
	if ($("#ch_fav_filter")[0].checked) {
		sel_fav = $(".fav");
		sel_nfav = $(".nfav");
		setCookie("ssn-dev-fav-act", "1", 360);
		for (i=0; i<sel_nfav.length; i++) {
			sel_nfav[i].hidden = true;
		}
	
	} else {
		setCookie("ssn-dev-fav-act", "0", 360);
		sel_fav = $(".tr_dev");
		
	}
	for (i=0; i<sel_fav.length; i++) {
		sel_fav[i].hidden = false;
	}
}	

function ssn_fav_change(elm) {
	var tr_id = elm.id.replace("inp_ch_fav","tr_dev");
//	tr_id.replace("inp_ch_fav","tr_dev");
	if (elm.checked) {
		$("#"+tr_id)[0].className = "tr_dev fav";
		setCookie("ssn-dev-fav-"+elm.id.replace("inp_ch_fav_",""), "1", 360);
	} else {
		$("#"+tr_id)[0].className = "tr_dev nfav";
		setCookie("ssn-dev-fav-"+elm.id.replace("inp_ch_fav_",""), "", -1);
	}
	
	if ($("#ch_fav_filter")[0].checked) {
		ssn_select_fav_devices();
	}
	
}


function ssn_print_services(dev_type, index, dev_id) {
    var srv_html = '<table width="100%" class="table">';
    for(var i=0; i<dev_type.services.length; i++) {
// for read/write property services check device index:
	if (((dev_type.services[i].service_code == 4) || (dev_type.services[i].service_code == 5)) && (dev_type.services[i].service_data.index != index)) { continue; }

	srv_html += '<tr><td><div class="row"><div class="col-sm-4"><h4><span class="label label-info">'+dev_type.services[i].service_name+
		'</span></h4></div><div class="row"><div class="col-sm-6"><h6>'+dev_type.services[i].dev_srv_comment+
		'</h6>'+ssn_print_controls(dev_type.services[i], dev_id, index)+'</div></div></td></tr>';
    }
    srv_html += '</table>';
    return srv_html;
}

function ssn_print_controls(srv, dev_id, index) {
var ctrls_html = "";
var input_html = "";
var button_style = "";

	switch(srv.service_code) {
// set state
	    case '3':
        	input_html = '<select class="state_select_box" id="inp_ctrl_'+dev_id+'_'+srv.service_code+
			'"><option value="0" selected>Inactive</option><option value="1">Active</option></select>';
		button_style = 'style="margin-left:1em;"';
	        break;
// write property
	    case '5':
// choose control type by device value:
		if (srv.service_data.value_code == 3) {
// boolean:
        	input_html = '<select class="prop_select_box dt_boolean" id="inp_ctrl_'+dev_id+'_'+srv.service_code+
			'"><option value="0" selected>Off</option><option value="1">On</option></select>';
		button_style = 'style="margin-left:1em;"';
	        break;
		}
// other types:
        	input_html = '<input style="width: 60px;margin-right:1em;" type="text"  value="" id="inp_ctrl_'+dev_id+'_'+srv.service_code+'"/>';
	        break;
//	    default:
	}
	ctrls_html = input_html + '<button type="button" '+button_style+' class="btn btn-xs btn-default" onclick="ssn_send_command(this)" id="srvbtn_'+dev_id+'_'+srv.service_code+'_'+index+'">'+srv.service_name+'</button><span id="out_container_'+dev_id+'_'+srv.service_code+'" style="margin-left: 1em;"></span>';
	return ctrls_html;
}

$(document).ready(function () {
    'use strict';
	var devs;

/*
  $(".index_select_box").chosen({
    disable_search_threshold: 2,
    width: "120px"
  });
  $('.index_select_box').on('change', function(evt, params) {
    ssn_refresh_data();
  });
*/

//$("#data_time_store_from")[0].value = moment(dateFrom, "X").format("YYYY-MM-DD HH:mm");
//$("#data_time_store_to")[0].value = moment(dateTo, "X").format("YYYY-MM-DD HH:mm");



// -----------------------------------------------------------------------------------
// get information about all devices for selected account and refresh data in browser:
function ssn_update_devices() {

var jqxhr_dict_devs = $.getJSON( ws_server+"/dict.php", 
{
a:  1,
dev: 0
})
.success(function(data) {
	console.log( "success" );
	devs = data;
	var i;
	var str_sel = " selected ";
	var box_check = "";
	var tr_class = "";
	$("#ch_fav_filter")[0].checked = getCookie("ssn-dev-fav-act")?true:false;

	for(i = 0; i < devs.length; i++) {
		var dt = ssn_get_device_type_info(devices_info, devs[i].dt_code);
		if (getCookie("ssn-dev-fav-"+devs[i].value) == 1) {
			box_check = "checked";
			tr_class = "tr_dev fav";
		}
		else {
			box_check = "";
			tr_class = "tr_dev nfav";
		}
		$(".ssn_devs_table").append('<tr id="tr_dev_'+devs[i].value+'" class="'+tr_class+'"><td><div class="panel panel-primary ssn_dev_'+devs[i].value+
			'"><div class="panel-heading"><h2 class="panel-title"><span class="badge active">'+devs[i].value+'</span> '+
			devs[i].label+'<span style="margin-right: 2px; float: right;"><img src="images/fav_star20.png"/> <input type="checkbox" id="inp_ch_fav_'+devs[i].value+'" onchange="ssn_fav_change(this)" '+box_check+' /></span></h2></div><div class="panel-body row"><div class="col-sm-4">'+devs[i].dev_comment+'<hr>'+devs[i].dev_type_comment+
			'</div><div class="col-sm-8">'+ssn_print_services(dt, devs[i].dev_index, devs[i].value)+'</div></div></div></td></tr>');

//		$("#tr_dev_"+devs[i].value)[0].hidden = true;
		
		if (devs[i].service_code == 3) {
		  $("#inp_ctrl_"+devs[i].value+"_3").chosen({
		    width: "100px"
		  });
		}
// activate chooser for boolean datatype:
		  $(".prop_select_box #dt_boolean").chosen({
		    width: "100px"
		  });
	}
	ssn_select_fav_devices();
	
/*	$(".device_select_box").chosen({
	    disable_search_threshold: 10,
	    include_group_label_in_selected: true,
	    no_results_text: "Oops, nothing found!",
	    width: "90%"
	});
  $('.device_select_box').on('change', function(evt, params) {
    ssn_refresh_data();
  });
*/

})
//.done(function( data ) {
//})
.fail(function() {
console.log( "error getting dict devs data" );
});

}

// ----------------------------------
// get static information about all devices types:
var jqxhr_dict_devs = $.getJSON( ws_server+"/dict.php", 
{
dtype: 0
})
.success(function(data) {
	console.log( "get dtype info success" );
	devices_info = data;
})
.done(function( data ) {
	ssn_update_devices();
})
.fail(function() {
console.log( "error getting common dict devs info" );
});



/*
function ssn_update_datetime() {

	dateTo = moment($("#data_time_store_to")[0].value, "YYYY-MM-DD HH:mm").format("X");
	dateFrom = moment($("#data_time_store_from")[0].value, "YYYY-MM-DD HH:mm").format("X");
}

$('.data_time_store').datetimepicker(
{
  format:'Y-m-d H:i',
  defaultDate:moment(dateTo, "X").format("YYYY-MM-DD HH:mm"), 
  defaultTime:'10:00',
  formatTime:'H:i',
  formatDate:'Y-m-d',
//  onSelect: dateSelect,
//  onShow: dateSelect,
  onChangeDateTime: ssn_update_datetime,
  closeOnDateSelect:true,
  timepicker:true
}
);
*/

});

