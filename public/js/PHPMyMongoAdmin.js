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
});