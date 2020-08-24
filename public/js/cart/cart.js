let baseUrl = 'http://innoscripta.test/cart/';
document.addEventListener("DOMContentLoaded", updateProductInCartCount);

function putProductToCart(productId) {
    $.ajax({
        type: "PUT",
        url: baseUrl + productId,
        success: function (msg) {
            console.log(msg);
            updateProductInCartCount();
        }
    });
}

function deleteProductFromCart(productId) {
    $.ajax({
        type: "DELETE",
        url: baseUrl + productId,
        success: function (msg) {
            console.log(msg);
            updateProductInCartCount();
        }
    });
}

function updateProductInCartCount() {
    $.ajax({
        type: "GET",
        url: baseUrl + 'count',
        success: function (msg) {
            $("#productInCartCount").text(msg.productInCartCount);
        }
    });
}