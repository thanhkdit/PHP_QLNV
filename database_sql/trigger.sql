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
   