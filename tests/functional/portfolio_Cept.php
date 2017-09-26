<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('create portfolio');

$username = $I->fake('username');
$email = $I->fake('email');
$phone = $I->fake('PhoneNumber');
$password = $I->fake('password');

$name = $I->fake('name');
$is_coder = $I->fake('boolean');
$is_designer = $I->fake('boolean');
$is_ux = $I->fake('boolean');
$about = $I->fake('text');
$portfolio_links = $I->fake('url').' '.$I->fake('url');
$imagePath = $I->fake('imagePath');

// registration
$I->register($username, $email, $phone, $password);

// page after registration
$I->seeCurrentUrlEquals('/user/settings/profile');

// create portfolio
$portfolio_images = $I->fileUpload($imagePath);

$I->createPortfolio(
    $name,
    $is_coder,
    $is_designer,
    $is_ux,
    $about,
    $portfolio_links,
    $portfolio_images
);

// I see changes applied
$I->seeInField('Имя', $name);
if ($is_coder) {
    $I->seeCheckboxIsChecked('#profile-is_coder');
}
if ($is_designer) {
    $I->seeCheckboxIsChecked('#profile-is_designer');
}
if ($is_ux) {
    $I->seeCheckboxIsChecked('#profile-is_ux');
}
$I->seeInField('О себе', $about);
$I->seeInField('Ссылки на работы', $portfolio_links);
$I->seeInField('Изображения работ', $portfolio_images);