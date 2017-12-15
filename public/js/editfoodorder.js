$(document).ready(function(){

  $.fn.api.settings.api = {
    'get package food'   : '/getPackageFood',
  };

  $('.ui.calendar.date').calendar({
      // startMode: 'month',
      type: 'date'
  });
  $('.ui.calendar.time').calendar({
      // startMode: 'month',
      type: 'time'
  });

  $('.status').dropdown();

  $('.browse').click(function(){
    $('#addmenu')
        .modal('setting', 'autofocus', false)
        .modal('setting', 'closable', false)
        .modal('setting', 'transition', 'fade up')
        .modal('show');
  });

  var data = $('#addmenu table').DataTable();

  $('#addmenu .addbtn').click(function(){
    var rowcollection =  data.$(".checkbox:checked", {"page": "all"});
    var price , priceVal , name , id;
    for(var i = 0; i < rowcollection.length; i++)
    {
      id = $(rowcollection[i]).closest('tr').find('input.checkbox').val();
      price = $(rowcollection[i]).closest('tr').find('.price').text();
      name = $(rowcollection[i]).closest('tr').find('.name').text();
      priceVal = parseFloat(price.replace(/[^0-9-.]/g, ''));
      $('.foodmenu tbody').append('<tr><td>'+name+'<input type="hidden" name="submenu[]" value="'+id+'"></td><td class="price">'+price+'</td><td><input type="number" name="qty[]" value="1"></td><td><span class="total">'+price+'</span><input type="hidden" name="subtotal[]" value="'+priceVal+'"></td><td><div class="ui negative icon button remove"><i class="delete icon"></i></div></td></tr>');
    }
  });
  Number.prototype.formatMoney = function(c, d, t){
  var n = this, 
      c = isNaN(c = Math.abs(c)) ? 2 : c, 
      d = d == undefined ? "." : d, 
      t = t == undefined ? "," : t, 
      s = n < 0 ? "-" : "", 
      i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
      j = (j = i.length) > 3 ? j % 3 : 0;
     return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
  };
  $(document).on('change','.foodmenu tbody input[name="qty[]"]',function(){
    var total = parseFloat($(this).closest('tr').find('.price').text().replace(/[^0-9-.]/g, '')) * $(this).val();
    $(this).closest('tr').find('.total').html('&#8369; '+(total).formatMoney(2));
    $(this).closest('tr').find('input[name="subtotal[]"]').val(total);
  });
  $(document).on('click','.foodmenu .remove',function(){
    $(this).closest('tr').remove();
  });


  $('.content form').form({
    inline : true,
    fields : {
      date : {
        identifier : 'date' ,
        rules : [{
          type : 'empty',
        prompt : 'Required.'
        }]      
      },
      time : {
        identifier : 'time',
        rules : [{
          type : 'empty',
          prompt : 'Required.'
        }]
      },
      status : {
        identifier : 'status',
        rules : [{
          type : 'empty',
          prompt : 'Required.'
        }]
      },
      address : {
        identifier : 'address',
        rules : [{
          type : 'empty',
          prompt : 'Required.'
        }]
      },
      fname: {
        identifier: 'fname',
        rules: [{
          type: 'empty',
          prompt: 'Required.'
        },
        {
          type   : 'maxLength[20]',
          prompt : 'Maximum of 20 characters only.'
        },
        {
          type   : 'regExp',
          value  : '/^[A-Za-z\ ]*$/',
          prompt : 'Enter a valid name.'
        }]
      },
      lname: {
        identifier: 'lname',
        rules: [{
          type: 'empty',
          prompt: 'Required.'
        },
        {
          type   : 'maxLength[20]',
          prompt : 'Maximum of 20 characters only.'
        },
        {
          type   : 'regExp',
          value  : '/^[A-Za-z\ ]*$/',
          prompt : 'Enter a valid name.'
        }]
      },
      cpnum1: {
        identifier: 'cpnum1',
        rules: [{
          type: 'empty',
          prompt: 'Required.'
        },
        {
          type: 'integer',
          prompt: 'Enter valid mobile number'
        },
        {
          type: 'exactLength[11]',
          prompt: 'Must be 11 digit mobile number'
        }]
      },
      cpnum2: {
        identifier: 'cpnum2',
        optional: true,
        rules: [{
          type: 'integer',
          prompt: 'Invalid.'
        },
        {
          type: 'integer',
          prompt: 'Enter valid mobile number'
        },
        {
          type: 'exactLength[11]',
          prompt: 'Must be 11 digit mobile number'
        },
        {
          type   : 'checkNumber[1]',
          prompt : 'Please put different values for each field'
        }]
      },
      telnum1: {
        identifier: 'telnum1',
        optional: true,
        rules: [{
          type: 'integer',
          prompt: 'Invalid.'
        }]
      },
      telnum2: {
        identifier: 'telnum2',
        optional: true,
        rules: [{
          type: 'integer',
          prompt: 'Invalid.'
        },
        {
          type   : 'checkNumber[2]',
          prompt : 'Please put different values for each field'
        }]
      },
      email: {
        identifier: 'email',
        rules: [{
          type: 'empty',
          prompt: 'Required.'
        },{
          type: 'email',
          prompt: 'Enter valid email address.'
        }]
      }
    }
  });
});
