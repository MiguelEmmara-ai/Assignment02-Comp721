/**
 * Author: Muhamad Miguel Emmara
 * Student ID: 18022146
 * Email: ryf2144@autuni.ac.nz
 */

/**
 * Add Booking To booking.php to process further
 * @send XML object
 */
function addBooking() {
    var xhr = createRequest();

    if (xhr) {
        var fName = document.getElementById("fName").value;
        var lName = document.getElementById("lName").value;
        var customerName = fName + " " + lName;

        // generate booking date/time
        // get client's current date/time for booking date & booking time
        var currentDate = new Date();
        var dd = String(currentDate.getDate()).padStart(2, '0');
        var mm = String(currentDate.getMonth() + 1).padStart(2, '0');
        var yyyy = currentDate.getFullYear();
        var bookingDate = yyyy + '-' + mm + '-' + dd; // formatted this way because MySQL uses yyyy-mm-dd format

        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var bookingTime = hours + ':' + minutes + ':' + seconds; // formated this way because MySQL uses HH:MM:SS format

        var phone = document.getElementById("phone").value;
        var unumber = document.getElementById("unumber").value;
        var snumber = document.getElementById("snumber").value;
        var stname = document.getElementById("stname").value;
        var sbname = document.getElementById("sbname").value;
        var dsbname = document.getElementById("dsbname").value;
        var pickUpDate = document.getElementById("pickUpDate").value;
        var pickUpTime = document.getElementById("pickUpTime").value;

        var inlineRadioOptions = document.querySelector('input[name="inlineRadioOptions"]:checked').value;

        var validated = false;

        // validate if pickupTime & pickupDate is not before current date & current time
        if (pickUpDate == bookingDate) { // validate if pickupDate is today

            if (validateTime(pickUpTime, bookingTime)) { // then check if time is not before current time

                validated = true;
            }

        } else if (validateDate(pickUpDate, bookingDate)) { // if pickupDate is after today

            validated = true;
        }

        // If time and date are correct
        if (validated) {
            // validate number inputs
            if (!/^[0-9]+$/.test(phone) || !/^[0-9]+$/.test(snumber)) {
                Swal.fire({
                    title: 'Oopss...',
                    icon: 'error',
                    html: 'Please only enter numeric characters only for <b>Contact Phone</b> and <b>Street Number</b>! (Allowed input:0-9)',
                })

                validated = false;
            } else {
                // if number inputs are corect
                if (validated) {
                    // encodeURIComponent(bookingDate)
                    var url = "includes/backend/booking.php";
                    var params = "customerName=" + customerName +
                        "&fName=" + encodeURIComponent(fName) +
                        "&lName=" + encodeURIComponent(lName) +
                        "&bookingDate=" + encodeURIComponent(bookingDate) +
                        "&bookingTime=" + encodeURIComponent(bookingTime) +
                        "&phone=" + encodeURIComponent(phone) +
                        "&unumber=" + encodeURIComponent(unumber) +
                        "&snumber=" + encodeURIComponent(snumber) +
                        "&stname=" + encodeURIComponent(stname) +
                        "&sbname=" + encodeURIComponent(sbname) +
                        "&dsbname=" + encodeURIComponent(dsbname) +
                        "&pickUpDate=" + encodeURIComponent(pickUpDate) +
                        "&pickUpTime=" + encodeURIComponent(pickUpTime) +
                        "&inlineRadioOptions=" + encodeURIComponent(inlineRadioOptions);

                    xhr.open("POST", url, true);

                    // Send the proper header information along with the request
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () { // Call a function when the state changes.
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            Swal.fire(
                                'Thank you for your booking!',
                                xhr.responseText,
                                'success'
                            ).then(function () {
                                location.reload();
                            });
                        }
                    }
                    xhr.send(params);

                } else {
                    $(document).ready(function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something is wrong buddy',
                            footer: 'Make Sure Fill  All The Required Data Or Try Again Later'
                        })
                    });
                }
            }
        }
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something is wrong buddy',
            footer: 'Please Try Again Later'
        })
    }
}

/**
 * validateDate
 * @returns true or false
 */
function validateDate(date, todaysdate) {
    if (date < todaysdate) {
        $(document).ready(function () {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Date error, please recheck your pick-up DATE'
            })
        });
        return false;
    }
    return true;
}

/**
 * validateTime
 * @returns true or false
 */
function validateTime(inputTime, currentTime) {
    if (inputTime < currentTime) {
        $(document).ready(function () {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Date error, please recheck your pick-up Time'
            })
        });
        return false;
    }
    return true;
}

/**
 * Get Today Date in DD/MM/YYYY.
 * @returns new Date().toDateInputValue();
 */
function getTodayDate() {
    // Add this for correct timezone support
    Date.prototype.toDateInputValue = (function () {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0, 10);
    });

    return new Date().toDateInputValue();
}

/**
 * Get Today Time Dependin On User Device Time Format.
 * @returns time
 */
function getTodayTime() {
    var today = new Date();
    var hours = today.getHours();
    var minutes = today.getMinutes();

    return time = (hours < 10 ? `0${hours}` : hours) + ':' + (minutes < 10 ? `0${minutes}` : minutes);
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