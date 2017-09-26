<?php

$I = new FunctionalTester($scenario);
$I->wantTo('Join to project');

// Login
$username = $I->fake('username');
$email = $I->fake('email');
$phone = $I->fake('PhoneNumber');
$password = $I->fake('password');

// portfolio
$name = $I->fake('name');
$is_coder = true;
$is_designer = $I->fake('boolean');
$is_ux = $I->fake('boolean');
$about = $I->fake('text');
$portfolio_links = $I->fake('url') . ' ' . $I->fake('url');
$imagePath = $I->fake('imagePath');

// project 1
$project_title = $I->fake('name');
$project_desc = $I->fake('Text');
$project_created_at = $I->fake('unixTime');
// project 2
$project_title2 = $I->fake('name');
$project_desc2 = $I->fake('Text');
$project_need_coder2 = true;
$project_created_at2 = $I->fake('unixTime');


// в базе лежат проеты
//1
$I->haveInDatabase('project', [
    'title' => $project_title,
    'description' => $project_desc,
    'author_id' => null,
    'created_at' => $project_created_at,
    'status' => 1,
        ]
);

//2
$I->haveInDatabase('project', [
    'title' => $project_title2,
    'description' => $project_desc2,
    'need_coder' => $project_need_coder2,
    'author_id' => null,
    'created_at' => $project_created_at2,
    'status' => 1,
        ]
);

// registration
$I->register($username, $email, $phone, $password);

// page after registration
$I->seeCurrentUrlEquals('/user/settings/profile');

// у меня есть портфолио
$portfolio_images = $I->fileUpload($imagePath);
$I->createPortfolio(
    $name, $is_coder, $is_designer, $is_ux, $about, $portfolio_links, $portfolio_images
);

// Страница со списком проектов
$I->amOnPage('/project/list');

$I->see($project_title);
$I->see($project_title2);

// я вступаю в проект, в котором меня ждут
$I->click('.panel-body .media button[type=submit][disabled!=disabled]');

// я вижу что моя заявка отправилась
$I->see('Заявка на участие в проекте успешно отправлена');
