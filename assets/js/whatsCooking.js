function initializeMap() {
    var userMap = new google.maps.Map(document.getElementById('map'), {
        zoom: 15
    });

    //Create new instance of geocode class
    var geoCode = new google.maps.Geocoder();
    $.post("../models/whatsCooking.php", function(data) {
        console.log(data);
        // var addr = JSON.parse(data);
        geoCode.geocode(
            {address: data.a }, function(results, status) {
                if(status == "OK") {
                    userMap.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: userMap,
                        position: results[0].geometry.location
                    });
                }
            });
    }, "json");
}


// Because I've specified the parsing type in my $post, I do not need to include JSON.parse. If it wasn't included, I would, beacuse it doesn't know that it is JSON.
