
<?php session_start(); 
//error_reporting(E_ALL & ~E_NOTICE);
?>
<script language="javascript" src="../js/res_act_mng.js">
</script>
<style>
body {
    background-color: #dfdfff;
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
    background-color: rgb(39, 117, 168);
}
table {
    width:80%;
}

table.center {
    margin-left: auto;
    margin-right: auto;
}

th, td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #fff;
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
  
<script language="javascript">
function confirm_delete_activity(id)
{
    msg = "Are you sure you want to delete activity?";
    if (confirm(msg))
    {
        location = "newactivity.php?delete="+id;
    }
}
function confirm_delete_activityp(id)
{
    msg = "Are you sure you want to delete activity?";
    if (confirm(msg))
    {
        location = "newactivity.php?deletep="+id;
    }
}
</script>
<?php
include_once("common.php");
global $blank;
if (isset($_GET['delete']))
{
    $res_id = $_GET['delete'];
    $conn = connect_to_db();
    $query = "DELETE FROM ACTIVITIES WHERE ID=$res_id";
    mysqli_query($conn,$query)
        or die("Can't delete resource");
    echo "deleted resource";
    print<<<_H
<p><a href="manage_tt.php">Timetable {$_SESSION['tt_name']}</a></p>
<p><a href="index.php">Main page</a></p>
_H;
    exit();
}
if (isset($_GET['deletep']))
{
    $res_id = $_GET['deletep'];
    $conn = connect_to_db();
    $query = "DELETE FROM PRACTICAL WHERE ID=$res_id";
    mysqli_query($conn,$query)
        or die("Can't delete resource");
    echo "deleted resource";
    print<<<_H
<p><a href="manage_tt.php">Timetable {$_SESSION['tt_name']}</a></p>
<p><a href="index.php">Main page</a></p>
_H;
    exit();
}
// page entry point
if (isset($_POST['add']) && !isset($_POST['addp']) )
{
    $conn = connect_to_db();
     $act_type = $_POST['type'];
     $class_name = $_POST['class'];
     $prof_name = $_POST['prof'];
	 $sub_name = $_POST['sub'];
	 $length=$_POST['length'];
    $query = "SELECT R1.ID AS CLASS_ID, R2.ID AS PROF_ID ,R3.ID AS SUB_ID" .
        " FROM RESOURCES R1, RESOURCES R2, RESOURCES R3 " .
        "WHERE R1.NAME='$class_name' AND R2.NAME='$prof_name' AND R3.NAME='$sub_name'";
    echo "<p>$query</p>";
    $result = mysqli_query($conn,$query)
        or die("Can't get resource names!");
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
     $class_id = $row['CLASS_ID'];
    $prof_id = $row['PROF_ID'];
	$sub_id = $row['SUB_ID'];
	
    if (isset($_POST['edit']))
    {
        $act_id = $_POST['edit'];
        $query = "UPDATE ACTIVITIES " .
            "SET TYPE='$act_type', CLASS_ID=$class_id, " .
            "PROF_ID=$prof_id ,SUB_ID=$sub_id,LENGTH=$length " .
            "WHERE ID=$act_id";
    }
    else
    {   echo $class_id;
        $query = "INSERT INTO ACTIVITIES " .
            "(TT_ID, CLASS_ID, PROF_ID,SUB_ID, LENGTH, TYPE) " .
            "VALUES ({$_SESSION['tt_id']}, $class_id, " .
            "$prof_id,$sub_id, $length, '$act_type')";
    }
    echo "<p>$query</p>";
    mysqli_query($conn,$query)
        or die ('Error on insert/update');
    echo '<p>Inserted/Updated the new resource data</p>';
    echo "<a href=\"newactivity.php\">";
    echo "New activity...</a>";
    echo "<p><a href=\"manage_tt.php\">";
    echo "Timetable {$_SESSION['tt_name']}</a></p>";
    echo '<p><a href="index.php">Main page</a></p>';
    exit();
}




