<?php
include 'templates/head.php';
include 'conexion.php';
include 'orden.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
} else {

    function GetEstado($num_despacho, $conexion)
    {

        $result = "Completado";
        $s = $conexion->query("SELECT * FROM `despacho_producto` where despacho_producto.num_despacho = {$num_despacho} ");
        while ($res = mysqli_fetch_array($s)) {

            if ($res['estado'] == 'pendiente') {
                $result = "Pendiente";
            }
        }

        return  $result;
    }
    $num_despacho = GetIsset('num_despacho');
    $s = $conexion->query("SELECT * FROM `despacho_producto` where despacho_producto.num_despacho = {$num_despacho} ");
    $desp = $conexion->query("SELECT * FROM `despacho` where num_despacho = {$num_despacho} ");
    $rDesp = mysqli_fetch_array($desp);





    $estado = '';

?>
    <div class="col-6">
        <div class="table-responsive border border-dark p-3 ">
            <p><strong>-Productos del despacho-</strong></p>

            <div class="table-responsive border border-dark p-3 ">
                <table class="table table-striped table-bordered">

                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>nombre producto</th>
                        <th>estado producto</th>
                        <th>precio</th>
                        <th></th>
                    </tr>

                    <?php
                    while ($r = mysqli_fetch_array($s)) {
                        $sen = $conexion->query("SELECT * FROM `producto` where id = {$r['id_producto']} ");
                        while ($producto = mysqli_fetch_array($sen)) {
                            $estado = $r['estado'];


                    ?>
                            <tr>
                                <?php if ($r['estado'] == 'pendiente') {

                                ?>
                                    <td> <?php echo ("{$r['id']}"); ?> </td>
                                    <td> <?php echo ("{$producto['codigo']}"); ?></td>
                                    <td> <?php echo ("{$producto['nombre']}"); ?></td>
                                    <td>
                                        <p class="text-danger"><?php echo ("{$r['estado']}"); ?></p>
                                    </td>
                                    <td> <?php echo ("{$producto['precio']}"); ?></td>
                                    <td>
                                        <form action="marcarCompletado.php" method="post">
                                            <input type="hidden" name="id_producto" id="id_producto" value="<?php echo  $r['id'] ?>">
                                            <input type="hidden" name="num_despacho" id="num_despacho" value="<?php echo  $num_despacho ?>">
                                            <button type="submit" class="btn btn-outline-primary">marcar entregado</button>
                                        </form>
                                    </td>




                            </tr>
                        <?php
                                } else {
                        ?>
                            <td><?php echo ("{$r['id']}"); ?> </td>
                            <td><?php echo ("{$producto['codigo']}"); ?></td>
                            <td><?php echo ("{$producto['nombre']}"); ?></td>
                            <th><?php echo ("<strong>{$r['estado']}</strong>"); ?></th>
                            <td><?php echo ("{$producto['precio']}"); ?></td>
                            <td>
                                <form action="" method="post">
                                    <button type="submit" class="btn btn-outline-success" disabled>Entregado</button>
                                </form>
                            </td>
                <?php
                                }
                            }
                        }


                ?>


                </table>
            </div>
            <?php if ($estado == 'pendiente') {
            ?>
                <form action="" method="post">
                    <input type="hidden" name="num_despacho" id="num_despacho" value="<?php echo  $num_despacho; ?>">
                    <button class="btn btn-outline-success mt-4" type="submit" name="accionBoton" value="marcar_completado">marcar completado</button>
                </form>

            <?php
            } ?>
        </div>


    </div>



    <div class="col-6 mt-4">
        <div class="table-responsive border border-dark p-3">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>------------ Información del despacho ---------------</th>
                </tr>
                <tr>
                    <th>Nº despacho: <?php echo GetIsset('num_despacho'); ?></th>
                </tr>

                <tr>
                    <th>Estado: <?php echo GetEstado($num_despacho, $conexion); ?></th>
                </tr>

                <tr>
                    <th>fecha de entrega: <?php echo $rDesp['fecha_entrega'] ?> </th>
                </tr>

                <tr>
                    <th>----------------- Datos del cliente -------------------</th>
                </tr>
                <tr>
                    <th>Nombre: <?php echo $rDesp['nombre_cliente']; ?></th>


                </tr>

                <tr>
                    <th>Número: <?php echo $rDesp['num_cliente']; ?></th>
                </tr>

                <tr>
                    <th>dirección: <?php echo $rDesp['direccion_cliente']; ?></th>
                </tr>


            </table>
        </div>
    </div>
<?php
}
include 'templates/foot.php';
?>