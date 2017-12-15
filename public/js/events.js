  $(document).ready(function() {
    
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay,listMonth'
      }, 
      // defaultDate: '2017-06',
      // contentHeight: '500px', 
      aspectRatio: 1,
      navLinks: true, // can click day/week names to navigate views
      // editable: true,
      eventLimit: true, // allow "more" link when too many events
      rendering: 'inverse-background',
      eventColor: 'rgb(251,189,8)',
      // eventTextColor: 'black',
      events: function(start, end, timezone, callback) {
        $.ajax({
          url: '/getEvents',
          type: 'get',
          dataType: 'json',
          success: function(response) {  
            var events = [];
            response.forEach(function(data){
              var color = '';
              // var textcolor = '';
              if (data.status == 'Completed') {
                color = 'rgb(33,133,208)';
              } else if(data.status == 'Cancelled') {
                color = 'rgb(219,40,40)';
              } else if(data.status == 'Booked') {
                color = 'rgb(33,186,69)';
              }
              events.push({
                id: data.event_reservation_id,
                title: data.event_name,
                start: data.event_date+'T'+data.event_time,
                color: color,
                // textColor: textcolor,
                url: 'Event-Reservation?eventdetails=edit&id='+data.event_reservation_id,
              });
            });
            callback(events);
          }
        });
      }
    });
      
});