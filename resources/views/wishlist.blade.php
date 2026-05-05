<!DOCTYPE html>
<html>
<head>
    <title>Wishlist</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 p-6">

<h1 class="text-3xl font-bold mb-6 text-gray-800">❤️ My Wishlist</h1>

<div id="wishlist" class="grid grid-cols-3 gap-6"></div>
<button onclick="goBack()" 
    class="mb-4 bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
    ⬅️ Retour
</button>

<script>
const token = localStorage.getItem('token');

// 📦 Load wishlist
function loadWishlist() {
    fetch('/api/wishlist', {
        headers: { Authorization: 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(data => {

        let html = '';

        if (!data.length) {
            html = "❌ No items in wishlist";
        }

        data.forEach(item => {

            let imageUrl = item.product.image 
                ? `${window.location.origin}/storage/${item.product.image}`
                : 'https://via.placeholder.com/150';

            html += `
            <div class="bg-white p-4 rounded-xl shadow hover:shadow-xl transition">

                <img src="${imageUrl}" class="h-32 w-full object-cover rounded mb-3"/>

                <h3 class="font-bold text-gray-800">${item.product.name}</h3>
                <p class="text-gray-500">${item.product.price} DH</p>

                <div class="flex justify-between mt-3">

                    <button onclick="addToCart(${item.product.id})"
                        class="bg-blue-500 text-white px-3 py-1 rounded-lg">
                        🛒 Add
                    </button>

                    <button onclick="deleteItem(${item.id})"
                        class="bg-red-500 text-white px-3 py-1 rounded-lg">
                        ❌ Remove
                    </button>

                </div>
            </div>`;
        });

        document.getElementById('wishlist').innerHTML = html;
    });
}

// ❌ remove
function deleteItem(id) {
    fetch(`/api/wishlist/${id}`, {
        method: 'DELETE',
        headers: { Authorization: 'Bearer ' + token }
    })
    .then(() => loadWishlist());
}

// 🛒 add to cart
function addToCart(id) {
    fetch('/api/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({ product_id: id })
    })
    .then(() => alert("Added to cart 🛒"));
}
function goBack() {
    window.history.back()
}
// 🚀 start
loadWishlist();
</script>

</body>
</html>
