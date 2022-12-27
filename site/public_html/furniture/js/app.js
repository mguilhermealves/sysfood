//responsive menu slicknav
$(function () {
    "use strict";
    $('.counter-up').counterUp({
        delay: 10,
        time: 3000
    });
    $('.counter-up-fast').counterUp({
        delay: 5,
        time: 1000
    });
    //circular progress animation
    $('.circlestat').circliful();
});
$(function () {
    "use strict";
    $('.slicknav').slicknav({
        label: "Planejar"
    });
    /*
     * INITIALIZE BUTTON TOGGLE
     * ------------------------
     * always use this code for toggle and close button effect
     */
    $(".side-bar").accordionze({
        accordionze: true,
        speed: 300,
        closedSign: '<b class="fa fa-circle"></b>',
        openedSign: '<b class="fa fa-circle"></b>'
    });
    $(".slim-scroll").slimscroll({
        height: "180px",
        alwaysVisible: false,
        size: "3px"
    });
    $(".sidebar-fixed").slimscroll({
        height: "460px",
        width: "260px",
        position: 'left',
        alwaysVisible: true,
        allowPageScroll: true,
        distance: '-1px',
        size: "4px"
    });
});
/*     
 * Add collapse and remove events to boxes
 */
(function ($) {
    "use strict";
    $("[data-widget='collapse']").click(function () {
        //Find the box parent        
        var box = $(this).parents(".box").first();
        //Find the body and the footer
        var bf = box.find(".box-body, .box-footer");
        if (!box.hasClass("collapsed-box")) {
            box.addClass("collapsed-box");
            bf.slideUp();
        } else {
            box.removeClass("collapsed-box");
            bf.slideDown();
        }
    });
})(jQuery);
//Find the box parent
(function ($) {
    "use strict";
    $("[data-widget='remove']").click(function () {
        var box = $(this).parents(".box").first();
        box.slideUp();
    });
})(jQuery);

