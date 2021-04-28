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



/* Procedure */

use qlnv;
DROP FUNCTION IF EXISTS `Payroll`;
DROP PROCEDURE IF EXISTS `Filter_employee_bonus`;
DROP PROCEDURE IF EXISTS `Filter_employee`;
DROP PROCEDURE IF EXISTS `Filter_employee_fine`;
DROP PROCEDURE IF EXISTS `Filter_employee_bonus_limit`;
DROP PROCEDURE IF EXISTS `Filter_employee_limit`;
DROP PROCEDURE IF EXISTS `Filter_employee_fine_limit`;
DROP PROCEDURE IF EXISTS `Filter_employee_workday`;
DROP PROCEDURE IF EXISTS `Filter_employee_workday_limit`;
DROP PROCEDURE IF EXISTS `Salary_in_month`;
DROP PROCEDURE IF EXISTS `Salary_in_month_limit`;
DROP PROCEDURE IF EXISTS `Total_salary`;

/*Tính lương nhân viên*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `Payroll`(basic_salary int,
        day_worked int(3),
        overtime int(5),
        bonus int,
        fine int,
        coefficient1 float,
        coefficient2 float
	) RETURNS int(11)
begin
		return ceiling(((basic_salary*(day_worked+overtime/24)+bonus-fine)*coefficient1*coefficient2)/1000)*1000;
	end$$
DELIMITER ;

/*Lọc nhân viên theo Thưởng*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Filter_employee_bonus`(
		employee nvarchar(50),
		department varchar(30),
        bonus varchar(30),
        salarymonth varchar(30),
        salaryyear varchar(30)
    )
begin
		select Ordinal, t_Bonus_info.Salary_id, t_Bonus_info.Employee_id, Fullname, Gender,
			Department_name, Position_name, t_Bonus_info.Bonus_id, Bonus_reason, t_Bonus_detail.Bonus
        from t_Information_of_employee, t_Department, t_Position, t_Contract, t_Bonus_info,
			t_Bonus_detail, t_Salary_year, t_Salary_month
		where t_Department.Department_id = t_Information_of_employee.Department_id
        and t_Position.Position_id =  t_Information_of_employee.Position_id
        and t_Contract.Employee_id = t_Information_of_employee.Employee_id
        and t_Bonus_info.Employee_id = t_Information_of_employee.Employee_id
        and t_Bonus_detail.Bonus_id = t_Bonus_info.Bonus_id
		and t_Salary_month.Salary_id = t_Bonus_info.Salary_id
		and t_Salary_year.Salary_year = t_Salary_month.Salary_year
        and Fullname like concat('%',employee,'%')
        and t_Department.Department_id like concat('',department,'')
        and t_Bonus_info.Bonus_id like concat('',bonus,'')
		and t_Salary_month.Salary_month like concat('',salarymonth,'')
		and t_Salary_year.Salary_year like concat('',salaryyear,'')
        and `Status` like '1'
        group by Ordinal, t_Bonus_info.Salary_id, t_Bonus_info.Employee_id, Fullname, Gender,
			Department_name, Position_name, t_Bonus_info.Bonus_id, Bonus_reason, t_Bonus_detail.Bonus;
    end$$
DELIMITER ;

/*Lọc nhân viên*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Filter_employee`(
		id varchar(20),
		employee nvarchar(50),
        employee_gender nvarchar(30),
		department varchar(30),
		position varchar(30),
		levelId varchar(30),
		contractId varchar(30),
		contract nvarchar(30),
        expiration varchar(20),
		status_contract varchar(30)
    )
begin
		select t_Information_of_employee.Employee_id, Fullname, Gender,
			Department_name, Position_name, `Level`, Type_of_contract, Contract_id, Expiration_date, Sign_day, t_Contract.Status
		from t_Information_of_employee, t_Department, t_Position, t_Level, t_Contract
		where t_Department.Department_id = t_Information_of_employee.Department_id
        and t_Position.Position_id =  t_Information_of_employee.Position_id
        and t_Level.Level_id =  t_Information_of_employee.Level_id
        and t_Contract.Employee_id = t_Information_of_employee.Employee_id
		and t_Information_of_employee.Employee_id like concat('',id,'')
        and Fullname like concat('%',employee,'%')
        and Gender like concat('',employee_gender,'')
        and t_Department.Department_id like concat('',department,'')
        and t_Position.Position_id like concat('',position,'')
        and t_Level.Level_id like concat('',levelId,'')
		and Contract_id like concat('',contractId,'')
        and Type_of_contract like concat('',contract,'')
		and Expiration_date <= expiration
        and `Status` like concat('',status_contract,'')
        group by t_Information_of_employee.Employee_id, Fullname,
			Department_name, Position_name, `Level`, Type_of_contract, Contract_id, Expiration_date, Sign_day, t_Contract.Status;
    end$$
DELIMITER ;

/*Lọc nhân viên theo phạt*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Filter_employee_fine`(
		employee nvarchar(50),
		department varchar(30),
        fine varchar(30),
        salarymonth varchar(30),
        salaryyear varchar(30)
    )
begin
		select Ordinal, t_Fine_info.Salary_id, t_Fine_info.Employee_id, Fullname, Gender,
			Department_name, Position_name, t_Fine_info.Fine_id, Fine_reason, t_Fine_detail.Fine
        from t_Information_of_employee, t_Department, t_Position, t_Contract, t_Fine_info,
			t_Fine_detail, t_Salary_year, t_Salary_month
		where t_Department.Department_id = t_Information_of_employee.Department_id
        and t_Position.Position_id =  t_Information_of_employee.Position_id
        and t_Contract.Employee_id = t_Information_of_employee.Employee_id
        and t_Fine_info.Employee_id = t_Information_of_employee.Employee_id
		and t_Salary_month.Salary_id = t_Fine_info.Salary_id
		and t_Salary_year.Salary_year = t_Salary_month.Salary_year
        and t_Fine_detail.Fine_id = t_Fine_info.Fine_id
        and Fullname like concat('%',employee,'%')
		and Gender like concat('',gender,'')
        and t_Department.Department_id like concat('',department,'')
        and t_Fine_info.Fine_id like concat('',fine,'')
		and t_Salary_month.Salary_month like concat('',salarymonth,'')
		and t_Salary_year.Salary_year like concat('',salaryyear,'')
        and `Status` like '1'
        group by Ordinal, t_Fine_info.Salary_id, t_Fine_info.Employee_id, Fullname, Gender,
			Department_name, Position_name, t_Fine_info.Fine_id, Fine_reason, t_Fine_detail.Fine;
    end$$
DELIMITER ;

/*Lọc nhân viên theo thưởng, limit để giới hạn số lượng tìm kiếm (cho việc phân trang)*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Filter_employee_bonus_limit`(
		employee nvarchar(50),
		department varchar(30),
        bonus varchar(30),
        salarymonth varchar(30),
        salaryyear varchar(30),
        page_start int(2),
        page_end int(2)
    )
begin
		select Ordinal, t_Bonus_info.Salary_id, t_Bonus_info.Employee_id, Fullname, Gender,
			Department_name, Position_name, t_Bonus_info.Bonus_id, Bonus_reason, t_Bonus_detail.Bonus
        from t_Information_of_employee, t_Department, t_Position, t_Contract, t_Bonus_info,
			t_Bonus_detail, t_Salary_year, t_Salary_month
		where t_Department.Department_id = t_Information_of_employee.Department_id
        and t_Position.Position_id =  t_Information_of_employee.Position_id
        and t_Contract.Employee_id = t_Information_of_employee.Employee_id
        and t_Bonus_info.Employee_id = t_Information_of_employee.Employee_id
        and t_Bonus_detail.Bonus_id = t_Bonus_info.Bonus_id
		and t_Salary_month.Salary_id = t_Bonus_info.Salary_id
		and t_Salary_year.Salary_year = t_Salary_month.Salary_year
        and Fullname like concat('%',employee,'%')
        and t_Department.Department_id like concat('',department,'')
        and t_Bonus_info.Bonus_id like concat('',bonus,'')
		and t_Salary_month.Salary_month like concat('',salarymonth,'')
		and t_Salary_year.Salary_year like concat('',salaryyear,'')
        and `Status` like '1'
        group by Ordinal, t_Bonus_info.Salary_id, t_Bonus_info.Employee_id, Fullname, Gender,
			Department_name, Position_name, t_Bonus_info.Bonus_id, Bonus_reason, t_Bonus_detail.Bonus
		LIMIT page_start,page_end;
    end$$
DELIMITER ;

/*Lọc nhân viên, limit để giới hạn số lượng tìm kiếm (cho việc phân trang)*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Filter_employee_limit`(
	id varchar(20),
	employee nvarchar(50),
    employee_gender nvarchar(30),
	department varchar(30),
	position varchar(30),
	levelId varchar(30),
	contractId varchar(30),
	contract nvarchar(30),
	expiration varchar(20),
	status_contract varchar(30),
    page_start int(3),
    page_end int(3)
)
begin
	select t_Information_of_employee.Employee_id, Fullname, Gender,
		Department_name, Position_name, `Level`, Type_of_contract, Contract_id, Expiration_date, Sign_day, t_Contract.Status
	from t_Information_of_employee, t_Department, t_Position, t_Level, t_Contract
	where t_Department.Department_id = t_Information_of_employee.Department_id
	and t_Position.Position_id =  t_Information_of_employee.Position_id
	and t_Level.Level_id =  t_Information_of_employee.Level_id
	and t_Contract.Employee_id = t_Information_of_employee.Employee_id
	and t_Information_of_employee.Employee_id like concat('',id,'')
	and Fullname like concat('%',employee,'%')
    and Gender like concat('',employee_gender,'')
	and t_Department.Department_id like concat('',department,'')
	and t_Position.Position_id like concat('',position,'')
	and t_Level.Level_id like concat('',levelId,'')
	and Contract_id like concat('',contractId,'')
	and Type_of_contract like concat('',contract,'')
    and Expiration_date <= expiration
	and `Status` like concat('',status_contract,'')
	group by t_Information_of_employee.Employee_id, Fullname,
		Department_name, Position_name, `Level`, Type_of_contract, Contract_id, Expiration_date, Sign_day, t_Contract.Status
	LIMIT page_start,page_end;
end$$
DELIMITER ;

/*Lọc nhân viên theo phạt, limit để giới hạn số lượng tìm kiếm (cho việc phân trang)*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Filter_employee_fine_limit`(
		employee nvarchar(50),
		department varchar(30),
        fine varchar(30),
        salarymonth varchar(30),
        salaryyear varchar(30),
        page_start int(2),
        page_end int(2)
    )
begin
		select Ordinal, t_Fine_info.Salary_id, t_Fine_info.Employee_id, Fullname, Gender,
			Department_name, Position_name, t_Fine_info.Fine_id, Fine_reason, t_Fine_detail.Fine
        from t_Information_of_employee, t_Department, t_Position, t_Contract, t_Fine_info,
			t_Fine_detail, t_Salary_year, t_Salary_month
		where t_Department.Department_id = t_Information_of_employee.Department_id
        and t_Position.Position_id =  t_Information_of_employee.Position_id
        and t_Contract.Employee_id = t_Information_of_employee.Employee_id
        and t_Fine_info.Employee_id = t_Information_of_employee.Employee_id
		and t_Salary_month.Salary_id = t_Fine_info.Salary_id
		and t_Salary_year.Salary_year = t_Salary_month.Salary_year
        and t_Fine_detail.Fine_id = t_Fine_info.Fine_id
        and Fullname like concat('%',employee,'%')
        and t_Department.Department_id like concat('',department,'')
        and t_Fine_info.Fine_id like concat('',fine,'')
		and t_Salary_month.Salary_month like concat('%',salarymonth,'')
		and t_Salary_year.Salary_year like concat('',salaryyear,'')
        and `Status` like '1'
        group by Ordinal, t_Fine_info.Salary_id, t_Fine_info.Employee_id, Fullname, Gender,
			Department_name, Position_name, t_Fine_info.Fine_id, Fine_reason, t_Fine_detail.Fine
		LIMIT page_start,page_end;
    end$$
DELIMITER ;

/*Lọc nhân viên theo ngày công*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Filter_employee_workday`(
		employee nvarchar(50),
        department varchar(30),
        position varchar(30),
        salarymonth varchar(10),
        salaryyear varchar(10)
    )
begin
		select Ordinal, t_Workday.Salary_id, t_Workday.Employee_id, Fullname, Department_name,
			t_Position.Position_id, Position_name, Salary_month, t_Salary_year.Salary_year, Day_worked, Overtime
		from t_Information_of_employee, t_Department, t_Contract, t_Salary_year,
			t_Salary_month, t_Workday, t_Position
		where t_Department.Department_id = t_Information_of_employee.Department_id
			and t_Contract.Employee_id = t_Information_of_employee.Employee_id
			and t_Position.Position_id = t_Information_of_employee.Position_id
			and t_Workday.Employee_id = t_Information_of_employee.Employee_id
			and t_Salary_year.Salary_year = t_Salary_month.Salary_year
			and t_Salary_month.Salary_id = t_Workday.Salary_id
			and Fullname like concat('%',employee,'%')
            and t_Position.Position_id like concat('',position,'')
            and t_Department.Department_id like concat('',department,'')
            and t_Salary_month.Salary_month like concat('',salarymonth,'')
            and t_Salary_year.Salary_year like concat('',salaryyear,'')
			and `Status` like '1'
		group by Ordinal, t_Workday.Salary_id, t_Workday.Employee_id, Fullname, Department_name,
			t_Position.Position_id, Position_name, Salary_month, t_Salary_year.Salary_year, Day_worked, Overtime;
    end$$
DELIMITER ;

/*Lọc nhân viên theo ngày công, limit để giới hạn số lượng tìm kiếm (cho việc phân trang)*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Filter_employee_workday_limit`(
		employee nvarchar(50),
        department varchar(30),
        position varchar(30),
        salarymonth varchar(10),
        salaryyear varchar(10),
        page_start int(3),
        page_end int(3)
    )
begin
		select Ordinal, t_Workday.Salary_id, t_Workday.Employee_id, Fullname, Department_name, 
			t_Position.Position_id, Position_name, Salary_month, t_Salary_year.Salary_year, Day_worked, Overtime
		from t_Information_of_employee, t_Department, t_Contract, t_Salary_year,
			t_Salary_month, t_Workday, t_Position
		where t_Department.Department_id = t_Information_of_employee.Department_id
			and t_Contract.Employee_id = t_Information_of_employee.Employee_id
			and t_Position.Position_id = t_Information_of_employee.Position_id
			and t_Workday.Employee_id = t_Information_of_employee.Employee_id
			and t_Salary_year.Salary_year = t_Salary_month.Salary_year
			and t_Salary_month.Salary_id = t_Workday.Salary_id
			and Fullname like concat('%',employee,'%')
            and t_Position.Position_id like concat('',position,'')
            and t_Department.Department_id like concat('',department,'')
            and t_Salary_month.Salary_month like concat('',salarymonth,'')
            and t_Salary_year.Salary_year like concat('',salaryyear,'')
			and `Status` like '1'
		group by Ordinal, t_Workday.Salary_id, t_Workday.Employee_id, Fullname, Department_name, 
			t_Position.Position_id, Position_name, Salary_month, t_Salary_year.Salary_year, Day_worked, Overtime
		LIMIT page_start,page_end;
    end$$
DELIMITER ;

/*Lọc + tính lương nhân viên*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Salary_in_month`(
		employee nvarchar(50),
        department varchar(30),
        position varchar(30),
        salarymonth varchar(30),
        salaryyear varchar(30)
    )
begin
		select t_Workday.Salary_id, t_Workday.Employee_id, Fullname, Department_name,
			Salary_month, t_Salary_year.Salary_year, Day_worked, Overtime, t_Position.Position_id, Position_name,
            Payroll(Basic_salary,Day_worked,Overtime,sum(Bonus),sum(Fine),t_Department.Coefficients_salary,t_Level.Coefficients_salary) as Salary
		from t_Information_of_employee, t_Department, t_Contract, t_Salary_year, t_Level,
			t_Salary_month, t_Workday, t_Bonus_info, t_Bonus_detail, t_Fine_info, t_Fine_detail, t_Position
		where t_Department.Department_id = t_Information_of_employee.Department_id
			and t_Contract.Employee_id = t_Information_of_employee.Employee_id
			and t_Bonus_info.Employee_id = t_Information_of_employee.Employee_id
			and t_Level.Level_id =  t_Information_of_employee.Level_id
			and t_Fine_info.Employee_id = t_Information_of_employee.Employee_id
			and t_Position.Position_id = t_Information_of_employee.Position_id
			and t_Workday.Employee_id = t_Information_of_employee.Employee_id
			and t_Salary_year.Salary_year = t_Salary_month.Salary_year
			and t_Salary_month.Salary_id = t_Workday.Salary_id
			and t_Salary_month.Salary_id = t_Fine_info.Salary_id
			and t_Salary_month.Salary_id = t_Bonus_info.Salary_id
			and t_Bonus_info.Bonus_id = t_Bonus_detail.Bonus_id
			and t_Fine_info.Fine_id = t_Fine_detail.Fine_id
			and Fullname like concat('%',employee,'%')
            and t_Position.Position_id like concat('',position,'')
            and t_Department.Department_id like concat('',department,'')
            and t_Salary_month.Salary_month like concat('',salarymonth,'')
            and t_Salary_year.Salary_year like concat('',salaryyear,'')
			and `Status` like '1'
		group by t_Workday.Salary_id, t_Position.Position_id, Position_name, t_Workday.Employee_id, Fullname, Department_name, Salary_month, t_Salary_year.Salary_year, Day_worked;
    end$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Salary_in_month_limit`(
		employee nvarchar(50),
        department varchar(30),
        position varchar(30),
        salarymonth varchar(30),
        salaryyear varchar(30),
        page_start int(3),
        page_end int(3)
    )
begin
		select t_Workday.Salary_id, t_Workday.Employee_id, Fullname, Department_name,
			Salary_month, t_Salary_year.Salary_year, Day_worked, Overtime, t_Position.Position_id, Position_name,
            Payroll(Basic_salary,Day_worked,Overtime,sum(Bonus),sum(Fine),t_Department.Coefficients_salary,t_Level.Coefficients_salary) as Salary
		from t_Information_of_employee, t_Department, t_Contract, t_Salary_year, t_Level,
			t_Salary_month, t_Workday, t_Bonus_info, t_Bonus_detail, t_Fine_info, t_Fine_detail, t_Position
		where t_Department.Department_id = t_Information_of_employee.Department_id
			and t_Contract.Employee_id = t_Information_of_employee.Employee_id
			and t_Bonus_info.Employee_id = t_Information_of_employee.Employee_id
			and t_Level.Level_id =  t_Information_of_employee.Level_id
			and t_Fine_info.Employee_id = t_Information_of_employee.Employee_id
			and t_Position.Position_id = t_Information_of_employee.Position_id
			and t_Workday.Employee_id = t_Information_of_employee.Employee_id
			and t_Salary_year.Salary_year = t_Salary_month.Salary_year
			and t_Salary_month.Salary_id = t_Workday.Salary_id
			and t_Salary_month.Salary_id = t_Fine_info.Salary_id
			and t_Salary_month.Salary_id = t_Bonus_info.Salary_id
			and t_Bonus_info.Bonus_id = t_Bonus_detail.Bonus_id
			and t_Fine_info.Fine_id = t_Fine_detail.Fine_id
			and Fullname like concat('%',employee,'%')
            and t_Position.Position_id like concat('',position,'')
            and t_Department.Department_id like concat('',department,'')
            and t_Salary_month.Salary_month like concat('',salarymonth,'')
            and t_Salary_year.Salary_year like concat('',salaryyear,'')
			and `Status` like '1'
		group by t_Workday.Salary_id, t_Position.Position_id, Position_name, t_Workday.Employee_id, Fullname, Department_name, Salary_month, t_Salary_year.Salary_year, Day_worked
        LIMIT page_start, page_end;
    end$$
DELIMITER ;

/*Tính tổng lương nhân viên, limit để giới hạn số lượng tìm kiếm (cho việc phân trang)*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Total_salary`(
        department varchar(30),
        salarymonth varchar(30),
        salaryyear varchar(30)
    )
begin
		select t_Department.Department_name, sum(Payroll(Basic_salary,Day_worked,Overtime,(Bonus),(Fine),t_Department.Coefficients_salary,t_Level.Coefficients_salary)) as Total_salary
		from t_Information_of_employee, t_Department, t_Contract, t_Salary_year, t_Level,
			t_Salary_month, t_Workday, t_Bonus_info, t_Bonus_detail, t_Fine_info, t_Fine_detail, t_Position
		where t_Department.Department_id = t_Information_of_employee.Department_id
			and t_Contract.Employee_id = t_Information_of_employee.Employee_id
			and t_Bonus_info.Employee_id = t_Information_of_employee.Employee_id
			and t_Level.Level_id =  t_Information_of_employee.Level_id
			and t_Fine_info.Employee_id = t_Information_of_employee.Employee_id
			and t_Position.Position_id = t_Information_of_employee.Position_id
			and t_Workday.Employee_id = t_Information_of_employee.Employee_id
			and t_Salary_year.Salary_year = t_Salary_month.Salary_year
			and t_Salary_month.Salary_id = t_Workday.Salary_id
			and t_Salary_month.Salary_id = t_Fine_info.Salary_id
			and t_Salary_month.Salary_id = t_Bonus_info.Salary_id
			and t_Bonus_info.Bonus_id = t_Bonus_detail.Bonus_id
			and t_Fine_info.Fine_id = t_Fine_detail.Fine_id
            and t_Department.Department_id like concat('',department,'')
            and t_Salary_month.Salary_month like concat('',salarymonth,'')
            and t_Salary_year.Salary_year like concat('',salaryyear,'')
			and `Status` like '1'
		group by t_Department.Department_name;
    end$$
DELIMITER ;

/* Trigger */
use QLNV;
/*Khi xóa 1 nhân viên thì thông tin liên quan trong các bảng liên quan cũng bị xóa theo*/
DROP TRIGGER IF EXISTS tg_del_employed;
	DELIMITER $$
    CREATE trigger tg_del_employed
    before DELETE ON t_Information_of_employee
    for each row
    begin
		delete from t_Contract where Employee_id=old.Employee_id;
		delete from t_Bonus_info where Employee_id=old.Employee_id;
		delete from t_Fine_info where Employee_id=old.Employee_id;
		delete from t_Workday where Employee_id=old.Employee_id;
    end$$
