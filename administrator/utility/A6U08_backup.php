<?php
	backup_database_tables('localhost','root','Pur1C1pt42012','sister', '*');

	// backup the db function
	function backup_database_tables($host,$user,$pass,$name,$tables)
	{
		$link 	= mysql_connect($host,$user,$pass);
		mysql_select_db($name,$link);
        $time	=date('d-m-y-H-i-s');
		
		//get all of the tables
		if($tables == '*')
		{
			$tables = array();
			$result = mysql_query('SHOW TABLES');
			while($row = mysql_fetch_row($result))
			{
				$tables[] = $row[0];
			}
		}
		else
		{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}

		//cycle through each table and format the data
		foreach($tables as $table)
		{
			$result = mysql_query('SELECT * FROM '.$table);
			$num_fields = mysql_num_fields($result);

			$return.= 'DROP TABLE '.$table.';';
			$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
			$return.= "\n\n".$row2[1].";\n\n";

			for ($i = 0; $i < $num_fields; $i++)
			{
				while($row = mysql_fetch_row($result))
				{
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++)
					{
						$row[$j] = addslashes($row[$j]);
						$row[$j] = ereg_replace("\n","\\n",$row[$j]);
						if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			}
			$return.="\n\n\n";
		}

		//save the file
		$handle = fopen('backup_dbsister('.($time).').sql','w+');
		fwrite($handle,$return);
		fclose($handle);
		echo"
		<br><center>Data Berhasil Disimpan....</center>";
	
		echo"
		<script type=text/javascript>	
			setTimeout('window.close();',3000);
		</script>";
	}
?>