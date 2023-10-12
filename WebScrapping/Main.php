<?php

namespace Chuva\Php\WebScrapping;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Main {

  public static function run(): void {
    $dom = new \DOMDocument('1.0', 'utf-8');
    $dom->loadHTMLFile(__DIR__ . '/../../assets/origin.html');

    $data = (new Scrapper())->scrap($dom);

    // Criar uma instância de PhpSpreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Adicionar os dados extraídos à planilha
    $row = 1;
    foreach ($data as $item) {
        $sheet->setCellValue('A' . $row, $item['campo1']);
        $sheet->setCellValue('B' . $row, $item['campo2']);
        // Adicione mais colunas conforme necessário
        $row++;
    }

    // Salvar a planilha em um arquivo
    $writer = new Xlsx($spreadsheet);
    $outputFile = __DIR__ . '/../../assets/output.xlsx';
    $writer->save($outputFile);

    echo "Os dados foram salvos em $outputFile";
  }

}