DELIMITER ;
/*END*/
/*Khi xóa 1 thông tin trong bảng t_bonus_detail thì thông tin liên quan trong bảng t_bonus_info sẽ bị xóa*/
DROP TRIGGER IF EXISTS tg_del_bonus;
	DELIMITER $$
    CREATE trigger tg_del_bonus
    before DELETE ON t_bonus_detail
    for each row
    begin
		delete from t_bonus_info where Bonus_id=old.Bonus_id;
    end$$
DELIMITER ;
/*END*/
/*Khi xóa 1 thông tin trong bảng t_fine_detail thì thông tin liên quan trong bảng t_fine_info sẽ bị xóa*/
DROP TRIGGER IF EXISTS tg_del_fine;
	DELIMITER $$
    CREATE trigger tg_del_fine
    before DELETE ON t_fine_detail
    for each row
    begin
		delete from t_fine_info where Fine_id=old.Fine_id;
    end$$
DELIMITER ;
/*END*/


/*Nếu số ngày đi làm lớn hơn hoặc bằng 26 ngày thì tự động thêm vào bảng thông 
tin thưởng với id thưởng tương ứng với lý do đi làm đầy đủ. Ngược lại nếu <=17 ngày
thì thêm vào thông tin phạt với lý do tương ứng */
DROP TRIGGER IF EXISTS tg_add_workday;
	DELIMITER $$
    CREATE trigger tg_add_workday
    after insert on t_Workday
    for each row
    begin
		if (NEW.Day_worked >=26) then
			INSERT INTO t_bonus_info
            set
				Employee_id=NEW.Employee_id,
                Bonus_id=5,
                Salary_id=NEW.Salary_id;
			
				elseif (NEW.Day_worked <=17) then
			INSERT INTO t_fine_info
            set
				Employee_id=NEW.Employee_id,
                Fine_id=5,
                Salary_id=NEW.Salary_id;
		end if;
    end$$
