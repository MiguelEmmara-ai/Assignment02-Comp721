/**
 * Author: Muhamad Miguel Emmara
 * Student ID: 18022146
 * Email: ryf2144@autuni.ac.nz
 */

/**
 * This function shows all bookings by passing information to the server
 * @send XML object
 */
function showall() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tableID").innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET", 'includes/backend/getAllBook.php', true);
    xmlhttp.send();
}

/**
 * This function shows recent bookings (within 2 hours) by passing information to the server
 * @send XML object
 */
function showRecent() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tableID").innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET", 'includes/backend/getRecentBook.php', true);
    xmlhttp.send();
}

/**
 * This function shows all available (Unassigned) Passengers by passing information to the server
 * @send XML object
 */
function showAvailPassengers() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tableID").innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET", 'includes/backend/getAvailBook.php', true);
    xmlhttp.send();
}

/**
 * This function search specific passengers based on their bookingRefNo
 * @send XML object
 */
function searchPassengers(bookingRefNo) {
    var xhttp = createRequest();

    if (bookingRefNo == "") {
        Swal.fire(
            'Missing Something?',
            'You Forgotten To Put The Booking Number<br><br>Want to know the recent books?<br>Click On The "Show Recent Bookings"',
            'question'
        )
        return;
    }

    if (!(/BRN\d{5}$/.test(bookingRefNo))) {
        Swal.fire(
            'Wrong Format',
            'Sorry, the Booking Reference Number format is wrong',
            'error'
        )
        return;
    }

    xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tableID").innerHTML = this.responseText;
        }
    }
    xhttp.open("GET", "includes/backend/searchBook.php?number=" + String(bookingRefNo), true);
    xhttp.send();
}

/**
 * This function is to assign taxi to a booking number
 * @send XML object
 */
function updateAssignCab(bookingRefNo) {
    var xhttp = createRequest();

    if (bookingRefNo == "") {
        document.getElementById("tableID").innerHTML = "";
        return;
    }

    xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            Swal.fire(
                'Congratulations!',
                xhttp.responseText,
                'success'
            ).then(function () {
                location.reload();
            });
        }
    };

    xhttp.open("GET", "includes/backend/assignCab.php?q=" + String(bookingRefNo), true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(null);
}

/**
 * Initialize XML 
 * @returns XML object
 */
function createRequest() {
    var xhr = false;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xhr = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        // code for IE6, IE5
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xhr;
} // end function createRequest()