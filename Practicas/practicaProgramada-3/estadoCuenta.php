<?php
// almacenar las transacciones
$transacciones = [];

// registrar una transacción
function registrarTransaccion(&$transacciones, $id, $descripcion, $monto) {
    array_push($transacciones, [
        "id" => $id,
        "descripcion" => $descripcion,
        "monto" => $monto
    ]);
}

// Función para generar el estado de cuenta
function generarEstadoDeCuenta($transacciones) {
    $totalContado = 0;
    $detalle = "===== ESTADO DE CUENTA =====\n\n";

    // Lista de las transacciones
    foreach ($transacciones as $t) {
        $detalle .= "ID: {$t['id']} | Descripción: {$t['descripcion']} | Monto: ₡" . number_format($t['monto'], 2) . "\n";
        $totalContado += $t['monto'];
    }

    // Calcular interes, cashback y el total
    $interes = $totalContado * 0.026;
    $montoConInteres = $totalContado + $interes;
    $cashback = $totalContado * 0.001;
    $montoFinal = $montoConInteres - $cashback;

    // Agrega el detalle
    $detalle .= "\n-----------------------------\n";
    $detalle .= "Monto total de contado: ₡" . number_format($totalContado, 2) . "\n";
    $detalle .= "Interés (2.6%): ₡" . number_format($interes, 2) . "\n";
    $detalle .= "Monto con interés: ₡" . number_format($montoConInteres, 2) . "\n";
    $detalle .= "Cashback (0.1%): ₡" . number_format($cashback, 2) . "\n";
    $detalle .= "Monto final a pagar: ₡" . number_format($montoFinal, 2) . "\n";

    // mostrar
    echo nl2br($detalle);

    // Guardar en archivo de texto
    file_put_contents("estado_cuenta.txt", $detalle);
}

// SIMULACIÓN DE TRANSACCIONES
registrarTransaccion($transacciones, 1, "Compra en supermercado", 70000);
registrarTransaccion($transacciones, 2, "Pago de gasolina", 20000);
registrarTransaccion($transacciones, 3, "Compra en línea", 50000);

// GENERAR ESTADO DE CUENTA
generarEstadoDeCuenta($transacciones);
?>
