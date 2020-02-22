/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) SCHENCK Simon
 * @since         0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */

$(document).ready(function(){

	$('.hideaway').on('click','.hideaway-btn',function(event){
		event.stopPropagation();
		let me = $(event.delegateTarget);
		let display = me.children('section').css('display');
		let list = me.parent('.hideaway-list');
		if(list.attr('class')){
			list.children('.hideaway').children('section').css('display','none');
		}
		if(display=='none'){
			me.children('section').css('display','block');
		}else{
			me.children('section').css('display','none');
		}
	});
	
	$('.btn-show-collection').on('click',function(e){
		let parent = $(this).parents('.db-list');
		parent.find('.db-collections-wrapper').toggleClass('open');
	});

	$('.flash-message').on('click',function(event){
		$(this).remove();
	});

	$.fn.initJsonEdit = function (option){
		
		let container = document.getElementById(option.container);
		let editor = new JSONEditor(container, option.editOption);
		let reader = new FileReader();
		editor.set(option.json);

		/*when the file is done*/
		reader.onload = function(event){
			let text = event.target.result;
			editor.set(JSON.parse(text));
		};

		//c'est la meme chose que l autre. a grouper!
		$('.btn-menu-save').on('click',function(event){
			let json = editor.get();
			$.post(option.link,{json:JSON.stringify(json)},function(data){
				if(data.result){
					window.location.replace(data.url);
				}else{
					//create aletre
					let text = '<div class="flash-message error">'+data.message+'<div>';
					$("#Flash-Message").html(text);
				}
			},'json');
		});

		$('#loadDocument').on('change',function(event){
			reader.readAsText($(this)[0].files[0]);
		});

		$('.btn-menu-file').on('click',function(event){
			let blob = new Blob([editor.getText()], {type: 'application/json;charset=utf-8'});
			let url = URL.createObjectURL(blob);
			window.open(url);
		});
	}
});