<?php

class PdfList
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function generatePdf($idPedido)
    {
        require ('../../libraries/fpdf/fpdf.php');
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        // Obtener información de la lista de compras
        $query = "SELECT l.*, u.nombreCompleto 
                  FROM listascompras l 
                  JOIN usuarios u ON l.idEmpleado = u.idEmpleado 
                  WHERE l.idPedido = $idPedido";
        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            die("Error al obtener la lista de compras: " . mysqli_error($this->connection));
        }

        $listData = mysqli_fetch_assoc($result);

        if (!$listData) {
            die("No se encontró la lista de compras con su ID pedido");
        }

        // Obtener detalles de la lista de compras
        $queryDetails = "SELECT d.productoDetallePedido, d.categoriaProductoPedido, d.cantidadProductoPedido 
                 FROM detallecompras d 
                 WHERE d.idPedido = $idPedido";
        $resultDetails = mysqli_query($this->connection, $queryDetails);

        if (!$resultDetails) {
            die("Error al obtener los detalles de la lista " . mysqli_error($this->connection));
        }

        $pdf->SetTitle('Lista de Compras # ' . $idPedido);
        $pdf->SetFont('Arial', 'B', 16);
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/programDental/img/logoFavicon.jpg';
        $pdf->Image($imagePath, 24, 10, 10, 10);
        $pdf->Cell(200, 10, utf8_decode('DentoSalud Centro Médico & Dental - Lista de Compras'), 0, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(190, 10, utf8_decode('Teléfono: 8701-8719'), 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(44.7, 10, utf8_decode('Número de Pedido: '), 0, 0, 'R');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 10, $idPedido, 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(35.2, 10, utf8_decode('Realizado por: '), 0, 0, 'R');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(80, 10, utf8_decode($listData['nombreCompleto']), 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(41, 10, utf8_decode('Fecha de Pedido: '), 0, 0, 'R');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(117, 10, utf8_decode($listData['fechaPedido']), 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(53.5, 10, utf8_decode('Descripción de la Lista: '), 0, 0, 'R');
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(140, 10, utf8_decode($listData['descripcionLista']), 0, 'L');  // Ajuste aquí
        $pdf->Ln();

        // Encabezado de detalle de productos
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(63.5, 20, utf8_decode('Nombre de Producto'), 1, 0, 'C');
        $pdf->Cell(63.5, 20, utf8_decode('Categoría'), 1, 0, 'C');
        $pdf->Cell(63.5, 20, utf8_decode('Cantidad'), 1, 1, 'C');

        // Datos de detalle de productos
        while ($row = mysqli_fetch_assoc($resultDetails)) {
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(63.5, 10, utf8_decode($row['productoDetallePedido']), 1, 0, 'C');
            $pdf->Cell(63.5, 10, utf8_decode($row['categoriaProductoPedido']), 1, 0, 'C');
            $pdf->Cell(63.5, 10, utf8_decode($row['cantidadProductoPedido']), 1, 1, 'C');
        }
        // Para que se abra el archivo en una pestaña distinta, y que al descargar, ponga nombre y el id pedido
        $pdf->Output('I', 'listacompras#' . $idPedido . '-dentosalud' . '.pdf');
    }
}

include (__DIR__ . "/../../model/connectiondb.php");

if (isset($_GET['generatePdf']) && $_GET['generatePdf'] == "true" && isset($_GET['idPedido'])) {
    $pdfList = new PdfList($connection);
    $pdfList->generatePdf($_GET['idPedido']);
} else {
    echo "No se proporcionó un ID de pedido para la lista de compras";
}
?>