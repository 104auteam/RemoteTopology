// TODO: Deny right click :)
document.oncontextmenu = _48468a0e3eb8856eb863b808a4662c1e; function _48468a0e3eb8856eb863b808a4662c1e() { return false; }

// TODO: Function for open links

function call(link) {
    window.open(link,this.target,'width=750,height=400,scrollbars=1');return false;
}
function callhost(link) {
    var win = window.open(link, '_blank');
    win.focus();
}


// JQuery function

// setTimeout(function(){
//     document.getElementById('admin-error').style.display='block';
//  }, 5000);
setTimeout(function(){ $('#admin-error').hide('fast'); }, 3000);
setTimeout(function(){ $('#admin-event').hide('fast'); }, 3000);


// sends data to a php file, via POST, and displays the received answer
function ajaxrequest(php_file, tagID) {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');  // XMLHttpRequest object
  
    // gets data from form fields, using their ID
    var username = document.getElementById('username').value;
    var action = document.getElementById('action').value;

    // create pairs index=value with data that must be sent to server
    var  the_data = 'username='+username+'&action='+action;
    request.open("POST", php_file, true);      // sets the request
  
    // adds a header to tell the PHP script to recognize the data as is sent via POST
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(the_data);    // sends the request
  
    // Check request status
    // If the response is received completely, will be transferred to the HTML tag with tagID
    request.onreadystatechange = function() {
      if (request.readyState == 4) {
        document.getElementById(tagID).innerHTML = request.responseText;
      }
    }
}

function GetModuleTable(str, module) {      
    if (str == "") {
        document.getElementById("AModule").innerHTML = "";
        return;
    }
    else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(`${module}Module`).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","/admin/getmodule.php?q="+str+"&m="+module,true);
        xmlhttp.send();
    }
}
// range    - all || users || user
// action   - trystate 
// (as sample) 
function GetFunction(range, action) {      
    if (action == "") {
        document.getElementById("TRY").innerHTML = "";
        return;
    }
    else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(`${action}`).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","/admin/getfunction.php?r="+range+"&a="+action,true);
        xmlhttp.send();
    }
}

function showRecords(perPageCount, pageNumber) {
    $.ajax({
        type: "GET",
        url: "/admin/features/getPageData.php",
        data: `pageNumber=${pageNumber}&perPageCount=${perPageCount}`,
        cache: false,
        beforeSend: function() {
            $('#loader').html('<img src="/images/loader.png" alt="reload" width="100" height="100" style="margin-top:10px;">'); 
        },
        success: function(html) {
            $("#results").html(html);
            $('#loader').html(''); 
        }
    });
}
// Timer function

// const FULL_DASH_ARRAY = 283;
// const WARNING_THRESHOLD = 10;
// const ALERT_THRESHOLD = 5;

// const COLOR_CODES = {
//   info: {
//     color: "green"
//   },
//   warning: {
//     color: "orange",
//     threshold: WARNING_THRESHOLD
//   },
//   alert: {
//     color: "red",
//     threshold: ALERT_THRESHOLD
//   }
// };


// const TIME_LIMIT = 20;
// let timePassed = 0;
// let timeLeft = TIME_LIMIT;
// let timerInterval = null;
// let remainingPathColor = COLOR_CODES.info.color;

// document.getElementById("app").innerHTML = `
// <div class="base-timer">
//   <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
//     <g class="base-timer__circle">
//       <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
//       <path
//         id="base-timer-path-remaining"
//         stroke-dasharray="283"
//         class="base-timer__path-remaining ${remainingPathColor}"
//         d="
//           M 50, 50
//           m -45, 0
//           a 45,45 0 1,0 90,0
//           a 45,45 0 1,0 -90,0
//         "
//       ></path>
//     </g>
//   </svg>
//   <span id="base-timer-label" class="base-timer__label">${formatTime(
//     timeLeft
//   )}</span>
// </div>
// `;

// // startTimer();

// function onTimesUp() {
//   clearInterval(timerInterval);
// }

// function startTimer() {
//   timerInterval = setInterval(() => {
//     timePassed = timePassed += 1;
//     timeLeft = TIME_LIMIT - timePassed;
//     document.getElementById("base-timer-label").innerHTML = formatTime(
//       timeLeft
//     );
//     setCircleDasharray();
//     setRemainingPathColor(timeLeft);

//     if (timeLeft === 0) {
//       onTimesUp();
//     }
//   }, 1000);
// }

// function formatTime(time) {
//   const minutes = Math.floor(time / 60);
//   let seconds = time % 60;

//   if (seconds < 10) {
//     seconds = `0${seconds}`;
//   }

//   return `${minutes}:${seconds}`;
// }

// function setRemainingPathColor(timeLeft) {
//   const { alert, warning, info } = COLOR_CODES;
//   if (timeLeft <= alert.threshold) {
//     document
//       .getElementById("base-timer-path-remaining")
//       .classList.remove(warning.color);
//     document
//       .getElementById("base-timer-path-remaining")
//       .classList.add(alert.color);
//   } else if (timeLeft <= warning.threshold) {
//     document
//       .getElementById("base-timer-path-remaining")
//       .classList.remove(info.color);
//     document
//       .getElementById("base-timer-path-remaining")
//       .classList.add(warning.color);
//   }
// }

// function calculateTimeFraction() {
//   const rawTimeFraction = timeLeft / TIME_LIMIT;
//   return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
// }

// function setCircleDasharray() {
//   const circleDasharray = `${(
//     calculateTimeFraction() * FULL_DASH_ARRAY
//   ).toFixed(0)} 283`;
//   document
//     .getElementById("base-timer-path-remaining")
//     .setAttribute("stroke-dasharray", circleDasharray);
// }
