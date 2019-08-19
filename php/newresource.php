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
h3 {
    color: rgb(40,40,40);
    text-align: left;
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

<script language="javascript" src="../js/res_act_mng.js">
</script>

<script language="javascript">
function type_changed()
{
    new_type = document.getElementById('type').value;
    size_row = document.getElementById('size-row');
    if (new_type == 'CLASS' || new_type == 'ROOM')
    {
        size_row.style.display = 'table-row';
    }
    else
    {
        size_row.style.display = 'none';
    }
}
function reset_type()
{
    document.getElementById('type').value = 'PROF';
    type_changed();
}
</script>

<?php
include_once("common.php");
if(isset($_SESSION['signup'])){
	$_SESSION['uname']='Admin';
}
// page entry point
$conn = connect_to_db();
if (isset($_POST['add']))
{
    $avl = "";
    $res_type = $_POST['type'];
    $res_name = $_POST['name'];
    $res_size = $_POST['size'];
    if ($res_size == '' || $res_type == 'PROF')
    {
        $res_size = 0; // size doesn't matter
    }
    $query = "INSERT INTO RESOURCES " .
             "(TT_ID, TYPE, NAME, AVL, SIZE) " .
             "VALUES ({$_SESSION['tt_id']}, '$res_type', " .
                     "'$res_name', '$avl', $res_size)";
    mysqli_query($conn,$query)
        or die ('Error on insert');
    echo '<p>Inserted the new resource data</p>';
    echo "<a href=\"newresource.php\">";
    echo "New resource...</a>";
    echo "<p><a href=\"manage_tt.php\">";
    echo "Timetable {$_SESSION['tt_name']}</a></p>";
    echo '<p><a href="index.php">Main page</a></p>';
    exit();
}
$existing = "<h3>Existing resources:</h3>";
$existing .= get_defined_resources($_SESSION['tt_id'], $conn);
print<<<_H
<h2>Timetable - {$_SESSION['tt_name']}</h2>
<p style='color:gray;'>Admin is logged in.</p>
$existing
<hr><h3>Resource data:</h3>
<!--<a href="resgen.php">use automatic generator</a><br>--><br>
<p><h3>The rooms dedicated for practical should have a name that begins with lAB like LAB1, LAB2,etc.</h3></p>
<form method="post" action="newresource.php">
<table class="center">
    <tr>
        <td>Type</td>
        <td><select name="type" id="type"
            onchange="javascript:type_changed()" >
			
        <option>CLASS</option>
        <option>ROOM</option>
		<option>PROF</option>
		 <option>SUB</option>
		 <option>PRAC</option>
        </select></td>
    </tr>
    <tr>
        <td>Name</td>
        <td><input name="name" id="name" type="text"></td>
    </tr>
    <tr id="size-row">
        <td>Size</td>
        <td><input name="size" id="size" type="text"></td>
    </tr>
	
    <tr>
        <td><input name="add" id="add" type="submit" value="Add"></td>
        <td><input name="add" id="add" type="reset" value="Reset"
        onclick="javascript:reset_type()"></td>
    </tr>
</table>
</form>
<p><a href="manage_tt.php">Timetable {$_SESSION['tt_name']}</a></p>
<p><a href="index.php">Main page</a></p>
_H;
?>
