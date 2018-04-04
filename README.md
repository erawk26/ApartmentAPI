# ApartmentAPI
A very simple backend 

This was just a simple backend PHP GET API. It will serve cached data to the front end if the data is less than 10min old or if the remote data source is unavailable.

The frontend makes a javascript fetch call to the PHP script then displays the JSON data in a properly sized and labeled table on desktop or a sort of flex-grid on smaller screens.

I chose to build this project entirely without frameworks. I wrote every line of code including the flex mixins. Im certainly not bragging, I just did it to show my personal coding ability without relying on a framework to do something. If you see a way that it can be improved please let me know!
