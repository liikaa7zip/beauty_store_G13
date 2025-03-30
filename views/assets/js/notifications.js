document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('notificationForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${response.id}</td>
                    <td>${response.notification_title}</td>
                    <td>${response.notification_message}</td>
                    <td>${response.notification_type}</td>
                    <td>${response.start_date}</td>
                    <td>${response.end_date}</td>
                    <td>${response.status}</td>
                    <td>${response.created_at}</td>
                    <td><button class="delete-btn" data-id="${response.id}">Delete</button></td>
                `;
                document.getElementById('notificationsTable').appendChild(newRow);

                // Add the new alert below the "Alerts" heading
                const newAlert = document.createElement('div');
                newAlert.className = `alert alert-${response.notification_type}`;
                newAlert.textContent = response.notification_message;
                const notificationsContainer = document.querySelector('.notifications');
                notificationsContainer.appendChild(newAlert);
            }
        };
        xhr.send(formData);
    });

    document.getElementById('notificationsTable').addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-btn')) {
            const id = event.target.getAttribute('data-id');
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        event.target.closest('tr').remove();
                    }
                }
            };
            xhr.send('delete_id=' + id);
        }
    });
});