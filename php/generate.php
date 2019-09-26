<?php session_start(); ?>

<?php
include_once("common.php");
// each room is assigned to $room_avl[i,j][]=room_id
global $expansion;
$expansion=1;
 $num=2;
//$res=array();

function calc_room_availability($resources, $timetable)
{
    $days = $timetable['days'];
    $intervals = $timetable['intervals'];
    $room_avl = array();
    for ($i = 1; $i <= $days; $i++)
    {
        for ($j = 1; $j <= $intervals; $j++)
        {
            $room_avl["$i,$j"] = array();
        }
    }
    foreach($resources as $k => $v)
    {
        if ($v['type'] == 'ROOM' && substr($v['name'],0,3)!='LAB')
        {
            foreach ($v['avl'] as $interval)
            {
				
			    $room_avl[$interval][] = $k;
			  
            }
        }
    }
	
    return $room_avl;
}

function calc_room_availability_prac($resources, $timetable)
{
	
    $days = $timetable['days'];
    $intervals = $timetable['intervals'];
    $room_avl = array();
    for ($i = 1; $i <= $days; $i++)
    {
        for ($j = 1; $j <= $intervals; $j++)
        {
            $room_avl["$i,$j"] = array();
        }
    }
    foreach($resources as $k => $v)
    {
        if ($v['type'] == 'ROOM' && substr($v['name'],0,3)=='LAB')
        {
            foreach ($v['avl'] as $interval)
            {
				
			    $room_avl[$interval][] = $k;
			  
            }
        }
    }
	
    return $room_avl;
}

//compares pressure
function cmp_pressure($v1, $v2)
{
    if ($v1['pressure'] == $v2['pressure'])
    {
        return 0;
    }
    elseif ($v1['pressure'] < $v2['pressure'])
    {
        return 1;
    }
    elseif ($v1['pressure'] > $v2['pressure'])
    {
        return -1;
    }
}
//finds common availability of professor and class by array_intersect() of availability (only from activities table)
function common_availability($activity, $resources) 
{    
    $class_avl = $resources[$activity['class']]['avl'];
	
     $prof_avl = $resources[$activity['prof']]['avl'];
     $avl = array_intersect($class_avl,$prof_avl);
     return $avl;

}


function common_availability_prac($tt_id,$conn,$activity, $resources) 
{    if($activity['prof1']==0 || $activity['prof2']==0 || $activity['prof3']==0)
   {
	   $prac_avl=$resources[$activity['prac']]['avl'];
	   $class_avl=$resources[$activity['class']]['avl'];
	   $avl = array_intersect($class_avl,$prac_avl);
	return $avl;
	
   }
   
   
    
    $class_avl = $resources[$activity['class']]['avl'];
	
     $prof1_avl = $resources[$activity['prof1']]['avl'];
	 
	 $prof2_avl = $resources[$activity['prof2']]['avl'];
	  $prof3_avl = $resources[$activity['prof3']]['avl'];
	  
	 if(!is_array($class_avl))
	 {
		 $class_avl=array($class_avl);
	 }
	 if(!is_array($prof1_avl))
	 {
		 $prof1_avl=array($prof1_avl);
	 }
	 if(!is_array($prof2_avl))
	 {
		 $prof2_avl=array($prof2_avl);
	 }
	 if(!is_array($prof3_avl))
	 {
		 $prof3_avl=array($prof3_avl);
	 }
	 
     $avl = array_intersect($class_avl,$prof1_avl);
	 $avl = array_intersect($avl,$prof2_avl);
	 $avl = array_intersect($avl,$prof3_avl);
	 
	 
	 
	 $practical_name=get_subject($tt_id,$conn,$activity['prac']);
   if($practical_name=='Communication System I[P]')
   {
	   $teacher1_avl=array();
	   $teacher2_avl=array();
	   $teacher3_avl=array();
	   $signal_analysis_id=get_labid($tt_id,$conn,'Signal Analysis[P]');
	   $teacher1_id=get_labid($tt_id,$conn,'Dr. DRP');
	   $teacher2_id=get_labid($tt_id,$conn,'Dr. SRB');
	   $teacher3_id=get_labid($tt_id,$conn,'AK');
	   
	   
     $teacher1_avl = $resources[$teacher1_id]['avl'];
	 $teacher2_avl = $resources[$teacher2_id]['avl'];
	 $teacher3_avl = $resources[$teacher3_id]['avl'];
	  
	 
	 $avll = array_intersect($teacher1_avl,$teacher2_avl);
	  $avll = array_intersect($avll,$teacher3_avl);
	  $avl=array_intersect($avl,$avll);
   }
   
      if($practical_name=='Digital Signal Processing[P]')
   {
	   $teacher1_avl=array();
	   $teacher2_avl=array();
	   $teacher3_avl=array();
	   $signal_analysis_id=get_labid($tt_id,$conn,'RF & Microwave Engineering[P]');
	   $teacher1_id=get_labid($tt_id,$conn,'Dr. NBA');
	   $teacher2_id=get_labid($tt_id,$conn,'DBK');
	   $teacher3_id=get_labid($tt_id,$conn,'KN');
	   
	   
     $teacher1_avl = $resources[$teacher1_id]['avl'];
	 $teacher2_avl = $resources[$teacher2_id]['avl'];
	 $teacher3_avl = $resources[$teacher3_id]['avl'];
	  
	 
	 $avll = array_intersect($teacher1_avl,$teacher2_avl);
	  $avll = array_intersect($avll,$teacher3_avl);
	  $avl=array_intersect($avl,$avll);
   }
   
   
   if($practical_name=='Internet & Intranet[P]')
   {
	   $teacher1_avl=array();
	   $teacher2_avl=array();
	   $teacher3_avl=array();
	   $signal_analysis_id=get_labid($tt_id,$conn,'Information System[P]');
	   $teacher1_id=get_labid($tt_id,$conn,'RB');
	   $teacher2_id=get_labid($tt_id,$conn,'AP');
	   $teacher3_id=get_labid($tt_id,$conn,'BRP');
	   
	   
     $teacher1_avl = $resources[$teacher1_id]['avl'];
	 $teacher2_avl = $resources[$teacher2_id]['avl'];
	 $teacher3_avl = $resources[$teacher3_id]['avl'];
	  
	 
	 $avll = array_intersect($teacher1_avl,$teacher2_avl);
	  $avll = array_intersect($avll,$teacher3_avl);
	  $avl=array_intersect($avl,$avll);
   }
   
    if($practical_name=='Embedded System[P]')
   {
	   $teacher1_avl=array();
	   $teacher2_avl=array();
	   $teacher3_avl=array();
	   $class_name=get_subject($tt_id,$conn,$activity['class']);
	   if($class_name=='BEX3')
	   {
	   $prop_antenna_id=get_labid($tt_id,$conn,'Propagation Antenna[P]');
	   $teacher1_id=get_labid($tt_id,$conn,'Dr. RKM');
	   $teacher2_id=get_labid($tt_id,$conn,'BP');
	   $teacher3_id=get_labid($tt_id,$conn,'KN');
	  
	   }
	   else
	   {
		   $os_id=get_labid($tt_id,$conn,'Operating System[P]');
	   $teacher1_id=get_labid($tt_id,$conn,'AV');
	   $teacher2_id=get_labid($tt_id,$conn,'RB');
	   $teacher3_id=get_labid($tt_id,$conn,'BRP');
	   
	   }
     $teacher1_avl = $resources[$teacher1_id]['avl'];
	 $teacher2_avl = $resources[$teacher2_id]['avl'];
	 $teacher3_avl = $resources[$teacher3_id]['avl'];
	  
	 
	 $avll = array_intersect($teacher1_avl,$teacher2_avl);
	 $avll = array_intersect($avll,$teacher3_avl);
	  
	  $avl=array_intersect($avl,$avll);
   }
     return $avl;

}
// assigns pressure to each activity by dividing the number of common_availability function returned value from 1000 then calls uasort() and returns activities
function sort_by_pressure($activities, $resources)
{
    foreach ($activities as $k => $v)
    {  
	    
        $avl = common_availability($v, $resources);
		//echo count($avl);
        $pressure = 1000.0 / count($avl);
		//echo $pressure;
        $activities[$k]['pressure'] = $pressure;
		
		
    }
	
	
    uasort($activities, 'cmp_pressure'); //sorts the activities based upon the pressure assigned in descending order
	
    return $activities;
}

