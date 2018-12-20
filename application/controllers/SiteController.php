<?php
#Подключаем необходимые модели
include $_SERVER['DOCUMENT_ROOT']."/application/models/User.php";
include $_SERVER['DOCUMENT_ROOT']."/application/models/Task.php";

class SiteController extends Controller
{
	function actionIndex()
	{
	   # главный экшен рендера задач , дабы упростить код , я прохожу одним методом по своим задачам, есть гет и пост запросы
        $model =  new Task;
        if($_GET['page']){
            $data = $model->getData(null,null,$_GET['page']);
            $this->view->generate('site.php', 'layout.php',$data);
        }
        elseif($_GET){
            echo json_encode($model->getData($_GET['sortname'],$_GET['sort'],$_GET['pageget']));
       }
        else{
            $data = $model->getData();
            $this->view->generate('site.php', 'layout.php',$data);
        }
	}
    public function actionSignup(){
        # регистрируемся
        if($_POST['Signup']){
            $model = new User;
            $model->signup($_POST['Signup']);
        }else
            $_SESSION['username']? header('Location: ../'): $this->view->generate('signup.php', 'layout.php');
    }

    public function actionLogin(){
	    # логинимся
        if($_POST['Login']){
            $model = new User;
            $model->login($_POST['Login']);
        }else
            $_SESSION['username']? header('Location: ../'): $this->view->generate('login.php', 'layout.php');

    }
    public function actionLogout(){
        User::logout();
        header('Location: ../');
    }
    public function actionUpdateTaskBody(){
    # формируем переменные и отправляем в модель для обновления задачи
        $id = $_POST['id'];
	    if($_POST['status'])
	        $status = $_POST['status'];
	    if($_POST['body'])
            $body = $_POST['body'];
        $model = new Task;
        $model->update($id, $body, $status);
    }
    public function actionTaskCreate(){
	    # формируем переменные и отправляем в модель для создания задачи
       if($_POST['Task']) {
            $model = new Task;
            $body = $_POST['Task']['body'];
            $image = $_POST['Task']['img'];
            $email  = $_POST['Task']['email'];
           $model->create($body, $image, $email);
        }
    }
}


