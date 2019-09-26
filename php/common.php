

<?php
//session_start();
	
function render_timetable_for_resource($sched_act, $resource_name,
        $days, $intervals, $show, $js_function="")
{
    $scd = array();
    for ($i = 1; $i <=$days; $i++)
    {
        for ($j = 1; $j <=$intervals; $j++)
        {
            $scd["$i,$j"] = array();
        }
    }
    $resource_used = 0;
    foreach ($sched_act as $act)
    {
        if ($resource_name == $act['class']
            || $resource_name == $act['prof']
            || $resource_name == $act['room'])
        {
            $cell_content = array(
                    $act['class'],
                    $act['prof'],
                    $act['room'],
					$act['sub']
                    );
					
					//print_r($cell_content);
            $cell_content = array_diff($cell_content, array($resource_name));
            if (count($scd["{$act['day']},{$act['interval']}"]) != 0)
            {
                echo("Resource $resource_name ".
                        "must be in two places simultaneously!");
            }
            $scd["{$act['day']},{$act['interval']}"] 
                = array_values($cell_content);
            $resource_used = 1;
        }
    }
    $result = "";
    if (!$resource_used)
    {
        return $result;
    }
    $result .= "<div id=\"res_name_$resource_name\" style=\"display: $show\">";
    $result .= "<table border=\"solid\">";
    $result .= "<caption>Timetable for $resource_name</caption>";
    $result .= "<tr><th></th>";
    for ($i = 1; $i <= $days; $i++)
    {   if($i==1)
		$d='SUNDAY';
	    if($i==2)
		$d='MONDAY';
	   if($i==3)
		$d='TUESDAY';
	if($i==4)
		$d='WEDNESDAY';
	if($i==5)
		$d='THURSDAY';
	if($i==6)
		$d='FRIDAY';
        $result .= "<th>$d</th>";
    }
    $result .= "</tr>";
    for ($j =1; $j <= $intervals; $j++)
    {
        $result .= "<tr>";
		if($j==1)
			$t='10:15-11:05';
		if($j==2)
			$t='11:05-11:55';
		if($j==3)
			$t='11:55-12:45';
		if($j==4)
			$t='12:45-01:35';
		if($j==5)
			$t='01:35-02:25';
		if($j==6)
			$t='02:25-03:15';
		if($j==7)
			$t='03:15-04:05';
		if($j==8)
			$t='04:05-04:55';
        $result .= "<td>$t</td>";
        for ($i = 1; $i <= $days; $i++)
        {
            $result .= "<td id=\"tt_{$i}_{$j}\"";
            if ($js_function != "")
            {
               // echo " onclick=\"javascript:$js_function($i,$j)\"";
				
				$result .= " onclick=\"javascript:$js_function($i,$j)\"";
				//$result.= "style=\"background:#00FF00; \"";
            }
			
            $cell_content = $scd["$i,$j"];
			
			
			
			if(count($cell_content)>0)
			{
			if($cell_content[2]=='Communication System I[P]' || $cell_content[2]=='Embedded System[P]' || $cell_content[2]=='Digital Signal Processing[P]' 
			||  $cell_content[2]=='Basic Electronics Engineering[P]' || $cell_content[2]=='Instrumentation I[P]' || $cell_content[2]=='Internet & Intranet[P]')
			{
				$result.="style='color:red;'";
			}
			else
			{
				if(substr($cell_content[2],-3)=='[P]' || substr($cell_content[2],0,8)=='Elective')
			{
				$result.="style='color:blue;'";
			}
			}
			}
            $result .= " >";
            if (count($cell_content) != 0)
            {
				if($cell_content[0]!='0' && $cell_content[1]!='0')
				{
                $result .= "{$cell_content[0]} - {$cell_content[1]} - {$cell_content[2]}";
				}
				else
				{
					$result .= "{$cell_content[2]}";
				}
            }
            $result .= "</td>";
        }
        $result .= "</tr>";
    }
    $result .= "</table>";
    $result .= "</div>";
	
    return $result;
}

