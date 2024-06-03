<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
date_default_timezone_set("America/Bogota");
//session_destroy(); exit;

if(file_exists("tareas.txt")){

    $jsontareas = file_get_contents("tareas.txt");

    $aTareas=json_decode($jsontareas, true);

}else{
    $aTareas=array();
}

if(isset($_GET["editar"]) && isset($_GET["editar"])>=0){
    $pos=$_GET["editar"];

}
if(isset($_GET["eliminar"]) && isset($_GET["eliminar"])>=0){
    $pos=$_GET["eliminar"];

    unset($_SESSION["aTareas"][$pos]);
        $aTareas=$_SESSION["aTareas"];

        $jsontarea=json_encode($aTareas);
        file_put_contents("tareas.txt", $jsontarea); 

        header("location: gestor_de_tareas.php");
         
}
if(isset($_GET["cancelar"])){
    unset($_SESSION["aTareas"]);
    header("location: gestor_de_tareas.php");

}


if ($_POST){

    
    if(isset($_GET["editar"])){
    $fecha= date("d/m/Y");
    $prioridad=$_REQUEST["lstPrioridad"];
    $usuario=$_REQUEST["lstUsuario"];
    $estado=$_REQUEST["lstEstado"];
    $titulo=$_REQUEST["txtTitulo"];
    $descripcion=$_REQUEST["txtDescripcion"];
    
    
    $aTareas[$pos]=array("lstPrioridad"=>"$prioridad", "lstUsuario"=>"$usuario","lstEstado"=>"$estado",
    "txtTitulo"=>"$titulo","txtDescripcion"=>"$descripcion", "fecha"=>"$fecha");
    $_SESSION["aTareas"]=$aTareas;
    
    $jsontarea=json_encode($aTareas);
    
    file_put_contents("tareas.txt", $jsontarea);
    header("location: gestor_de_tareas.php");

    }else{
        $fecha= date("d/m/Y");
    $prioridad=$_REQUEST["lstPrioridad"];
    $usuario=$_REQUEST["lstUsuario"];
    $estado=$_REQUEST["lstEstado"];
    $titulo=$_REQUEST["txtTitulo"];
    $descripcion=$_REQUEST["txtDescripcion"];
    
    
    $aTareas[]=array("lstPrioridad"=>"$prioridad", "lstUsuario"=>"$usuario","lstEstado"=>"$estado",
    "txtTitulo"=>"$titulo","txtDescripcion"=>"$descripcion", "fecha"=>"$fecha");
    $_SESSION["aTareas"]=$aTareas;
    
    $jsontarea=json_encode($aTareas);
    
    file_put_contents("tareas.txt", $jsontarea);
    header("location: gestor_de_tareas.php");
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Tareas</title>
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">


</head>

<body>

    <main class="container">
        <div class="col-12 text-center">
            <h1>Gestor de Tareas</h1>
        </div>

        <div class="row p-4">
            <div class="col-4">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="lstPrioridad" class="form-label">Prioridad</label>
                    <select id="lstPrioridad" required class="form-select" required name="lstPrioridad">
                        
                        <option disabled selected value="" ><?php echo isset($_GET["editar"]) && $aTareas[$_GET["editar"]]["lstPrioridad"] == "Alta"? "selected": ""; ?>Prioridad</option> <i class="fa-solid fa-check"></i>
                        <option <?php echo isset($_GET["editar"]) && $aTareas[$_GET["editar"]]["lstPrioridad"] == "Alta"? "selected": ""; ?> value="Alta">Alta</option>
                        <option <?php echo isset($_GET["editar"]) && $aTareas[$_GET["editar"]]["lstPrioridad"] == "Media"? "selected": ""; ?> value="Media">Media</option>
                        <option <?php echo isset($_GET["editar"]) && $aTareas[$_GET["editar"]]["lstPrioridad"] == "Baja"? "selected": ""; ?> value="Baja">Baja</option>
                    </select>
            </div>

            <div class="col-4">
                <label for="lstUsuario" class="form-label">Usuario</label>
                <select id="lstUsuario" required class="form-select" name="lstUsuario">
                    <option disabled selected value="">Usuario</option>
                    <option <?php echo isset($_GET["editar"]) && $aTareas[$_GET["editar"]]["lstUsuario"] == "Ana"? "selected": ""; ?> value="Ana">Ana</option>
                    <option <?php echo isset($_GET["editar"]) && $aTareas[$_GET["editar"]]["lstUsuario"] == "Bernabe"? "selected": ""; ?> value="Bernabe">Bernabe</option>
                    <option <?php echo isset($_GET["editar"]) && $aTareas[$_GET["editar"]]["lstUsuario"] == "Daniela"? "selected": ""; ?> value="Daniela">Daniela</option>
                </select>
            </div>

            <div class="col-4">
                <label for="lstEstado" class="form-label">Estado</label>
                <select id="lstEstado" class="form-select" required name="lstEstado">
                    <option disabled selected value="">Estado</option>
                    <option <?php echo isset($_GET["editar"]) && $aTareas[$_GET["editar"]]["lstEstado"] == "Sin asignar"? "selected": ""; ?> value="Sin asignar">Sin asignar</option>
                    <option <?php echo isset($_GET["editar"]) && $aTareas[$_GET["editar"]]["lstEstado"] == "Asignado"? "selected": ""; ?> value="Asignado">Asignado</option>
                    <option <?php echo isset($_GET["editar"]) && $aTareas[$_GET["editar"]]["lstEstado"] == "En proceso"? "selected": ""; ?> value="En proceso">En proceso</option>
                    <option <?php echo isset($_GET["editar"]) && $aTareas[$_GET["editar"]]["lstEstado"] == "Terminado"? "selected": ""; ?> value="Terminado">Terminado</option>
                </select>
            </div>

            <div class="col-12">
                <label for="txtTitulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="txtTitulo" value="<?php echo isset($_GET["editar"]) && $_GET["editar"] >= 0? $aTareas[$_GET["editar"]]["txtTitulo"]: ""; ?>" required name="txtTitulo">
                
            </div>
            <div class="col-12">
                <label for="txtDescripcion" class="form-label">Descripcion</label>
                <input type="text" class="form-control" id="txtDescripcion" value="<?php echo isset($_GET["editar"]) && $_GET["editar"] >= 0? $aTareas[$_GET["editar"]]["txtDescripcion"]: ""; ?>" name="txtDescripcion">
            </div>

            <div class="col-12 text-center my-3">
                <button type="submit" class="btn btn-primary">ENVIAR</button>
                <a href="?cancelar=1"><button type="button" class="btn btn-secondary">CANCELAR</button></a>
            </div>
            </form>
        </div>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Fecha de inserción</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Prioridad</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Estado</th>
                    <th scope="col" colspan="1"></th>

                </tr>
            </thead>
            <tbody>
                <?php if(isset($aTareas)){ foreach($aTareas as $pos => $tarea){ ?>
                <tr>
                    <th scope="row"><?php echo $pos+1; ?></th>
                    <td><?php echo $tarea["fecha"]; ?></td>
                    <td><?php echo $tarea["txtTitulo"]; ?></td>
                    <td><?php echo $tarea["lstPrioridad"]; ?></td>
                    <td><?php echo $tarea["lstUsuario"]; ?></td>
                    <td><?php echo $tarea["lstEstado"]; ?></td>

                    <td><a href="?editar=<?php echo $pos; ?>"><button type="button" class="btn btn-secondary"><i
                                    class="fa-solid fa-pen-to-square"></i></button></a>
                        <a href="?eliminar=<?php echo $pos;?>"><button type="button" class="btn btn-danger"><i
                                    class="fa-solid fa-trash"></i></button></a>
                    </td>

                </tr>
                <?php } } ?>

            </tbody>
        </table>

    </main>

</body>

</html>