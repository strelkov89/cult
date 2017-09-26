<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Module;
use Codeception\Util\Debug;
use Faker\Factory;

class FunctionalHelper extends Module
{
    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * Die and dump
     *
     * @param mixed $var
     */
    public function dd($var)
    {
        Debug::debug($var);
        die();
    }

    /**
     * Get fake data
     *
     * @return mixed
     */
    public function fake($field)
    {
        if (null === $this->faker) {
            $this->faker = Factory::create('ru_RU');
        }

        $lookup = [
            'password' => 'qwerty123',
            'imagePath' => __DIR__."/../_data/кот\x20с\x20пробелами.jpg",
        ];

        if (isset($lookup[$field])) {
            return $lookup[$field];
        }

        // special case for username
        if ('username' === $field) {
            return str_replace('.', '', $this->faker->userName);
        }

        return $this->faker->{$field};
    }

    /**
     * Registration
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @throws \Codeception\Exception\Module
     */
    public function register($username, $email, $phone, $password)
    {
        $browser_I = $this->getModule('PhpBrowser');
        $mailcatcher_I = $this->getModule('MailCatcher');

        // clear emails in mailcatcher
        $mailcatcher_I->resetEmails();

        // registration link exists
        $browser_I->amOnPage('/');
        $browser_I->click('Регистрация');

        // submitting registration form
        $browser_I->fillField('Имя пользователя', $username);
        $browser_I->fillField('Email', $email);
        $browser_I->fillField('Телефон', $phone);
        $browser_I->fillField('Пароль', $password);
        $browser_I->click('Зарегистрироваться');

        // confirm email
        $confirmationUrl = $mailcatcher_I->grabFromLastEmail('/https?\:\/\/[^\s]+/i');
        $browser_I->amOnPage($confirmationUrl);
    }

    /**
     * Login
     *
     * @param string $username
     * @param string $password
     * @throws \Codeception\Exception\Module
     */
    public function login($username, $password)
    {
        $browser_I = $this->getModule('PhpBrowser');

        // login link exists
        $browser_I->amOnPage('/');
        $browser_I->click('Войти');

        // submitting registration form
        $browser_I->fillField('Логин', $username);
        $browser_I->fillField('#login-form-password', $password);
        $browser_I->click('Авторизоваться');
    }

    /**
     * File Upload
     *
     * @param string $filePath
     * @return string
     */
    public function fileUpload($filePath)
    {
        $rest_I = $this->getModule('REST');

        $rest_I->sendPOST('/file/upload', [], ['file' => $filePath]);
        return $rest_I->grabDataFromJsonResponse('url');
    }

    /**
     * Create Portfolio
     *
     * @param string $name
     * @param boolean $is_coder
     * @param boolean $is_designer
     * @param boolean $is_ux
     * @param string $about
     * @param string $portfolio_links
     * @param string $portfolio_images
     * @throws \Codeception\Exception\Module
     */
    public function createPortfolio($name, $is_coder, $is_designer, $is_ux, $about, $portfolio_links, $portfolio_images)
    {
        $browser_I = $this->getModule('PhpBrowser');

        // I fill all fields
        $browser_I->fillField('Имя', $name);
        if ($is_coder) {
            $browser_I->checkOption('#profile-is_coder');
        }
        if ($is_designer) {
            $browser_I->checkOption('#profile-is_designer');
        }
        if ($is_ux) {
            $browser_I->checkOption('#profile-is_ux');
        }

        $browser_I->fillField('О себе', $about);
        $browser_I->fillField('Ссылки на работы', $portfolio_links);
        $browser_I->fillField('Изображения работ', $portfolio_images);

        // I submit form
        $browser_I->click('Сохранить');
    }
    
    
    /**
     * Registration
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @throws \Codeception\Exception\Module
     */
    public function joinProject($username, $email, $password)
    {
        
        
    }
}