DELIMITER ;

/*END*/


/*Nếu thêm năm mới thì tự động thêm vào 12 tháng trong bảng tháng*/
DROP TRIGGER IF EXISTS tg_add_month;
	DELIMITER $$
    CREATE trigger tg_add_month
    after insert on t_salary_year
    for each row
    begin
    
		insert into t_salary_month
        set
        Salary_month=1,
        Salary_year=new.Salary_year;
        insert into t_salary_month
        set
        Salary_month=2,
        Salary_year=new.Salary_year;
        insert into t_salary_month
        set
        Salary_month=3,
        Salary_year=new.Salary_year;
        insert into t_salary_month
        set
        Salary_month=4,
        Salary_year=new.Salary_year;
        insert into t_salary_month
        set
        Salary_month=5,
        Salary_year=new.Salary_year;
        insert into t_salary_month
        set
        Salary_month=6,
        Salary_year=new.Salary_year;
        insert into t_salary_month
        set
        Salary_month=7,
        Salary_year=new.Salary_year;
        insert into t_salary_month
        set
        Salary_month=8,
        Salary_year=new.Salary_year;
        insert into t_salary_month
        set
        Salary_month=9,
        Salary_year=new.Salary_year;
        insert into t_salary_month
        set
        Salary_month=10,
        Salary_year=new.Salary_year;
        insert into t_salary_month
        set
        Salary_month=11,
        Salary_year=new.Salary_year;
        insert into t_salary_month
        set
        Salary_month=12,
        Salary_year=new.Salary_year;
        
        
    end$$;
   
   DELIMITER $$
   
   
   
