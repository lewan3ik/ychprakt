function fetchStudents() {
    fetch('../controllers/StudentController.php?action=get')
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(students => {
            const tbody = document.getElementById('students');
            tbody.innerHTML = ''; // Очистка содержимого tbody

            students.forEach(student => {
                const row = `
                <tr>
                    <td>${student.ID}</td>
                    <td>${student.FIO}</td>
                    <td>${student.Group}</td>
                    <td>${student.date}</td>
                    <td>
                        <button class="btn btn-outline">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        })
        .catch(err => console.error('Failed to fetch students:', err));
}

fetchStudents();
