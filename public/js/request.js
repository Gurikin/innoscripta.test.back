let baseUrl = 'http://innoscripta.test/';
if (document.documentURI === baseUrl || document.documentURI === (baseUrl + '#')) {
    document.addEventListener("DOMContentLoaded", request("GET", baseUrl + 'getPizzas'));
}

function request(method, requestUrl) {
    $.ajax({
        type: method,
        url: requestUrl,
        success: function (msg) {
            $(".main-container").html(msg);
        }
    });
}