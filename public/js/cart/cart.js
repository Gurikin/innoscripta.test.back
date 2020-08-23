function putProductToCart(url) {
    request("PUT", url)
}

function deleteProductFromCart(url) {
    request("DELETE", url);
}