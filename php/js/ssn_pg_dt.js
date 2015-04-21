
$(document).ready(function () {
    'use strict';

    var oTable;
     
    oTable = $('#ssn_data').DataTable({
	    "responsive": true,
            "processing": true,
            "serverSide": true,
	    "deferRender": true,
	    "dataType": "jsonp",
            "ajax": {
                "url": ws_server+"/ssn.php",
                "type": "GET"
            },

            "language": {
                "infoFiltered": " - filtered from _MAX_ records"
            },
		"order": [[ 0, 'desc' ],[ 6, 'desc']],
		"sort_as": [[ 0, 'num' ]],

"columnDefs": [ {
    "targets": [5],
    "data": [5],
    "render": function ( data, type, full, meta ) {
      return (moment(data, "X").format("D.MM.YYYY, H:mm:ss"));
    }
  },
{
    "targets": [6],
    "data": [6],
    "render": function ( data, type, full, meta ) {
      return (moment(data, "X").format("D.MM.YYYY, H:mm:ss"));
    }
  } ]

    });

setInterval( function () {
    oTable.ajax.reload( null, false ); // user paging is not reset on reload
}, 30000 );


    yadcf.init(oTable, ([
        {
          column_number: 0,
	  column_data_type: "text",
          filter_type: "text",
	  filter_default_label: "type id to filter",
          filter_delay: 500
        },
        {
          column_number: 1,
	  select_type: "chosen"
        },
        {
          column_number: 2,
          filter_type: "multi_select",
	  select_type: "chosen",
          filter_delay: 500
        },
        {
          column_number: 3,
          filter_type: "select",
	  select_type: "chosen"
        },
        {
          column_number: 4,
          filter_type: "text",
          filter_delay: 500
        },
        {
          column_number: 5,
          filter_type: "range_date",
	  sort_order:  "desc",
          filter_delay: 500
        },
        {
          column_number: 6,
          filter_type: "range_date",
          filter_delay: 500
        }
        ]));
         
//    yadcf.exFilterColumn(oTable, [[3, "Trident"]]);

    });
