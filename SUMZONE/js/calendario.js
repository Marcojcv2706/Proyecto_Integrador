const calendarElement = document.getElementById("calendar");
const modal = document.getElementById("modal");
const closeModal = document.getElementById("close");
const addActivityButton = document.getElementById("addActivity");
const activityInput = document.getElementById("activity");
const prevMonthButton = document.getElementById("prevMonth");
const nextMonthButton = document.getElementById("nextMonth");

let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();
let selectedDate;

const closeModalFunction = () => {
    modal.style.display = "none";
    activityInput.value = '';
};

closeModal.onclick = closeModalFunction;
window.onclick = function(event) {
    if (event.target === modal) {
        closeModalFunction();
    }
};

addActivityButton.onclick = function() {
    const activityText = activityInput.value;
    if (activityText) {
        const dayDiv = document.querySelector(`.day[data-date="${selectedDate}"]`);
        
        const activityDiv = document.createElement("div");
        activityDiv.className = "activity";
        activityDiv.textContent = activityText;

        activityDiv.onclick = function() {
            dayDiv.removeChild(activityDiv);
        };

        dayDiv.appendChild(activityDiv);
        closeModalFunction();
    }
};

const renderCalendar = () => {
    calendarElement.innerHTML = ''; // Limpia el calendario

    const monthDiv = document.createElement("div");
    monthDiv.className = "month";
    const monthHeader = document.createElement("h2");
    monthHeader.textContent = new Date(currentYear, currentMonth).toLocaleString('es', { month: 'long', year: 'numeric' });
    monthDiv.appendChild(monthHeader);
    
    const daysDiv = document.createElement("div");
    daysDiv.className = "days";
    
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    const firstDay = new Date(currentYear, currentMonth, 1).getDay();
    
    for (let i = 0; i < firstDay; i++) {
        const emptyDiv = document.createElement("div");
        emptyDiv.className = "day empty";
        daysDiv.appendChild(emptyDiv);
    }
    
    for (let day = 1; day <= daysInMonth; day++) {
        const dayDiv = document.createElement("div");
        dayDiv.className = "day";
        dayDiv.textContent = day;
        dayDiv.setAttribute("data-date", `${currentMonth + 1}/${day}/${currentYear}`);

        dayDiv.onclick = function() {
            selectedDate = `${currentMonth + 1}/${day}/${currentYear}`;
            modal.style.display = "block";
        };
        
        daysDiv.appendChild(dayDiv);
    }
    
    monthDiv.appendChild(daysDiv);
    calendarElement.appendChild(monthDiv);
};

prevMonthButton.onclick = () => {
    if (currentMonth === 0) {
        currentMonth = 11;
        currentYear--;
    } else {
        currentMonth--;
    }
    renderCalendar();
};

nextMonthButton.onclick = () => {
    if (currentMonth === 11) {
        currentMonth = 0;
        currentYear++;
    } else {
        currentMonth++;
    }
    renderCalendar();
};

renderCalendar();