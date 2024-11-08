<?php
require('fpdf/fpdf.php');

// Función para eliminar acentos
function quitarAcentos($cadena) {
    $acentos = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', '¿', '¡');
    $sin_acentos = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N', '', '');
    return str_replace($acentos, $sin_acentos, $cadena);
}

// Recibir los datos del formulario
$pass_num = $_POST['pass_num'];
$pass_matricula = $_POST['pass_matricula'];
$pass_nombre = $_POST['pass_nombre'];
$pass_categoria = $_POST['pass_categoria'];
$pass_fecha = $_POST['pass_fecha'];
$pass_entrada = $_POST['pass_entrada'];
$pass_salida = $_POST['pass_salida'];
$pass_entrada2 = $_POST['pass_entrada2'];
$pass_salida2 = $_POST['pass_salida2'];
$pass_min = $_POST['pass_min'];
$pass_importe = $_POST['pass_importe'];
$pass_tipo_pase = $_POST['pass_tipo_pase'];
$pass_observaciones = $_POST['pass_observaciones'];

$inc_num = $_POST['inc_num'];
$inc_matricula = $_POST['inc_matricula'];
$inc_nombre = $_POST['inc_nombre'];
$inc_categoria = $_POST['inc_categoria'];
$inc_fecha = $_POST['inc_fecha'];
$inc_justificacion = $_POST['inc_justificacion'];
$inc_observaciones = $_POST['inc_observaciones'];

$ret_num = $_POST['ret_num'];
$ret_matricula = $_POST['ret_matricula'];
$ret_nombre = $_POST['ret_nombre'];
$ret_categoria = $_POST['ret_categoria'];
$ret_fecha = $_POST['ret_fecha'];
$ret_entrada = $_POST['ret_entrada'];
$ret_salida = $_POST['ret_salida'];
$ret_entrada2 = $_POST['ret_entrada2'];
$ret_salida2 = $_POST['ret_salida2'];
$ret_min = $_POST['ret_min'];
$ret_importe = $_POST['ret_importe'];
$ret_observaciones = $_POST['ret_observaciones'];

// Generar el PDF
class PDF extends FPDF {
    // Encabezado del PDF
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 6, 'INSTITUTO MEXICANO DEL SEGURO SOCIAL', 0, 1, 'C');
        $this->Cell(0, 6, 'DELEGACION ESTATAL EN YUCATAN', 0, 1, 'C');  // sin acentos
        $this->Cell(0, 6, 'JEFATURA DE SERVICIOS DE PRESTACIONES MEDICAS', 0, 1, 'C');  // sin acentos
        $this->Cell(0, 6, 'COORDINACION DE PLANEACION Y ENLACE INSTITUCIONAL', 0, 1, 'C');  // sin acentos
        $this->Cell(0, 6, 'ESCUELA DE ENFERMERIA INCORPORADA A LA U.A.D.Y.', 0, 1, 'C');  // sin acentos
        $this->Cell(0, 6, 'MICRO 011 U.M.A.A.', 0, 1, 'C');
        $this->Ln(10); // Espacio debajo del encabezado
    }

    // Pie de página del PDF
    function Footer() {
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 5);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');  // sin acento
    }

    // Función para crear una tabla
    function Tabla($header, $data) {
        $this->SetFont('Arial', 'B', 5);
        foreach($header as $col) {
            $this->Cell(18, 7, quitarAcentos($col), 1, 0, 'C');  // sin acentos
        }
        $this->Ln();

        $this->SetFont('Arial', '', 5);
        foreach($data as $row) {
            foreach($row as $cell) {
                $this->Cell(18, 7, quitarAcentos($cell), 1, 0, 'C');  // sin acentos
            }
            $this->Ln();
        }
    }
}

$pdf = new PDF('L');
$pdf->AddPage();

// Tabla de Pases Entrada-Salida
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 5, 'PASES ENTRADA-SALIDA', 0, 1, 'L');

$header1 = ['Nº', 'Matricula', 'Nombre', 'Categoria', 'Fecha', 'Entrada', 'Salida', 'Entrada', 'Salida', 'Min', 'Importe', 'Tipo de Pase', 'Observaciones'];
$data1 = [];
for ($i = 0; $i < count($pass_num); $i++) {
    $data1[] = [
        quitarAcentos($pass_num[$i]),
        quitarAcentos($pass_matricula[$i]),
        quitarAcentos($pass_nombre[$i]),
        quitarAcentos($pass_categoria[$i]),
        quitarAcentos($pass_fecha[$i]),
        quitarAcentos($pass_entrada[$i]),
        quitarAcentos($pass_salida[$i]),
        quitarAcentos($pass_entrada2[$i]),
        quitarAcentos($pass_salida2[$i]),
        quitarAcentos($pass_min[$i]),
        quitarAcentos($pass_importe[$i]),
        quitarAcentos($pass_tipo_pase[$i]),
        quitarAcentos($pass_observaciones[$i])
    ];
}
$pdf->Tabla($header1, $data1);
$pdf->Ln(10);

// Tabla de Incidencias Diarias
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 5, 'INCIDENCIAS DIARIAS', 0, 1, 'L');

$header2 = ['Nº', 'Matricula', 'Nombre', 'Categoria', 'Fecha', 'Justificacion', 'Observaciones'];
$data2 = [];
for ($i = 0; $i < count($inc_num); $i++) {
    $data2[] = [
        quitarAcentos($inc_num[$i]),
        quitarAcentos($inc_matricula[$i]),
        quitarAcentos($inc_nombre[$i]),
        quitarAcentos($inc_categoria[$i]),
        quitarAcentos($inc_fecha[$i]),
        quitarAcentos($inc_justificacion[$i]),
        quitarAcentos($inc_observaciones[$i])
    ];
}
$pdf->Tabla($header2, $data2);
$pdf->Ln(10);

// Tabla de Retardos
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 5, 'RETARDOS', 0, 1, 'L');

$header3 = ['Nº', 'Matricula', 'Nombre', 'Categoria', 'Fecha', 'Entrada', 'Salida', 'Entrada', 'Salida', 'Min', 'Importe', 'Observaciones'];
$data3 = [];
for ($i = 0; $i < count($ret_num); $i++) {
    $data3[] = [
        quitarAcentos($ret_num[$i]),
        quitarAcentos($ret_matricula[$i]),
        quitarAcentos($ret_nombre[$i]),
        quitarAcentos($ret_categoria[$i]),
        quitarAcentos($ret_fecha[$i]),
        quitarAcentos($ret_entrada[$i]),
        quitarAcentos($ret_salida[$i]),
        quitarAcentos($ret_entrada2[$i]),
        quitarAcentos($ret_salida2[$i]),
        quitarAcentos($ret_min[$i]),
        quitarAcentos($ret_importe[$i]),
        quitarAcentos($ret_observaciones[$i])
    ];
}
$pdf->Tabla($header3, $data3);

// Salida del PDF
$pdf->Output();
?>
