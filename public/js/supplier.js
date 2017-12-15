$(document).ready(function(){

  $('#addform form').form({
    inline: true,
    fields: {
      name: {
        identifier: 'name',
        rules: [
        {
          type: 'empty',
          prompt: 'Required.'
        }]
      },
      contact: {
        identifier: 'contact',
        rules: [
        {
          type: 'empty',
          prompt: 'Required.'
        },
        {
          type: 'number',
          prompt: 'Enter a valid contact.'
        }]
      },
    }
  });
  $('#editform form').form({
    inline: true,
    fields: {
      name: {
        identifier: 'name',
        rules: [
        {
          type: 'empty',
          prompt: 'Required.'
        }]
      },
      contact: {
        identifier: 'contact',
        rules: [
        {
          type: 'empty',
          prompt: 'Required.'
        },
        {
          type: 'number',
          prompt: 'Enter a valid contact.'
        }]
      },
    }
  });

  $('#addform .addbtn').click(function(){
    $('#addform form').form('validate form');
    if ($('#addform form').form('is valid') == true) {
      return true;
    }
    return false;
  });
  $('#addform .cancelbtn').click(function(){
    $('#addform form').form('reset');
  });
  $('#editform .addbtn').click(function(){
    $('#editform form').form('validate form');
    if ($('#editform form').form('is valid') == true) {
      return true;
    }
    return false;
  });
  $('#editform .cancelbtn').click(function(){
    $('#editform form').form('reset');
  });

  $('.table-cont .delete.button').click(function(e){
    var id = $(this).data('id');
    var item = $(this).closest('tr').find('.name').text();
    $('.ui.basic.modal span.item').text(item);
    $('.ui.basic.modal')
      .modal({
        closable  : false,
        onApprove : function() {
          $('#delete').form('set value','id',id);
          $('#delete').submit();
        }
      })
    .modal('show');
    e.preventDefault();
  });

  $.fn.api.settings.api = {
    'retrieve supplier' : '/retrieveSupplier',
  };
  $('.edit').api({
    action: 'retrieve supplier',
    method: 'get',
    beforeSend: function(settings) {
      settings.data = {
        ID: $(this).data('id')
      };
      return settings;
    },
    onSuccess: function(data) {
      $('#editform form')
        .form('set values', {
          id     : data.supplier_id,
          name : data.supplier_name,
          contact : data.supplier_contact,
      });
    },
    onComplete: function(response) {
      $('#editform')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'scale')
        .modal('show');
    },
  });

  $('.addsup').click(function(){
    $('#addform')
      .modal('setting', 'autofocus', false)
      .modal('setting', 'closable', false)
      .modal('setting', 'transition', 'fade up')
      .modal('show');
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

  $('.table-cont table').DataTable();
});
