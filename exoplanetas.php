<?php
//Este script de PHP crea planetas para agregarlos a Celestia utilizando la base de datos de exoplanets.eu
//Necesitas descargar el catálogo de exoplanetas desde exoplanet.eu
//Luego importa la bases de datos en un servidor como xampp (phpmyadmin)
//Renombra la columna "dec" como "deg"
//Abre el script en un navegador web y se creará el archivo
//Mueve el archivo a la carpeta extras dentro de la carpeta de instalación de Celestia
$link = mysql_connect("localhost", "root", "");
mysql_select_db("exoplanetas", $link);
 
$result = mysql_query("SELECT name, radius, orbital_period, semi_major_axis, eccentricity, inclination, omega, tperi, star_name FROM planetas", $link);


if($result === FALSE) {
	die(mysql_error()); // TODO: better error handling
}

$rjupiter = 71492;

$ar=fopen("exoplanetas.ssc","w") or die("Problemas en la creacion");
 
while($row=mysql_fetch_array($result))
{
	fputs($ar, "\"");
    fputs($ar, $row["name"]);
    fputs($ar, "\" ");
    fputs($ar, "\"");
    fputs($ar, $row["star_name"]);
    fputs($ar, "\"");
    fputs($ar, "\n");
    fputs($ar, "{\n");
    fputs($ar, "Texture \"exo-class1.*\"");
    fputs($ar, "\n");
    
    if(!empty($row["radius"])) {
    	$radioJ = $row["radius"];
    	$radio = $radioJ * $rjupiter;
    	fputs($ar, "Radius ");
    	fputs($ar, $radio);
    	fputs($ar,"\n");
    }
    
    fputs($ar, "\n");
    fputs($ar, "Elliptical Orbit");
    fputs($ar, "{\n");
    fputs($ar, "SemiMajorAxis ");
    fputs($ar, $row["semi_major_axis"]);
    fputs($ar, "\n");
    
    if(!empty($row["eccentricity"])) {
    	fputs($ar, "Eccentricity ");
    fputs($ar, $row["eccentricity"]);
    fputs($ar,"\n");
    }
      
    if(!empty($row["inclination"])) {
    	fputs($ar, "Inclination ");
    	fputs($ar, $row["inclination"]);
    	fputs($ar,"\n");
    }
    
    if(!empty($row["omega"])) {
    fputs($ar, "AscendingNode ");
    fputs($ar, $row["omega"]);
    fputs($ar,"\n");
    }
    
    if(!empty($row["tperi"])) {
    	fputs($ar, "Epoch ");
    	fputs($ar, $row["tperi"]);
    	fputs($ar,"\n");
    	fputs($ar,"}");
    	fputs($ar,"\n");
    	fputs($ar,"}");
    	fputs($ar,"\n");
    	
    } else {
    	fputs($ar,"\n");
    	fputs($ar,"}");
    	fputs($ar,"\n");
    	fputs($ar,"}");
    	fputs($ar,"\n");
    }
    }
    echo "Archivo exoplanetas.ssc creado correctamente";
fclose($ar);
?>
</body>
</html>