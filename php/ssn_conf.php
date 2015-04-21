<?php

class SSN_PREFS {

// common prefs
static $ssn_details_db = array(
    'user' => 'ssn',
    'pass' => '123456',
    'db'   => 'ssn',
    'host' => 'localhost'
);

static $ssn_details_app = array(
		'ws_server' => 'http://ssn', // address of the web service server
		'proxy_server' => 'localhost', // address of the proxy server to MC
		'proxy_port' => 10001, // proxy server port
		'ws_data_mode' => 'sinc', // data webservice mode: "sinc" - direct send messages to hardware, "asinc" - queueing messages to DB 
		'text_data' => array (
			'en' => array (
				'main_menu_proj' => 'Smart-Home Sensors Network',
				'main_menu_home' => 'Home',
				'main_menu_about' => 'About',
				'main_menu_contact' => 'Contact',
				'main_menu_login' => 'Login',
				'main_menu_logout' => 'Logout',
				'main_menu_short' => 'Short',
				'main_menu_detail' => 'Detail',
				'main_menu_graph' => 'Graph',
				'main_menu_commands' => 'Commands',
				'main_title' => 'Smart-House Sensors Network: all about your house',
				'main_short_text' => 'Simplified table with sensors data',
				'main_detail_text' => 'Full sensors data table',
				'main_graph_text' => 'Graphical representation sensors data',
				'main_cmd_text' => 'Commands to devices',
				'login_message' => 'Please sign in', 
				'login_remember_me' => 'Remember me', 
				'ssn_commands_title' => 'Commands to devices',
				'ssn_commands_table_head_devs' => 'Devices', 
				'ssn_commands_table_head_cmd' => 'Commands', 
				'table_data_name' => 'Devices data',
				'table_data_search' => 'Search',
				'table_data_id' => 'ID',
				'table_data_obj' => 'Object',
				'table_data_device' => 'Sensor',
				'table_data_index' => 'Index',
				'table_data_value' => 'Value',
				'table_data_time_dev' => 'Measure time',
				'table_data_time_store' => 'Store time'
			),
			'ru' => array (
				'main_menu_proj' => 'Smart-Home Sensors Network',
				'main_menu_home' => 'Главная',
				'main_menu_about' => 'О системе',
				'main_menu_contact' => 'Контакты',
				'main_menu_login' => 'Вход',
				'main_menu_logout' => 'Выход',
				'main_menu_short' => 'Простая',
				'main_menu_detail' => 'Подробная',
				'main_menu_graph' => 'График',
				'main_menu_commands' => 'Команды',
				'main_title' => 'Smart-House Sensors Network: о вашем доме всё',
				'main_short_text' => 'Упрощенная таблица показаний датчиков с наиболее важными данными - номер датчика, значение величины, времени получения показаний. Данные по умолчанию отсортированы по убыванию времени и обновляются автоматически каждые полминуты. ',
				'main_detail_text' => 'Таблица показаний датчиков с полным набором атрибутов - номер показания, объект, на котором установлен датчик, номер/индекс датчика, значение величины, время опроса датчика, время получения показаний. Данные по умолчанию отсортированы по убыванию времени передачи и обновляются автоматически каждые полминуты. ',
				'main_graph_text' => 'Графики динамики показателей во времени. По умолчанию выбирается первый по списку датчик и интервал за предыдущие сутки. При желании на одном графике можно выбрать несколько датчиков и произвольный период измерений. График интерактивный - можно менять детализацию на временной шкале вплоть до отдельных измерений.',
				'main_cmd_text' => 'Интерактивное взаимодействие с устройствами. В зависимости от типа устройства отображается доступный для него список сервисов и допустимых значений. ',
				'login_message' => 'Пожалуйста авторизуйтесь',
				'login_remember_me' => 'Запомнить меня', 
				'ssn_commands_title' => 'Команды устройствам',
				'ssn_commands_table_head_devs' => 'Устройства', 
				'ssn_commands_table_head_cmd' => 'Команды', 
				'table_data_name' => 'Показания датчиков',
				'table_data_search' => 'Искать',
				'table_data_id' => 'ID',
				'table_data_obj' => 'Объект',
				'table_data_device' => 'Датчик',
				'table_data_index' => 'Показатель',
				'table_data_value' => 'Значение',
				'table_data_time_dev' => 'Время измерения',
				'table_data_time_store' => 'Время передачи'
			)
		)
);

static function get_ssn_prefs_db() {
	
	return self::$ssn_details_db;
}

static function get_ssn_prefs_app() {
	
	return self::$ssn_details_app;
}

static function ssn_get_app_pref ($pref_key )
{
	return self::$ssn_details_app[$pref_key];
}

static function ssn_get_text ( $lang, $text_key )
{
	$def_lang = 'en';
	$text_ret = self::$ssn_details_app['text_data'][$lang][$text_key];
	return $text_ret;
}

}
?>