function read_scheduled_activities($tt_id, $conn)
{   
$sched_act = array();

    $sched_act = array();
     $query = "SELECT R1.NAME AS CLASS, R2.NAME AS PROF, " .
        "R3.NAME AS ROOM, R4.NAME AS SUB, SA.DAY, SA.INT_NO, " .
        "SA.CLASS_ID, SA.PROF_ID, SA.ROOM_ID,SA.SUB_ID, SA.ID " .
        "FROM SCHED_ACTIVITIES SA, RESOURCES R1, RESOURCES R2, RESOURCES R3, RESOURCES R4 ".
        "WHERE SA.TT_ID=$tt_id AND SA.CLASS_ID=R1.ID " . 
        "AND SA.PROF_ID=R2.ID AND SA.ROOM_ID=R3.ID AND SA.SUB_ID=R4.ID".
		" UNION ".
		"SELECT R1.NAME AS CLASS,SA.PROF_ID AS PROF,SA.ROOM_ID AS ROOM ," .
        "R4.NAME AS SUB, SA.DAY, SA.INT_NO, " .
        "SA.CLASS_ID, SA.PROF_ID, SA.ROOM_ID,SA.SUB_ID, SA.ID " .
        "FROM SCHED_ACTIVITIES SA, RESOURCES R1,RESOURCES R4 ".
        "WHERE SA.TT_ID=$tt_id AND SA.CLASS_ID=R1.ID " . 
        " AND SA.SUB_ID=R4.ID AND SA.PROF_ID=0 AND SA.ROOM_ID=0";
//    echo "<p>$query</p>";
    $result = mysqli_query($conn,$query)
        or die(mysqli_error($conn));
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $act = array();
		
        $act['id'] = $row['ID'];
        $act['class'] = $row['CLASS'];
        $act['prof'] = $row['PROF'];
        $act['room'] = $row['ROOM'];
		 $act['sub'] = $row['SUB'];
        $act['class_id'] = $row['CLASS_ID'];
        $act['prof_id'] = $row['PROF_ID'];
        $act['room_id'] = $row['ROOM_ID'];
		$act['sub_id']=$row['SUB_ID'];
        $act['day'] = $row['DAY'];
        $act['interval'] = $row['INT_NO'];
        $sched_act[] = $act;
		
    }
    return $sched_act;
	
}

function read_activities($tt_id, $conn)
{
    $query = "SELECT A.ID,A.TT_ID,A.CLASS_ID,A.PROF_ID,A.SUB_ID, A.TYPE,A.LENGTH FROM ACTIVITIES A,RESOURCES R	WHERE A.TT_ID=$tt_id AND A.SUB_ID=R.ID AND R.TYPE !='PRAC'";
    $result = mysqli_query($conn,$query)
        or die("Can't read activities!");
    $activities = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $act = array();
        $act['class'] = $row['CLASS_ID'];
        $act['prof'] = $row['PROF_ID'];
		$act['sub'] = $row['SUB_ID'];
        $act['type'] = $row['TYPE'];
		$act['length'] = $row['LENGTH'];
        $activities[$row['ID']] = $act;
    }
    return $activities;
}
function read_activities_prac($tt_id,$conn)
{
	$query = "SELECT * FROM PRACTICAL WHERE TT_ID=$tt_id";
    $result = mysqli_query($conn,$query)
        or die("Can't read activities!");
    $activities = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $act = array();
        $act['class'] = $row['CLASS_ID'];
        $act['prof1'] = $row['PROF1_ID'];
		$act['prof2'] = $row['PROF2_ID'];
		$act['prof3'] = $row['PROF3_ID'];
		$act['prac'] = $row['PRAC_ID'];
       // $act['type'] = $row['TYPE'];
		$act['length'] = $row['LENGTH'];
        $activities[$row['ID']] = $act;
    }
    return $activities;
}
function get_subject($tt_id,$conn,$act)
{   
	//$query="SELECT R.NAME AS NAME FROM PRACTICAL AS P,RESOURCES AS R WHERE P.TT_ID=$tt_id AND P.PRAC_ID=R.ID";
	$query= "SELECT NAME FROM RESOURCES WHERE TT_ID=$tt_id AND ID=$act";
	$result = mysqli_query($conn,$query)
        or die("Can't find the practical name of practical!");
     while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
		$name=$row['NAME'];
	}
	return $name;
}
function get_labid($tt_id,$conn,$name)
{
	 $query= "SELECT ID FROM RESOURCES WHERE TT_ID=$tt_id AND NAME='$name' ";
	$result = mysqli_query($conn,$query)
        or die("Can't find the practical name of practical!");
     while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
		$id=$row['ID'];
	}
	return $id;
}
function fix_avl($avl, $days, $intervals)
{
    if ($avl == '')
    {
        for ($i = 1; $i <= $days; $i++)
        {
            for ($j = 1; $j <= $intervals; $j++)
            {
                $avl .= "$i,$j;";
            }
        }
        $avl = rtrim($avl, ";");
    }
    if ($avl{0} == ':')
    {
        $avl = ltrim($avl, ":");
        $avl = rtrim($avl, ";");
    }
    return explode(";", $avl);
}

