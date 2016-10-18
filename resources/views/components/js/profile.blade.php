<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/vendor/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<script>
    jQuery(document).ready(function() {
        $("form#uploadAvatar").submit(function() {

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: window.location.pathname,
                type: 'POST',
                data: formData,
                async: false,
                dataType: 'json',
                success: function (data) {
                    if (data.status=='success'){
                        toastr['success']("Avatar upload success", "Avatar Upload");
                    } else {
                        toastr['error']("Something error", "Avatar Upload")
                    }
                    console.log(data);
                },
                error: function (data) {
                    toastr['error']("Can't connect to server", "Avatar Upload")
                },
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        });
        $("form#biodata").submit(function() {

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: window.location.pathname,
                type: 'POST',
                data: formData,
                async: false,
                dataType: 'json',
                success: function (data) {
                    if (data.status=='success'){
                        toastr['success']("Biodata update success", "Biodata Update");
                    } else {
                        toastr['error']("Something error", "Biodata Update")
                    }
                    console.log(data);
                },
                error: function (data) {
                    toastr['error']("Can't connect to server", "Biodata Update")
                },
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        });
        $("form#changePassword").submit(function() {

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: window.location.pathname,
                type: 'POST',
                data: formData,
                async: false,
                dataType: 'json',
                success: function (data) {
                    if (data.status=='success'){
                        toastr['success']("Cahnge password success", "Change Password");
                    } else {
                        toastr['error']("Something error", "Change Password")
                    }
                    console.log(data);
                },
                error: function (data) {
                    toastr['error']("Can't connect to server", "Change Password");
                    console.log(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        });

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