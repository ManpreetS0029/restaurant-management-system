<?php

if(!isset($_GET["page"]))
{
    $page = 1;
}

else
{
    $page = $_GET["page"];
}

$resultsPerPage = 10;


?>