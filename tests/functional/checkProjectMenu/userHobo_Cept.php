<?php
$I = new FunctionalTester($scenario);
$I->wantTo('Check menu, when user does not have the project & request');

// Login
$username = $I->fake('username');
$email = $I->fake('email');
$phone = $I->fake('PhoneNumber');
$password = $I->fake('password');

// registration
$I->register($username, $email, $phone, $password);

// !!! Проверка МЕНЮ:
$I->see('Создать проект', 'ul.nav a');
$I->see('Вступить в проект', 'ul.nav a');