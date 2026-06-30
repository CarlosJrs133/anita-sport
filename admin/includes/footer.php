<!-- ===========================================
     BOOTSTRAP JS
     Permite que funcionen componentes de Bootstrap
     como menús, modales y botones interactivos.
=========================================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<!-- ===========================================
     SPRINT 7 - MODIFICACIÓN 02
     JQUERY

     DataTables necesita jQuery para funcionar.
=========================================== -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<!-- ===========================================
     SPRINT 7 - MODIFICACIÓN 03
     DATATABLES JS

     Estas librerías activan:
     ✔ Buscador
     ✔ Paginación
     ✔ Ordenamiento
     ✔ Diseño integrado con Bootstrap 5
=========================================== -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>


<!-- ===========================================
     SPRINT 7 - MODIFICACIÓN 04
     DATATABLES RESPONSIVE

     Hace que las tablas se adapten mejor
     en pantallas pequeñas.
=========================================== -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>


<!-- ===========================================
     SPRINT 7 - MODIFICACIÓN 05
     BOTONES DE EXPORTACIÓN

     Permiten exportar la tabla a Excel, PDF
     e imprimir el listado.
=========================================== -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>


<!-- ===========================================
     SPRINT 7 - MODIFICACIÓN 06
     ACTIVACIÓN DE DATATABLES

     Toda tabla que tenga la clase "tabla-dinamica"
     tendrá buscador, paginación, ordenamiento
     y botones de exportación.
=========================================== -->
<script>
$(document).ready(function () {

    $('.tabla-dinamica').DataTable({
        responsive: true,
        pageLength: 10,

        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
        },

        dom: 'Bfrtip',

        buttons: [
            'excel',
            'pdf',
            'print'
        ]
    });

});
</script>

</body>

</html>