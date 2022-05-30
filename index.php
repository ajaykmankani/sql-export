<?php 

// Start session 
if(!session_id()) session_start(); 

    //ENTER THE RELEVANT INFO BELOW
    $mysqlUserName      = "root";
    $mysqlPassword      = "";
    $mysqlHostName      = "localhost";
    $mysqliName         = "test";
    $backup_name        = "mybackup.sql";
    $tables             = array();


    define('GOOGLE_CLIENT_ID', '120136095373-drl3g096q612buq3rd03d300180etfhd.apps.googleusercontent.com'); 
	define('GOOGLE_CLIENT_SECRET', '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'); 
	define('GOOGLE_OAUTH_SCOPE', 'https://www.googleapis.com/auth/drive'); 
	define('REDIRECT_URI', 'https://addurl.ink/ajay-developer/sql-export/google_drive_sync.php'); 
 

 
// Google OAuth URL 


   //or add 5th parameter(array) of specific tables:    array("mytable1","mytable2","mytable3") for multiple tables

    Export_Database($mysqlHostName,$mysqlUserName,$mysqlPassword,$mysqliName,  $tables=false, $backup_name=false );

    function Export_Database($host,$user,$pass,$name,  $tables=false, $backup_name=false )
    {
        $mysqli = new mysqli($host,$user,$pass,$name); 
        $mysqli->select_db($name); 
        $mysqli->query("SET NAMES 'utf8'");

        $queryTables    = $mysqli->query('SHOW TABLES'); 
        while($row = $queryTables->fetch_row()) 
        { 
            $target_tables[] = $row[0]; 
        }   
        if($tables !== false) 
        { 
            $target_tables = array_intersect( $target_tables, $tables); 
        }
        foreach($target_tables as $table)
        {
            $result         =   $mysqli->query('SELECT * FROM '.$table);  
            $fields_amount  =   $result->field_count;  
            $rows_num=$mysqli->affected_rows;     
            $res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
            $TableMLine     =   $res->fetch_row();
            $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = $result->fetch_row())  
                { //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    {
                            $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)  
                    { 
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                        if (isset($row[$j]))
                        {
                            $content .= '"'.$row[$j].'"' ; 
                        }
                        else 
                        {   
                            $content .= '""';
                        }     
                        if ($j<($fields_amount-1))
                        {
                                $content.= ',';
                        }      
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                    {   
                        $content .= ";";
                    } 
                    else 
                    {
                        $content .= ",";
                    } 
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        
        $backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";

        


        // $backup_name = $backup_name ? $backup_name : $name.".sql";

        // header('Content-Type: application/octet-stream');   
        // header("Content-Transfer-Encoding: Binary"); 
        // header("Content-disposition: attachment; filename=\"".$backup_name."\"");  


        $data = $content;
        $handle = fopen('db/'.$backup_name.'', 'w+');
        fwrite($handle, $data);
        fclose($handle);
        

        $sqlQ = "INSERT INTO drive_files (file_name,created) VALUES (?,NOW())"; 
            $stmt = $mysqli->prepare($sqlQ);
            $stmt->bind_param("s", $mysqli_file_name);
            $mysqli_file_name = $backup_name; 
            $insert = $stmt->execute(); 
            $googleOauthURL = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode(GOOGLE_OAUTH_SCOPE) . '&redirect_uri=' . REDIRECT_URI . '&response_type=code&client_id=' . GOOGLE_CLIENT_ID . '&access_type=online'; 


            if($insert){ 
                $file_id = $stmt->insert_id; 
                 
                // Store DB reference ID of file in SESSION 
                $_SESSION['last_file_id'] = $file_id; 
                 
                header("Location: $googleOauthURL"); 
                exit(); 
            }


            $_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg); 
 
            // 	header("Location: index.php"); 
                exit(); 
       
    }
?>

