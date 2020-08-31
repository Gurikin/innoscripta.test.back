// var $ = require('jquery');

function request(method, requestUrl) {
    $.ajax({
        type: method,
        url: requestUrl,
        headers: {"Access-Control-Allow-Origin": "*"}
    }).done(function (msg) {
        $(".main-container").html(msg);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
    });
}