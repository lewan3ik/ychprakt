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
            const counter = document.getElementById('studentCount');
            counter.innerHTML = `${students.length}`;
            tbody.innerHTML = ''; // Очистка содержимого tbody

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

function fetchGroups() {
    fetch('../controllers/GroupController.php?action=get')
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(list => {
            const tbody = document.getElementById('groups');
            const counter = document.getElementById('groupCount');
            counter.innerHTML = `${list.length}`;
            tbody.innerHTML = ''; // Очистка содержимого tbody

            list.forEach(elem => {
                const row = `
                <tr>
                            <td>${elem.ID}</td>
                            <td>${elem.Name}</td>
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
fetchGroups();
fetchStudents();
