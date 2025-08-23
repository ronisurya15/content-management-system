document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", async () => {
            let id = button.dataset.id;
            let name = button.dataset.name;
            let path = button.dataset.path;
            let price = button.dataset.price;
            let discount = button.dataset.discount;

            const response = await fetch(window.cartStoreUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": window.csrfToken
                },
                body: JSON.stringify({ id, name, path, price, discount })
            });

            const data = await response.json();

            if (data.status) {
                document.getElementById("cart-count").textContent = data.cart_count;
                document.getElementById("cart-count-mobile").textContent = data.cart_count;
                
                flyToCart(button.dataset.path, button);
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", async () => {
    loadCartCount()
});

async function loadCartCount () {
    const response = await fetch(window.cartCountUrl);
    const data = await response.json();

    document.getElementById("cart-count").textContent = data.count;
    document.getElementById("cart-count-mobile").textContent = data.count;
}

function flyToCart(imgUrl, button) {
    const cartIcon = document.getElementById("cart-icon-mobile")?.offsetParent !== null 
        ? document.getElementById("cart-icon-mobile") 
        : document.getElementById("cart-icon");

    const img = document.createElement("img");
    img.src = imgUrl;
    img.style.position = "fixed";
    img.style.width = "50px";
    img.style.height = "50px";
    img.style.borderRadius = "8px";
    img.style.zIndex = "9999";
    img.style.pointerEvents = "none";

    // posisi awal (button)
    const rect = button.getBoundingClientRect();
    img.style.left = rect.left + "px";
    img.style.top = rect.top + "px";

    document.body.appendChild(img);

    // posisi tujuan (cart yang aktif)
    const cartRect = cartIcon.getBoundingClientRect();
    const translateX = cartRect.left - rect.left;
    const translateY = cartRect.top - rect.top;

    // animasi
    img.animate([
        { transform: `translate(0, 0) scale(1)`, opacity: 1 },
        { transform: `translate(${translateX}px, ${translateY}px) scale(0.1)`, opacity: 0.5 }
    ], {
        duration: 800,
        easing: "ease-in-out"
    }).onfinish = () => img.remove();
}
