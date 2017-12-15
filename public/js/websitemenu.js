$(document).ready(function(){ 
 	$('.dropdown.ctgry').dropdown();
 	// $cat = ('input[name=cat]').val();
 	var cat = $('.dropdown.ctgry').dropdown('get value');
 	console.log($('.dropdown.ctgry').dropdown('get value'));
 	$('.dropdown.ctgry').on('change',function(){
 		$('.list').empty();
 	$.ajax
  ({
    url: '/wgetFood',
    type:'get',
    dataType : 'json',
    data : {"cat" : $('.dropdown.ctgry').dropdown('get value')},
    success:function(response) {
      response.forEach(function(data) {
      console.log(data);
      $('.list').append('<div class="column"><div class="ui card cc"><div class="image"><img class="img" height="100px" width="100px" src="image/FoodImages/'+data.submenu_img+'"></div><div class="content"><p class="header">'+data.submenu_name+'</p><div class="description">'+data.submenu_description+'</div></div><div class="extra content">Price: '+data.submenu_price+' per head</div></div></div>');
      });
    }
  	});
	});

  $('.browse').click(function(){
    $('#addmenu')
        .modal('setting', 'autofocus', false)
        .modal('setting', 'closable', false)
        .modal('setting', 'transition', 'fade up')
        .modal('show');
  });


});