/**
 * Created by Kurniawan Yudha on 14/10/2016.
 */

var Profile = function () {

    return {
        init: function () {
            $("#upload_btn").click(function (e) {
                e.preventDefault();
                $.ajax({
                    url : "/profile/upload",
                    method : "POST",
                    data:{
                        avatar: 'asa'
                    },
                    dataType:'multipart/form-data',
                    async:false,
                    type:'post',
                    processData: false,
                    contentType: false,
                    success:function(response){
                        console.log(response);
                    }
                });
            });
        }
    }
}();