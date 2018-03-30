$(document).ready(function(){
    //DISPLAY THE SLIDER
    $("#distance").slider({});



    //ON LOAD CHECK SCREEN SIZE AND ALTER SLIDER
    addRemoveTwoClasses("1165", ".slide-container", "hidden", ".input-container", "hidden");
    //CHECK IF XSMALL SCREEN SIZE ON LOAD AND ALTER FILTER BAR
    filterBar("768", ".filter-bar-container", "hidden", ".filter-icon-container", "hidden");

    if(window.matchMedia('(max-width: 768px)').matches) {
        $("#filter-btn").click(function(){
            $(".filter-bar-container").toggleClass("hidden");
        })
    }

    //ON MODIFICATION OF SCREEN SIZE
    $(window).resize(function() {
        //HIDE/SHOW SLIDER
        addRemoveTwoClasses("1165", ".slide-container", "hidden", ".input-container", "hidden");
        //HIDE/SHOW FILTER
        filterBar("768", ".filter-bar-container", "hidden", ".filter-icon-container", "hidden");
    })//END RESIZE CHECKER


    function addRemoveTwoClasses(width, targetAdd, classAdd, targetRmv, classRemove) {
        if(window.matchMedia('(max-width:'+ width +'px)').matches) {
            $(targetAdd).addClass(classAdd);
            $(targetRmv).removeClass(classRemove);
        } else if (window.matchMedia('(min-width:' + width + 'px)').matches) {
            $(targetRmv).addClass(classAdd);
            $(targetAdd).removeClass(classRemove);
        }
    }

    function filterBar(width, target1, t1, target2, t2) {
        if(window.matchMedia('(max-width:'+ width +'px)').matches) {
            $(target1).addClass(t1);
            $(target2).removeClass(t2);
        } else if (window.matchMedia('(min-width:' + width + 'px)').matches) {
            $(target2).addClass(t1);
            $(target1).removeClass(t2);
        }
    }

})//END PAGE LOAD


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
            geoCode.geocode(
                {address: data.b }, function(results, status) {
                    if(status == "OK") {
                        userMap.setCenter(results[0].geometry.location);
                        var image = {
                          url: "../images/JessicaAvatar.png",
                          size: new google.maps.Size(71, 71),
                          origin: new google.maps.Point(0, 0),
                          anchor: new google.maps.Point(17, 34),
                          scaledSize: new google.maps.Size(25, 25)
                        };
                        var marker = new google.maps.Marker({
                            map: userMap,
                            position: results[0].geometry.location,
                            icon: image
                        });
                    }
                });
    }, "json");
}


// Because I've specified the parsing type in my $post, I do not need to include JSON.parse. If it wasn't included, I would, beacuse it doesn't know that it is JSON.
