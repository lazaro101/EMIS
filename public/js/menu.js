$(document).ready(function(){

  $('.ui.dropdown').dropdown();

  var foodid = 0;
  var optionPkg = "";
  var option = "";

  $.fn.api.settings.api = {
    'get category' : '/getCategory',
    'get food'   : '/getFood',
    'get package food'   : '/getPackageFood',
    'get menu'   : '/retrieveMenu',
  };

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
  $.ajax
  ({
    url: '/getPackage',
    type:'get',
    dataType : 'json',
    success:function(response) {
      response.forEach(function(data) {
        optionPkg += '<option value="'+data.package_id+'">'+data.package_name+'</option>';
      });
    $('#addform #selpkg').append(optionPkg);
    $('#editform #selpkg').append(optionPkg);
    }
  });

	//-----------------------Forms Image Preview----------------------//
	$(".addpic").change(function(event){
		var input = $(event.currentTarget);
		var file = input[0].files[0];
		var reader = new FileReader();
		reader.onload = function(e){
			image_base64 = e.target.result;
			$('#addform img').attr("src", image_base64);
		};
		reader.readAsDataURL(file);
	});

	$(".editpic").change(function(event){
		var input = $(event.currentTarget);
		var file = input[0].files[0];
		var reader = new FileReader();
		reader.onload = function(e){
			image_base64 = e.target.result;
			$('#editform img').attr("src", image_base64);
		};
		reader.readAsDataURL(file);
	});

  $('#addform .fixpkg').api({
      action: 'get package food',
      method: 'get',
      beforeSend: function(settings) {
        settings.data = {
          ID: $('#addform .search.dropdown.pkg').dropdown('get value')
        };
        return settings;
      },
      onSuccess: function(response) {
        response.forEach(function(data) {
          for(var j=data.qty;j!=0;j--){
            addfood('two',foodid,'#addform-menu');
            $('#addform-menu .ctgry'+foodid).dropdown('set selected',data.submenu_category_id);
            foodid++;
          }
        })
      },
      onComplete: function(response) {
        $('#addform .header.second .name').text($('#addform .search.dropdown.pkg').dropdown('get text'));
        $('#addform .first.segment').transition({
          animation  : 'swing up',
          onComplete : function() {
            $('#addform .second.segment').transition('swing down');
          }
        });
      },
  });

  //---------------------Show Addform-----------------------------------//
  $('#addsub').click(function(){//-----------------show form------------------//
    $('#addform')
      .modal('setting', 'closable', false)
      .modal('setting', 'autofocus', false)
      .modal('setting', 'transition', 'fade up')
      .modal('show');
  });

  //---------------------Show Editform-----------------------------------//
  $('.edit').api({
    action: 'get menu',
    method: 'get',
    beforeSend: function(settings) {
      settings.data = {
        ID: $(this).data('id')
      };
      return settings;
    },
    onSuccess: function(response) {
      $('#editform .first.segment').transition('hide');
      $('#editform .second.segment').transition('show');
      $('#editform form')
        .form('set values', {
          id     : response[0][0].menu_id,
          duptitle : response[0][0].menu_title,
          title : response[0][0].menu_title,
          description : response[0][0].menu_description,
          package : response[0][0].package_id,
      });
      response[1].forEach(function(data) {
          addfood('two',foodid,'#editform-menu');
          $('#editform-menu .ctgry'+foodid).dropdown('set selected',data.submenu_category_id);
          var fd = foodid;
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
              $('#food'+fd).append(foodopt);
            },
            onComplete: function(response) {
              $('#editform-menu .food'+fd).addClass('loading');
              setTimeout(function(){ 
                $('#editform-menu .food'+fd).dropdown('set selected',data.submenu_id);
                $('#editform-menu .food'+fd).removeClass('loading');
              }, 1000);
            },
          }).api('query');
          foodid++;
      })
    },
    onComplete: function(response) {
      $('#editform')
        .modal('setting', 'closable', false)
        .modal('setting', 'autofocus', false)
        .modal('setting', 'transition', 'scale')
        .modal('show');
    },
  });
  //--------------add button form------------------------------//
  $('#addform .addbtn').click(function(){
    if ($('#addform .ui.form').form('is valid') == false) {
      $('#addform .ui.form').form('validate form');
      return false
    }
    return true;
  });
  $('#editform .addbtn').click(function(){
    if ($('#editform .ui.form').form('is valid') == false) {
      $('#editform .ui.form').form('validate form');
      return false
    }
    return false;
  });
  //--------------cancel button form------------------------------//
  $('#addform .cancelbtn').click(function(){
    $('#addform-menu .fields').remove();
    $('#addform .first.segment').transition('show');
    $('#addform .second.segment').transition('hide');
    $('#addform form').form('reset');
    $('#addform form').form('clear');
    foodid = 0;
  });
  $('#editform .cancelbtn').click(function(){
    $('#editform-menu .fields').remove();
    $('#editform form').form('reset');
    foodid = 0;
  });

  //---------------add food dropdown onchange------------------------//
  $('#addform').on('change','.cha',function(){
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
        response.forEach(function(data) {
          option += '<option value="'+data.submenu_id+'">'+data.submenu_name+'</option>';
        });
        $('#food'+k).append(option);
      }
    });
  });

  //---------------edit food dropdown onchange------------------------//
  // $('#editform #editform-menu').on('change','.cha',function(){
  //   var k =$(this).find('select').data('id');
  //   var ctgry_id = $('#ctgry'+k).val();
  //   $('#food'+k).dropdown('restore defaults');
  //   var option = "";
  //   $('#food'+k).empty();
  //   $.ajax
  //   ({
  //     type:'get',
  //     url: '/getFood',
  //     data: {'ctgry_id':ctgry_id},
  //     success:function(response) {
  //       response.forEach(function(data) {
  //         option += '<option value="'+data.submenu_id+'">'+data.submenu_name+'</option>';
  //       });
  //       $('#food'+k).append(option);
  //     }
  //   });
  // });

  function addfood(numfld,n,menu){
    var div1 = document.createElement("div");
    div1.setAttribute('class', numfld+' fields div'+n);
    $(menu).append(div1);

    var ctgrydiv = document.createElement("div");
    ctgrydiv.setAttribute('class','six wide column field subdiv1'+n);
    $('.div'+n).append(ctgrydiv);

    var fooddiv = document.createElement("div");
    fooddiv.setAttribute('class','six wide column field subdiv2'+n);
    $('.div'+n).append(fooddiv);

    var newD = document.createElement("select");
    newD.setAttribute('id','ctgry'+n);
    newD.setAttribute('class','ui dropdown cha disabled ctgry'+n);
    // newD.setAttribute('name','menuCtgrys[]');
    // newD.setAttribute('data-validate','menuCtgrys');
    newD.setAttribute('data-id',n);
    $('.subdiv1'+n).append(newD);
    
    var newF = document.createElement("select");
    newF.setAttribute('id','food'+n);   
    newF.setAttribute('class','ui search dropdown fdcol food'+n);
    newF.setAttribute('data-id',n);
    newF.setAttribute('name','menuFood[]');
    $('.subdiv2'+n).append(newF);

    $('#ctgry'+n).append("<option value=''>Category</option>");
    $('#food'+n).append("<option value=''>Food</option>");

    $('#ctgry'+n).append(option);
    $('.ui.dropdown').dropdown();
  }

  //---------------------VALIDATIONS---------------------------//

  $.fn.form.settings.rules.checkName = function(value) { //-----------duplicate -------------//
    var res = true;
    $.ajax
      ({
        async : false,
        url: '/validateMenu',
        type : "get",
        data : {"value" : value},
        dataType: "json",
        success: function(data) {
            if (data.length > 0) {
                res = false;
            } else {
                res = true;
            }
        }
    });
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

  $.fn.form.settings.rules.checkSymbol = function(value) { //-----------duplicate -------------//
    if (value.charAt(0)=="-" || value.charAt(0)=="/" || value.charAt(0)=="(" ||value.charAt(0)==")" || value.charAt(0)=="'" || value.charAt(0)>=0 && value.charAt(0)<=9){
      return false;  
    }
    return true;
  };

/*$.fn.form.settings.rules.checkNoMenu= function(value) { //----------- no food-------------//
    var foods = document.getElementById("addformform").elements["menuFood[]"];
      for (var i=0;i<foods.length;i++){
      if (foods[i].value <= 0){
        return false;
      }
    }
    return true;
  };

   $.fn.form.settings.rules.checkMenu= function(value) { //----------- same food-------------//
    var foods = document.getElementById("addformform").elements["menuFood[]"];
      for (var i=0;i<foods.length;i++){
        for (var u=0;i<foods.length;u++){
           if (foods[i].value == foods[u].value){
            if(i != u && $("#ctgry"+i).val() == $("#ctgry"+u).val()){
            return false;
            }
          }
        }
    }
    return true;
  };*/

  $('#addform .ui.form')//--------------------addform validate--------------//
    .form({
      inline : true,
      fields :{
        title: {
          identifier: 'title',
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
          },
          {
            type   : 'checkName',
            prompt : 'Name Already Exists'
          }]
        },
        description: {
          identifier: 'description',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be empty'
          },
          {
            type   : 'maxLength[100]',
            prompt : 'Maximum of 100 characters only.'
          },
          {
            type   : 'regExp',
            value : '/^[ A-Za-z0-9.,!()\'\\-`/\"]*$/',
            prompt : 'Invalid Symbol/s.'
          },
          {
            type   : 'regExp',
            value : '/^(?!.*[.,()\'\\-`/\"]{2}).*$/',
            prompt : 'Consecutive symbol/s not allowed.'
          }],
        mn:{
          identifier: 'mn',
          rules: [
            {
              type : 'checkNoMenu',
              prompt: 'Menu Empty.'
            }
          ]
        }
        // },
        // menuCtgrys: {
        //   identifier: 'menuCtgrys',
        //   rules: [
        //   {
        //     type   : 'empty',
        //     prompt : 'Select a category'
        //   }]
        }
      }
  });
  $('#editform .ui.form')//--------------------editform validate--------------//
    .form({
      inline : true,
      fields :{
        title: {
          identifier: 'title',
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
          },
          {
            type   : 'checkNameEdit',
            prompt : 'Name Already Exists'
          }]
        },
        description: {
          identifier: 'description',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be empty'
          },
          {
            type   : 'maxLength[100]',
            prompt : 'Maximum of 100 characters only.'
          },
          {
            type   : 'regExp',
            value : '/^[ A-Za-z0-9.,!()\'\\-`/\"]*$/',
            prompt : 'Invalid Symbol/s.'
          },
          {
            type   : 'regExp',
            value : '/^(?!.*[.,()\'\\-`/\"]{2}).*$/',
            prompt : 'Consecutive symbol/s not allowed.'
          }]
        },
        // submenuCtgry: {
        //   identifier: 'submenuCtgry',
        //   rules: [
        //   {
        //     type   : 'empty',
        //     prompt : 'Select a category'
        //   }]
        // },
      }
  });

  //-------------------Delete Validation----------------------//
  $('button.delbtn').click(function(e) {
    var id = $(this).data('id');
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
