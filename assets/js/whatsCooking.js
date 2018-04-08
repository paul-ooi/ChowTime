$(document).ready(function(){
//SOMEHOW FIX LAYOUT ISSUE OF FILTER BAR

    //CHECK IF XSMALL SCREEN SIZE ON LOAD AND ALTER FILTER BAR
    filterBar("768", ".filter-bar-container", "hidden", ".filter-icon-container", "hidden");


    if(window.onload) {
        if (window.matchMedia('(max-width: 768px)').matches) {
            if(!($("#filter-btn").click())) {
                $(".filter-bar-container").addClass("hidden");
                $(".d-flex").addClass("layout");
            } else if ($("#filter-btn").click()) {
                $(".filter-bar-container").removeClass("hidden");
                $(".d-flex").removeClass("layout");
            }
        }
    }

    $("#filter-btn").click(function(){
        $(".filter-bar-container").toggleClass("hidden");
        $(".d-flex").toggleClass("layout");
    })

    //ON MODIFICATION OF SCREEN SIZE
    $(window).resize(function() {
        //HIDE/SHOW FILTER
        filterBar("768", ".filter-bar-container", "hidden", ".filter-icon-container", "hidden");
        filterBar("768", ".d-flex", "layout", ".d-flex", "layout");
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

//SHOW WHATS COOKING
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
            {address: data.key1 }, function(results, status) {
                if(status == "OK") {
                    userMap.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: userMap,
                        position: results[0].geometry.location
                    });
                }
            });
            geoCode.geocode(
                {address: data.key2 }, function(results, status) {
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
}//END INITIALIZE MAP

//PINTEREST TO SHARE RECIPE




// Because I've specified the parsing type in my $post, I do not need to include JSON.parse. If it wasn't included, I would, beacuse it doesn't know that it is JSON.
