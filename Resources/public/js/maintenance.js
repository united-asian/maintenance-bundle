!function( $ ) {
    $.fn.maintenance_records = function( method ) {

        var settings,
            table;

        // Public methods
        var methods = {
            init: function( options ) {
                settings = $.extend( true, {}, $.fn.maintenance_records.defaults, options );

                return this.each(function() {
                    var $this = $( this );

                    table = $( "table.table", this ).dataTable( $.extend( true, {}, settings.datatables, {
			initComplete: function( settings, json ) {
   			    $( settings.nTable ).css( "display", "table" );
			}
                    } ) );
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
            $.error( "Method " +  method + " does not exist in $.maintenance_records." );
        }
    };

    $.fn.maintenance_records.defaults = {
        datatables: {
            autoWidth: false,
            columns: [
                { data: null },
                { data: "date_start" },
                { data: "date_end" },
                { data: "description" },
                { data: "confirmed" }
                { data: null }
            ],
            columnDefs: [
                { orderable: false, targets: [ 0, 5 ] },
                { visible: false, targets: [ 0 ] },
                { className: "actions", targets: [ 5 ] }
            ],
            language: {
                url: "/bundles/uamdatatables/datatables/" + .locale + ".json"
            },
            orderable: true,
            paging: true,
            processing: true,
            serverSide: true,
            stripeClasses: []
        }
    };
} ( window.jQuery );

$( document ).ready(function() {
    $( ".maintenance_records" ).maintenance_records( maintenance_records );
});