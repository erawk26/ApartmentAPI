var aptArr = [];
$(document).ready(function () {
    $.ajax({//production
        type: "GET",
        url: "/api/apartments/",
        dataType: "json",
        async: false,
        success: function (res) {
            aptArr = res['data'];
             console.log(res);
        },
        error: function (res) {
            console.log('FAIL');
            console.log(res);
        }
    })
        .then(function () {
            if (aptArr.length > 0) {
                aptList = "<ul class='apartments'>";
                aptList += "<li>" +
                    "<span class='label name'>Name</span>" +
                    "<span class='label floor'>Floor plan</span>" +
                    "<span class='label beds'>Beds</span>" +
                    "<span class='label baths'>Baths</span>" +
                    "<span class='label rent'>Rent</span>" +
                    "<span class='label apply-link'></span>" +
                    "</li>";
                aptArr.map(function (apt) {
                    var aptName = apt['ApartmentName'],
                        numBeds = apt['Beds'],
                        numBaths = Math.round(apt['Baths']*2)/2,
                        floorName = apt['FloorplanName'],
                        rentMin=parseInt(apt['MinimumRent']),
                        rentMax=parseInt(apt['MaximumRent']),
                        applyLink = apt['ApplyOnlineURL'];
                    aptList += "<li>" +
                        "<span class='name'>" + aptName + "</span>" +
                        "<span class='floor'>" + floorName + "</span>" +
                        "<span class='beds'>" + numBeds + "</span>" +
                        "<span class='baths'>" + numBaths + "</span>" +
                        "<span class='rent'>" + "\$"+rentMin+" - "+rentMax + "</span>" +
                        "<a class='apply-link' target='_blank' href='" + applyLink + "'>Apply Online</a>" +
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
    //         $('#test-container').html(res['data']);
    //         console.log(res['data']);
    //     },
    //     error: function (res) {
    //         $('#test-container').html(res.responseText);
    //         console.log('FAIL\n');
    //     }
    // });
});
