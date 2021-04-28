CREATE DATABASE QLNV
CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';

use QLNV;

/* Danh mục chức vụ */
CREATE TABLE t_Position(
	Position_id VARCHAR(10) NOT NULL PRIMARY KEY,
    Position_name NVARCHAR(60) NOT NULL,
    Basic_salary INT not null,
    check (Basic_salary > 0)
);

/* phòng ban */
create table t_Department(
	Department_id varchar(10) not null primary key,
    Department_name nvarchar(60) not null,
    Coefficients_salary float(3,1),
    check (Coefficients_salary > 0)
);

/*Bảng trình độ*/
create table t_Level(
	Level_id varchar(10) not null PRIMARY KEY,
    `Level` nvarchar(50) not null,
    Coefficients_salary  FLOAT(3,1),
    check (Coefficients_salary > 0)
);

/*Bảng năm tính lương*/
create table t_Salary_year(
	Salary_year int(5) not null primary key,
    check (Salary_year > 0)
);

/*Bảng chi tiết thưởng*/
create table t_Bonus_detail(
	Bonus_id int(4) not null primary key AUTO_INCREMENT,
    Bonus_reason nvarchar(100),
    Bonus int not null,
    check (Bonus > 0)
);
/*Bảng chi tiết phạt*/
create table t_Fine_detail(
	Fine_id int(4) not null primary key AUTO_INCREMENT,
    Fine_reason nvarchar(100),
    Fine int not null,
    check (Fine > 0)
);

/*Bảng tháng tính lương*/
create table t_Salary_month(
	Salary_id int not null primary key AUTO_INCREMENT,
	Salary_month int(3) not null,
    Salary_year int(5),
    FOREIGN KEY (Salary_year) REFERENCES t_Salary_year(Salary_year),
    check (Salary_month > 0)
);

/* Thông tin nhân viên */
create table t_Information_of_employee(
	Employee_id varchar(10) not null primary key,
    Fullname nvarchar(50) not null,
    Gender nvarchar(10) not null,
    Position_id varchar(10) NOT NULL,
    Department_id varchar(10) NOT NULL,
    Level_id varchar(10) NOT NULL,
    FOREIGN KEY (Position_id) REFERENCES t_Position(Position_id),
    FOREIGN KEY (Department_id) REFERENCES t_Department(Department_id),
    FOREIGN KEY (Level_id) REFERENCES t_Level(Level_id)
);

/* Hợp đồng */
CREATE TABLE t_Contract(
	Contract_id VARCHAR(10) NOT NULL PRIMARY KEY,
	Employee_id varchar(10) not null,
    Type_of_contract NVARCHAR(60) NOT NULL,
    Sign_day DATE not null,
    Expiration_date DATE not null,
    `Status` int(1) not null,
    FOREIGN KEY (Employee_id) REFERENCES t_Information_of_employee(Employee_id)
);

/* Số công của nhân viên */
create table t_Workday(
	Ordinal int not null primary key auto_increment,
    Employee_id varchar(10) not null,
    Salary_id int not null,
    Day_worked int(2) not null,
    Overtime int(3) not null,
    FOREIGN KEY (Employee_id) REFERENCES t_Information_of_employee(Employee_id),
    FOREIGN KEY (Salary_id) REFERENCES t_Salary_month(Salary_id),
    check (Day_worked > 0 and Overtime > 0)
);

/*Bảng thông tin thưởng*/
create table t_Bonus_info(
	Ordinal int not null primary key AUTO_INCREMENT,
    Employee_id varchar(10) not null,
    Bonus_id int(4) not null,
    Salary_id int not null,
    FOREIGN KEY (Employee_id) REFERENCES t_Information_of_employee(Employee_id),
    FOREIGN KEY (Salary_id) REFERENCES t_Salary_month(Salary_id),
    FOREIGN KEY (Bonus_id) REFERENCES t_Bonus_detail(Bonus_id)
);

/*Bảng thông tin phạt*/
create table t_Fine_info(
	Ordinal int not null primary key AUTO_INCREMENT,
    Employee_id varchar(10) not null,
    Fine_id int(4) not null,
    Salary_id int not null,
    FOREIGN KEY (Employee_id) REFERENCES t_Information_of_employee(Employee_id),
    FOREIGN KEY (Salary_id) REFERENCES t_Salary_month(Salary_id),
    FOREIGN KEY (Fine_id) REFERENCES t_Fine_detail(Fine_id)
);

/* Bảng login */
create table t_Login(
	userId varchar(50) not null primary key,
    `password` varchar(50) not null,
    userName varchar(50) not null
);

