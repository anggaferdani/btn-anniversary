<?php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class ParticipantExport implements FromCollection, WithHeadings, WithDrawings
{
//    protected $eventId;
//    protected $filter;

    function __construct()
    {
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Participant::where("status", 1)->with('instansi')->whereNotNull("qrcode")->get()
            ->map(function ($participant) {
                return [
                    'Kode' => $participant->qrcode,
                    'Nama' => $participant->name,
                    "Instansi" => $participant->instansi->name,
                    "QRCODE" => ""
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nama',
            'Instansi',
            'QRCODE',
        ];
    }

    public function drawings()
    {

        $drawings = [];
        $participants = Participant::where("status", 1)->whereNotNull("qrcode")->get();

        foreach ($participants as $index => $participant) {
            try {
                $imageUrl = 'https://quickchart.io/qr?text=' . urlencode($participant->qrcode);
                $imageContent = file_get_contents($imageUrl);

                if ($imageContent === false) {
                    throw new \Exception('Failed to fetch the image content.');
                }

                $imageResource = @imagecreatefromstring($imageContent);

                if ($imageResource === false) {
                    throw new \Exception('The image URL cannot be converted into an image resource.');
                }

                $drawing = new MemoryDrawing();
                $drawing->setName($participant->name);
                $drawing->setDescription('QRCODE');
                $drawing->setImageResource($imageResource);
                $drawing->setHeight(90);
                $drawing->setCoordinates('D' . ($index + 2)); // Position image in column D according to row
                $drawings[] = $drawing;
            } catch (\Exception $e) {
                // Log the error or handle it as needed
                error_log($e->getMessage());
            }
        }

        return $drawings;
    }

}
