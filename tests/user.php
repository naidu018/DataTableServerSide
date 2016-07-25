<?php
$data = array();
$con = mysqli_connect("localhost",'root','root','show_emails');
//echo "<pre>\n{$_REQUEST["search"]["value"]}\n</pre> ";
$sql = "SELECT * FROM emails";

$query = mysqli_query($con,$sql) or die(mysqli_error($con));

$searchvalue = isset($_REQUEST["search"]["value"])? $_REQUEST["search"]["value"] : '';


if(!$searchvalue)
{
while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $data_row = array();
    foreach($row as $key=>$value){
        array_push($data_row, $value);
    }
    array_push($data,$data_row);
}
$reverse=array_reverse($data);
//echo '<code><pre>';
$json_to_return = array();
$json_to_return["draw"] = $_REQUEST["draw"];
$json_to_return["recordsTotal"] = sizeof($data);
$json_to_return["recordsFiltered"] = sizeof($data);
$json_to_return["data"] = $reverse;
echo json_encode($json_to_return);
//echo '</pre></code>';
}
else
{
    $sql= "select * from emails where _messageId like '%$searchvalue%' or _from like '%$searchvalue%' or _pSetup like '%$searchvalue%' or _Deadline like '%$searchvalue%' or _Subject like '%$searchvalue%' or _AssignedPerson like '%$searchvalue%'";
   
    $query = mysqli_query($con,$sql) or die(mysqli_error($con));
    while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $data_row = array();
    foreach($row as $key=>$value){
        array_push($data_row, $value);
    }
    array_push($data,$data_row);
}
$reverse=array_reverse($data);
//echo '<code><pre>';
$json_to_return = array();
$json_to_return["draw"] = $_REQUEST["draw"];
$json_to_return["recordsTotal"] = sizeof($data);
$json_to_return["recordsFiltered"] = sizeof($data);
$json_to_return["data"] = $reverse;
echo json_encode($json_to_return);
}
?>
