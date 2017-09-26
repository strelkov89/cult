<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('start registration on index page');

$username = $I->fake('username');
$email = $I->fake('email');

$I->amOnPage('/');
$I->fillField('username', $username);
$I->fillField('email', $email);
$I->click('Зарегистрироваться');

$I->seeCurrentUrlEquals('/user/register?username='.urlencode($username).'&email='.urlencode($email));
$I->seeInField('Имя пользователя', $username);
$I->seeInField('Email', $email);