var FormDropzone = function () {


    return {
        //main function to initiate the module
        init: function () {
            // alert("X");
            Dropzone.options.myDropzone = {
                init: function() {
                    // alert("A");
                    this.on("addedfile", function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<button class='btn btn-sm btn-block'>Remove file</button>");

                        // Capture the Dropzone instance as closure.
                        var _this = this;
                        // alert("TES");
                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                          // Make sure the button click doesn't submit the form:
                          e.preventDefault();
                          e.stopPropagation();

                          // Remove the file preview.
                          _this.removeFile(file);
                          // If you want to the delete the file on the server as well,
                          // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    }).on('error', function (file, response) {
                        console.log(response);
                        $(file.previewElement).find('.dz-error-message').text("TES");
                    });
                }

                // addedfile: function (file) {
                //     // Create the remove button
                //     var removeButton = Dropzone.createElement("<button class='btn btn-sm btn-block'>Remove file</button>");
                //
                //     // Capture the Dropzone instance as closure.
                //     var _this = this;
                //
                //     alert("Tes");
                //     // Listen to the click event
                //     removeButton.addEventListener("click", function(e) {
                //         // Make sure the button click doesn't submit the form:
                //         e.preventDefault();
                //         e.stopPropagation();
                //
                //         // Remove the file preview.
                //         _this.removeFile(file);
                //         // If you want to the delete the file on the server as well,
                //         // you can do the AJAX request here.
                //     });
                //
                //     // Add the button to the file preview element.
                //     file.previewElement.appendChild(removeButton);
                // }
            }
        }
    };
}();