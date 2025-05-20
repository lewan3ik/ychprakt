function fetchStudents() {
    console.log('xyu')
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
            console.log(students);

            students.forEach(student => {
                const row = `
                <tr>
                    <td>${student.ID}</td>
                    <td>${student.FullName}</td>
                    <td>${student.GroupID}</td>
                    <td>${student.ExpulsionDate}</td>
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