function sort_by_pressure_prac($tt_id,$conn,$activities, $resources)
{
    foreach ($activities as $k => $v)
    {
        $avl = common_availability_prac($tt_id,$conn,$v, $resources);
		//echo count($avl);
        $pressure = 1000.0 / count($avl);
		//echo $pressure;
        $activities[$k]['pressure'] = $pressure;
		
		
    }
	
	
    uasort($activities, 'cmp_pressure'); //sorts the activities based upon the pressure assigned in descending order
	
    return $activities;
}
// assigns room for common available activitiea and makes an array variants containing interval with room i.e. all possible rooms for common prof and class availability
function get_all_variants($room_avl, $avl)
{
    $variants = array();
    foreach($avl as $interval)
    {
        $rooms = $room_avl[$interval];
        if (count($rooms) > 0)
        {
            foreach ($rooms as $room)
            {
                $variants[] = array($interval, $room);
            }
        }
    }
    return $variants;
}

function is_adjacent($i1,$i2){
	 $i1=explode(',',$i1,2);
	$i2=explode(',',$i2,2);
	
	if($i1[0]==$i2[0]){
		if($i1[1]<$i2[1]){
			$a=$i1[1];
			$b=$i2[1];
		}
		else if($i1[1]>$i2[1]){
			$a=$i2[1];
			$b=$i1[1];
		}
		else{
			return 0;
		}
		$a++;
		if($a==$b){
			return 1;
		}
		else{
			return 0;
		}
	}
	else{
		return 0;
	}
}
//initialize professor and class timetables setting all intervals to 0
function init_score_timetables(&$prof_timetable, &$class_timetable,
        $resources, $days, $intervals)
{
    $prof_timetable = array();
    $class_timetable = array();
	

    foreach($resources as $k => $resource)
    {
        if ($resource['type'] == 'PROF')
        {
            $prof_timetable[$k] = array();
            for ($i = 1; $i <= $days; $i++)
            {
                for ($j = 1; $j <= $intervals; $j++)
                {
                    $prof_timetable[$k]["$i,$j"] = 0;
                }
            }
        }
        else if ($resource['type'] == 'CLASS')
        {
            $class_timetable[$k] = array();
            for ($i = 1; $i <= $days; $i++)
            {
                for ($j = 1; $j <= $intervals; $j++)
                {
                    $class_timetable[$k]["$i,$j"] = 0;
                }
            }
        }
    }
}
function init_score_timetables_prac(&$prof_timetable, &$class_timetable,
        $resources, $days, $intervals)
{
    $prof_timetable = $_SESSION['prof_timetable'];
    $class_timetable = $_SESSION['class_timetable'];
	

    foreach($resources as $k => $resource)
    {
        if ($resource['type'] == 'PROF')
        {
            $prof_timetable[$k] = array();
            for ($i = 1; $i <= $days; $i++)
            {
                for ($j = 1; $j <= $intervals; $j++)
                {
                    $prof_timetable[$k]["$i,$j"] = 0;
                }
            }
        }
        else if ($resource['type'] == 'CLASS')
        {
            $class_timetable[$k] = array();
            for ($i = 1; $i <= $days; $i++)
            {
                for ($j = 1; $j <= $intervals; $j++)
                {
                    $class_timetable[$k]["$i,$j"] = 0;
                }
            }
        }
    }
}

