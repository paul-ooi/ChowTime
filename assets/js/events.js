$("#datepicker").datepicker();

// Time Picker
function populate(selector) {
    var select = $(selector);
    var hours, minutes, ampm;
    for(var i = 0; i <= 1430; i += 15){
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
        select.append($('<option></option>')
            .attr('value', i)
            .text(hours + ':' + minutes + ' ' + ampm));
    }
}

populate('.timeSelect');
