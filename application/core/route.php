<?php
/*
Класс-маршрутизатор для определения запрашиваемой страницы.
> цепляет классы контроллеров и моделей;
> создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
*/
class Route
{
	static function start()
	{
		// контроллер и действие по умолчанию
		$controller_name = 'Site';
		$action_name = 'index';
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		// получаем имя контроллера
		if ( !empty($routes[1]) )
		{
			$controller_name = $routes[1];

		}
		// получаем имя экшена
		if ( !empty($routes[2]) )
		{
		    if(stristr($routes[2], '?')){
                $urlArr = explode('?',$routes[2]);
                $routes[2] = $urlArr[0];
                $getArr = explode('&',$urlArr[1]);
                foreach($getArr as $getVal => $getValKey){
                    $getStrArr = explode('=',$getValKey);
                    $_GET[$getStrArr[0]] = $getStrArr[1];
                }
            }
			$action_name =  stristr($routes[2], '-')? str_replace('-','',$routes[2]) :$routes[2];
		}

		// добавляем префиксы
		$model_name = 'User';
		$controller_name = $controller_name.'Controller';
		$action_name = 'action'.$action_name;

		// подцепляем файл с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "application/controllers/".$controller_file;
		if(file_exists($controller_path))
		{
			include "application/controllers/".$controller_file;
            $controller = new $controller_name;
            $action = $action_name;
            // создаем контроллер
            if(method_exists($controller, $action))
                // вызываем действие контроллера
                $controller->$action();

		}
		else
		{
			/*
			 редирект на страницу 404
			*/
			Route::ErrorPage404();
		}


	}

	function ErrorPage404()
	{
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
        View::generate('404_view.php', 'layout.php');
    }

}