/* Insert */

/* Thêm dữ liệu vào bảng thông tin đăng nhập t_login */
INSERT INTO `qlnv`.`t_login` (`userId`, `password`, `userName`) VALUES ('admin1', '111', 'Kiều Đăng Thành');
INSERT INTO `qlnv`.`t_login` (`userId`, `password`, `userName`) VALUES ('admin2', '222', 'Trần Thanh Duy');
INSERT INTO `qlnv`.`t_login` (`userId`, `password`, `userName`) VALUES ('admin3', '333', 'Tô Thị Thu');
 
/* Thêm dữ liệu vào bảng chức vụ t_Position */
INSERT INTO `qlnv`.`t_position` (`Position_id`, `Position_name`, `Basic_salary`) VALUES ('CVGD', 'Giám đốc', '1000000');
INSERT INTO `qlnv`.`t_position` (`Position_id`, `Position_name`, `Basic_salary`) VALUES ('CVTP', 'Trưởng phòng', '800000');
INSERT INTO `qlnv`.`t_position` (`Position_id`, `Position_name`, `Basic_salary`) VALUES ('CVPP', 'Phó phòng', '750000');
INSERT INTO `qlnv`.`t_position` (`Position_id`, `Position_name`, `Basic_salary`) VALUES ('CVNVKYT', 'Nhân viên kỹ thuật', '630000');
INSERT INTO `qlnv`.`t_position` (`Position_id`, `Position_name`, `Basic_salary`) VALUES ('CVNVKD', 'Nhân viên kinh doanh', '620000');
INSERT INTO `qlnv`.`t_position` (`Position_id`, `Position_name`, `Basic_salary`) VALUES ('CVNVKET', 'Nhân viên kế toán', '650000');
INSERT INTO `qlnv`.`t_position` (`Position_id`, `Position_name`, `Basic_salary`) VALUES ('CVNVHC', 'Nhân viên hành chính', '550000');
INSERT INTO `qlnv`.`t_position` (`Position_id`, `Position_name`, `Basic_salary`) VALUES ('CVNVNS', 'Nhân viên nhân sự', '580000');

