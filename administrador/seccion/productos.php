<?php include("../template/cabecera.php"); ?>  
<?php 

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:""; 
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:""; 

include("../config/db.php"); 
 
switch($accion){
    case "Agregar": 
        //INSERT INTO `libros2` (`id`, `nombre`, `imagen`) VALUES (NULL, 'Libro de php', 'imagen.jpg');
        $sentenciaSQL= $conexion->prepare("INSERT INTO libros2 ( nombre, imagen) VALUES ( :nombre, :imagen);"); 
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':imagen',$txtImagen);
        $sentenciaSQL->execute(); 
        break; 

    case "Modificar":
        echo "Presionado botón modificar";
         break; 

    case "Cancelar":
        echo "Presionado botón Cancelar";
        break; 

    case "Seleccionar":
        //echo "Presionado botón Seleccionar";
        break; 

    case "Borrar": 
        $sentenciaSQL= $conexion->prepare("DELETE  FROM libros2 WHERE id=:id"); 
        $sentenciaSQL->bindParam(':id',$txtID); 
        $sentenciaSQL->execute(); 
        //echo "Presionado botón Borrar";
        break; 
    }  

    $sentenciaSQL= $conexion->prepare("SELECT * FROM libros2"); 
    $sentenciaSQL->execute(); 
    $listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

 ?>

<div class="col-md-5"> 

<div class="card">
    <div class="card-header">
       Datos de Libro
    </div> 

    <div class="card-body"> 
    <form method="POST" enctype="multipart/form-data"> 

<div class = "form-group">
<label for="txtID">ID:</label>
<input type="text" class="form-control" name="txtID" id="txtID"  placeholder="ID">
</div>  

<div class = "form-group">
<label for="txtNombre">Nombre:</label>
<input type="text" class="form-control" name="txtNombre" id="txtNombre"  placeholder="Nombre del libro">
</div>  

<div class = "form-group">
<label for="txtImagen">Imagen</label>
<input type="file" class="form-control" name="txtImagen" id="txtImagen"  placeholder="Imagen">
</div> 

<div class="btn-group" role="group" aria-label="">
    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
    <button type="Submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
    <button type="Submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
</div>

</form> 
       
    </div> 

   
</div>

    
    
    

</div>  
<div class="col-md-7">  

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th> 
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($listaLibros as $Libro) { ?>
            <tr>
                <td ><?php echo $Libro['id']; ?></td>
                <td><?php echo $Libro['nombre']; ?></td>
                <td><?php echo $Libro['imagen']; ?></td>  

                <td>
                    
                Seleccionar | Borrar 
                <form method="post">

                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $Libro['id']; ?>" /> 

                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />

                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />

                </form>

                </td> 

            </tr>
           <?php } ?>
        </tbody>
    </table>
    
</div>

<?php include("../template/pie.php"); ?> 