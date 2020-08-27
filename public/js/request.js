var $ = require('jquery');

function request(method, requestUrl) {
    $.ajax({
        type: method,
        url: requestUrl,
        success: function (msg) {
            $(".main-container").html(msg);
        }
    });
}