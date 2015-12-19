<?php 
return [
	'db' => [
		'MySQL' => [
			'host'=>'localhost',
			'user'=>'root',
			'pass'=>'',
			'database'=>'skankytest',
		],
		'MongoDB' =>[
			'host'=>'localhost',
			'port'=>'27017',
			'user'=>'admin',
			'pass'=>'',
			'database'=>'skankydev',
		]
	],
	'routes' =>[
		'/' => [
			'options'=>[
				'controller' => 'Database',
				'action'     => 'index',
				'namespace'  => 'PHPMyMongoAdmin'
			]
		],
	],	
];
