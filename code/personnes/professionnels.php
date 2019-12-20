<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
        $('#professionnelstable thead tr').clone(true).appendTo('#professionnelstable thead');
        $('#professionnelstable thead tr:eq(1) th').each(function(i) {
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

        var table = $('#professionnelstable').DataTable({
            "ajax": '../db/personnes/listeprofessionnels.php',
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
                        data = '<a href="?code=' + encodeURIComponent(row.id) + '&tpprs=pfs">' + row.nom + '</a>';
                    }
                    return data;
                }
            }]
        });
    });
</script>
<br />
<div class="row">
    <table id="professionnelstable" class="display" cellspacing="0" width="100%">
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
       style="position: fixed; bottom: 25px; right: 25px;" href="index.php?code=vide&tpprs=pfs">
        <strong>+</strong>
    </a>
</span>
