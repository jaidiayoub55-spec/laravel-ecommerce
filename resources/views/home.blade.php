<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200">

<!-- NAVBAR -->
<nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
    <h1 class="font-bold text-xl text-gray-800">🛒 MyShop</h1>

    <div id="nav-links" class="flex items-center gap-4">
        <!-- dynamic -->
    </div>
</nav>

<!-- SEARCH -->
<div class="p-6">
    <input id="search"
        placeholder="🔍 Search products..."
        class="border p-3 w-full rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
        onkeyup="loadProducts()">
</div>

<!-- HERO -->
<div class="text-center mt-16 mb-10">
    <h2 class="text-4xl font-bold mb-4 text-gray-800">
        Welcome to MyShop 🛍️
    </h2>

    <p class="text-gray-600 mb-6">
        Buy the best products بسهولة
    </p>

    <a href="/register"
        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg shadow transition">
        Get Started
    </a>
</div>

<!-- PRODUCTS -->
<div class="px-6 pb-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">📦 Products</h2>

    <div id="products" class="grid grid-cols-3 gap-6"></div>
</div>

<script>
    const token = localStorage.getItem('token');
    const nav = document.getElementById('nav-links');

    if (token) {
        nav.innerHTML = `
            <a href="/cart" class="mr-4 text-blue-500">🛒 Cart</a>
            <a href="/wishlist" class="mr-4 text-pink-500">❤️ Wishlist</a>
            <a href="/admin" class="mr-4 text-green-500">Dashboard</a>
            <button onclick="logout()" class="text-red-500">Logout</button>
        `;
    } else {
        nav.innerHTML = `
            <a href="/admin/login" class="mr-4 text-blue-500">Login</a>
            <a href="/register" class="bg-green-500 text-white px-3 py-1 rounded">
                Register
            </a>
        `;
    }

// 🔓 Logout
function logout() {
    fetch('/api/logout', {
        method: 'POST',
        headers: {
            Authorization: 'Bearer ' + token
        }
    }).then(() => {
        localStorage.removeItem('token');
        location.reload();
    });
}

// 📦 Load Products (FIXED)
function loadProducts() {

    let search = document.getElementById('search').value;
    const token = localStorage.getItem('token');

    fetch(`/api/products?search=${search}`, {
        headers: token ? {
            'Authorization': 'Bearer ' + token
        } : {}
    })
    .then(res => {
        if (!res.ok) {
            throw new Error("Failed to fetch ❌");
        }
        return res.json();
    })
    .then(data => {

        let products = data.data || data;
        let html = '';

        if (!products || products.length === 0) {
            html = "❌ No products found";
        } else {

            products.forEach(p => {

                let imageUrl = p.image 
                    ? `http://127.0.0.1:8000/storage/${p.image}`
                    : 'https://via.placeholder.com/150';

                function stars(count) {
                    let s = '';
                    for (let i = 0; i < 5; i++) {
                        s += i < count ? '⭐' : '☆';
                    }
                    return s;
                }

                html += `
                <div class="bg-white p-4 rounded-xl shadow hover:shadow-xl transition transform hover:-translate-y-1">
                    <img src="${imageUrl}" class="h-32 w-full object-cover mb-3 rounded-lg"/>

                    <h3 class="font-bold text-gray-800">${p.name}</h3>
                    <p class="text-gray-500">${p.price} DH</p>

                    <p>${stars(p.reviews?.length ?? 0)}</p>

                    <div class="mt-2 flex gap-2">
                        <button onclick="addToCart(${p.id})"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg transition">
                            🛒
                        </button>

                        <button onclick="addToWishlist(${p.id})"
                            class="bg-pink-500 hover:bg-pink-600 text-white px-3 py-1 rounded-lg transition">
                            ❤️
                        </button>
                    </div>
                </div>
                `;
            });
        }

        document.getElementById('products').innerHTML = html;
    })
    .catch(err => console.error(err));
}

// 🛒 Add to cart (FIXED)
function addToCart(id) {
    fetch('/api/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        },
        body: JSON.stringify({ product_id: id })
    })
    .then(res => res.json())
    .then(() => {
        const msg = document.createElement('div');
        msg.innerText = "Added to cart 🛒";
        msg.className = "fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded";
        document.body.appendChild(msg);

        setTimeout(() => msg.remove(), 2000);
    })
    .catch(err => console.error(err));
}

// ❤️ Wishlist
function addToWishlist(id) {
    fetch('/api/wishlist', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        },
        body: JSON.stringify({ product_id: id })
    })
    .then(() => {
        const msg = document.createElement('div');
        msg.innerText = "Added to wishlist ❤️";
        msg.className = "fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded";
        document.body.appendChild(msg);

        setTimeout(() => msg.remove(), 2000);
    });
}

// 🚀 start
document.addEventListener("DOMContentLoaded", function() {
    loadProducts();
});
</script>

</body>
</html>