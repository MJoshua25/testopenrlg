<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('#interpretestable thead tr').clone(true).appendTo('#interpretestable thead');
        $('#interpretestable thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();
            $(this).html('<input type="text" />');

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#interpretestable').DataTable({
            "ajax": '../db/personnes/listeinterpretes.php',
            "columns": [
                {
                    "data": "nom"
                },
                {
                    "data": "prenom"
                },
                {
                    "data": "email"
                },
                {
                    "data": "role"
                }
            ],
            "language": {
                "url": "../ajax/language.fr.json"
            },
            "columnDefs": [{
                targets: 0,
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        data = '<a href="?code=' + encodeURIComponent(row.id) + '';
                        data += '&prs='+encodeURIComponent(row.personnefk)+'';
                        data += '&tpprs=int">' + row.nom + '</a>';
                    }
                    return data;
                }
            }]
        });
    });
</script>
<br />
<div class="row">
    <table id="interpretestable" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th colspan="4"></th>
            </tr>
        </tfoot>
    </table>
</div>

<span>
    <a class="btn-floating btn-large waves-effect waves-light #b71c1c red darken-4 z-depth-3" 
       style="position: fixed; bottom: 25px; right: 25px;" href="index.php?code=vide&tpprs=int">
        <strong>+</strong>
    </a>
</span>
