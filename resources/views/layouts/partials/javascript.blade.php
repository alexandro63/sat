<!--   Core JS Files   -->
<script src="{{ asset('js/core/jquery.3.2.1.min.js') }}"></script>
<script src="{{ asset('js/core/popper.min.js') }}"></script>
<script src="{{ asset('js/core/bootstrap.min.js') }}"></script>

<!-- jQuery UI -->
<script src="{{ asset('js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('js/plugin/chart.js/chart.min.js') }}"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Chart Circle -->
<script src="{{ asset('js/plugin/chart-circle/circles.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('js/plugin/datatables/datatables.min.js') }}"></script>

<!-- Bootstrap Notify -->
<script src="{{ asset('js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<!-- jQuery Vector Maps -->
<script src="{{ asset('js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

<!-- Sweet Alert -->
<script src="{{ asset('js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Atlantis JS -->
<script src="{{ asset('js/atlantis.min.js') }}"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!-- Common JS -->
<script src="{{ asset('js/common.js') }}"></script>
<!-- Functions JS -->
<script src="{{ asset('js/functions.js') }}"></script>
<!-- Lang JS -->
<script src="{{ asset('js/lang/es.js') }}"></script>



<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        @if (config('app.debug') == false)
            $.fn.dataTable.ext.errMode = 'none';
            // $(document).on('error.dt', function(e, settings, techNote, message) {
            //     alert('Hubo un problema al cargar los datos. Intenta de nuevo.');
            //     $.fn.dataTable.ajax.reload();
            // });
        @else
            $.fn.dataTable.ext.errMode = 'throw';
        @endif

    })
</script>
