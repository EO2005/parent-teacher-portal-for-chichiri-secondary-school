const gradeInput = document.getElementById("gradeInput");
const gradeDisplay = document.getElementById("gradeDisplay");

gradeInput.addEventListener("input", function () {
    const grade = parseFloat(gradeInput.value);
    if (grade > 100) {
        grade = 100;
        gradeInput.value = grade;
    }
    if (grade >= 90) {
        gradeDisplay.textContent = "Grade A+";
    } else if(grade >= 80){
        gradeDisplay.textContent = "Grade A";
    } else if (grade >= 70) {
        gradeDisplay.textContent = "Grade B";
    } else if (grade >= 60) {
        gradeDisplay.textContent = "Grade C";
    } else if (grade >= 50) {
        gradeDisplay.textContent = "Grade D";
    } else if (grade >= 0) {
        gradeDisplay.textContent = "Grade F";
    } else {
        gradeDisplay.textContent = "No Result";
    }
});