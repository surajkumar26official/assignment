<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

        html,
        body {
            margin: 0;
            min-height: 100%;
            background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
        }

        body {
            padding: 1rem;
        }

        .container {
            max-width: 1120px;
            margin: 0 auto;
            display: grid;
            gap: 1.5rem;
        }

        .hero {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            padding: 1.75rem;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(148, 163, 184, 0.24);
            box-shadow: 0 28px 80px rgba(15, 23, 42, 0.08);
        }

        .hero-title {
            margin: 0;
            font-size: clamp(2rem, 2.5vw, 2.75rem);
            line-height: 1.05;
        }

        .hero-meta {
            margin: 0;
            color: #475569;
            line-height: 1.75;
        }

        .hero-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: center;
            justify-content: space-between;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            border-radius: 999px;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .button,
        .button-secondary {
            border: none;
            border-radius: 16px;
            padding: 0.95rem 1.15rem;
            font-size: 0.97rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
        }

        .button {
            background: #0f172a;
            color: #ffffff;
        }

        .button:hover {
            transform: translateY(-1px);
            background: #111827;
        }

        .button-secondary {
            background: #f8fafc;
            color: #0f172a;
            border: 1px solid rgba(148, 163, 184, 0.35);
        }

        .button-secondary:hover {
            background: #e2e8f0;
        }

        .grid-columns {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: 1fr;
        }

        .panel {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(148, 163, 184, 0.22);
            border-radius: 28px;
            padding: 1.75rem;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.06);
        }

        .panel h2 {
            margin: 0 0 0.65rem;
            font-size: 1.35rem;
            color: #0f172a;
        }

        .panel p {
            margin: 0;
            color: #475569;
            line-height: 1.75;
        }

        .field-group {
            display: grid;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .field {
            display: grid;
            gap: 0.45rem;
        }

        .field label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #334155;
        }

        .field input,
        .field select {
            width: 100%;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            border-radius: 16px;
            padding: 0.95rem 1rem;
            font-size: 0.98rem;
            color: #0f172a;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field input:focus,
        .field select:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.14);
        }

        .feedback {
            min-height: 1.5rem;
            margin-top: 1rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: #334155;
        }

        .list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 1rem;
        }

        .list-item {
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 20px;
            padding: 1rem 1.15rem;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .list-item strong {
            color: #0f172a;
            word-break: break-all;
        }

        .link-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 0.85rem;
            border-radius: 999px;
            background: #0f172a;
            color: white;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 700;
        }

        @media (min-width: 900px) {
            .grid-columns {
                grid-template-columns: 1.25fr 0.85fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <section class="hero">
            <div class="hero-row">
                <div>
                    <p class="hero-badge">Dashboard</p>
                    <h1 class="hero-title">Manage your links and team invites</h1>
                </div>
                <button class="button" onclick="logout()">Log out</button>
            </div>
            <p id="welcomeMessage" class="hero-meta">Loading user...</p>
            <p id="companyBlock" class="hero-meta"></p>
        </section>

        <div class="grid-columns">
            <div class="space-y-6">
                <section class="panel">
                    <h2>Invite a user</h2>
                    <p>Send a new invite to someone on your team. Admins can keep the company field locked.</p>
                    <div class="field-group">
                        <div class="field">
                            <label for="invite_name">Name</label>
                            <input id="invite_name" type="text" placeholder="Full name">
                        </div>
                        <div class="field">
                            <label for="invite_email">Email</label>
                            <input id="invite_email" type="email" placeholder="user@example.com">
                        </div>
                        <div class="field">
                            <label for="invite_password">Password</label>
                            <input id="invite_password" type="password" placeholder="Choose a password">
                        </div>
                        <div class="field">
                            <label for="invite_company">Company</label>
                            <input id="invite_company" type="text" placeholder="Company name (optional)">
                        </div>
                        <div class="field">
                            <label for="invite_role">Role</label>
                            <select id="invite_role">
                                <option value="Member">Member</option>
                                <option value="Admin">Admin</option>
                                <option value="Sales">Sales</option>
                                <option value="Manager">Manager</option>
                                <option value="Engineer">Engineer</option>
                            </select>
                        </div>
                    </div>
                    <button class="button-secondary" onclick="inviteUser()">Send invite</button>
                    <div id="inviteMessage" class="feedback"></div>
                </section>

                <section class="panel">
                    <h2>Create short URL</h2>
                    <p>Paste a long URL below to generate a short link your team can share.</p>
                    <div class="field-group">
                        <div class="field">
                            <label for="original_url">Original URL</label>
                            <input id="original_url" type="text" placeholder="https://example.com/awesome-page">
                        </div>
                    </div>
                    <button class="button-secondary" onclick="createUrl()">Create link</button>
                    <div id="urlMessage" class="feedback"></div>
                </section>
            </div>

            <section class="panel">
                <div class="hero-row">
                    <div>
                        <h2>All URLs</h2>
                        <p>Refresh to load the latest short links for your account.</p>
                    </div>
                    <button class="button-secondary" onclick="getUrls()">Load URLs</button>
                </div>
                <ul id="urlList" class="list"></ul>
            </section>
        </div>
    </div>

    <script>
        let token = localStorage.getItem('token');

        if (!token) {
            window.location.href = '/';
        }

        let currentUser = null;

        async function loadProfile() {
            const response = await fetch('/api/me', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                localStorage.removeItem('token');
                window.location.href = '/';
                return;
            }

            const data = await response.json();
            currentUser = data.user;
            const roleName = Array.isArray(data.roles) && data.roles.length ? data.roles[0] : 'User';
            document.getElementById('welcomeMessage').textContent = `Welcome, ${currentUser.name} (${roleName})`;
            document.getElementById('companyBlock').textContent = `Company: ${currentUser.company?.name ?? 'No company assigned'}`;
            if (currentUser.company?.name) {
                document.getElementById('invite_company').value = currentUser.company.name;
                if (roleName === 'Admin') {
                    document.getElementById('invite_company').readOnly = true;
                }
            }
        }

        loadProfile();

        function logout() {
            fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            }).then(() => {
                localStorage.removeItem('token');
                window.location.href = '/';
            });
        }

        function inviteUser() {
            const feedback = document.getElementById('inviteMessage');
            feedback.textContent = 'Inviting user...';
            feedback.style.color = '#334155';

            fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify({
                    name: document.getElementById('invite_name').value,
                    email: document.getElementById('invite_email').value,
                    password: document.getElementById('invite_password').value,
                    role: document.getElementById('invite_role').value,
                    company_name: document.getElementById('invite_company').value,
                })
            })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        feedback.style.color = '#dc2626';
                        let errorMessage = data.error || data.message || 'Invite failed';
                        if (data.errors) {
                            const errorList = Object.values(data.errors).flat();
                            errorMessage = errorList.join(', ');
                        }
                        feedback.textContent = errorMessage;
                        throw new Error(errorMessage);
                    }

                    feedback.style.color = '#16a34a';
                    feedback.textContent = data.message || 'User invited successfully';
                    document.getElementById('invite_name').value = '';
                    document.getElementById('invite_email').value = '';
                    document.getElementById('invite_password').value = '';
                    console.log(data);
                })
                .catch(err => {
                    console.error(err);
                });
        }

        function createUrl() {
            const feedback = document.getElementById('urlMessage');
            feedback.textContent = 'Creating URL...';
            feedback.style.color = '#334155';

            fetch('/api/urls', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify({
                    original_url: document.getElementById('original_url').value
                })
            })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        feedback.style.color = '#dc2626';
                        let errorMessage = data.error || data.message || 'URL creation failed';
                        if (data.errors) {
                            const errorList = Object.values(data.errors).flat();
                            errorMessage = errorList.join(', ');
                        }
                        feedback.textContent = errorMessage;
                        throw new Error(errorMessage);
                    }
                    feedback.style.color = '#16a34a';
                    feedback.textContent = 'URL created successfully';
                    document.getElementById('original_url').value = '';
                    console.log(data);
                })
                .catch(err => {
                    console.error(err);
                });
        }

        function getUrls() {
            fetch('/api/urls', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            })
                .then(response => response.json())
                .then(data => {
                    let list = document.getElementById('urlList');
                    list.innerHTML = '';

                    data.forEach(url => {
                        let li = document.createElement('li');
                        li.innerHTML = `
                ${url.original_url}
                →
                <a href="${url.original_url}" target="_blank">
                    ${url.short_code}
                </a>
            `;
                        list.appendChild(li);
                    });
                });
        }
    </script>

</body>

</html>