function get_variant_score($variant, &$ptt, &$ctt, $days, $intervals)
{
    $ptt[$variant] = 1;
    $ctt[$variant] = 1;
	//print_r($ptt);
	//print_r($ctt);
    $score = 0;
	//echo $variant;
	//echo "<br/><br />";
    $prof_busy = array();
    $class_busy = array();
    for ($i = 1; $i <= $days; $i++)
    {
        $prof_windows = 0;
        $class_windows = 0;
        $prof_win_increment = 0;
        $class_win_increment = 0;
        $prof_has_window=0;
        $class_has_window=0;
        $pb = 0;
        $cb = 0;
        for ($j = 1; $j <= $intervals; $j++)
        {
            $pij = $ptt["$i,$j"];
            $cij = $ctt["$i,$j"];
            if ($pij == 1)
            {
                $pb ++;
            }
            if ($cij == 1)
            {
                $cb ++;
            }

            if ($pij == 1 && $prof_has_window == 0)
            {
                $prof_has_window = 1;
            }
            else if ($pij == 0 && 
                    ($prof_has_window == 1 || $prof_has_window == 2))
            {
                $prof_win_increment ++;
                $prof_has_window = 2;
            }
            else if ($pij == 1 && $prof_has_window == 2)
            {
                $prof_has_window = 1;
                $prof_windows += $prof_win_increment;
                $prof_win_increment = 0;
            }

            if ($cij == 1 && $class_has_window == 0)
            {
                $class_has_window = 1;
            }
            else if ($cij == 0 && 
                    ($class_has_window == 1 || $class_has_window == 2))
            {
                $class_win_increment ++;
                $class_has_window = 2;
            }
            else if ($cij == 1 && $class_has_window == 2)
            {
                $class_has_window = 1;
                $class_windows += $class_win_increment;
                $class_win_increment = 0;
            }
			
			//echo "pij=".$pij;
			//echo "prof_has_window=".$prof_has_window;
			//echo "prof_windows=".$prof_windows."<br />";
        }
        $prof_busy[] = $pb;
        $class_busy[] = $cb;
		
			
         $score -= $prof_windows * 20;
		// echo "Score init before class=".$score;
          $score -= $class_windows * 60;
		//echo "Score init after class=".$score;
    }
    for ($i = 1; $i < $days; $i++)
    {  // echo "pb=".$pb;
         //echo "cb=".$cb;
          $pb = abs($prof_busy[$i] - $prof_busy[$i-1]);
         $score -= ($pb - 1) * 2;
		// echo "score prof=".$score;
         $cd = abs($class_busy[$i] - $class_busy[$i-1]);
         $score -= ($cd - 1) * 4;
		//echo "score last=".$score;
    }
    $ptt[$variant] = 0;
    $ctt[$variant] = 0;
	

    return $score;
}

function best_variant(&$variants, $activity,
        &$prof_timetable, &$class_timetable,
        $days, $intervals)
{
    $ptt = $prof_timetable[$activity['prof']];
	
    $ctt = $class_timetable[$activity['class']];
	
    $best_score = null;
    $best_variant = array();
    foreach ($variants as $variant)
    {
        $score = get_variant_score($variant, $ptt, $ctt, $days, $intervals);
		//echo "Score=".$score.","."best_score=".$best_score."<br />";
        if ($best_score == null || $score > $best_score)
        {
            $best_score = $score;
            $best_variant = array();
            $best_variant[] = $variant;
        }
        else if ($best_score == $score)
        {
            $best_variant[] = $variant;
        }
    }
	$temp=array();
	for($i=0;$i<count($best_variant);$i++){
		foreach($variants as $variant){
			if(is_adjacent($best_variant[$i],$variant) && !in_array($variant,$best_variant)){
				$best_variant[]=$variant;
				$temp[]=$variant;
			}
		}
	}
	//dump_var($best_variant);
	
    /////////////////
		if($activity['length']>1){
			$len=$activity['length'];
			
			$len--;
			$max=count($best_variant)-1;
			//$tot=0;
			//$t=0;
			
				for($i=0;$i<count($best_variant);$i++){
					
					$best=array();
                    					$t=0;
					$best[]=$best_variant[$i+$t];

					for($j=0;$j<count($best_variant);$j++){
						if(is_adjacent($best_variant[$i+$t],$best_variant[$j])){
							$t++;
							$best[]=$best_variant[$j];
							//dump_var($best);
							$len--;
							
							if($len==0){
								
								//dump_var($best);
								
								return $best;
							}
						}
					}
				}
				
			//echo "Some of the multi-interval activities got splitted.";
					$best=array();	
			//for($i=0;$i<$activity['length'];$i++){
				
				//$best[]=$variants[$i];
			//}
			
			foreach($variants as $variant){
				$best[]=$variant;
				//echo "count=".count($best);
				if(count($best)==$activity['length']){
					//echo "break";
					break;
				}
			}
			//dump_var($best);
			return $best;
			
		}
    return $best_variant[mt_rand(0, count($best_variant)-1)];
}

function best_variant_prac(&$variants, $activity,
        &$prof_timetable, &$class_timetable,
        $days, $intervals)
		{
			
			$len=2;
    for($i=0;$i<count($variants);$i++){
					
					$best=array();
                    					$t=0;
					$best[]=$variants[$i+$t];

					for($j=0;$j<count($variants);$j++){
						if(is_adjacent($variants[$i+$t],$variants[$j])){
							$t++;
							$best[]=$variants[$j];
							//dump_var($best);
							$len--;
							
							if($len==0){
								
								//dump_var($best);
								
								return $best;
							}
						}
					}
				}
				die("Could not find adjacent intervals for practical of length 3");
		}
