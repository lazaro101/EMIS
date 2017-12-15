$(document).ready(function(){
  $('table').tablesort();
  $('.ui.accordion').accordion();
  $('.ui.dropdown.status').dropdown();
  $('.ui.calendar').calendar({
      type: 'date',
      today:true,
  });

  $('.table-cont .delete.button').click(function(e){
    var id = $(this).data('id');
    var item = $(this).closest('tr').find('.name').text();
    $('.ui.basic.modal span.item').text(item);
    $('.ui.basic.modal')
      .modal({
        closable  : false,
        onApprove : function() {
          $('#deleteReservation').form('set value','id',id);
          $('#deleteReservation').submit();
        }
      })
    .modal('show');
    e.preventDefault();
  });

  //------------------Message Box ------------------------//
  var tm = setTimeout(function(){ $('.ui.msgbox.scsmsg').transition('fade'); }, 5000);
  $('#close1').on('click', function() {
    clearTimeout(tm);
    $(this)
      .closest('.msgbox.scsmsg')
      .transition('fade');
  });
  $('#close').on('click', function() {
    clearTimeout(ts);
    $(this)
      .closest('.msgbox.valmsg')
      .transition('fade');
  });


});