if (isset($_POST['addp'])  && !isset($_POST['add']) )
{
    $conn = connect_to_db();
     
     $classp_name = $_POST['class'];
     $prof1_name = $_POST['prof1'];
	 $prof2_name = $_POST['prof2'];
	 $prof3_name = $_POST['prof3'];
	 $prac_name = $_POST['prac'];
	 $length=3;
	 if($prof1_name=='' || $prof2_name=='' || $prof3_name=='')
	 {
		 $query = "SELECT R1.ID AS CLASS_ID,R3.ID AS PRAC_ID" .
        " FROM RESOURCES R1,  RESOURCES R3 " .
        "WHERE R1.NAME='$classp_name'  AND R3.NAME='$prac_name'";
	 }
	 else
	 {
    $query = "SELECT R1.ID AS CLASS_ID, R2.ID AS PROF1_ID , R3.ID AS PROF2_ID, R4.ID AS PROF3_ID,R5.ID AS PRAC_ID" .
        " FROM RESOURCES R1, RESOURCES R2, RESOURCES R3, RESOURCES R4, RESOURCES R5 " .
        "WHERE R1.NAME='$classp_name' AND R2.NAME='$prof1_name' AND R3.NAME='$prof2_name' AND R4.NAME='$prof3_name' AND R5.NAME='$prac_name'";
	 }
    echo "<p>$query</p>";
    $result = mysqli_query($conn,$query)
        or die("Can't get resource names!");
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	if($prof1_name=='' || $prof2_name=='' || $prof3_name=='')
	 {
     $classp_id = $row['CLASS_ID'];
    $prof1_id = 0;
	 $prof2_id = 0;
	  $prof3_id = 0;
	$prac_id = $row['PRAC_ID'];
	 }
	 else
	 {
		$classp_id = $row['CLASS_ID'];
    $prof1_id = $row['PROF1_ID'];
	$prof2_id = $row['PROF2_ID'];
	$prof3_id = $row['PROF3_ID'];
	$prac_id = $row['PRAC_ID']; 
	 }
    if (isset($_POST['editp']))
    {
        $act_id = $_POST['editp'];
        $query = "UPDATE PRACTICAL " .
            " SET CLASS_ID=$classp_id, " .
            "PROF1_ID=$prof1_id ,PROF2_ID=$prof2_id ,PROF3_ID=$prof3_id ,PRAC_ID=$prac_id,LENGTH=3 " .
            "WHERE ID=$act_id";
    }
    else
    {   echo $classp_id;
        $query = "INSERT INTO PRACTICAL " .
            "(TT_ID, CLASS_ID, PROF1_ID,PROF2_ID,PROF3_ID,PRAC_ID, LENGTH) " .
            "VALUES ({$_SESSION['tt_id']}, $classp_id, " .
            "$prof1_id,$prof2_id,$prof3_id,$prac_id, $length)";
    }
    echo "<p>$query</p>";
    mysqli_query($conn,$query)
        or die ('Error on insert/update');
    echo '<p>Inserted/Updated the new resource data</p>';
    echo "<a href=\"newactivity.php\">";
    echo "New activity...</a>";
    echo "<p><a href=\"manage_tt.php\">";
    echo "Timetable {$_SESSION['tt_name']}</a></p>";
    echo '<p><a href="index.php">Main page</a></p>';
    exit();
}


$conn = connect_to_db();
if (isset($_GET['edit']) && !isset($_GET['editp']))
{
	 $act_classp = -1;
    $act_prof1 = -1;
	$act_prof2 = -1;
	$act_prof3 = -1;
	$act_prac = -1;
     $types_html = "<option>COMPULSORY</option>";
    $types_html .= "<option>ELECTIVE</option>";
    $delete_link = "";
    $act_id = $_GET['edit'];
    $edit_input = "<input name=\"edit\" id=\"edit\"" .
        " type=\"hidden\" value=\"$act_id\">";
    $query = "SELECT * FROM ACTIVITIES WHERE ID=$act_id";
    $result = mysqli_query($conn,$query)
        or die("Can't get activity");
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $act_class = $row['CLASS_ID'];
    $act_prof = $row['PROF_ID'];
	 $act_sub = $row['SUB_ID'];
    $act_type = $row['TYPE'];
    $selected = $act_type == 'COMPULSORY' ? ' selected' : '';
    $types_html = "<option$selected>COMPULSORY</option>";
	
    $selected = $act_type == 'ELECTIVE' ? ' selected' : '';
    $types_html .= "<option$selected>ELECTIVE</option>";
    $delete_link = 
        "<p><a href=\"javascript:confirm_delete_activity($act_id)\">";
    $delete_link .= "delete activity</a></p>";
    $generator_link = "";
    $submit = "Update";
}
else if(isset($_GET['editp']) && !isset($_GET['edit']))
{
	$act_class = -1;
	$act_sub = -1;
	$act_prof = -1;
	 $types_html = "<option>COMPULSORY</option>";
    $types_html .= "<option>ELECTIVE</option>";
    $delete_link = "";
    $act_id = $_GET['editp'];
    $edit_input = "<input name=\"editp\" id=\"editp\"" .
        " type=\"hidden\" value=\"$act_id\">";
    $query = "SELECT * FROM PRACTICAL WHERE ID=$act_id";
    $result = mysqli_query($conn,$query)
        or die("Can't get activity");
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $act_classp = $row['CLASS_ID'];
    $act_prof1 = $row['PROF1_ID'];
	$act_prof2 = $row['PROF2_ID'];
	$act_prof3 = $row['PROF3_ID'];
	 $act_prac = $row['PRAC_ID'];
    
   
    $delete_link = 
        "<p><a href=\"javascript:confirm_delete_activityp($act_id)\">";
    $delete_link .= "delete practical activity</a></p>";
    $generator_link = "";
    $submit = "Update";
}
else
{
	
    $act_class = -1;
	$act_sub = -1;
	$act_prof = -1;
	
	$act_classp = -1;
    $act_prof1 = -1;
	$act_prof2 = -1;
	$act_prof3 = -1;
	
	$act_prac = -1;
    $act_type = "";
    $edit_input = "";
    $types_html = "<option>COMPULSORY</option>";
    $types_html .= "<option>ELECTIVE</option>";
    $delete_link = "";
    $generator_link = 
        "<a href=\"actgen.php\">use automatic generator</a><br><br>";
    $submit = "Add";
}

	if(!isset($_GET['editp']) || !isset($_POST['addp'])){
		$class_options = 
    get_resource($_SESSION['tt_id'], 'CLASS', $act_class);
$prof_options =
    get_resource($_SESSION['tt_id'], 'PROF', $act_prof);
	$sub_options =
    get_resource($_SESSION['tt_id'], 'SUB', $act_sub);
	}
	if(!isset($_GET['edit']) || !isset($_POST['add']) ){
		//$prof_options=array();
		$classp_options = 
    get_resource($_SESSION['tt_id'], 'CLASS', $act_classp);
		$prof1_options =
    get_resource($_SESSION['tt_id'], 'PROF', $act_prof1);
	$prof2_options =
    get_resource($_SESSION['tt_id'], 'PROF', $act_prof2);
	$prof3_options=
    get_resource($_SESSION['tt_id'], 'PROF', $act_prof3);
	$prac_options = get_prac_resources($_SESSION['tt_id'], 'PRAC', $act_prac);
	}