/* Thêm dữ liệu vào bảng phòng ban t_Department */
INSERT INTO `qlnv`.`t_department` (`Department_id`, `Department_name`, `Coefficients_salary`) VALUES ('PKD', 'Phòng kinh doanh', '1.2');
INSERT INTO `qlnv`.`t_department` (`Department_id`, `Department_name`, `Coefficients_salary`) VALUES ('PKYT', 'Phòng kỹ thuật', '2.1');
INSERT INTO `qlnv`.`t_department` (`Department_id`, `Department_name`, `Coefficients_salary`) VALUES ('PNS', 'Phòng nhân sự', '1.3');
INSERT INTO `qlnv`.`t_department` (`Department_id`, `Department_name`, `Coefficients_salary`) VALUES ('PKET', 'Phòng kế toán', '1.5');
INSERT INTO `qlnv`.`t_department` (`Department_id`, `Department_name`, `Coefficients_salary`) VALUES ('PLD', 'Phòng lãnh đạo', '3.0');
INSERT INTO `qlnv`.`t_department` (`Department_id`, `Department_name`, `Coefficients_salary`) VALUES ('PHC', 'Phòng hành chính', '1.0');

/* Thêm dữ liệu vào bảng trình độ t_Level */
INSERT INTO `qlnv`.`t_level` (`Level_id`, `Level`, `Coefficients_salary`) VALUES ('THS', 'Thạc sỹ', '2.41');
INSERT INTO `qlnv`.`t_level` (`Level_id`, `Level`, `Coefficients_salary`) VALUES ('TS', 'Tiến sỹ', '2.65');
INSERT INTO `qlnv`.`t_level` (`Level_id`, `Level`, `Coefficients_salary`) VALUES ('DH', 'Đại học', '2.34');
INSERT INTO `qlnv`.`t_level` (`Level_id`, `Level`, `Coefficients_salary`) VALUES ('CD', 'Cao đẳng', '2.1');
INSERT INTO `qlnv`.`t_level` (`Level_id`, `Level`, `Coefficients_salary`) VALUES ('TC', 'Trung cấp', '1.86');
INSERT INTO `qlnv`.`t_level` (`Level_id`, `Level`, `Coefficients_salary`) VALUES ('PT', 'Phổ thông', '1.63');

