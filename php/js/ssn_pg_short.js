
$(document).ready(function () {
    'use strict';

    var oTable;
     
    oTable = $('.ssn_data').DataTable({
	    "responsive": true,
            "processing": true,
            "serverSide": true,
	    "deferRender": true,
	    "dataType": "jsonp",
            "ajax": {
                "url": "http://192.168.1.114/ssn/ssn.php",
                "type": "GET"
            },
            "language": {
                "infoFiltered": " - filtered from _MAX_ records"
            },
		"order": [[6, 'desc']],

"columnDefs": [
        {
                "targets": 0,
		"data": 0,
                "visible": false
        },
        {
                "targets": 1,
		"data": 1,
                "visible": false
        },
        {
                "targets": 5,
		"data": 5,
                "visible": false
        },
	{
		"targets": 6,
		"data": 6,
		"render": function ( data, type, full, meta ) {
		return (moment(data, "X").format("D.MM.YYYY, H:mm:ss"));
	}
}]

});

setInterval( function () {
    oTable.ajax.reload( null, false ); // user paging is not reset on reload
}, 30000 );

yadcf.init(oTable, ([
        {
          column_number: 1,
	  filter_container_id: "external_filter_container_obj",
	  select_type: "chosen"
        },
        {
          column_number: 2,
	  filter_container_id: "external_filter_container_device",
          filter_type: "multi_select",
	  select_type: "chosen",
          select_type_options: {
            width: 100
          },
          filter_delay: 500
        },
        {
          column_number: 3,
          filter_type: "select",
	  filter_container_id: "external_filter_container_index",
	  select_type: "chosen",
          select_type_options: {
            width: 100
        	},
        },
//       {
//          column_number: 4
//          filter_type: "text",
//          filter_delay: 500
//        },
        {
          column_number: 6,
          filter_type: "range_date",
	  filter_container_id: "external_filter_container_date_store",
          filter_delay: 500
        }
]));
});
