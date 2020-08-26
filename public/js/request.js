let baseUrl = 'http://localhost/';

function request(method, requestUrl) {
    $.ajax({
        type: method,
        url: requestUrl,
        success: function (msg) {
            $(".main-container").html(msg);
        }
    });
}