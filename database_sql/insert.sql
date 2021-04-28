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
INSERT INTO `qlnv`.`t_workday` (`Employee_id`, `Salary_id`, `Day_worked`, `Overtime`) VALUES ('NV001', '1', '22', '1');
INSERT INTO `qlnv`.`t_workday` (`Employee_id`, `Salary_id`, `Day_worked`, `Overtime`) VALUES ('NV002', '1', '20', '1');
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
