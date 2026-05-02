<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center">

<div class="bg-white shadow-xl rounded-2xl p-6 w-full max-w-md">

    <h1 class="text-2xl font-bold text-center mb-6">✏️ Edit Product</h1>

    <form id="editForm" class="space-y-4">

        <div>
            <label class="text-sm text-gray-500">Name</label>
            <input id="name" placeholder="Name" class="w-full border p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label class="text-sm text-gray-500">Price (DH)</label>
            <input id="price" placeholder="Price" type="number" class="w-full border p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label class="text-sm text-gray-500">Stock</label>
            <input id="stock" placeholder="Stock" type="number" class="w-full border p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label class="text-sm text-gray-500">Description</label>
            <textarea id="description" placeholder="Description" class="w-full border p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
        </div>

        <div class="flex justify-between items-center mt-4">

            <button onclick="updateProduct(productId) class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
                💾 Save
            </button>
        </div>

    </form>

</div>

<script>
const token = localStorage.getItem('token');
const id = {{ $id }};

// 📥 Load product
fetch(`/api/products/${id}`, {
    headers: {
        'Authorization': 'Bearer ' + token
    }
})
.then(res => res.json())
.then(p => {
    document.getElementById('name').value = p.name;
    document.getElementById('price').value = p.price;
    document.getElementById('stock').value = p.stock;
    document.getElementById('description').value = p.description;
});

// ✏️ Update
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();

    fetch(`/api/products/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({
            name: document.getElementById('name').value,
            price: document.getElementById('price').value,
            stock: document.getElementById('stock').value,
            description: document.getElementById('description').value
        })
    })
    .then(res => res.json())
    .then(() => {
        const msg = document.createElement('div');
            msg.innerText = "✅ Updated successfully";
            msg.className = "fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded";
            document.body.appendChild(msg);

            setTimeout(() => msg.remove(), 2000);
        window.location.href = "/admin";
    });
});
const productId = window.location.pathname.split('/').pop();
function updateProduct(id) {
    let formData = new FormData();

    formData.append('name', document.getElementById('name').value);
    formData.append('price', document.getElementById('price').value);
    formData.append('stock', document.getElementById('stock').value);
    formData.append('description', document.getElementById('description').value);
    formData.append('_method', 'PUT'); // مهم

    fetch(`/api/products/${id}`, {
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        },
        body: formData
    })
    .then(res => res.json())
    .then(() => {
        const msg = document.createElement('div');
            msg.innerText = "Updated ✅";
            msg.className = "fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded";
            document.body.appendChild(msg);

            setTimeout(() => msg.remove(), 2000);
        window.location.href = '/admin';
    });
}
</script>

</body>
</html>