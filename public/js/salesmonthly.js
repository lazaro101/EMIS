$(document).ready(function(){
  $('.ui.dropdown.status').dropdown();

  $('.ui.calendar').calendar({
      type: 'date',
      today: true,
  });

  var start = $('.form.filter').form('get value','start');
  var end = $('.form.filter').form('get value','end');
  $('.button.print').click(function(){
    window.open('/Admin/Reports/Inventory_Report?print=pdf&start='+start+'&end='+end,'_blank');
  });
  $('.button.back').click(function(){
    window.open('/Admin/Reports','_self');
  });


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