/* Thêm dữ liệu vào bảng thông tin nhân viên t_Information_of_employee */
INSERT INTO `qlnv`.`t_information_of_employee` (`Employee_id`, `Fullname`, `Gender`, `Position_id`, `Department_id`, `Level_id`) VALUES ('NV001', 'Hoàng Lan Anh', 'Nữ', 'CVGD', 'PLD', 'TS');
INSERT INTO `qlnv`.`t_information_of_employee` (`Employee_id`, `Fullname`, `Gender`, `Position_id`, `Department_id`, `Level_id`) VALUES ('NV002', 'Bùi Nhật Minh', 'Nam', 'CVGD', 'PLD', 'THS');
INSERT INTO `qlnv`.`t_information_of_employee` (`Employee_id`, `Fullname`, `Gender`, `Position_id`, `Department_id`, `Level_id`) VALUES ('NV003', 'Vương Thế Cường', 'Nam', 'CVTP', 'PKD', 'DH');
INSERT INTO `qlnv`.`t_information_of_employee` (`Employee_id`, `Fullname`, `Gender`, `Position_id`, `Department_id`, `Level_id`) VALUES ('NV004', 'Nguyễn Văn Bình', 'Nam', 'CVPP', 'PNS', 'DH');
INSERT INTO `qlnv`.`t_information_of_employee` (`Employee_id`, `Fullname`, `Gender`, `Position_id`, `Department_id`, `Level_id`) VALUES ('NV005', 'Trần Thị Liễu', 'Nữ', 'CVNVHC', 'PHC', 'DH');
INSERT INTO `qlnv`.`t_information_of_employee` (`Employee_id`, `Fullname`, `Gender`, `Position_id`, `Department_id`, `Level_id`) VALUES ('NV006', 'Trần Mạnh Huy', 'Nam', 'CVNVKYT', 'PKYT', 'CD');
INSERT INTO `qlnv`.`t_information_of_employee` (`Employee_id`, `Fullname`, `Gender`, `Position_id`, `Department_id`, `Level_id`) VALUES ('NV007', 'Vũ Thị Cẩm Ly', 'Nữ', 'CVNVKET', 'PKET', 'TC');
INSERT INTO `qlnv`.`t_information_of_employee` (`Employee_id`, `Fullname`, `Gender`, `Position_id`, `Department_id`, `Level_id`) VALUES ('NV008', 'Phạm Thanh Huyền', 'Nữ', 'CVNVNS', 'PNS', 'DH');
INSERT INTO `qlnv`.`t_information_of_employee` (`Employee_id`, `Fullname`, `Gender`, `Position_id`, `Department_id`, `Level_id`) VALUES ('NV009', 'Nguyễn Đình Hùng', 'Nam', 'CVNVKYT', 'PKYT', 'PT');
INSERT INTO `qlnv`.`t_information_of_employee` (`Employee_id`, `Fullname`, `Gender`, `Position_id`, `Department_id`, `Level_id`) VALUES ('NV010', 'Nguyễn Trần Hùng', 'Nam', 'CVNVKYT', 'PKYT', 'CD');

