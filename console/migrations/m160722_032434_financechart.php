<?php

use yii\db\Migration;

class m160722_032434_financechart extends Migration
{
    public function up()
    {
		$this->execute("
CREATE PROCEDURE `showFinanceChart`(IN iyear INT, IN imonth INT, IN imaxnum INT, IN itype VARCHAR(5))
BEGIN

DECLARE counter INT default 1;
DECLARE date_range_from VARCHAR(10);
DECLARE date_range_to VARCHAR(10);
DECLARE date_str VARCHAR(10);

IF itype = 'month' THEN
	CREATE TEMPORARY TABLE IF NOT EXISTS tmpDateForDay
	(
		occur_date DATE
	) ENGINE=MyISAM;
	TRUNCATE TABLE tmpDateForDay;
    
      WHILE counter <= imaxnum DO

		SET date_str = CONCAT(CAST(iyear as CHAR(4)), '-', CAST(imonth as CHAR(2)), '-', CAST(counter as CHAR(2)));
        INSERT INTO tmpDateForDay(occur_date) VALUES (date_str);
		SET counter = counter + 1;

	  END WHILE;
      
      
      SET date_range_from = CONCAT(CAST(iyear as CHAR(4)), '-', CAST(imonth as CHAR(2)), '-', CAST(1 as CHAR(2)));
      SET date_range_to = CONCAT(CAST(iyear as CHAR(4)), '-', CAST(imonth as CHAR(2)), '-', CAST(imaxnum as CHAR(2)));
      
      CREATE TEMPORARY TABLE IF NOT EXISTS tmpIncomingForDay
	(
		occur_date DATE,
        amount DECIMAL(9,2)
	) ENGINE=MyISAM;
	TRUNCATE TABLE tmpIncomingForDay;
    
    INSERT INTO tmpIncomingForDay (occur_date, amount)
    SELECT occur_date, sum(amount) FROM finance 
    WHERE occur_date >= date_range_from 
    AND occur_date <= date_range_to
    AND amount > 0
    GROUP BY occur_date;
    
    CREATE TEMPORARY TABLE IF NOT EXISTS tmpOutgoingForDay
	(
		occur_date DATE,
        amount DECIMAL(9,2)
	) ENGINE=MyISAM;
	TRUNCATE TABLE tmpOutgoingForDay;
    
	INSERT INTO tmpOutgoingForDay (occur_date, amount)
    SELECT occur_date, sum(amount) FROM finance 
    WHERE occur_date >= date_range_from 
    AND occur_date <= date_range_to
    AND amount < 0
    GROUP BY occur_date;
    
    CREATE TEMPORARY TABLE IF NOT EXISTS tmpFinanceForDay
	(
		occur_date DATE,
        amount DECIMAL(9,2)
	) ENGINE=MyISAM;
	TRUNCATE TABLE tmpFinanceForDay;
    
	INSERT INTO tmpFinanceForDay (occur_date, amount)
    SELECT occur_date, sum(amount) FROM finance 
    WHERE occur_date >= date_range_from 
    AND occur_date <= date_range_to
    GROUP BY occur_date;
    
    SELECT d.occur_date, ifnull(i.amount,0) as incoming, ifnull(o.amount,0) as outgoing, ifnull(f.amount,0) as finance
    FROM tmpDateForDay d
    LEFT JOIN tmpIncomingForDay i on d.occur_date = i.occur_date
    LEFT JOIN tmpOutgoingForDay o on d.occur_date = o.occur_date
    LEFT JOIN tmpFinanceForDay f on d.occur_date = f.occur_date
    ORDER BY d.occur_date;
      
ELSEIF itype = 'year' THEN
	CREATE TEMPORARY TABLE IF NOT EXISTS tmpDateForMonth
	(
		occur_date varchar(7)
	) ENGINE=MyISAM;
	TRUNCATE TABLE tmpDateForMonth;
    
      WHILE counter <= imaxnum DO

		SET date_str = CONCAT(CAST(iyear as CHAR(4)), '-', CAST(counter as CHAR(2)));
        INSERT INTO tmpDateForMonth(occur_date) VALUES (date_str);
		SET counter = counter + 1;

	  END WHILE;
      
      
      SET date_range_from = CONCAT(CAST(iyear as CHAR(4)), '-', CAST(1 as CHAR(2)));
      SET date_range_to = CONCAT(CAST(iyear as CHAR(4)), '-', CAST(imaxnum as CHAR(2)));
      
      CREATE TEMPORARY TABLE IF NOT EXISTS tmpIncomingForMonth
	(
		occur_date varchar(7),
        amount DECIMAL(9,2)
	) ENGINE=MyISAM;
	TRUNCATE TABLE tmpIncomingForMonth;
    
    INSERT INTO tmpIncomingForMonth (occur_date, amount)
    SELECT DATE_FORMAT(occur_date,'%Y-%c'), sum(amount) FROM finance 
    WHERE DATE_FORMAT(occur_date,'%Y-%c') >= date_range_from 
    AND DATE_FORMAT(occur_date,'%Y-%c') <= date_range_to
    AND amount > 0
    GROUP BY DATE_FORMAT(occur_date,'%Y-%c');
    
    CREATE TEMPORARY TABLE IF NOT EXISTS tmpOutgoingForMonth
	(
		occur_date varchar(7),
        amount DECIMAL(9,2)
	) ENGINE=MyISAM;
	TRUNCATE TABLE tmpOutgoingForMonth;
    
	INSERT INTO tmpOutgoingForMonth (occur_date, amount)
    SELECT DATE_FORMAT(occur_date,'%Y-%c'), sum(amount) FROM finance 
    WHERE DATE_FORMAT(occur_date,'%Y-%c') >= date_range_from 
    AND DATE_FORMAT(occur_date,'%Y-%c') <= date_range_to
    AND amount < 0
    GROUP BY DATE_FORMAT(occur_date,'%Y-%c');
    
    CREATE TEMPORARY TABLE IF NOT EXISTS tmpFinanceForMonth
	(
		occur_date varchar(7),
        amount DECIMAL(9,2)
	) ENGINE=MyISAM;
	TRUNCATE TABLE tmpFinanceForMonth;
    
	INSERT INTO tmpFinanceForMonth (occur_date, amount)
    SELECT DATE_FORMAT(occur_date,'%Y-%c'), sum(amount) FROM finance 
    WHERE DATE_FORMAT(occur_date,'%Y-%c') >= date_range_from 
    AND DATE_FORMAT(occur_date,'%Y-%c') <= date_range_to
    GROUP BY DATE_FORMAT(occur_date,'%Y-%c');
    
    SELECT d.occur_date, ifnull(i.amount,0) as incoming, ifnull(o.amount,0) as outgoing, ifnull(f.amount,0) as finance
    FROM tmpDateForMonth d
    LEFT JOIN tmpIncomingForMonth i on d.occur_date = i.occur_date
    LEFT JOIN tmpOutgoingForMonth o on d.occur_date = o.occur_date
    LEFT JOIN tmpFinanceForMonth f on d.occur_date = f.occur_date
    ORDER BY d.occur_date;
END IF;

END");
    }

    public function down()
    {
        $this->execute("DROP procedure IF EXISTS `showFinanceChart`");
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
