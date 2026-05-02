<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gradient-to-br from-gray-100 to-gray-200">

<h1 class="text-3xl font-bold mb-6 text-gray-800">🛒 My Cart</h1>

<div id="cart" class="space-y-3"></div>

<button onclick="checkout()"
    class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 mt-6 rounded-lg shadow transition font-semibold">
    Checkout 💳
</button>
<button onclick="goBack()" 
    class="mb-4 bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
    ⬅️ Retour
</button>

<script>
const token = localStorage.getItem('token');

function loadCart() {
    fetch('/api/cart', {
        headers: { Authorization: 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(data => {
        let html = '';
        let total = 0;

        data.forEach(item => {
            total += item.quantity * item.product.price;

            html += `
            <div class="bg-white p-4 rounded-xl shadow flex justify-between items-center">

                <div>
                    <h3 class="font-bold">${item.product.name}</h3>
                    <p>${item.product.price} DH</p>
                </div>

                <div class="flex items-center gap-2">

                    <button onclick="updateQty(${item.id}, ${item.quantity - 1})"
                        class="bg-gray-300 px-2 rounded">-</button>

                    <span>${item.quantity}</span>

                    <button onclick="updateQty(${item.id}, ${item.quantity + 1})"
                        class="bg-gray-300 px-2 rounded">+</button>

                    <button onclick="deleteItem(${item.id})"
                        class="bg-red-500 text-white px-2 rounded">
                        ❌
                    </button>

                </div>

            </div>`;
        });

        html += `<h2 class="mt-6 font-bold text-xl">Total: ${total} DH</h2>`;

        document.getElementById('cart').innerHTML = html;
    });
}

function checkout() {
    if (!token) {
        alert("Login first 🔐");
        return;
    }

    fetch('/api/checkout', {
        method: 'POST',
        headers: { Authorization: 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(data => {
        console.log(data); // 👈 مهم تشوف error
        alert("Order placed 🎉");
        loadCart();
    })
    .catch(err => console.error(err));
    window.location.href = '/admin';
}
function updateQty(id, qty) {

    if (qty < 1) return;

    fetch(`/api/cart/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({ quantity: qty })
    })
    .then(() => loadCart());
}

function deleteItem(id) {
    fetch(`/api/cart/${id}`, {
        method: 'DELETE',
        headers: {
            Authorization: 'Bearer ' + token
        }
    })
    .then(() => loadCart());
}
function goBack() {
    window.history.back()
}
loadCart();
</script>

</body>
</html>