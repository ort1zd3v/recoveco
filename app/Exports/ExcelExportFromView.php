<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExcelExportFromView implements FromView, WithColumnFormatting, WithColumnWidths, ShouldAutoSize
{
    protected $data;
    protected $view;
    protected $columnFormats;
    protected $columnWidths;
    protected $additionals;

    public function __construct($data, $view, $columnFormats = null, $columnWidths = null, $additionals = [])
    {
        $this->data = $data;
		$this->view = $view;
		$this->columnFormats = $columnFormats;
		$this->columnWidths = $columnWidths;
		$this->additionals = $additionals;

    }
    public function view(): View
    {
        return view($this->view, [
            'data' => $this->data,
			'additionals' => $this->additionals
        ])->with('numberFormat', NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    }

	public function columnFormats(): array
    {
        if ($this->columnFormats != null) {
			return $this->columnFormats;
		}
    }

	public function columnWidths(): array
    {
        if ($this->columnWidths != null) {
			return $this->columnWidths;
		}
    }
}