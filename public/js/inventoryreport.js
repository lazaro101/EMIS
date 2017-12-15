$(document).ready(function(){
  $('.ui.dropdown.status').dropdown();

  $('.ui.calendar').calendar({
      type: 'date',
      today: true,
  });


  
  $('.button.print').click(function(){
    window.open('/Admin/Reports/Inventory_Report?print=pdf&start='+start+'&end='+end,'_blank');
  });
  $('.button.back').click(function(){
    window.open('/Admin/Reports','_self');
  });
  var start = $('.form.filter').form('get value','start');
  var end = $('.form.filter').form('get value','end');


  $.fn.form.settings.rules.checkEnd = function(value) {
    if (new Date($('input[name=start]').val()) > new Date(value) ) {
      return false;
    } else {
      return true;
    }
  };
  $.fn.form.settings.rules.checkStart = function(value) {
    if (new Date($('input[name=end]').val()) < new Date(value) ) {
      return false
    } else {
      return true;
    }
  };
  $('.form.filter').form({
    inline : true,
    fields: {
      start: {
        identifier: 'start',
        rules: [{
          type: 'checkStart',
          prompt: 'Cannot set start date after end date.'
        }]
      },
      end: {
        identifier: 'end',
        rules: [{
          type: 'checkEnd',
          prompt: 'Cannot set end date before start date.'
        }]
      },
    }
  });

  $('.table.list').DataTable();
});

// var chart = AmCharts.makeChart("chartdiv", {
//     "type": "serial",
//     "theme": "patterns",
//     "marginRight": 40,
//     "marginLeft": 40,
//     "autoMarginOffset": 20,
//     "mouseWheelZoomEnabled":true,
//     "dataDateFormat": "YYYY-MM-DD",
//     "valueAxes": [{
//         "id": "v1",
//         "axisAlpha": 0,
//         "position": "left",
//         "ignoreAxisWidth":true
//     }],
//     "balloon": {
//         "borderThickness": 1,
//         "shadowAlpha": 0
//     },
//     "graphs": [{
//         "id": "g1",
//         "balloon":{
//           "drop":true,
//           "adjustBorderColor":false,
//           "color":"#ffffff"
//         },
//         "bullet": "round",
//         "bulletBorderAlpha": 1,
//         "bulletColor": "#FFFFFF",
//         "bulletSize": 5,
//         "hideBulletsCount": 50,
//         "lineThickness": 2,
//         "title": "red line",
//         "useLineColorForBulletBorder": true,
//         "valueField": "value",
//         "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
//     }],
//     "chartScrollbar": {
//         "graph": "g1",
//         "oppositeAxis":false,
//         "offset":30,
//         "scrollbarHeight": 80,
//         "backgroundAlpha": 0,
//         "selectedBackgroundAlpha": 0.1,
//         "selectedBackgroundColor": "#888888",
//         "graphFillAlpha": 0,
//         "graphLineAlpha": 0.5,
//         "selectedGraphFillAlpha": 0,
//         "selectedGraphLineAlpha": 1,
//         "autoGridCount":true,
//         "color":"#AAAAAA"
//     },
//     "chartCursor": {
//         "pan": true,
//         "valueLineEnabled": true,
//         "valueLineBalloonEnabled": true,
//         "cursorAlpha":1,
//         "cursorColor":"#258cbb",
//         "limitToGraph":"g1",
//         "valueLineAlpha":0.2,
//         "valueZoomable":true
//     },
//     "valueScrollbar":{
//       "oppositeAxis":false,
//       "offset":50,
//       "scrollbarHeight":10
//     },
//     "categoryField": "date",
//     "categoryAxis": {
//         "parseDates": true,
//         "dashLength": 1,
//         "minorGridEnabled": true
//     },
//     "export": {
//         "enabled": true
//     },
//     "dataProvider": []
// });
// $.ajax({
//   type: 'get',       
//   url: "/getInventoryReports",
//   data: {start : 'October 1, 2017' , end : 'October 31, 2017'},
//   dataType: 'json',
//   success: function(data) {
//       chart.dataProvider = data;
//       chart.validateNow();
//   }
// });


// chart.addListener("rendered", zoomChart);

// zoomChart();
// function zoomChart() {
//     chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
// }
