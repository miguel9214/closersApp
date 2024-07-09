<?php

namespace App\Services;

use Google_Client;
use Google_Service_Sheets;

class GoogleSheetsService
{
    protected $client;
    protected $service;
    protected $spreadsheetId;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('app/credentials.json'));
        $this->client->addScope(Google_Service_Sheets::SPREADSHEETS);
        $this->service = new Google_Service_Sheets($this->client);
        $this->spreadsheetId = '1lhc8TRpfLs00ClQoPU24Jj6Y7a6PiB9sWIVNWi9lwT0/edit?gid=0#gid=0'; // Reemplaza con tu propio ID
    }

    public function updateStatus($row, $status)
    {
        $range = "Sheet1!H{$row}"; // Suponiendo que la columna H contiene el campo "Closer"
        $values = [[ $status ]];
        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'RAW'
        ];
        $this->service->spreadsheets_values->update($this->spreadsheetId, $range, $body, $params);
    }

    public function logChange($row, $status)
    {
        $range = 'LogSheet!A1'; // Ajustar a la hoja y rango de registro
        $values = [[ date('Y-m-d H:i:s'), $row, $status ]];
        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'RAW',
            'insertDataOption' => 'INSERT_ROWS'
        ];
        $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, $params);
    }
}
