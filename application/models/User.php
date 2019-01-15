<?php

@session_start();

class User extends model{

    public function Signup($post){
        $post = $this->serializeArray($post);
        $errors = [];
        # проверка на существование полей
        if (!isset($post['username'])  || !isset($post['password']) || !isset($post['confirmPassword']))
            $errors[] = "не хватает полей";

        # правильность заполнения полей
        if (!$post['username'] ||   !$post['password'] || !$post['confirmPassword'])
            $errors[] = "заполните поля";

        # ограничение числа аккаунтов до одного
        $sl_user = $this->DBH->prepare("SELECT `id` FROM `users` WHERE `username`=?");
        $sl_user->execute([$post['username']]);
        $row_user = $sl_user->fetch();
        if ($row_user)
            $errors[] = "такой аккаунт уже есть";

        # подтверждение пароля
        if ($post["password"] != $post["confirmPassword"])
            $errors[] = "пароли не совпадают";

        # шифрование пароля
        if (!$errors){
            $hash = password_hash($post['password'], PASSWORD_ARGON2I);
            $in_user = $this->DBH->prepare("INSERT INTO `users`(`username`, `password`) VALUES (?, ?) ");
            $in_user->execute([$post['username'],   $hash]);
            # авторизируем
            $sl_user = $this->DBH->prepare("SELECT `id`,`role` FROM `users` WHERE `username`=?");
            $sl_user->execute([$post['username']]);
            $row_user = $sl_user->fetch();
            $_SESSION['id'] = $row_user['id'];
            $_SESSION['username'] = $row_user['username'];
            $_SESSION['role'] = $row_user['role'];
        } else echo array_shift($errors);
    }
    public function Login($post){
        $post = $this->serializeArray($post);
        # проверка на существование полей
        $errors = [];
        if (!isset($post['username']) || !isset($post['password']))
            $errors[] = "не хватает полей";

        # правильность заполнения полей
        if (!$post['username'] || !$post['password'])
            $errors[] = "заполните поля";

        # проверка на существование пользователя
        $sl_user = $this->DBH->prepare("SELECT `id` , `password` , `username`,`role`  FROM `users` WHERE `username`=?");
        $sl_user->execute([$post['username']]);
        $row_user = $sl_user->fetch();

        if(!$row_user)
            $errors[] = "нет такого пользователя";

        if (!password_verify($post['password'], $row_user['password']))
            $errors[] = "пароль не верный";

        if (!$errors){
            $_SESSION['id'] = $row_user['id'];
            $_SESSION['username'] = $row_user['username'];
            $_SESSION['role'] = $row_user['role'];
        } else echo array_shift($errors);
    }
    public function Logout(){
        $_SESSION = "";
        session_destroy();
    }


}