<?php
$I = new FunctionalTester($scenario);
$I->wantTo('register, logout and login');

$username = $I->fake('username');
$email = $I->fake('email');
$phone = $I->fake('PhoneNumber');
$password = $I->fake('password');

// registration
$I->register($username, $email, $phone, $password);
// on portfolio page after registration
$I->seeCurrentUrlEquals('/user/settings/profile');
$I->seeLink('Выйти');

// logging out
$I->click('Выйти');
$I->seeLink('Войти');

// logging in
$I->login($username, $password);
$I->seeLink('Выйти');
// on portfolio page after registration
$I->seeCurrentUrlEquals('/user/settings/profile');