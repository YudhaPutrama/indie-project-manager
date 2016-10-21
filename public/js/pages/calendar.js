var Calendar = function() {


    return {
        //main function to initiate the module
        init: function() {
            Calendar.initScheduleView();
            Calendar.initScheduleRequest();
        },

        initScheduleView: function(){
            if (!jQuery().fullCalendar) {
                return;
            }

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var calendar = $('.schedule-view');

            var h = {};
            if (calendar.parents(".portlet").width() <= 720) {
                calendar.addClass("mobile");
                h = {
                    left: 'title, prev, next',
                    center: '',
                    right: 'today,month'
                };
            } else {
                calendar.removeClass("mobile");
                h = {
                    left: 'title',
                    center: '',
                    right: 'prev,next,today,month'
                };
            }

            calendar.fullCalendar('destroy'); // destroy the calendar
            calendar.fullCalendar({ //re-initialize the calendar
                header: h,
                defaultView: 'month',
                editable: false,
                droppable: false,
                timeFormat: '',
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: window.location.pathname+'/data',
                        type: 'GET',
                        success: function(doc) {
                            var events = [];
                            $(doc).each(function() {
                                var status=$(this).attr('status');
                                var color;
                                //alert(status);
                                if(status=='pending'){
                                    color = Metronic.getBrandColor('yellow')
                                }else if(status=='ongoing'){
                                    color = Metronic.getBrandColor('green')
                                }else if (status=='done'){
                                    color = Metronic.getBrandColor('blue')
                                }
                                events.push({
                                    title: $(this).attr('event'),
                                    start: $(this).attr('start'), // will be parsed
                                    end: $(this).attr('end'), // will be parsed
                                    color: color
                                });
                            });
                            callback(events);
                        }
                    });
                }
            });
        },

        initScheduleRequest: function() {

            if (!jQuery().fullCalendar) {
                return;
            }

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var calendar = $('.schedule-request');

            var h = {};
            if (calendar.parents(".portlet").width() <= 720) {
                calendar.addClass("mobile");
                h = {
                    left: 'title, prev, next',
                    center: '',
                    right: 'today,month'
                };
            } else {
                calendar.removeClass("mobile");
                h = {
                    left: 'title',
                    center: '',
                    right: 'prev,next,today,month'
                };
            }

            calendar.fullCalendar('destroy'); // destroy the calendar
            calendar.fullCalendar({ //re-initialize the calendar
                header: h,
                defaultView: 'month', // change default view with available options from http://arshaw.com/fullcalendar/docs/views/Available_Views/
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function(date, allDay) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');
                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.className = $(this).attr("data-class");

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    calendar.fullCalendar('renderEvent', copiedEventObject, true);


                    $(this).remove();

                },

                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: window.location.pathname+'/data',
                        type: 'GET',
                        success: function(doc) {
                            var events = [];
                            $(doc).each(function() {
                                events.push({
                                    title: $(this).attr('event'),
                                    start: $(this).attr('start') // will be parsed
                                });
                            });
                            callback(events);
                        }
                    });
                }
                // events: {
                //     url: window.location.pathname,
                //     type: 'POST',
                //     data: {
                //         custom_param1: 'something',
                //         custom_param2: 'somethingelse'
                //     },
                //     error: function() {
                //         alert('there was an error while fetching events!');
                //     },
                //     color: 'yellow',   // a non-ajax option
                //     textColor: 'black' // a non-ajax option
                // }
            });

            var initDrag = function(el) {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim(el.text()) // use the element's text as the event title
                };
                // store the Event Object in the DOM element so we can get to it later
                el.data('eventObject', eventObject);
                // make the event draggable using jQuery UI
                el.draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });
            };

            var addEvent = function(title) {
                title = title.length === 0 ? "Untitled Event" : title;
                var html = $('<div class="external-event label label-default">' + title + '</div>');
                jQuery('#event_box').append(html);
                initDrag(html);
            };

            $('#external-events div.external-event').each(function() {
                initDrag($(this));
            });

            $('#event_add').unbind('click').click(function() {
                var title = $('#event_title').val();
                addEvent(title);
            });

            //predefined events
            $('#event_box').html("");
            addEvent("My Event 1");
            addEvent("My Event 2");
            addEvent("My Event 3");
            addEvent("My Event 4");
            addEvent("My Event 5");
            addEvent("My Event 6");

        }

    };

}();