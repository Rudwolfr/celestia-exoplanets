<?php
//Este script de PHP crea estrellas para agregarlos a Celestia utilizando la base de datos de exoplanets.eu
//Necesitas descargar el catálogo de exoplanetas desde exoplanet.eu
//Luego importa la bases de datos en un servidor como xampp
//Renombra la columna dec como deg, debido a que "dec" es palabra reservada de sql
//Abre el script en un navegador web y se creará el archivo
//Mueve el archivo a la carpeta extras dentro de la carpeta de instalación de php
$link = mysql_connect("localhost", "root", "");
mysql_select_db("exoplanetas", $link);
 
$result = mysql_query("SELECT star_name, ra, deg, mag_v, star_distance, star_radius, star_sp_type FROM planetas", $link);

if($result === FALSE) {
	die(mysql_error()); 
}

$rsol = 696342;//Radio del Sol en kilometro
$estrellas_celestia = array("11 Com", "11 UMi", "14 And", "14 Her");//Estrellas ya incluidas en Celestia, falta muchas
$checa ="";

$ar=fopen("stars.stc","w") or die("Problemas en la creación");
 
while($row=mysql_fetch_array($result))
{
	if (in_array($row["star_name"], $estrellas_celestia, true)) {
	}
	else {
	if($row["star_name"] != $checa){//Para evitar planetas repetidos
	
	fputs($ar, "\"");
    fputs($ar, $row["star_name"]);
    fputs($ar, "\"");
    fputs($ar, "\n");
    fputs($ar, "{");
    fputs($ar, "\n");
    fputs($ar, "RA ");
    fputs($ar, $row["ra"]);
    fputs($ar, "\n");
    fputs($ar, "Dec ");
    fputs($ar, $row["deg"]);//originalmente dec, pero es palabra reservada de sql
    fputs($ar,"\n");
    
    if(!empty($row["mag_v"])) {
    fputs($ar, "AppMag ");
    fputs($ar, $row["mag_v"]);
    fputs($ar,"\n");
    }
    
    if(!empty($row["star_distance"])) {
	fputs($ar, "Distance ");
    fputs($ar, $row["star_distance"]);
    strtr ("hello my name is santa", array (' ' => '\r'));
    fputs($ar,"\n");
    }
    
    fputs($ar, "SpectralType ");
    fputs($ar, "\"");
    fputs($ar, str_replace(" ", "", $row["star_sp_type"]));
    fputs($ar, "\"");
    fputs($ar,"\n");
    
    if(!empty($row["star_radius"])) {
    	$radioS = $row["star_radius"];
    	$radio = $radioS * $rsol;
    	fputs($ar, "Radius ");
    	fputs($ar, $radio);
    	fputs($ar,"\n");
    	fputs($ar,"}");
    	fputs($ar,"\n");
    } else {
    	fputs($ar,"}");
    	fputs($ar,"\n");
    }
    $checa=$row["star_name"];
    }}}
 echo "Archivo stars.stc creado correctamente";
fclose($ar);
?>