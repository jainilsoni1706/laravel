<div class="col-sm-4">
						<label>Country</label>
						<select name="country" id="xcountryx" class="form-control onChangeCountry select1">
							@forelse(DB::table('countries')->get() as $country)
								@if($loop->first)
								<option disabled selected>--- Select a Country ---</option>
								@endif
								<option value="{{ $country->id }}" class="{{ $country->id }}"> {{ $country->name }} </option>
							@empty
								<option disabled selected>--- No Data ---</option>
							@endforelse
						</select>
					</div>

					<div class="col-sm-4">
						<label>State</label>
						<select name="state" id="xstatex" class="form-control onChangeState select1">
							@forelse(DB::table('states')->where('country_id',101)->get() as $state)
								@if($loop->first)
								<option disabled selected>--- Select a State ---</option>
								@endif
								<option value="{{ $state->id }}" class="{{ $state->id }}" > {{ $state->name }} </option>
							@empty
								<option disabled selected>--- No Data ---</option>
							@endforelse
						</select>
					</div>

					<div class="col-sm-4">
						<label>City</label>
						<select name="city" id="xcityx" class="form-control onChangeCity select1">
							@forelse(DB::table('cities')->where('state_id',4030)->get() as $city)
								@if($loop->first)
								<option disabled selected>--- Select a City ---</option>
								@endif
								<option value="{{ $city->id }}" class="{{ $city->id }}" > {{ $city->name }} </option>
							@empty
								<option disabled selected>--- No Data ---</option>
							@endforelse
						</select>
					</div>
          
          
          
          

<script>

$('.onChangeCountry').on('change',function(){

	$('.onChangeState').empty();
	$('.onChangeCity').empty();

//get all state
$.ajax({
	type: "GET",
	url: "{{ url('getallstatelist') }}",
	data: {
		country: $(this).val(),
	},
	dataType: 'json',
	success: function(data)
	{
		$('.removable-option-tag').remove();
		data.forEach(element => {
		$('.onChangeState').append("<option class='removable-option-tag' value='" + element.id + "'> " + element.name + " </option>");                    
		});
	}
});

});



$('.onChangeState').on('change',function(){
 //get all city
 $.ajax({
	type: "GET",
	url: "{{ url('getallcitylist') }}",
	data: {
		state: $(this).val(),
	},
	dataType: 'json',
	success: function(data)
	{
		$('.removable-option-tag-2').remove();
		data.forEach(element => {
		$('.onChangeCity').append("<option class='removable-option-tag-2' value='" + element.id + "'> " + element.name + " </option>");                    
		});
	}
});
});

</script>
