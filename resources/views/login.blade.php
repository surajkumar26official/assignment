<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<input type="email" id="email" placeholder="Email"><br><br>
<input type="password" id="password" placeholder="Password"><br><br>

<button onclick="login()">Login</button>

<script>
function login() {
    fetch('/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.token) {
            localStorage.setItem('token', data.token);
            window.location.href = '/dashboard';
        } else {
            alert('Login failed');
        }
    });
}
</script>

</body>
</html>