function read_resources($tt_id, $conn, $days, $intervals)
{
    $query = "SELECT * FROM RESOURCES WHERE TT_ID=$tt_id ORDER BY RESOURCES.TYPE ASC, RESOURCES.NAME ASC";
    $result = mysqli_query($conn,$query)
        or die("Can't read activities!");
    $resources = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $res = array();
        $res['type'] = $row['TYPE'];
        $res['name'] = $row['NAME'];
        $res['avl'] = fix_avl($row['AVL'], $days, $intervals);
        $res['size'] = $row['SIZE'];
        $resources[$row['ID']] = $res;
    }
    return $resources;
}


function read_timetable($tt_id, $conn)
{
    $query = "SELECT * FROM TIMETABLES WHERE ID=$tt_id";
    $result = mysqli_query($conn,$query)
        or die("Can't read timetable");
    //$resources = array();
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $timetable = array();
    $timetable['name'] = $row['NAME'];
    $timetable['days'] = $row['DAYS'];
    $timetable['intervals'] = $row['INTERVALS'];
    return $timetable;
}

function connect_to_db()
{
	
		$dbuser = 'root';
    $dbpass = '';
	
    $dbhost = 'localhost';
    
    $dbname = 'rgs';
    
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname)
        or die ('Error connecting to mysqli');
		/*if(!isset($_SESSION['signup'])){
			
		
       $user=$_SESSION['uname'];
$query1 = "SELECT * FROM users WHERE username='$user'";
    $select = mysqli_query($conn,$query1)
        or die("Can't read timetable!");
		 $row = mysqli_fetch_array($select, MYSQLI_ASSOC);
		 $dbuser=$row['user_status'];
		 $dbpass=$row['user_status'];
		 $dbname='sms';
		// echo $dbuser;
		   $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname)
        or die ('Error connecting to mysqli');
   // mysqli_select_db($dbname)
       // or die ('Error selecting database');
		}*/
    return $conn;
}

function dump_var($v)
{
    echo "<pre>";
    print_r($v);
    echo "</pre>";
}

function debug_dump()
{
    echo "<p>session contents</p>";
    dump_var($_SESSION);
}

function get_prac_resources($tt_id, $res_type, $selected_id)
{
    $query = "SELECT ID, NAME FROM RESOURCES ".
        "WHERE TT_ID = $tt_id AND TYPE = '$res_type'";
//    echo "<p>$query</p>";
      $conn=connect_to_db();
    $result = mysqli_query($conn,$query)
        or die("Can't read associated resources (type $res_type)");
    $res_options = "";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $selected = $selected_id == $row['ID'] ? ' selected' : '';
        $res_options .= "<option$selected>{$row['NAME']}</option>";
    }
    return $res_options;
}