function generate_timetable($activities, $resources, $room_avl,
        $days, $intervals,$prof_timetable,$class_timetable,$partial_acts)
{
    //init_score_timetables($prof_timetable, $class_timetable,
    //    $resources, $days, $intervals);
	
   $sched_acts = $partial_acts;
    foreach ($activities as $k => $v)
    {
        $room = "";
        $avl = common_availability($v, $resources);
		
		$avl=array_values($avl);
        $variants = validate_avl_by_room($room_avl, $avl);
		
        if (count($variants) > 0)
        {   
	         $big_interval=array();
			 $expansion=$v['length'];
			if($expansion==1){
			        $variant =
                best_variant($variants, $v,
                        $prof_timetable, $class_timetable,
                        $days, $intervals);
						//echo $variant;
						 $rooms =& $room_avl[$variant];
			
            $room = $rooms[0];
			
            $class = $v['class'];
            $prof = $v['prof'];
            $prof_timetable[$prof][$variant] = 1;
            $class_timetable[$class][$variant] = 1;
			
            $rooms = array_slice($rooms, 1);
			
            $resources[$class]['avl'] =
                array_diff($resources[$class]['avl'], array($variant));
            $resources[$prof]['avl'] =
                array_diff($resources[$prof]['avl'], array($variant));
            $act = array(
                'class' => $v['class'],
                'prof' => $v['prof'],
                'room' => $room,
				'sub' => $v['sub'],
                'interval' => $variant
                );
            $sched_acts[] = $act;
			}
			else {
				$big_interval=best_variant($variants, $v,
                        $prof_timetable, $class_timetable,
                        $days, $intervals);
				//	dump_var($big_interval);
				
                if(isset($big_interval)){				
				foreach($big_interval as $vt){
					//echo $big_interval[$f];
				$rooms =& $room_avl[$vt];
				
				 $room = $rooms[0];
				 //$room_avl[2];
			//echo count($rooms);
            $class = $v['class'];
            $prof = $v['prof'];
			$sub=$v['sub'];
            $prof_timetable[$prof][$vt] = 1;
            $class_timetable[$class][$vt] = 1;
			//print_r($rooms);
			
            $rooms = array_slice($rooms, 1);
			//print_r($rooms);
			//$variant=array_diff(array($big_interval[$f]);
            $resources[$class]['avl'] =
                array_diff($resources[$class]['avl'],array($vt));
            $resources[$prof]['avl'] =
                array_diff($resources[$prof]['avl'], array($vt));
            $act = array(
                'class' => $v['class'],
                'prof' => $v['prof'],
                'room' => $room,
				'sub' => $v['sub'],
                'interval' => $vt
                );
            $sched_acts[][] = $act;
				}
				
				}
			
				
			}
			
          // print_r($sched_acts);
        }
        else
        {
			// echo $class = $v['class'];
            //echo $prof = $v['prof'];
            echo "Can't find suitable room1!";
        }
    }
	//dump_var($sched_acts);
    return $sched_acts;
}
function is_multi2($a) {
    foreach ($a as $v) {
        if (is_array($v)) return true;
    }
    return false;
    }
function commit_schedule_to_db($sched_acts, $tt_id, $conn)
{
    $query = "DELETE FROM SCHED_ACTIVITIES WHERE TT_ID=$tt_id";
    mysqli_query($conn,$query)
        or die("Can't remove old schedule");
	//dump_var($sched_acts);
    foreach ($sched_acts as $act)
    {  
      $i=1;
	   if(is_multi2($act)){
		  // echo "hello";
		   foreach($act as $dact){
			   //dump_var($dact);
			 $class = $dact['class'];
        $prof = $dact['prof'];
        $room = $dact['room'];
		$sub = $dact['sub'];
        list($day, $intv) = explode(",", $dact['interval']);
         $query = "INSERT INTO SCHED_ACTIVITIES " .
            "(TT_ID, CLASS_ID, PROF_ID, ROOM_ID,SUB_ID, DAY, INT_NO, TWEAK) " .
            "VALUES ($tt_id, $class, $prof, $room,$sub, $day, $intv, 0)";
			//echo $query;
        mysqli_query($conn,$query)
           // or die("Can't add scheduled activity");
                   or die(mysqli_error($conn));	
             $i++;				   
		   }
	   }
       else{
		   //die();
        $class = $act['class'];
        $prof = $act['prof'];
        $room = $act['room'];
		$sub= $act['sub'];
        list($day, $intv) = explode(",", $act['interval']);
         $query = "INSERT INTO SCHED_ACTIVITIES " .
            "(TT_ID, CLASS_ID, PROF_ID, ROOM_ID,SUB_ID ,DAY, INT_NO, TWEAK) " .
            "VALUES ($tt_id, $class, $prof, $room,$sub, $day, $intv, 0)";
        mysqli_query($conn,$query)
            //or die("Can't add scheduled activity");
			or die(mysqli_error($conn));
	   }
    }
	
}

function occupy_room(&$room_avl, $interval, $room_id)
{
    $room_avl[$interval] =
        array_diff($room_avl[$interval], array($room_id));
}

function validate_avl_by_room(&$room_avl, $avl)
{   
    $validated_avl = array();
	
	if(is_array($avl)){
    foreach($avl as $interval)
    {  
        $rooms = $room_avl[$interval];
		
        if (count($rooms) > 0)
        {   
            $validated_avl[] = $interval;
        }
		
    }
	}
	
    return $validated_avl;
}

