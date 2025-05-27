<?php

/**
 * PHPMaker 2024 configuration file (Development)
 */

return [
    "Databases" => [
        "DB" => ["id" => "DB", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "193.203.175.60", "port" => "3306", "user" => "u741348489_wanderne_con", "password" => "DIpIYIp25O", "dbname" => "u741348489_preco_contrato"]
    ],
    "SMTP" => [
        "PHPMAILER_MAILER" => "smtp", // PHPMailer mailer
        "SERVER" => "email-ssl.com.br", // SMTP server
        "SERVER_PORT" => 465, // SMTP server port
        "SECURE_OPTION" => "ssl",
        "SERVER_USERNAME" => "comercial@amixxam.com.br", // SMTP server user name
        "SERVER_PASSWORD" => "Amixx@2023", // SMTP server password
    ],
    "JWT" => [
        "SECRET_KEY" => "+XlQLvEz//u0TGCexSPRqe/bJdjkdJFj9M5MtptZFLQ=", // JWT secret key
        "ALGORITHM" => "HS512", // JWT algorithm
        "AUTH_HEADER" => "X-Authorization", // API authentication header (Note: The "Authorization" header is removed by IIS, use "X-Authorization" instead.)
        "NOT_BEFORE_TIME" => 0, // API access time before login
        "EXPIRE_TIME" => 600 // API expire time
    ]
];
