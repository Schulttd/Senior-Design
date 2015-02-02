<?php
require_once("/phpChart/conf.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>graph</title>
</head>
<body>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Senior Design";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE name='Thomas Schultz'";
$result = $conn->query($sql);

$name;
$data_file;
$num_on_count;
$num_on_sd;
$flag_description;
$flag_time;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $name = $row["name"];
        $data_file = $row["data_file"];
        $data_file = "output.txt";
        $num_on_count = $row["num_on_count"];
        $num_on_sd = $row["num_on_sd"];
        $flag_description = $row["flag_description"];
        $flag_time = $row["flag_time"];
        
        echo "name: " . $row["name"] . "<br>";
    }
} else {
    echo "0 results";
}

$data_string = file_get_contents($data_file);
$data_string = str_replace("\r", "", $data_string);

$data_array = explode("\n", $data_string);

//foreach($data_array as $data) {
//	echo $data . "<br>";
//}

//split array into timestamps and data points
$counter = 1;
$data_points = [];
$timestamps= [];
foreach($data_array as $data) {
    if($counter % 2 == 1) {
        array_push($data_points, $data);
    }
    else {
        array_push($timestamps, $data);
    }

    $counter++;
}

array_pop($data_points);

/*foreach($data_points as $data_point) {
    echo $data_point, "<br>";
}

foreach($timestamps as $timestamp) {
    echo $timestamp, "<br>";
}
*/
$pc = new C_PhpChartX(array($data_points),'usage_chart');
$pc->draw();


/*
// content="text/plain; charset=utf-8"
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');

$n = count($data_points);
$xmin = $data_points[0];
$xmax = $data_points[$n-1];

// Setup the graph
$graph = new Graph(300,250);
$graph->SetScale('intlin',0,1,$xmin,$xmax);

$theme_class=new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Filled Y-grid');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("fill");
$graph->xaxis->SetTickLabels(array($timestamps));
$graph->xgrid->SetColor('#E3E3E3');

// Create the first line
$p1 = new LinePlot(array($data_points));
$graph->Add($p1);
$p1->SetColor("#6495ED");
$p1->SetLegend('Line 1');

$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();
*/
$conn->close();

?>