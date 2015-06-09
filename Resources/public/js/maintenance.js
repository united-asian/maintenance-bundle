
!function( $ ) {
	$.fn.maintenance = function( method ) {

		var settings,
			table;

		// Public methods

		var methods = {
			init: function( options ) {
				var $this = $( this );

				settings = $.extend( true, {}, this.maintenance.defaults, options );

				return this.each(function() {
					table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.datatables, {
						initComplete: function( settings, json ) {
							$( this ).show();
						}
					} ));
				});
			}
		};

		if ( methods[ method ] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ) );
		}
		else if ( typeof method === "object" || !method ) {
			return methods.init.apply( this, arguments );
		}
		else {
			$.error( "Method " +  method + " does not exist in $.maintenance." );
		}
	};

	$.fn.maintenance.defaults = {
		datatables: {
			autoWidth: false,
			columns: [
				{ data: null },
				{ data: "id" },
				{ data: "date_start" },
				{ data: "date_end" },
				{ data: "description" },
				{ data: "confirmed" },
				{
					data: function( row, type, val, meta ) {
						if ( "display" === type ) {
							var template = $( "template.actions" ).html();
							return Mustache.render( template, row );
						}

						return "";
					}
				}
			],
			columnDefs: [
				{ orderable: false, targets: [ 0 ] }, // First column and last column ("actions") are not sortable
				{ visible: false, targets: [ 0 ] }, // Hide the first column
				{ className: "actions", targets: [ 5 ] } // Set special "actions" class on cells in the last column
			],
			language: {
				url: "/bundles/uamdatatables/lang/" + maintenance.locale + ".json"
			},
			orderable: true,
			paging: true,
			processing: true,
			serverSide: true, // set datatables to use ajax to display content
			stripeClasses: []
		}
	};
} ( window.jQuery );

// Make sure that a parent element of the table has the class ''.persons'' set so that this plugin can be triggered properly when the page is loaded.
$( document ).ready(function() {
	$( ".maintenances" ).maintenance( uammaintenances );
});
