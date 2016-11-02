/**
 * Created by Chevalier on 11/2/2016.
 */

var Application = function () {

    return {
        initFormHanlder: function () {
            $("form").submit(function() {
                var formData = new FormData($(this)[0]);
                var _this = $(this);
                Metronic.blockUI({
                    target: _this,
                    animate: true
                });

                $.ajax({
                    url: window.location.pathname,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status=='success'){
                            toastr['success']("Successfully request", "Success");
                        } else {
                            if (data.detail!=null)
                                toastr['warning'](data.detail, "Warning");
                            else
                                toastr['error']("Something error", "Error")
                        }
                        console.log(data);
                    },
                    error: function (data) {
                        toastr['error']("Can't connect to server", "Error");
                        Metronic.unblockUI(_this);
                    },
                    complete: function(){
                        Metronic.unblockUI(_this);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
                return false;
            });
        }
    }
}();