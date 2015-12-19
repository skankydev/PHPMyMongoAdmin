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

	$('.db-list').on('click',function(event){
		var dbName = $(this).find('.db-name').html();
		$.get('/collection/index/'+dbName,function(data){
			$('#Contents').html(data);
		})
	});
});