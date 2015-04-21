var dateTo = moment().format("X");
var dateFrom = moment().subtract(1, 'day').format("X");

$(document).ready(function () {
    'use strict';
	var devs;
	var items;
	var axisses_left_title = "";
	var axisses_right_title = "";
	var groups_data;

  var groups;
  var dataset;
  var options;
  var graph2d;
  var vis_container;

  $(".index_select_box").chosen({
    disable_search_threshold: 2,
    width: "120px"
  });
  $('.index_select_box').on('change', function(evt, params) {
    ssn_refresh_data();
  });


$("#data_time_store_from")[0].value = moment(dateFrom, "X").format("YYYY-MM-DD HH:mm");
$("#data_time_store_to")[0].value = moment(dateTo, "X").format("YYYY-MM-DD HH:mm");

var jqxhr_dict_devs = $.getJSON(ws_server+"/dict.php", 
{
a:  1,
rt: 3,
st: 2
})
.success(function(data) {
	console.log( "success" );
	devs = data;
	var i;
	var str_sel = " selected ";
	$("#external_filter_container_device").append('<select class="device_select_box" data-placeholder="Select Your Options" multiple="true"></select>');
	for(i = 0; i < devs.length; i++) {
		$(".device_select_box").append('<option value="'+devs[i].value+'"'+str_sel+'>'+devs[i].label+'</option>');
		str_sel = "";
	}
	$(".device_select_box").chosen({
	    disable_search_threshold: 10,
	    include_group_label_in_selected: true,
	    no_results_text: "Oops, nothing found!",
	    width: "90%"
	});

  $('.device_select_box').on('change', function(evt, params) {
    ssn_refresh_data();
  });

  ssn_refresh_data();

})
//.done(function( data ) {
//})
.fail(function() {
console.log( "error getting dict devs data" );
});


function ssn_update_datetime() {

	dateTo = moment($("#data_time_store_to")[0].value, "YYYY-MM-DD HH:mm").format("X");
	dateFrom = moment($("#data_time_store_from")[0].value, "YYYY-MM-DD HH:mm").format("X");

	ssn_refresh_data();
}

function ssn_refresh_data() {

var jqxhr = $.getJSON( ws_server+"/wsgraph.php", 
{
a: 1,
gb: dateFrom,
ge: dateTo,

dev: $( "select.device_select_box option:selected" ).map( function() {return this.value;}).get().join( "|" ),
ind: $( "select.index_select_box option:selected" ).map( function() {return this.value;}).get().join( "|" )

})
.done(function( data ) {
	console.log( "success");
	groups_data = data[0].groups;
	items = data[1].devices;
	axisses_left_title = data[2].axisses[0].left_title;
	axisses_right_title = data[2].axisses[0].right_title;
})
.fail(function() {
console.log( "error getting graph data" );
})
.always(function() {
console.log( "complete graph data" );
  vis_container = document.getElementById('visualization');

  if (groups === undefined) {
	groups = new vis.DataSet(groups_data);
  } else {
//	groups.clear();
	groups.update(groups_data);
  }

  if (dataset === undefined) {
 	dataset = new vis.DataSet(items);
  } else {
	dataset.clear();
	dataset.update(items);
  }

//  if (options === undefined) {
      options = {
        defaultGroup: 'ungrouped',
        legend: true,
        drawPoints: {style: 'circle', size: 6 },
        start: moment(dateFrom, "X").format("YYYY-MM-DD HH:mm"),
        end: moment(dateTo, "X").format("YYYY-MM-DD HH:mm"),
        dataAxis: {
            showMinorLabels: false,
            title: {
                left: {
                    text: axisses_left_title
                },
                right: {
                    text: axisses_right_title
                }
            }
        }
     }
//  } else {
//  }

  if (graph2d === undefined) {
	graph2d = new vis.Graph2d(vis_container, dataset, groups, options);
  } else {
	graph2d.setOptions(options);
	graph2d.setWindow(moment(dateFrom, "X").format("YYYY-MM-DD HH:mm"), moment(dateTo, "X").format("YYYY-MM-DD HH:mm"), {animate: true});
	graph2d.redraw();
  }

});
};


//jqxhr.always(function() {
//alert( "second complete" );
//});



$('.data_time_store').datetimepicker(
{
  format:'Y-m-d H:i',
  defaultDate:moment(dateTo, "X").format("YYYY-MM-DD HH:mm"), 
  defaultTime:'10:00',
  formatTime:'H:i',
  formatDate:'Y-m-d',
//  mask:'9999-19-39 29:59:00',
//  onSelect: dateSelect,
//  onShow: dateSelect,
  onChangeDateTime: ssn_update_datetime,
  closeOnDateSelect:true,
  timepicker:true
}
);

});

