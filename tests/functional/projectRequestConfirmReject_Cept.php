<?php

$I = new FunctionalTester($scenario);
$I->wantTo('Confirm request & reject request');

// Login 1
$username = $I->fake('username');
$email = $I->fake('email');
$phone = $I->fake('PhoneNumber');
$password = $I->fake('password');

// Login 2
$username2 = $I->fake('username');
$email2 = $I->fake('email');
$phone2 = $I->fake('PhoneNumber');
$password2 = $I->fake('password');

// portfolio
$name = $I->fake('name');
$is_coder = true;
$is_designer = false;
$is_ux = false;
$about = '';
$portfolio_links = '';

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
$I->click('Выйти');

// вступаем в проект
$I->register($username2, $email2, $phone2, $password2);
// у меня есть портфолио
$I->createPortfolio(
    $name, $is_coder, $is_designer, $is_ux, $about, $portfolio_links, null
);
$I->amOnPage('/project/list');
$I->click('.panel-body .list-view > div:last-child button[type=submit]');
$I->see('Заявка на участие в проекте успешно отправлена');
$I->click('Выйти');

// подтверждаем заявку
$I->amOnPage('/user/login');
$I->fillField('Логин', $username);
$I->fillField("input[type='password']", $password);
$I->click('Авторизоваться');
//$I->fillField('Пароль (<a href="/user/forgot" tabindex="5">Забыли пароль?</a>)', $password);
$I->amOnPage('/project');
$I->click('.panel-body button[type=submit][title="Подтвердить заявку"]');
$I->see('Заявка успешно подтверждена');

// отклоняем заявку
$I->amOnPage('/project');
$I->click('.panel-body button[type=submit][title="Удалить участника"]');
$I->see('Участник успешно удалён из проекта');