$existing = "<h3>Existing activities:</h3>";
$existing .= get_defined_activities($_SESSION['tt_id'], $conn);

//After h3 tag, add $generator_link befor $delete_link
print<<<_H
<h2>Timetable - {$_SESSION['tt_name']}</h2>

$existing
<h3>Activity data:</h3>
$delete_link
_H;
if(!isset($_GET['editp']) || !isset($_POST['addp'])){
	print<<<_H
<form method="post">
<table class="center">
    <tr >
        <td>Type</td>
        <td ><select name="type" id="type"
            onchange="javascript:type_changed()">
        $types_html
        </select></font></td>
    </tr>
    <tr >
        <td>Class</td>
        <td><select name="class" id="class">
        $class_options
        </select>
        </td>
    </tr>
	
    <tr >
        <td>Prof</td>
        <td><select name="prof" id="prof">
        $prof_options
        </select>
        </td>
    </tr>
	<tr  >
        <td>Subject</td>
        <td><select name="sub" id="sub">
        $sub_options
        </select>
        </td>
    </tr>
	<tr >
        <td>Length</td>
        <td><input name="length" id="length" type="number" value="1" min="1" max="3">
        </td>
    </tr>
    <tr>
        <td><input name="add" id="add" type="submit" value="$submit"></td>
        <td><input name="add" id="add" type="reset" value="Reset"
        onclick="javascript:reset_type()">
        $edit_input
        </td>
    </tr>
</table>
</form>
_H;
}

if(!isset($_GET['edit']) || !isset($_POST['add']) ){
	
	print<<<_H
<h1>Practical activities can be added below.</h1>
<form method="post">
<table class="center">
    
    <tr >
        <td>Class</td>
        <td><select name="class" id="class">
        $classp_options
        </select>
        </td>
    </tr>
	
	
    <tr >
        <td>Prof1</td>
        <td><select name="prof1" id="prof1">
		$blank="<option></option>";
        $prof1_options=$blank.$prof1_options;
        </select>
        </td>
    </tr>
	<tr >
        <td>Prof2</td>
        <td><select name="prof2" id="prof2">
        $blank="<option></option>";
        $prof2_options=$blank.$prof2_options;
        </select>
        </td>
    </tr>
	<tr >
        <td>Prof3</td>
        <td><select name="prof3" id="prof3">
        $blank="<option></option>";
        $prof3_options=$blank.$prof3_options;
        </select>
        </td>
    </tr>
	<tr  >
        <td>Subject</td>
        <td><select name="prac" id="prac">
        $prac_options
        </select>
        </td>
    </tr>
	
    <tr>
        <td><input name="addp" id="addp" type="submit" value="$submit"></td>
        <td><input name="addp" id="addp" type="reset" value="Reset"
        onclick="javascript:reset_type()">
        $edit_input
        </td>
    </tr>
</table>
</form>
_H;
}
print<<<_H
<p><a href="manage_tt.php">Timetable {$_SESSION['tt_name']}</a></p>
<p><a href="index.php">Main page</a></p>
_H;
?>