/* Thêm dữ liệu vào bảng hợp đồng t_Contract */
INSERT INTO `qlnv`.`t_contract` (`Contract_id`, `Employee_id`, `Type_of_contract`, `Sign_day`, `Expiration_date`, `Status`) VALUES ('KXD001', 'NV001', 'Không xác định thời hạn', '2019-01-01', '3000-01-01', '1');
INSERT INTO `qlnv`.`t_contract` (`Contract_id`, `Employee_id`, `Type_of_contract`, `Sign_day`, `Expiration_date`, `Status`) VALUES ('KXD002', 'NV002', 'Không xác định thời hạn', '2019-01-01', '3000-01-01', '1');
INSERT INTO `qlnv`.`t_contract` (`Contract_id`, `Employee_id`, `Type_of_contract`, `Sign_day`, `Expiration_date`, `Status`) VALUES ('CXD001', 'NV003', 'Có xác định thời hạn', '2019-02-03', '2022-02-03', '1');
INSERT INTO `qlnv`.`t_contract` (`Contract_id`, `Employee_id`, `Type_of_contract`, `Sign_day`, `Expiration_date`, `Status`) VALUES ('CXD002', 'NV004', 'Có xác định thời hạn', '2019-03-11', '2022-12-31', '1');
INSERT INTO `qlnv`.`t_contract` (`Contract_id`, `Employee_id`, `Type_of_contract`, `Sign_day`, `Expiration_date`, `Status`) VALUES ('CXD003', 'NV005', 'Có xác định thời hạn', '2019-04-15', '2022-04-10', '1');
INSERT INTO `qlnv`.`t_contract` (`Contract_id`, `Employee_id`, `Type_of_contract`, `Sign_day`, `Expiration_date`, `Status`) VALUES ('CXD004', 'NV006', 'Có xác định thời hạn', '2019-02-04', '2022-02-13', '1');
INSERT INTO `qlnv`.`t_contract` (`Contract_id`, `Employee_id`, `Type_of_contract`, `Sign_day`, `Expiration_date`, `Status`) VALUES ('CXD005', 'NV007', 'Có xác định thời hạn', '2019-03-15', '2022-12-12', '1');
INSERT INTO `qlnv`.`t_contract` (`Contract_id`, `Employee_id`, `Type_of_contract`, `Sign_day`, `Expiration_date`, `Status`) VALUES ('CXD006', 'NV008', 'Có xác định thời hạn', '2019-04-16', '2022-04-17', '1');
INSERT INTO `qlnv`.`t_contract` (`Contract_id`, `Employee_id`, `Type_of_contract`, `Sign_day`, `Expiration_date`, `Status`) VALUES ('TV001', 'NV009', 'Hợp đồng thời vụ', '2019-10-01', '2020-11-01', '1');
INSERT INTO `qlnv`.`t_contract` (`Contract_id`, `Employee_id`, `Type_of_contract`, `Sign_day`, `Expiration_date`, `Status`) VALUES ('TV002', 'NV010', 'Hợp đồng thời vụ', '2019-05-10', '2020-10-10', '1');

/* Thêm dữ liệu vào bảng năm tính lương t_Salary_year */
INSERT INTO `qlnv`.`t_salary_year` (`Salary_year`) VALUES ('2020');
INSERT INTO `qlnv`.`t_salary_year` (`Salary_year`) VALUES ('2021');

/* Thêm dữ liệu vào bảng chi tiết thưởng t_bonus_detail */
INSERT INTO `qlnv`.`t_bonus_detail` (`Bonus_reason`, `Bonus`) VALUES ('Thưởng doanh số', '3000000');
INSERT INTO `qlnv`.`t_bonus_detail` (`Bonus_reason`, `Bonus`) VALUES ('Thưởng dự án', '5000000');
INSERT INTO `qlnv`.`t_bonus_detail` (`Bonus_reason`, `Bonus`) VALUES ('Thưởng chuyên cần', '500000');
INSERT INTO `qlnv`.`t_bonus_detail` (`Bonus_reason`, `Bonus`) VALUES ('Thưởng trách nhiệm', '500000');
INSERT INTO `qlnv`.`t_bonus_detail` (`Bonus_reason`, `Bonus`) VALUES ('Đi làm đầy đủ', '100000');

/* Thêm dữ liệu vào bảng chi tiết thưởng t_fine_detail */
INSERT INTO `qlnv`.`t_fine_detail` (`Fine_reason`, `Fine`) VALUES ('Phạt không chuyên cần', '300000');
INSERT INTO `qlnv`.`t_fine_detail` (`Fine_reason`, `Fine`) VALUES ('Phạt chậm tiến độ', '200000');
INSERT INTO `qlnv`.`t_fine_detail` (`Fine_reason`, `Fine`) VALUES ('Phạt đi muộn', '50000');
INSERT INTO `qlnv`.`t_fine_detail` (`Fine_reason`, `Fine`) VALUES ('Phạt không đạt doanh số', '500000');
INSERT INTO `qlnv`.`t_fine_detail` (`Fine_reason`, `Fine`) VALUES ('Nghỉ nhiều', '100000');

