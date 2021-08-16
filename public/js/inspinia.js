$(document).ready(function () {

    var cloudServices = [
        {
            icon: "/img/dropbox.png",
            name: "Dropbox",
            tutorial: "/img/tutorials/dropbox.mp4"
        },
        {
            icon: "/img/googledrive.png",
            name: "GoogleDrive",
            tutorial: "/img/tutorials/google-drive.mp4"
        },
    ];

    function showDialog(title, text, callback) {
        if (text.trim() == "") {
            text = "Network error";
        }
        BootstrapDialog.show({
            title: title,
            message: text,
            buttons: [{
                cssClass: 'btn-primary',
                label: 'Ok',
                action: function (dialog) {
                    dialog.close();
                    if (!!callback) {
                        callback();
                    }
                }
            }]
        });
    }

    $('.projectionDialog').on("click", function (event) {
        var title = 'What is "Projection"?';
        var message = $(this).attr('title');
        showDialog(title, message);
    });

    $('.projectionBigDialog').on("click", function (event) {
        var title = 'What is "Projected additional earnings"?';
        var message = $(this).attr('title');
        showDialog(title, message);
    });

    //tabs fragment navigation
    if (window.location.hash) {
        var tab = "ul.nav a[href='" + window.location.hash + "']";
        var $tab = $(tab);
        if ($tab.length == 1) {
            $tab.parents('ul').find('li').removeClass('active');
            $tab.click();
            window.location.hash = '';
        }
    }

    $('.chosen').chosen();

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '+1d',
        todayHighlight: true,
        autoclose: true
    });

    function updateExclusiveRightField() {
        var selector = ".exclusive_rights_cost_div";
        var privateValue = 'private for target price';
        var value = $(this).val();
        if (value == privateValue) {
            $(selector).removeClass('hidden');
        } else {
            $(selector).addClass('hidden');
        }
    }

    $('#uploadform-license_type').on('change', updateExclusiveRightField);


    // upload
    var retries = 0;
    var chunkSize = 1000000;

    function hideFields() {
        $('.upload-fields').addClass('hidden');
    }

    function showError(text) {
        hideFields();
        hideProgress();
        $('.error-div').removeClass('hidden');
        $('.error-div .alert').html(text);
    }

    function hideError() {
        $('.error-div').addClass('hidden');
    }

    function showProgress() {
        $('.progress-div').removeClass('hidden');
    }

    function hideProgress() {
        $('.progress-div').addClass('hidden');
    }

    function updateProgress(percent, text) {
        var div = $('.progress-div');
        var h1 = div.find('h1');
        var progressBar = div.find('.progress-bar');
        progressBar.attr('style', "width:" + parseInt(percent, 10) + "%");
        h1.html(text);
    }

    function isJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }

    function getErrorFromRequest(XMLHttpRequest) {
        var defaultError = "Network error occurs";
        var responseText = XMLHttpRequest.responseText;
        if (responseText == "") {
            return defaultError;
        }
        if (isJsonString(responseText)) {
            var responseJSON = JSON.parse(responseText);
            if (responseJSON['message']) {
                return responseJSON['message'];
            }
        }
        return defaultError;
    }

    function uploadComplete(data) {
        var path = data.files[0]['name'];
        var url = $('#fileupload').data('completeurl');
        $.ajax({
            type: "POST",
            url: url,
            data: {path: path},
            success: function (msg) {
                document.location.reload(true);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                showError(getErrorFromRequest(XMLHttpRequest));
            }
        });
    }

    function collectUrls() {
        var urls = [];
        //raw url
        var urlVal = $('#upload_url').val();
        if (urlVal) {
            urls.push(urlVal);
        }
        //cloud url
        $('.cloudurl').each(function () {
            var val = $(this).val();
            if (val) {
                urls.push(val);
            }
        });
        return urls;
    }

    function collectUploadData() {
        return {
            ftp: $('#upload_ftp_file').val(),
            url: collectUrls()
        };
    }

    $('#upload_save_video_info').on('click', function () {
        var data = collectUploadData();
        hideFields();
        hideError();
        showProgress();
        updateProgress(100, "Saving...")
        $.ajax({
            type: "POST",
            url: $('#fileupload').data('completeurl'),
            data: data,
            success: function (msg) {
                document.location.reload(true);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                showError(getErrorFromRequest(XMLHttpRequest));
            }
        });
    });

    $('#fileupload').fileupload({
        maxChunkSize: chunkSize,
        maxRetries: 1000,
        recalculateProgress: true,
        sequentialUploads: true,
        retryTimeout: 500,
        done: function (e, data) {
            uploadComplete(data);
        },
        add: function (e, data) {
            var that = this;
            var url = $('#fileupload').data('url');
            $.getJSON(url, {file: data.files[0].name}, function (result) {
                var file = result.file;
                var filesize = data.files[0].size;
                data.uploadedBytes = file && file.size;
                if (data.uploadedBytes == filesize) {
                    uploadComplete(data);
                } else {
                    $.blueimp.fileupload.prototype
                        .options.add.call(that, e, data);
                }
            });
            hideError();
            hideFields();
            showProgress();
        },
        progress: function (e, data) {
            var progress = (data.loaded / data.total * 100).toFixed(2);
            updateProgress(progress, 'Uploading... ' + progress + "%");
        },
        fail: function (e, data) {
            var fu = $(this).data('blueimp-fileupload') || $(this).data('fileupload'),
                retry = function () {
                    var url = $('#fileupload').data('url');
                    $.getJSON(url, {file: data.files[0].name})
                        .done(function (result) {
                            var file = result.file;
                            data.uploadedBytes = file && file.size;
                            data.data = null;
                            data.submit();
                        })
                        .fail(function () {
                            fu._trigger('fail', e, data);
                        });
                };
            if (data.errorThrown !== 'abort' &&
                data.uploadedBytes < data.files[0].size &&
                retries < fu.options.maxRetries) {
                retries += 1;
                window.setTimeout(retry, retries * fu.options.retryTimeout);
                return;
            }
            showError("Upload failed due to network failures. Please reload page, re-pick the file again later and the upload will resume.");
        }
    });

    //upload page
    if ($('#fileupload').length > 0) {

        var uploadFields = $('.upload-fields .field-append');
        var fieldSeparator = $('.upload-fields .field-separator').first().html();

        for (var i in cloudServices) {
            var cloudfield = generateCloudField(cloudServices[i]);
            uploadFields.append(fieldSeparator);
            uploadFields.append(cloudfield);
        }

        $('body').on('click', '.cloudDriveDialog', function () {
            var videoUrl = $(this).attr('video');
            var video = '<video width="100%" height="auto" controls>\n' +
                '  <source src="' + videoUrl + '" type="video/mp4">\n' +
                '</video>';
            showDialog("How to upload", video);
        });
    }

    function generateCloudField(cloud) {

        var helpIcon = '<span style="vertical-align: middle; cursor: pointer" ' +
            'class="badge badge-info badge-info-th cloudDriveDialog" ' +
            'title="Click to watch how to upload" ' +
            'video="' + cloud.tutorial + '">?</span>';

        return '<div class="row">\
            <div class="form-group">\
                <label \
                style="display:inline-block; vertical-align: middle"\
                class="control-label col-sm-5">\
                or <img \
                style="display: inline-block; width: 25px; height: auto; vertical-align: middle"\
                 src="' + cloud.icon + '" alt="' + cloud.name + '">\
                    ' + cloud.name + ' URL ' + helpIcon + '\
                </label>\
                <div class="col-sm-7">\
                    <input type="text" class="form-control cloudurl">\
                </div>\
            </div>\
     </div>';
    }

    $('.deletionConfirm').on('click', function (event) {
        var text = $(this).attr('deletionText');
        var url = $(this).attr('href');
        var tr = $(this).parents('tr').first();
        event.preventDefault();
        BootstrapDialog.show({
            title: "Please confirm",
            message: text,
            buttons: [
                {
                    cssClass: 'btn-primary',
                    label: 'Yes',
                    action: function (dialog) {
                        dialog.close();
                        $.get(url);
                        tr.hide();
                    }
                },
                {
                    cssClass: 'btn-default',
                    label: 'No',
                    action: function (dialog) {
                        dialog.close();
                    }
                }
            ]
        });
    });

    //
    // $('#headshot_input').on('change', function (e) {
    //     var input = document.getElementById('headshot_input');
    //     var $modal = $('#modal');
    //     var files = e.target.files;
    //     var done = function (url) {
    //         input.value = '';
    //         image.src = url;
    //         $modal.modal('show');
    //     };
    //     var reader;
    //     var file;
    //
    //     if (files && files.length > 0) {
    //         file = files[0];
    //         if (URL) {
    //             done(URL.createObjectURL(file));
    //         } else if (FileReader) {
    //             reader = new FileReader();
    //             reader.onload = function (e) {
    //                 done(reader.result);
    //             };
    //             reader.readAsDataURL(file);
    //         }
    //     }
    // });
    //
    // $modal.on('shown.bs.modal', function () {
    //     cropper = new Cropper(image, {
    //         aspectRatio: 1,
    //         viewMode: 3,
    //     });
    // }).on('hidden.bs.modal', function () {
    //     cropper.destroy();
    //     cropper = null;
    // });
    //
    // //upload profile headshot, poster
    // $('#headshot').once('click', function () {
    //
    //     var avatar = document.getElementById('headshot');
    //     var image = document.getElementById('headshot_image');
    //
    //
    //     var cropper;
    //
    //
    //
    //     document.getElementById('crop').addEventListener('click', function () {
    //         var initialAvatarURL;
    //         var canvas;
    //
    //         $modal.modal('hide');
    //
    //         if (cropper) {
    //             canvas = cropper.getCroppedCanvas({
    //                 width: 160,
    //                 height: 160,
    //             });
    //             initialAvatarURL = avatar.src;
    //             avatar.src = canvas.toDataURL();
    //             $progress.show();
    //             $alert.removeClass('alert-success alert-warning');
    //             canvas.toBlob(function (blob) {
    //                 var formData = new FormData();
    //
    //                 formData.append('avatar', blob, 'avatar.jpg');
    //                 $.ajax('https://jsonplaceholder.typicode.com/posts', {
    //                     method: 'POST',
    //                     data: formData,
    //                     processData: false,
    //                     contentType: false,
    //
    //                     xhr: function () {
    //                         var xhr = new XMLHttpRequest();
    //
    //                         xhr.upload.onprogress = function (e) {
    //                             var percent = '0';
    //                             var percentage = '0%';
    //
    //                             if (e.lengthComputable) {
    //                                 percent = Math.round((e.loaded / e.total) * 100);
    //                                 percentage = percent + '%';
    //                                 $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
    //                             }
    //                         };
    //
    //                         return xhr;
    //                     },
    //
    //                     success: function () {
    //                         $alert.show().addClass('alert-success').text('Upload success');
    //                     },
    //
    //                     error: function () {
    //                         avatar.src = initialAvatarURL;
    //                         $alert.show().addClass('alert-warning').text('Upload error');
    //                     },
    //
    //                     complete: function () {
    //                         $progress.hide();
    //                     },
    //                 });
    //             });
    //         }
    //     });
    //
    // });

});

