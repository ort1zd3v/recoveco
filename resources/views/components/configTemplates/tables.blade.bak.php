<style>
	.datatablePreview  {
		overflow: auto;
		width: 100%;
	}
	.datatablePreview table {
		width: 100%;
		table-layout: fixed;
		border-collapse: collapse;
		border-spacing: 1px;
		text-align: left;
	}
	.datatablePreview caption {
		caption-side: top;
		text-align: left;
	}
	.datatablePreview th {
		@php
			$rgb = explode(",", $template->datatables_header_backround_color);
			$r = intval($rgb[0]);
			$g = intval($rgb[1]);
			$b = intval($rgb[2]);
		@endphp
		background-color: {{ sprintf("#%02x%02x%02x", $r, $g, $b) ?? "#ffffff"}};
		color: {{$template->datatables_header_font_color ?? "#ffffff"}};
		padding: 5px;
		font-size: 12px
	}
	.datatablePreview td {
		background-color: #FFFFFF;
		color: #000000;
		padding: 5px;
		font-size: 11px;
	}

	.datatablePreview td .icon-edit {
		color: {{$template->datatables_edit_font_color ?? "#ffffff"}};
	}
	.datatablePreview td .icon-delete {
		color: {{$template->datatables_delete_font_color ?? "#ffffff"}};
	}

	#btnAddPreview {
		margin-bottom: 8px;
		font-size: 10px;
		padding: 5px;
		border-radius: 5px;
		float: right !important;
		cursor: pointer;
		background-color: {{$template->datatables_add_background_color ?? "#ffffff"}};
		color: {{$template->datatables_add_font_color ?? "#ffffff"}};
	}

	#btnPagePreview {
		padding-right: 4px;
		padding-left: 4px;
		font-size: 10px;
		border-radius: 50%;
		float: right !important;
		display: inline-block;
		cursor: pointer;
		margin-top: 10px;
		margin-right: 10px;
		background-color: {{$template->datatables_add_background_color ?? "#ffffff"}};
		color: {{$template->datatables_add_font_color ?? "#ffffff"}};
	}

</style>
<div class="p-2 bg-white h-75">
	<span id="btnAddPreview">+ Agregar</span>
	<div class="datatablePreview" role="region" tabindex="0">
		<table>
			<thead id="datatableHeaderPreview">
				<tr class="border-bottom">
					<th>Header 1</th>
					<th>Header 2</th>
					<th>Header 3</th>
				</tr>
			</thead>
			<tbody id="datatableBodyPreview">
				<tr class="border-bottom">
					<td>Text</td>
					<td>Text</td>
					<td>
						<i class="mdi mdi-pencil icon-edit font-size-18"></i>
						<i class="mdi mdi-delete icon-delete font-size-18"></i>
					</td>
				</tr>
				<tr class="border-bottom">
					<td>Text</td>
					<td>Text</td>
					<td>
						<i class="mdi mdi-pencil icon-edit font-size-18"></i>
						<i class="mdi mdi-delete icon-delete font-size-18"></i>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<span id="btnPagePreview">1</span>
</div>