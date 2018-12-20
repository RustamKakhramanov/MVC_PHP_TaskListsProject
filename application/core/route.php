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
		$action_name = 'Index';
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		// получаем имя контроллера
		if ( !empty($routes[1]) )
		{
			$controller_name = ucfirst ($routes[1]);

		}
		// получаем имя экшена
		if ( !empty($routes[2]) )
		{
			$action_name =  stristr($routes[2], '-')? str_replace('-','',$routes[2]) :$routes[2];
            if(stristr($routes[2], '?')){
                #Если есть Гет параметр то формируем его и обрезаем экшн
                $str= strpos($routes[2], "?");
                $action_name = substr($routes[2], 0, $str);

                $urlArr = explode('?',$routes[2]);
                $routes[2] = $urlArr[0];
                $getArr = explode('&',$urlArr[1]);
                foreach($getArr as $getVal => $getValKey){
                    $getStrArr = explode('=',$getValKey);
                    $_GET[$getStrArr[0]] = $getStrArr[1];
                }
            }
		}

		// добавляем префиксы
		$action_name = ucfirst($action_name);     
		$model_name = 'User';
		$controller_name = $controller_name.'Controller';
		$action_name = 'action'.$action_name;
		// подцепляем файл с классом контроллера
		$controller_file = $controller_name.'.php';
		$controller_path =  $_SERVER['DOCUMENT_ROOT']."/application/controllers/".$controller_file;
		if(file_exists($controller_path))
		{
			include $controller_path;
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