function get_resource($tt_id, $res_type, $selected_id)
{
    $query = "SELECT ID, NAME FROM RESOURCES ".
        "WHERE TT_ID = $tt_id AND TYPE = '$res_type'";
//    echo "<p>$query</p>";
      $conn=connect_to_db();
    $result = mysqli_query($conn,$query)
        or die("Can't read associated resources (type $res_type)");
    $res_options = "";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $selected = $selected_id == $row['ID'] ? ' selected' : '';
        $res_options .= "<option$selected>{$row['NAME']}</option>";
    }
    return $res_options;
}


function get_defined_resources_by_type($tt_id, $conn, $type)
{
    $resources = "";
    $resources .= "\n<div id=\"{$type}_res\" style='margin-left:10px; margin-top:15px; font-style:italic; display:none;'>";
    $resources .= "<b>$type Resources</b><br>\n";
     $query = "SELECT * FROM RESOURCES ";
     $query .= "WHERE TT_ID=$tt_id AND TYPE='$type'";
     $query .= " ORDER BY NAME ASC";
//    $resources .= "<p>$query</p>";
    $result = mysqli_query($conn,$query)
        or die ("Can't get resources!");
    if (mysqli_num_rows($result) == 0)
    {
//        $resources = "<p>You have defined no $type resources!</p>";
        $resources .= "You have defined no $type resources!";
    }
    else
    {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $res_id = $row['ID'];
            $res_name = $row['NAME'];
            $res_type = $row['TYPE'];
            $res_size = $row['SIZE'];
            $resources .= "<a href=\"editres.php?id=$res_id\">";
            if ($res_type != 'PROF' && $res_type != 'SUB' && $res_type != 'PRAC')
            {
                $resources .= "<button style='background-color: rgb(106, 165, 205); color: white; text-decoration:none; padding:5px; margin-left:5px; margin-top:5px; border: none; border-radius: 5px; cursor: pointer;'>$res_name ($res_size)</button>";
            }
            else{
                $resources .= "<button style='background-color: rgb(106, 165, 205); color: white; text-decoration:none; padding:5px; margin-left:5px; margin-top:5px; border: none; border-radius: 5px; cursor: pointer;'>$res_name</button>";
            }
            $resources .= "</a>\n";
        }
    }
    $resources .= "</div>\n";
    return $resources;
}

function get_defined_resources($tt_id, $conn)
{
    $result = "<div style='border-left: solid #aaa; padding-left:5px; margin:5px;'>";
    $result .= "<b style='font-size:21px'>Resources : </b> ";
    $result .= "<a id=\"show_lnk\" ";
    $result .= "href=\"javascript:show_res('block')\" style='background-color: rgb(66, 125, 165); color: white; text-decoration:none; padding:5px; margin-left:5px; border: none; border-radius: 5px; cursor: pointer;'> show </a> ";
    $result .= "<a href=\"newresource.php\" style='background-color: rgb(66, 125, 165); color: white; text-decoration:none; padding:5px; margin-left:5px; border: none; border-radius: 5px; cursor: pointer;'> new </a>";
    $result .= get_defined_resources_by_type($tt_id, $conn, "CLASS");
	$result .= get_defined_resources_by_type($tt_id, $conn, "PRAC");
    $result .= get_defined_resources_by_type($tt_id, $conn, "PROF");
    $result .= get_defined_resources_by_type($tt_id, $conn, "ROOM");
	$result .= get_defined_resources_by_type($tt_id, $conn, "SUB");
    $result .= "<br></div>";
	
	//echo $result;
    return $result;
}

