$(document).ready(function(){
  $('.ui.accordion').accordion();
  $('.ui.calendar').calendar({
      today: true,
      type: 'date'
  });
  $('table').tablesort();

  $('.ui.dropdown.status').dropdown();

  $('.table-cont .edit').click(function(){
    $('#editform form').form('set value','id',$(this).closest('td').data('id'));
    $('#editform')
      .modal('show')
      .modal('setting','autofocus',false);
  });
  $('.table-cont .delete').click(function(){
    var id = $(this).closest('td').data('id');
    $('.ui.basic.modal')
      .modal({
        closable  : false,
        onApprove : function() {
          $('#deleteform').form('set value','id',id);
          $('#deleteform').submit();
        }
      })
    .modal('show');
    e.preventDefault();
  });
  $('#editform form').form({
    inline: true,
    fields: {
      status : {
        identifier : 'status',
        rules : [{
          type : 'empty',
          prompt : 'Required.'
        }] 
      }
    }
  });
  $('#editform .submit.button').click(function(){
    if ($('#editform form').form('is valid') == false) {
      $('#editform form').form('validate form');
      return false;
    }
    return true;
  });
  var ts ="";
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
