<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('#languestable thead tr').clone(true).appendTo( '#languestable thead' );
        $('#languestable thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" />' );
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );
        var table = $('#languestable').DataTable({
            "ajax": '../db/langues/listelangues.php',
            "columns": [               
                {
                    "data": "libelle"
                },
                {
                    "data": "liblotslang"
                }
            ],
            "language": {
                "url": "../ajax/language.fr.json"
            },
            "columnDefs": [{
                targets: 0,
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        data = '<a href="?code=' + encodeURIComponent(row.code) + '&tplgm=lgn">' + row.libelle + '</a>';
                    }                    
                    return data;
                }
            }]
        });
    });
</script>
<br />
<div class="row">
    <table id="languestable" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>                
                <th>Libelle</th>                
                <th>Lots de langues</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div>
<span>
    <a class="btn-floating btn-large waves-effect waves-light #b71c1c red darken-4 z-depth-3" 
       style="position: fixed; bottom: 25px; right: 25px;" href="index.php?code=vide&tplgm=lgn">
        <strong>+</strong>
    </a>
</span>