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