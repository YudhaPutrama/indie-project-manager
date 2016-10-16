<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/vendor/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="/vendor/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/js/metronic.js" type="text/javascript"></script>
<script src="/js/layout.js" type="text/javascript"></script>
<script src="/js/pages/profile.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function() {
        // initiate layout and plugins
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Profile.init(); // init page demo
    });
</script>