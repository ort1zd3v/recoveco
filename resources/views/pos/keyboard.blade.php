<div class="row row-cols-3 g-2" id="calculator">
	@for ($i = 1; $i < 10; $i++)
		<div class="col">
			<div class="p-2 number text-center font-size-24" onclick="addNumber('{{ $target ?? '.amount' }}', {{$i}})">{{$i}}</div>
		</div>
	@endfor
	<div class="col">
		<div class="p-2 number text-center font-size-24">#</div>
	</div>
	<div class="col">
		<div class="p-2 number text-center font-size-24" onclick="addNumber('{{ $target ?? '.amount' }}', 0)">0</div>
	</div>
	<div class="col">
		<div class="p-2 number text-center font-size-24" onclick="offNumber('{{ $target ?? '.amount' }}')"><i class='bx bxs-left-arrow-circle' ></i></div>
	</div>
	
</div>