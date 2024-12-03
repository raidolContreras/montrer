<?php
require_once "../forms.controller.php";
require_once "../../model/forms.models.php";
require '../../assets/vendor/PHP/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Verificar si se enviaron las fechas
if (!isset($_POST['startDate']) || !isset($_POST['endDate'])) {
    http_response_code(400);
    die("Las fechas de inicio y término son obligatorias.");
}

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$context = (isset($_POST['context'])) ? $_POST['context'] : null;

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate)) {
    http_response_code(400);
    die("Formato de fecha inválido.");
}

// Obtener los datos desde el modelo
$data = FormsController::ctrGetReports($startDate, $endDate, $context);

// Crear un nuevo objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$headers = [
    'FOLIO', 'SOLICITANTE', 'PROVEEDOR', 'CONCEPTO DE PAGO', 'MONTO', 'MONTO PAGADO',
    'FECHA INGRESO', 'FECHA COMPROMISO', 'FECHA DE PAGO', 'BANCO', 'CLABE',
    'CUENTA CARGO', 'CUENTA ABONO', 'ESTATUS'
];

// Estilo para encabezados
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '0073AA']
    ],
    'alignment' => ['horizontal' => 'center', 'vertical' => 'center']
];

// Insertar encabezados y aplicar estilo
$sheet->fromArray($headers, NULL, 'A1');
$sheet->getStyle('A1:' . chr(64 + count($headers)) . '1')->applyFromArray($headerStyle);
$sheet->getRowDimension('1')->setRowHeight(30);

// Función para determinar el estatus
function getStatus($statusBudgetRequest, $active, $pagado)
{
    if (!is_null($statusBudgetRequest)) {
        switch ($statusBudgetRequest) {
            case 0: return "No respondido";
            case 1: return "Aprobado";
            case 2: return "Envió de comprobante";
            case 3: return "Rechazado";
            case 4: return "Denegado el comprobante";
            case 5: return "Aprobado el comprobante";
        }
    }

    if (is_null($active)) {
        return "No respondido";
    } elseif ($active == 1 && $pagado == 0) {
        return "Pendiente de pago";
    } elseif ($active == 1 && $pagado == 1) {
        return "Aprobado sin comprobar";
    } elseif ($active == 0 && $pagado == 1) {
        return "Finalizado";
    }

    return "Rechazado"; // Valor predeterminado en caso de error
}

// Insertar datos
$row = 2;
$totalSolicitudes = 0;

foreach ($data as $record) {
    $sheet->setCellValue("A{$row}", $record['folio'] ?? '');
    $sheet->setCellValue("B{$row}", $record['solicitante_nombre'] ?? '');
    $sheet->setCellValue("C{$row}", $record['account_holder'] ?? '');
    $sheet->setCellValue("D{$row}", $record['concepto_pago'] ?? '');
    $sheet->setCellValue("E{$row}", $record['importe_solicitado'] ?? 0);
    $sheet->getStyle("E{$row}")->getNumberFormat()->setFormatCode('$#,##0.00');
    $sheet->setCellValue("F{$row}", $record['abono'] ?? 0);
    $sheet->getStyle("F{$row}")->getNumberFormat()->setFormatCode('$#,##0.00');
    $sheet->setCellValue("G{$row}", $record['requestDate'] ?? '');
    $sheet->setCellValue("H{$row}", $record['fecha_pago'] ?? '');
    $sheet->setCellValue("I{$row}", $record['paymentDate'] ?? '');
    $sheet->setCellValue("J{$row}", $record['banco'] ?? '');
    $sheet->setCellValueExplicit("K{$row}", $record['clabe'] ?? '', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $sheet->setCellValue("L{$row}", $record['cuentaAfectada'] ?? '');
    $sheet->setCellValue("M{$row}", $record['partidaAfectada'] ?? '');

    // Determinar estatus
    $status = getStatus($record['statusBudgetRequest'] ?? null, $record['active'] ?? null, $record['pagado'] ?? null);
    $sheet->setCellValue("N{$row}", $status);

    // Sumar el monto de las solicitudes
    $totalSolicitudes += $record['cargo'] ?? 0;
    $row++;
}

// Agregar fila de totales
$sheet->setCellValue("D{$row}", 'TOTAL SOLICITUDES EN TRANSITO');
$sheet->mergeCells("D{$row}:E{$row}"); // Combinar celdas
$sheet->setCellValue("F{$row}", $totalSolicitudes); // Total calculado
$sheet->getStyle("F{$row}")->getNumberFormat()->setFormatCode('$#,##0.00');

// Aplicar estilo a la fila de totales
$totalStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '28A745'] // Verde
    ],
    'alignment' => ['horizontal' => 'center', 'vertical' => 'center']
];
$sheet->getStyle("D{$row}:F{$row}")->applyFromArray($totalStyle);

// Ajustar el ancho de las columnas automáticamente
foreach (range('A', 'N') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Bordes para las celdas con datos
$dataRange = 'A1:N' . $row;
$sheet->getStyle($dataRange)->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb' => '000000']
        ]
    ]
]);

// Configurar encabezados para la descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte_Concentrado_Solicitudes.xlsx"');
header('Cache-Control: max-age=0');

// Generar el archivo Excel
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
