<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('upload image');

$username = $I->fake('username');
$email = $I->fake('email');
$phone = $I->fake('PhoneNumber');
$password = $I->fake('password');
$imagePath = $I->fake('imagePath');

// I am registered and authorized
$I->register($username, $email, $phone, $password);

// upload file
$imageUrl = $I->fileUpload($imagePath);

// image exists
$I->sendGET($imageUrl);
$I->seeResponseCodeIs(200);