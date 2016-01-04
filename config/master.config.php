<?php 
return [
	'db' => [
		'MongoDB' =>[
			'host'=>'localhost',
			'port'=>'27017',
			'user'=>'admin',
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
