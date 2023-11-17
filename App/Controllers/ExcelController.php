<?php

namespace App\Controllers;

use Slim\Http\Response;
use Slim\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController
{
    private $view;

    public function __construct($container)
    {
        $this->view = $container->get('view');
    }

    public function renderImportarExcel(Request $request, Response $response, array $args): Response
    {
        // Exibe a página inicial para importar o Excel
        return $this->view->render($response, 'importarexcel.html');
    }
    
    public function importarExcel($request, $response, $args)
    {
        // Obtenha o arquivo enviado no formulário
        $uploadedFile = $request->getUploadedFiles()['excelFile'];

        // Verifique se um arquivo foi enviado
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            // Salve o arquivo temporário
            $uploadedFilePath = 'C:/xampp/htdocs/importacaoDev/php-slim-js/tmp/' . $uploadedFile->getClientFilename();
            $uploadedFile->moveTo($uploadedFilePath);

            // Processe o arquivo Excel
            $spreadsheet = IOFactory::load($uploadedFilePath);
            $sheet = $spreadsheet->getActiveSheet();

            // Inicialize um array para armazenar os dados do Excel
            $excelData = [];

            // Obtém o cabeçalho (primeira linha) para mapear as colunas
            $headerRow = $sheet->getRowIterator()->current();
            $cellIterator = $headerRow->getCellIterator();

            // Inicializa um array para mapear as colunas pelo nome
            $columnMap = [];

            foreach ($cellIterator as $cell) {
                $columnName = $cell->getValue();
                $columnIndex = $cell->getColumn();
                $columnMap[$columnName] = $columnIndex;
            }

            // Itera sobre as linhas do Excel (ignorando o cabeçalho)
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                if ($rowIndex === 1) {
                    // Ignora a primeira linha (cabeçalho)
                    continue;
                }
            
                // Obtém os valores das colunas usando o mapeamento pelo nome
                $nome = $sheet->getCell($columnMap['nome'] . $row->getRowIndex())->getValue();
                $endereco = $sheet->getCell($columnMap['endereco'] . $row->getRowIndex())->getValue();
            
                // Adiciona os dados ao array
                $excelData[] = [
                    'nome' => $nome,
                    'endereco' => $endereco,
                ];
            }

            // Exclua o arquivo temporário após o processamento
            unlink($uploadedFilePath);

            // Exibe os dados do Excel na tela
            return $this->view->render($response, 'importarexcel.html', ['excelData' => $excelData]);
        } else {
            // O upload do arquivo falhou, retorne uma resposta de erro
            return $response->withStatus(400)->withJson(['error' => 'Upload do arquivo falhou']);
        }
    }
}
