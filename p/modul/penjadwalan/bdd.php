<?php
try
{
	$bdd = new PDO('mysql:host=192.168.88.14;dbname=db_emtc_final;charset=utf8', 'root', '19K23O15P');
}
catch(Exception $e)
{
        die('Error : '.$e->getMessage());
}
