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
        label: "Santher"
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


(function ($) {
    $.ajax({
        type: "GET",
        url: '/usuarios.json'
        , data: {}
        , success: function (data) {
            $.each(data.total, function (i, o) {
                $("#" + i + "SpanUser").html(o)
            })
        }
    })
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
    function output(msg) {
        // Response
        var m = document.getElementById('messages');
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
        }
        else {
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