CREATE DATABASE dbtest1;

CREATE TABLE dbtest1.tbl_user (
    id BIGINT UNSIGNED AUTO_INCREMENT,
    name varchar(80) NOT NULL,
    email varchar(300) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) DEFAULT CHARSET=utf8_general_ci AUTO_INCREMENT=1;
INSERT INTO dbtest1.tbl_user (id, name, email)
VALUES
    (1, 'Василий', 'vasiliy@test.ru'),
    (2, 'Марина', 'marina@test.ru'),
    (4, 'Петр', 'petr@test.ru');

CREATE DATABASE dbtest2;

CREATE TABLE dbtest2.tbl_account (
    id BIGINT UNSIGNED AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    sum float DEFAULT 0.0,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    user_id int NOT NULL,
    PRIMARY KEY (id)
) DEFAULT CHARSET=utf8_general_ci AUTO_INCREMENT=1;
INSERT INTO dbtest2.tbl_account (name, user_id, sum)
VALUES
('acc_1', 1, 123.23),
('acc_3', 3, 321.32),
('acc_4', 4, 0.0);

SELECT tu.*, ta.*
    FROM dbtest1.tbl_user as tu
    LEFT JOIN dbtest2.tbl_account as ta ON ta.user_id = tu.id;

SELECT tu.*, ta.*
FROM dbtest1.tbl_user as tu
         right JOIN dbtest2.tbl_account as ta ON ta.user_id = tu.id;

SELECT tu.*, ta.*
FROM dbtest1.tbl_user as tu
         inner JOIN dbtest2.tbl_account as ta ON ta.user_id = tu.id;