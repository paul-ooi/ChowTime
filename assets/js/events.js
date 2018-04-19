$("#datepicker").datepicker({dateFormat: "yy-mm-dd", minDate: 0});

// Time Picker
function populate(selector) {
    var select = $(selector);
    var hours, minutes, ampm;
    for(var i = 0; i <= 1430; i += 30){
        hours = Math.floor(i / 60);
        minutes = i % 60;
        if (minutes < 10){
            minutes = '0' + minutes;
        }
        ampm = hours % 24 < 12 ? 'AM' : 'PM';
        hours = hours % 12;
        if (hours === 0){
            hours = 12;
        }

        // For value input
        if (ampm === 'PM'){
            var valHour = hours + 12;
        } else {
            var valHour = hours;
            if (hours < 10){
                valHour = '0' + hours;
            }
        }

        select.append($('<option></option>')
            .attr('value', valHour + ':' + minutes + ':00')
            .text(hours + ':' + minutes + ' ' + ampm));
    }
}

populate('.timeSelect');
