<?php session_start(); ?>
<script language="javascript" src="../js/res_act_mng.js">
</script>

<script language="javascript">
function send_req(http, url, content, handler)
{
    http.open('post', url);
    http.onreadystatechange = handler;
    var contentType = "application/x-www-form-urlencoded; charset=UTF-8";
    http.setRequestHeader("Content-Type", contentType);
    http.send(content);
}

function create_http_request() {
    var ro;
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer"){
        ro = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
        ro = new XMLHttpRequest();
    }
    return ro;
}

var http_move = create_http_request();

var clicked_cell = "";

function handle_request_move()
{ 
    if(http_move.readyState == 4){
        alert("got move reply\n"+http_move.responseText);
        r = http_move.responseText;
        r = r.replace(/\n/,"");
        for (i = 1; i <= days(); i++)
        {
            for (j = 1; j <= intervals(); j++)
            {
                id = 'tt_'+i+'_'+j;
                document.getElementById(id).style.background = 'white';
            }
        }
        if (r != "")
        {
            tweaks = r.split(';');
            for(var i = 0; i < tweaks.length; i++)
            {
                coords = tweaks[i].split(',');
                id = 'tt_'+parseFloat(coords[0])+'_'+parseFloat(coords[1]);
//                alert('|'+id+'|');
                document.getElementById(id).style.background = 'yellow';
            }
//            alert('|'+clicked_cell+'|');
            document.getElementById(clicked_cell).style.background =
                'lightgreen';
        }
    }
}

var tweak_in_progress = 0;

var http_tweak = create_http_request();

function handle_request_tweak()
{
    if(http_tweak.readyState == 4){
      alert("got move reply\n"+http_tweak.responseText);
	  
// reload page with the tweak
        location = "tweak.php?name="+res_name();
    }
}

function start_tweak(start, stop)
{
    start_elem = document.getElementById(start).innerHTML.split(' - ');
	start=start.replace(/^tt_/, '');
    stop = stop.replace(/^tt_/, '');
    if (res_type() == 'CLASS')
    {
        start_param = res_name()+","+start_elem[0]+","+start_elem[1]+","+start_elem[2]+","+start;
    }
    else if (res_type() == 'PROF')
    {
        start_param = start_elem[0]+","+res_name()+","+start_elem[1]+","+start_elem[2]+","+start;
    }
    content = encodeURI("tweak=1&start="+start_param+"&stop="+stop);
   alert(content);
    document.getElementById('tweak_progress').innerHTML = 'tweaking...';
	
    send_req(http_tweak, 'generate.php', content, handle_request_tweak);
	
}

function tt_clicked(day, interval)
{
    if (tweak_in_progress)
    {
        return;
    }
    id = 'tt_'+day+'_'+interval;
    elem = document.getElementById(id);
    text = elem.innerHTML;
	//text=text.split("-");
	//alert(text);
    bkcolor = elem.style.background.split(' ');
	//alert(clicked_cell);
    if (bkcolor[0] == 'yellow')
    {   //alert('in');
        tweak_in_progress = 1;
        start_tweak(clicked_cell, id);
    }
    if (text=='')
    { 
       
        return;
    }
	 ar = text.split(' - ');
	//alert(ar);
	var str = ar[0]; 
    var res = str.match("\\[.*]");
	
	if(res=='[P]')
	{  
		 return;
	}
	var str = ar[1]; 
    var res = str.match(/LAB/g);
	if(res=='LAB')
	{  
        //alert(res);
		 return;
	}
	
    
    if (clicked_cell != '')
    {
		//alert("out");
        document.getElementById(clicked_cell).style.background = 'white';
    }
    clicked_cell = id;
   
    if (res_type() == 'CLASS')
    {
        class_name = res_name();
        prof_name = ar[0];
        room_name = ar[1];
	    sub_name = ar[2];
    }
    else if (res_type() == 'PROF')
    {
        class_name = ar[0];
        prof_name = res_name();
        room_name = ar[1];
		sub_name = ar[2];
    }
    content =
        encodeURI('tweak_options=1'
            + '&class_name=' + class_name
            + '&prof_name=' + prof_name
            + '&room_name=' + room_name
			+ '&sub_name=' + sub_name);
    alert(content);
    send_req(http_move, 'generate.php', content, handle_request_move);
}
function new_resource()
{
    location = "tweak.php?name="+document.getElementById('res_select').value;
}
</script>

<?php
include_once("common.php");

//debug_dump();
if (!isset($_SESSION['tt_id']))
{
    echo '<a href="index.php">Main page</a>';
    exit();
}
if (isset($_GET['name']))
{  
    $res_name = $_GET['name'];
}
else
{
    $res_name = "";
}
$tt_id = $_SESSION['tt_id'];
$conn = connect_to_db();
$timetable = read_timetable($tt_id, $conn);
$resources = read_resources($tt_id, $conn,
        $timetable['days'], $timetable['intervals']);
$html_resources = "";
foreach ($resources as $res)
{
    if ($res['type'] == 'CLASS')
    {
        if ($res_name == "")
        {
            $res_name = $res['name'];
        }
        $selected = "";
        if ($res_name == $res['name'])
        {
            $selected = " selected";
            $res_type = $res['type'];
        }
        $html_resources .= "<option$selected>{$res['name']}</option>";
    }
}
$tt_days = $timetable['days'];
$tt_intervals = $timetable['intervals'];

$sched_acts = read_scheduled_activities($_SESSION['tt_id'], $conn);
$prof_tt = render_timetable_for_resource($sched_acts, $res_name,
        $tt_days, $tt_intervals, 'block', 'tt_clicked');

print<<<_H
<script language="javascript">
function res_type()
{
    return '$res_type';
}
function res_name()
{
    return '$res_name';
}
function days()
{
    return $tt_days;
}
function intervals()
{
    return $tt_intervals;
}
</script>








<p><a href="index.php">Main page</a></p>
<h2><a href="manage_tt.php">Timetable {$_SESSION['tt_name']}</a>
- Tweaking CLASS and PROF timetables</h2>

<hr width="20%" align="left" padding="10px">
<p>Timetable for
<select id="res_select" name="res_select" onchange="javascript:new_resource()">
$html_resources</select></p>

$prof_tt
<div id="tweak_progress"></div>
<p style="width:60ex">
Click on an occupied interval to highlight the other intervals that are
available for the activity you clicked on. The background of the clicked
activity will turn green and the available spots will turn yellow. Clicking on
a yellow cell will move the activity to that interval.
</p>
<hr width="20%" align="left">
<p><a href="manage_tt.php">Timetable {$_SESSION['tt_name']}</a></p>
<p><a href="index.php">Main page</a></p>
_H;
?>
