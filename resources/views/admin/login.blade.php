<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gradient-to-br from-blue-100 to-gray-200">

<div class="bg-white p-8 rounded-2xl shadow-lg w-80 hover:shadow-xl transition">

    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">
        🔐 Admin Login
    </h2>

    <input id="email" placeholder="Email"
        class="border p-2 w-full mb-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">

    <input id="password" type="password" placeholder="Password"
        class="border p-2 w-full mb-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">

    <button onclick="login()"
        class="bg-blue-500 hover:bg-blue-600 text-white p-2 w-full rounded transition font-semibold">
        Login
    </button>

</div>

<script>
function login() {
    fetch('/api/login', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({
        email: document.getElementById('email').value,
        password: document.getElementById('password').value
    })
})
.then(async res => {
    const data = await res.json();

    if (!res.ok) {
        alert(data.message || "Login failed ❌");
        return;
    }

    localStorage.setItem('token', data.token);
    if (data.user.role === 'admin') {
    window.location.href = '/admin';
    } else {
    window.location.href = '/';
    }
    });
}
</script>

</body>
</html>