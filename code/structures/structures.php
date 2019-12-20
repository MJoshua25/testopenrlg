<?php
require_once "../db/db_connect.php";
require_once "../db/structures.php";
?>
<style type="text/css" class="init">
    td.details-control {
        background: url('../assets/img/details_open.png') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('../assets/img/details_close.png') no-repeat center center;
    }
</style>
<script type="text/javascript" language="javascript" class="init">
    /* Formatting function for row details - modify as you need */
    $(document).ready(function() {
        $('#organismestable thead tr').clone(true).appendTo('#organismestable thead');
        $('#organismestable thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();
            $(this).html('<input type="text" />');
            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table.column(i).search(this.value).draw();
                }
            });
        });
        var table = $('#organismestable').DataTable({
            "ajax": '../db/structures/liste.php',
            "columns": [{
                    "data": "libelle"
                },
                {
                    "data": "typestructure"
                },
                {
                    "data": "typeorganisme"
                },
                {
                    "data": "ville"
                }
            ],
            "language": {
                "url": "../ajax/language.fr.json"
            },
            "columnDefs": [{
                targets: 0,
                render: function(data, type, row, meta) {
                    if (type === 'display') {
                        data = '<a href="?code=' + encodeURIComponent(row.code) + '">' + row.libelle + '</a>';
                    }
                    return data;
                }
            }]
        });
    });
</script>
<div class="container">
    <h3>
        <img src="../assets/img/structures.png" style="width: 45px; height: 45px;" /> Structures
    </h3>
    <br/>
    <a class="btn waves-effect waves-light #1565c0 blue darken-3" href="../index.php">
    < < < Retour
    </a>
    <br/>
    <br/>
    <div class="row">
        <table id="organismestable" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Libelle</th>
                    <th>Typestructure</th>
                    <th>Typeorganisme</th>
                    <th>Ville</th>
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
        <a class="btn-floating btn-large waves-effect waves-light #b71c1c red darken-4 z-depth-3" style="position: fixed; bottom: 25px; right: 25px;" href="index.php?code=vide">
            <strong>+</strong>
        </a>
    </span>
</div>