function get_defined_activities_by_cat($tt_id, $conn, $cat)
{
    if ($cat == 'prof')
    {
        $sort = "PROF_NAME";
    }
    else if($cat == 'class')
    {
        $sort = "CLASS_NAME";
    }
	else {
		$sort = "SUB_NAME";
	}
	
	
    $query = "SELECT A.ID AS ID, R1.NAME AS CLASS_NAME, R2.NAME AS PROF_NAME, R3.NAME AS SUB_NAME " .
             "FROM ACTIVITIES A, RESOURCES R1, RESOURCES R2,RESOURCES R3 " .
             "WHERE A.TT_ID=$tt_id AND A.CLASS_ID=R1.ID AND A.PROF_ID=R2.ID AND A.SUB_ID=R3.ID " .
             "ORDER BY $sort";
    $result = mysqli_query($conn,$query)
        or die ("Can't get activities!");
	
    $activities = "";
    $activities .= "<b style='font-size:20px'>Activities by $cat : </b>\n";
    $activities .= "<a href=\"javascript:show_activity('block','$cat')\" style='background-color: rgb(66, 125, 165); color: white; text-decoration:none; padding:5px; margin-left:5px; border: none; border-radius: 5px; cursor: pointer;'" .
        "id=\"show_lnk_act_$cat\"> show </a>\n";
    $activities .= "<a href=\"newactivity.php\" style='background-color: rgb(66, 125, 165); color: white; text-decoration:none; padding:5px; margin-left:5px; border: none; border-radius: 5px; cursor: pointer;'> new </a>\n";
    $activities .= "<div id=\"act_$cat\" style=\"display:none\"><div style='margin-left:10px;'>";
    if (mysqli_num_rows($result) == 0)
    {
        $activities .= "<p>You have defined no activities!</p>\n";
    }
    else
    {
        $crt_cat = "";
        if ($cat == 'prof')
        {
            $catvar = 'prof_name';
        }
        else if($cat == 'class')
        {
            $catvar = 'class_name';
        }
		else {
			$catvar='sub_name';
		}
		
		
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $act_id = $row['ID'];
            $class_name = $row['CLASS_NAME'];
            $prof_name = $row['PROF_NAME'];
			$sub_name = $row['SUB_NAME'];
            if ($crt_cat != $$catvar)
            {
                $crt_cat = $$catvar;
                $activities .= "<div style=\"margin-top:20px; font-weight:bold\"><i>$crt_cat</i></div>\n";
            }
            $activities .= "<a href=\"newactivity.php?edit=$act_id\">";
            $activities .= "<button style='background-color: rgb(106, 165, 205); color: white; text-decoration:none; padding:5px; margin-left:5px; margin-top:5px; border: none; border-radius: 5px; cursor: pointer;'>$class_name - $prof_name - $sub_name</button></a>\n";
        }
		
    }
    $activities .= "</div></div><br>\n";
    return $activities;
}


