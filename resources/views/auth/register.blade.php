<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gradient-to-br from-green-100 to-gray-200">

<div class="bg-white p-8 rounded-2xl shadow-lg w-96 hover:shadow-xl transition">

    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">
        📝 Register
    </h2>

    <input id="name" placeholder="Name"
        class="border p-2 w-full mb-3 rounded focus:outline-none focus:ring-2 focus:ring-green-400">
    <p id="name_error" class="text-red-500 text-sm mb-2"></p>

    <input id="email" placeholder="Email"
        class="border p-2 w-full mb-3 rounded focus:outline-none focus:ring-2 focus:ring-green-400">
    <p id="email_error" class="text-red-500 text-sm mb-2"></p>

    <input id="password" type="password" placeholder="Password"
        class="border p-2 w-full mb-4 rounded focus:outline-none focus:ring-2 focus:ring-green-400">
    <p id="password_error" class="text-red-500 text-sm mb-2"></p>
    
    <p class="text-xs text-gray-500">
        Password must contain:
        8 chars, uppercase, lowercase, number, special char
    </p>

    <button onclick="register()"
        class="bg-green-500 hover:bg-green-600 text-white p-2 w-full rounded transition font-semibold">
        Register
    </button>

    <p class="text-center mt-5 text-gray-600">
        Already have account?
        <a href="/admin/login" class="text-blue-500 hover:underline font-medium">
            Login
        </a>
    </p>

</div>

<script>
function clearErrors() {
    document.getElementById('name_error').innerText = "";
    document.getElementById('email_error').innerText = "";
    document.getElementById('password_error').innerText = "";
}

function register() {
    clearErrors();

    fetch('/api/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        })
    })
    .then(async res => {
        const data = await res.json();

        // ❌ validation errors
        if (!res.ok) {

            if (data.errors) {

                if (data.errors.name) {
                    document.getElementById('name_error').innerText =
                        data.errors.name[0];
                }

                if (data.errors.email) {
                    document.getElementById('email_error').innerText =
                        data.errors.email[0];
                }

                if (data.errors.password) {
                    document.getElementById('password_error').innerText =
                        data.errors.password[0];
                }
            }

            return;
        }

        // ✅ success
        window.location.href = '/admin/login';
    })
    .catch(() => {
        document.getElementById('email_error').innerText =
            "Server error ❌";
    });
}
</script>

</body>
</html>