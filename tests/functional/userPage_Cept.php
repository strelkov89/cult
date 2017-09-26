<?php
$I = new FunctionalTester($scenario);
$I->wantTo('see user page');

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

// go to user page
$user_id = $I->grabFromDatabase('user', 'id', ['username' => $username]);
$I->amOnPage('/user/'.$user_id);

// see portfolio on user's page
$I->see($name);
if ($is_coder) {
    $I->see('Программист');
}
if ($is_designer) {
    $I->see('Дизайнер');
}
if ($is_ux) {
    $I->see('UX-специалист');
}
$I->see($about);
foreach (explode(' ', $portfolio_links) as $link) {
    $I->seeLink($link);
}

$I->see($portfolio_images);