function get_defined_pracs($tt_id, $conn, $cat)
{
            $sort = "PRAC_NAME";
    
	
    $query = "SELECT P.ID AS ID, R1.NAME AS CLASS_NAME, R2.NAME AS PROF1_NAME, R3.NAME AS PROF2_NAME,R4.NAME AS PROF3_NAME,R5.NAME AS PRAC_NAME " .
             "FROM PRACTICAL P, RESOURCES R1, RESOURCES R2,RESOURCES R3,RESOURCES R4,RESOURCES R5 " .
             "WHERE P.TT_ID=$tt_id AND P.CLASS_ID=R1.ID AND P.PROF1_ID=R2.ID AND P.PROF2_ID=R3.ID AND P.PROF3_ID=R4.ID AND P.PRAC_ID=R5.ID " ."UNION ".
			 "SELECT P.ID AS ID, R1.NAME AS CLASS_NAME, P.PROF1_ID AS PROF1_NAME, P.PROF2_ID AS PROF2_NAME,P.PROF3_ID AS PROF3_NAME,R5.NAME AS PRAC_NAME " .
             "FROM PRACTICAL P, RESOURCES R1,RESOURCES R5 " .
             "WHERE P.TT_ID=$tt_id AND P.CLASS_ID=R1.ID AND P.PROF1_ID=0 AND PROF2_ID=0 AND PROF3_ID=0 AND  P.PRAC_ID=R5.ID " .
             "ORDER BY $sort";
    $result = mysqli_query($conn,$query)
        or die ("Can't get activities!");
	
    $activities = "";
    $activities .= "<b style='font-size:20px'>Activities by $cat : </b>\n";
    $activities .= "<a href=\"javascript:show_activity('block','$cat')\"  style='background-color: rgb(66, 125, 165); color: white; text-decoration:none; padding:5px; margin-left:5px; border: none; border-radius: 5px; cursor: pointer;'" .
        "id=\"show_lnk_act_$cat\"> show </a>\n";
    $activities .= "<a href=\"newactivity.php\" style='background-color: rgb(66, 125, 165); color: white; text-decoration:none; padding:5px; margin-left:5px; border: none; border-radius: 5px; cursor: pointer;'> new </a>\n";
    $activities .= "<div id=\"act_$cat\" style=\"display:none;\"><div style='margin-left:10px;'>";
    if (mysqli_num_rows($result) == 0)
    {
        $activities .= "<p>You have defined no activities!</p>\n";
    }
    else
    {
        $crt_cat = "";
        $catvar = 'prac_name';
		
		
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $act_id = $row['ID'];
            $class_name = $row['CLASS_NAME'];
			$prac_name = $row['PRAC_NAME'];
			if( $row['PROF1_NAME']!='0' &&  $row['PROF2_NAME']!='0' &&  $row['PROF3_NAME']!='0'){
            $prof1_name = $row['PROF1_NAME'];
			$prof2_name = $row['PROF2_NAME'];
			$prof3_name = $row['PROF3_NAME'];
			
			}
			else
			{
				$prof1_name='';
				$prof2_name='';
				$prof3_name='';
			}
            if ($crt_cat != $$catvar)
            {
                $crt_cat = $$catvar;
                $activities .= "<div style=\"margin-top:20px; font-weight:bold\"><i>$crt_cat</i></div>\n";
            }
			
            $activities .= "<a href=\"newactivity.php?editp=$act_id\">";
            $activities .= "<button style='background-color: rgb(106, 165, 205); color: white; text-decoration:none; padding:5px; margin-left:5px; margin-top:5px; border: none; border-radius: 5px; cursor: pointer;'>$class_name - $prof1_name,$prof2_name,$prof3_name - $prac_name</button></a>\n";
        }
		
    }
    $activities .= "</div></div><br>\n";
    return $activities;
}

function get_defined_activities($tt_id, $conn)
{
    $activities = "";
    $activities .= "<div style='border-left: solid #aaa; padding-left:5px; margin:5px; margin-top:10px;'>";
    $activities .= get_defined_activities_by_cat($tt_id, $conn, 'class');
    $activities .= "</div>";
    
    $activities .= "<div style='border-left: solid #aaa; padding-left:5px; margin:5px; margin-top:10px;'>";
	$activities .= get_defined_pracs($tt_id, $conn, 'prac');
    $activities .= "</div>";

    $activities .= "<div style='border-left: solid #aaa; padding-left:5px; margin:5px; margin-top:10px;'>";
    $activities .= get_defined_activities_by_cat($tt_id, $conn, 'prof');
    $activities .= "</div>";

    $activities .= "<div style='border-left: solid #aaa; padding-left:5px; margin:5px; margin-top:10px;'>";
	$activities .= get_defined_activities_by_cat($tt_id, $conn, 'sub');
    $activities .= "</div>";
    
    return $activities;
}

function echop($arg)
{
    echo "<p>$arg</p>";
}

?>
