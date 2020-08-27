let baseUrl = 'http://innoscripta.test/';

function request(method, requestUrl) {
    $.ajax({
        type: method,
        url: requestUrl,
        success: function (msg) {
            $(".main-container").html(msg);
        }
    });
}