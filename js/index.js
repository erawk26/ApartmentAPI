"use strict";
(function () {
	fetch("/api/events/")
		.then(function (response) {
			return response.json();
		})
		.then(function (obj) {
			document.getElementById('event-container').innerHTML = obj.JSON.stringify();
			console.log('success');
			console.table(obj);
		})
		.catch(function (err) {
			document.getElementById('event-container').innerHTML = err;
			console.log('FAIL');
			console.table(err);
		});
    fetch("/api/apartments/")
        .then(function (response) {
            return response.json();
        })
        .then(function (obj) {
            aptArr = obj.data;
            if (aptArr.length > 0) {
                aptList = "<ul class='apartments'>";
                aptList += "<li class='desktop-labels'>" +
                    "<div class='label name'>Name</div>" +
                    "<div class='label floor'>Floor Plan</div>" +
                    "<div class='label beds'>Beds</div>" +
                    "<div class='label baths'>Baths</div>" +
                    "<div class='label rent'>Rent</div>" +
                    "<div class='label apply'></div>" +
                    "</li>";
                aptArr.map(function (apt) {
                    var aptName = apt.ApartmentName,
                        numBeds = apt.Beds,
                        numBaths = Math.round(apt.Baths * 2) / 2,
                        floorName = apt.FloorplanName,
                        rentMin = parseInt(apt.MinimumRent),
                        rentMax = parseInt(apt.MaximumRent),
                        applyLink = apt.ApplyOnlineURL;
                    aptList += "<li>" +
                        "<div class='name'><span class='mobile-label'>Name:</span>" + aptName + "</div>" +
                        "<div class='floor'><span class='mobile-label'>Floor Plan:</span>" + floorName + "</div>" +
                        "<div class='beds'><span class='mobile-label'>Beds:</span>" + numBeds + "</div>" +
                        "<div class='baths'><span class='mobile-label'>Baths:</span>" + numBaths + "</div>" +
                        "<div class='rent'><span class='mobile-label'>Rent:</span>" + "\$" + rentMin + " - \$" + rentMax + "</div>" +
                        "<div class='apply'><a role='button' target='_blank' href='" + applyLink + "'>Apply Online</a></div>" +
                        "</li>";
                });
                document.getElementById('apt-container').innerHTML = aptList + "</ul>";
            }
        })
        .catch(function (err) {
            document.getElementById('apt-container').innerHTML = err;
            console.log('FAIL');
            console.table(err);
        });
})();

