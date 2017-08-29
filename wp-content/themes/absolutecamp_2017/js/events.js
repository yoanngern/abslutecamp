window.events = [];


$(document).ready(function () {

    HandlebarsIntl.registerWith(Handlebars);


    getEventsNew();

    /*
    $("#listOfEvents").each(function () {
        var nb = $(this).attr("data-nb");

        getEvents(nb);
    });
    */

});

function getEventsNew() {

    //var url = "/wp-json/wp/v2/events/?filter[orderby]=order&order=asc";

    var url = "http://healing-ministries.org/wp-json/wp/v2/events/?filter[orderby]=order&order=asc";

    $.ajax({
        type: "GET",
        url: url,
        async: true,
        jsonpCallback: 'callback',
        contentType: "application/json",
        dataType: 'json',
        'timeout': 4000,
        error: function () {
            console.log("error");
        },
        success: function (data) {

            console.log(data);

            $(data).each(function () {
                var event = {};

                event.id = this.id;
                event.title = this.title.rendered;
                event.link = this.link;

                if(this.better_featured_image) {
                    event.image = this.better_featured_image.media_details.sizes.card.source_url;
                } else {
                    event.image = "";
                }

                event.date_start = new Date(this.event_start_date);
                event.date_end = new Date(this.event_end_date);

                events.push(event);

            });


            printEvents(events);

        }
    });

}

function getEvents(nb) {


    var url = "/wp-json/ee/v4.8.36/events?include=Datetime&calculate=image_full&order_by=Datetime.DTT_EVT_start&order=ASC";

    url += "&filter[date_query][before]=NOW";

    $.ajax({
        type: "GET",
        url: url,
        async: true,
        jsonpCallback: 'callback',
        contentType: "application/json",
        dataType: 'json',
        'timeout': 4000,
        error: function () {
            console.log("error");
        },
        success: function (data) {

            $(data).each(function () {
                var event = {};

                event.id = this.EVT_ID;
                event.title = this.EVT_name;
                event.link = this.link;

                if (this._calculated_fields.image_full != null) {
                    event.image = this._calculated_fields.image_full.url;
                }

                event.date_start = new Date(this.datetimes[0].DTT_EVT_start);
                event.date_end = new Date(this.datetimes[0].DTT_EVT_end);

                event.timestamp = event.date_start;

                var now = new Date();

                if (event.date_start > now) {
                    events.push(event);
                }


            });



            if (nb !== null && nb !== 999 ) {
                limitEvents(events, nb);
            }


            printEvents(events);


        }
    });

}


function limitEvents(events, nb) {

    events.length = nb;

    return events;
}


function printEvents(events) {
    var context = {
        events: events
    };

    var intlData = {
        "locales": "fr-FR"
    };

    var container = $("#listOfEvents .insert");

    var source = $("#eventsList").html();
    var template = Handlebars.compile(source);
    var html = template(context, {
        data: {intl: intlData}
    });

    $(container).html(html);
}