document.addEventListener("DOMContentLoaded", function () {
    updateProductInCartCount(baseUrl + 'cart')
});
// document.onload(function () {
//     updateProductInCartCount(baseUrl + 'cart/')
// });

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
        success: function (msg) {
            $("#productInCartCount").text(msg.productInCartCount);
        }
    });
}