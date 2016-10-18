<script src="/vendor/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="/vendor/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="/vendor/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="/vendor/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="/vendor/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/vendor/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>

<script src="/vendor/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="/vendor/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="/vendor/jquery.sparkline.min.js" type="text/javascript"></script>

<script src="/js/metronic.js" type="text/javascript"></script>
<script src="/js/layout.js" type="text/javascript"></script>
<script src="/js/pages/index.js" type="text/javascript"></script>

<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core componets
        Layout.init(); // init layout
        Index.init();
        Index.initCalendar(); // init index page's custom scripts
        Index.initCharts(); // init index page's custom scripts
        Index.initChat();
        Index.initMiniCharts();

        toastr.options = {
            "closeButton": true,
            "debug": true,
            "positionClass": "toast-bottom-right",
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    });
</script>