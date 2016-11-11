<?php
	//Constantes
	$configs = new HXPHP\System\Configs\Config;

	$configs->env->add('development');

	$configs->env->development->baseURI = '/Levrochet/';

	$configs->env->development->database->setConnectionData([
		'host' => 'localhost', 
		'user' => 'root',
		'password' => '',
		'dbname' => 'sistemahx'

	]);

	$configs->env->development->auth->setURLs('/Levrochet/home/', '/Levrochet/login/');
	$configs->env->development->menu->setMenus(array(
		'Home/dashboard' => '%baseURI%/home',
		'Projetos/briefcase' => '%baseURI%/projetos',
		'Editar Perfil/cog' => '%baseURI%/perfil/editar'
	), 'administrator');

	$configs->env->development->menu->setMenus(array(
		'Home/dashboard' => '%baseURI%/home'
	), 'user');

	$configs->env->development->menu->setConfigs(array(
		'container' => 'nav',
		'container_id' => '',
		'container_class' => 'navbar navbar-default',
		'menu_id' => 'menu',
		'menu_class' => 'navbar-nav nav',
		'menu_item_class' => 'menu-item',
		'menu_item_active_class' => 'active',
		'menu_item_dropdown_class' => 'dropdown',
		'link_before' => '<span>',
		'link_after' => '</span>',
		'link_class' => 'menu-link',
		'link_active_class' => 'menu-active-link',
		'link_dropdown_class' => 'dropdown-toggle',
		'link_dropdown_attrs' => [
			'data-toggle' => 'dropdown'
		],
		'dropdown_class' => 'dropdown-menu',
		'dropdown_item_class' => 'dropdown-item',
		'dropdown_item_active_class' => 'active'
	));
 
	//-----------------------PRODUCTION--------------------------------------------

	$configs->env->add('production');

	$configs->env->production->baseURI = '/Levrochet/';

	$configs->env->production->database->setConnectionData([
		'host' => 'localhost', 
		'user' => 'root',
		'password' => '',
		'dbname' => 'sistemahx'

	]);

	$configs->env->production->auth->setURLs('/Levrochet/home/', '/Levrochet/login/');
		$configs->env->development->menu->setMenus(array(
		'Home/dashboard' => '%baseURI%/home',
		'Projetos/briefcase' => '%baseURI%/projetos',
		'Editar Perfil/cog' => '%baseURI%/perfil/editar'
	), 'administrator');

	$configs->env->development->menu->setMenus(array(
		'Home/dashboard' => '%baseURI%/home'
	), 'user');

	/*
		//Globais
		$configs->title = 'Titulo customizado';

		//Configurações de Ambiente - Desenvolvimento
		$configs->env->add('development');

		$configs->env->development->baseURI = '/hxphp/';

		$configs->env->development->database->setConnectionData([
			'driver' => 'mysql',
			'host' => 'localhost',
			'user' => 'root',
			'password' => '',
			'dbname' => 'hxphp',
			'charset' => 'utf8'
		]);

		$configs->env->development->mail->setFrom([
			'from' => 'Remetente',
			'from_mail' => 'email@remetente.com.br'
		]);

		$configs->env->development->menu->setConfigs([
			'container' => 'nav',
			'container_class' => 'navbar navbar-default',
			'menu_class' => 'nav navbar-nav'
		]);

		$configs->env->development->menu->setMenus([
			'Home/home' => '%siteURL%',
			'Subpasta/folder-open' => [
				'Home/home' => '%baseURI%/admin/have-fun/',
				'Teste/home' => '%baseURI%/admin/index/',
			]
		]);

		$configs->env->development->auth->setURLs('/hxphp/home/', '/hxphp/login/');
		$configs->env->development->auth->setURLs('/hxphp/admin/home/', '/hxphp/admin/login/', 'admin');

		//Configurações de Ambiente - Produção
		$configs->env->add('production');

		$configs->env->production->baseURI = '/';

		$configs->env->production->database->setConnectionData([
			'driver' => 'mysql',
			'host' => 'localhost',
			'user' => 'usuariodobanco',
			'password' => 'senhadobanco',
			'dbname' => 'hxphp',
			'charset' => 'utf8'
		]);

		$configs->env->production->mail->setFrom([
			'from' => 'Remetente',
			'from_mail' => 'email@remetente.com.br'
		]);
	*/


	return $configs;
