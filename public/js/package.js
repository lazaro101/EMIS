$(document).ready(function(){ 
  $('.dropdown').dropdown();
  var foodid = 0;
  var option = "";
  $.ajax
  ({
    url: '/getCategory',
    type:'get',
    dataType : 'json',
    success:function(response) {
      response.forEach(function(data) {
        option += '<option value="'+data.submenu_category_id+'">'+data.submenu_category_name+'</option>';
      });
    }
  });

  $.fn.api.settings.api = {
    'retrieve package' : '/retrievePackage',
  };

  $('.drpdwn').dropdown();

  $('.table-cont tbody .checkbox').on('change',function(){
    var s = 1;
    if ($(this).checkbox('is checked') == true) {
      s = 0;
    }
    $.ajax
    ({
      url: '/changePackageStatus',
      type:'get',
      data: { status:s, id:$(this).find('input').val() },
      dataType : 'json',
    });
  });

  //---------------------Show Addform-----------------------------------//
  $('#addsub').click(function(){//-----------------show form------------------//
    $('#addform .ui.form').form('reset');//----------------reset form ------------//
    for(var i=0;i<1;i++){
      addfood('three',i,'#addform-menu');
      foodid=i;
    }
    $('#addform')
      .modal('setting', 'closable', false)
      .modal('setting', 'autofocus', false)
      .modal('setting', 'transition', 'fade up')
      .modal('show');
  });
  //-------------------Show Edit form---------------------------------------------//
  $('.edit')
    .api({
      action: 'retrieve package',
      method: 'get',
      beforeSend: function(settings) {
        settings.data = {
          ID: $(this).data('id')
        };
        return settings;
      },
      onSuccess: function(response) {
        $('#editform form')
          .form('set values', {
            id     : response[0][0].package_id,
            name : response[0][0].package_name,
            inclusions : response[0][0].package_inclusions,
            price   : response[0][0].package_price,
        });
        response[1].forEach(function(datas) {
          if ($('#editform-menu div.fields').length >= 5) {
            addfood('four',foodid,'#editform-menu');
            $('#editform #qty'+foodid).val(datas.qty);
            $('#editform #ctgry'+foodid).dropdown('set selected',datas.submenu_category_id);
            $('.div'+foodid).append('<button class="ui orange labeled icon button remove" data-id="'+foodid+'" type="button"><i class="remove circle icon"></i>REMOVE</button>');
          
            $('button.remove').click(function(){//-----------------remove food button-------------//
              var l = $(this).data('id') ; 
              $('#editform-menu .fields.div'+l).remove();
            });
          } else {
            addfood('three',foodid,'#editform-menu');
            $('#editform #qty'+foodid).val(datas.qty);
            $('#editform #ctgry'+foodid).dropdown('set selected',datas.submenu_category_id);
          }
          var fd = foodid
          $.ajax
          ({
            url: '/retrieveSelected',
            type: 'get',
            data:{ 'pcid' : datas.package_choice_id , 'scid' : datas.submenu_category_id },
            success:function(response){
              response.forEach(function(data){
                $('.chc'+fd).dropdown('set selected',data.submenu_id);
              })
            }
          });
          foodid++;
        })
      },
      onComplete: function(response) {
        $('#editform')
          .modal('setting', 'closable', false)
          .modal('setting', 'autofocus', false)
          .modal('setting', 'transition', 'scale')
          .modal('show'); 
        $('#editform .ui.form').form('reset');//----------------reset form ------------//
      },
    }).click(function(){
      $(this).addClass('disabled');
  });

  //--------------add button form------------------------------//
  $(document).on('change','#addform-menu select[name="pkgCtgry[]"]',function(){
    $('#addform-menu').find('.field').removeClass('error');
  });
  $(document).on('change','#addform-menu select[name="pkgChc[]"]',function(){
    $(this).closest('.field').removeClass('error');
  });
  $(document).on('change','#addform-menu input[name="pkgQty[]"]',function(){
    $(this).closest('.field').removeClass('error');
  });
  $(document).on('change','#editform-menu select[name="pkgCtgry[]"]',function(){
    $('#addform-menu').find('.field').removeClass('error');
  });
  $(document).on('change','#editform-menu select[name="pkgChc[]"]',function(){
    $(this).closest('.field').removeClass('error');
  });
  $(document).on('change','#editform-menu input[name="pkgQty[]"]',function(){
    $(this).closest('.field').removeClass('error');
  });
  $('#addform .addbtn').click(function(){
    $('#addform .ui.form').form('validate form');
    var x = [];
    var count = 0,none = 0, same = 0, valid = true;
    $('#addform input[name="pkgQty[]"]').each(function(){
      if ($(this).val() == "" || $(this).val() <= 0) {
        $(this).closest('.field').addClass('error');
        none = 1;
      }
    });
    $('#addform select[name="pkgCtgry[]"] option:selected').each(function(){
      x.push($(this).val());
      if ($(this).val() == "") {
        $(this).closest('.field').addClass('error');
        none = 2;
      }
    });
    $('#addform select[name="pkgCtgry[]"] option:selected').each(function(){
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
    $('#addform select[name="pkgChc[]"]').each(function(){
      if ($(this).val() == null) {
        $(this).closest('.field').addClass('error');
        none = 3;
      }
    });
    if (none == 1) {
      swal('Quantity Column','Enter a valid value.','error');
      valid = false; 
    } else if (none == 2){
      swal('Category Column','Choose a category.','error');
      valid = false;
    } else if (same == 1) {
      swal('Category Column','Cannot have same category.','error');
      valid = false;
    } else if (none == 3) {
      swal('Food Column','Select choice of foods.','error');
      valid = false;
    }

    if ($('#addform .ui.form').form('is valid') == false) {
      return false
    }
    if (valid == true) {
      return true;
    } else {
      return false;
    }
  });
  $('#editform .addbtn').click(function(){
    $('#editform .ui.form').form('validate form');
    var x = [];
    var count = 0,none = 0, same = 0, valid = true;
    $('#editform input[name="pkgQty[]"]').each(function(){
      if ($(this).val() == "" || $(this).val() <= 0) {
        $(this).closest('.field').addClass('error');
        none = 1;
      }
    });
    $('#editform select[name="pkgCtgry[]"] option:selected').each(function(){
      x.push($(this).val());
      if ($(this).val() == "") {
        $(this).closest('.field').addClass('error');
        none = 2;
      }
    });
    $('#editform select[name="pkgCtgry[]"] option:selected').each(function(){
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
    $('#editform select[name="pkgChc[]"]').each(function(){
      if ($(this).val() == null) {
        $(this).closest('.field').addClass('error');
        none = 3;
      }
    });
    if (none == 1) {
      swal('Quantity Column','Enter a valid value.','error');
      valid = false; 
    } else if (none == 2){
      swal('Category Column','Choose a category.','error');
      valid = false;
    } else if (same == 1) {
      swal('Category Column','Cannot have same category.','error');
      valid = false;
    } else if (none == 3) {
      swal('Food Column','Select choice of foods.','error');
      valid = false;
    }

    if ($('#editform .ui.form').form('is valid') == false) {
      return false
    }
    // alert(valid);
    if (valid == true) {
      return true;
    } else {
      return false;
    }
  });
  //--------------cancel button form------------------------------//
  $('#addform .cancelbtn').click(function(){
    $('#addform-menu .fields').remove();
    $('#addform form').form('reset');
    foodid = 0;
  });
  $('#editform .cancelbtn').click(function(){
    $('#editform-menu .fields').remove();
    $('.edit').removeClass('disabled');
    $('#editform form').form('reset');
    foodid = 0;
  });

  //--------------addform add category button ------------------------------//
  $('#addform #add').click(function(){
  	if ($('#addform-menu div.fields').length >= 10) {
  		return false;
  	}
    foodid++;
    addfood('four',foodid,'#addform-menu');
    $('#addform-menu .fields.div'+foodid).append('<div class="field"><button class="ui orange labeled icon button remove" data-id="'+foodid+'" type="button"><i class="remove circle icon"></i>REMOVE</button></div>');
    $('#addform-menu .fields.div'+foodid).transition('shake');
		$('button.remove').click(function(){//-----------------remove food button-------------//
			var l = $(this).data('id') ; 
			$('#addform-menu .fields.div'+l).transition({
          animation  : 'browse',
          onComplete : function() {
            $(this).remove();
          }
      });
		});
  });
  //--------------editform add category button ------------------------------//
  $('#editform #add').click(function(){
  	if ($('#editform-menu div.fields').length >= 10) {
  		return false;
  	}
    foodid++;
    addfood('four',foodid,'#editform-menu');
    $('#editform-menu .fields.div'+foodid).append('<div class="field"><button class="ui orange labeled icon button remove" data-id="'+foodid+'" type="button"><i class="remove circle icon"></i>REMOVE</button></div>');
    $('#editform-menu .fields.div'+foodid).transition('shake');
		$('button.remove').click(function(){//-----------------remove food button-------------//
			var l = $(this).data('id') ; 
			$('#editform-menu .fields.div'+l).transition({
          animation  : 'browse',
          onComplete : function() {
            $(this).remove();
          }
      });
		});
  });

  function addfood(numfld,n,menu){
    var div1 = document.createElement("div");
    div1.setAttribute('class', numfld+' fields div'+n);
    $(menu).append(div1);

    var qtydiv = document.createElement("div");
    qtydiv.setAttribute('class','two wide column field subdiv1'+n);
    $('.div'+n).append(qtydiv);

    var ctgrydiv = document.createElement("div");
    ctgrydiv.setAttribute('class','four wide column field subdiv2'+n);
    $('.div'+n).append(ctgrydiv);

    var chdiv = document.createElement("div");
    chdiv.setAttribute('class','six wide column field subdiv3'+n);
    $('.div'+n).append(chdiv);

    var newF = document.createElement("input");
    newF.setAttribute('id','qty'+n);
    newF.setAttribute('name','pkgQty[]');
    newF.setAttribute('type','number');
    newF.setAttribute('placeholder','Qty.');
    $('.subdiv1'+n).append(newF);

    var newD = document.createElement("select");
    newD.setAttribute('id','ctgry'+n);
    newD.setAttribute('data-id',n);
    newD.setAttribute('class','ui search dropdown drpdwn cha');
    newD.setAttribute('name','pkgCtgry[]');
    $('.subdiv2'+n).append(newD);

    var newC = document.createElement("select");
    newC.setAttribute('id','chc'+n);
    newC.setAttribute('multiple','');
    newC.setAttribute('class','ui search multiple dropdown drpdwn chc'+n);
    newC.setAttribute('name','pkgChc[]');
    $('.subdiv3'+n).append(newC);
    
    $('#chc'+n).append("<option value=''>Choice of Food</option>");

    $('#ctgry'+n).append("<option value=''>Category</option>");
    $('#ctgry'+n).append(option);

    $('.drpdwn').dropdown();
  }

  $('#addform').on('change','.cha',function(){
    var k = $(this).find('select').data('id');
    var ctgry_id = $('#ctgry'+k).val();
    $('#chc'+k).dropdown('restore defaults');
    var option = "";
    $('#chc'+k).empty();
    $.ajax
    ({
      type:'get',
      url: '/getFood',
      data: {'ctgry_id':ctgry_id},
      success:function(response) {
        $('#chc'+k).append('<option value="">Choice of Food</option>');
        response.forEach(function(data) {
          option += '<option value="'+data.submenu_id+'">'+data.submenu_name+'</option>';
        });
        $('#chc'+k).append(option);
      }
    });
  });
  $('#editform').on('change','.cha',function(){
    var k = $(this).find('select').data('id');
    var ctgry_id = $('#ctgry'+k).val();
    $('#chc'+k).dropdown('restore defaults');
    var option = "";
    $('#chc'+k).empty();
    $.ajax
    ({
      type:'get',
      url: '/getFood',
      data: {'ctgry_id':ctgry_id},
      success:function(response) {
        $('#chc'+k).append('<option value="">Choice of Food</option>');
        response.forEach(function(data) {
          option += '<option value="'+data.submenu_id+'">'+data.submenu_name+'</option>';
        });
        $('#chc'+k).append(option);
      }
    });
  });
  //---------------------VALIDATIONS---------------------------//

  $.fn.form.settings.rules.checkName = function(value) { //-----------duplicate -------------//
    var res = true;
    $.ajax
      ({
        url: '/validatePackage',
        type : "get",
        data : {"value" : value},
        dataType: "json",
        success: function(data) {
          if (data > 0) {
              res = false;
          } else {
              res = true;
          }
        }
    });
              alert(res);
      return res;
  };
  $.fn.form.settings.rules.checkNameEdit = function(value) { //-----------check duplicate -------------//
    var res = true;
    var dup = $('#editform .ui.form').form('get value','dupsubmenuName');
    if (dup.toLowerCase() == value.toLowerCase()) {
      return true;
    }
    $.ajax
      ({
        async : false,
        url: '/validateSubmenu',
        type : "get",
        data : {"value" : value},
        dataType: "json",
        success: function(response) {
          if (response.length > 0) {
                res = false;              
          } else {
              res = true;
          }
        }
    });
      return res;
  };
    $.fn.form.settings.rules.checkPrice = function(value) { //-----------duplicate -------------//
      if(value.indexOf(".")>1){
        return false;
      }
      return true;
    };

  $.fn.form.settings.rules.checkSymbol = function(value) { //-----------duplicate -------------//
    if (value.charAt(0)=="-" || value.charAt(0)=="/" || value.charAt(0)=="(" ||value.charAt(0)==")" || value.charAt(0)=="'" || value.charAt(0)>=0 && value.charAt(0)<=9){
      return false;  
    }
    return true;
  };

  $.fn.form.settings.rules.checkNoCategories = function(value) { //-----------No Categories -------------//
    var foods = document.getElementById("addformform").elements["pkgCtgry[]"];
      for (var i=0;i<foods.length;i++){
      if (foods[i].value == "0"){
        return false;
      }
    }
    return true;
  };

  $.fn.form.settings.rules.checkCategories = function(value) { //-----------Same Categories -------------//
    var foods = document.getElementById("addformform").elements["pkgCtgry[]"];    
    for (var i=0;i<foods.length;i++){
      for (var u=0;u<foods.length;u++){
        if(u!=i){
          if (foods[i].value==foods[u].value){
            return false;
          }
        }
      }
    }
    return true;
  };

   $.fn.form.settings.rules.checkQuantity= function(value) { //-----------No Quantity -------------//
    var foods = document.getElementById("addformform").elements["pkgQty[]"];
      for (var i=0;i<foods.length;i++){
      if (foods[i].value <= 0){
        return false;
      }
    }
    return true;
  };

   $.fn.form.settings.rules.echeckNoCategories = function(value) { //-----------No Categories -------------//
    var foods = document.getElementById("editformform").elements["pkgCtgry[]"];
      for (var i=0;i<foods.length;i++){
      if (foods[i].value == "0"){
        return false;
      }
    }
    return true;
  };

  $.fn.form.settings.rules.echeckCategories = function(value) { //-----------Same Categories -------------//
    var foods = document.getElementById("editformform").elements["pkgCtgry[]"];
      for (var i=0;i<foods.length;i++){

      for (var u=0;u<foods.length;u++){
      if(u!=i){
      if (foods[i].value==foods[u].value){
          return false;
        }
      }}
    }
    return true;
  };

   $.fn.form.settings.rules.echeckQuantity= function(value) { //-----------No Quantity -------------//
    var foods = document.getElementById("editformform").elements["pkgQty[]"];
      for (var i=0;i<foods.length;i++){
      if (foods[i].value <= 0){
        return false;
      }
    }
    return true;
  };

  $('#addform form')//--------------------addform validate--------------//
    .form({
      inline : true,
      fields :{
        name: {
          identifier: 'name',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be empty'
          },
          {
            type   : 'maxLength[30]',
            prompt : 'Maximum of 30 characters only.'
          },
          {
            type   : 'regExp',
            value : '/^[ A-Za-z0-9()\'\\-`/\"]*$/',
            prompt : 'Invalid Symbol/s.'
          },
          {
            type   : 'regExp',
            value : '/^(?!.*[()\'\\-`/\"]{2}).*$/',
            prompt : 'Consecutive symbol/s not allowed.'
          },
          {
            type   : 'checkSymbol',
            prompt : 'Should not start with number/s or symbol/s.'
          // },
          // {
          //   type   : 'checkName',
          //   prompt : 'Name Already Exists'
          }]
        },
        inclusions: {
          identifier: 'inclusions',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be empty'
          },
          {
            type   : 'maxLength[500]',
            prompt : 'Maximum of 100 characters only.'
          },
          // {
          //   type   : 'regExp',
          //   value : '/^[ A-Za-z0-9.,!()\'\\-`/\"]*$/',
          //   prompt : 'Invalid Symbol/s.'
          // },
          // {
          //   type   : 'regExp',
          //   value : '/^(?!.*[.,()\'\\-`/\"]{2}).*$/',
          //   prompt : 'Consecutive symbol/s not allowed.'
          // }
          ]
        },
        // pckg: {
        //   identifier: 'pckg',
        //   rules:[
        //     {
        //     type   : 'checkNoCategories',
        //     prompt : 'Cannot have a empty category.'
        //   },
        //   {
        //     type   : 'checkQuantity',
        //     prompt : 'Cannot have a empty Quantity.'
        //   },
        //   {
        //     type   : 'checkCategories',
        //     prompt : 'Cannot have the same categories'
        //   }
        //   ]
        // },
        price: {
          identifier: 'price',
          rules: [{
              type: 'checkPrice',
              prompt: 'Enter a valid Price'
            },
            {
            type: 'empty',
            prompt: 'Cannot be Empty'
          },
          {
            type: 'decimal',
            prompt: 'Enter valid price'
          }]
        },
      }
  });
  $('#editform form')//--------------------addform validate--------------//
    .form({
      inline : true,
      fields :{
        name: {
          identifier: 'name',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be empty'
          },
          {
            type   : 'maxLength[30]',
            prompt : 'Maximum of 30 characters only.'
          },
          {
            type   : 'regExp',
            value : '/^[ A-Za-z0-9()\'\\-`/\"]*$/',
            prompt : 'Invalid Symbol/s.'
          },
          {
            type   : 'regExp',
            value : '/^(?!.*[()\'\\-`/\"]{2}).*$/',
            prompt : 'Consecutive symbol/s not allowed.'
          },
          {
            type   : 'checkSymbol',
            prompt : 'Should not start with number/s or symbol/s.'
          // },
          // {
          //   type   : 'checkName',
          //   prompt : 'Name Already Exists'
          }]
        },
        inclusions: {
          identifier: 'inclusions',
          rules: [
          {
           type   : 'empty',
            prompt : 'Cannot be empty'
          },
          {
            type   : 'maxLength[500]',
            prompt : 'Maximum of 500 characters only.'
          },
          //{
           // type   : 'regExp',
           // value : '/^[ A-Za-z0-9.,!()\'\\-`/\"]*$/',
           // prompt : 'Invalid Symbol/s.'
          //},
          // {
          //   type   : 'regExp',
          //   value : '/^(?!.*[.,()\'\\-`/\"]{2}).*$/',
          //   prompt : 'Consecutive symbol/s not allowed.'
          // }
          ]
        },
        // pckg: {
        //   identifier: 'pckg',
        //   rules:[
        //     {
        //     type   : 'echeckNoCategories',
        //     prompt : 'Cannot have a empty category.'
        //   },
        //   {
        //     type   : 'echeckQuantity',
        //     prompt : 'Cannot have a empty Quantity.'
        //   },
        //   {
        //     type   : 'echeckCategories',
        //     prompt : 'Cannot have the same categories'
        //   }
        //   ]
        // },
        price: {
          identifier: 'price',
          rules: [{
              type: 'checkPrice',
              prompt: 'Enter a valid Price'
            },
            {
            type: 'empty',
            prompt: 'Cannot be Empty'
          },
          {
            type: 'decimal',
            prompt: 'Enter valid price'
          }]
        },
      }
  });

  //-------------------Delete Validation----------------------//
  $('button.delbtn').click(function(e) {
    var id = $(this).data('id');
    var item = $(this).closest('tr').find('.name').text();
    $('.ui.basic.modal span.item').text(item);
    $('.ui.basic.modal')
      .modal({
        closable  : false,
        onApprove : function() {
          $('#delete-form').form('set value','id',id);
          $('#delete-form').submit();
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

  $('table').DataTable();
});
