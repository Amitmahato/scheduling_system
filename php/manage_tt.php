<?php session_start(); ?>
<style>
body {
    background-color: #dfdfff;
}
hr {
    text-align: center;
}
h2 {
    font-size: 40px;
    color: rgb(50,50,50);
    text-align: center;
    padding: 8px;
}
input[type=text],input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #fff;
    border-radius: 5px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: rgb(76, 135, 175);
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
input[type=reset] {
    width: 100%;
    background-color: rgb(76, 135, 175);
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
input[type=submit]:hover {
    background-color: rgba(39, 117, 168, 10);
}
table {
    border-collapse: collapse;
    width: 80%;
    margin-left: auto;
    margin-right: auto;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    background-color: rgb(140, 189, 223);
}

tr:hover{background-color:#f5f5f5}


table {
    display: table;
    border-collapse: separate;
    border-spacing: 2px;
    border-color: gray
}

thead {
    display: table-header-group;
    vertical-align: middle;
    border-color: inherit
}

tbody {
    display: table-row-group;
    vertical-align: middle;
    border-color: inherit
}

tfoot {
    display: table-footer-group;
    vertical-align: middle;
    border-color: inherit
}

table > tr {
    vertical-align: middle;
}

col {
    display: table-column
}

colgroup {
    display: table-column-group
}

tr {
    display: table-row;
    vertical-align: inherit;
    border-color: inherit
}

td, th {
    display: table-cell;
    vertical-align: inherit;
	font-size=50px
}

th {
    font-weight: bold
	font-size=50px
}

caption {
    display: table-caption;
    text-align: -webkit-center
}
</style>
<script language="javascript" src="../js/res_act_mng.js">
</script>
<script language="javascript">

function confirm_start_over()
{
    msg = 'Regenerating the timetable will erase ' +
        'the generated timetable and ALL your tweaks for this timetable!';
    if (confirm(msg))
    {
        location = 'generate.php';
    }
}

function show_res(disp)
{   
    el = document.getElementById('CLASS_res');
    el.style.display = disp;
    el = document.getElementById('PROF_res');
    el.style.display = disp;
    el = document.getElementById('ROOM_res');
    el.style.display = disp;
	el = document.getElementById('SUB_res');
    el.style.display = disp;
	el = document.getElementById('PRAC_res');
    el.style.display = disp;
    el = document.getElementById('show_lnk');
    if (disp == 'none')
    {  
        disp = 'block';
        el.innerHTML = 'show';
    }
    else
    {
        disp = 'none';
        el.innerHTML = 'hide';
    }
    el.href = 'javascript:show_res(\'' + disp + '\')';
}
function show_activity(disp,cat)
{
    el = document.getElementById('act_' + cat);
    el.style.display = disp;
    el = document.getElementById('show_lnk_act_' + cat);
    if (disp == 'none')
    {
        disp = 'block';
        el.innerHTML = 'show';
    }
    else
    {
        disp = 'none';
        el.innerHTML = 'hide';
    }
    el.href =
        'javascript:show_activity(\''+disp+'\',\''+cat+'\')';
}

</script>
<?php
include_once("common.php");
if(isset($_POST['export']))
{
$file="demo.xls";
$test="<table  ><tr><td>Cell 1</td><td>Cell 2</td></tr></table>";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");
echo $test;
}
function show_timetables($resources, $timetable, $tt_id, $conn)
{
    $sched_act = read_scheduled_activities($tt_id, $conn);
    $used_res = array();
    $html_result = "";
    if (count($sched_act) == 0)
    {
        $html_result .=  "";
    }
    else
    {
        $show = 'block';
        foreach ($resources as $k => $v)
        { 
		   
            $html_table = 
                render_timetable_for_resource($sched_act, $v['name'],
                        $timetable['days'], $timetable['intervals'],
                        $show);
						//echo $timetable['days'];
						//echo $timetable['intervals'];
						//echo $v['name'];
						//echo $sched_act;
            if ($html_table != "")
            {
                $used_res[] = $v['name'];
                $html_result .= $html_table;
                $show = 'none';
				
            }
			
        }
    }
    return array($used_res, $html_result);
}

function generate_chooser($used_resources)
{
    echo "\n<script language=\"javascript\">\n";
    echo "var res_list = new Array();\n";
    $i = 0;
    foreach ($used_resources as $res)
    {
        echo "res_list[$i]='$res';\n";
        $i++;
    }
    print<<<_H
function chooser_onchange()
{ 
    for (var i = 0; i < res_list.length; i++)
    {
        id = 'res_name_' + res_list[i];
        document.getElementById(id).style.display = 'none';
    }
    current = document.getElementById('res_chooser').value;
    document.getElementById('res_name_'+current).style.display = 'block';
}
_H;



    echo "</script>";
	echo "<form method='POST' action='manage_tt.php'> <input type='submit' name='export' Value='Export to Excel'/></form>";
    echo "<br>View timetable for ";
    echo "<select id=\"res_chooser\" name=\"res_chooser\"";
    echo "onchange=\"javascript:chooser_onchange()\">";
    foreach ($used_resources as $res)
    {
        echo "<option>$res</option>";
    }
    echo "</select>";
}

// page entry point
if (!isset($_GET['id']) && !isset($_SESSION['tt_id']))
{
    echo '<a href="index.php">Main page</a>';
    exit();
}
if (isset($_GET['id']))
{
    $_SESSION['tt_id']= $_GET['id'];
    $_SESSION['tt_name']= $_GET['name'];
}
$conn = connect_to_db();
$resources = get_defined_resources($_SESSION['tt_id'], $conn);
$activities = get_defined_activities($_SESSION['tt_id'], $conn);
print<<<_H
<h2><a href="index.php" style="text-decoration:none;color:initial;">Timetable</a> - {$_SESSION['tt_name']}</h2>

_H;
echo "<hr><h3>Timetable input</h3>";
echo $resources;
echo $activities;
$tt_id = $_SESSION['tt_id'];
$tt = read_timetable($tt_id, $conn);
$resources = read_resources($tt_id, $conn, $tt['days'], $tt['intervals']);
list($used_resources, $html_tt) = 
    show_timetables($resources, $tt, $_SESSION['tt_id'], $conn);
if ($html_tt == "")
{
    $generate_url = "generate.php";
}
else
{
    $generate_url = "javascript:confirm_start_over()";
}
echo "<hr><h3>";
echo "<a href=\"$generate_url\">Generate</a> ";
echo "<a href=\"tweak.php\">Tweak</a></h3> ";
echo "<hr><h3>Timetable output</h3>";
if ($html_tt != "")
{
    generate_chooser($used_resources);
    echo $html_tt;
}
else
{
    echo "<p>No timetable generated yet</p>";
}
echo "<hr>";
echo "<p><a href=\"index.php\">Main page</a></p>";
echo "<p style='color:green;'>Export to Excel and add the following alternate practicals where there are red colored practicals:<br /> ";
?>

