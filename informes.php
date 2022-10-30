<?php
include 'templates/head.php';
include 'conexion.php';
include 'orden.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
} else {
    include './templates/header_informes.php';
?>

    <?php


    $m = "de hoy : $";
    date_default_timezone_set(timezoneId: "America/Santiago");
    $f = date('Y-m-d');
    if (isset($_POST['fecha'])) {
        $f = $_POST['fecha'];
        $fecha = date("d-m-Y", strtotime($f));
        $m = "del día {$fecha} : $";
    }
    $sql = $conexion->query("SELECT * FROM `orden` where orden.fecha = '{$f}'; ");

    $ganancia = 0;
    while ($r = mysqli_fetch_array($sql)) {


        $ganancia += $r['total_venta'];
    }
    ?>
    <?php
    $con = $conexion->query("SELECT * FROM `orden` where orden.fecha = '{$f}'  ORDER BY orden.fecha DESC ");

    ?>

    <div class="p-3">
        <div class="  table-responsive border p-3 table-scrollable ">
            <table class="table table-responsive border table-striped table-hover ">
                <caption> Total ganancias <?php echo $m;
                                            echo number_format($ganancia); ?> </caption>
                <tr>
                    <th>N° Orden</th>
                    <th>Fecha de emisión</th>
                    <th>TOTAL VENTA</th>
                    <th></th>
                    <th></th>
                </tr>


                <?php
                while ($res = mysqli_fetch_array($con)) {

                    $fecha = date("d-m-Y", strtotime($res['fecha']));
                ?> <tr>
                        <td><?php echo $res['num_orden']; ?></td>
                        <td><?php echo ($fecha); ?></td>
                        <td><strong><?php echo ('$'); ?></strong><?php echo number_format($res['total_venta']); ?></td>
                        <td>

                            <form action="ventas_detalles.php" method="post">
                                <input type="hidden" name="num_orden" id="num_orden" value="<?php echo $res['num_orden']; ?>">
                                <button class="btn btn-outline-success" type="submit">Ver detalles </button>
                            </form>

                        </td>

                        <td>

                            <?php
                            $descont = 0;
                            $sdes = $conexion->query("SELECT * FROM `despacho` where num_despacho= '{$res['num_orden']}'");
                            while ($rSdes = mysqli_fetch_array($sdes)) {
                                $descont++;
                            }
                            if ($descont == 0) {
                                echo (' <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                              </svg><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                                <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                            </svg>');
                            } else {
                                echo (' 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                              </svg><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                                <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                            </svg>');
                            }
                            ?>
                        </td>
                    </tr>

                <?php
                }
                ?>


            </table>
        </div>
    </div>

<?php
}
include 'templates/foot.php';
?>