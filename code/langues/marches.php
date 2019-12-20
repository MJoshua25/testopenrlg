<script type="text/javascript" language="javascript" class="init">  

    $(document).ready(function() {
        $('#marchestable thead tr').clone(true).appendTo( '#marchestable thead' );
        $('#marchestable thead tr:eq(1) th').each( function (i) {
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

        var table = $('#marchestable').DataTable({
            "ajax": '../db/langues/listemarches.php',
            "columns": [                
                {
                    "data": "libelle"
                },
                {
                    "data": "typecontrat"
                },
                {
                    "data": "prix"
                },
                {
                    "data": "date_debut"
                },
                {
                    "data": "date_fin"
                }
            ],
            "language": {
                "url": "../ajax/language.fr.json"
            },
            "columnDefs": [{
                targets: 0,
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        data = '<a href="?code=' + encodeURIComponent(row.code) + '&tplgm=mrc">' + row.libelle + '</a>';
                    }                    
                    return data;
                }
            }],
            orderCellsTop: true,
            fixedHeader: true
        });
    });
</script>
<br/>
<div class="row">
    <table id="marchestable" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>                
                <th>Libelle</th>
                <th>Type de contrat</th>
                <th>Prix</th>
                <th>Date de début</th>
                <th>Date de fin</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th colspan="5"></th>
            </tr>
        </tfoot>
    </table>
</div>
<span>
    <a class="btn-floating btn-large waves-effect waves-light #b71c1c red darken-4 z-depth-3" 
       style="position: fixed; bottom: 25px; right: 25px;" href="index.php?code=vide&tplgm=mrc">
        <strong>+</strong>
    </a>
</span>