function validate_avl_by_room_prac($tt_id,$conn,&$room_avl, $avl,$act)
{
    $validated_avl = array();
	if(is_array($avl)){
    foreach($avl as $interval)
    {
        $rooms = $room_avl[$interval];
		//print_r($rooms);
		//print_r($room_avl[$interval]);
        if (count($rooms) > 0)
        {
			$subject=get_subject($tt_id,$conn,$act['prac']);
			//echo $interval;
			//echo $subject;
			   
			
			
				if($subject=="Microprocessor[P]" || $subject=="Communication System I[P]" || $subject=="Propagation Antenna[P]" || $subject=="RF & Microwave Engineering[P]" || $subject=="Minor Project[P]")
				{					
								$lab_id=get_labid($tt_id,$conn,'LAB1');
								//echo $lab_id;
				               if(in_array($lab_id,$rooms))
							   {
								   if($subject=='Communication System I[P]')
							   {
								   $lab_id=get_labid($tt_id,$conn,'LAB5');
								//echo $lab_id;
				               if(in_array($lab_id,$rooms))
							   {
								   $validated_avl[] = $interval;
							   }
							   }
							   else
							   {
								   $validated_avl[] = $interval;
							   }
							   }
							   
				}
				else if($subject=="Project[P]")
				{
								$lab_id=get_labid($tt_id,$conn,'LAB2');
								//echo $lab_id;
				               if(in_array($lab_id,$rooms))
							   {
								   $validated_avl[] = $interval;
							   }
				}
				else if($subject=="Basic Electronics Engineering[P]" || $subject=="Embedded System[P]")
				{					
								$lab_id=get_labid($tt_id,$conn,'LAB3');
								//echo $lab_id;
				               if(in_array($lab_id,$rooms))
							   {
								    if($subject=='Embedded System[P]')
							   {
								   $class=get_subject($tt_id,$conn,$act['class']);
								   if($class=='BEX3')
								   {
								   $lab_id=get_labid($tt_id,$conn,'LAB1');
								   }
								   else
								   {
									    $lab_id=get_labid($tt_id,$conn,'LAB6');
								   }
								//echo $lab_id;
				               if(in_array($lab_id,$rooms))
							   {
								   $validated_avl[] = $interval;
							   }
							   }
							   else
							   {
								   $validated_avl[] = $interval;
							   }
							   }
				}
				else if($subject=="Data Structure & Algorithms[P]" || $subject=="DBMS[P]" || $subject=="Internet & Intranet[P]" || $subject=="Computer Network[P]" )
				{					
								$lab_id=get_labid($tt_id,$conn,'LAB4');
								//echo $lab_id;
				               if(in_array($lab_id,$rooms))
							   {
								   if($subject=='Internet & Intranet[P]')
							   {
								   $lab_id=get_labid($tt_id,$conn,'LAB6');
								//echo $lab_id;
				               if(in_array($lab_id,$rooms))
							   {
								   $validated_avl[] = $interval;
							   }
							   }
							   else
							   {
								   $validated_avl[] = $interval;
							   }
							   }
				}
				else if($subject=="Minor Project[P]" || $subject=="Signal Analysis[P]" || $subject=="Digital Signal Processing[P]" )
				{
								 $lab_id=get_labid($tt_id,$conn,'LAB5');
								
				               if(in_array($lab_id,$rooms))
							   {
								   
								    if($subject=='Digital Signal Processing[P]')
							   {
								   $lab_id=get_labid($tt_id,$conn,'LAB1');
								//echo $lab_id;
								//print_r($rooms);
				               if(in_array($lab_id,$rooms))
							   {
								   
								   $validated_avl[] = $interval;
								   
							   }
							  
							   }
							   else
							   {
								  // print_r($rooms);
								   $validated_avl[] = $interval;
								   
							   }
							   }
							  
				}
			else if($subject== "OOAD[P]" || $subject=="Operating System[P]" || $subject=="Artificial Intelligence[P]" || $subject=="Simulation & Modeling[P]" || $subject=="Information System[P]" )
			{				
								$lab_id=get_labid($tt_id,$conn,'LAB6');
								//echo $lab_id;
				               if(in_array($lab_id,$rooms))
							   {
								   $validated_avl[] = $interval;
							   }
			}
				else
				{
						// echo "Practical name not found in resources for given practical id in practical table";
						// echo $subject;
				}
			
			
			
            
        }
    }
	}
	
    return $validated_avl;
}

function get_tweaks($class_name, $prof_name, $room_name,
        &$room_avl, $sched_acts, $resources)
{
    $activity = null;
    foreach ($sched_acts as $act)
    {
//        dump_var($act);
//        echo("\n");
        if ($act['class'] == $class_name
            && $act['prof'] == $prof_name
            && $act['room'] == $room_name)
        {
//            dump_var($act);
            $activity = array(
                    'class' => $act['class_id'],
                    'prof' => $act['prof_id'],
                    'room' => $act['room_id']
                    );
            continue;
        }
        $interval = "{$act['day']},{$act['interval']}";
        if ($act['class'] == $class_name)
        {
//            echo "<p>reducing avl for $class_name $interval</p>";
            $avl =& $resources[$act['class_id']]['avl'];
            $avl = array_diff($avl, array($interval));
        }
        if ($act['prof'] == $prof_name)
        {
//            echo "<p>reducing avl for $prof_name $interval</p>";
            $avl =& $resources[$act['prof_id']]['avl'];
            $avl = array_diff($avl, array($interval));
        }
//        echo "<p>reducing avl for {$act['room']} $interval</p>";
        occupy_room($room_avl, $interval, $act['room_id']);
    }
//    echo "<p>activity</p>";
//  dump_var($activity);
    $avl = common_availability($activity, $resources);
    $tweaks = validate_avl_by_room($room_avl, $avl);
    return $tweaks;
}

