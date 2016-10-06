$(document).ready(function() {
    $grouping(1);

    $("#active").click(function(){
        $("#inactive").removeClass().addClass("active");
        $("#active").removeClass().addClass("inactive");
        $grouping(3);
    })

    $("#inactive").click(function(){
        $("#inactive").removeClass().addClass("active");
        $("#active").removeClass().addClass("inactive");
        $grouping(1);
    })

} );

$grouping = function(a) {
    var table = $('#datas-list').DataTable({
        "destroy": true,
        "bFilter": false,
        "paging": false,
        "order": [[ a, 'asc' ]],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(a, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="success"><td class="blue" colspan="6">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );
}

