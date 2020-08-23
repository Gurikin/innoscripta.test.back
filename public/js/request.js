function request(method, url) {
    $.ajax({
        type: method,
        url: url,
        success: function (msg) {
            console.log(msg);
        }
    });
}