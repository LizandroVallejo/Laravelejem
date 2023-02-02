<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\Productos;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Http;
use SoapClient;
class UtilesController extends Controller
{

    function debuguear($variable){
      echo "    <pre>
      var_dump($variable);
    </pre>";
      exit;
    }
  
    public function utiles_inicio()
    { 
      return view('utiles.home' );
    }
    public function utiles_pdf()
    {
        #composer require mpdf/mpdf --with-all-dependencies
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML('<h1>Hello world!</h1><img src="https://www.tamila.cl/assets/img/logo_2.png" />');
        $mpdf->Output();
    }
    public function utiles_excel()
    {
        $helper = new Sample();
        if ($helper->isCli()) {
            $helper->log('This example should only be run from a Web Browser'. PHP_EOL );

            return;
        }
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('César Cancino')
            ->setLastModifiedBy('Tamila.cl')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Excel creado con PHP.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');

        $datos = Productos::orderBy('id', 'desc')->get();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Categoría')
            ->setCellValue('C1', 'Nombre')
            ->setCellValue('D1', 'Precio')
            ->setCellValue('E1', 'Stock')
            ->setCellValue('F1', 'Descripción')
            ->setCellValue('G1', 'Fecha');
        $i=2;
        foreach($datos as $dato)
        {
            
            $spreadsheet->getActiveSheet()
            ->setCellValue('A'.$i, $dato->id)
            ->setCellValue('B'.$i, $dato->categorias->nombre)
            ->setCellValue('C'.$i, $dato->nombre)
            ->setCellValue('D'.$i, $dato->precio)
            ->setCellValue('E'.$i, $dato->stock)
            ->setCellValue('F'.$i, $dato->descripcion)
            ->setCellValue('G'.$i, Helpers::invierte_fecha($dato->fecha));
            $i++;
        }
        

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Hoja 1');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte_'.date("Y-m-d H:i:s").'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
    public function utiles_cliente_rest()
    {
        $response = Http::get('http://192.168.21.1/clientes/tamila/clientes/pruebas/v1/productos') ;
        $datos = $response->object();
        $json = $response->body();
        $status = $response->status();
        $headers = $response->headers();
        return view('utiles.cliente_rest', compact('datos', 'status', 'headers', 'json'));
    }
    public function utiles_cliente_soap()
    {
        $cliente=new SoapClient("http://www.otravuelta.cl/soap/index.php?wsdl");
        $datos=  $cliente->retornarDatos("César", "info@tamila.cl", "+5696585454"); 
        return view('utiles.cliente_soap', compact('datos'));
     
    }
}