function generate($tt_id, $conn)
{   $sd=schedule_practical($tt_id,$conn);
     $resources=$sd[0];
	 $prof_timetable=$sd[1];
	 $class_timetable=$sd[2];
	 $partial_acts=$sd[3];
    $timetable = read_timetable($tt_id, $conn);
    $activities = read_activities($tt_id, $conn);
   // $resources = read_resources($tt_id, $conn,
     //       $timetable['days'], $timetable['intervals']);
	// $resources = $_SESSION['resources'];
    //dump_var($activities);
    //dump_var($resources);
    //dump_var($timetable);
    $room_avl = calc_room_availability($resources, $timetable);
    //dump_var($room_avl);
    $activities = sort_by_pressure($activities, $resources);
    //dump_var($activities);
    $sched_acts = generate_timetable($activities, $resources, $room_avl,
            $timetable['days'], $timetable['intervals'],$prof_timetable,$class_timetable,$partial_acts);
    //dump_var($sched_acts);
    commit_schedule_to_db($sched_acts, $tt_id, $conn);
    echo "<p>Scheduled all activities</p>";
    echo "<p><a href=\"manage_tt.php\">Timetable ";
    echo "{$_SESSION['tt_name']}</a></p>";
    echo "<p><a href=\"index.php\">Main page</a></p>";
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function other_department_prac($class,$practical,$resources) 
{    
    $class_avl = $resources[$class]['avl'];
	   $prac_avl=$resources[$practical]['avl'];
	   $avl = array_intersect($class_avl,$prac_avl);
      return $avl;

}

function adjacent($class_space)
{
	
	$len=2;
    for($i=0;$i<count($class_space);$i++)
	            {
					
					$space=array();
                    					$t=0;
					$space[]=$class_space[$i+$t];

					for($j=0;$j<count($class_space);$j++){
						if(is_adjacent($class_space[$i+$t],$class_space[$j])){
							$t++;
							$space[]=$class_space[$j];
							//dump_var($best);
							$len--;
							
							if($len==0)
							{
								
								//dump_var($best);
								
								return $space;
							}
						}
					}
				}
}
function schedule_practical($tt_id,$conn)
{   
    
     
	$timetable = read_timetable($tt_id, $conn);
    $activities = read_activities_prac($tt_id, $conn);
    $resources = read_resources($tt_id, $conn,
            $timetable['days'], $timetable['intervals']);
	
	$room_avl = calc_room_availability_prac($resources, $timetable);
	
	$activities = sort_by_pressure_prac($tt_id,$conn,$activities, $resources);
	
	$days = $timetable['days'];
	$intervals = $timetable['intervals'];
	//--------------------------------------------------------------------------------------------------------------------------------------------
	
	init_score_timetables($prof_timetable, $class_timetable,
        $resources, $days, $intervals);
    $sched_acts = array();
    foreach ($activities as $k => $v)
    {
		///////////////////////////////////////////////////////////////////////////////////scheduling other department practicals
		if($v['prof1']==0 || $v['prof2']==0 || $v['prof3']==0)
		{
			$class_space=array();
		$class_space=other_department_prac($v['class'],$v['prac'],$resources);
		$class_space= array_values($class_space);
		//print_r($class_space);
		if(count($class_space)>=3)
		    {
			
			
			$space=array();	
			$space=adjacent($class_space);
			if(count($space)!=3)
			{
				echo "Could not find adjacent slots for external practical";
			}
				
		    
			
			
			 $class_timetable[$v['class']][$space[0]] = 1;
			 $class_timetable[$v['class']][$space[1]] = 1;
			 $class_timetable[$v['class']][$space[2]] = 1;
			  $resources[$v['class']]['avl'] =
                array_diff($resources[$v['class']]['avl'],array($space[0]));
				$resources[$v['class']]['avl'] =
                array_diff($resources[$v['class']]['avl'],array($space[1]));
				$resources[$v['class']]['avl'] =
                array_diff($resources[$v['class']]['avl'],array($space[2]));
				
			$resources[$v['prac']]['avl'] =
                array_diff($resources[$v['prac']]['avl'],array($space[0]));
			$resources[$v['prac']]['avl'] =
                array_diff($resources[$v['prac']]['avl'],array($space[1]));
			$resources[$v['prac']]['avl'] =
                array_diff($resources[$v['prac']]['avl'],array($space[2]));
				foreach($space as $ot)
				{
					 $act = array(
                'class' => $v['class'],
               'prof' =>$v['prof1'],
                'room' =>0,
                
				'sub' => $v['prac'],
                'interval' => $ot
                );
            $sched_acts[][] = $act;
				}
		    }
		
		
			continue;
			
		 
	    }
		////////////////////////////////////////////////////////////////////////////////////
        $room = "";
        $avl = common_availability_prac($tt_id,$conn,$v, $resources);
		
		
        $variants = validate_avl_by_room_prac($tt_id,$conn,$room_avl, $avl,$v);
		
	//print_r($variants);
        if (count($variants) > 0)
        {   
	         $bigp_interval=array();
			 $expansion=$v['length'];
			
			        $bigp_interval =
                best_variant_prac($variants, $v,
                        $prof_timetable, $class_timetable,
                        $days, $intervals);
						//echo $variant;
						 
			
            
			if(isset($bigp_interval)){
               $i=1;				
				foreach($bigp_interval as $vt){
					//echo $big_interval[$f];
				
				$rooms =& $room_avl[$vt];
						//print_r($rooms);
						 $subject=get_subject($tt_id,$conn,$v['prac']);
						
			if($subject=="Microprocessor[P]" || $subject=="Communication System I[P]" || $subject=="Propagation Antenna[P]" || $subject=="RF & Microwave Engineering[P]" || $subject=="Minor Project[P]")
			{
				
								$lab_id=get_labid($tt_id,$conn,'LAB1');
				               if(in_array($lab_id,$rooms))
							   {
								  // $key= array_search($lab_id,$rooms);
								   
								   //$room = $rooms[$key];
								   //$room = array_slice($rooms,$key,1);
								   $room=array($lab_id);
								   
							   }
							  
			                 if($subject=="Communication System I[P]")
							 {
								 $lab_id=get_labid($tt_id,$conn,'LAB5');
				               if(in_array($lab_id,$rooms))
							   {
								   //$key= array_search($lab_id,$rooms);
								   
								   //$room = $rooms[$key];
								   //$room1 = array_slice($rooms,$key,1);
								   $room1=array($lab_id);
								   
							   }
							 }
				
						
			}
			else if($subject== "Project[P]")
			{
				
								$lab_id=get_labid($tt_id,$conn,'LAB2');
				               if(in_array($lab_id,$rooms))
							   {
								   //$key= array_search($lab_id,$rooms);
								   
								   //$room = $rooms[$key];
								   //$room = array_slice($rooms,$key,1);
								   $room=array($lab_id);
								   
							   }
							  
			
				
						
			}
			else if($subject=="Basic Electronics Engineering[P]" || $subject=="Embedded System[P]")
			{
				
								$lab_id=get_labid($tt_id,$conn,'LAB3');
				               if(in_array($lab_id,$rooms))
							   {
								   //$key= array_search($lab_id,$rooms);
								   
								   //$room = $rooms[$key];
								 
								  // $room = array_slice($rooms,$key,1);
								  $room=array($lab_id);
								  
							   }
							  
			if($subject=="Embedded System[P]")
							 {
								 $class=get_subject($tt_id,$conn,$v['class']);
								 if($class=='BEX3')
								 {
								 $lab_id=get_labid($tt_id,$conn,'LAB1');
								 }
								 else
								 {
									$lab_id=get_labid($tt_id,$conn,'LAB6'); 
								 }
				               if(in_array($lab_id,$rooms))
							   {
								   //$key= array_search($lab_id,$rooms);
								   
								   //$room = $rooms[$key];
								   //$room1 = array_slice($rooms,$key,1);
								   $room1=array($lab_id);
								   
							   }
							 }
				
				
						
			}
			else if($subject=="Data Structure & Algorithms[P]" || $subject=="DBMS[P]" || $subject=="Internet & Intranet[P]" || $subject=="Computer Network[P]" )
			{
				
								$lab_id=get_labid($tt_id,$conn,'LAB4');
				               if(in_array($lab_id,$rooms))
							   {
								   //$key= array_search($lab_id,$rooms);
								   
								   //$room = $rooms[$key];
								  // $room = array_slice($rooms,$key,1);
								  $room=array($lab_id);
								   
							   }
							  
			if($subject=="Internet & Intranet[P]")
							 {
								 $lab_id=get_labid($tt_id,$conn,'LAB6');
				               if(in_array($lab_id,$rooms))
							   {
								  // $key= array_search($lab_id,$rooms);
								   
								   //$room = $rooms[$key];
								  // $room1 = array_slice($rooms,$key,1);
								  $room1=array($lab_id);
								   
							   }
							 }
				
						
			}
			else if($subject=="Minor Project[P]" || $subject=="Signal Analysis[P]" || $subject=="Digital Signal Processing[P]")
			{                    
		                         //echo $subject;
				
								 $lab_id=get_labid($tt_id,$conn,'LAB5');
				               if(in_array($lab_id,$rooms))
							   {  
								  // $key= array_search($lab_id,$rooms);
								   
								   //$room = $rooms[$key];
								 
								  
								   //$room = array_slice($rooms,$key,1);
								   $room=array($lab_id);
								   
								 
							   }
							  
			                if($subject=="Digital Signal Processing[P]")
							 {
								 $lab_id=get_labid($tt_id,$conn,'LAB1');
				               if(in_array($lab_id,$rooms))
							   {
								  // $key= array_search($lab_id,$rooms);
								   
								   //$room = $rooms[$key];
								   //$room1 = array_slice($rooms,$key,1);
								   $room1=array($lab_id);
								   
							   }
							 }   
				
						
			}
			else if($subject== "OOAD[P]" || $subject=="Operating System[P]" || $subject=="Artificial Intelligence[P]" || $subject=="Simulation & Modeling[P]" || $subject=="Information System[P]" )
			{
				
								$lab_id=get_labid($tt_id,$conn,'LAB6');
				               if(in_array($lab_id,$rooms))
							   {
								   //$key= array_search($lab_id,$rooms);
								  
								   //$room = array_slice($rooms,$key,1);
								  $room=array($lab_id);
								   
								   
							   }
							  
			
				
						
			}
			
			
				 //$room_avl[2];
			//echo count($rooms);
            $class = $v['class'];
            $prof1 = $v['prof1'];
			$prof2 = $v['prof2'];
			$prof3 = $v['prof3'];
			$prac=$v['prac'];
            $prof_timetable[$prof1][$vt] = 1;
			$prof_timetable[$prof2][$vt] = 1;
			$prof_timetable[$prof3][$vt] = 1;
            $class_timetable[$class][$vt] = 1;
			//print_r($rooms);
			//$room=array($room);
			//print_r($room);
			// print_r($rooms);
			 
            $rooms = array_diff($rooms,$room);
			 if($subject=="Communication System I[P]")
							 {
			$rooms = array_diff($rooms,$room1);
			$teacher1_id=get_labid($tt_id,$conn,'Dr. DRP');
	   $teacher2_id=get_labid($tt_id,$conn,'Dr. SRB');
	   $teacher3_id=get_labid($tt_id,$conn,'AK');
	   
	   $prof_timetable[$teacher1_id][$vt] = 1;
			$prof_timetable[$teacher2_id][$vt] = 1;
			$prof_timetable[$teacher3_id][$vt] = 1;
			
			 $resources[$teacher1_id]['avl'] =
                array_diff($resources[$teacher1_id]['avl'], array($vt));
				 $resources[$teacher2_id]['avl'] =
                array_diff($resources[$teacher2_id]['avl'], array($vt));
				 $resources[$teacher3_id]['avl'] =
                array_diff($resources[$teacher3_id]['avl'], array($vt));
			
							 }
							 
							 
		 if($subject=="Digital Signal Processing[P]")
		 {
			 
			$rooms = array_diff($rooms,$room1);
			$teacher1_id=get_labid($tt_id,$conn,'Dr. NBA');
	   $teacher2_id=get_labid($tt_id,$conn,'DBK');
	   $teacher3_id=get_labid($tt_id,$conn,'KN');
	   
	   $prof_timetable[$teacher1_id][$vt] = 1;
			$prof_timetable[$teacher2_id][$vt] = 1;
			$prof_timetable[$teacher3_id][$vt] = 1;
			
			
			 $resources[$teacher1_id]['avl'] =
                array_diff($resources[$teacher1_id]['avl'], array($vt));
				 $resources[$teacher2_id]['avl'] =
                array_diff($resources[$teacher2_id]['avl'], array($vt));
				 $resources[$teacher3_id]['avl'] =
                array_diff($resources[$teacher3_id]['avl'], array($vt));
			
		 }
		 
		  if($subject=="Internet & Intranet[P]")
		 {
			 
			$rooms = array_diff($rooms,$room1);
			$teacher1_id=get_labid($tt_id,$conn,'RB');
	   $teacher2_id=get_labid($tt_id,$conn,'AP');
	   $teacher3_id=get_labid($tt_id,$conn,'BRP');
	   
	   $prof_timetable[$teacher1_id][$vt] = 1;
			$prof_timetable[$teacher2_id][$vt] = 1;
			$prof_timetable[$teacher3_id][$vt] = 1;
			
			
			 $resources[$teacher1_id]['avl'] =
                array_diff($resources[$teacher1_id]['avl'], array($vt));
				 $resources[$teacher2_id]['avl'] =
                array_diff($resources[$teacher2_id]['avl'], array($vt));
				 $resources[$teacher3_id]['avl'] =
                array_diff($resources[$teacher3_id]['avl'], array($vt));
			
		 }
		if($subject=="Embedded System[P]")
							 {
			$rooms = array_diff($rooms,$room1);
			if($class=='BEX3')
			{
			$teacher1_id=get_labid($tt_id,$conn,'Dr. RKM');
	   $teacher2_id=get_labid($tt_id,$conn,'BP');
	   $teacher3_id=get_labid($tt_id,$conn,'KN');
			}
			else
			{
				$teacher1_id=get_labid($tt_id,$conn,'AV');
	   $teacher2_id=get_labid($tt_id,$conn,'RB');
	   $teacher3_id=get_labid($tt_id,$conn,'BRP');
			}
	   $prof_timetable[$teacher1_id][$vt] = 1;
			$prof_timetable[$teacher2_id][$vt] = 1;
			$prof_timetable[$teacher3_id][$vt] = 1;
			
			
			 $resources[$teacher1_id]['avl'] =
                array_diff($resources[$teacher1_id]['avl'], array($vt));
				 $resources[$teacher2_id]['avl'] =
                array_diff($resources[$teacher2_id]['avl'], array($vt));
				 $resources[$teacher3_id]['avl'] =
                array_diff($resources[$teacher3_id]['avl'], array($vt));
			
			
							 }
			//print_r($rooms);
			//print_r($room);
			
			//print_r($rooms);
			//$variant=array_diff(array($big_interval[$f]);
            $resources[$class]['avl'] =
                array_diff($resources[$class]['avl'],array($vt));
            $resources[$prof1]['avl'] =
                array_diff($resources[$prof1]['avl'], array($vt));
				 $resources[$prof2]['avl'] =
                array_diff($resources[$prof2]['avl'], array($vt));
				 $resources[$prof3]['avl'] =
                array_diff($resources[$prof3]['avl'], array($vt));
				
            $act = array(
                'class' => $v['class'],
                'prof' => $v['prof'.$i],
                'room' => $room[0],
				'sub' => $v['prac'],
                'interval' => $vt
                );
            $sched_acts[][] = $act;
			$i++;
				}
				
		    }
			
			//$_SESSION['professor_timetable']=$prof_timetable;
            // $_SESSION['class_timetable']=$class_timetable;
			// $_SESSION['resources']=$resources;
				
          // print_r($sched_acts);
        }
        else
        {
            // echo ("Can't find suitable room!");
        }
    }
	//dump_var($sched_acts);
   commit_schedule_to_db($sched_acts, $tt_id, $conn);
	//die();
	$sd =array();
	$sd[0]=&$resources;
	$sd[1]=&$prof_timetable;
	$sd[2]=&$class_timetable;
	$sd[3]=&$sched_acts;
	return $sd;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//debug_dump();
$tt_id = $_SESSION['tt_id'];
$conn = connect_to_db();

if (isset($_POST['tweak']))
{    
   //die("hello");
    $sched_acts = read_scheduled_activities($tt_id, $conn);
    list($class, $prof, $room,$sub,$start) = explode(',', $_POST['start']);
    list($day, $interval) = explode('_', $_POST['stop']);
	list($sday,$sinterval)=explode('_', $start);
    $timetable = read_timetable($tt_id, $conn);
    $resources = read_resources($tt_id, $conn,
            $timetable['days'], $timetable['intervals']);
    $room_avl = calc_room_availability($resources, $timetable);
    // call to reduce the room_avl using the scheduled activities
    foreach($sched_acts as $act)
    {
        if ($act['class'] == $class
                && $act['prof'] == $prof
                && $act['room'] == $room && $act['sub'] == $sub && $act['day']==$sday && $act['interval']=$sinterval)
        {
            $id = $act['id'];
            break;
        }
    }
    get_tweaks($class, $prof, $room, $room_avl, $sched_acts, $resources);
//    dump_var($room_avl);
    $rooms = array_values($room_avl["$day,$interval"]);
    $room = $rooms[0];
    $query = "UPDATE SCHED_ACTIVITIES " .
        "SET ROOM_ID=$room, DAY=$day, INT_NO=$interval " .
        "WHERE ID=$id AND DAY=$sday AND INT_NO=$sinterval";
    mysqli_query($conn,$query)
                        or die("Can't update scheduled activities!");
        //or die(mysqli_error($conn));
		
    exit();
}


if (isset($_POST['tweak_options']))
{   
	
    $timetable = read_timetable($tt_id, $conn);
    $activities = read_activities($tt_id, $conn);
    $resources = read_resources($tt_id, $conn,
            $timetable['days'], $timetable['intervals']);
    $sched_acts = read_scheduled_activities($tt_id, $conn);
    $class_name = $_POST['class_name'];
    $prof_name = $_POST['prof_name'];
    $room_name = $_POST['room_name'];
	    $sub_name = $_POST['sub_name'];
//    dump_var($_POST);
    $room_avl = calc_room_availability($resources, $timetable);
    $tweaks = get_tweaks($class_name, $prof_name, $room_name,
            $room_avl, $sched_acts, $resources);
    $output = "";
    foreach ($tweaks as $tweak)
    {
        $output .= $tweak . ";";
    }
    $output = rtrim($output, ';');
    echo($output);
	
		
    exit();
}

if (isset($_GET['startover']))
{
    $query = "DELETE FROM SCHED_ACTIVITIES WHERE TT_ID=$tt_id";
    mysqli_query($query)
        or die ("Can't delete activities");
    echo "<p>Un-scheduled all activities</p>";
    echo "<p><a href=\"manage_tt.php\">Timetable ";
    echo "{$_SESSION['tt_name']}</a></p>";
    echo "<p><a href=\"index.php\">Main page</a></p>";
    exit();
}

//$res=$ress;

//die();
$start_time = microtime(true);


generate($tt_id, $conn);

$stop_time = microtime(true);
$duration = $stop_time - $start_time;
echo "<p>[Generate took $duration seconds]</p>";

?>
