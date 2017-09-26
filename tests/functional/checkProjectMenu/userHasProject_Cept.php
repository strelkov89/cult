<?php
$I = new FunctionalTester($scenario);
$I->wantTo('Check menu, when user has project');

// Login
$username = $I->fake('username');
$email = $I->fake('email');
$phone = $I->fake('PhoneNumber');
$password = $I->fake('password');

// registration
$I->register($username, $email, $phone, $password);

// Страница с формой
$I->amOnPage('/project');

// форма
$title = $I->fake('name');
$desc = $I->fake('text');
$I->fillField('Название', $title);
$I->fillField('Описание', $desc);
$I->checkOption('#project-need_coder');
$I->checkOption('#project-need_designer');

// I submit form
$I->click('Сохранить');

// I see changes applied
$I->see('Проект успешно создан');

// !!! Проверка МЕНЮ:
$I->see('Мой проект');
$I->seeElement('.panel-body ul.nav li a', ['href'=>'/project']);
$I->dontSeeElement('.panel-body ul.nav li a', ['href'=>'/project/list']);