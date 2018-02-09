<!DOCTYPE html>

<html>


<head>
	<meta http-equiv="X-UA-Compatible" content="IE=11">
	<meta charset="UTF-8"/>

	<title>Company View</title>


	<!-- @TODO clean these up by testing one by one after commenting them out.  Move remaining js & css to internal application folder -->
	<link href="https://yadcf-showcase.appspot.com/resources/css/dataTables.jqueryui.css" rel="stylesheet"
		  type="text/css"></link>
	<link href="https://cdn.datatables.net/buttons/1.0.1/css/buttons.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css" rel="stylesheet">
	<link href="http://localhost/Codeigniter/css/zepernick.css" rel="stylesheet"/>
	<script src="https://yadcf-showcase.appspot.com/resources/js/jquery-1.8.2.min.js"></script>
	<script src="https://yadcf-showcase.appspot.com/resources/js/jquery-ui.1.9.0.js"></script>
	<script src="https://yadcf-showcase.appspot.com/resources/js/chosen.jquery.min.js"></script>
	<!-- <script src="https://yadcf-showcase.appspot.com/resources/js/jquery.dataTables.10.js"></script>  -->
	<script src="https:////cdn.datatables.net/1.10.10/js/jquery.dataTables.js"></script>
	<script src="https://yadcf-showcase.appspot.com/resources/js/dataTables.fixedHeader.min.js"></script>
	<script src="https://yadcf-showcase.appspot.com/resources/js/dataTables.responsive.js"></script>
	<script src="https://yadcf-showcase.appspot.com/resources/js/dataTables.jqueryui.js"></script>
	<script src="https://yadcf-showcase.appspot.com/resources/js/dataTables.colVis.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/yadcf/0.9.2/jquery.dataTables.yadcf.js"></script>


	<!-- <script src="https://yadcf-showcase.appspot.com/resources/js/dom_ajax_multiple_1.10_example.js"></script>  -->
	<script type="text/javascript" src="https://yadcf-showcase.appspot.com/resources/js/shCore.js"></script>
	<script type="text/javascript" src="https://yadcf-showcase.appspot.com/resources/js/shBrushJScript.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
	<link rel="stylesheet" href="<?php echo base_url("css/styles.css"); ?>" type="text/css"/>
	<!-- Testing Select -->
	<script type="text/javascript" src="https://cdn.datatables.net/select/1.2.2/js/dataTables.select.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.colVis.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.2/css/select.dataTables.min.css"
		  type="text/css"/>
	<link rel="stylesheet" hred="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css"
		  type="text/css">
	<!-- Testing multiselect -->
	<script type="text/javascript"
			src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.full.min.js"></script>


	<style>

		/* For some reason, Ive been having problems getting the css in the header to over-ride other CSS.  I think its because the css include links are also currently in the page and so theyre given the same priority */

		/* Use this style sheet to make the final tweaks to your report, don't try to change higher level style sheets that will change the way the entire application displays or behaves.  Use the !important flag if you need to. */

		/* This setting neatly formats and controls the headers and columns.  https://github.com/vedmack/yadcf/issues/101   */
		.yadcf-filter {
			width: 100px;
		}

		.yadcf-filter-range-date-seperator:after {

			content: ;

		}

		a.dropdown-toggle {

			z-index: 1 !important;
			position: relative !important;
		}

		a.dropdown-content {

			z-index: 1 !important;
		}

		td.child {

			text-align: left;

		}

		div.entrys_table_wrapper {

			border-top-width: 20px;

		}

		div.floatright {
			display: inline;
			float: right;
			padding-left: 5px;
		}

		a.fg-button.ui-state-disabled {
			border: 1px !important;
			border-style: solid !important;
			background-color: #e9e9e9 !important;
			padding: 4px !important;

		}

		a.fg-button {
			border: 1px !important;
			border-style: solid !important;
			background-color: white !important;
			padding: 4px !important;

		}

		/* This is hiding accessibility labels that show up next to controls */
		.ui-helper-hidden-accessible {
			display: none;
		}

		#external_filter_container_wrapper {
			margin-bottom: 20px;
		}

		#external_filter_container {
			display: inline-block;
		}

		tr.odd td {

			border-bottom-color: transparent !important;

		}

		tr.odd td {

			background-color: #E2E4FF !important;

		}


	</style>


	<script>


		/*     IMPORTANT NOTE FOR SERVER-SIDE PROCESSING    https://datatables.net/reference/type/selector-modifier

         When using DataTables in server-side processing mode (serverSide) the selector-modifier has very little effect on the rows selected
         since all processing (ordering, search etc) is performed at the server. Therefore, the only rows that exist on the client-side are those shown in the table at any one time,
         and the selector can only select those rows which are on the current page.

         from https://datatables.net/forums/discussion/29027/yadcf-dropdown-filter-only-show-data-from-current-page-of-table-not-from-all-page:
         When using Datatables with server side config you MUST provide yadcf with the values of each filter (think about it - you populate your DT with values of one page only, how do you
         expect yadcf to know what values exist in the other pages) so look at the showcase page - Server side source example see code snippet at the bottom and inspect the dev tools
         and the network tab to see how I provide the needed data for yadcf filters (sending yadcf_data_0 / yadcf_data_1 / etc.. from server along with the DT data).


         */

		jQuery.browser = {};
		(function () {
			jQuery.browser.msie = false;
			jQuery.browser.version = 0;
			if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
				jQuery.browser.msie = true;
				jQuery.browser.version = RegExp.$1;
			}
		})();


		// This first section is where custom javascript functions go.

		function popupwindow(url, title, w, h) {
			var x = screen.width / 2 - 500 / 2;
			//var x = screen.width/2;
			var y = screen.height / 2 - 450 / 2;
			//var w = w / 1.1;
			var w = w / 1.0;
			var h = h / 1.5;
			// Set all values to "yes" for debugging purposes so you have access to toolbars, xdebug debugging switch, etc...
			//return window.open(url, title, 'toolbar=yes, location=yes, directories=yes, status=yes, menubar=yes, scrollbars=yes, resizable=yes, copyhistory=yes, width='+w+', height='+h+', top='+y+', left='+x);
			return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + y + ', left=' + x);
		}

		$.fn.dataTable.ext.buttons.submit = {
			className: 'buttons-submit',
			action: function () {
				document.forms[0].submit();
				return false;
			}
		};

		$('#entrys_table tbody').on('click', 'button', function () {
			//var data = table.row( $(this).parents('tr') ).data();
			//alert( data[0] +"'s salary is: "+ data[ 5 ] );
			alert("TEST");
		});

		String.prototype.capitalize = function () {
			return this.charAt(0).toUpperCase() + this.slice(1);
		}

		var JS_BASE_URL = '<?php echo site_url(); ?>';


		// This second section is where your base datatables initialization and functions go.


		$(document).ready(function () {
			'use strict';


			var oTable = $('#entrys_table').DataTable({
				searchDelay: 1000,
				lengthMenu: [
					//Because the actual show all option of -1 sometimes doesn't seem to work for me, in those cases, I just make it a ridiculously large amount instead.
					// Only show all on filtered amounts of a few thousand at most or you'll crash your page.
					//@TODO put this back to ridiculously high amount after testing.  What effect does this have on the number of records stored in the dom?
					// The -1 setting seems to be working correctly now.
					[10, 25, 50, -1],
					[10, 25, 50, 'Show all']
				],
				"bStateSave": true,
				"responsive": true,
				// Use with custom classes -- see below buttons section below.
				"select": true,
				// Unless your model is actually set up for server side processing, don't use this or it will mess up your report.
				"serverSide": true,
				// "processing" option just shows the flashing word "processing" while your report is rendering.
				"processing": true,
				// deferRender has a HUGE effect on render time of a large report.  It defers rendering of HTML elements on data in the DOM until it's actually displayed.
				"deferRender": true,
				// autoWidth doesn't seem to have an effect.
				"autoWidth": true,
				"searching": true,
				// Case insensitive doesn't seem to work for server-side report.  I changed the code in the model to add it.
				"search": {
					"caseInsensitive": true
				},

				// This is the server-side ajax code.
				"ajax": {
					<?php /* "url": "<?php echo site_url('Rez_inventory/ajax_list')?>",  */ ?>
					"url": "http://localhost:8074/People/ajax_list",
					// Testing non-server side ajax-sourced data see https://datatables.net/forums/discussion/22532/filter-column-into-server-side-process look for "I might be wrong" in page.
					<?php /* "url": "<?php echo site_url('reports/secure/Ceu_input2/test_ajax')?>",  */ ?>
					// Using "POST" makes the report about 25% faster.  ~28 seconds for 155,000 records versus ~38 seconds for "Get".
					"type": "POST",
					// https://stackoverflow.com/questions/28367734/datatable-cannot-read-property-length-of-null
					"dataSrc": function (json) {
						if (!json.data) {
							$('#entrys_table').html('No result');
							json.data = [];
						}
						return json.data;
					},
					"data": function (d) {
						d.test = "test_name";
						//d.column_number.className = "test_column_data";
						return $.extend({}, d, {
							"extra_search": $('#extra').val()
						});
					}
				},


				//  This section is for defining groups of columns.  If you have some option that you want to apply to multiple columns, you can set it here.
				// You can do things like add links to columns this way.  The links could point to controllers, effectively creating forms.  https://datatables.net/reference/option/columnDefs
				"columnDefs": [{
					// array id of target column
					"targets": [4]
					// Don't show the data for this column, we're going to put something else there.
					//"data": null,
					// "defaultContent": "<button>This is a link to a controller!</button>"
				}  // Case insensitive doesn't seem to work, at least for server-side report.
					//{targets: '_all', case_insensitive: true}
					// { "width": "100%", "targets": [0,1,2,3] }

				],

				// This third section is for single column definitions.  className is used here in conjunction with the "Hide Columns" button.

				"columns": [{}, {}, {}, {}, {}

				],

				//  This section is for defining objects in the Buttons library.  In this case, it's the set of buttons used for exporting as well as some customized ones to hide specific columns etc...

				dom: 'lf<"floatright "B>rtip',

				buttons: [

					{  // Trying to make reset all columns example at http://yadcf-showcase.appspot.com/DOM_source_chosen.html work with Buttons library.
						text: 'Reset All Filters',
						action: function () {
							yadcf.exResetAllFilters(oTable)
						}

					},

					{   // Add classnames to Datatables (not YADCF) Column Definitions above and then add them here to hide columns.
						extend: 'colvisGroup',
						titleAttr: "Remove search fields for export",
						text: 'Hide Columns',
						hide: '.INVENTORY_ID, .MODIFY_TS'
					},

					{
						extend: 'colvisGroup',
						text: 'Show all',
						show: ':hidden'
					},


					{

						text: 'Add New Record',
						action: function (e, dt, button, config) {

							popupwindow('<?php echo base_url();?>index.php/Rez_inventory_details/newRezInventory/', 'TEST', 600, 600);

						}

					},

					{
						// @TODO This seems to have stopped working server side. It was because "selected" was commented out in the Datatables options.
						extend: 'selected',
						titleAttr: "You must first select a record",
						text: 'Edit selected record',
						action: function (e, dt, button, config) {
							//alert(dt.rows({selected: true}).indexes().length + ' row(s) selected');
							//alert(dt.rows({selected: true}).indexes().length + ' row(s) selected');

							var data = oTable.rows({selected: true}).data();
							var newarray = [];
							for (var i = 0; i < data.length; i++) {


								popupwindow('<?php echo base_url();?>index.php/Rez_inventory_details/index/' + data[i][0], 'TEST', 600, 600);


								newarray.push(data[i][0]);
								newarray.push(data[i][1]);
							}

							var sData = newarray.join();


						}
					},
					{   // https://datatables.net/reference/button/csv
						extend: 'csv',
						filename: 'export.csv',
						exportOptions: {
							// Setting columns to visible causes error in Edge browser.
							columns: ':visible',
							// Remove content of filter controls from export https://github.com/vedmack/yadcf/issues/284
							format: {

								header: function (mDataProp, columnIdx) {
									var htmlText = '<span>' + mDataProp + '</span>';
									var jHtmlObject = jQuery(htmlText);
									console.log('htmlText = ' + htmlText)
									jHtmlObject.find('Select').remove();
									//jHtmlObject.find('x').remove();
									var newHtml = jHtmlObject.text();
									// Use for debugging header
									//console.log('My header > ' + newHtml);
									return newHtml;

								}
							}
						}
					}

				]


			});


			// YADCF Column Definitions
			yadcf.init(oTable, [{
				data: '<?php echo $_SESSION['FIELD'][0]  ?>',
				column_number: 0,
				width: '1px',
				filter_type: "text",
				exclude: false,                  //@TODO get exclude functionality working for Oracle (it's currently designed for MySQL).
				exclude_label: '',
				case_insensitive: true,
				filter_reset_button_text: false  //This gets rid of the individual header filter reset button.  There's an issue at export where any label -- like an 'X' -- gets exported too.
			}, {
				data: '<?php echo $_SESSION['FIELD'][1]  ?>',
				column_number: 1,
				width: '1px',
				filter_type: "text",
				exclude: false,
				exclude_label: '',
				filter_reset_button_text: false
			}, {
				data: '<?php echo $_SESSION['FIELD'][2] ?>',
				column_number: 2,
				filter_type: "text",
				filter_reset_button_text: false
				//filter_default_label: "Select Yes/No"
				//regex: "false"
			}, {
				data: '<?php echo $_SESSION['FIELD'][3] ?>',
				column_number: 3,
				filter_type: "text",
				case_insensitive: true,
				filter_delay: 500,
				filter_reset_button_text: false
			}, {
				data: '<?php echo $_SESSION['FIELD'][4] ?>',
				column_number: 4,
				filter_type: "text",
				//date_format: "dd-M-y", // This is default Oracle Date Format
				//date_format: "yy-mm-dd",
				filter_reset_button_text: false
				/*  filter_plugin_options: {
                      changeMonth: true,
                      changeYear: true,
                      yearRange: '1980:nnnn'
                  }  */
			}
			]);


			// Example filter using "HICKS".  This seems to be set by an Ajax call firing after the initial load.
			//  exFilterColumn mostly doesn't work with serverside processing.  see YADCF author's (daniel_r) note here:  https://datatables.net/forums/discussion/22694/set-a-default-value-in-yadcf
			//  see comment by daniel_r on https://datatables.net/forums/discussion/22532/filter-column-into-server-side-process look for "filtering logic".
			//yadcf.exFilterColumn(oTable, [[1, "HICKS"]]);
			//yadcf.exFilterColumn(oTable, [[0, "ACTIVE" , "INACTIVE"]]);


		});
	</script>


</head>


<body>
<div class="container" style="font-size: 1em;">

	</header>

	<div>
		<?php
		$attributes = array(
			'width' => '900',
			'height' => '900',
			'scrollbars' => '0',
			'status' => 'yes',
			'resizable' => 'yes',
			'screenx' => '0',
			'screeny' => '0'

		);

		?>

		<table cellpadding="0" cellspacing="0" border="0" class="display" id="entrys_table">
			<thead>
			<tr>


				<th>Person ID</th>
				<th>Last Name</th>
				<th>First Name</th>
				<th>Phone Number</th>
				<th>Email</th>


			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>

</div>

<!-- </div>  -->

</body>

</html>