/* Thêm dữ liệu vào bảng số công t_Workday */
INSERT INTO `qlnv`.`t_workday` (`Employee_id`, `Salary_id`, `Day_worked`, `Overtime`) VALUES ('NV001', '1', '22', '16');
INSERT INTO `qlnv`.`t_workday` (`Employee_id`, `Salary_id`, `Day_worked`, `Overtime`) VALUES ('NV002', '1', '20', '14');
INSERT INTO `qlnv`.`t_workday` (`Employee_id`, `Salary_id`, `Day_worked`, `Overtime`) VALUES ('NV003', '1', '26', '10');
INSERT INTO `qlnv`.`t_workday` (`Employee_id`, `Salary_id`, `Day_worked`, `Overtime`) VALUES ('NV004', '1', '26', '10');
INSERT INTO `qlnv`.`t_workday` (`Employee_id`, `Salary_id`, `Day_worked`, `Overtime`) VALUES ('NV005', '1', '26', '10');
INSERT INTO `qlnv`.`t_workday` (`Employee_id`, `Salary_id`, `Day_worked`, `Overtime`) VALUES ('NV006', '2', '26', '10');
INSERT INTO `qlnv`.`t_workday` (`Employee_id`, `Salary_id`, `Day_worked`, `Overtime`) VALUES ('NV007', '2', '26', '10');
INSERT INTO `qlnv`.`t_workday` (`Employee_id`, `Salary_id`, `Day_worked`, `Overtime`) VALUES ('NV008', '2', '26', '10');
INSERT INTO `qlnv`.`t_workday` (`Employee_id`, `Salary_id`, `Day_worked`, `Overtime`) VALUES ('NV009', '2', '26', '72');
INSERT INTO `qlnv`.`t_workday` (`Employee_id`, `Salary_id`, `Day_worked`, `Overtime`) VALUES ('NV010', '2', '26', '20');

/* Thêm dữ liệu vào bảng thông tin thưởng t_bonus_info */
INSERT INTO `qlnv`.`t_bonus_info` (`Employee_id`, `Bonus_id`, `Salary_id`) VALUES ('NV001', '3', '1');
INSERT INTO `qlnv`.`t_bonus_info` (`Employee_id`, `Bonus_id`, `Salary_id`) VALUES ('NV002', '4', '1');
INSERT INTO `qlnv`.`t_bonus_info` (`Employee_id`, `Bonus_id`, `Salary_id`) VALUES ('NV003', '1', '1');
INSERT INTO `qlnv`.`t_bonus_info` (`Employee_id`, `Bonus_id`, `Salary_id`) VALUES ('NV004', '3', '1');
INSERT INTO `qlnv`.`t_bonus_info` (`Employee_id`, `Bonus_id`, `Salary_id`) VALUES ('NV005', '2', '1');
INSERT INTO `qlnv`.`t_bonus_info` (`Employee_id`, `Bonus_id`, `Salary_id`) VALUES ('NV006', '3', '2');
INSERT INTO `qlnv`.`t_bonus_info` (`Employee_id`, `Bonus_id`, `Salary_id`) VALUES ('NV007', '4', '2');
INSERT INTO `qlnv`.`t_bonus_info` (`Employee_id`, `Bonus_id`, `Salary_id`) VALUES ('NV008', '1', '2');
INSERT INTO `qlnv`.`t_bonus_info` (`Employee_id`, `Bonus_id`, `Salary_id`) VALUES ('NV009', '3', '2');
INSERT INTO `qlnv`.`t_bonus_info` (`Employee_id`, `Bonus_id`, `Salary_id`) VALUES ('NV010', '2', '2');

/* Thêm dữ liệu vào bảng thông tin thưởng t_fine_info */
INSERT INTO `qlnv`.`t_fine_info` (`Employee_id`, `Fine_id`, `Salary_id`) VALUES ('NV001', '4', '1');
INSERT INTO `qlnv`.`t_fine_info` (`Employee_id`, `Fine_id`, `Salary_id`) VALUES ('NV002', '1', '1');
INSERT INTO `qlnv`.`t_fine_info` (`Employee_id`, `Fine_id`, `Salary_id`) VALUES ('NV003', '1', '1');
INSERT INTO `qlnv`.`t_fine_info` (`Employee_id`, `Fine_id`, `Salary_id`) VALUES ('NV004', '2', '1');
INSERT INTO `qlnv`.`t_fine_info` (`Employee_id`, `Fine_id`, `Salary_id`) VALUES ('NV005', '3', '1');
INSERT INTO `qlnv`.`t_fine_info` (`Employee_id`, `Fine_id`, `Salary_id`) VALUES ('NV006', '2', '2');
INSERT INTO `qlnv`.`t_fine_info` (`Employee_id`, `Fine_id`, `Salary_id`) VALUES ('NV007', '4', '2');
INSERT INTO `qlnv`.`t_fine_info` (`Employee_id`, `Fine_id`, `Salary_id`) VALUES ('NV008', '1', '2');
INSERT INTO `qlnv`.`t_fine_info` (`Employee_id`, `Fine_id`, `Salary_id`) VALUES ('NV009', '1', '2');
INSERT INTO `qlnv`.`t_fine_info` (`Employee_id`, `Fine_id`, `Salary_id`) VALUES ('NV010', '2', '2');
