document.addEventListener("DOMContentLoaded", function () {
    if (document.documentURI.search('cart') === -1) {
        console.log('update cart count');
        let baseUrl = 'http://innoscripta.test/';
        updateProductInCartCount(baseUrl + 'cart')
    }
});

function putProductToCart(productId, requestUrl) {
    $.ajax({
        type: "PUT",
        url: requestUrl + '/' + productId,
        success: function (msg) {
            console.log(msg);
            updateProductInCartCount(requestUrl);
        }
    });
}

function addProductToCart(productId, requestUrl) {
    $.ajax({
        type: "PUT",
        url: requestUrl + '/' + productId,
        success: function (msg) {
            console.log(msg);
            updateProductInCartCount(requestUrl);
            request("GET", requestUrl);
        }
    });
}

function deleteProductFromCart(productId, requestUrl) {
    $.ajax({
        type: "DELETE",
        url: requestUrl + '/' + productId,
        success: function (msg) {
            console.log(msg);
            updateProductInCartCount(requestUrl);
            request("GET", requestUrl);
        }
    });
}

function updateProductInCartCount(requestUrl) {
    $.ajax({
        type: "GET",
        url: requestUrl + '/count',
        headers: {"Access-Control-Allow-Origin": "*"}
    }).done(function (msg) {
        $("#productInCartCount").text(msg.productInCartCount);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
    });
}