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
		var me = $(event.delegateTarget);
		var display = me.children('section').css('display');
		var list = me.parent('.hideaway-list');
		if(list.attr('class')){
			list.children('.hideaway').children('section').css('display','none');
		}
		if(display=='none'){
			me.children('section').css('display','block');
		}else{
			me.children('section').css('display','none');
		}
	});
	
	$('.flash-message').on('click',function(event){
		$(this).remove();
	});

	$.fn.initJsonEdit = function (option){
		console.log(option);
		var container = document.getElementById(option.container);
		var editor = new JSONEditor(container, option.editOption);
		var reader = new FileReader();
		editor.set(option.json);

		/*when the file is done*/
		reader.onload = function(event){
			var text = event.target.result;
			editor.set(JSON.parse(text));
		};

		//c'est la meme chose que l autre. a grouper!
		$('.btn-menu-save').on('click',function(event){
			var json = editor.get();
			$.post(option.link,{json:JSON.stringify(json)},function(data){
				if(data.result){
					window.location.replace(data.url);
				}else{
					//create aletre
					var text = '<div class="flash-message error">'+data.message+'<div>';
					$("#Flash-Message").html(text);
				}
			},'json');
		});

		$('#loadDocument').on('change',function(event){
			reader.readAsText($(this)[0].files[0]);
		});

		$('.btn-menu-file').on('click',function(event){
			var blob = new Blob([editor.getText()], {type: 'application/json;charset=utf-8'});
			var url = URL.createObjectURL(blob);
			window.open(url);
		});
	}
});