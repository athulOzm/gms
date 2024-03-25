
--
-- Table structure for table `account_2`
--

CREATE TABLE `account_2` (
  `account_id` int(11) NOT NULL,
  `account_name` varchar(40) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `parent_id` int(1) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bank_add`
--

CREATE TABLE `bank_add` (
  `bank_id` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `ac_name` varchar(250) DEFAULT NULL,
  `ac_number` varchar(250) DEFAULT NULL,
  `branch` varchar(250) DEFAULT NULL,
  `signature_pic` varchar(250) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `acc_coa` (
  `HeadCode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `HeadName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `PHeadName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `HeadLevel` int(11) NOT NULL,
  `IsActive` tinyint(1) NOT NULL,
  `IsTransaction` tinyint(1) NOT NULL,
  `IsGL` tinyint(1) NOT NULL,
  `HeadType` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `IsBudget` tinyint(1) NOT NULL,
  `IsDepreciation` tinyint(1) NOT NULL,
  `DepreciationRate` decimal(18,2) NOT NULL,
  `CreateBy` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CreateDate` datetime NOT NULL,
  `UpdateBy` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `UpdateDate` datetime NOT NULL,
  PRIMARY KEY (`HeadName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acc_coa`
--

INSERT INTO `acc_coa` (`HeadCode`, `HeadName`, `PHeadName`, `HeadLevel`, `IsActive`, `IsTransaction`, `IsGL`, `HeadType`, `IsBudget`, `IsDepreciation`, `DepreciationRate`, `CreateBy`, `CreateDate`, `UpdateBy`, `UpdateDate`) VALUES
('4021403', 'AC', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:33:55', '', '0000-00-00 00:00:00'),
('50202', 'Account Payable', 'Current Liabilities', 2, 1, 0, 1, 'L', 0, 0, '0.00', 'admin', '2015-10-15 19:50:43', '', '0000-00-00 00:00:00'),
('10203', 'Account Receivable', 'Current Asset', 2, 1, 0, 0, 'A', 0, 0, '0.00', '', '0000-00-00 00:00:00', 'admin', '2013-09-18 15:29:35'),
('1020201', 'Advance', 'Advance, Deposit And Pre-payments', 3, 1, 0, 1, 'A', 0, 0, '0.00', 'Zoherul', '2015-05-31 13:29:12', 'admin', '2015-12-31 16:46:32'),
('102020103', 'Advance House Rent', 'Advance', 4, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-10-02 16:55:38', 'admin', '2016-10-02 16:57:32'),
('10202', 'Advance, Deposit And Pre-payments', 'Current Asset', 2, 1, 0, 0, 'A', 0, 0, '0.00', '', '0000-00-00 00:00:00', 'admin', '2015-12-31 16:46:24'),
('4020602', 'Advertisement and Publicity', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:51:44', '', '0000-00-00 00:00:00'),
('1010410', 'Air Cooler', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-05-23 12:13:55', '', '0000-00-00 00:00:00'),
('4020603', 'AIT Against Advertisement', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:52:09', '', '0000-00-00 00:00:00'),
('1', 'Assets', 'COA', 0, 1, 0, 0, 'A', 0, 0, '0.00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('1010204', 'Attendance Machine', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:49:31', '', '0000-00-00 00:00:00'),
('40216', 'Audit Fee', 'Other Expenses', 2, 1, 1, 1, 'E', 0, 0, '0.00', 'admin', '2017-07-18 12:54:30', '', '0000-00-00 00:00:00'),
('4021002', 'Bank Charge', 'Financial Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:21:03', '', '0000-00-00 00:00:00'),
('30203', 'Bank Interest', 'Other Income', 2, 1, 1, 1, 'I', 0, 0, '0.00', 'Obaidul', '2015-01-03 14:49:54', 'admin', '2016-09-25 11:04:19'),
('1010104', 'Book Shelf', 'Furniture & Fixturers', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:46:11', '', '0000-00-00 00:00:00'),
('1010407', 'Books and Journal', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-03-27 10:45:37', '', '0000-00-00 00:00:00'),
('4020604', 'Business Development Expenses', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:52:29', '', '0000-00-00 00:00:00'),
('4020606', 'Campaign Expenses', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:52:57', 'admin', '2016-09-19 14:52:48'),
('4020502', 'Campus Rent', 'House Rent', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:46:53', 'admin', '2017-04-27 17:02:39'),
('40212', 'Car Running Expenses', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:28:43', '', '0000-00-00 00:00:00'),
('10201', 'Cash & Cash Equivalent', 'Current Asset', 2, 1, 0, 0, 'A', 0, 0, '0.00', '', '0000-00-00 00:00:00', 'admin', '2015-10-15 15:57:55'),
('1020102', 'Cash At Bank', 'Cash & Cash Equivalent', 3, 1, 0, 0, 'A', 0, 0, '0.00', '2', '2018-07-19 13:43:59', 'admin', '2015-10-15 15:32:42'),
('1020101', 'Cash In Hand', 'Cash & Cash Equivalent', 3, 1, 1, 0, 'A', 0, 0, '0.00', '1', '2019-01-26 07:38:48', 'admin', '2016-05-23 12:05:43'),
('1010207', 'CCTV', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:51:24', '', '0000-00-00 00:00:00'),
('102020102', 'CEO Current A/C', 'Advance', 4, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-09-25 11:54:54', '', '0000-00-00 00:00:00'),
('1010101', 'Class Room Chair', 'Furniture & Fixturers', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:45:29', '', '0000-00-00 00:00:00'),
('4021407', 'Close Circuit Cemera', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:35:35', '', '0000-00-00 00:00:00'),
('4020601', 'Commision on Admission', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:51:21', 'admin', '2016-09-19 14:42:54'),
('1010206', 'Computer', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:51:09', '', '0000-00-00 00:00:00'),
('4021410', 'Computer (R)', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'Zoherul', '2016-03-24 12:38:52', 'Zoherul', '2016-03-24 12:41:40'),
('1010102', 'Computer Table', 'Furniture & Fixturers', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:45:44', '', '0000-00-00 00:00:00'),
('301020401', 'Continuing Registration fee - UoL (Income)', 'Registration Fee (UOL) Income', 4, 1, 1, 0, 'I', 0, 0, '0.00', 'admin', '2015-10-15 17:40:40', '', '0000-00-00 00:00:00'),
('4020904', 'Contratuall Staff Salary', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:12:34', '', '0000-00-00 00:00:00'),
('4020709', 'Cultural Expense', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'nasmud', '2017-04-29 12:45:10', '', '0000-00-00 00:00:00'),
('102', 'Current Asset', 'Assets', 1, 1, 0, 0, 'A', 0, 0, '0.00', '', '0000-00-00 00:00:00', 'admin', '2018-07-07 11:23:00'),
('502', 'Current Liabilities', 'Liabilities', 1, 1, 0, 0, 'L', 0, 0, '0.00', 'anwarul', '2014-08-30 13:18:20', 'admin', '2015-10-15 19:49:21'),
('1020301', 'Customer Receivable', 'Account Receivable', 3, 1, 0, 1, 'A', 0, 0, '0.00', '1', '2019-01-24 12:10:05', 'admin', '2018-07-07 12:31:42'),
('1020202', 'Deposit', 'Advance, Deposit And Pre-payments', 3, 1, 0, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:40:42', '', '0000-00-00 00:00:00'),
('4020605', 'Design & Printing Expense', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:55:00', '', '0000-00-00 00:00:00'),
('4020404', 'Dish Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:58:21', '', '0000-00-00 00:00:00'),
('40215', 'Dividend', 'Other Expenses', 2, 1, 1, 1, 'E', 0, 0, '0.00', 'admin', '2016-09-25 14:07:55', '', '0000-00-00 00:00:00'),
('4020403', 'Drinking Water Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:58:10', '', '0000-00-00 00:00:00'),
('1010211', 'DSLR Camera', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:53:17', 'admin', '2016-01-02 16:23:25'),
('4020908', 'Earned Leave', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:13:38', '', '0000-00-00 00:00:00'),
('5020200010', 'ECU3CYJ0-TESTCASEKevin', 'Account Payable', 2, 1, 1, 0, 'L', 0, 0, '0.00', 'Jhon  Doe', '2018-10-31 18:22:29', '', '0000-00-00 00:00:00'),
('4020607', 'Education Fair Expenses', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:53:42', '', '0000-00-00 00:00:00'),
('1010602', 'Electric Equipment', 'Electrical Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-03-27 10:44:51', '', '0000-00-00 00:00:00'),
('1010203', 'Electric Kettle', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:49:07', '', '0000-00-00 00:00:00'),
('10106', 'Electrical Equipment', 'Non Current Assets', 2, 1, 0, 1, 'A', 0, 0, '0.00', 'admin', '2016-03-27 10:43:44', '', '0000-00-00 00:00:00'),
('4020407', 'Electricity Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:59:31', '', '0000-00-00 00:00:00'),
('40201', 'Entertainment', 'Other Expenses', 2, 1, 1, 1, 'E', 0, 0, '0.00', 'admin', '2013-07-08 16:21:26', 'anwarul', '2013-07-17 14:21:47'),
('2', 'Equity', 'COA', 0, 1, 0, 0, 'L', 0, 0, '0.00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('4', 'Expence', 'COA', 0, 1, 0, 0, 'E', 0, 0, '0.00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('4020903', 'Faculty,Staff Salary & Allowances', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:12:21', '', '0000-00-00 00:00:00'),
('4021404', 'Fax Machine', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:34:15', '', '0000-00-00 00:00:00'),
('4020905', 'Festival & Incentive Bonus', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:12:48', '', '0000-00-00 00:00:00'),
('1010103', 'File Cabinet', 'Furniture & Fixturers', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:46:02', '', '0000-00-00 00:00:00'),
('40210', 'Financial Expenses', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, '0.00', 'anwarul', '2013-08-20 12:24:31', 'admin', '2015-10-15 19:20:36'),
('1010403', 'Fire Extingushier', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-03-27 10:39:32', '', '0000-00-00 00:00:00'),
('4021408', 'Furniture', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:35:47', '', '0000-00-00 00:00:00'),
('10101', 'Furniture & Fixturers', 'Non Current Assets', 2, 1, 0, 1, 'A', 0, 0, '0.00', 'anwarul', '2013-08-20 16:18:15', 'anwarul', '2013-08-21 13:35:40'),
('4020406', 'Gas Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:59:20', '', '0000-00-00 00:00:00'),
('20201', 'General Reserve', 'Reserve & Surplus', 2, 1, 1, 0, 'L', 0, 0, '0.00', 'admin', '2016-09-25 14:07:12', 'admin', '2016-10-02 17:48:49'),
('10105', 'Generator', 'Non Current Assets', 2, 1, 1, 1, 'A', 0, 0, '0.00', 'Zoherul', '2016-02-27 16:02:35', 'admin', '2016-05-23 12:05:18'),
('4021414', 'Generator Repair', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'Zoherul', '2016-06-16 10:21:05', '', '0000-00-00 00:00:00'),
('40213', 'Generator Running Expenses', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:29:29', '', '0000-00-00 00:00:00'),
('10103', 'Groceries and Cutleries', 'Non Current Assets', 2, 1, 1, 1, 'A', 0, 0, '0.00', '2', '2018-07-12 10:02:55', '', '0000-00-00 00:00:00'),
('1010408', 'Gym Equipment', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-03-27 10:46:03', '', '0000-00-00 00:00:00'),
('4020907', 'Honorarium', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:13:26', '', '0000-00-00 00:00:00'),
('40205', 'House Rent', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, '0.00', 'anwarul', '2013-08-24 10:26:56', '', '0000-00-00 00:00:00'),
('3', 'Income', 'COA', 0, 1, 0, 0, 'I', 0, 0, '0.00', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('30204', 'Income from Photocopy & Printing', 'Other Income', 2, 1, 1, 1, 'I', 0, 0, '0.00', 'Zoherul', '2015-07-14 10:29:54', 'admin', '2016-09-25 11:04:28'),
('5020302', 'Income Tax Payable', 'Liabilities for Expenses', 3, 1, 0, 1, 'L', 0, 0, '0.00', 'admin', '2016-09-19 11:18:17', 'admin', '2016-09-28 13:18:35'),
('10107', 'Inventory', 'Non Current Assets', 1, 1, 0, 0, 'A', 0, 0, '0.00', '2', '2018-07-07 15:21:58', '', '0000-00-00 00:00:00'),
('1010210', 'LCD TV', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:52:27', '', '0000-00-00 00:00:00'),
('30103', 'Lease Sale', 'Store Income', 1, 1, 1, 1, 'I', 0, 0, '0.00', '2', '2018-07-08 07:51:52', '', '0000-00-00 00:00:00'),
('5', 'Liabilities', 'COA', 0, 1, 0, 0, 'L', 0, 0, '0.00', 'admin', '2013-07-04 12:32:07', 'admin', '2015-10-15 19:46:54'),
('50203', 'Liabilities for Expenses', 'Current Liabilities', 2, 1, 0, 0, 'L', 0, 0, '0.00', 'admin', '2015-10-15 19:50:59', '', '0000-00-00 00:00:00'),
('4020707', 'Library Expenses', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2017-01-10 15:34:54', '', '0000-00-00 00:00:00'),
('4021409', 'Lift', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:36:12', '', '0000-00-00 00:00:00'),
('1020302', 'Loan Receivable', 'Account Receivable', 3, 1, 0, 1, 'A', 0, 0, '0.00', '1', '2019-01-26 07:37:20', '', '0000-00-00 00:00:00'),
('50101', 'Long Term Borrowing', 'Non Current Liabilities', 2, 1, 0, 1, 'L', 0, 0, '0.00', 'admin', '2013-07-04 12:32:26', 'admin', '2015-10-15 19:47:40'),
('4020608', 'Marketing & Promotion Exp.', 'Promonational Expence', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:53:59', '', '0000-00-00 00:00:00'),
('4020901', 'Medical Allowance', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:11:33', '', '0000-00-00 00:00:00'),
('1010411', 'Metal Ditector', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'Zoherul', '2016-08-22 10:55:22', '', '0000-00-00 00:00:00'),
('4021413', 'Micro Oven', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'Zoherul', '2016-05-12 14:53:51', '', '0000-00-00 00:00:00'),
('30202', 'Miscellaneous (Income)', 'Other Income', 2, 1, 1, 1, 'I', 0, 0, '0.00', 'anwarul', '2014-02-06 15:26:31', 'admin', '2016-09-25 11:04:35'),
('4020909', 'Miscellaneous Benifit', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:13:53', '', '0000-00-00 00:00:00'),
('4020701', 'Miscellaneous Exp', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2016-09-25 12:54:39', '', '0000-00-00 00:00:00'),
('40207', 'Miscellaneous Expenses', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, '0.00', 'anwarul', '2014-04-26 16:49:56', 'admin', '2016-09-25 12:54:19'),
('1010401', 'Mobile Phone', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-01-29 10:43:30', '', '0000-00-00 00:00:00'),
('102020101', 'Mr Ashiqur Rahman', 'Advance', 4, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-12-31 16:47:23', 'admin', '2016-09-25 11:55:13'),
('1010212', 'Network Accessories', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-01-02 16:23:32', '', '0000-00-00 00:00:00'),
('4020408', 'News Paper Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2016-01-02 15:55:57', '', '0000-00-00 00:00:00'),
('101', 'Non Current Assets', 'Assets', 1, 1, 0, 0, 'A', 0, 0, '0.00', '', '0000-00-00 00:00:00', 'admin', '2015-10-15 15:29:11'),
('501', 'Non Current Liabilities', 'Liabilities', 1, 1, 0, 0, 'L', 0, 0, '0.00', 'anwarul', '2014-08-30 13:18:20', 'admin', '2015-10-15 19:49:21'),
('1010404', 'Office Decoration', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-03-27 10:40:02', '', '0000-00-00 00:00:00'),
('10102', 'Office Equipment', 'Non Current Assets', 2, 1, 0, 1, 'A', 0, 0, '0.00', 'anwarul', '2013-12-06 18:08:00', 'admin', '2015-10-15 15:48:21'),
('4021401', 'Office Repair & Maintenance', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:33:15', '', '0000-00-00 00:00:00'),
('30201', 'Office Stationary (Income)', 'Other Income', 2, 1, 1, 1, 'I', 0, 0, '0.00', 'anwarul', '2013-07-17 15:21:06', 'admin', '2016-09-25 11:04:50'),
('402', 'Other Expenses', 'Expence', 1, 1, 0, 0, 'E', 0, 0, '0.00', '2', '2018-07-07 14:00:16', 'admin', '2015-10-15 18:37:42'),
('302', 'Other Income', 'Income', 1, 1, 0, 0, 'I', 0, 0, '0.00', '2', '2018-07-07 13:40:57', 'admin', '2016-09-25 11:04:09'),
('40211', 'Others (Non Academic Expenses)', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, '0.00', 'Obaidul', '2014-12-03 16:05:42', 'admin', '2015-10-15 19:22:09'),
('30205', 'Others (Non-Academic Income)', 'Other Income', 2, 1, 0, 1, 'I', 0, 0, '0.00', 'admin', '2015-10-15 17:23:49', 'admin', '2015-10-15 17:57:52'),
('10104', 'Others Assets', 'Non Current Assets', 2, 1, 0, 1, 'A', 0, 0, '0.00', 'admin', '2016-01-29 10:43:16', '', '0000-00-00 00:00:00'),
('4020910', 'Outstanding Salary', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'Zoherul', '2016-04-24 11:56:50', '', '0000-00-00 00:00:00'),
('4021405', 'Oven', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:34:31', '', '0000-00-00 00:00:00'),
('4021412', 'PABX-Repair', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'Zoherul', '2016-04-24 14:40:18', '', '0000-00-00 00:00:00'),
('4020902', 'Part-time Staff Salary', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:12:06', '', '0000-00-00 00:00:00'),
('1010202', 'Photocopy & Fax Machine', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:47:27', 'admin', '2016-05-23 12:14:40'),
('4021411', 'Photocopy Machine Repair', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'Zoherul', '2016-04-24 12:40:02', 'admin', '2017-04-27 17:03:17'),
('3020503', 'Practical Fee', 'Others (Non-Academic Income)', 3, 1, 1, 1, 'I', 0, 0, '0.00', 'admin', '2017-07-22 18:00:37', '', '0000-00-00 00:00:00'),
('1020203', 'Prepayment', 'Advance, Deposit And Pre-payments', 3, 1, 0, 1, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:40:51', 'admin', '2015-12-31 16:49:58'),
('1010201', 'Printer', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:47:15', '', '0000-00-00 00:00:00'),
('40202', 'Printing and Stationary', 'Other Expenses', 2, 1, 1, 1, 'E', 0, 0, '0.00', 'admin', '2013-07-08 16:21:45', 'admin', '2016-09-19 14:39:32'),
('3020502', 'Professional Training Course(Oracal-1)', 'Others (Non-Academic Income)', 3, 1, 1, 0, 'I', 0, 0, '0.00', 'nasim', '2017-06-22 13:28:05', '', '0000-00-00 00:00:00'),
('30207', 'Professional Training Course(Oracal)', 'Other Income', 2, 1, 0, 1, 'I', 0, 0, '0.00', 'nasim', '2017-06-22 13:24:16', 'nasim', '2017-06-22 13:25:56'),
('1010208', 'Projector', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:51:44', '', '0000-00-00 00:00:00'),
('40206', 'Promonational Expence', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, '0.00', 'anwarul', '2013-07-11 13:48:57', 'anwarul', '2013-07-17 14:23:03'),
('40214', 'Repair and Maintenance', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:32:46', '', '0000-00-00 00:00:00'),
('202', 'Reserve & Surplus', 'Equity', 1, 1, 0, 1, 'L', 0, 0, '0.00', 'admin', '2016-09-25 14:06:34', 'admin', '2016-10-02 17:48:57'),
('20102', 'Retained Earnings', 'Share Holders Equity', 2, 1, 1, 1, 'L', 0, 0, '0.00', 'admin', '2016-05-23 11:20:40', 'admin', '2016-09-25 14:05:06'),
('4020708', 'River Cruse', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2017-04-24 15:35:25', '', '0000-00-00 00:00:00'),
('10203010201', 'Saiful', 'Tarek', 5, 1, 0, 1, 'A', 0, 0, '0.00', '1', '2019-01-23 15:54:51', '', '0000-00-00 00:00:00'),
('102020105', 'Salary', 'Advance', 4, 1, 0, 0, 'A', 0, 0, '0.00', 'admin', '2018-07-05 11:46:44', '', '0000-00-00 00:00:00'),
('40209', 'Salary & Allowances', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, '0.00', 'anwarul', '2013-12-12 11:22:58', '', '0000-00-00 00:00:00'),
('404', 'Sale Discount', 'Expence', 1, 1, 1, 0, 'E', 0, 0, '0.00', '2', '2018-07-19 10:15:11', '', '0000-00-00 00:00:00'),
('1010406', 'Security Equipment', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-03-27 10:41:30', '', '0000-00-00 00:00:00'),
('20101', 'Share Capital', 'Share Holders Equity', 2, 1, 0, 1, 'L', 0, 0, '0.00', 'anwarul', '2013-12-08 19:37:32', 'admin', '2015-10-15 19:45:35'),
('201', 'Share Holders Equity', 'Equity', 1, 1, 0, 0, 'L', 0, 0, '0.00', '', '0000-00-00 00:00:00', 'admin', '2015-10-15 19:43:51'),
('50201', 'Short Term Borrowing', 'Current Liabilities', 2, 1, 0, 1, 'L', 0, 0, '0.00', 'admin', '2015-10-15 19:50:30', '', '0000-00-00 00:00:00'),
('40208', 'Software Development Expenses', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, '0.00', 'anwarul', '2013-11-21 14:13:01', 'admin', '2015-10-15 19:02:51'),
('4020906', 'Special Allowances', 'Salary & Allowances', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:13:13', '', '0000-00-00 00:00:00'),
('50102', 'Sponsors Loan', 'Non Current Liabilities', 2, 1, 0, 1, 'L', 0, 0, '0.00', 'admin', '2015-10-15 19:48:02', '', '0000-00-00 00:00:00'),
('4020706', 'Sports Expense', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'nasmud', '2016-11-09 13:16:53', '', '0000-00-00 00:00:00'),
('401', 'Store Expenses', 'Expence', 1, 1, 0, 0, 'E', 0, 0, '0.00', '2', '2018-07-07 13:38:59', 'admin', '2015-10-15 17:58:46'),
('301', 'Store Income', 'Income', 1, 1, 0, 0, 'I', 0, 0, '0.00', '2', '2018-07-07 13:40:37', 'admin', '2015-09-17 17:00:02'),
('3020501', 'Students Info. Correction Fee', 'Others (Non-Academic Income)', 3, 1, 1, 0, 'I', 0, 0, '0.00', 'admin', '2015-10-15 17:24:45', '', '0000-00-00 00:00:00'),
('1010601', 'Sub Station', 'Electrical Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-03-27 10:44:11', '', '0000-00-00 00:00:00'),
('4020704', 'TB Care Expenses', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2016-10-08 13:03:04', '', '0000-00-00 00:00:00'),
('30206', 'TB Care Income', 'Other Income', 2, 1, 1, 1, 'I', 0, 0, '0.00', 'admin', '2016-10-08 13:00:56', '', '0000-00-00 00:00:00'),
('4020501', 'TDS on House Rent', 'House Rent', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:44:07', 'admin', '2016-09-19 14:40:16'),
('502030201', 'TDS Payable House Rent', 'Income Tax Payable', 4, 1, 1, 0, 'L', 0, 0, '0.00', 'admin', '2016-09-19 11:19:42', 'admin', '2016-09-28 13:19:37'),
('502030203', 'TDS Payable on Advertisement Bill', 'Income Tax Payable', 4, 1, 1, 0, 'L', 0, 0, '0.00', 'admin', '2016-09-28 13:20:51', '', '0000-00-00 00:00:00'),
('502030202', 'TDS Payable on Salary', 'Income Tax Payable', 4, 1, 1, 0, 'L', 0, 0, '0.00', 'admin', '2016-09-28 13:20:17', '', '0000-00-00 00:00:00'),
('4021402', 'Tea Kettle', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:33:45', '', '0000-00-00 00:00:00'),
('4020402', 'Telephone Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:57:59', '', '0000-00-00 00:00:00'),
('1010209', 'Telephone Set & PABX', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:51:57', 'admin', '2016-10-02 17:10:40'),
('102020104', 'Test', 'Advance', 4, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2018-07-05 11:42:48', '', '0000-00-00 00:00:00'),
('40203', 'Travelling & Conveyance', 'Other Expenses', 2, 1, 1, 1, 'E', 0, 0, '0.00', 'admin', '2013-07-08 16:22:06', 'admin', '2015-10-15 18:45:13'),
('4021406', 'TV', 'Repair and Maintenance', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 19:35:07', '', '0000-00-00 00:00:00'),
('1010205', 'UPS', 'Office Equipment', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:50:38', '', '0000-00-00 00:00:00'),
('40204', 'Utility Expenses', 'Other Expenses', 2, 1, 0, 1, 'E', 0, 0, '0.00', 'anwarul', '2013-07-11 16:20:24', 'admin', '2016-01-02 15:55:22'),
('4020503', 'VAT on House Rent Exp', 'House Rent', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:49:22', 'admin', '2016-09-25 14:00:52'),
('5020301', 'VAT Payable', 'Liabilities for Expenses', 3, 1, 0, 1, 'L', 0, 0, '0.00', 'admin', '2015-10-15 19:51:11', 'admin', '2016-09-28 13:23:53'),
('1010409', 'Vehicle A/C', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'Zoherul', '2016-05-12 12:13:21', '', '0000-00-00 00:00:00'),
('1010405', 'Voltage Stablizer', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-03-27 10:40:59', '', '0000-00-00 00:00:00'),
('1010105', 'Waiting Sofa - Steel', 'Furniture & Fixturers', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2015-10-15 15:46:29', '', '0000-00-00 00:00:00'),
('4020405', 'WASA Bill', 'Utility Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2015-10-15 18:58:51', '', '0000-00-00 00:00:00'),
('1010402', 'Water Purifier', 'Others Assets', 3, 1, 1, 0, 'A', 0, 0, '0.00', 'admin', '2016-01-29 11:14:11', '', '0000-00-00 00:00:00'),
('4020705', 'Website Development Expenses', 'Miscellaneous Expenses', 3, 1, 1, 0, 'E', 0, 0, '0.00', 'admin', '2016-10-15 12:42:47', '', '0000-00-00 00:00:00');

CREATE TABLE IF NOT EXISTS `acc_income_expence` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `VNo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Student_Id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Paymode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Perpose` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Narration` text COLLATE utf8_unicode_ci NOT NULL,
  `StoreID` int(11) NOT NULL,
  `COAID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `IsApprove` tinyint(4) NOT NULL,
  `CreateBy` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CreateDate` datetime NOT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
CREATE TABLE IF NOT EXISTS `acc_transaction` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `VNo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Vtype` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VDate` date DEFAULT NULL,
  `COAID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Narration` text COLLATE utf8_unicode_ci,
  `Debit` decimal(18,2) DEFAULT NULL,
  `Credit` decimal(18,2) DEFAULT NULL,
  `IsPosted` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CreateBy` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UpdateDate` datetime DEFAULT NULL,
  `IsAppove` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `bank_summary`
--

CREATE TABLE `bank_summary` (
  `bank_id` varchar(250) DEFAULT NULL,
  `description` text,
  `deposite_id` varchar(250) DEFAULT NULL,
  `date` varchar(250) DEFAULT NULL,
  `ac_type` varchar(50) DEFAULT NULL,
  `dr` float DEFAULT NULL,
  `cr` float DEFAULT NULL,
  `ammount` float DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cheque_manger`
--

CREATE TABLE `cheque_manger` (
  `cheque_id` varchar(100) NOT NULL,
  `transection_id` varchar(100) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `bank_id` varchar(100) NOT NULL,
  `cheque_no` varchar(100) NOT NULL,
  `date` varchar(250) DEFAULT NULL,
  `transection_type` varchar(100) NOT NULL,
  `cheque_status` int(10) NOT NULL,
  `amount` float NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_information`
--

CREATE TABLE `company_information` (
  `company_id` varchar(250) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `website` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_information`
--

INSERT INTO `company_information` (`company_id`, `company_name`, `email`, `address`, `mobile`, `website`, `status`) VALUES
('1', 'bdtask', 'bdtask@gmail.com', 'khilkhet, dhaka', '45656', 'https://www.bdtask.com/', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_information`
--

CREATE TABLE `customer_information` (
  `customer_id` varchar(250) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_mobile` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `status` int(2) NOT NULL COMMENT '1=paid,2=credit',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_ledger`
--

CREATE TABLE `customer_ledger` (
  `id` int(20) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `invoice_no` varchar(100) DEFAULT NULL,
  `receipt_no` varchar(50) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `date` varchar(250) DEFAULT NULL,
  `receipt_from` varchar(50) DEFAULT NULL,
  `status` int(2) NOT NULL,
  `d_c` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `customer_transection_summary`
-- (See below for the actual view)
--
CREATE TABLE `customer_transection_summary` (
`customer_name` varchar(255)
,`customer_id` varchar(100)
,`type` varchar(6)
,`amount` double
);

-- --------------------------------------------------------

--
-- Table structure for table `daily_banking_add`
--

CREATE TABLE `daily_banking_add` (
  `banking_id` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `bank_id` varchar(100) NOT NULL,
  `deposit_type` varchar(255) NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `amount` int(11) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `daily_closing`
--

CREATE TABLE `daily_closing` (
  `closing_id` varchar(255) NOT NULL,
  `last_day_closing` float NOT NULL,
  `cash_in` float NOT NULL,
  `cash_out` float NOT NULL,
  `date` varchar(250) NOT NULL,
  `amount` float NOT NULL,
  `adjustment` float DEFAULT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` varchar(100) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `date` varchar(50) DEFAULT NULL,
  `total_amount` float NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `invoice_discount` float DEFAULT NULL COMMENT 'invoice discount',
  `total_discount` float DEFAULT NULL COMMENT 'total invoice discount',
  `total_tax` float DEFAULT NULL,
  `invoice_details` text NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `invoice_details_id` varchar(100) NOT NULL,
  `invoice_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `quantity` float NOT NULL,
  `rate` float NOT NULL,
  `supplier_rate` float DEFAULT NULL,
  `total_price` float NOT NULL,
  `discount` float DEFAULT NULL,
  `discount_per` varchar(15) DEFAULT NULL,
  `tax` float DEFAULT NULL,
  `paid_amount` float DEFAULT '0',
  `due_amount` float NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) UNSIGNED NOT NULL,
  `phrase` text NOT NULL,
  `english` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `language`
--


INSERT INTO `language` (`id`, `phrase`, `english`) VALUES
(1, 'user_profile', 'User Profile'),
(2, 'setting', 'Setting'),
(3, 'language', 'Language'),
(4, 'manage_users', 'Manage Users'),
(5, 'add_user', 'Add User'),
(6, 'manage_company', 'Manage Company'),
(7, 'web_settings', 'Software Settings'),
(8, 'manage_accounts', 'Manage Accounts'),
(9, 'create_accounts', 'Create Account'),
(10, 'manage_bank', 'Manage Bank'),
(11, 'add_new_bank', 'Add New Bank'),
(12, 'settings', 'Bank'),
(13, 'closing_report', 'Closing Report'),
(14, 'closing', 'Closing'),
(15, 'cheque_manager', 'Cheque Manager'),
(16, 'accounts_summary', 'Accounts Summary'),
(17, 'expense', 'Expense'),
(18, 'income', 'Income'),
(19, 'accounts', 'Accounts'),
(20, 'stock_report', 'Stock Report'),
(21, 'stock', 'Stock'),
(22, 'pos_invoice', 'POS Invoice'),
(23, 'manage_invoice', 'Manage Invoice '),
(24, 'new_invoice', 'New Invoice'),
(25, 'invoice', 'Invoice'),
(26, 'manage_purchase', 'Manage Purchase'),
(27, 'add_purchase', 'Add Purchase'),
(28, 'purchase', 'Purchase'),
(29, 'paid_customer', 'Paid Customer'),
(30, 'manage_customer', 'Manage Customer'),
(31, 'add_customer', 'Add Customer'),
(32, 'customer', 'Customer'),
(33, 'supplier_payment_actual', 'Supplier Payment Ledger'),
(34, 'supplier_sales_summary', 'Supplier Sales Summary'),
(35, 'supplier_sales_details', 'Supplier Sales Details'),
(36, 'supplier_ledger', 'Supplier Ledger'),
(37, 'manage_supplier', 'Manage Supplier'),
(38, 'add_supplier', 'Add Supplier'),
(39, 'supplier', 'Supplier'),
(40, 'product_statement', 'Product Statement'),
(41, 'manage_product', 'Manage Product'),
(42, 'add_product', 'Add Product'),
(43, 'product', 'Product'),
(44, 'manage_category', 'Manage Category'),
(45, 'add_category', 'Add Category'),
(46, 'category', 'Category'),
(47, 'sales_report_product_wise', 'Sales Report (Product Wise)'),
(48, 'purchase_report', 'Purchase Report'),
(49, 'sales_report', 'Sales Report'),
(50, 'todays_report', 'Todays Report'),
(51, 'report', 'Report'),
(52, 'dashboard', 'Dashboard'),
(53, 'online', 'Online'),
(54, 'logout', 'Logout'),
(55, 'change_password', 'Change Password'),
(56, 'total_purchase', 'Total Purchase'),
(57, 'total_amount', 'Total Amount'),
(58, 'supplier_name', 'Supplier Name'),
(59, 'invoice_no', 'Invoice No'),
(60, 'purchase_date', 'Purchase Date'),
(61, 'todays_purchase_report', 'Todays Purchase Report'),
(62, 'total_sales', 'Total Sales'),
(63, 'customer_name', 'Customer Name'),
(64, 'sales_date', 'Sales Date'),
(65, 'todays_sales_report', 'Todays Sales Report'),
(66, 'home', 'Home'),
(67, 'todays_sales_and_purchase_report', 'Todays sales and purchase report'),
(68, 'total_ammount', 'Total Amount'),
(69, 'rate', 'Rate'),
(70, 'product_model', 'Product Model'),
(71, 'product_name', 'Product Name'),
(72, 'search', 'Search'),
(73, 'end_date', 'End Date'),
(74, 'start_date', 'Start Date'),
(75, 'total_purchase_report', 'Total Purchase Report'),
(76, 'total_sales_report', 'Total Sales Report'),
(77, 'total_seles', 'Total Sales'),
(78, 'all_stock_report', 'All Stock Report'),
(79, 'search_by_product', 'Search By Product'),
(80, 'date', 'Date'),
(81, 'print', 'Print'),
(82, 'stock_date', 'Stock Date'),
(83, 'print_date', 'Print Date'),
(84, 'sales', 'Sales'),
(85, 'price', 'Price'),
(86, 'sl', 'SL.'),
(87, 'add_new_category', 'Add new category'),
(88, 'category_name', 'Category Name'),
(89, 'save', 'Save'),
(90, 'delete', 'Delete'),
(91, 'update', 'Update'),
(92, 'action', 'Action'),
(93, 'manage_your_category', 'Manage your category '),
(94, 'category_edit', 'Category Edit'),
(95, 'status', 'Status'),
(96, 'active', 'Active'),
(97, 'inactive', 'Inactive'),
(98, 'save_changes', 'Save Changes'),
(99, 'save_and_add_another', 'Save And Add Another'),
(100, 'model', 'Model'),
(101, 'supplier_price', 'Supplier Price'),
(102, 'sell_price', 'Sale Price'),
(103, 'image', 'Image'),
(104, 'select_one', 'Select One'),
(105, 'details', 'Details'),
(106, 'new_product', 'New Product'),
(107, 'add_new_product', 'Add new product'),
(108, 'barcode', 'Barcode'),
(109, 'qr_code', 'Qr-Code'),
(110, 'product_details', 'Product Details'),
(111, 'manage_your_product', 'Manage your product'),
(112, 'product_edit', 'Product Edit'),
(113, 'edit_your_product', 'Edit your product'),
(114, 'cancel', 'Cancel'),
(115, 'incl_vat', 'Incl. Vat'),
(116, 'money', 'TK'),
(117, 'grand_total', 'Grand Total'),
(118, 'quantity', 'Qnty'),
(119, 'product_report', 'Product Report'),
(120, 'product_sales_and_purchase_report', 'Product sales and purchase report'),
(121, 'previous_stock', 'Previous Stock'),
(122, 'out', 'Out'),
(123, 'in', 'In'),
(124, 'to', 'To'),
(125, 'previous_balance', 'Previous Credit Balance'),
(126, 'customer_address', 'Customer Address'),
(127, 'customer_mobile', 'Customer Mobile'),
(128, 'customer_email', 'Customer Email'),
(129, 'add_new_customer', 'Add new customer'),
(130, 'balance', 'Balance'),
(131, 'mobile', 'Mobile'),
(132, 'address', 'Address'),
(133, 'manage_your_customer', 'Manage your customer'),
(134, 'customer_edit', 'Customer Edit'),
(135, 'paid_customer_list', 'Paid Customer List'),
(136, 'ammount', 'Amount'),
(137, 'customer_ledger', 'Customer Ledger'),
(138, 'manage_customer_ledger', 'Manage Customer Ledger'),
(139, 'customer_information', 'Customer Information'),
(140, 'debit_ammount', 'Debit Amount'),
(141, 'credit_ammount', 'Credit Amount'),
(142, 'balance_ammount', 'Balance Amount'),
(143, 'receipt_no', 'Receipt NO'),
(144, 'description', 'Description'),
(145, 'debit', 'Debit'),
(146, 'credit', 'Credit'),
(147, 'item_information', 'Item Information'),
(148, 'total', 'Total'),
(149, 'please_select_supplier', 'Please Select Supplier'),
(150, 'submit', 'Submit'),
(151, 'submit_and_add_another', 'Submit And Add Another One'),
(152, 'add_new_item', 'Add New Item'),
(153, 'manage_your_purchase', 'Manage your purchase'),
(154, 'purchase_edit', 'Purchase Edit'),
(155, 'purchase_ledger', 'Purchase Ledger'),
(156, 'invoice_information', 'Invoice Information'),
(157, 'paid_ammount', 'Paid Amount'),
(158, 'discount', 'Dis./Pcs.'),
(159, 'save_and_paid', 'Save And Paid'),
(160, 'payee_name', 'Payee Name'),
(161, 'manage_your_invoice', 'Manage your invoice'),
(162, 'invoice_edit', 'Invoice Edit'),
(163, 'new_pos_invoice', 'New POS invoice'),
(164, 'add_new_pos_invoice', 'Add new pos invoice'),
(165, 'product_id', 'Product ID'),
(166, 'paid_amount', 'Paid Amount'),
(167, 'authorised_by', 'Authorised By'),
(168, 'checked_by', 'Checked By'),
(169, 'received_by', 'Received By'),
(170, 'prepared_by', 'Prepared By'),
(171, 'memo_no', 'Memo No'),
(172, 'website', 'Website'),
(173, 'email', 'Email'),
(174, 'invoice_details', 'Invoice Details'),
(175, 'reset', 'Reset'),
(176, 'payment_account', 'Payment Account'),
(177, 'bank_name', 'Bank Name'),
(178, 'cheque_or_pay_order_no', 'Cheque/Pay Order No'),
(179, 'payment_type', 'Payment Type'),
(180, 'payment_from', 'Payment From'),
(181, 'payment_date', 'Payment Date'),
(182, 'add_income', 'Add Income'),
(183, 'cash', 'Cash'),
(184, 'cheque', 'Cheque'),
(185, 'pay_order', 'Pay Order'),
(186, 'payment_to', 'Payment To'),
(187, 'total_outflow_ammount', 'Total Expense Amount'),
(188, 'transections', 'Transections'),
(189, 'accounts_name', 'Accounts Name'),
(190, 'outflow_report', 'Expense Report'),
(191, 'inflow_report', 'Income Report'),
(192, 'all', 'All'),
(193, 'account', 'Account'),
(194, 'from', 'From'),
(195, 'account_summary_report', 'Account Summary Report'),
(196, 'search_by_date', 'Search By Date'),
(197, 'cheque_no', 'Cheque No'),
(198, 'name', 'Name'),
(199, 'closing_account', 'Closing Account'),
(200, 'close_your_account', 'Close your account'),
(201, 'last_day_closing', 'Last Day Closing'),
(202, 'cash_in', 'Cash In'),
(203, 'cash_out', 'Cash Out'),
(204, 'cash_in_hand', 'Cash In Hand'),
(205, 'add_new_bank', 'Add New Bank'),
(206, 'day_closing', 'Day Closing'),
(207, 'account_closing_report', 'Account Closing Report'),
(208, 'last_day_ammount', 'Last Day Amount'),
(209, 'adjustment', 'Adjustment'),
(210, 'pay_type', 'Pay Type'),
(211, 'customer_or_supplier', 'Customer,Supplier Or Others'),
(212, 'transection_id', 'Transections ID'),
(213, 'accounts_summary_report', 'Accounts Summary Report'),
(214, 'bank_list', 'Bank List'),
(215, 'bank_edit', 'Bank Edit'),
(216, 'debit_plus', 'Debit (+)'),
(217, 'credit_minus', 'Credit (-)'),
(218, 'account_name', 'Account Name'),
(219, 'account_type', 'Account Type'),
(220, 'account_real_name', 'Account Real Name'),
(221, 'manage_account', 'Manage Account'),
(222, 'company_name', 'Niha International'),
(223, 'edit_your_company_information', 'Edit your company information'),
(224, 'company_edit', 'Company Edit'),
(225, 'admin', 'Admin'),
(226, 'user', 'User'),
(227, 'password', 'Password'),
(228, 'last_name', 'Last Name'),
(229, 'first_name', 'First Name'),
(230, 'add_new_user_information', 'Add new user information'),
(231, 'user_type', 'User Type'),
(232, 'user_edit', 'User Edit'),
(233, 'rtr', 'RTR'),
(234, 'ltr', 'LTR'),
(235, 'ltr_or_rtr', 'LTR/RTR'),
(236, 'footer_text', 'Footer Text'),
(237, 'favicon', 'Favicon'),
(238, 'logo', 'Logo'),
(239, 'update_setting', 'Update Setting'),
(240, 'update_your_web_setting', 'Update your web setting'),
(241, 'login', 'Login'),
(242, 'your_strong_password', 'Your strong password'),
(243, 'your_unique_email', 'Your unique email'),
(244, 'please_enter_your_login_information', 'Please enter your login information.'),
(245, 'update_profile', 'Update Profile'),
(246, 'your_profile', 'Your Profile'),
(247, 're_type_password', 'Re-Type Password'),
(248, 'new_password', 'New Password'),
(249, 'old_password', 'Old Password'),
(250, 'new_information', 'New Information'),
(251, 'old_information', 'Old Information'),
(252, 'change_your_information', 'Change your information'),
(253, 'change_your_profile', 'Change your profile'),
(254, 'profile', 'Profile'),
(255, 'wrong_username_or_password', 'Wrong User Name Or Password !'),
(256, 'successfully_updated', 'Successfully Updated.'),
(257, 'blank_field_does_not_accept', 'Blank Field Does Not Accept !'),
(258, 'successfully_changed_password', 'Successfully changed password.'),
(259, 'you_are_not_authorised_person', 'You are not authorised person !'),
(260, 'password_and_repassword_does_not_match', 'Passwor and re-password does not match !'),
(261, 'new_password_at_least_six_character', 'New Password At Least 6 Character.'),
(262, 'you_put_wrong_email_address', 'You put wrong email address !'),
(263, 'cheque_ammount_asjusted', 'Cheque amount adjusted.'),
(264, 'successfully_payment_paid', 'Successfully Payment Paid.'),
(265, 'successfully_added', 'Successfully Added.'),
(266, 'successfully_updated_2_closing_ammount_not_changeale', 'Successfully Updated -2. Note: Closing Amount Not Changeable.'),
(267, 'successfully_payment_received', 'Successfully Payment Received.'),
(268, 'already_inserted', 'Already Inserted !'),
(269, 'successfully_delete', 'Successfully Delete.'),
(270, 'successfully_created', 'Successfully Created.'),
(271, 'logo_not_uploaded', 'Logo not uploaded !'),
(272, 'favicon_not_uploaded', 'Favicon not uploaded !'),
(273, 'supplier_mobile', 'Supplier Mobile'),
(274, 'supplier_address', 'Supplier Address'),
(275, 'supplier_details', 'Supplier Details'),
(276, 'add_new_supplier', 'Add New Supplier'),
(277, 'manage_suppiler', 'Manage Supplier'),
(278, 'manage_your_supplier', 'Manage your supplier'),
(279, 'manage_supplier_ledger', 'Manage supplier ledger'),
(280, 'invoice_id', 'Invoice ID'),
(281, 'deposite_id', 'Deposite ID'),
(282, 'supplier_actual_ledger', 'Supplier Payment Ledger'),
(283, 'supplier_information', 'Supplier Information'),
(284, 'event', 'Event'),
(285, 'add_new_income', 'Add New Income'),
(286, 'add_expese', 'Add Expense'),
(287, 'add_new_expense', 'Add New Expense'),
(288, 'total_inflow_ammount', 'Total Income Amount'),
(289, 'create_new_invoice', 'Create New Invoice'),
(290, 'create_pos_invoice', 'Create POS Invoice'),
(291, 'total_profit', 'Total Profit'),
(292, 'monthly_progress_report', 'Monthly Progress Report'),
(293, 'total_invoice', 'Total Invoice'),
(294, 'account_summary', 'Account Summary'),
(295, 'total_supplier', 'Total Supplier'),
(296, 'total_product', 'Total Product'),
(297, 'total_customer', 'Total Customer'),
(298, 'supplier_edit', 'Supplier Edit'),
(299, 'add_new_invoice', 'Add New Invoice'),
(300, 'add_new_purchase', 'Add new purchase'),
(301, 'currency', 'Currency'),
(302, 'currency_position', 'Currency Position'),
(303, 'left', 'Left'),
(304, 'right', 'Right'),
(305, 'add_tax', 'Add Tax'),
(306, 'manage_tax', 'Manage Tax'),
(307, 'add_new_tax', 'Add new tax'),
(308, 'enter_tax', 'Enter Tax'),
(309, 'already_exists', 'Already Exists !'),
(310, 'successfully_inserted', 'Successfully Inserted.'),
(311, 'tax', 'Tax'),
(312, 'tax_edit', 'Tax Edit'),
(313, 'product_not_added', 'Product not added !'),
(314, 'total_tax', 'Total Tax'),
(315, 'manage_your_supplier_details', 'Manage your supplier details.'),
(316, 'invoice_description', 'Lorem Ipsum is sim ply dummy Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy Lorem Ipsum is sim ply dummy Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy'),
(317, 'thank_you_for_choosing_us', 'Thank you very much for choosing us.'),
(318, 'billing_date', 'Billing Date'),
(319, 'billing_to', 'Billing To'),
(320, 'billing_from', 'Billing From'),
(321, 'you_cant_delete_this_product', 'Sorry !!  You can\'t delete this product.This product already used in calculation system!'),
(322, 'old_customer', 'Old Customer'),
(323, 'new_customer', 'New Customer'),
(324, 'new_supplier', 'New Supplier'),
(325, 'old_supplier', 'Old Supplier'),
(326, 'credit_customer', 'Credit Customer'),
(327, 'account_already_exists', 'This Account Already Exists !'),
(328, 'edit_income', 'Edit Income'),
(329, 'you_are_not_access_this_part', 'You are not authorised person !'),
(330, 'account_edit', 'Account Edit'),
(331, 'due', 'Due'),
(332, 'expense_edit', 'Expense Edit'),
(333, 'please_select_customer', 'Please select customer !'),
(334, 'profit_report', 'Profit Report (Invoice Wise)'),
(335, 'total_profit_report', 'Total profit report'),
(336, 'please_enter_valid_captcha', 'Please enter valid captcha.'),
(337, 'category_not_selected', 'Category not selected.'),
(338, 'supplier_not_selected', 'Supplier not selected.'),
(339, 'please_select_product', 'Please select product.'),
(340, 'product_model_already_exist', 'Product model already exist !'),
(341, 'invoice_logo', 'Invoice Logo'),
(342, 'available_qnty', 'Av. Qnty.'),
(343, 'you_can_not_buy_greater_than_available_cartoon', 'You can not select grater than available cartoon !'),
(344, 'customer_details', 'Customer details'),
(345, 'manage_customer_details', 'Manage customer details.'),
(346, 'site_key', 'Captcha Site Key'),
(347, 'secret_key', 'Captcha Secret Key'),
(348, 'captcha', 'Captcha'),
(349, 'cartoon_quantity', 'Cartoon Quantity'),
(350, 'total_cartoon', 'Total Cartoon'),
(351, 'cartoon', 'Cartoon'),
(352, 'item_cartoon', 'Item/Cartoon'),
(353, 'product_and_supplier_did_not_match', 'Product and supplier did not match !'),
(354, 'if_you_update_purchase_first_select_supplier_then_product_and_then_quantity', 'If you update purchase,first select supplier then product and then update qnty.'),
(355, 'item', 'Item'),
(356, 'manage_your_credit_customer', 'Manage your credit customer'),
(357, 'total_quantity', 'Total Quantity'),
(358, 'quantity_per_cartoon', 'Quantity per cartoon'),
(359, 'barcode_qrcode_scan_here', 'Barcode or QR-code scan here'),
(360, 'synchronizer_setting', 'Synchronizer Setting'),
(361, 'data_synchronizer', 'Data Synchronizer'),
(362, 'hostname', 'Host name'),
(363, 'username', 'User Name'),
(364, 'ftp_port', 'FTP Port'),
(365, 'ftp_debug', 'FTP Debug'),
(366, 'project_root', 'Project Root'),
(367, 'please_try_again', 'Please try again'),
(368, 'save_successfully', 'Save successfully'),
(369, 'synchronize', 'Synchronize'),
(370, 'internet_connection', 'Internet Connection'),
(371, 'outgoing_file', 'Outgoing File'),
(372, 'incoming_file', 'Incoming File'),
(373, 'ok', 'Ok'),
(374, 'not_available', 'Not Available'),
(375, 'available', 'Available'),
(376, 'download_data_from_server', 'Download data from server'),
(377, 'data_import_to_database', 'Data import to database'),
(378, 'data_upload_to_server', 'Data uplod to server'),
(379, 'please_wait', 'Please Wait'),
(380, 'ooops_something_went_wrong', 'Oooops Something went wrong !'),
(381, 'upload_successfully', 'Upload successfully'),
(382, 'unable_to_upload_file_please_check_configuration', 'Unable to upload file please check configuration'),
(383, 'please_configure_synchronizer_settings', 'Please configure synchronizer settings'),
(384, 'download_successfully', 'Download successfully'),
(385, 'unable_to_download_file_please_check_configuration', 'Unable to download file please check configuration'),
(386, 'data_import_first', 'Data import past'),
(387, 'data_import_successfully', 'Data import successfully'),
(388, 'unable_to_import_data_please_check_config_or_sql_file', 'Unable to import data please check config or sql file'),
(389, 'total_sale_ctn', 'Total Sale Ctn'),
(390, 'in_qnty', 'In Qnty.'),
(391, 'out_qnty', 'Out Qnty.'),
(392, 'stock_report_supplier_wise', 'Stock Report (Supplier Wise)'),
(393, 'all_stock_report_supplier_wise', 'Stock Report (Suppler Wise)'),
(394, 'select_supplier', 'Select Supplier'),
(395, 'stock_report_product_wise', 'Stock Report (Product Wise)'),
(396, 'phone', 'Phone'),
(397, 'select_product', 'Select Product'),
(398, 'in_quantity', 'In Qnty.'),
(399, 'out_quantity', 'Out Qnty.'),
(400, 'in_taka', 'In TK.'),
(401, 'out_taka', 'Out TK.'),
(402, 'commission', 'Commission'),
(403, 'generate_commission', 'Generate Commssion'),
(404, 'commission_rate', 'Commission Rate'),
(405, 'total_ctn', 'Total Ctn.'),
(406, 'per_pcs_commission', 'Per PCS Commission'),
(407, 'total_commission', 'Total Commission'),
(408, 'enter', 'Enter'),
(409, 'please_add_walking_customer_for_default_customer', 'Please add \'Walking Customer\' for default customer.'),
(410, 'supplier_ammount', 'Supplier Amount'),
(411, 'my_sale_ammount', 'My Sale Amount'),
(412, 'signature_pic', 'Signature Picture'),
(413, 'branch', 'Branch'),
(414, 'ac_no', 'A/C Number'),
(415, 'ac_name', 'A/C Name'),
(416, 'bank_transaction', 'Bank Transaction'),
(417, 'bank', 'Bank'),
(418, 'withdraw_deposite_id', 'Withdraw / Deposite ID'),
(419, 'bank_ledger', 'Bank Ledger'),
(420, 'note_name', 'Note Name'),
(421, 'pcs', 'Pcs.'),
(422, '1', '1'),
(423, '2', '2'),
(424, '5', '5'),
(425, '10', '10'),
(426, '20', '20'),
(427, '50', '50'),
(428, '100', '100'),
(429, '500', '500'),
(430, '1000', '1000'),
(431, 'total_discount', 'Total Discount'),
(432, 'product_not_found', 'Product not found !'),
(433, 'this_is_not_credit_customer', 'This is not credit customer !'),
(434, 'personal_loan', 'Office Loan'),
(435, 'add_person', 'Add Person'),
(436, 'add_loan', 'Add Loan'),
(437, 'add_payment', 'Add Payment'),
(438, 'manage_person', 'Manage Person'),
(439, 'personal_edit', 'Person Edit'),
(440, 'person_ledger', 'Person Ledger'),
(441, 'backup_restore', 'Backup '),
(442, 'database_backup', 'Database backup'),
(443, 'file_information', 'File information'),
(444, 'filename', 'Filename'),
(445, 'size', 'Size'),
(446, 'backup_date', 'Backup date'),
(447, 'backup_now', 'Backup now'),
(448, 'restore_now', 'Restore now'),
(449, 'are_you_sure', 'Are you sure ?'),
(450, 'download', 'Download'),
(451, 'backup_and_restore', 'Backup'),
(452, 'backup_successfully', 'Backup successfully'),
(453, 'delete_successfully', 'Delete successfully'),
(454, 'stock_ctn', 'Stock/Qnt'),
(455, 'unit', 'Unit'),
(456, 'meter_m', 'Meter (M)'),
(457, 'piece_pc', 'Piece (Pc)'),
(458, 'kilogram_kg', 'Kilogram (Kg)'),
(459, 'stock_cartoon', 'Stock Cartoon'),
(460, 'add_product_csv', 'Add Product (CSV)'),
(461, 'import_product_csv', 'Import product (CSV)'),
(462, 'close', 'Close'),
(463, 'download_example_file', 'Download example file.'),
(464, 'upload_csv_file', 'Upload CSV File'),
(465, 'csv_file_informaion', 'CSV File Information'),
(466, 'out_of_stock', 'Out Of Stock'),
(467, 'others', 'Others'),
(468, 'full_paid', 'Full Paid'),
(469, 'successfully_saved', 'Your Data Successfully Saved'),
(470, 'manage_loan', 'Manage Loan'),
(471, 'receipt', 'Receipt'),
(472, 'payment', 'Payment'),
(473, 'cashflow', 'Daily Cash Flow'),
(474, 'signature', 'Signature'),
(475, 'supplier_reports', 'Supplier Reports'),
(476, 'generate', 'Generate'),
(477, 'todays_overview', 'Todays Overview'),
(478, 'last_sales', 'Last Sales'),
(479, 'manage_transaction', 'Manage Transaction'),
(480, 'daily_summary', 'Daily Summary'),
(481, 'daily_cash_flow', 'Daily Cash Flow'),
(482, 'custom_report', 'Custom Report'),
(483, 'transaction', 'Transaction'),
(484, 'receipt_amount', 'Receipt Amount'),
(485, 'transaction_details_datewise', 'Transaction Details Datewise'),
(486, 'cash_closing', 'Cash Closing'),
(487, 'you_can_not_buy_greater_than_available_qnty', 'You can not buy greater than available qnty.'),
(488, 'supplier_id', 'Supplier ID'),
(489, 'category_id', 'Category ID'),
(490, 'select_report', 'Select Report'),
(491, 'supplier_summary', 'Supplier summary'),
(492, 'sales_payment_actual', 'Sales payment actual'),
(493, 'today_already_closed', 'Today already closed.'),
(494, 'root_account', 'Root Account'),
(495, 'office', 'Office'),
(496, 'loan', 'Loan'),
(497, 'transaction_mood', 'Transaction Mood'),
(498, 'select_account', 'Select Account'),
(499, 'add_receipt', 'Add Receipt'),
(500, 'update_transaction', 'Update Transaction'),
(501, 'no_stock_found', 'No Stock Found !'),
(502, 'admin_login_area', 'Admin Login Area'),
(503, 'print_qr_code', 'Print QR Code'),
(504, 'discount_type', 'Discount Type'),
(505, 'discount_percentage', 'Discount'),
(506, 'fixed_dis', 'Fixed Dis.'),
(507, 'return', 'Return'),
(508, 'stock_return_list', 'Stock Return List'),
(509, 'wastage_return_list', 'Wastage Return List'),
(510, 'return_invoice', 'Invoice Return'),
(511, 'sold_qty', 'Sold Qty'),
(512, 'ret_quantity', 'Return Qty'),
(513, 'deduction', 'Deduction'),
(514, 'check_return', 'Check Return'),
(515, 'reason', 'Reason'),
(516, 'usablilties', 'Usability'),
(517, 'adjs_with_stck', 'Adjust With Stock'),
(518, 'return_to_supplier', 'Return To Supplier'),
(519, 'wastage', 'Wastage'),
(520, 'to_deduction', 'Total Deduction '),
(521, 'nt_return', 'Net Return Amount'),
(522, 'return_list', 'Return List'),
(523, 'add_return', 'Add Return'),
(524, 'per_qty', 'Purchase Qty'),
(525, 'return_supplier', 'Supplier Return'),
(526, 'stock_purchase', 'Stock Purchase Price'),
(527, 'stock_sale', 'Stock Sale Price'),
(528, 'supplier_return', 'Supplier Return'),
(529, 'purchase_id', 'Purchase ID'),
(530, 'return_id', 'Return ID'),
(531, 'supplier_return_list', 'Supplier Return List'),
(532, 'c_r_slist', 'Stock Return Stock'),
(533, 'wastage_list', 'Wastage List'),
(534, 'please_input_correct_invoice_id', 'Please Input a Correct Invoice ID'),
(535, 'please_input_correct_purchase_id', 'Please Input Your Correct  Purchase ID'),
(536, 'add_more', 'Add More'),
(537, 'prouct_details', 'Product Details'),
(538, 'prouct_detail', 'Product Details'),
(539, 'stock_return', 'Stock Return'),
(540, 'choose_transaction', 'Select Transaction'),
(541, 'transection_category', 'Select  Category'),
(542, 'transaction_categry', 'Select Category'),
(543, 'search_supplier', 'Search Supplier'),
(544, 'customer_id', 'Customer ID'),
(545, 'search_customer', 'Search Customer Invoice'),
(546, 'serial_no', 'Serial Number'),
(547, 'item_discount', 'Item Discount'),
(548, 'invoice_discount', 'Invoice Discount'),
(549, 'add_unit', 'Add Unit'),
(550, 'manage_unit', 'Manage Unit'),
(551, 'add_new_unit', 'Add New Unit'),
(552, 'unit_name', 'Unit Name'),
(553, 'payment_amount', 'Payment Amount'),
(554, 'manage_your_unit', 'Manage Your Unit'),
(555, 'unit_id', 'Unit ID'),
(556, 'unit_edit', 'Unit Edit'),
(557, 'vat', 'Vat'),
(558, 'sales_report_category_wise', 'Sales Report (Category wise)'),
(559, 'purchase_report_category_wise', 'Purchase Report (Category wise)'),
(560, 'category_wise_purchase_report', 'Category wise purchase report'),
(561, 'category_wise_sales_report', 'Category wise sales report'),
(562, 'best_sale_product', 'Best Sale Product'),
(563, 'all_best_sales_product', 'All Best Sales Products'),
(564, 'todays_customer_receipt', 'Todays Customer Receipt'),
(565, 'not_found', 'Record not found'),
(566, 'collection', 'Collection'),
(567, 'increment', 'Increment'),
(568, 'accounts_tree_view', 'Accounts Tree View'),
(569, 'debit_voucher', 'Debit Voucher'),
(570, 'voucher_no', 'Voucher No'),
(571, 'credit_account_head', 'Credit Account Head'),
(572, 'remark', 'Remark'),
(573, 'code', 'Code'),
(574, 'amount', 'Amount'),
(575, 'approved', 'Approved'),
(576, 'debit_account_head', 'Debit Account Head'),
(577, 'credit_voucher', 'Credit Voucher'),
(578, 'find', 'Find'),
(579, 'transaction_date', 'Transaction Date'),
(580, 'voucher_type', 'Voucher Type'),
(581, 'particulars', 'Particulars'),
(582, 'with_details', 'With Details'),
(583, 'general_ledger', 'General Ledger'),
(584, 'general_ledger_of', 'General ledger of'),
(585, 'pre_balance', 'Pre Balance'),
(586, 'current_balance', 'Current Balance'),
(587, 'to_date', 'To Date'),
(588, 'from_date', 'From Date'),
(589, 'trial_balance', 'Trial Balance'),
(590, 'authorized_signature', 'Authorized Signature'),
(591, 'chairman', 'Chairman'),
(592, 'total_income', 'Total Income'),
(593, 'statement_of_comprehensive_income', 'Statement of Comprehensive Income'),
(594, 'profit_loss', 'Profit Loss'),
(595, 'cash_flow_report', 'Cash Flow Report'),
(596, 'cash_flow_statement', 'Cash Flow Statement'),
(597, 'amount_in_dollar', 'Amount In Dollar'),
(598, 'opening_cash_and_equivalent', 'Opening Cash and Equivalent'),
(599, 'coa_print', 'Coa Print'),
(600, 'cash_flow', 'Cash Flow'),
(601, 'cash_book', 'Cash Book'),
(602, 'bank_book', 'Bank Book'),
(603, 'c_o_a', 'Chart of Account'),
(604, 'journal_voucher', 'Journal Voucher'),
(605, 'contra_voucher', 'Contra Voucher'),
(606, 'voucher_approval', 'Vouchar Approval'),
(607, 'supplier_payment', 'Supplier Payment'),
(608, 'customer_receive', 'Customer Receive'),
(609, 'gl_head', 'General Head'),
(610, 'account_code', 'Account Head'),
(611, 'opening_balance', 'Opening Balance'),
(612, 'head_of_account', 'Head of Account'),
(613, 'inventory_ledger', 'Inventory Ledger'),
(614, 'newpassword', 'New Password'),
(615, 'password_recovery', 'Password Recovery'),
(616, 'forgot_password', 'Forgot Password ??'),
(617, 'send', 'Send');
-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL,
  `cash_date` varchar(20) NOT NULL,
  `1000n` varchar(11) NOT NULL,
  `500n` varchar(11) NOT NULL,
  `100n` varchar(11) NOT NULL,
  `50n` varchar(11) NOT NULL,
  `20n` varchar(11) NOT NULL,
  `10n` varchar(11) NOT NULL,
  `5n` varchar(11) NOT NULL,
  `2n` varchar(11) NOT NULL,
  `1n` varchar(30) NOT NULL,
  `grandtotal` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_trans`
--

CREATE TABLE `payment_trans` (
  `transection_id` varchar(200) NOT NULL,
  `tracing_id` varchar(200) NOT NULL,
  `payment_type` varchar(10) NOT NULL,
  `date` varchar(50) DEFAULT NULL,
  `amount` float NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `personal_loan`
--

CREATE TABLE `personal_loan` (
  `per_loan_id` int(11) NOT NULL,
  `transaction_id` varchar(30) NOT NULL,
  `person_id` varchar(30) NOT NULL,
  `debit` float DEFAULT NULL,
  `credit` float NOT NULL,
  `date` varchar(30) NOT NULL,
  `details` varchar(100) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=no paid,2=paid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `person_information`
--

CREATE TABLE `person_information` (
  `person_id` varchar(50) NOT NULL,
  `person_name` varchar(50) NOT NULL,
  `person_phone` varchar(50) NOT NULL,
  `person_address` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `person_ledger`
--

CREATE TABLE `person_ledger` (
  `transaction_id` varchar(50) NOT NULL,
  `person_id` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `debit` float NOT NULL,
  `credit` float NOT NULL,
  `details` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=no paid,2=paid',
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pesonal_loan_information`
--

CREATE TABLE `pesonal_loan_information` (
  `id` int(11) NOT NULL,
  `person_id` varchar(50) NOT NULL,
  `person_name` varchar(50) NOT NULL,
  `person_phone` varchar(30) NOT NULL,
  `person_address` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `category_id` varchar(255) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_information`
--

CREATE TABLE `product_information` (
  `product_id` varchar(100) NOT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `tax` float DEFAULT NULL COMMENT 'Tax in %',
  `serial_no` varchar(50) DEFAULT NULL,
  `product_model` varchar(100) NOT NULL,
  `product_details` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_price_history`
--

CREATE TABLE `product_price_history` (
  `product_pr_his_id` int(11) NOT NULL,
  `product_id` varchar(30) CHARACTER SET latin1 NOT NULL,
  `supplier_id` varchar(30) CHARACTER SET latin1 NOT NULL,
  `supplier_price` double NOT NULL,
  `date_of_price_buy` varchar(30) CHARACTER SET latin1 NOT NULL,
  `affect_time_pc` varchar(30) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase`
--

CREATE TABLE `product_purchase` (
  `purchase_id` varchar(100) NOT NULL,
  `chalan_no` varchar(100) NOT NULL,
  `supplier_id` varchar(100) NOT NULL,
  `grand_total_amount` float NOT NULL,
  `total_discount` float DEFAULT NULL,
  `purchase_date` varchar(50) NOT NULL,
  `purchase_details` text NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase_details`
--

CREATE TABLE `product_purchase_details` (
  `purchase_detail_id` varchar(100) NOT NULL,
  `purchase_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `quantity` float NOT NULL,
  `rate` float NOT NULL,
  `total_amount` float NOT NULL,
  `discount` float DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `product_report`
-- (See below for the actual view)
--
CREATE TABLE `product_report` (
`date` varchar(50)
,`product_id` varchar(100)
,`quantity` double
,`rate` float
,`total_amount` double
,`account` varchar(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `product_return`
--

CREATE TABLE `product_return` (
  `return_id` varchar(30) CHARACTER SET latin1 NOT NULL,
  `product_id` varchar(20) CHARACTER SET latin1 NOT NULL,
  `invoice_id` varchar(20) CHARACTER SET latin1 NOT NULL,
  `purchase_id` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `date_purchase` varchar(20) CHARACTER SET latin1 NOT NULL,
  `date_return` varchar(30) CHARACTER SET latin1 NOT NULL,
  `byy_qty` float NOT NULL,
  `ret_qty` float NOT NULL,
  `customer_id` varchar(20) CHARACTER SET latin1 NOT NULL,
  `supplier_id` varchar(30) CHARACTER SET latin1 NOT NULL,
  `product_rate` float NOT NULL,
  `deduction` float NOT NULL,
  `total_deduct` float NOT NULL,
  `total_tax` float NOT NULL,
  `total_ret_amount` float NOT NULL,
  `net_total_amount` float NOT NULL,
  `reason` text CHARACTER SET latin1 NOT NULL,
  `usablity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `product_supplier`
-- (See below for the actual view)
--
CREATE TABLE `product_supplier` (
`product_id` varchar(100)
,`product_name` varchar(255)
,`product_model` varchar(100)
,`supplier_id` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `purchase_report`
-- (See below for the actual view)
--
CREATE TABLE `purchase_report` (
`purchase_date` varchar(50)
,`chalan_no` varchar(100)
,`supplier_id` varchar(100)
,`purchase_detail_id` varchar(100)
,`purchase_id` varchar(100)
,`product_id` varchar(100)
,`quantity` float
,`rate` float
,`total_amount` float
,`status` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `sales_actual`
-- (See below for the actual view)
--
CREATE TABLE `sales_actual` (
`DATE` varchar(50)
,`supplier_id` varchar(100)
,`sub_total` double
,`no_transection` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `sales_report`
-- (See below for the actual view)
--
CREATE TABLE `sales_report` (
`date` varchar(50)
,`invoice_id` varchar(100)
,`invoice_details_id` varchar(100)
,`customer_id` varchar(100)
,`supplier_id` varchar(100)
,`product_id` varchar(100)
,`product_model` varchar(100)
,`product_name` varchar(255)
,`quantity` float
,`sell_rate` float
,`supplier_rate` float
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `stock_history`
-- (See below for the actual view)
--
CREATE TABLE `stock_history` (
`vdate` varchar(50)
,`product_id` varchar(100)
,`sell` double
,`Purchase` double
);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_information`
--

CREATE TABLE `supplier_information` (
  `id` int(11) NOT NULL,
  `supplier_id` varchar(100) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `details` varchar(255) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_ledger`
--

CREATE TABLE `supplier_ledger` (
  `id` int(20) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `supplier_id` varchar(100) NOT NULL,
  `chalan_no` varchar(100) DEFAULT NULL,
  `deposit_no` varchar(50) DEFAULT NULL,
  `amount` float NOT NULL,
  `description` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `date` varchar(50) NOT NULL,
  `status` int(2) NOT NULL,
  `d_c` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_product`
--

CREATE TABLE `supplier_product` (
  `supplier_pr_id` int(11) NOT NULL,
  `product_id` varchar(30) CHARACTER SET latin1 NOT NULL,
  `products_model` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `supplier_id` varchar(30) CHARACTER SET latin1 NOT NULL,
  `supplier_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `synchronizer_setting`
--

CREATE TABLE `synchronizer_setting` (
  `id` int(11) NOT NULL,
  `hostname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `port` varchar(10) NOT NULL,
  `debug` varchar(10) NOT NULL,
  `project_root` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tax_information`
--

CREATE TABLE `tax_information` (
  `tax_id` varchar(15) NOT NULL,
  `tax` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transection`
--

CREATE TABLE `transection` (
  `id` int(20) NOT NULL,
  `transaction_id` varchar(30) NOT NULL,
  `date_of_transection` varchar(30) NOT NULL,
  `transection_type` varchar(30) NOT NULL,
  `transection_category` varchar(30) NOT NULL,
  `transection_mood` varchar(25) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `pay_amount` int(30) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `relation_id` varchar(30) NOT NULL,
  `is_transaction` int(2) NOT NULL COMMENT '0 = invoice and 1 = transaction'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unit_id` varchar(255) CHARACTER SET latin1 NOT NULL,
  `unit_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`, `status`) VALUES
('I3QT1TR3VJIYAZX', 'Piece', 1),
('W9YUY1HJQM9IEFT', 'KG', 1),
('XM4H48345SO6M94', 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(15) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `gender` int(2) NOT NULL,
  `date_of_birth` varchar(255) NOT NULL,
  `logo` varchar(250) DEFAULT NULL,
  `status` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `user_id` varchar(15) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` int(2) NOT NULL,
  `security_code` varchar(255) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--

-- Stand-in structure for view `view_customer_transection`
-- (See below for the actual view)
--
CREATE TABLE `view_customer_transection` (
`transaction_id` varchar(30)
,`customer_name` varchar(255)
,`invoice_no` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_person_transection`
-- (See below for the actual view)
--
CREATE TABLE `view_person_transection` (
`transaction_id` varchar(30)
,`person_name` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_supplier_transection`
-- (See below for the actual view)
--
CREATE TABLE `view_supplier_transection` (
`transaction_id` varchar(30)
,`supplier_name` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_transection`
-- (See below for the actual view)
--
CREATE TABLE `view_transection` (
`transaction_id` varchar(30)
,`date_of_transection` varchar(30)
,`amount` varchar(20)
,`pay_amount` int(30)
,`invoice_no` varchar(100)
,`customer_name` varchar(255)
,`supplier_name` varchar(255)
,`person_name` varchar(50)
,`transection_category` varchar(30)
,`transection_type` varchar(30)
,`transection_mood` varchar(25)
,`description` varchar(255)
,`relation_id` varchar(30)
);

-- --------------------------------------------------------

--
-- Table structure for table `web_setting`
--

CREATE TABLE `web_setting` (
  `setting_id` int(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `invoice_logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `currency_position` varchar(10) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `rtr` varchar(255) DEFAULT NULL,
  `captcha` int(11) DEFAULT '1' COMMENT '0=active,1=inactive',
  `site_key` varchar(250) DEFAULT NULL,
  `secret_key` varchar(250) DEFAULT NULL,
  `discount_type` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `web_setting`
--

INSERT INTO `web_setting` (`setting_id`, `logo`, `invoice_logo`, `favicon`, `currency`, `currency_position`, `footer_text`, `language`, `rtr`, `captcha`, `site_key`, `secret_key`, `discount_type`) VALUES
(1, 'http://store.bdtask.com/beta/my-assets/image/logo/37e6319ba5b91ed3bbf418f0fcd4e834.png', 'http://store.bdtask.com/beta/my-assets/image/logo/795e09495b11ef567798ab6c055c3476.png', 'http://store.bdtask.com/beta/my-assets/image/logo/55480f15a50555ae4406aecce9bf2342.png', '$', '0', 'Copyright Ãƒâ€šÃ‚Â© 2016-2017 bdtask. All rights reserved.', 'english', '0', 1, '', '', 1);

-- --------------------------------------------------------

--
-- Structure for view `customer_transection_summary`
--
DROP TABLE IF EXISTS `customer_transection_summary`;

CREATE VIEW `customer_transection_summary`  AS  select `customer_information`.`customer_name` AS `customer_name`,`customer_ledger`.`customer_id` AS `customer_id`,'credit' AS `type`,sum(-(`customer_ledger`.`amount`)) AS `amount` from (`customer_ledger` join `customer_information` on((`customer_information`.`customer_id` = `customer_ledger`.`customer_id`))) where (isnull(`customer_ledger`.`receipt_no`) and (`customer_ledger`.`status` = 1)) group by `customer_ledger`.`customer_id` union all select `customer_information`.`customer_name` AS `customer_name`,`customer_ledger`.`customer_id` AS `customer_id`,'debit' AS `type`,sum(`customer_ledger`.`amount`) AS `amount` from (`customer_ledger` join `customer_information` on((`customer_information`.`customer_id` = `customer_ledger`.`customer_id`))) where (isnull(`customer_ledger`.`invoice_no`) and (`customer_ledger`.`status` = 1)) group by `customer_ledger`.`customer_id` ;

-- --------------------------------------------------------

--
-- Structure for view `product_report`
--
DROP TABLE IF EXISTS `product_report`;

CREATE VIEW `product_report`  AS  select `purchase_report`.`purchase_date` AS `date`,`purchase_report`.`product_id` AS `product_id`,`purchase_report`.`quantity` AS `quantity`,`purchase_report`.`rate` AS `rate`,`purchase_report`.`total_amount` AS `total_amount`,'a' AS `account` from `purchase_report` union all select `sales_report`.`date` AS `date`,`sales_report`.`product_id` AS `product_id`,-(`sales_report`.`quantity`) AS `-quantity`,`sales_report`.`supplier_rate` AS `rate`,(`sales_report`.`quantity` * `sales_report`.`supplier_rate`) AS `total_amount`,'b' AS `account` from `sales_report` ;

-- --------------------------------------------------------

--
-- Structure for view `product_supplier`
--
DROP TABLE IF EXISTS `product_supplier`;

CREATE VIEW `product_supplier`  AS  select `b`.`product_id` AS `product_id`,`c`.`product_name` AS `product_name`,`c`.`product_model` AS `product_model`,`a`.`supplier_id` AS `supplier_id` from ((`product_purchase` `a` join `product_purchase_details` `b`) join `product_information` `c`) where ((`a`.`purchase_id` = `b`.`purchase_id`) and (`c`.`product_id` = `b`.`product_id`)) group by `b`.`product_id` ;

-- --------------------------------------------------------

--
-- Structure for view `purchase_report`
--
DROP TABLE IF EXISTS `purchase_report`;

CREATE VIEW `purchase_report`  AS  select `product_purchase`.`purchase_date` AS `purchase_date`,`product_purchase`.`chalan_no` AS `chalan_no`,`product_purchase`.`supplier_id` AS `supplier_id`,`product_purchase_details`.`purchase_detail_id` AS `purchase_detail_id`,`product_purchase_details`.`purchase_id` AS `purchase_id`,`product_purchase_details`.`product_id` AS `product_id`,`product_purchase_details`.`quantity` AS `quantity`,`product_purchase_details`.`rate` AS `rate`,`product_purchase_details`.`total_amount` AS `total_amount`,`product_purchase_details`.`status` AS `status` from (`product_purchase_details` left join `product_purchase` on((`product_purchase_details`.`purchase_id` = `product_purchase`.`purchase_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `sales_actual`
--
DROP TABLE IF EXISTS `sales_actual`;

CREATE VIEW `sales_actual`  AS  select `sales_report`.`date` AS `DATE`,`sales_report`.`supplier_id` AS `supplier_id`,sum((`sales_report`.`quantity` * -(`sales_report`.`supplier_rate`))) AS `sub_total`,sum(`sales_report`.`quantity`) AS `no_transection` from `sales_report` group by `sales_report`.`date`,`sales_report`.`supplier_id` union all select `supplier_ledger`.`date` AS `date`,`supplier_ledger`.`supplier_id` AS `supplier_id`,`supplier_ledger`.`amount` AS `sub_total`,`supplier_ledger`.`description` AS `no_transection` from `supplier_ledger` where isnull(`supplier_ledger`.`chalan_no`) group by `supplier_ledger`.`date`,`supplier_ledger`.`description`,`supplier_ledger`.`supplier_id` ;

-- --------------------------------------------------------

--
-- Structure for view `sales_report`
--
DROP TABLE IF EXISTS `sales_report`;

CREATE VIEW `sales_report`  AS  select `b`.`date` AS `date`,`b`.`invoice_id` AS `invoice_id`,`a`.`invoice_details_id` AS `invoice_details_id`,`b`.`customer_id` AS `customer_id`,`c`.`supplier_id` AS `supplier_id`,`a`.`product_id` AS `product_id`,`c`.`product_model` AS `product_model`,`c`.`product_name` AS `product_name`,`a`.`quantity` AS `quantity`,`a`.`rate` AS `sell_rate`,`a`.`supplier_rate` AS `supplier_rate` from ((`invoice_details` `a` join `invoice` `b`) join `product_supplier` `c`) where ((`a`.`invoice_id` = `b`.`invoice_id`) and (`a`.`product_id` = `c`.`product_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `stock_history`
--
DROP TABLE IF EXISTS `stock_history`;

CREATE VIEW `stock_history`  AS  select `invoice`.`date` AS `vdate`,`invoice_details`.`product_id` AS `product_id`,sum(`invoice_details`.`quantity`) AS `sell`,0 AS `Purchase` from (`invoice_details` join `invoice` on((`invoice_details`.`invoice_id` = `invoice`.`invoice_id`))) group by `invoice_details`.`product_id`,`invoice`.`date` union select `product_purchase`.`purchase_date` AS `purchase_date`,`product_purchase_details`.`product_id` AS `product_id`,0 AS `0`,sum(`product_purchase_details`.`quantity`) AS `purchase` from (`product_purchase_details` join `product_purchase` on((`product_purchase_details`.`purchase_id` = `product_purchase`.`purchase_id`))) group by `product_purchase_details`.`product_id`,`product_purchase`.`purchase_date` ;

-- --------------------------------------------------------

--
-- Structure for view `view_customer_transection`
--
DROP TABLE IF EXISTS `view_customer_transection`;

CREATE VIEW `view_customer_transection`  AS  (select `i`.`transaction_id` AS `transaction_id`,`j`.`customer_name` AS `customer_name`,`q`.`invoice_no` AS `invoice_no` from ((`transection` `i` left join `customer_information` `j` on((convert(`i`.`relation_id` using utf8) = `j`.`customer_id`))) left join `customer_ledger` `q` on((convert(`i`.`transaction_id` using utf8) = `q`.`transaction_id`)))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_person_transection`
--
DROP TABLE IF EXISTS `view_person_transection`;

CREATE VIEW `view_person_transection`  AS  (select `i`.`transaction_id` AS `transaction_id`,`j`.`person_name` AS `person_name` from (`transection` `i` left join `person_information` `j` on((convert(`i`.`relation_id` using utf8) = `j`.`person_id`)))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_supplier_transection`
--
DROP TABLE IF EXISTS `view_supplier_transection`;

CREATE VIEW `view_supplier_transection`  AS  (select `i`.`transaction_id` AS `transaction_id`,`j`.`supplier_name` AS `supplier_name` from (`transection` `i` left join `supplier_information` `j` on((convert(`i`.`relation_id` using utf8) = `j`.`supplier_id`)))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_transection`
--
DROP TABLE IF EXISTS `view_transection`;

CREATE VIEW `view_transection`  AS  (select `i`.`transaction_id` AS `transaction_id`,`i`.`date_of_transection` AS `date_of_transection`,`i`.`amount` AS `amount`,`i`.`pay_amount` AS `pay_amount`,`f`.`invoice_no` AS `invoice_no`,`g`.`customer_name` AS `customer_name`,`h`.`supplier_name` AS `supplier_name`,`j`.`person_name` AS `person_name`,`i`.`transection_category` AS `transection_category`,`i`.`transection_type` AS `transection_type`,`i`.`transection_mood` AS `transection_mood`,`i`.`description` AS `description`,`i`.`relation_id` AS `relation_id` from ((((`transection` `i` left join `customer_ledger` `f` on((convert(`i`.`transaction_id` using utf8) = `f`.`transaction_id`))) left join `customer_information` `g` on((convert(`i`.`relation_id` using utf8) = `f`.`customer_id`))) left join `supplier_information` `h` on((convert(`i`.`relation_id` using utf8) = `h`.`supplier_id`))) left join `person_information` `j` on((convert(`i`.`relation_id` using utf8) = `j`.`person_id`)))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_2`
--
ALTER TABLE `account_2`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `customer_ledger`
--
ALTER TABLE `customer_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`note_id`);

--
-- Indexes for table `personal_loan`
--
ALTER TABLE `personal_loan`
  ADD PRIMARY KEY (`per_loan_id`);

--
-- Indexes for table `pesonal_loan_information`
--
ALTER TABLE `pesonal_loan_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_information`
--
ALTER TABLE `supplier_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_ledger`
--
ALTER TABLE `supplier_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_product`
--
ALTER TABLE `supplier_product`
  ADD PRIMARY KEY (`supplier_pr_id`);

--
-- Indexes for table `transection`
--
ALTER TABLE `transection`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_2`
--
ALTER TABLE `account_2`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_ledger`
--
ALTER TABLE `customer_ledger`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=568;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_loan`
--
ALTER TABLE `personal_loan`
  MODIFY `per_loan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesonal_loan_information`
--
ALTER TABLE `pesonal_loan_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_information`
--
ALTER TABLE `supplier_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_ledger`
--
ALTER TABLE `supplier_ledger`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_product`
--
ALTER TABLE `supplier_product`
  MODIFY `supplier_pr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transection`
--
ALTER TABLE `transection`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
