 
  $(".build").sortable({
    //connectWith: '.container',
    //revert: true
    stop: makeTables
	});
  
  $(".build > .layout").sortable({
    connectWith: '.build > .layout',
    stop: makeTables
    //revert: true
	});


function makeTables(){
	console.log('making tabls')
	var layouts = ''
  $('.build > .layout').each(function(){
  	var items = ''
    $(this).find('.item').each(function(){
    	items += '<div class="item">'+$(this).html()+'</div>';
    })
    console.log(items)
    layouts = layouts + '<div class="layout">'+items+'</div>' 
    console.log(layouts)
  });
  $('.preview').html(layouts); 
}
makeTables()
