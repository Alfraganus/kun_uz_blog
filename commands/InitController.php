<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class InitController extends Controller
{
    public function actionMakeEnv()
    {
        $dbHost = $this->prompt('MySQL server manzilini kiriting (misol: localhost):', [
            'required' => true,
            'default' => 'localhost',
        ]);
        $dbName = $this->prompt('Ma’lumotlar bazasi nomini kiriting (misol uchun: kunuz):', [
            'required' => true,
            'default' => 'kunuz',
        ]);
        $dbUsername = $this->prompt('MySQL username  kiriting (misol uchun: root):', [
            'required' => true,
            'default' => 'root',
        ]);
        $dbPassword = $this->prompt('MySQL parolini kiriting (bo’sh qoldirish mumkin):', [
            'required' => false,
        ]);

                $envContent = <<<ENV
        DB_HOST=$dbHost
        DB_NAME=$dbName
        DB_USERNAME=$dbUsername
        DB_PASSWORD=$dbPassword
        ENV;

        $filePath = \Yii::getAlias('@app') . '/.env';
        if (file_put_contents($filePath, $envContent)) {
            $this->stdout(".env fayli muvaffaqiyatli yaratildi!\n", Console::FG_GREEN);
        } else {
            $this->stderr(".env faylini yaratishda xatolik yuz berdi!\n", Console::FG_RED);
        }

        return ExitCode::OK;
    }

    public function actionStart()
    {
        $envFilePath = \Yii::getAlias('@app') . '/.env';

        if (!file_exists($envFilePath)) {
            $this->stderr("Assalomu alykum, sizda hali .env yaratilmagan, iltimos  php yii init/make-env orqali yarating yoki root fayl ichida .env yaratib oling!\n");
            return ExitCode::OK;
        }

        $this->stdout(".env file exists.\n");

        $envData = parse_ini_file($envFilePath);

        $dbHost = $envData['DB_HOST'] ?? null;
        $dbName = $envData['DB_NAME'] ?? null;
        $dbUsername = $envData['DB_USERNAME'] ?? null;
        $dbPassword = $envData['DB_PASSWORD'] ?? null;

        if (!$dbHost || !$dbName || !$dbUsername) {
            $this->stderr("Databaza  maʼlumotlari .env faylida toʻliq emas, iltimos tekshirib, qayta urinib koʻring.\n");
            return ExitCode::OK;
        }

        $this->stdout("Databazaga ulanish tekshirilmoqda...\n");

        try {
            $dsn = "mysql:host=$dbHost";
            $pdo = new \PDO($dsn, $dbUsername, $dbPassword);

            $stmt = $pdo->query("SHOW DATABASES LIKE '$dbName'");
            if ($stmt->rowCount() > 0) {
                $this->stdout("Maʼlumotlar bazasi '$dbName' mavjud.\n", Console::FG_GREEN);
            } else {
                $this->stdout("Maʼlumotlar bazasi '$dbName' mavjud emas.\n", Console::FG_YELLOW);

                if ($this->confirm("'$dbName' maʼlumotlar bazasini yaratilsinmi?")) {
                    $pdo->exec("CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                    $this->stdout("'$dbName' maʼlumotlar bazasi muvaffaqiyatli yaratildi.\n", Console::FG_GREEN);
                } else {
                    $this->stderr("Databze '$dbName' yaralmadi. Ushbu sozlamadan uzilmoqda.\n", Console::FG_RED);
                }
            }

            if ($this->confirm("Migratsiyalar yurgizilsinmi?")) {
                $this->stdout("Migratsiyalar yurgisilmoqda...\n", Console::FG_GREEN);

                $migrationController = new \yii\console\controllers\MigrateController('migrate', \Yii::$app);
                $migrationController->interactive = true;
                $migrationController->runAction('up', ['interactive' => true]);

                $this->stdout("Migratsiyalar muvaffaqiyatli yakunlandi!\n", Console::FG_GREEN);
            } else {
                $this->stdout("Migratsiya o'tkazib yuborildi. Siz ularni keginroq './yii migrate' buyrug'i yordamida ishga tushirishingiz mumkin.\n", Console::FG_YELLOW);
            }

            if ($this->confirm("Adminkaga kirish uchun admin user yaralsinmi ?")) {
                $username = $this->prompt('admin username kiriting');
                $password = $this->prompt('admin parol kiriting', [
                    'required' => true,
                    'noEcho' => true,
                ]);
                $passwordHash = \Yii::$app->getSecurity()->generatePasswordHash($password);

                $adminUser = new User();
                $adminUser->username = $username;
                $adminUser->password_hash = $passwordHash;
                $adminUser->auth_key = \Yii::$app->security->generateRandomString();
                $adminUser->access_token = \Yii::$app->security->generateRandomString();

                if ($adminUser->save()) {
                    $this->stdout("Admin user '$username' muvaffaqiyatli yaratildi.\n", Console::FG_GREEN);
                } else {
                    $this->stderr("Admin user yaratishda muommo bor: " . implode(", ", $adminUser->errors) . "\n", Console::FG_RED);
                }
            }

        } catch (\PDOException $e) {
            $this->stderr("Databazaga ulanishda hatolik bor: " . $e->getMessage() . "\n", Console::FG_RED);
        }

        return ExitCode::OK;
    }

}
