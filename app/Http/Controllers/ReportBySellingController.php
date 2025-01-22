<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ReportBySellingDataTable;
use App\Services\PaymentService;
use App\Models\Payment;
use App\Models\SellingRow;
use App\Exports\ExcelExportFromView;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\DB;

class ReportBySellingController extends Controller
{
    public function index()
	{
		return (new ReportBySellingDataTable())->render('reports.report-by-sellings');
	}

	public function exportExcel()
	{
		$query = SellingRow::select(
			DB::raw('suppliers.id as supplier_id'),
			DB::raw('suppliers.name as supplier_name'),
			DB::raw('suppliers.commission_percentage as commission_percentage'),
			DB::raw('SUM(selling_rows.total_price) as total'),
			DB::raw('SUM((selling_rows.total_price * COALESCE(selling_rows.commission_percentage, 100) / 100)) as net_sales'),
			DB::raw('SUM(selling_rows.total_price - (selling_rows.total_price * COALESCE(selling_rows.commission_percentage, 100) / 100)) as commissions'),
		);
		$query->where('selling_rows.is_active', 1)
			->where('suppliers.name', '<>', 'null')
			
			->leftJoin('products', 'selling_rows.product_id', '=', 'products.id')
			->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
			->groupBy('suppliers.id')
			->newQuery();

		if (request('initial_date') != 0) {
			$query->where('selling_rows.created_at','>=', request('initial_date'));
		}
		if (request('final_date') != 0) {
			$query->where('selling_rows.created_at','<=' ,request('final_date')." 23:59:59");
		}
		if (request('supplier_name') != null) {
			$query->where('suppliers.name','like', "%".request('supplier_name')."%")
					->orWhere('suppliers.id','like', "%".request('supplier_name')."%");
		}

		$suppliers = $query->get();


		foreach ($suppliers as $supplier){
			$query = SellingRow::select(
				'suppliers.id as supplier_id',
				'suppliers.name as supplier_name',
				'sellings.id as selling_id',
				'selling_rows.created_at as created_at',
				'products.name as product_name',
				'selling_rows.amount as amount',
				'selling_rows.unit_price as unit_price',
				'selling_rows.total_price as total_price',
			);
			$query->where('selling_rows.is_active', 1)
			->where('products.supplier_id', $supplier->supplier_id)
			->leftJoin('sellings', 'selling_rows.selling_id', '=', 'sellings.id')
			->leftJoin('products', 'selling_rows.product_id', '=', 'products.id')
			->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
			->newQuery();
	
			if (request('supplier_name') != null) {
				$query->where('suppliers.name','like', "%".request('supplier_name')."%")
					->orWhere('suppliers.id','like', "%".request('supplier_name')."%");
			}
			if (request('product_name') != null) {
				$query->where('products.name','like' , "%".request('product_name')."%");
			}
			if (request('selling_id') != null) {
				$query->where('sellings.id', request('selling_id'));
			}
	
			if(request('initial_date') !== null && request('final_date') !== null){
				$query->where('selling_rows.created_at','>=' ,request('initial_date'))
					->where('selling_rows.created_at','<=' ,request('final_date')." 23:59:59");
			}
	
			$supplier->products = $query->get();
		}


		$columnFormats = [
			'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 . ' $',
			'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 . ' $',
			'D' => NumberFormat::FORMAT_DATE_DDMMYYYY
		];

		$columnWidth = [
			"E" => 50
		];

		$additionals = [
			'initial_date' => date("d/m/Y", strtotime(request('initial_date'))),
			'final_date' => date("d/m/Y", strtotime(request('final_date'))),
			'name' => 'elrecoveco',
		];

		// return view('excel-report-views.report_excel_by_sellings', compact('suppliers','columnFormats', 'columnWidth', 'additionals'));
		return Excel::download(new ExcelExportFromView($suppliers, 'excel-report-views.report_excel_by_sellings', $columnFormats, $columnWidth, $additionals), 'products_by_sellings.xlsx');
	}
}
