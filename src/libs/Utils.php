<?php
require_once "bbdd.php";

abstract class Utils
{
    public static function paginate($pagecount, $countername, $pagerate, $total)
    {
        if ($pagecount > 0) {
            echo "<a href='home.php?$countername=".($pagecount - $pagerate)."'>Anterior </a>";
        }
        // Mostrando mensaje de los resultados actuales
        if (($pagecount + $pagerate) <= $total) {
            echo "Mostrando de ".($pagecount + 1)." a ".($pagecount + $pagerate)." de ".$total;
        } else {
            echo "Mostrando de ".($pagecount + 1)." a ".$total." de ".$total;
        }
        // Mostrar el siguiente (en cado de que lo haya)
        if (($pagecount + $pagerate) < $total) {
            echo "<a href='home.php?$countername=".($pagecount + $pagerate)."'> Siguiente</a>";
        }
    }
    
    public static function createTable($res) // Generic for user list
    {
        while($row = $res->fetch_assoc())
        {
            echo "<tr>";
            foreach($row as $key => $value)
                echo "<td>$value</td>";
            echo "</tr>";
        }
    }
    
    public static function createInboxTable($res)
    {
        while($row = $res->fetch_assoc())
        {
            if($row["read"]) // If the msg is read
            {
                echo "<tr>";
                foreach($row as $key => $value)
                {
                    if($key == "idmessage")
                        $id = $value;
                    else if($key != "read" && $key != "body")
                        echo "<td>$value</td>";
                }
                echo "<td><button id='$id' type='button' class='message btn btn-default btn-block' data-toggle='modal' data-target='#readMsg'><span class='glyphicon glyphicon-envelope'/></td>";
                echo "</tr>";
            }
            else
            {
                echo "<tr class='msgrow' style='background-color: #FFEEAA'>";
                foreach($row as $key => $value)
                {
                    if($key == "idmessage")
                        $id = $value;
                    else if($key != "read" && $key != "body")
                        echo "<td style='font-weight: bold'>$value</td>";
                }
                echo "<td><button id='$id' type='button' class='message btn btn-primary btn-block' data-toggle='modal' data-target='#readMsg'><span class='glyphicon glyphicon-envelope'/></td>";
                echo "</tr>";
            }
        }
    }
    
    public static function createSentTable($res)
    {
        while($row = $res->fetch_assoc())
        {
            echo "<tr>";
            foreach($row as $key => $value)
            {
                if($key == "idmessage")
                    $id = $value;
                else if($key != "body")
                    echo "<td>$value</td>";
            }
            echo "<td><button id='$id' type='button' class='message noupdate btn btn-default btn-block' data-toggle='modal' data-target='#readMsg'><span class='glyphicon glyphicon-envelope'/></td>";
            echo "</tr>";
        }
    }
    
    public static function createAllMsgsTable($res)
    {
        while($row = $res->fetch_assoc())
        {
            if($row["read"])
            {
                echo "<tr>";
                foreach($row as $key => $value)
                {
                    if($key == "idmessage")
                        $id = $value;
                    else if($key != "read" && $key != "body")
                        echo "<td>$value</td>";
                }
                echo "<td><button id='$id' type='button' class='message noupdate btn btn-default btn-block' data-toggle='modal' data-target='#readMsg'><span class='glyphicon glyphicon-envelope'/></td>";
                echo "</tr>";
            }
            else
            {
                echo "<tr class='msgrow' style='background-color: #FFEEAA'>";
                foreach($row as $key => $value)
                {
                    if($key == "idmessage")
                        $id = $value;
                    else if($key != "read" && $key != "body")
                        echo "<td style='font-weight: bold'>$value</td>";
                }
                echo "<td><button id='$id' type='button' class='message noupdate btn btn-primary btn-block' data-toggle='modal' data-target='#readMsg'><span class='glyphicon glyphicon-envelope'/></td>";
                echo "</tr>";
            }
        }
    }
    
    public static function fetchUsersOption()
    {
        $con = connect(Constants::db);
        $res = $con->query("SELECT username, name, surname FROM user");
        while($row = $res->fetch_assoc())
        {
            echo "<option value='".$row["username"]."'>".$row["name"]." ".$row["surname"]." (".$row["username"].")</option>";
        }
    }
}