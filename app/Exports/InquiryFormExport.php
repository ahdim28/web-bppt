<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class InquiryFormExport implements 
    FromView,
    WithEvents
{
    use Exportable;

    protected $inquiry, $form;

    public function __construct($inquiry, $form)
    {
        $this->inquiry = $inquiry;
        $this->form = $form;
    }

    public function view(): View
    {
        $inquiry = $this->inquiry;

        return view('backend.inquiries.forms.export', [
            'inquiry' => $inquiry,
            'form' => $this->form
        ]);
    }

    /**
     * menambahkan style untuk excel
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $styleHeader = [
                    'font' => [
                        'bold' => true,
                        'size' => 12
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $styleContent = [
                    'borders' => [
                        'font' => [
                            'size' => 12
                        ],
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                $styleTotalSistem = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                    ],
                ];
            },
        ];
    }
}
