<?php
/**
 * Created by PhpStorm.
 * User: ACER
 * Date: 03.12.2018
 * Time: 15:35
 */
class Task extends  model{
    const HEIGHT_IMAGE = 240;
    const WIDTH_IMAGE  = 320;

    public function create($body,$img,$email){
        #Создаем задачу
        $nameImage = $this->uploadImage($img);
        $user_id = $this->getUser();
        $in_user = $this->DBH->prepare("INSERT INTO `tasks`(`user_id`, `email`, `body`, `image`) VALUES (?,?, ?, ?) ");
        if($in_user->execute([$user_id, $email, $body, $nameImage]))
            echo "success";
    }

    public function getUser(){
        #смотрим автризирован ли пользователь
      return $_SESSION['id']? $_SESSION['id']:null;
    }

    public function getData($sortName = null, $sort = null, $page = null){
        # Создаем начальный запрос, который будет присутсвовать везде
        $query = "SELECT p.id AS `id`, p.body AS `body`, p.image AS `image`, p.status AS `status`,p.email AS `email`, u.username AS `username` FROM `tasks` AS p LEFT JOIN `users` AS u ON p.`user_id` =  u.`id` ORDER by ";

        # Забираем количество записей , это понадобится для постраничной навигации
        $count_sl = $this->DBH->query("SELECT count(*) FROM `tasks`");
        $count = implode($count_sl->fetch());

        # Проверяем еесть ли параметр сортировки, если да подстраиваем запрос для вывода
       if($sortName && $sort){
            $query .= " `$sortName` $sort, id DESC";
       }else
           $query .= '`id` DESC';
        if($count != 3 && !$page){
            # ограничиваем количество задач на странице
            $query .= ' limit 3';
            $returnArr['pages'] = ceil($count/3);
        }elseif ($count != 3 && $page){
        # Подсчитываем смотря на параметр на какой странице мы должны быть
            $pageQuery = $page * 3 - 3;
            $returnArr['pages'] = ceil($count/3);
            if($page > $returnArr['pages']){
            # если страница не соответствует , выдаем ошибку
                Route::ErrorPage404();
                die();
            }
        # если страница не первая то мы лимитирауем записи и выводим с той, с которой должна быть страница добавляя к нашему запросу параметр лимита
            $returnArr['currentPage'] = $page;
            $query .= " limit $pageQuery, 3";
        }else $returnArr['tasks'] = 'Tasks not found';
        # отправляем наш запрос
        $sl_orders = $this->DBH->query($query);

        # получаем данные запроса и формируем их
        $returnArr['tasks'] =  $this->htmlFormired($sl_orders->fetchAll());
        return $returnArr ;

    }
    public function htmlFormired($data){
        #Формируем строку для наших задач
        $html = '';
        foreach($data as $task){
            $html .= '<div class="row item-task-body border-bottom">';
                $html .= '<div class="d-none" id="id-task">'.$task['id'].'</div>';
                if(!$task['username'])
                    $html .= '<div class="col-md-2 guest">Guest</div>'.'<div class="col-md-2">'.$task['email'].'</div>';
                else $html .= '<div class="col-md-2">'.$task['username'].'</div><div class="col-md-2">'.$task['email'].'</div>';

                $html .= '<div class="col-md-3 text-left task-text-container">';
                if($_SESSION['role'] == 9)
                    $html .= '<div class="task-text" onclick="taskText(this)">'.$task['body'].'</div>';
                else
                    $html .= $task['body'];
                $html .= '</div>';
                $html .= '<div class="col-md-3 image"><img src="/uploads/img/tasks/'.$task['image'].'" alt=""></div>';
                $status = $task['status'] == 1?"No completed":"Сompleted";
                if($_SESSION['role'] && $_SESSION['role'] == 9)
                    $html .= '<div class="col-md-2"><div class="update-status" onclick="updateStatus(this)">'.$status.'</div></div>';
                else
                    $html .= '<div class="col-md-2">'.$status.'</div>';
            $html .= '</div>';

        }
        return $html;
    }
    public function update($id, $body = null, $status = null){
        $query = "UPDATE `tasks` SET  ";
        if($body)
            $query .= "`body` = '$body'";
        if($status)
            $query .= "`status` = '$status'";
        $query .= "  WHERE `id`= '$id'";
        $this->DBH->query($query);
        echo $body;
    }
    public function uploadImage($image){
        $randomString = md5(uniqid(rand(), true));
        $infoImg = getimagesize($image);
        $typeImg = str_replace('image/','',$infoImg['mime']);
        $name =  $randomString.'_task.'.$typeImg;
        $width_orig =  $infoImg[0];
        $height_orig = $infoImg[1];
        $image =  $this->decodeImage($image, $typeImg);
        if($width_orig > 320 || $height_orig >240)
            $image = $this->resizeImage($image,$width_orig,$height_orig);
        if($this->writeImage($image,$typeImg,$name))
            return $name;
    }



    public function decodeImage($image, $typeImg){
        # Создаем изображение из base64 формата
        switch($typeImg) {
            case 'bmp':
                return imagecreatefromwbmp($image);
                break;
            case 'gif':
                return  imagecreatefromgif($image);
                break;
            case 'jpg':
                return  imagecreatefromjpeg($image);
                break;
            case 'jpeg':
                return  imagecreatefromjpeg($image);
                break;
            case 'png':
                return  imagecreatefrompng($image);
                break;
            default :
                echo "Unsupported picture type!";
                return false;
        }
    }

    public function resizeImage($image,$width_orig,$height_orig){
        # Меняем размер изображения
        $height = self::WIDTH_IMAGE /($width_orig/$height_orig);
        $image_p = imagecreatetruecolor(self::WIDTH_IMAGE, $height);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, self::WIDTH_IMAGE, $height, $width_orig, $height_orig);
        return  $image_p;
    }

    public function writeImage($image,$typeImg,$name){
        # Определяем какое расширение картинки нам создавать
        $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/img/tasks/'.$name;
        switch($typeImg) {
            case 'bmp':
                return  imagebmp($image, $path);
                break;
            case 'gif':
                return   imagegif($image, $path);
                break;
            case 'jpg':
                return   imagejpeg($image, $path,100);
                break;
            case 'jpeg':
                return   imagejpeg($image, $path,100);
                break;
            case 'png':
                return   imagepng($image, $path);
                break;
            default :
                echo "Unsupported picture type!";
                return false;
        }
    }
}