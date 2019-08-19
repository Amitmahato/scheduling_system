<?php session_start(); ?>
<style>
input[type=text],input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
input[type=reset] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
input[type=submit]:hover {
    background-color: #45a049;
}
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
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
<?php
include_once("common.php");

// page entry point
if (isset($_POST['add']))
{
    $conn = connect_to_db();
    $act_type = $_POST['type'];
    $classes = $_POST['class'];
    $profs = $_POST['prof'];
    foreach ($classes as $class_name)
    {
        foreach ($profs as $prof_name)
        {
            $query = "SELECT R1.ID AS CLASS_ID, R2.ID AS PROF_ID " .
                "FROM RESOURCES R1, RESOURCES R2 " .
                "WHERE R1.NAME='$class_name' AND R2.NAME='$prof_name'";
//            echo "<p>$query</p>";
            $result = mysqli_query($conn,$query)
                or die("Can't get resource names!");
            $row = mysqli_fetch_array($result, MYSQL_ASSOC);
            $class_id = $row['CLASS_ID'];
            $prof_id = $row['PROF_ID'];
            $query = "INSERT INTO ACTIVITIES " .
                "(TT_ID, CLASS_ID, PROF_ID, LENGTH, TYPE) " .
                "VALUES ({$_SESSION['tt_id']}, $class_id, " .
                "$prof_id, 1, '$act_type')";
//            echo "<p>$query</p>";
            mysqli_query($conn,$query)
                or die ('Error on insert/update');
        }
    }
    echo '<p>Inserted/Updated the new resource data</p>';
    echo "<a href=\"newactivity.php\">";
    echo "New activity...</a>";
    echo "<p><a href=\"manage_tt.php\">";
    echo "Timetable {$_SESSION['tt_name']}</a></p>";
    echo '<p><a href="index.php">Main page</a></p>';
    exit();
}
//debug_dump();
$conn = connect_to_db();
$class_options = 
    get_resource($_SESSION['tt_id'], 'CLASS', -1);
$prof_options =
    get_resource($_SESSION['tt_id'], 'PROF', -1);

print<<<_H
<h2>Timetable - {$_SESSION['tt_name']}</h2>
<p>admin is logged in.</p>

<h3>Activity generator:</h3>
<p>Every selected class on the left will be paired with each selected prof on
the right, and every pair will generate an activity.The subjects and intervals can be only defined manually one by one.</p>
<form method="post">
<table>
    <tr>
        <td>Type</td>
        <td><select name="type" id="type"
            onchange="javascript:type_changed()">
            "<option>MANDATORY</option>
            "<option>DESIRABLE</option>
        </select></td>
    </tr>
    <tr>
        <td>Select classes</td>
        <td>Select profs</td>
		
    </tr>
    <tr>
        <td><select multiple size="20" name="class[]" id="class">
        $class_options
        </select>
        </td>
        <td><select multiple size="20" name="prof[]" id="prof">
        $prof_options
        </select>
        </td>
		
    </tr>
    <tr>
        <td><input name="add" id="add" type="submit" value="Generate"></td>
        <td><input name="add" id="add" type="reset" value="Reset"
        onclick="javascript:reset_type()">
        </td>
    </tr>
</table>
</form>
<p><a href="manage_tt.php">Timetable {$_SESSION['tt_name']}</a></p>
<p><a href="index.php">Main page</a></p>
_H;
?>
