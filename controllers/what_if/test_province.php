<?php
  $sql = "SELECT GP.PROVINCE_CODE,GP.ZONE_DOPA,GP.PROVINCE_NAME ";
  $sql .= ",ROUND((((PEOPLE / TOTAL)* ".$_REQUEST['num'].") / ((GRADUATE / ATTEND) * 100)) * 100) AS ValTest ";
  $sql .= "FROM(SELECT MSC.PROVINCE_ID,SUM(MSC.MALE_QUANTITY + MSC.FEMALE_QUANTITY) AS PEOPLE ";
  $sql .= ",(SELECT SUM(MALE_QUANTITY + FEMALE_QUANTITY) ";
  $sql .= "FROM STAT_MOE_CITIZEN@L_STMOL ";
  $sql .= "WHERE ACADEMIC_YEAR = (SELECT MAX(ACADEMIC_YEAR) FROM STAT_MOE_CITIZEN@L_STMOL) ";
  $sql .= "AND AGE BETWEEN 15 AND 60) TOTAL ";
  $sql .= ",(SELECT COUNT(TDT.PERSONAL_ID) AS CATT FROM DB_MOL.TRT_DSD_TESTING TDT ";
  $sql .= "LEFT JOIN DB_MOL.LKU_DSD_TESTING_COURSE LDTC ";
  $sql .= "ON TDT.TESTING_ID = LDTC.TESTING_ID LEFT JOIN DB_MOL.LKU_DSD_DEPT LDD ON LDTC.DEPT_CODE = LDD.DEPT_ID ";
  $sql .= "LEFT JOIN DB_MOL.STD_TEST_COURSE STC ON LDTC.TEST_COURSE_CODE = STC.TEST_COURSE_CODE ";
  $sql .= "WHERE TDT.STATUS_ATTEND = '1' ";
  $sql .= "AND LDTC.TARGET_BUDGET_YEAR = '".$_REQUEST['year']."' ";
  $sql .= "AND STC.LAW_OCCUPATION_CODE = '".$_REQUEST['branch']."' ";
  $sql .= "AND LDTC.TEST_COURSE_CODE = '".$_REQUEST['occupation']."') ATTEND ";
  $sql .= ",(SELECT COUNT(TDT.PERSONAL_ID) AS CGRA FROM DB_MOL.TRT_DSD_TESTING TDT ";
  $sql .= "LEFT JOIN DB_MOL.LKU_DSD_TESTING_COURSE LDTC ON TDT.TESTING_ID = LDTC.TESTING_ID ";
  $sql .= "LEFT JOIN DB_MOL.LKU_DSD_DEPT LDD ON LDTC.DEPT_CODE = LDD.DEPT_ID LEFT JOIN DB_MOL.STD_TEST_COURSE STC ";
  $sql .= "ON LDTC.TEST_COURSE_CODE = STC.TEST_COURSE_CODE ";
  $sql .= "WHERE TDT.STATUS_GRADUATE = '1' ";
  $sql .= "AND LDTC.TARGET_BUDGET_YEAR = '".$_REQUEST['year']."' ";
  $sql .= "AND STC.LAW_OCCUPATION_CODE = '".$_REQUEST['branch']."' ";
  $sql .= "AND LDTC.TEST_COURSE_CODE = '".$_REQUEST['occupation']."') GRADUATE ";
  $sql .= "FROM STAT_MOE_CITIZEN@L_STMOL MSC ";
  $sql .= "WHERE MSC.ACADEMIC_YEAR = (SELECT MAX(ACADEMIC_YEAR) FROM STAT_MOE_CITIZEN@L_STMOL) ";
  $sql .= "AND MSC.AGE BETWEEN 15 AND 60 ";
  $sql .= "GROUP BY MSC.PROVINCE_ID) WhatIFTest ";
  $sql .= "RIGHT JOIN DB_MOL.GIS_PROVINCE GP ";
  $sql .= "ON WhatIFTest.PROVINCE_ID = GP.PROVINCE_CODE ";
  $sql .= "ORDER BY GP.PROVINCE_CODE ";
  echo $sql;

?>