//File Upload
function ekUpload() {
    function Init() {

        console.log("Upload Initialised");

        var fileSelect = document.getElementById('file-upload'),
            fileDrag = document.getElementById('file-drag'),
            submitButton = document.getElementById('submit-button');

        fileSelect.addEventListener('change', fileSelectHandler, false);

        // Is XHR2 available?
        var xhr = new XMLHttpRequest();
        if (xhr.upload) {
            // File Drop
            fileDrag.addEventListener('dragover', fileDragHover, false);
            fileDrag.addEventListener('dragleave', fileDragHover, false);
            fileDrag.addEventListener('drop', fileSelectHandler, false);
        }
    }

    function fileDragHover(e) {
        var fileDrag = document.getElementById('file-drag');

        e.stopPropagation();
        e.preventDefault();

        fileDrag.className = (e.type === 'dragover' ? 'hover' : 'modal-body file-upload');
    }

    function fileSelectHandler(e) {
        // Fetch FileList object
        var files = e.target.files || e.dataTransfer.files;

        // Cancel event and hover styling
        fileDragHover(e);

        // Process all File objects
        for (var i = 0, f; f = files[i]; i++) {
            parseFile(f);
            uploadFile(f);
        }
    }

    // Output
    function output() {
        // Response
        var msg = '<div id="messages" class="alert alert-success" role="alert">';
        msg += '<div class="row">';
        msg += '<div class="col-md-1"> <svg class="mx-1" style="float:left margin-top -10px; padding-top 25px !important;" width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M42 21C42 26.5695 39.7875 31.911 35.8492 35.8492C31.911 39.7875 26.5695 42 21 42C15.4305 42 10.089 39.7875 6.15076 35.8492C2.21249 31.911 0 26.5695 0 21C0 15.4305 2.21249 10.089 6.15076 6.15076C10.089 2.21249 15.4305 0 21 0C26.5695 0 31.911 2.21249 35.8492 6.15076C39.7875 10.089 42 15.4305 42 21ZM31.5787 13.0462C31.3912 12.8594 31.168 12.7123 30.9223 12.6137C30.6767 12.5151 30.4136 12.4671 30.149 12.4725C29.8843 12.4778 29.6235 12.5366 29.382 12.6451C29.1406 12.7536 28.9235 12.9097 28.7437 13.104L19.6271 24.7196L14.133 19.2229C13.7598 18.8751 13.2662 18.6858 12.7561 18.6948C12.2461 18.7038 11.7595 18.9104 11.3987 19.2711C11.038 19.6318 10.8314 20.1185 10.8224 20.6285C10.8134 21.1385 11.0027 21.6322 11.3505 22.0054L18.2962 28.9537C18.4834 29.1405 18.7062 29.2877 18.9514 29.3865C19.1966 29.4853 19.4592 29.5337 19.7236 29.5288C19.9879 29.5239 20.2486 29.4658 20.49 29.358C20.7313 29.2502 20.9486 29.0948 21.1286 28.9013L31.6076 15.8025C31.9649 15.4311 32.1622 14.9343 32.1573 14.419C32.1524 13.9037 31.9456 13.4108 31.5814 13.0462H31.5787Z" fill="#198754"/> </svg> </div>';
        msg += '<div class="col-md-11"> <strong>Imagem anexada com sucesso! <br> Preencha as informações abaixo:</strong> </div>';
        msg += '</div>';
        msg += '</div>';
        var m = $('#messages').removeClass('d-none').html(msg);
        m.innerHTML = msg;
    }

    function parseFile(file) {

        console.log(file.name);
        output(
            '<strong>' + encodeURI(file.name) + '</strong>'
        );

        // var fileType = file.type;
        // console.log(fileType);
        var imageName = file.name;

        var isGood = (/\.(?=gif|jpg|png|jpeg)/gi).test(imageName);
        if (isGood) {
            document.getElementById('start').classList.add("hidden");
            document.getElementById('response').classList.remove("hidden");
            document.getElementById('notimage').classList.add("hidden");
            // Thumbnail Preview
            document.getElementById('file-image').classList.remove("hidden");
            document.getElementById('file-image').src = URL.createObjectURL(file);
        } else {
            document.getElementById('file-image').classList.add("hidden");
            document.getElementById('notimage').classList.remove("hidden");
            document.getElementById('start').classList.remove("hidden");
            document.getElementById('response').classList.add("hidden");
            document.getElementById("file-upload-form").reset();
        }
    }

    function setProgressMaxValue(e) {
        var pBar = document.getElementById('file-progress');

        if (e.lengthComputable) {
            pBar.max = e.total;
        }
    }

    function updateFileProgress(e) {
        var pBar = document.getElementById('file-progress');

        if (e.lengthComputable) {
            pBar.value = e.loaded;
        }
    }

    function uploadFile(file) {

        var xhr = new XMLHttpRequest(),
            fileInput = document.getElementById('class-roster-file'),
            pBar = document.getElementById('file-progress'),
            fileSizeLimit = 1024; // In MB
        if (xhr.upload) {
            // Check if file is less than x MB
            if (file.size <= fileSizeLimit * 1024 * 1024) {
                // Progress bar
                pBar.style.display = 'inline';
                xhr.upload.addEventListener('loadstart', setProgressMaxValue, false);
                xhr.upload.addEventListener('progress', updateFileProgress, false);

                // File received / failed
                xhr.onreadystatechange = function (e) {
                    if (xhr.readyState == 4) {
                        // Everything is good!

                        // progress.className = (xhr.status == 200 ? "success" : "failure");
                        // document.location.reload(true);
                    }
                };

                // Start upload
                //   xhr.open('POST', document.getElementById('file-upload-form').action, true);
                //   xhr.setRequestHeader('X-File-Name', file.name);
                //   xhr.setRequestHeader('X-File-Size', file.size);
                //   xhr.setRequestHeader('Content-Type', 'multipart/form-data');
                //   xhr.send(file);
            } else {
                output('Please upload a smaller file (< ' + fileSizeLimit + ' MB).');
            }
        }
    }

    // Check for the various File API support.
    if (window.File && window.FileList && window.FileReader) {
        Init();
    } else {
        document.getElementById('file-drag').style.display = 'none';
    }
}
ekUpload();