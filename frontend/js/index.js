const dir = '../../controllers/';


document.addEventListener('DOMContentLoaded', function() {
    // Функция для загрузки данных
    function loadLessonsData() {
        
        fetch(dir + 'StudentController.php', {
            method: 'POST',
              headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  },
            body: JSON.stringify({
                action: 'getStudentMarks',
                id: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.error) {
                console.error(data.error);
                return;
            }
            
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    // Загружаем данные при загрузке страницы
    loadLessonsData();
});