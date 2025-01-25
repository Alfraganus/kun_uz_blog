<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class InitController extends Controller
{

    public function actionStart()
    {
        $envFilePath = \Yii::getAlias('@app') . '/.env';

        if (!file_exists($envFilePath)) {
            $this->stderr("Welcome to Kun.uz blog system. To continue installation, please create a .env file!\n");
            return ExitCode::OK;
        }

        $this->stdout(".env file exists.\n");

        $envData = parse_ini_file($envFilePath);

        $dbHost = $envData['DB_HOST'] ?? null;
        $dbName = $envData['DB_NAME'] ?? null;
        $dbUsername = $envData['DB_USERNAME'] ?? null;
        $dbPassword = $envData['DB_PASSWORD'] ?? null;

        if (!$dbHost || !$dbName || !$dbUsername) {
            $this->stderr("Database credentials are incomplete in the .env file. Please check and try again.\n");
            return ExitCode::OK;
        }

        $this->stdout("Checking database connection...\n");

        try {
            $dsn = "mysql:host=$dbHost";
            $pdo = new \PDO($dsn, $dbUsername, $dbPassword);

            $stmt = $pdo->query("SHOW DATABASES LIKE '$dbName'");
            if ($stmt->rowCount() > 0) {
                $this->stdout("Database '$dbName' already exists.\n", Console::FG_GREEN);
            } else {
                $this->stdout("Database '$dbName' does not exist.\n", Console::FG_YELLOW);

                if ($this->confirm("Do you want to create the database '$dbName' now?")) {
                    $pdo->exec("CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                    $this->stdout("Database '$dbName' has been created successfully.\n", Console::FG_GREEN);
                } else {
                    $this->stderr("Database '$dbName' was not created. Exiting setup.\n", Console::FG_RED);
                }
            }

            if ($this->confirm("Do you want to run migrations now?")) {
                $this->stdout("Running migrations...\n", Console::FG_GREEN);

                $migrationController = new \yii\console\controllers\MigrateController('migrate', \Yii::$app);
                $migrationController->interactive = true;
                $migrationController->runAction('up', ['interactive' => true]);

                $this->stdout("Migrations completed successfully.\n", Console::FG_GREEN);
            } else {
                $this->stdout("Migrations skipped. You can run them later using the `./yii migrate` command.\n", Console::FG_YELLOW);
            }

            if ($this->confirm("Do you want to create an admin user now?")) {
                $username = $this->prompt('Enter admin username');
                $password = $this->prompt('Enter admin password', [
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
                    $this->stdout("Admin user '$username' has been created successfully.\n", Console::FG_GREEN);
                } else {
                    $this->stderr("Error creating admin user: " . implode(", ", $adminUser->errors) . "\n", Console::FG_RED);
                }
            }

        } catch (\PDOException $e) {
            $this->stderr("Error connecting to the database: " . $e->getMessage() . "\n", Console::FG_RED);
        }

        return ExitCode::OK;
    }

}
