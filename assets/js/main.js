// Подтверждение удаления
document.addEventListener('DOMContentLoaded', function() {
    // Подтверждение перед удалением
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Вы уверены, что хотите удалить эту запись?')) {
                e.preventDefault();
            }
        });
    });
    
    // Динамическая загрузка дисциплин при выборе группы
    const groupSelect = document.getElementById('group');
    const disciplineSelect = document.getElementById('discipline');
    
    if (groupSelect && disciplineSelect) {
        groupSelect.addEventListener('change', function() {
            if (this.value) {
                fetch(`get_disciplines.php?group_id=${this.value}`)
                    .then(response => response.json())
                    .then(data => {
                        disciplineSelect.innerHTML = '<option value="">Выберите дисциплину</option>';
                        data.forEach(discipline => {
                            const option = document.createElement('option');
                            option.value = discipline.ID;
                            option.textContent = discipline.Наименование;
                            disciplineSelect.appendChild(option);
                        });
                    });
            } else {
                disciplineSelect.innerHTML = '<option value="">Выберите дисциплину</option>';
            }
        });
    }
});