-- 
-- TABLE: walkin_role --
-- 
CREATE TABLE `walkin_role` (
  `id` int(11) NOT NULL,
  `idCard` varchar(13) DEFAULT NULL COMMENT 'เลขบัตร ปชช',
  `idStudent` varchar(10) DEFAULT NULL COMMENT 'รหัสนิสิต',
  `pname` varchar(50) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `studentName` varchar(255) DEFAULT NULL,
  `profileName` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `imageCard` varchar(50) DEFAULT NULL,
  `updatedDate` timestamp NULL DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  `verificationCode` varchar(10) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=ยังไม่ยืนยัน, 1=ยืนยันแล้ว',
  `role` varchar(50) DEFAULT NULL,
  `examLocation` int(11) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `lastDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `walkin_role`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `walkin_role` (`id`, `idCard`, `idStudent`, `pname`, `fname`, `lname`, `studentName`, `profileName`, `email`, `mobile`, `image`, `imageCard`, `updatedDate`, `updatedBy`, `verificationCode`, `verified`, `role`, `examLocation`, `password`, `lastDate`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, 'ณัฐพร แซ่คู', 'nattaporn.s@ku.th', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'admin', NULL, 'admin', NULL),
(2, NULL, NULL, NULL, NULL, NULL, NULL, 'ศลิษฏ์ หอมกลุ่น', 'salit.ho@ku.th', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'admin', NULL, 'admin', NULL),
(3, NULL, NULL, NULL, NULL, NULL, NULL, 'จิตติ นิรมิตรานนท์', 'jitti.n@ku.th', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'admin', NULL, 'admin', NULL),
(4, NULL, NULL, NULL, NULL, NULL, NULL, 'พรนภา โรจนะวิจิตร', 'pornnapar.r@ku.th', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'admin', NULL, '', NULL),
(5, NULL, NULL, NULL, NULL, NULL, NULL, 'เบญจวรรณ ทิพย์ยอดศรี', 'benchawan.chana@ku.th', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'admin', NULL, '', NULL),
(6, NULL, NULL, NULL, NULL, NULL, NULL, 'ดิศทัต แพทยานนท์', 'disatad.ba@ku.th', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'admin', NULL, '', NULL),
(7, NULL, NULL, NULL, NULL, NULL, NULL, 'ภาณุวัฒน์ บุญชัยกมลอากร', 'phanuvat.b@ku.th', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'admin', NULL, '', NULL),
(8, NULL, NULL, NULL, NULL, NULL, NULL, 'อัคคสรี จิรชาญชัย', 'akkhasri.j@ku.th', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'admin', NULL, '', NULL),
(9, NULL, NULL, NULL, NULL, NULL, NULL, 'จรูญศักดิ์ สวนสวรรค์', 'jaroonsak.s@ku.th', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'admin', NULL, '', NULL),
(10, NULL, NULL, NULL, NULL, NULL, NULL, 'สรพงษ์ เรือนมณี', 'sorapong.r@ku.th', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'admin', NULL, '', NULL),
(11, NULL, NULL, NULL, NULL, NULL, NULL, 'ชัยพร ใจแก้ว', 'chaiporn.j@ku.th', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'admin', NULL, '', NULL);


-- 
-- TABLE: LOCATION --
-- 
CREATE TABLE `walkin_location` (
  `id` int(11) NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `locationName` varchar(255) NOT NULL,
  `locationCode` varchar(5) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `subDistinct` varchar(50) DEFAULT NULL,
  `distinct` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `zipcode` varchar(5) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  `updatedDate` timestamp NULL DEFAULT NULL,
  `active` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=active (on), Y=active (off), N=no active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `walkin_location`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique` (`locationName`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `walkin_location` (`id`, `capacity`, `locationName`, `locationCode`, `address`, `subDistinct`, `distinct`, `province`, `zipcode`, `phone`, `email`, `contact`, `updatedBy`, `updatedDate`, `active`) VALUES
(1, 1000, 'มหาวิทยาลัยเกษตรศาสตร์', 'KU', 'เลขที่ 50 ถนนงามวงศ์วาน', 'ลาดยาว', 'จตุจักร', 'กรุงเทพมหานคร', '10900', '0 2118 0100', 'psdntps@ku.ac.th', 'ณัฐพร', 'nattaporn.s@ku.th', '2023-04-03 19:03:03', 'A');


-- 
-- TABLE: walkin_room --
-- 
CREATE TABLE `walkin_room` (
  `id` int(11) NOT NULL,
  `room` varchar(100) NOT NULL,
  `building` varchar(100) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `examLocation` int(11) DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  `updatedDate` timestamp NULL DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `active` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=active (on), Y=active (off), N=no active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `walkin_room`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_room` (`building`,`room`),
  ADD KEY `fk_walkinLocation` (`examLocation`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `walkin_room`
  ADD CONSTRAINT `fk_walkinLocation` FOREIGN KEY (`examLocation`) REFERENCES `walkin_location` (`id`);

INSERT INTO `walkin_room` (`id`, `room`, `building`, `capacity`, `examLocation`, `updatedBy`, `updatedDate`, `remark`, `active`) VALUES
(1, 'ห้องจงรัก KU-LAM Hall – B1', 'ศูนย์เรียนรวม 1', 140, 1, 'nattaporn.s@ku.th', '2023-04-03 04:54:29', NULL, 'A');


-- 
-- TABLE: walkin_subject --
-- 
CREATE TABLE `walkin_subject` (
  `id` int(11) NOT NULL,
  `subjectCode` varchar(50) NOT NULL,
  `subjectName` varchar(255) DEFAULT NULL,
  `subjectNameEn` varchar(255) DEFAULT NULL,
  `credit` varchar(10) DEFAULT NULL,
  `customExamFee` int(11) DEFAULT 0 COMMENT 'ค่าสมัครสอบ (ราคาขาย)',
  `tester` int(11) NOT NULL DEFAULT 9999 COMMENT 'เปิดรับสูงสุด',
  `gapHour` int(11) NOT NULL DEFAULT 1,
  `rounds` varchar(10) NOT NULL DEFAULT '1,2,3,4',
  `remark` varchar(255) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL COMMENT 'custom ใช้กับ event',
  `updatedDate` timestamp NULL DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  `active` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=active (on), Y=active (off), N=no active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `walkin_subject`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_subject` (`subjectCode`) USING BTREE,
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `walkin_subject` (`id`, `subjectCode`, `subjectName`, `subjectNameEn`, `credit`, `customExamFee`, `tester`, `gapHour`, `rounds`, `remark`, `description`, `updatedDate`, `updatedBy`, `active`) VALUES
(1, '01355102-64', 'ภาษาอังกฤษในมหาวิทยาลัย', 'English for University Life', '3(3-0-6)', 0, 150, 2, '1,2', 'สอบ2ชม midterm & final', 'walkin', NULL, NULL, 'A');

-- 
-- TABLE: walkin_event --
-- 
CREATE TABLE `walkin_event` (
  `id` int(11) NOT NULL,
  `evnTitle` varchar(255) NOT NULL,
  `evnStartDate` date DEFAULT NULL,
  `evnEndDate` date DEFAULT NULL,
  `evnStartTime` time DEFAULT NULL,
  `evnEndTime` time DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `updatedDate` timestamp NULL DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  `active` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=active (on), Y=active (off), N=no active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `walkin_event`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_event` (`evnTitle`,`evnStartDate`,`evnEndDate`) USING BTREE,
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `walkin_event` (`id`, `evnTitle`, `evnStartDate`, `evnEndDate`, `evnStartTime`, `evnEndTime`, `description`, `remark`, `updatedDate`, `updatedBy`, `active`) VALUES
(1, 'สอบกลางภาค', '2024-05-11', '2024-05-12', '10:00:00', '12:00:00', NULL, NULL, NULL, NULL, 'A'),
(2, 'สอบไล่', '2024-06-01', '2024-06-02', '10:00:00', '12:00:00', NULL, NULL, NULL, NULL, 'A');


-- 
-- TABLE: walkin_a_evn2date --
-- 
CREATE TABLE `walkin_a_evn2date` (
  `id` int(11) NOT NULL,
  `evn_id` int(11) NOT NULL,
  `evn_date` date NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `active` varchar(1) DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `walkin_a_evn2date`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `walkin_a_evn2date` (`id`, `evn_id`, `evn_date`, `remark`, `active`) VALUES
(1, 1, '2024-05-11', NULL, 'A'),
(2, 1, '2024-05-12', NULL, 'A'),
(3, 2, '2024-06-01', NULL, 'A'),
(4, 2, '2024-06-02', NULL, 'A');


-- 
-- TABLE: walkin_time --
-- 
CREATE TABLE `walkin_time` (
  `id` int(11) NOT NULL,
  `gapTime` int(11) NOT NULL,
  `rangeTime` varchar(11) NOT NULL,
  `timeStart` time NOT NULL,
  `active` varchar(1) NOT NULL DEFAULT 'A',
  `updatedBy` varchar(50) DEFAULT NULL,
  `updatedDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `walkin_time`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_rangeTime` (`rangeTime`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `walkin_time` (`id`, `gapTime`, `rangeTime`, `timeStart`, `active`, `updatedBy`, `updatedDate`) VALUES
(1, 2, '10.00-12.00', '10:00:00', 'A', NULL, NULL);


-- 
-- TABLE: walkin_time_slot --  
-- 
CREATE TABLE `walkin_time_slot` (
  `id` int(11) NOT NULL,
  `timeBucket` time DEFAULT NULL,
  `unit` varchar(50) NOT NULL DEFAULT '30 min'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `walkin_time_slot`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `walkin_time_slot` (`id`, `timeBucket`, `unit`) VALUES
(1, '10:00:00', '2 hr');


-- 
-- TABLE: walkin_time_bucket --  //ตรงนี้เหมือนจะไม่ได้ใช้งาน
-- 
CREATE TABLE `walkin_time_bucket` (
  `id` int(11) NOT NULL,
  `date_id` int(11) DEFAULT NULL,
  `evn_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `qtyBucket` int(11) NOT NULL DEFAULT 0,
  `qtyBucket1` int(11) NOT NULL DEFAULT 0,
  `qtyBucket2` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `walkin_time_bucket`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `walkin_time_bucket` (`id`, `date_id`, `evn_id`, `slot_id`, `qtyBucket`, `qtyBucket1`, `qtyBucket2`) VALUES
(1, 1, 1, 1, 0, 0, 0),
(2, 2, 1, 1, 0, 0, 0),
(3, 3, 2, 1, 0, 0, 0),
(4, 4, 2, 1, 0, 0, 0);

-- 
-- TABLE: walkin_a_schedule --
-- 
CREATE TABLE `walkin_a_schedule` (
  `id` int(11) NOT NULL,
  `evn_id` int(11) NOT NULL,
  `dat_id` int(11) NOT NULL,
  `tim_id` int(11) NOT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  `updatedDate` timestamp NULL DEFAULT NULL,
  `active` varchar(1) NOT NULL DEFAULT 'A',
  `amount` int(11) NOT NULL DEFAULT 0,
  `isFull` int(11) NOT NULL DEFAULT 0 COMMENT '0=ยังไม่เต็ม, 1=เต็มแล้ว',
  `combine` varchar(50) DEFAULT NULL COMMENT 'กรณีมากกว่า1ชม ระบุรวม id',
  `bucket` varchar(50) DEFAULT NULL,
  `limited` int(11) NOT NULL DEFAULT 135,
  `gap` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `walkin_a_schedule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_schedule` (`evn_id`,`dat_id`,`tim_id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `walkin_a_schedule` (`id`, `evn_id`, `dat_id`, `tim_id`, `updatedBy`, `updatedDate`, `active`, `amount`, `isFull`, `combine`, `bucket`, `limited`, `gap`) VALUES
(1, 1, 1, 1, NULL, NULL, 'A', 0, 0, NULL, 1, 150, 2),
(2, 1, 2, 1, NULL, NULL, 'A', 0, 0, NULL, 2, 150, 2),
(3, 2, 3, 1, NULL, NULL, 'A', 0, 0, NULL, 3, 150, 2),
(4, 2, 4, 1, NULL, NULL, 'A', 0, 0, NULL, 4, 150, 2);


-- 
-- TABLE: walkin_transaction --
-- 
CREATE TABLE `walkin_transaction` (
  `id` int(1) NOT NULL,
  `mooc_id` int(11) DEFAULT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `isReserved` int(11) NOT NULL DEFAULT 1 COMMENT '0=ยกเลิก, 1=จอง, 0=online, 1=onsite ',
  `examSubject` int(11) DEFAULT NULL,
  `examStudent` int(11) DEFAULT NULL,
  `examEvnxloc` int(11) DEFAULT NULL,
  `fixPrice` int(11) DEFAULT NULL COMMENT 'ค่าสมัครสอบ (ราคาซื้อ)',
  `dateExam` date DEFAULT NULL,
  `timeExam` varchar(20) DEFAULT NULL,
  `rev` int(11) NOT NULL DEFAULT 0,
  `isPaid` int(11) NOT NULL DEFAULT 0 COMMENT '0=ยังไม่จ่าย, 1=จ่ายแล้ว',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=processing, 1=completed',
  `inv_no` varchar(10) DEFAULT NULL,
  `updatedDate` timestamp NULL DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  `active` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=active (on), Y=active (off), N=no active',
  `round` int(11) NOT NULL DEFAULT 0,
  `revisedDate` timestamp NULL DEFAULT NULL,
  `revisedBy` varchar(50) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `walkin_transaction`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;


-- 
-- TABLE: walkin_student --
-- 
CREATE TABLE `walkin_student` (
  `id` int(11) NOT NULL,
  `idCard` varchar(13) DEFAULT NULL COMMENT 'เลขบัตร ปชช',
  `idStudent` varchar(10) DEFAULT NULL COMMENT 'รหัสนิสิต',
  `pname` varchar(50) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `pname_en` varchar(50) DEFAULT NULL,
  `fname_en` varchar(100) DEFAULT NULL,
  `lname_en` varchar(100) DEFAULT NULL,
  `studentName` varchar(255) DEFAULT NULL,
  `profileName` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `faculty` varchar(105) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `imageCard` varchar(50) DEFAULT NULL,
  `updatedDate` timestamp NULL DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  `verificationCode` varchar(10) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=ยังไม่ยืนยัน, 1=ยืนยันแล้ว',
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `walkin_student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student` (`idStudent`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
-- ไม่ต้องใส่ user เข้าในระบบ ให้ user ล็อคอินเข้ามาแล้วมาเช็ครหัสนิสิต idStudent (กรอก) กับรายวิชาที่ ลทบ walkin_mooc
-- INSERT INTO `walkin_student` (`id`, `idCard`, `idStudent`, `pname`, `fname`, `lname`, `pname_en`, `fname_en`, `lname_en`, `studentName`, `profileName`, `email`, `faculty`, `mobile`, `image`, `imageCard`, `updatedDate`, `updatedBy`, `verificationCode`, `verified`, `remark`) VALUES
-- (1, NULL, '6610011001', 'นางสาว', 'ณัฐพร', 'แซ่คู', 'Miss', 'Nattaporn', 'Saekhoo', NULL, NULL, 'nattaporn.s@ku.th', 'สำนักบริหารการศึกษา', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'tester');


-- 
-- TABLE: walkin_mooc --
-- 
CREATE TABLE `walkin_mooc` (
  `id` int(11) NOT NULL,
  `idStudent` varchar(10) DEFAULT NULL,
  `idCard` varchar(13) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `startLearn` date DEFAULT NULL,
  `endLearn` date DEFAULT NULL,
  `subjectCode` varchar(50) NOT NULL,
  `subjectName` varchar(255) DEFAULT NULL,
  `subjectNameEn` varchar(255) DEFAULT NULL,
  `defaultExamFee` int(11) DEFAULT NULL COMMENT 'ค่าสมัครสอบ (ราคากลาง)',
  `learnStatus` int(11) NOT NULL DEFAULT 1 COMMENT '0=กำลังเรียน, 1=เรียนจบแล้ว',
  `description` varchar(50) DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  `updatedDate` timestamp NULL DEFAULT NULL,
  `active` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=active (on), Y=active (off), N=no active',
  `checkin1` timestamp NULL DEFAULT NULL,
  `checkin2` timestamp NULL DEFAULT NULL,
  `checkin3` timestamp NULL DEFAULT NULL,
  `checkin4` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `walkin_mooc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_mooc` (`subjectCode`,`idStudent`) USING BTREE,
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `walkin_mooc` (`id`, `idStudent`, `idCard`, `email`, `startLearn`, `endLearn`, `subjectCode`, `subjectName`, `subjectNameEn`, `defaultExamFee`, `learnStatus`, `description`, `updatedBy`, `updatedDate`, `active`, `checkin1`, `checkin2`, `checkin3`, `checkin4`) VALUES
(1, '6610011001', NULL, 'nattaporn.s@ku.th', NULL, NULL, '01355102-64', NULL, NULL, NULL, 1, NULL, NULL, NULL, 'A', NULL, NULL, NULL, NULL);



-- 
-- VIEW: walkin_view_transaction
-- 
CREATE VIEW walkin_view_transaction AS
SELECT 
  a.id AS moc_id, 
  a.subjectCode, 
  a.active,
  b.id AS sub_id, 
  b.subjectName, 
  b.subjectNameEn, 
  b.credit, 
  b.gapHour, 
  b.rounds , 
  b.tester,
  c.id AS tran_id,
  c.schedule_id,
  c.isReserved,
  CASE WHEN c.revisedDate IS NOT NULL THEN c.revisedDate ELSE c.updatedDate END AS updatedDate,
  d.evn_id,
  d.dat_id,
  e.evn_date,
  d.tim_id,
  f.rangeTime,
  f.gapTime,
  f.timeStart,
  d.amount,
  d.combine,
  d.bucket,
  d.limited,
  a.email,
  g.idStudent,
  g.pname,
  g.fname,
  g.lname,
  g.pname_en,
  g.fname_en,
  g.lname_en,
  g.mobile,
  g.remark as remark_student,
  g.verified
FROM walkin_mooc a 
LEFT JOIN walkin_subject b ON b.subjectCode=a.subjectCode AND b.active='A'
LEFT JOIN walkin_transaction c ON a.id=c.mooc_id AND c.active='A'
LEFT JOIN walkin_a_schedule d ON d.id=c.schedule_id AND d.active='A'
LEFT JOIN walkin_a_evn2date e ON e.id=d.dat_id 
LEFT JOIN walkin_time f ON f.id=d.tim_id
LEFT JOIN walkin_student g ON g.email=a.email
where a.active='A';


-- 
-- สร้าง view สำหรับนับจำนวน schedule_id,bucket,gapHour,cnt
-- 
  CREATE VIEW walkin_view_time_bucket_update AS
  SELECT
    schedule_id,
    bucket,
    gapTime,
    CAST(COUNT(*) AS SIGNED) AS cnt
  FROM walkin_view_transaction
  WHERE bucket IS NOT NULL
  GROUP BY schedule_id, bucket, gapTime
  ORDER BY gapTime, schedule_id;

-- กรณีดึงจากตาราง transaction โดยตรง ไม่ต้องดึงจาก view (ทำเผื่อไว้ อาจจะใช้แทน walkin_view_time_bucket_update)
SELECT 
     schedule_id,    
     round as gapTime, 
     CAST(COUNT(*) AS SIGNED) AS cnt 
FROM `walkin_transaction` 
WHERE active='A' 
GROUP BY schedule_id
ORDER BY round, schedule_id
