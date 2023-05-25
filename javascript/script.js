// Menu
const menu_pop = document.querySelector('#menu-bars');
const navbar = document.querySelector('.header .navbar');

if (menu_pop != null) {
    menu_pop.addEventListener('click', () => {
        console.log('click');
        menu_pop.classList.toggle('fa-times');
        navbar.classList.toggle('active');
    });
}


// Faqs
const faqs = document.querySelectorAll('.faq');
if (faqs != null) {
    faqs.forEach(faq => {
        faq.addEventListener('click', () => {
            faq.classList.toggle('active');
        });
    });
}


// Ticket
const tickets = document.querySelectorAll('.ticket');

if (tickets != null) {
    tickets.forEach(ticket => {
        ticket.addEventListener('click', () => {
            ticket.classList.toggle('active');
        });
    });
}

// User
const users = document.querySelectorAll('.user');

if (users != null) {

    users.forEach(user => {
        user.addEventListener('click', () => {
            user.classList.toggle('active');
        });
    });
}

// Swiper
const swiper = new Swiper(".home-slider", {
    loop: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

// Mota FAQ
function toggleOptions() {
    var customMessageTextarea = document.getElementById("message");
    var predefinedAnswersSelect = document.getElementById("faq-answers");
    var faqAnswerInput = document.querySelector('input[name="faq_answer"]');

    if (customMessageTextarea.style.display === "none") {
        customMessageTextarea.style.display = "block";
        predefinedAnswersSelect.style.display = "none";
        faqAnswerInput.value = ""; // Clear the value if switching to custom message
    } else {
        customMessageTextarea.style.display = "none";
        predefinedAnswersSelect.style.display = "block";
        faqAnswerInput.value = predefinedAnswersSelect.value; // Set the selected option value as the input value
    }
}



// uploaded image
let input_img = document.getElementById('file-image');
let img_name = document.getElementById('file-image-name');

if (input_img != null) {

    input_img.addEventListener('change', () => {
        let inputImage = document.querySelector('input[id=file-image]').files[0];
        img_name.innerText = inputImage.name;
    });

}
// uploaded files

let uploaded_files = document.getElementById('up_files');
if (uploaded_files != null) {
    uploaded_files.addEventListener('change', handleFileSelect);
}

function handleFileSelect(event) {
    let files = event.target.files;
    let fileList = document.getElementById('file-list');

    fileList.innerHTML = ''; // Clear existing file list

    for (let i = 0; i < files.length; i++) {
        let listItem = document.createElement('li');
        listItem.textContent = files[i].name;
        fileList.appendChild(listItem);
    }
}



// Filter tables by search input id= filterInput / table id = tableToFilter
const filterInput = document.getElementById("filterInput");
if (filterInput != null) {
    filterInput.addEventListener("keyup", function () {
        let keyword = this.value;
        let tableToFilter = document.getElementById("tableToFilter");
        let allRows = tableToFilter.getElementsByTagName('tr');
        for (let i = 0; i < allRows.length; i++) {

            let all_col = allRows[i].getElementsByTagName('td');

            for (let j = 0; j < all_col.length; j++) {

                if (all_col[j]) {
                    let col_val = all_col[j].innerText || all_col[j].textContent;
                    col_val = col_val.toUpperCase();
                    if (col_val.toLowerCase().indexOf(keyword.toLowerCase()) > -1) {
                        allRows[i].style.display = "";
                        break;
                    } else {
                        allRows[i].style.display = "none";
                    }
                }
            }

        }
    });
}

// Filter tables when there is more then 1 table
const filterInput1 = document.getElementById("filterInput1");
if (filterInput1 != null) {
    filterInput1.addEventListener("keyup", function () {
        let keyword = this.value;
        let tableToFilter1 = document.getElementById("tableToFilter1");
        let allRows = tableToFilter1.getElementsByTagName('tr');
        for (let i = 0; i < allRows.length; i++) {

            let all_col = allRows[i].getElementsByTagName('td');

            for (let j = 0; j < all_col.length; j++) {

                if (all_col[j]) {
                    let col_val = all_col[j].innerText || all_col[j].textContent;
                    col_val = col_val.toUpperCase();
                    if (col_val.toLowerCase().indexOf(keyword.toLowerCase()) > -1) {
                        allRows[i].style.display = "";
                        break;
                    } else {
                        allRows[i].style.display = "none";
                    }
                }
            }

        }
    });
}

// Filter tables when there is more then 2 table
const filterInput2 = document.getElementById("filterInput2");
if (filterInput2 != null) {
    filterInput2.addEventListener("keyup", function () {
        let keyword = this.value;
        let tableToFilter2 = document.getElementById("tableToFilter2");
        let allRows = tableToFilter2.getElementsByTagName('tr');
        for (let i = 0; i < allRows.length; i++) {

            let all_col = allRows[i].getElementsByTagName('td');

            for (let j = 0; j < all_col.length; j++) {

                if (all_col[j]) {
                    let col_val = all_col[j].innerText || all_col[j].textContent;
                    col_val = col_val.toUpperCase();
                    if (col_val.toLowerCase().indexOf(keyword.toLowerCase()) > -1) {
                        allRows[i].style.display = "";
                        break;
                    } else {
                        allRows[i].style.display = "none";
                    }
                }
            }
        }

    });
}

// Filter tables when there is more then 3 table
const filterInput3 = document.getElementById("filterInput3");
if (filterInput3 != null) {
    filterInput3.addEventListener("keyup", function () {
        let keyword = this.value;
        let tableToFilter3 = document.getElementById("tableToFilter3");
        let allRows = tableToFilter3.getElementsByTagName('tr');
        for (let i = 0; i < allRows.length; i++) {

            let all_col = allRows[i].getElementsByTagName('td');

            for (let j = 0; j < all_col.length; j++) {

                if (all_col[j]) {
                    let col_val = all_col[j].innerText || all_col[j].textContent;
                    col_val = col_val.toUpperCase();
                    if (col_val.toLowerCase().indexOf(keyword.toLowerCase()) > -1) {
                        allRows[i].style.display = "";
                        break;
                    } else {
                        allRows[i].style.display = "none";
                    }
                }
            }
        }
    });
}






/* Sorting tables class="table-sortable" - table to sort/ column to sort / bool for asc or desc */
function sortTableByColumn(table, column, asc = true) {
    const dirModifier = asc ? 1 : -1;
    const tBody = table.tBodies[0];
    const rows = Array.from(tBody.querySelectorAll("tr"));

    // Sort each row
    const sortedRows = rows.sort((a, b) => {
        const colum = column + 1;
        const aColText = a.querySelector('td:nth-child(' + colum + ')').textContent.trim();
        const bColText = b.querySelector('td:nth-child(' + colum + ')').textContent.trim();

        return aColText > bColText ? (1 * dirModifier) : (-1 * dirModifier);
    });

    // Remove all existing tr from the table
    while (tBody.firstChild) {
        tBody.removeChild(tBody.firstChild);
    }

    // Re-add the newly sorted rows
    tBody.append(...sortedRows);

    // Remember how the column is sorted
    table.querySelectorAll("th").forEach(th => th.classList.remove("th-sort-asc", "th-sort-desc"));
    table.querySelector("th:nth-child(" + (column + 1) + ")").classList.toggle("th-sort-asc", asc);
    table.querySelector("th:nth-child(" + (column + 1) + ")").classList.toggle("th-sort-desc", !asc);
}

document.querySelectorAll(".table-sortable th").forEach(headerCell => {

    headerCell.addEventListener("click", () => {

        const tableElement = headerCell.parentElement.parentElement.parentElement;
        const headerIndex = Array.prototype.indexOf.call(headerCell.parentElement.children, headerCell);
        const currentIsAscending = headerCell.classList.contains("th-sort-asc");

        sortTableByColumn(tableElement, headerIndex, !currentIsAscending);

    });

});

