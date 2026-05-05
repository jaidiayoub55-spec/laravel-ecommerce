<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 p-6">

<h1 class="text-3xl font-bold mb-6 text-gray-800">👑 Admin Dashboard</h1>

<!-- STATS -->
<div class="grid grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition text-center">
        <h2 class="text-gray-500">Products</h2>
        <p id="productsCount" class="text-3xl font-bold text-blue-500"></p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition text-center">
        <h2 class="text-gray-500">Orders</h2>
        <p id="ordersCount" class="text-3xl font-bold text-green-500"></p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition text-center">
        <h2 class="text-gray-500">Revenue</h2>
        <p id="revenue" class="text-3xl font-bold text-purple-500"></p>
    </div>
</div>

<!-- ADD PRODUCT -->
<div class="bg-white p-6 rounded-xl shadow mb-8">
    <h2 class="text-xl mb-4 font-semibold">➕ Add Product</h2>

    <form id="productForm" class="grid grid-cols-2 gap-4">
        <input name="name" placeholder="Name" class="border p-2 rounded focus:ring-2 focus:ring-blue-400">
        <input name="price" type="number" placeholder="Price" class="border p-2 rounded focus:ring-2 focus:ring-blue-400">
        <input name="stock" type="number" placeholder="Stock" class="border p-2 rounded focus:ring-2 focus:ring-blue-400">

        <select name="category_id" id="category" class="border p-2 rounded"></select>

        <input name="description" placeholder="Description" class="border p-2 rounded col-span-2 focus:ring-2 focus:ring-blue-400">
        <input type="file" name="image" class="border p-2 rounded col-span-2">

        <button class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded col-span-2 transition">
            Add Product
        </button>
    </form>
</div>

<!-- ADD CATEGORY -->
<div class="bg-white p-6 rounded-xl shadow w-96 mb-8">
    <h2 class="text-xl mb-3 font-semibold">📂 Add Category</h2>

    <input id="category_name" placeholder="Category name"
        class="border p-2 w-full mb-3 rounded focus:ring-2 focus:ring-blue-400">

    <button onclick="addCategory()"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 w-full rounded transition">
        Add Category
    </button>
</div>

<!-- CATEGORIES -->
<div class="bg-white p-6 rounded-xl shadow mb-8">
    <h2 class="text-xl mb-3 font-semibold">📋 Categories</h2>
    <div id="categories" class="space-y-2"></div>
</div>

<!-- PRODUCTS -->
<div class="bg-white p-6 rounded-xl shadow mb-8">
    <h2 class="text-xl mb-4 font-semibold">📦 Products</h2>
    <div id="products" class="grid grid-cols-3 gap-6"></div>
</div>

<!-- ORDERS -->
<div class="bg-white p-6 rounded-xl shadow">
    <h2 class="text-xl mb-4 font-semibold">🧾 Orders</h2>
    <div id="orders" class="space-y-3"></div>
</div>
<button onclick="goBack()" 
    class="mb-4 bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
    ⬅️ Retour
</button>

<script>
const token = localStorage.getItem('token');

// 📥 Load Categories
function loadCategories() {
    fetch('/api/categories', {
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(data => {
        let categories = data.data || data;

        let options = '';
        let list = '';

        categories.forEach(c => {
            options += `<option value="${c.id}">${c.name}</option>`;
            list += `<div class="bg-gray-100 p-2 mb-2 rounded">${c.name}</div>`;
        });

        document.getElementById('category').innerHTML = options;
        document.getElementById('categories').innerHTML = list;
    });
}

// ➕ Add Category
function addCategory() {
    fetch('/api/categories', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({
            name: document.getElementById('category_name').value
        })
    })
    .then(() => {
        alert("Category added ✅");
        loadCategories();
    });
}

// ➕ Add Product
document.getElementById('productForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('/api/products', {
        method: 'POST',
        headers: { 'Authorization': 'Bearer ' + token },
        body: formData
    })
    .then(res => res.json())
    .then(() => {
        alert("Product added ✅");
        this.reset();
        loadProducts();
    });
});

// 📦 Load Products
function loadProducts() {
    fetch('/api/products', {
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(data => {

        let products = data.data || data;
        let html = '';

        products.forEach(p => {
            let imageUrl = p.image 
                ? `${window.location.origin}/storage/${p.image}`
                : 'https://via.placeholder.com/150';

            html += `
            <div class="bg-gray-50 p-3 rounded-xl shadow hover:shadow-lg transition">
                <img src="${imageUrl}" class="h-24 w-full object-cover rounded mb-2"/>
                <h3 class="font-bold">${p.name}</h3>
                <p>${p.price} DH</p>
                <p>${p.stock}</p>
                <p>${p.description}</p>
                <button onclick="deleteProduct(${p.id})"
                    class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 mt-2 rounded transition">
                    Delete
                </button><button onclick="editProduct(${p.id}, '${p.name}', ${p.price})"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 mt-2 rounded transition">
                    Edit
                </button>
            </div>`;
        });

        document.getElementById('products').innerHTML = html;
        document.getElementById('productsCount').innerText = products.length;
    });
}
function editProduct(id) {
    window.location.href = `/edit-product/${id}`;
}

// ❌ Delete Product
function deleteProduct(id) {
    fetch(`/api/products/${id}`, {
        method: 'DELETE',
        headers: { Authorization: 'Bearer ' + token }
    })
    .then(() => loadProducts());
}

// 🧾 Load Orders + Revenue
function loadOrders() {
    fetch('/api/orders', {
        headers: { Authorization: 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(data => {

        let revenue = 0;
        let html = '';

        data.forEach(o => {
    revenue += Number(o.total);

    html += `
    <div class="bg-white p-4 rounded-xl shadow mb-3">

        <div class="flex justify-between items-center">
            <div>
                <h3 class="font-bold">Order #${o.id}</h3>
                <p>Total: ${o.total} DH</p>
            </div>

            <!-- 🔥 STATUS SELECT -->
            <select onchange="changeStatus(${o.id}, this.value)"
                class="border p-1 rounded">

                <option value="pending" ${o.status === 'pending' ? 'selected' : ''}>Pending</option>
                <option value="paid" ${o.status === 'paid' ? 'selected' : ''}>Paid</option>
                <option value="shipped" ${o.status === 'shipped' ? 'selected' : ''}>Shipped</option>

            </select>
        </div>

        <div class="mt-2">
            ${o.items.map(i => `
                <p class="text-sm text-gray-600">
                    - ${i.product.name} x ${i.quantity}
                </p>
            `).join('')}
        </div>

        <button onclick="deleteOrder(${o.id})"
            class="bg-red-500 text-white px-2 py-1 mt-2 rounded">
            Delete
        </button>

    </div>`;
});
        console.log("ORDERS:", data);
        document.getElementById('orders').innerHTML = html;
        document.getElementById('ordersCount').innerText = data.length;
        document.getElementById('revenue').innerText = revenue + " DH";
    });
}
function deleteOrder(id) {
    fetch(`/api/orders/${id}`, {
        method: 'DELETE',
        headers: {
            Authorization: 'Bearer ' + token
        }
    })
    .then(() => {
        alert("Order deleted ❌");
        loadOrders();
    });
}

// 🚀 START
document.addEventListener("DOMContentLoaded", function() {
    loadCategories();
    loadProducts();
    loadOrders();
});
function changeStatus(id, status) {
    fetch(`/api/orders/${id}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({ status })
    })
    .then(() => {
        alert("Status updated ✅");
        loadOrders();
    });
}
function goBack() {
    window.history.back()
}
</script>

</body>
</html>
