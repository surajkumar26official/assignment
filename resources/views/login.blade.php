<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 1.5rem;
            background: radial-gradient(circle at top, rgba(56, 189, 248, 0.12), transparent 34%), #f8fafc;
        }

        .panel {
            width: min(100%, 420px);
            background: #ffffff;
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 28px;
            box-shadow: 0 28px 80px rgba(15, 23, 42, 0.08);
            padding: 2rem;
        }

        h1 {
            margin: 0 0 0.75rem;
            font-size: 2rem;
            line-height: 1.1;
        }

        p.subtitle {
            margin: 0 0 1.75rem;
            color: #475569;
            line-height: 1.7;
        }

        .field {
            display: grid;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .field label {
            font-size: 0.95rem;
            color: #334155;
            font-weight: 600;
        }

        .field input {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 16px;
            background: #f8fafc;
            padding: 0.95rem 1rem;
            font-size: 0.98rem;
            color: #0f172a;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field input:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.14);
        }

        .button {
            width: 100%;
            border: none;
            border-radius: 16px;
            background: #0ea5e9;
            color: white;
            padding: 0.95rem 1rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .button:hover {
            background: #0284c7;
        }

        .button:active {
            transform: scale(0.99);
        }

        .note {
            margin-top: 1.25rem;
            text-align: center;
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="panel">
        <h1>Welcome back</h1>
        <p class="subtitle">Log in to manage short URLs and invite team members from your dashboard.</p>

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" placeholder="you@example.com">
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" placeholder="Enter your password">
        </div>

        <button class="button" onclick="login()">Login</button>

        <p class="note">If login fails, verify your credentials or contact support.</p>
    </div>

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
