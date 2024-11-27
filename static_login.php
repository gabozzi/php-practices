<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Static Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <!-- Error/Success Card -->
        <div id="alertMessage" class="alert d-none alert-dismissible fade show" role="alert">
            <span id="alertText"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <h3 class="text-center mb-4">Login</h3>
        <form id="loginForm">
            <!-- Role Selection -->
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Content Manager">Content Manager</option>
                    <option value="System User">System User</option>
                </select>
            </div>

            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter your username" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // accounts
    const accounts = {
        Admin: [{
                username: "admin1",
                password: "password1"
            },
            {
                username: "admin2",
                password: "password2"
            },
        ],
        "Content Manager": [{
                username: "manager1",
                password: "password1"
            },
            {
                username: "manager2",
                password: "password2"
            },
        ],
        "System User": [{
            username: "user1",
            password: "password1"
        }, ],
    };

    const loginForm = document.getElementById("loginForm");
    const alertMessage = document.getElementById("alertMessage");
    const alertText = document.getElementById("alertText");

    loginForm.addEventListener("submit", function(event) {
        event.preventDefault();

        const role = document.getElementById("role").value;
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        // Validation
        if (!role || !username || !password) {
            showAlert("All fields are required.", "danger");
            return;
        }

        // Check credentials
        const validAccount = accounts[role]?.find(
            account => account.username === username && account.password === password
        );

        if (validAccount) {
            showAlert("Login successful!", "success");
        } else {
            showAlert("Invalid credentials. Please try again.", "danger");
        }
    });

    // Show Alert
    function showAlert(message, type) {
        alertText.textContent = message;
        alertMessage.className = `alert alert-${type} alert-dismissible fade show`;
    }
    </script>

</body>

</html>