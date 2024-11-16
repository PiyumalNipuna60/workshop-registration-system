<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="assets/DashBordStyle.css">
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
        }

        .modal.show {
            display: block;
        }

        .modal-header {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .modal-footer {
            margin-top: 10px;
            text-align: right;
        }

        .modal-footer button {
            padding: 5px 10px;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
            <br>
            <nav>
                <ul>
                    <li><a href="user_dashboard_form_ui.php">My Workshops</a></li>
                    <li><a href="register.php">Register for Workshop</a></li>
                    <li><a href="login_form_ui.php">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h2>Your Workshops</h2>
            <button id="addWorkshopBtn">Add Workshop</button>
            <br><br>

            <!-- Workshop Table -->
            <?php if (!empty($user_workshops)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Workshop Title</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody id="workshopTable">
                        <?php foreach ($user_workshops as $workshop): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($workshop['Title']); ?></td>
                                <td><?php echo htmlspecialchars($workshop['Date']); ?></td>
                                <td><?php echo htmlspecialchars($workshop['Time']); ?></td>
                                <td><?php echo htmlspecialchars($workshop['Location']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No workshops registered yet..!</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add Workshop Modal -->
    <div class="modal" id="addWorkshopModal">
        <div class="modal-header">Add Workshop</div>
        <form id="addWorkshopForm">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <br>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            <br>
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>
            <br>
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
            <br>
            <div class="modal-footer">
                <button type="submit">Save</button>
                <button type="button" id="closeModalBtn">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        const addWorkshopBtn = document.getElementById('addWorkshopBtn');
        const addWorkshopModal = document.getElementById('addWorkshopModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const addWorkshopForm = document.getElementById('addWorkshopForm');
        const workshopTable = document.getElementById('workshopTable');

        // Open Modal
        addWorkshopBtn.addEventListener('click', () => {
            addWorkshopModal.classList.add('show');
        });

        // Close Modal
        closeModalBtn.addEventListener('click', () => {
            addWorkshopModal.classList.remove('show');
        });

        // Handle Form Submission
        addWorkshopForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(addWorkshopForm);
            const response = await fetch('add_workshop.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();

            if (result.success) {
                // Update Table
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${result.workshop.Title}</td>
                    <td>${result.workshop.Date}</td>
                    <td>${result.workshop.Time}</td>
                    <td>${result.workshop.Location}</td>
                `;
                workshopTable.appendChild(newRow);

                // Close Modal
                addWorkshopModal.classList.remove('show');
                addWorkshopForm.reset();
            } else {
                alert('Failed to add workshop.');
            }
        });
    </script>
</body>

</html>
