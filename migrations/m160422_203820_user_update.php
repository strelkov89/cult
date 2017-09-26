<?php

use yii\db\Schema;
use yii\db\Migration;

class m160422_203820_user_update extends Migration
{
    public function up()
    {
        $this->execute(
            "INSERT INTO `user` (`id`, `username`, `email`, `confirmed_at`, `created_at`, `updated_at`, `phone`) VALUES
            ('600', 'unknown0@unknown.com', 'unknown0@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('601', 'unknown1@unknown.com', 'unknown1@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('602', 'unknown2@unknown.com', 'unknown2@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('603', 'unknown3@unknown.com', 'unknown3@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('604', 'unknown4@unknown.com', 'unknown4@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('605', 'unknown5@unknown.com', 'unknown5@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('606', 'unknown6@unknown.com', 'unknown6@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('607', 'unknown7@unknown.com', 'unknown7@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('608', 'unknown8@unknown.com', 'unknown8@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('609', 'unknown9@unknown.com', 'unknown9@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('610', 'unknown10@unknown.com', 'unknown10@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('611', 'unknown11@unknown.com', 'unknown11@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('612', 'unknown12@unknown.com', 'unknown12@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('613', 'unknown13@unknown.com', 'unknown13@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('614', 'unknown14@unknown.com', 'unknown14@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('615', 'unknown15@unknown.com', 'unknown15@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('616', 'unknown16@unknown.com', 'unknown16@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('617', 'unknown17@unknown.com', 'unknown17@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('618', 'unknown18@unknown.com', 'unknown18@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('619', 'unknown19@unknown.com', 'unknown19@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('620', 'unknown20@unknown.com', 'unknown20@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('621', 'unknown21@unknown.com', 'unknown21@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('622', 'unknown22@unknown.com', 'unknown22@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('623', 'unknown23@unknown.com', 'unknown23@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('624', 'unknown24@unknown.com', 'unknown24@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('625', 'unknown25@unknown.com', 'unknown25@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('626', 'unknown26@unknown.com', 'unknown26@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('627', 'unknown27@unknown.com', 'unknown27@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('628', 'unknown28@unknown.com', 'unknown28@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('629', 'unknown29@unknown.com', 'unknown29@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('630', 'unknown30@unknown.com', 'unknown30@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('631', 'unknown31@unknown.com', 'unknown31@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('632', 'unknown32@unknown.com', 'unknown32@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('633', 'unknown33@unknown.com', 'unknown33@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('634', 'unknown34@unknown.com', 'unknown34@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('635', 'unknown35@unknown.com', 'unknown35@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('636', 'unknown36@unknown.com', 'unknown36@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('637', 'unknown37@unknown.com', 'unknown37@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('638', 'unknown38@unknown.com', 'unknown38@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('639', 'unknown39@unknown.com', 'unknown39@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('640', 'unknown40@unknown.com', 'unknown40@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('641', 'unknown41@unknown.com', 'unknown41@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('642', 'unknown42@unknown.com', 'unknown42@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('643', 'unknown43@unknown.com', 'unknown43@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('644', 'unknown44@unknown.com', 'unknown44@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('645', 'unknown45@unknown.com', 'unknown45@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' ),
            ('646', 'unknown46@unknown.com', 'unknown46@unknown.com', '1461363460', '1461363460', '1461363460', '7777777' );"
        );
        
        $this->execute(
            "INSERT INTO `profile` (`user_id`, `name`, `lastName`, `city`) VALUES
            ('600', 'Дарья', 'Горчакова', 'unknown'),
            ('601', 'Ирина', 'Кочеткова', 'unknown'),
            ('602', 'Алексей', 'Варников', 'unknown'),
            ('603', 'Андрей', 'Искорнев', 'unknown'),
            ('604', 'Артем', 'Корсунов', 'unknown'),
            ('605', 'Ольга', 'Кукоба', 'unknown'),
            ('606', 'Владислав', 'Михайленко', 'unknown'),
            ('607', 'Дмитрий', 'Юницкий', 'unknown'),
            ('608', 'Николай', 'Зарубинский', 'unknown'),
            ('609', 'Луиза', 'Изнаурова', 'unknown'),
            ('610', 'Ольга', 'Полищук', 'unknown'),
            ('611', 'Дмитрий', 'Абрамов', 'unknown'),
            ('612', 'Софья', 'Троценко', 'unknown'),
            ('613', 'Дмитрий', 'Рыжков', 'unknown'),
            ('614', 'Алексей', 'Копчиков', 'unknown'),
            ('615', 'Олег', 'Дронов', 'unknown'),
            ('616', 'Михаил', 'Вайсман', 'unknown'),
            ('617', 'Денис', 'Кудинов', 'unknown'),
            ('618', 'Алексей', 'Исаченко', 'unknown'),
            ('619', 'Замир', 'Шухов', 'unknown'),
            ('620', 'Даниил', 'Козлов', 'unknown'),
            ('621', 'Ирина', 'Колоскова', 'unknown'),
            ('622', 'Евгения', 'Андольщик', 'unknown'),
            ('623', 'Денис', 'Чернецкий', 'unknown'),
            ('624', 'Богдан', 'Бакалейко', 'unknown'),
            ('625', 'Наташа', 'Андреева', 'unknown'),
            ('626', 'Нурлан', 'Гасыев', 'unknown'),
            ('627', 'Артур', 'Мискарян', 'unknown'),
            ('628', 'Ярослав', 'Федосеев', 'unknown'),
            ('629', 'Ксения', 'Марьясова', 'unknown'),
            ('630', 'Чулпан', 'Биккузина', 'unknown'),
            ('631', 'Ксения', 'Кузьмина', 'unknown'),
            ('632', 'Ольга', 'Лобанова', 'unknown'),
            ('633', 'Сэсэг', 'Тубанова', 'unknown'),
            ('634', 'Кристина', 'Ревуэльта', 'unknown'),
            ('635', 'Александр', 'Цветков', 'unknown'),
            ('636', 'Галия', 'Ибрагимова', 'unknown'),
            ('637', 'Катя', 'Гробман', 'unknown'),
            ('638', 'Алина', 'Пищерикова', 'unknown'),
            ('639', 'Илья', 'Лакстыгал', 'unknown'),
            ('640', 'Наташа', 'Полыця', 'unknown'),
            ('641', 'Настя', 'Бабанова', 'unknown'),
            ('642', 'Полина', 'Табагари', 'unknown'),
            ('643', 'Тамара', 'Муллаходжаева', 'unknown'),
            ('644', 'Светлана', 'Ивина', 'unknown'),
            ('645', 'Анастасия', 'Бабанова', 'unknown'),
            ('646', 'Михил', 'Граафстал', 'unknown');"
        );
    }

    public function down()
    {
        echo "m160422_203820_user_update cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
