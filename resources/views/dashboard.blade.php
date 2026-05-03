<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h1>Dashboard</h1>

<div>
    <strong id="welcomeMessage">Loading user...</strong><br>
    <span id="companyBlock"></span>
</div>

<button onclick="logout()">Logout</button>

<hr>

<h2>Invite User</h2>

<input type="text" id="invite_name" placeholder="Name"><br><br>
<input type="email" id="invite_email" placeholder="Email"><br><br>
<input type="password" id="invite_password" placeholder="Password"><br><br>
<input type="text" id="invite_company" placeholder="Company Name (optional)"><br><br>

<select id="invite_role">
    <option value="Member">Member</option>
    <option value="Admin">Admin</option>
    <option value="Sales">Sales</option>
    <option value="Manager">Manager</option>
    <option value="Engineer">Engineer</option>
</select>

<br><br>
<button onclick="inviteUser()">Invite</button>
<div id="inviteMessage" style="margin-top:12px;color:#333;"></div>

<hr>

<h2>Create Short URL</h2>

<input type="text" id="original_url" placeholder="Enter URL"><br><br>
<button onclick="createUrl()">Create</button>
<div id="urlMessage" style="margin-top:12px;color:#333;"></div>

<hr>

<h2>All URLs</h2>

<button onclick="getUrls()">Load URLs</button>

<ul id="urlList"></ul>

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
            feedback.style.color = 'red';
            let errorMessage = data.error || data.message || 'Invite failed';
            if (data.errors) {
                // Handle validation errors
                const errorList = Object.values(data.errors).flat();
                errorMessage = errorList.join(', ');
            }
            feedback.textContent = errorMessage;
            throw new Error(errorMessage);
        }

        feedback.style.color = 'green';
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
            feedback.style.color = 'red';
            let errorMessage = data.error || data.message || 'URL creation failed';
            if (data.errors) {
                // Handle validation errors
                const errorList = Object.values(data.errors).flat();
                errorMessage = errorList.join(', ');
            }
            feedback.textContent = errorMessage;
            throw new Error(errorMessage);
        }
        feedback.style.color = 'green';
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
