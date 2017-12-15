$(document).ready(function(){

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

  $('.table-cont .button.edit').click(function(){
    var pid = $(this).data('id');
    $.ajax
    ({
      url: '/getPayment',
      type: 'get',
      data: { id : $(this).data('id') },
      success:function(response){
        if (response.location_total == null) {
          var loctot = 0;
        } else {
          var loctot = response.location_total;
        }
        $('.long.modal .menu').text('₱ '+response.menu_total.formatMoney(2));
        $('.long.modal .addons').text('₱ '+response.addons_total.formatMoney(2));
        $('.long.modal .venue').text('₱ '+loctot.formatMoney(2));
        $('.long.modal .services').text('₱ '+response.services_total.formatMoney(2));
        $('.long.modal .extra').text('₱ '+response.extra_cost_total.formatMoney(2));
        $('.long.modal .total').text('₱ '+response.grand_total.formatMoney(2));
        $('.long.modal .balance').text('₱ '+(response.grand_total-response.amt_paid).formatMoney(2));
        $('.long.modal p.pid').text(pid);
        $('.long.modal form').form('set value','pid',pid);
      },
      complete:function(){
        $('.long.modal')
          .modal('setting', 'autofocus', false)
          .modal('setting', 'closable', false)
          .modal('setting', 'transition', 'fade up')
          .modal('show');
      }
    });
  });

  $('.full').click(function(){
    $('.long.modal form').form('set value','amount',parseFloat($('.long.modal .balance').text().replace(/[^0-9-.]/g, '')));
  });

  $('.long.modal .positive').click(function(){
    $('.long.modal form').form('validate form');
    if ($('.long.modal form').form('is valid')) {
      return true;
    } else {
      return false;
    }
  });
  $('.long.modal .deny').click(function(){
    $('.long.modal form').form('reset');
  });

  $.fn.form.settings.rules.checkAmt = function(value) { 
    var bal = parseFloat($('.long.modal .balance').text().replace(/[^0-9-.]/g, ''));
    if (value > bal) {
      return false;
    } else {
      return true;
    }
  };
  $('.long.modal form').form({
    inline: true,
    fields: {
      amount: {
        identifier: 'amount',
        rules: [{
          type : 'empty',
          prompt : 'Required.'
        },
        {
          type : 'decimal',
          prompt : 'Enter a valid value,'
        },
        {
          type : 'checkAmt',
          prompt : 'Must not be greater than the current balance.'
        }] 
      }
    }
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

  $('.main.table').DataTable();
});
