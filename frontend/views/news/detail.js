// If absolute URL from the remote server is provided, configure the CORS
// header on that server.
$("#frameId").load(function () {
    getPdf();
});

function getPdf() {
    var content = $("#frameId").contents().find('p:first').text();
    if (content.indexOf("file:", 0) != -1) {
        var url = content.split("..")[1];

        $('.contents').empty();

        // Disable workers to avoid yet another cross-origin issue (workers need
        // the URL of the script to be loaded, and dynamically loading a cross-origin
        // script does not work).
        // PDFJS.disableWorker = true;

        // The workerSrc property shall be specified.
        PDFJS.workerSrc = '/scripts/lib/pdf.worker.js';

        // Asynchronous download of PDF
        var loadingTask = PDFJS.getDocument(url);

        loadingTask.promise.then(function (pdf) {

            // Fetch the first page
            for (var pageNumber = 1; pageNumber <= pdf.numPages; ++pageNumber) {
                pdf.getPage(pageNumber).then(function (page) {

                    var scale = 1.7;
                    var viewport = page.getViewport(scale);

                    // Prepare canvas using PDF page dimensions
                    var canvas = document.createElement('canvas');
                    var context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    // Render PDF page into canvas context
                    var renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    page.render(renderContext);
                    $('.contents').append(canvas);
                });


            }
        }, function (reason) {
            // PDF loading error
        });
    }
}