<?php 
require("includes.php");
$_SESSION['clan_id'] = (isset($_REQUEST['clan']) ? trim($_REQUEST['clan']) : (isset($_SESSION['clan_id']) && !empty($_SESSION['clan_id'] ) ? $_SESSION['clan_id']  : ""));
$myclan = getOcwClanLists($con,$_SESSION['clan_id']);
$_SESSION['my_clan'] = $myclan;
// $members = getClanMembersAPI($myclan['clan_tag']);
// $mymembers = processMembers($members);

// echo "<pre>";
// print_r($myclan);
// print_r($mymembers);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ocw-Create-Roster</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
</head>
<body>

<div class="container">
  <h2><?php echo $myclan['clan_name'];?></h2>
  <ul class="nav nav-tabs">
    <li><a href="/ocw">Home</a></li>
    <li class="active"><a data-toggle="tab" href="#mymembers">My Members</a></li>
    <li><a data-toggle="tab" href="#addplayer">Search Player</a></li>
    <li><a data-toggle="tab" href="#roster">View Roster</a></li>
  </ul>

  <div class="tab-content">
    <div id="mymembers" class="tab-pane fade in active">
      <h3>My Members</h3>
      <p>Select a member to be added to your roster.</p>
        <p>Press <b>Submit</b> and the members will added to your ocw roster.</p>
      <form id="frm-example" action="/ocw/data/add_roster.php" method="POST">
      <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
            	<th><input type="checkbox" name="select_all" value="1" id="example-select-all" style="vertical-align: middle"></th>
                <th>PLAYER NAME</th>
                <th>PLAYER TAG</th>
                <th>TH LEVEL</th>
                <th>AQ</th>
                <th>BK</th>
                <th>WARDEN</th>
            </tr>
        </thead>
    </table>
    <hr>
		<p>Select a member to be added to your roster.</p>
        <p>Press <b>Submit</b> and the members will added to your ocw roster.</p>
        <p><button>Submit</button></p>
        <b>Data submitted to the server:</b><br>
        <pre id="example-console">
        </pre>
    	</form>
    </div>
    <div id="addplayer" class="tab-pane fade">
      <h3>Search/Add Player to your roster.</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="roster" class="tab-pane fade">
      <h3>My Roster</h3>
      <table id="myTable2" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><input type="checkbox" name="select_all" value="1" id="example-select-all2" style="vertical-align: middle"></th>
                <th>PLAYER NAME</th>
                <th>PLAYER TAG</th>
                <th>TH LEVEL</th>
                <th>AQ</th>
                <th>BK</th>
                <th>WARDEN</th>
            </tr>
        </thead>
    </table>
    </div>
  </div>
</div>
<script type="text/javascript">

$(document).ready(function() {



	
	var table = $('#myTable1').DataTable( {
        "processing": true,
        "ajax": "data/get_my_members.php",
        'order': [[1, 'asc']],
        'columnDefs': [{
            'targets': 0,
            'searchable': false,
            'orderable': false,
            'className': 'dt-body-center',
            'render': function (data, type, full, meta){
                return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
            }
         }],
         "columns": [
                     { "data": "player_tag" },
                     { "data": "name" },
                     { "data": "player_tag" },
                     { "data": "townhall" },
                     { "data": "aq" },
                     { "data": "bk" },
                     { "data": "gw" }
                 ]
    } );
	var table2 = $('#myTable2').DataTable( {
        "processing": true,
        "ajax": "data/get_roster.php",
        'order': [[1, 'asc']],
        'columnDefs': [{
            'targets': 0,
            'searchable': false,
            'orderable': false,
            'className': 'dt-body-center',
            'render': function (data, type, full, meta){
                return '<input type="checkbox" name="sid[]" value="' + $('<div/>').text(data).html() + '">';
            }
         }],
         dom: 'Bfrtip',
         buttons: [
             //'copy', 'csv', 'excel', 'pdf', 'print'
             {
				extend: 'copy',
				exportOptions: {
                    columns: [ 1,2,3,4,5,6]
                }
             },
             {
  				extend: 'csv',
  				exportOptions: {
                      columns: [ 1,2,3,4,5,6 ]
                  }
               },
               {
  				extend: 'excel',
  				exportOptions: {
                      columns: [ 1,2,3,4,5,6 ]
                  }
               }
         ],
         iDisplayLength: -1,
         "columns": [
                     { "data": "player_tag" },
                     { "data": "name" },
                     { "data": "player_tag" },
                     { "data": "townhall" },
                     { "data": "aq" },
                     { "data": "bk" },
                     { "data": "gw" }
                 ]
    } );
	// Handle click on "Select all" control
	   $('#example-select-all').on('click', function(){
	      // Get all rows with search applied
	      var rows = table.rows({ 'search': 'applied' }).nodes();
	      // Check/uncheck checkboxes for all rows in the table
	      $('input[type="checkbox"]', rows).prop('checked', this.checked);
	   });

	   // Handle click on checkbox to set state of "Select all" control
	   $('#myTable1 tbody').on('change', 'input[type="checkbox"]', function(){
	      // If checkbox is not checked
	      if(!this.checked){
	         var el = $('#example-select-all').get(0);
	         // If "Select all" control is checked and has 'indeterminate' property
	         if(el && el.checked && ('indeterminate' in el)){
	            // Set visual state of "Select all" control
	            // as 'indeterminate'
	            el.indeterminate = true;
	         }
	      }
	   });

	   // Handle form submission event
	   $('#frm-example').on('submit', function(e){
	      var form = this;

	      // Iterate over all checkboxes in the table
	      table.$('input[type="checkbox"]').each(function(){
	         // If checkbox doesn't exist in DOM
	         if(!$.contains(document, this)){
	            // If checkbox is checked
	            if(this.checked){
	               // Create a hidden element
	               $(form).append(
	                  $('<input>')
	                     .attr('type', 'hidden')
	                     .attr('name', this.name)
	                     .val(this.value)
	               );
	            }
	         }
	      });

	   // FOR TESTING ONLY
	      
	      // Output form data to a console
// 	      $('#example-console').text($(form).serialize()); 
// 	      console.log("Form submission", $(form).serialize()); 
	       
// 	      // Prevent actual form submission
// 	      e.preventDefault();
	      
	   });





    
} );

</script>
</body>
</html>







