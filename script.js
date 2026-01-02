var images = [
    'https://picsum.photos/400/300?random=1',
    'https://picsum.photos/400/300?random=2',
    'https://picsum.photos/400/300?random=3',
    'https://picsum.photos/400/300?random=4',
    'https://picsum.photos/400/300?random=5'
];

var currentIndex = 0;

function changeBackground() {
    var hour = new Date().getHours();
    var body = document.body;
    
    if (hour >= 6 && hour < 12) {
        body.style.backgroundColor = '#FFE4B5';
    } else if (hour >= 12 && hour < 18) {
        body.style.backgroundColor = '#87CEEB';
    } else if (hour >= 18 && hour < 22) {
        body.style.backgroundColor = '#FFA07A';
    } else {
        body.style.backgroundColor = '#2F4F4F';
        body.style.color = '#fff';
    }
}

function changeImage() {
    var img = document.getElementById('mainImage');
    img.src = images[currentIndex];
    currentIndex = (currentIndex + 1) % images.length;
}

function generateTable() {
    var min = parseInt(document.getElementById('minVal').value);
    var max = parseInt(document.getElementById('maxVal').value);
    
    if (min > max) {
        alert('Мінімум повинен бути менше максимуму');
        return;
    }
    
    var table = document.createElement('table');
    
    for (var i = 0; i < 10; i++) {
        var row = document.createElement('tr');
        for (var j = 0; j < 10; j++) {
            var cell = document.createElement('td');
            var randomNum = Math.floor(Math.random() * (max - min + 1)) + min;
            cell.textContent = randomNum;
            
            if ((i + j) % 2 === 0) {
                cell.style.backgroundColor = '#fff';
            } else {
                cell.style.backgroundColor = '#ccc';
            }
            
            row.appendChild(cell);
        }
        table.appendChild(row);
    }
    
    var container = document.getElementById('tableContainer');
    container.innerHTML = '';
    container.appendChild(table);
}

window.onload = function() {
    var interval = prompt('Введіть інтервал зміни зображень (секунди):', '3');
    interval = parseInt(interval) || 3;
    
    changeBackground();
    changeImage();
    
    setInterval(changeImage, interval * 1000);
    setInterval(changeBackground, 60000);
};