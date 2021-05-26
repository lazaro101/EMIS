$(document).ready(function(){

  $(document).on('change','input[name="qty[]"]',function(){
    $(this).closest('.field').removeClass('error');
  });

  // $.ajax
  // ({
  //   url: '/getEventNow',
  //   type: 'get',
  //   data: { date : $("input[name=eventdate]").val() },
  //   success:function(response){
  //     $('input[name=eventcount]').val(response);
  //   }
  // });
  // $('input[name=eventdate]').change(function(){
  //   $.ajax
  //   ({
  //     url: '/getEventNow',
  //     type: 'get',
  //     data: { date : $("input[name=eventdate]").val() },
  //     success:function(response){
  //       $('input[name=eventcount]').val(response);
  //     }
  //   });
  // });

  $('.form.main').submit(function(e){
    var error = 0;
    var datecnt = 0;
    // var date = ;
    // alert($('input[name=eventcount]').val());

    if ($('input[name=shrs]').length > 0){
      $('input[name=shrs]').each(function(){
        if ($(this).val() <= 0) {
          $(this).closest('.field').addClass('error');
          error = 1;
        }
      });
    }
    if ($('input[name="qty[]"]').length > 0){
      $('input[name="qty[]"]').each(function(){
        if ($(this).val() <= 0) {
          $(this).closest('.field').addClass('error');
          error = 2;
        }
      });
    }
    if (!$('.form.main').form('is valid')) {
      swal("Error submitting form!", "You have field/s with error." ,"error");
      $('.cont').scrollTop(200);
      e.preventDefault();
    // } else if ($('input[name=eventcount]').val() > 0) {
    //   swal("Conflicting Events!", "ABCDEFG." ,"warning");
    //   $('.cont').scrollTop(200);
    //   e.preventDefault();
    } else if ($('input[name=pkgid]').val() == "") {
      swal("Package required!", "No package selected." ,"error");
      $('.cont').scrollTop(800);
      e.preventDefault();
    } else if (error == 1) {
      swal("Column hour/s on other additional charges!", "Enter a valid value." ,"error");
      $('.cont').scrollTop(1100);
      e.preventDefault();
    } else if (error == 2) {
      swal("Column quantity on inventory checklist!", "Enter a valid value." ,"error");
      $('.cont').scrollTop(1300);
      e.preventDefault();
    } else {
      // if ($('input[name=eventcount]').val() > 0) {
      //   swal({
      //     title: "Conflicting Events",
      //     text: "You have Conflicting event/s on this day!",
      //     icon: "warning",
      //     buttons: true,
      //     dangerMode: true,
      //   })
      //   .then((willDelete) => {
      //     if (willDelete) {
            $(this).unbind('submit').submit()
          // } else {
          //   e.preventDefault();
          // }
        // });
        // $('.cont').scrollTop(200);
      // }
    }
  });

  $('.drpdwn').dropdown();
  
  $.fn.api.settings.api = {
    'get package food'   : '/getPackageFood',
    'get category' : '/getCategory',
    'get food'   : '/getFood',
    'get package food'   : '/getPackageFood',
    'get service contact'   : '/getServiceContact',
    'get package'   : '/retrievePackage',
    'get menu catering'   : '/getMenuCatering',
    'get task'   : '/getTask',
    'get extra'   : '/getExtraCost',
  };

  $('.ui.calendar.date').calendar({
      type: 'date',
      today: true,
  });
  
  $('.ui.calendar.time').calendar({
      type: 'time'
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

  $('.button.checked').click(function(){
    $('.ui.calendar.modal').modal('show');
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay,listMonth'
      }, 
      // defaultDate: '2017-06',
      contentHeight: 800, 
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

  //----------------------------------VALIDATIONS-----------------------------------------------------
  $.fn.form.settings.rules.checkNum = function(value,checkNum) { 
    if (checkNum == 1) {
      if ($('.content form').form('get value','cpnum1') == value) {
        return false
      }
    } else {
      if ($('.content form').form('get value','telnum1') == value) {
        return false
      }
    }
    return true;
  };
  function formatTime(value){
    var hours = Number(value.match(/^(\d+)/)[1]);
    var minutes = Number(value.match(/:(\d+)/)[1]);
    var AMPM = value.match(/\s(.*)$/)[1].toLowerCase();

    if (AMPM == "pm" && hours < 12) hours = hours + 12;
    if (AMPM == "am" && hours == 12) hours = hours - 12;
    var sHours = hours.toString();
    var sMinutes = minutes.toString();
    if (hours < 10) sHours = "0" + sHours;
    if (minutes < 10) sMinutes = "0" + sMinutes;

    return sHours +':'+sMinutes; 
  }
  $.fn.form.settings.rules.checkEnd = function(value) {
    if (formatTime(value) < formatTime($('input[name=eventtime]').val())) {
      return false
    } else {
      return true;
    }
  };
  $.fn.form.settings.rules.checkStart = function(value) {
    if (formatTime(value) > formatTime($('input[name=eventtime]').val())) {
      return false
    } else {
      return true;
    }
  };

  $('.content form').form({
    inline : true,
    fields: {
      eventname: {
        identifier: 'eventname',
        rules: [{
          type: 'empty',
          prompt: 'Event name is required.'
        }]
      },
      eventdate: {
        identifier: 'eventdate',
        rules: [{
          type: 'empty',
          prompt: 'Required.'
        }]
      },
      eventtime: {
        identifier: 'eventtime',
        rules: [{
          type: 'empty',
          prompt: 'Required.'
        }]
      },
      endtime: {
        identifier: 'endtime',
        depends: 'eventtime',
        rules: [{
          type: 'checkEnd',
          prompt: 'End time cannot be set before the event time.'
        }]
      },
      setuptime: {
        identifier: 'setuptime',
        depends: 'eventtime',
        rules: [{
          type: 'checkStart',
          prompt: 'Setup time cannot be set after the event time.'
        }]
      },
      guestcount: {
        identifier: 'guestcount',
        rules: [{
          type: 'empty',
          prompt: 'Enter a valid value.'
        },
        {
          type: 'integer',
          prompt: 'Enter a valid value.'
        },
        {
          type: 'doesntContain[-]',
          prompt: 'Enter a valid value.'
        }]
      },
      occassion: {
        identifier: 'occassion',
        rules: [{
          type: 'empty',
          prompt: 'Required.'
        },
        {
          type   : 'maxLength[20]',
          prompt : 'Maximum of 20 characters only.'
        }]
      },
      motif: {
        identifier: 'motif',
        rules: [{
          type   : 'maxLength[20]',
          prompt : 'Maximum of 20 characters only.'
        }]
      },
      venue: {
        identifier: 'venue',
        rules: [{
          type: 'empty',
          prompt: 'Required.'
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
          type   : 'checkNum[1]',
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
          type   : 'checkNum[2]',
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
      },
    }
  });
  
  //-----------------------------------end validation-------------------------------------------------

  var optionCtgry = "";
  $.ajax
  ({
    url: '/getCategory',
    type:'get',
    dataType : 'json',
    success:function(response) {
      response.forEach(function(data) {
        optionCtgry += '<option value="'+data.submenu_category_id+'">'+data.submenu_category_name+'</option>';
      });
    }
  });
  var optionPkg = "";
  $.ajax
  ({
    url: '/getPackage',
    type:'get',
    dataType : 'json',
    success:function(response) {
      response.forEach(function(data) {
        optionPkg += '<div class="item" data-value="'+data.package_id+'">'+data.package_name+'</div>';
      });
    // $('.ui.dropdown.pkg').append(optionPkg);
    $('#selpkg .menu').append(optionPkg);
    }
  });
  var foodid = 0;

  //------------------------------Add / Modify Menu ---------------------------------------------------------//
  $('#addmenu table').DataTable();

  $("#addmenu form").submit(function(e){
      e.preventDefault();
  });

  $('.addmenu').click(function(){
    if ($('.menu-table input[name=pkgid]').val() == "") {
      $('#addmenu .pkg-cont').transition('show');
      $('#addmenu .second.segment').transition('hide');
      $('#addmenu')
        .modal('setting', 'autofocus', false)
        .modal('setting', 'closable', false)
        .modal('setting', 'transition', 'fade up')
        .modal('show');
    } else {
      var mf = [];
      var af = [];
      $(".menu-table input[name='menu[]']").map(function() {
        mf.push($(this).val());
      }).get();
      $(".menu-table input[name='addons[]']").map(function() {
        af.push($(this).val());
      }).get();

      $.ajax
      ({
        url: '/getMenuCatering',
        type:'get',
        data: { 
          pkgid : $('.menu-table input[name=pkgid]').val(),
          mf : mf ,
          af : af ,
        },
        dataType : 'json',
        success:function(response) {
          $('#addmenu .second.segment h2.header').text(response[0].package_name);
          $('#addmenu input[name=packid]').val(response[0].package_id);
          response[1].forEach(function(data) {
            addfood('four',foodid,'#menu-cont','menu');
            $('#menu-cont .ctgry'+foodid).dropdown('set selected',data.submenu_category_id);
            var fd = foodid;
            $('#addmenu .food'+fd).addClass('loading');
            $(this).api({
              action: 'get food',
              method: 'get',
              beforeSend: function(settings) {
                settings.data = {
                  ctgry_id: data.submenu_category_id
                };
                return settings;
              },
              onSuccess: function(response) {
                var foodopt = "";
                response.forEach(function(data) {
                  foodopt += '<option value="'+data.submenu_id+'">'+data.submenu_name+'</option>';
                });
                // $('#food'+fd).append(foodopt);
              },
              onComplete: function(response) {
                setTimeout(function(){ 
                  $('#addmenu .food'+fd).dropdown('set selected',data.submenu_id);
                  $('#addmenu .food'+fd).removeClass('loading');
                }, 00);
              },
            }).api('query');
            foodid++;
          });
          if (response[2] != "") {
            response[2].forEach(function(data) {
              addfood('four',foodid,'#add-ons','addons');
              $('#add-ons .ctgry'+foodid).dropdown('set selected',data.submenu_category_id);
              var fd = foodid;
              $('#addmenu .food'+fd).addClass('loading'); $('#add-ons .div'+fd).append('<button class="ui orange labeled icon button remove" data-id="'+foodid+'" type="button"><i class="remove circle icon"></i>REMOVE</button>');
              $(this).api({
                action: 'get food',
                method: 'get',
                beforeSend: function(settings) {
                  settings.data = {
                    ctgry_id: data.submenu_category_id
                  };
                  return settings;
                },
                onSuccess: function(response) {
                  var foodopt = "";
                  response.forEach(function(data) {
                    foodopt += '<option value="'+data.submenu_id+'">'+data.submenu_name+'</option>';
                  });
                 
                  // $('#food'+fd).append(foodopt);
                },
                onComplete: function(response) {
                  setTimeout(function(){ 
                    $('#addmenu .food'+fd).dropdown('set selected',data.submenu_id);
                    $('#addmenu .food'+fd).removeClass('loading');
                  }, 00);
                },
              }).api('query');
              foodid++;
            });
          }
        },
        complete:function(){
          $('#addmenu .second.segment').transition('show');
          $('#addmenu')
            .modal('setting', 'autofocus', false)
            .modal('setting', 'closable', false)
            .modal('setting', 'transition', 'fade up')
            .modal('show');
          $('#addmenu .pkg-cont').transition('hide');
        }
      }); 
    }
  });
  $('#addmenu .actions .chngpkg').click(function(){
    $('#addmenu .second.segment').transition({
      animation  : 'fade out',
      onComplete : function() {
        $('#addmenu .pkg-cont').transition('fade in');
      }
    });
  });

  $('#addmenu .fixpkg')
    .api({
      action: 'get package food',
      method: 'get',
      beforeSend: function(settings) {
        settings.data = {
          ID:$(this).data('id')
        };
        return settings;
      },
      onSuccess: function(response) {
        $('#menu-cont .fields').remove();
        response.forEach(function(data) {
          for(var j=data.qty;j!=0;j--){
            addfood('four',foodid,'#menu-cont','menu');
            $('#menu-cont .ctgry'+foodid).addClass('disabled');
            $('#menu-cont .ctgry'+foodid).dropdown('set selected',data.submenu_category_id);
            foodid++;
          }
        });
      },
      onComplete: function(){
        $('#menu-cont .fields').remove();
        $('#add-ons .fields').remove();
        $('#addmenu input[name=packid]').val($(this).data('id'));
        var name = $(this).closest('tr').find('.name').text();
        $('#addmenu .second.segment .ui.centered.header').text(name);
        $('#addmenu .pkg-cont').transition({
          animation  : 'fade out',
          onComplete : function() {
            $('#addmenu .second.segment').transition('fade in');
          }
        });
      },
    });

  $('#addmenu').on('change','.cha',function(){
    var k = $(this).find('select').data('id');
    var ctgry_id = $('#ctgry'+k).val();
    $('#food'+k).dropdown('restore defaults');
    var option = "";
    $('#food'+k).empty();
    $.ajax
    ({
      type:'get',
      url: '/getFood',
      data: {'ctgry_id':ctgry_id},
      success:function(response) {
        $('#food'+k).append('<option value="">Food</option>');
        response.forEach(function(data) {
          option += '<option value="'+data.submenu_id+'">'+data.submenu_name+'</option>';
        });
        $('#food'+k).append(option);
      }
    });
  });

  //----------------add food button-------------------------------//
  $('.addfood').click(function(){
    if ($('#add-ons div.fields').length >= 10) {
      return false;
    }
    foodid++;
    addfood('four',foodid,'#add-ons','addons');
    $('#add-ons .div'+foodid).append('<button class="ui orange labeled icon button remove" data-id="'+foodid+'" type="button"><i class="remove circle icon"></i>REMOVE</button>');
    $('#add-ons .div'+foodid).transition('jiggle');
  });

  $(document).on('click','#add-ons button.remove',function(){
    var l = $(this).data('id') ; 
    $('#add-ons .fields.div'+l).transition({
        animation  : 'fly up',
        onComplete : function() {
          $(this).remove();
        }
    });
  });

  $(document).on('change','.field',function(){
    $('#addmenu .field').removeClass('error');
  });

  $('#addmenu .addbtn').click(function(){
    var same = 0,none = 0, x = [];
    var count = 0;
    var valid = true;
    $('select[name="menuFood[]"] option:selected').each(function() {
      x.push($(this).val());
      if ($(this).val() == "") {
        $(this).closest('.field').addClass('error');
        none = 1;
      }
    });
    $('select[name="addonsFood[]"] option:selected').each(function() {
      x.push($(this).val());
      if ($(this).val() == "") {
        $(this).closest('.field').addClass('error');
        none = 1;
      }
    });
    $('select[name="menuFood[]"] option:selected').each(function() {
      console.log($(this).val());
      if ($(this).val() != "") {
        for (var u=0;u<x.length;u++){
          if ($(this).val() == x[u]){
            count += 1;
          }
        }
        if (count >= 2){
          $(this).closest('.field').addClass('error');
          same = 1;
        }
        count = 0;
      }
    });
    $('select[name="addonsFood[]"] option:selected').each(function() {
      if ($(this).val() != "") {
        for (var u=0;u<x.length;u++){
          if ($(this).val() == x[u]){
            count += 1;
          }
        }
        if (count >= 2){
          $(this).closest('.field').addClass('error');
          same = 1;
        }
        count = 0;
      }
    });
    if (none == 1) {
      swal('Food Column','Cannot have empty value.','error');
      valid = false;
    }
    if (same == 1) {
      swal('Food Column','Cannot have same food name.','error');
      valid = false;
    }
    if (valid) {
      var mf = [];
      var af = [];
      $("#addmenu select[name='menuFood[]']").map(function() {
        mf.push($(this).val());
      }).get();
      $("#addmenu select[name='addonsFood[]']").map(function() {
        af.push($(this).val());
      }).get();
      $.ajax
      ({
        url: '/saveCateringMenu',
        type: 'get',
        data: {
          pkgid: $('#addmenu input[name=packid]').val(),
          mf: mf,
          af: af
        },
        success:function(response){
          $('.menu-table tbody').empty();
          // response[0].forEach(function(data){
            $('.menu-table .pkgname').text(response[0].package_name);
          // });
          response[1].forEach(function(data){
            $('.menu-table tbody').append('<tr><td>'+data.submenu_name+'<input type="hidden" name="menu[]" value="'+data.submenu_id+'"></td><td class="four wide">'+data.submenu_category_name+'</td></tr>');
          });
          if (response[2] != "") {
            $('.menu-table tbody').append('<tr><td colspan="2" class="center aligned">Addons:</td></tr>');
            response[2].forEach(function(data){
              $('.menu-table tbody').append('<tr><td>'+data.submenu_name+'<input type="hidden" name="addons[]" value="'+data.submenu_id+'"></td><td class="four wide">'+data.submenu_category_name+'</td></tr>');
            });
          }
        },
        complete:function(){
          $('.menu-table input[name=pkgid]').val($('#addmenu input[name=packid]').val());
          $('#menu-cont .fields').remove();
          $('#add-ons .fields').remove();
          $('#addmenu .pkg-cont').transition('show');
          $('#addmenu .second.segment').transition('hide');
          foodid = 0;
        }
      });
    } else {
      return false;
    }
  });  

  $('#addmenu .cancelbtn').click(function(){
    $('#menu-cont .fields').remove();
    $('#add-ons .fields').remove();
    $('#addmenu .pkg-cont').transition('show');
    $('#addmenu .second.segment').transition('hide');
    foodid = 0;
    $('#addmenu input[name=packid]').val('');
  });

  function addfood(numfld,n,cont,input){
    var div1 = document.createElement("div");
    div1.setAttribute('class', numfld+' fields div'+n);
    $(cont).append(div1);

    var ctgrydiv = document.createElement("div");
    ctgrydiv.setAttribute('class','five wide column field subdiv1'+n);
    $(cont+' .div'+n).append(ctgrydiv);

    var fooddiv = document.createElement("div");
    fooddiv.setAttribute('class','five wide column field subdiv2'+n);
    $(cont+' .div'+n).append(fooddiv);

    var pricediv = document.createElement("div");
    pricediv.setAttribute('class','two wide column field subdiv3'+n);
    $(cont+' .div'+n).append(pricediv);

    var newD = document.createElement("select");
    newD.setAttribute('id','ctgry'+n);
    newD.setAttribute('class','ui search cha dropdown ctgry'+n);
    // newD.setAttribute('name','menuCtgrys[]');
    newD.setAttribute('data-id',n);
    $(cont+' .subdiv1'+n).append(newD); 
    
    var newF = document.createElement("select");
    newF.setAttribute('id','food'+n);   
    newF.setAttribute('class','ui search dropdown food'+n);
    newF.setAttribute('name',input+'Food[]');
    $(cont+' .subdiv2'+n).append(newF);

    $(cont+' #ctgry'+n).append("<option value=''>Category</option>");
    $(cont+' #food'+n).append("<option value=''>Food</option>");

    $(cont+' #ctgry'+n).append(optionCtgry);
    $('.search.dropdown').dropdown();
  }
  //--------------------------------END MENU ----------------------------------------------------//

  //------------------------------------Services------------------------------------------------//
  $('.addservices').click(function(){
    $('#addservices')
      .modal('setting', 'autofocus', false)
      .modal('setting', 'closable', false)
      .modal('setting', 'transition', 'fade up')
      .modal('show');
  });

  $('#addservices table.all tbody tr').click(function(){
    if ($(this).data('id') == 'all') {
      $('#addservices table.list tbody').empty();
      $.ajax
      ({
        url: '/getServiceContact',
        type:'get',
        dataType : 'json',
        success:function(response) {
          response.forEach(function(data) {
            var check = 0;
            var type = 'per hr.';
            $(".service-table input[name='serviceContact[]']").map( function() {
              if ($(this).val() == data.services_contact_id) {
                check = 1;
              } 
            }).get();
            $("#service-input input[name='serviceContact[]']").map( function() {
              if ($(this).val() == data.services_contact_id) {
                check = 2;
              } 
            }).get();
            if (data.price_type == 2) {
              type = 'flat';
            }
              if (check == 1) {
                $('#addservices table.list tbody').append('<tr><td class="two wide"></td><td class="eight wide">'+data.services_contact_name+'</td><td class="two wide"></td><td class="center aligned">Service already added.</td></tr>');
              } else if(check == 2) {
                $('#addservices table.list tbody').append('<tr><td class="two wide center aligned"><div class="ui checkbox" data-id="'+data.services_contact_id+'"><input type="checkbox" tabindex="0" value="'+data.services_contact_id+'" checked><label></label></div></td><td class="eight wide name">'+data.services_contact_name+'</td><td class="type two wide">'+type+'</td><td class="four wide center aligned price">&#8369; '+(data.services_contact_price).formatMoney(2)+' '+type+'</td></tr>');
              } else {
                $('#addservices table.list tbody').append('<tr><td class="two wide center aligned"><div class="ui checkbox" data-id="'+data.services_contact_id+'"><input type="checkbox" name="example" tabindex="0" value="'+data.services_contact_id+'"><label></label></div></td><td class="eight wide name">'+data.services_contact_name+'</td><td class="type two wide">'+type+'</td><td class="four wide center aligned price">&#8369; '+(data.services_contact_price).formatMoney(2)+'</td></tr>');
              }
          });
        },
        complete:function(){
          $('#addservices table.all').transition({
              animation  : 'fade out',
              onComplete : function() {
                $('#addservices .title').html('<i class="left chevron icon all"></i> All Services');
                $('#addservices table.list').transition('fade in');
              }
            });
        }
      });
    } else {
      $('#addservices table.all').transition({
          animation  : 'fade out',
          onComplete : function() {
            $('#addservices .title').html('<i class="left chevron icon ctgry"></i> Service Category');
            $('#addservices table.type').transition('fade in');
          }
        });
    }
  });
  $('#addservices table.type tr').click(function(){
    var name = $(this).find('.name').html();
    $('#addservices table.list tbody').empty();
    $.ajax
    ({
      url: '/getServiceContact',
      type:'get',
      data: {id:$(this).data('id')},
      dataType : 'json',
      success:function(response) {
        response.forEach(function(data) {
            var check = 0;
            var type = 'per hr.';
            $(".service-table input[name='serviceContact[]']").map( function() {
              if ($(this).val() == data.services_contact_id) {
                check = 1;
              } 
            }).get();
            $("#service-input input[name='serviceContact[]']").map( function() {
              if ($(this).val() == data.services_contact_id) {
                check = 2;
              } 
            }).get();
            if (data.price_type == 2) {
              type = 'flat';
            }
              if (check == 1) {
                $('#addservices table.list tbody').append('<tr><td class="two wide"></td><td class="eight wide">'+data.services_contact_name+'</td><td class="two wide"></td><td class="center aligned">Service already added.</td></tr>');
              } else if(check == 2) {
                $('#addservices table.list tbody').append('<tr><td class="two wide center aligned"><div class="ui checkbox" data-id="'+data.services_contact_id+'"><input type="checkbox" tabindex="0" value="'+data.services_contact_id+'" checked><label></label></div></td><td class="eight wide name">'+data.services_contact_name+'</td><td class="type two wide">'+type+'</td><td class="four wide center aligned price">&#8369; '+(data.services_contact_price).formatMoney(2)+' '+type+'</td></tr>');
              } else {
                $('#addservices table.list tbody').append('<tr><td class="two wide center aligned"><div class="ui checkbox" data-id="'+data.services_contact_id+'"><input type="checkbox" name="example" tabindex="0" value="'+data.services_contact_id+'"><label></label></div></td><td class="eight wide name">'+data.services_contact_name+'</td><td class="type two wide">'+type+'</td><td class="four wide center aligned price">&#8369; '+(data.services_contact_price).formatMoney(2)+'</td></tr>');
              }
        });
      },
      complete:function(){
        $('#addservices table.type').transition({
          animation  : 'fade out',
          onComplete : function() {
            $('#addservices .title').html('<i class="left chevron icon list"></i> '+name);
            $('#addservices table.list').transition('fade in');
          }
        });
      }
    });
  });
  $('#addservices .actions .varsel').click(function(){
    if ($('#addservices table.selected').transition('is visible') == false) {
      $('#addservices .title').transition({
          animation  : 'fade out',
          onComplete : function() {
            $('#addservices span.selected').transition('fade in');
          }
        });
      $('#addservices #service-cont').transition({
        animation  : 'fade out',
        onComplete : function() {
          // $('#addservices .title').html('<i class="left chevron icon sel"></i> Selected');
          $('#addservices table.selected').transition('fade in');
        }
      });
    }
  });

  $(document).on('click','#addservices .title .all',function(){
    $('#addservices table.list').transition({
        animation  : 'fade out',
        onComplete : function() {
          $('#addservices .title').html('Services');
          $('#addservices table.all').transition('fade in');
        }
      });
  });
  $(document).on('click','#addservices .title .ctgry',function(){
    $('#addservices table.type').transition({
        animation  : 'fade out',
        onComplete : function() {
          $('#addservices .title').html('Services');
          $('#addservices table.all').transition('fade in');
        }
      });
  });
  $(document).on('click','#addservices .title .list',function(){
    $('#addservices table.list').transition({
        animation  : 'fade out',
        onComplete : function() {
          $('#addservices .title').html('<i class="left chevron icon ctgry"></i> Service Category');
          $('#addservices table.type').transition('fade in');
        }
      });
  });
  $(document).on('click','#addservices .header .sel',function(){
    $('#addservices .search input').val('');
    $('#addservices .header span.selected').transition('fade out');
    $('#addservices table.selected').transition({
        animation  : 'fade out',
        onComplete : function() {
          $('#addservices #service-cont table.all').transition('show');
          $('#addservices #service-cont table.list').transition('hide');
          $('#addservices #service-cont table.type').transition('hide');
          $('#addservices #service-cont').transition('fade in');
          $('#addservices .header span.title').html('Services');
          $('#addservices .header span.title').transition('fade in');
        }
      });
  });
  $(document).on('click','#addservices .title .srch',function(){
    $('#addservices .search input').val('');
    $('#addservices table.list').transition({
        animation  : 'fade out',
        onComplete : function() {
          $('#addservices .title').html('Services');
          $('#addservices table.all').transition('fade in');
        }
      });
  });
  $(document).on('click','#addservices table.selected .delete',function(){
    var id = $(this).closest('tr').data('id');
    $('#addservices #service-input input[value="'+id+'"]').remove();
    $('#addservices table.selected tbody tr[data-id="'+id+'"]').remove();
    $('#addservices table.selected').trigger('count');
  });

  $(document).on('click','#addservices table.list .checkbox',function(){
    var id = $(this).find('input').val();
    if ($(this).checkbox('is checked') == true) {
      $('#addservices table.selected tbody').append('<tr data-id="'+id+'"><td class="twelve wide name">'+$(this).closest('tr').find('td.name').text()+'</td><td class="two wide type">'+$(this).closest('tr').find('td.type').text()+'</td><td class="four wide price">'+$(this).closest('tr').find('td.price').text()+'</td><td class="two wide center aligned"><i class="delete icon"></i></td></tr>').trigger('count');
      $('#addservices #service-input').append('<input type="hidden" name="serviceContact[]" value="'+id+'">');
    } else {
      $('#addservices table.selected tbody tr[data-id="'+id+'"]').remove();
      $('#addservices table.selected').trigger('count');
    }
  });
  $('#addservices table.selected').bind('count', function(event){
    $('#addservices .actions .counter').html($('#addservices table.selected tr').length);
  });

  $('#addservices .search input').on('change',function(){
    $('#addservices table.list tbody').empty();
    var srch = $(this).val();
    $.ajax
    ({
      url: '/getServiceContact',
      type:'get',
      data: {srch:srch},
      dataType : 'json',
      success:function(response) {
        if (response == "") {
          $('#addservices table.list tbody').append('<tr><td class="center aligned" colspan="3">No results found for "'+srch+'"</td></tr>');
        } else {
          response.forEach(function(data) {
            var check = 0;
            $(".service-table input[name='serviceContact[]']").map( function() {
              if ($(this).val() == data.services_contact_id) {
                check = 1;
              } 
            }).get();
              if (check == 1) {
                $('#addservices table.list tbody').append('<tr><td class="two wide"></td><td class="ten wide">'+data.services_contact_name+'</td><td class="center aligned">Service already added.</td></tr>');
              } else {
                $('#addservices table.list tbody').append('<tr><td class="two wide center aligned"><div class="ui checkbox" data-id="'+data.services_contact_id+'"><input type="checkbox" name="example" tabindex="0" value="'+data.services_contact_id+'"><label></label></div></td><td class="ten wide name">'+data.services_contact_name+'</td><td class="four wide center aligned">&#8369; '+(data.services_contact_price).formatMoney(2)+'</td></tr>');
              }
          });
        }
      },
      complete:function(){
        $('#addservices table.all').transition('hide');
        $('#addservices table.type').transition('hide');
        $('#addservices .title').html('<i class="left chevron icon srch"></i> Select Services');
        $('#addservices table.list').transition('fade in');
      }
    });
  });

  $('#addservices .cancelbtn').click(function(){
    $('#addservices .title').transition('show');
    $('#addservices .selected').transition('hide');
    $('#addservices table.all').transition('show');
    $('#addservices #service-cont').transition('show');
    $('#addservices table.type').transition('hide');
    $('#addservices table.list').transition('hide');
    $('#addservices table.selected').transition('hide');
    $('#addservices table.selected tbody').empty();
    $('#addservices #service-input').empty();
    $('#addservices .actions .counter').html($('#addservices table.selected tr').length);
    $('#addservices .title').html('Services');
  });

  $('#addservices .addbtn').click(function(){
    if ($('.service-table tbody tr td').text() == 'Empty') {
      $('.service-table tbody').empty();
    }
    $('#addservices table.selected tbody tr').map( function() {
      var hrs = '<div class="field"><input type="number" name="shrs" value="1"></div>';
      var type = $(this).closest('tr').find('td.type').text();
      var price = $(this).closest('tr').find('td.price').text();
      if (type == 'flat') {
        hrs = 0;
      }
      $('.service-table tbody').append('<tr><td>'+$(this).closest('tr').find('td.name').text()+'<input type="hidden" name="serviceContact[]" value="'+$(this).data('id')+'"></td><td class="right aligned price">'+price+' '+type+'</td><td>'+hrs+'</td><td class="right aligned total">'+price+'<input type="hidden" name="sctot[]" value="'+parseFloat(price.replace(/[^0-9-.]/g, ''))+'"></td><td class="center aligned"><div class="ui secondary small icon button delser"><i class="delete icon"></i></div></td></tr>');
    }).get();
    $('#addservices table.all').transition('show');
    $('#addservices table.list').transition('hide');
    $('#addservices table.type').transition('hide');
    $('#addservices table.selected').transition('hide');
    $('#addservices .title').html('Services');
    $('#addservices table.selected tbody').empty();
    $('#addservices #service-input').empty();
    $('#addservices .actions .counter').html('0');
  });

  $(document).on('change','.service-table input[name=shrs]',function(){
    $(this).closest('.field').removeClass('error');
    var pri = $(this).closest('tr').find('td.price').text();
    var price = parseFloat(pri.replace(/[^0-9-.]/g, ''));
    var total = $(this).val() * price;
    $(this).closest('tr').find('td.total').html('₱ '+total.formatMoney(2)+'<input type="hidden" name="sctot[]" value="'+total+'">');
  });

  $(document).on('click','.service-table tbody tr .delser',function(){
    // var price = parseFloat($(this).closest('tr').find('.price').text().replace(/[^0-9-.]/g, ''));
    // var total = parseFloat($('.payment.table .oac').text().replace(/[^0-9-.]/g, '')) - price;
    // $('.payment.table .oac').text('₱ '+total.formatMoney(2));
    $(this).closest('tr').remove();
    if ($('.service-table tbody tr').length == 0) {
      $('.service-table tbody').append('<tr><td colspan="5" class="center aligned">Empty</td></tr>');
    }
  });
  //--------------------------------------END SErvices ------------------------------------------------------------//

  //----------------------------------------Inventory Checklist----------------------------------------------------//


  $('.addchecklist').click(function(){
    $.ajax
    ({
      url: '/getEquipments',
      type:'get',
      dataType : 'json',
      success:function(response) {
        $('#addinventory table tbody').empty();
        response.forEach(function(data) {
          var check = 0;
          $(".checklist input[name='eqid[]']").map( function() {
            if ($(this).val() == data.equipment_inventory_id) {
              check = 1;
            } 
          }).get();
          if (check == 1) {
            $('#addinventory table tbody').append('<tr><td class="center aligned"></td><td class="name">'+data.equipment_inventory_name+'</td><td>'+data.equipment_type_description+'</td><td>Equipment already added</td><tr>');
          } else {
            $('#addinventory table tbody').append('<tr><td class="center aligned"><div class="ui checkbox"><input type="checkbox" name="chk[]" class="checkbox" value="'+data.equipment_inventory_id+'"><label></label></div></td><td class="name">'+data.equipment_inventory_name+'</td><td>'+data.equipment_type_description+'</td><td>'+data.equipment_inventory_qty+'</td><tr>');
          }
        });
      },
      complete:function(){
        $('#addinventory')
          .modal('setting', 'autofocus', false)
          .modal('setting', 'closable', false)
          .modal('setting', 'transition', 'fade up')
          .modal('show');
      }
    });
  });

  $('#addinventory .addbtn').click(function(){
    if ($('.checklist tbody tr td').html() == 'Empty') {
      $('.checklist tbody').empty();
    }
    $("#addinventory table tbody input[name='chk[]']:checked").map( function() {
      $('.checklist tbody').append('<tr><td>'+$(this).closest('tr').find('.name').text()+'<input type="hidden" value="'+$(this).val()+'" name="eqid[]"></td><td><div class="field"><input type="number" name="qty[]"></div></td><td class="center aligned"><i class="delete icon"></i></td></tr>');
    }).get();
  });
  
  $(document).on('click','.checklist tbody .delete.icon',function(){
    $(this).closest('tr').remove();
    if ($('.checklist tbody tr').length == 0) {
      $('.checklist tbody').append('<tr><td class="center aligned" colspan="3">Empty</td></tr>');
    }
  });




  //-----------------------------------------End Checklist---------------------------------------------------------//

  //----------------------------------------STAFF-----------------------------------------------------------------//
  $('.addstaff').click(function(){
    $.ajax
    ({
      url: '/getStaff',
      type:'get',
      data: { date: $('input[name=eventdate]').val() },
      dataType : 'json',
      success:function(response) {
        $('#addstaff table tbody').empty();
        response.forEach(function(data) {
          var status = 'Available';
          var check = 0;
          $(".staff-table input[name='staff[]']").map( function() {
            if ($(this).val() == data.staff_id) {
              check = 1;
            } 
          }).get();
          if (check == 1) {
            $('#addstaff table tbody').append('<tr><td class="center aligned"></td><td>'+data.staff_fname+' '+data.staff_lname+'</td><td>'+data.staff_profession_description+'</td><td>Staff Already Added.</td></tr>');
          } else {
            if (data.cnt == 1) {
              status = 'Unavailable';
            }
            $('#addstaff table tbody').append('<tr><td class="center aligned"><div class="ui checkbox"><input type="checkbox" name="staff[]" class="checkbox" value="'+data.staff_id+'"><label></label></div></td><td class="name">'+data.staff_fname+' '+data.staff_lname+'</td><td class="prof">'+data.staff_profession_description+'</td><td>'+status+'</td></tr>');
          }
        });
      },
      complete:function(){
        $('#addstaff')
          .modal('setting', 'autofocus', false)
          .modal('setting', 'closable', false)
          .modal('setting', 'transition', 'fade up')
          .modal('show');
      }
    });
  });

  $('#addstaff .addbtn').click(function(){
    if ($('.staff-table tbody tr td').html() == 'Empty') {
      $('.staff-table tbody').empty();
    }
    $("#addstaff table tbody input[name='staff[]']:checked").map( function() {
      $('.staff-table tbody').append('<tr><td>'+$(this).closest('tr').find('td.name').html()+'<input type="hidden" name="staff[]" value="'+$(this).val()+'"></td><td>'+$(this).closest('tr').find('td.prof').html()+'</td><td class="center aligned"><i class="delete icon"></i></td></tr>');
    }).get();
  });
  $(document).on('click','.staff-table tbody tr .delete.icon',function(){
    $(this).closest('tr').remove();
    if ($('.staff-table tbody tr').length == 0) {
      $('.staff-table tbody').append('<tr><td colspan="3" class="center aligned">Empty</td></tr>');
    }
  });
  //--------------------------------------END STAFF---------------------------------------------------------------//
  

  //---------------------------------------EXTRA COST----------------------------------------------------------//
  $('.addextra').click(function(){
    $('#addextra .checkbox.type').checkbox('check');
    $('#addextra .guestcount').addClass('disabled');
    $('#addextra')
      .modal('setting', 'autofocus', false)
      .modal('setting', 'closable', false)
      .modal('setting', 'transition', 'fade up')
      .modal('show');
  });
  $("#addextra form").submit(function(e){
      e.preventDefault();
  });
  $("#editextra form").submit(function(e){
      e.preventDefault();
  });
  $('#addextra .addbtn').click(function(){
    $('#addextra form').form('validate form');
    if ($('#addextra form').form('is valid')) {
      $.ajax
      ({
        url: '/addExtraCost',
        type: 'get',
        data: { 
          type : $('#addextra input[name="type"]:checked').val(),
          amount : $('#addextra input[name="amount"]').val(),
          count : $('#addextra input[name="count"]').val(),
          comment : $('#addextra textarea[name="comment"]').val(),
        },
        success:function(response){
          if ($('.extracost tbody td').text() == 'Empty') {
            $('.extracost tbody').empty();  
          }
          $('.extracost tbody').append('<tr><input type="hidden" value="'+response.extra_cost_id+'"><td>'+response.cost_type+'</td><td class="right aligned">&#8369; '+response.amount+'</td><td class="center aligned">('+response.guest_count+')</td><td class="right aligned">&#8369; '+response.total+'</td><td class="center aligned"><div class="ui mini teal icon button editextra"><i class="pencil icon"></i></div><div class="ui mini negative icon button deleteextra"><i class="trash bin icon"></i></div></td></tr><tr><td colspan="5">'+response.comments+'<input type="hidden" name="extraCost[]" value="'+response.extra_cost_id+'"></td></tr>');
          $('#addextra form').form('reset');
          $('#addextra form').form('clear');
        }
      });
    } else {
      return false;
    }
  });
  $('#editextra .addbtn').click(function(){
    $('#editextra form').form('validate form');
    if ($('#editextra form').form('is valid')) {
      $.ajax
      ({
        url: '/editExtraCost',
        type: 'get',
        data: { 
          ecid: $('#editextra input[name=ecid]').val(),
          type : $('#editextra input[name="type"]:checked').val(),
          amount : $('#editextra input[name="amount"]').val(),
          count : $('#editextra input[name="count"]').val(),
          comment : $('#editextra textarea[name="comment"]').val(),
        },
        success:function(response){
          $('.extracost tbody tr input[value="'+response.extra_cost_id+'"]').closest('tr').remove();
          $('.extracost tbody').append('<tr><input type="hidden" value="'+response.extra_cost_id+'"><td>'+response.cost_type+'</td><td class="right aligned">&#8369; '+response.amount+'</td><td class="center aligned">('+response.guest_count+')</td><td class="right aligned">&#8369; '+response.total+'</td><td class="center aligned"><div class="ui mini teal icon button editextra"><i class="pencil icon"></i></div><div class="ui mini negative icon button deleteextra"><i class="trash bin icon"></i></div></td></tr><tr><td colspan="5">'+response.comments+'<input type="hidden" name="extraCost[]" value="'+response.extra_cost_id+'"></td></tr>');
          $('#editextra form').form('reset');
        }
      });
    } else {
      return false;
    }
  });

  $('#addextra .radio.checkbox').checkbox({
    onChange: function(){
      if ($('#addextra .radio.checkbox.count').checkbox('is checked') == true) {
        $('#addextra').find('.guestcount').removeClass('disabled');
      }else{
        $('#addextra').find('.guestcount').addClass('disabled');
      }
    }
  });
  $('#editextra .radio.checkbox').checkbox({
    onChange: function(){
      if ($('#editextra .radio.checkbox.count').checkbox('is checked') == true) {
        $('#editextra').find('.guestcount').removeClass('disabled');
      }else{
        $('#editextra').find('.guestcount').addClass('disabled');
      }
    }
  });
  $('#addextra .deny.button').click(function(){
    $('#addextra form').form('reset');
  });
  $('#editextra .deny.button').click(function(){
    $('#editextra form').form('reset');
  });

  $(document).on('click','.editextra',function(){
    $.ajax
    ({
      url: '/getExtraCost',
      type: 'get',
      data: { ID: $(this).closest('tr').find('input').val() },
      success:function(response){
        response.forEach(function(data){
          if (data.cost_type == "Flat Cost") {
            $('#editextra').find('.guestcount').addClass('disabled');
          }
          $('#editextra form').form('set values',{
            ecid: data.extra_cost_id,
            amount: data.amount,
            type: data.cost_type,
            count: data.guest_count,
            comment: data.comments,
          });
        });
      },
      complete:function(){
        $('#editextra')
          .modal('setting', 'autofocus', false)
          .modal('setting', 'closable', false)
          .modal('setting', 'transition', 'fade up')
          .modal('show');
      }
    });
  });

  $(document).on('click','.deleteextra',function(){
    var ecid = $(this).closest('tr').find('input').val();
    $.ajax
    ({
      url: '/deleteExtra',
      type: 'get',
      data: { ecid: ecid },
      success:function(response){
        $('.extracost tbody tr input[value="'+ecid+'"]').closest('tr').remove();
        if ($('.extracost tbody tr').length <= 1) {
          $('.extracost tbody').append('<tr><td class="center aligned" colspan="5">Empty</td></tr>');
        }
      }
    });
  });

  $.fn.form.settings.rules.checkCount = function(value,checkCount) {
    if (checkCount == 1) {
      if ($('#addextra input[name=type]:checked').val() == 'Count Based') {
        if (value <= 0) {
          return false; 
        }
      }
    } else {
      if ($('#editextra input[name=type]:checked').val() == 'Count Based') {
        if (value <= 0) {
          return false; 
        }
      }
    }
    return true;
  };
  $('#addextra form').form({
    inline : true,
    fields : {
      amount : {
        identifier : 'amount',
        rules: [{
          type: 'empty',
          prompt: 'Cannot be empty.'
        },  
        {
          type : 'decimal',
          prompt : 'Invalid.'
        }]
      },
      count : {
        identifier: 'count',
        rules: [{
          type : 'checkCount[1]',
          prompt : 'Required.'
        }]
      },
    }
  });
  $('#editextra form').form({
    inline : true,
    fields : {
      amount : {
        identifier : 'amount',
        rules: [{
          type: 'empty',
          prompt: 'Cannot be empty.'
        },  
        {
          type : 'decimal',
          prompt : 'Invalid.'
        }]
      },
      count : {
        identifier: 'count',
        rules: [{
          type : 'checkCount[2]',
          prompt : 'Required.'
        }]
      },
    }
  });
  //---------------------------------------END EXTRA COST----------------------------------------------------------//

  //-----------------------------------------TASK-------------------------------------------------------------------//
  $('.addtask').click(function(){
    $('#addtask')
      .modal('setting', 'autofocus', false)
      .modal('setting', 'closable', false)
      .modal('setting', 'transition', 'fade up')
      .modal('show');
    $('#addtask .ui.calendar.date').calendar({
        value: '2017-06-06',
        type: 'date'
    }).calendar('set date',$('.content form .calendar.date').calendar('get date'));
    $('#addtask .ui.calendar.time').calendar({
        type: 'time'
    });
  });
  $("#addtask form").submit(function(e){
      e.preventDefault();
  });
  $("#edittask form").submit(function(e){
      e.preventDefault();
  });
  $('#addtask .addbtn').click(function(){
    $('#addtask form').form('validate form');
    if ($('#addtask form').form('is valid')) {
      $.ajax
      ({
        url: '/addTask',
        type: 'get',
        data: { 
          date : $('#addtask .calendar.date input').val(),
          time : $('#addtask .calendar.date input').val(),
          desc : $('#addtask textarea[name=description]').val(),
        },
        success:function(response){
          if ($('.task tbody td').text() == 'Empty') {
            $('.task tbody').empty();  
          }
          $('.task tbody').append('<tr><td class="seven wide">'+response.description+'<input type="hidden" name="reminder[]" value="'+response.reminder_id+'"></td><td class="five wide center aligned">'+response.date+' '+response.time+'</td><td class="three wide center aligned"><div class="ui mini teal icon button edittask"><i class="pencil icon"></i></div><div class="ui mini red icon button deletetask"><i class="trash bin icon"></i></div></td></tr>');
          $('#addtask form').form('reset');
        }
      });
    } else {
      return false;
    }
  });
  $('#edittask .addbtn').click(function(){
    $('#edittask form').form('validate form');
    if ($('#edittask form').form('is valid')) {
      $.ajax
      ({
        url: '/editTask',
        type: 'get',
        data: { 
          id : $('#edittask input[name=id]').val(),
          date : $('#edittask .calendar.date input').val(),
          time : $('#edittask .calendar.date input').val(),
          desc : $('#edittask textarea[name=description]').val(),
        },
        success:function(response){
          $('.task tbody tr input[value="'+response.reminder_id+'"]').closest('tr').remove();
          $('.task tbody').append('<tr><td class="seven wide">'+response.description+'<input type="hidden" name="reminder[]" value="'+response.reminder_id+'"></td><td class="five wide center aligned">'+response.date+' '+response.time+'</td><td class="three wide center aligned"><div class="ui mini teal icon button edittask"><i class="pencil icon"></i></div><div class="ui mini red icon button deletetask"><i class="trash bin icon"></i></div></td></tr>');
          $('#edittask form').form('reset');
        }
      });
    } else {
      return false;
    }
  });

  $('#addtask .deny.button').click(function(){
    $('#addtask form').form('reset');
  });
  $('#edittask .deny.button').click(function(){
    $('#edittask form').form('reset');
  });

  $(document).on('click','.edittask',function(){
    $.ajax
    ({
      url: '/getTask',
      type: 'get',
      data: { ID: $(this).closest('tr').find('input').val() },
      success:function(response){
        response.forEach(function(data){
          $('#edittask .ui.calendar.date').calendar('set date',data.date);
          $('#edittask .ui.calendar.time').calendar('set date',data.time);
          $('#edittask form').form('set values',{
            id: data.reminder_id,
            description: data.description,
          });
        });
      },
      complete:function(){
        $('#edittask')
          .modal('setting', 'autofocus', false)
          .modal('setting', 'closable', false)
          .modal('setting', 'transition', 'fade up')
          .modal('show');
        $('#edittask .ui.calendar.date').calendar({
            value: '2017-06-06',
            type: 'date'
        });
        $('#edittask .ui.calendar.time').calendar({
            type: 'time'
        });
      }
    });
  });
  
  $(document).on('click','.deletetask',function(){
    var rid = $(this).closest('tr').find('input').val();
    $.ajax
    ({
      url: '/deleteTask',
      type: 'get',
      data: { rid: rid },
      success:function(response){
        $('.task tbody tr input[value='+rid+']').closest('tr').remove();
        if ($('.task tbody tr').length < 1) {
          $('.task tbody').append('<tr><td class="center aligned" colspan="3">Empty</td></tr>');
        }
      }
    });
  });

  $('#addtask form').form({
    inline : true,
    fields : {
      date : {
        identifier : 'date',
        rules: [{
          type: 'empty',
          prompt: 'Cannot be empty.'
        }]
      },
      time : {
        identifier : 'time',
        rules: [{
          type: 'empty',
          prompt: 'Cannot be empty.'
        }]
      },
      description : {
        identifier : 'description',
        rules: [{
          type: 'empty',
          prompt: 'Cannot be empty.'
        }]
      },
    }
  });
  $('#edittask form').form({
    inline : true,
    fields : {
      date : {
        identifier : 'date',
        rules: [{
          type: 'empty',
          prompt: 'Cannot be empty.'
        }]
      },
      time : {
        identifier : 'time',
        rules: [{
          type: 'empty',
          prompt: 'Cannot be empty.'
        }]
      },
      description : {
        identifier : 'description',
        rules: [{
          type: 'empty',
          prompt: 'Cannot be empty.'
        }]
      },
    }
  });
  //----------------------------------------------END TASK-----------------------------------------------------------//

  $('.location.checkbox').checkbox({
    onChange: function(){
      if ($('.location.checkbox').checkbox('is checked') == true) {
        $('.first.side').transition({
          animation  : 'fade out',
          onComplete : function() {
            $('.form.location').form('clear');
            $('.second.side').transition('fade in');
          }
        });
        $('.main.form').form('remove fields', ['venue']);
        $('.main.form')
          .form('add rule', 'location', {
            rules: [{
              type: 'empty',
              prompt: 'Required.'
            }]
          })
          .form('add rule', 'hrs', {
            rules: [{
              type: 'empty',
              prompt: 'Required.'
            }]
          });
      } else {
        $('.second.side').transition({
          animation  : 'fade out',
          onComplete : function() {
            $('.form.location').form('clear');
            $('.first.side').transition('fade in');
          }
        });
        $('.main.form').form('remove fields', ['location','hrs']);
        $('.main.form')
          .form('add rule', 'venue', {
            rules: [{
              type: 'empty',
              prompt: 'Required.'
            }]
          });
      }
    }
  });
  
});
