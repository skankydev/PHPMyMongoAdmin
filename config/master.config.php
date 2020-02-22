<?php 
return [
	'db' => [
		'MongoDB' =>[
			'host'=>'localhost',
			'port'=>'27017',
			'user'=>'',
			'pass'=>''
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
