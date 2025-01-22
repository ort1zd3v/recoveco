<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ReportBySupplierDataTable;
use App\DataTables\ReportBySupplierDetailDataTable;
use App\Traits\MonthTrait;
use App\Services\PaymentService;
use App\Models\Supplier;
use App\Models\SellingRow;
use Illuminate\Support\Facades\DB;
use App\Exports\ExcelExportFromView;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReportBySupplierController extends Controller
{
	use MonthTrait;

    public function index()
	{
		$year = null; //para indicar que todos los años
		return (new ReportBySupplierDataTable())->render('reports.report-by-supplier', compact('year'));
	}

	public function getSupplierDetail($supplier_id, $initial_date, $final_date)
	{
		$supplier = Supplier::find($supplier_id);
		return (new ReportBySupplierDetailDataTable($supplier, $initial_date, $final_date))->render('reports.report-supplier-detail', compact('supplier', 'initial_date','final_date'));
	}

	public function exportExcel()
	{
		$query = SellingRow::select(
			DB::raw('suppliers.id as supplier_id'),
			DB::raw('suppliers.name as supplier_name'),
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
			$query->where('suppliers.name','like' , "%".request('supplier_name')."%");
		}
		if (request('is_active') == 0) {
			$query->where('suppliers.is_active', 1);
		}

		$suppliers = $query->get();


		foreach ($suppliers as $supplier){
			$query = SellingRow::selectRaw(
				'
				 products.name as product_id,
				 SUM(selling_rows.amount) as total_amount,
				 SUM(selling_rows.total_price) as total_product_amount,
				 selling_rows.commission_percentage as commission_percentage,
				 SUM(selling_rows.total_price) * (COALESCE(selling_rows.commission_percentage, 1)/100) as commission,
				 SUM(selling_rows.total_price) - (SUM(selling_rows.total_price) * (COALESCE(selling_rows.commission_percentage, 1)/100)) as commission2
				'
			);
			
			$query->where('products.supplier_id', $supplier->supplier_id)
			->where('selling_rows.is_active', 1)
			->where('selling_rows.total_price', '<>', 0)
			->leftjoin('products', 'selling_rows.product_id', '=', 'products.id')
			->leftjoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
			->orderBy('total_product_amount', 'desc')
			->groupBy('products.name','product_id','products.supplier_id', 'selling_rows.commission_percentage')
			->newQuery();

			if (request('initial_date') != 0) {
				$query->where('selling_rows.created_at','>=', request('initial_date'));
			}
			if (request('final_date') != 0) {
				$query->where('selling_rows.created_at','<=' ,request('final_date')." 23:59:59");
			}
			if (request('supplier_name') != null) {
				$query->where('suppliers.name','like' , "%".request('supplier_name')."%");
			}
			if (request('is_active') == 0) {
				$query->where('suppliers.is_active', 1);
			}
	
			$supplier->products = $query->get();
		}

		// $data = $suppliers;
		// return view('excel-report-views.report_excel_by_suppliers', compact('data'));

		$columnFormats = [
			'B' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
			'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 . ' $',
			'D' => NumberFormat::FORMAT_PERCENTAGE_00,
			'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 . ' $',
			'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 . ' $',
		];

		$columnWidth = [
			'A' => 50,
		];

		$additionals = [
			'initial_date' => date("d/m/Y", strtotime(request('initial_date'))),
			'final_date' => date("d/m/Y", strtotime(request('final_date'))),
			'name' => 'elrecoveco',
		];

		return Excel::download(new ExcelExportFromView($suppliers, 'excel-report-views.report_excel_by_suppliers', $columnFormats, $columnWidth, $additionals), 'products_by_supplier.xlsx');

	}

	
	
}
