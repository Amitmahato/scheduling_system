<?php session_start();

//if((!isset($_SESSION['loggedin']))| (!isset($_SESSION['signup'])))
	//header("Location:/pro/login.php");
?>
<style>
body {
    margin:0;
}
hr {
    text-align: center;
}

h2 {
    font-size: 40px;
    color: rgb(50,50,50);
    background-color: #dfdfff;
    text-align: center;
    padding: 8px;
    font-weight: bold;
    position: relative;
    animation: disp 1s;
}
/* Standard syntax */
@keyframes disp {
  from {top: -50px; background-color:#fff;}
  to {top: 0px;background-color: #dfdfff;}
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

.home{
  font-weight: bold;
  position: relative;
}

.timetable{
    /* margin-left:40%; */
    padding:20px;
    width:30%;
    /* align:center; */
    position:relative;
    left:35%;
    border-left:5px solid #dfdfff ;
    border-radius:5px;
    box-shadow: 1px 1px 5px;
    animation: displaytimetable 1s;
    animation-delay: 0.8s;
    animation-fill-mode:backwards;
}
@keyframes displaytimetable {
  from {opacity:0;}
  to {opacity:100%;}
}

hr{
    background-color:blue;
    border:1px solid gray;
}

</style>
<?php
include_once("common.php");

function fetch_user_timetables($conn)
{
    $query = "SELECT * FROM TIMETABLES";
    $result = mysqli_query($conn,$query)
        or die ('Can\'t get timetables!');
    $timetables = '';
    if (mysqli_num_rows($result) == 0)
    {
        $timetables = 'You have defined no timetables<br>';
        return $timetables;
    }
    $timetables .= "<h3>Your timetables:</h3><ol>";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $tt_id = $row['ID'];
        $tt_name = $row['NAME'];
        $tt_days = $row['DAYS'];
        $timetables .= "<li>";
        $timetables .= "<a style='text-decoration:none;' href=\"manage_tt.php?id=$tt_id&name=$tt_name\">";
        $timetables .= $tt_name;
        $timetables .= "</a>";
        $timetables .= " - spans $tt_days days</li>";
    }
    $timetables .= "</ol>";
    return $timetables;
}

function validate_user($conn)
{
    $pass_md5 = md5($_POST['pass']);
    $query = "SELECT * FROM USERS WHERE NICK='{$_POST['user']}'";
//    echop($query);
    $result = mysqli_query($conn,$query)
        or die ('Can\'t get users!');
    $failure_msg = "Username and password do not match!";
    if (mysqli_num_rows($result) == 0)
    {
        echop($failure_msg);
        return 0;
    }
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($row['PASS'] == $pass_md5)
    {
         $_SESSION['user_name'] = $row['NICK'];
        $_SESSION['user_id'] = $row['ID'];
        return 1;
    }
    else
    {
        echop($failure_msg);
        return 0;
    }
}

/*if (isset($_GET['signout']))
{
    unset($_SESSION['user_name']);
}
*/
$conn = connect_to_db();
//dump_var($_POST);
/*if (isset($_POST['signin']))
{
    if (validate_user($conn))
    {
        header("Location: index.php");
    }
}

if (!isset($_SESSION['user_name']))
{
    print<<<_H
    <h3>Login</h3>
    <form method="post">
    <table>
    <tr>
        <td>User:</td>
        <td><input id="user" name="user" type="text"></td>
    </tr>
    <tr>
        <td>Password:</td>
        <td><input id="pass" name="pass" type="password"></td>
    </tr>
    <tr>
        <td><input id="signin" name="signin" type="submit" value="Sign in"></td>
    </tr>
    </table>
    </form>
    <p>You don't have an account? <a href="signup.php">Sign up</a> now!</p>
_H;
    exit();
}
*/
// page entry point
$timetables = fetch_user_timetables($conn);
print<<<_H
<div class="home">
    <a href="index.php" style="text-decoration:none;color:initial;"><h2>Timetable</h2></a>

    <div class="timetable">
        <div><b>$timetables</b></div>
        <hr></hr>
        <a style='text-decoration:none;' href="newtimetable.php">New Timetable...</a>
    </div>
<br><br>
</div>
_H;

?>

