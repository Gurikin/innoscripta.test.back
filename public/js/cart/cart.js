function putProductToCart(url) {
    request("PUT", url)
}

function deleteProductFromCart(url) {
    request("DELETE", url);
}

function updateProductInCartCount(url) {
    $.ajax({
        type: "GET",
        url: url,
        success: function (msg) {
            $("#productInCartCount").text(msg.productInCartCount);
        }
    });
}