<?php
$I = new FunctionalTester($scenario);
$I->wantTo('Create & Edit project');

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
$I->seeInField('Название', $title);
$I->seeInField('Описание', $desc);
$I->seeCheckboxIsChecked('#project-need_coder');
$I->seeCheckboxIsChecked('#project-need_designer');

// Edit
$I->fillField('Название', $title . ' new');

$I->click('Сохранить');

// I see changes applied
$I->see('Проект успешно изменён');
$I->seeInField('Название', $title . ' new');
$I->seeInField('Описание', $desc);
$I->seeCheckboxIsChecked('#project-need_coder');
$I->seeCheckboxIsChecked('#project-need_designer');
