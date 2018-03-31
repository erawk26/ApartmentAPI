var aptArr = [];
$(document).ready(function () {
    $.ajax({//production
        type: "GET",
        url: "/api/apartments.php",
        dataType: "json",
        async: true,
        success: function (res) {
            aptArr = res['data'];
             console.log(res);
        },
        error: function (res) {
            console.log('FAIL')
        }
    })
        .then(function () {
            if (aptArr.length > 0) {
                aptList = '<ul class="apartments">';
                aptArr.map(function (apt) {
                    var aptName = apt['ApartmentName'],
                        numBeds = apt['Beds'],
                        numBaths = apt['Baths'],
                        floorName = apt['FloorplanName'],
                        applyLink = apt['ApplyOnlineURL'];
                    aptList += "<li>" +
                        "Name: " + aptName + "<br>" +
                        "Floor plan: " + floorName + "<br>" +
                        "Beds: " + numBeds + "<br>" +
                        "Baths: " + numBaths + "<br>" +
                        "<a href='" + applyLink + "'>Apply Online</a><br>" +
                        "</li>";
                });
                $('#test-container').html(aptList + "</ul>");
            }
        });
    // $.ajax({//testing
    //     type: "GET",
    //     url: "/api/apartments.php",
    //     dataType: "json",
    //     async: true,
    //     success: function (res) {
    //         $('#test-container').html(res);
    //         console.log(res['data']);
    //     },
    //     error: function (res) {
    //         console.log('FAIL')
    //     }
    // });
});
