<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>

<body>

<div class="container mt-5" style="max-width: 700px">
    <h2 class="h2 text-center mb-5 border-bottom pb-3">Booking</h2>
    <div id='events'></div>
</div>

{{-- Scripts --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        var SITEURL = "{{ url('/') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var calendar = $('#events').fullCalendar({
            editable: true,
            events: SITEURL + "/event",
            displayEventTime: true,
            defaultView: 'agendaWeek',
            minTime:'08:00:00',
            maxTime:'18:00:00',
            slotDuration:'00:15:00',
            eventRender: function (event, element, view) {
                event.allDay = event.allDay === 'true';
            },
            selectable: true,
            selectHelper: true,
            select: function (start_time, end_time, allDay) {
                var name = prompt('Event Name:');
                if (name) {
                    var start_time = $.fullCalendar.formatDate(start_time, "Y-MM-DD HH:mm:ss");
                    var end_time = $.fullCalendar.formatDate(end_time, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: SITEURL + "/event-actions",
                        data: {
                            name: name,
                            start_time: start_time,
                            end_time: end_time,
                            type: 'create'
                        },
                        type: "POST",
                        success: function (data) {
                            displayMessage("Event created.");
                            calendar.fullCalendar('renderEvent', {
                                id: data.id,
                                title: name,
                                start: start_time,
                                end: end_time,
                                allDay: allDay
                            }, true);
                            calendar.fullCalendar('unselect');
                        }
                    });
                }
            },
            eventClick: function (event) {
                var eventDelete = confirm("Do you want cancel event?");
                if (eventDelete) {
                    $.ajax({
                        type: "POST",
                        url: SITEURL + '/event-actions',
                        data: {
                            id: event.id,
                            type: 'delete'
                        },
                        success: function (response) {
                            calendar.fullCalendar('removeEvents', event.id);
                            displayMessage("Event removed");
                        }
                    });
                }
            }
        });
    });

    function displayMessage(message) {
        toastr.success(message, 'Event');
    }

</script>

</body>

</html>
