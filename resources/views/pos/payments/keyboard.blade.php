<div class="row row-cols-3 g-2 mt-1" id="calculator">
	@for ($i = 1; $i < 10; $i++)
		<div class="col">
			<div class="p-3 number text-center font-size-16" onclick="addNumberPayment({{$i}})">{{$i}}</div>
		</div>
	@endfor
	<div class="col">
		<div class="p-3 number text-center font-size-16"><i class='bx bxs-user-circle'></i></div>
	</div>
	<div class="col">
		<div class="p-3 number text-center font-size-16" onclick="addNumberPayment(0)">0</div>
	</div>
	<div class="col">
		<div class="p-3 number text-center font-size-16" onclick="offNumberPayment()"><i class='bx bxs-left-arrow-circle' ></i></div>
	</div>
</div>