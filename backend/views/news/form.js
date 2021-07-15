var file;
var fileName, filePath;

$(document).ready(function () {
    //选择文件
    $(document).on('change', '#pdf', function () {
        file = this.files[0];
        var form = new FormData();
        form.append("file", file);
        $.ajax({
            method: 'POST',
            url: "upload-files",
            data: form,
            dataType: "json",
            cache: true,
            contentType: false,
            processData: false,
            success: function (response) {
                fileName = response.data.filename;
                filePath = response.data.filepath;
                $('#news-title').val(fileName);
                $('#summernote').summernote('insertText', ("file:" + filePath));
                $('#news-isshow').click();
                $('form').submit();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    });


});