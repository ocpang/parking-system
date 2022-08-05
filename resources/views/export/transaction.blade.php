<!DOCTYPE html>
<html>
<head>
	<title>INDOSTATION - Claimed Voucher</title>
</head>
<body>

	<div class="container">
		<table border="2">
			<thead style="background:#d1d1d1;">
				<tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Vehicle No</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Hours</th>
                    <th>Price per hour</th>
                    <th>Total</th>
                    <th>User Created</th>
                    <th>User Updated</th>
                    <th>Time Created</th>
                    <th>Time Updated</th>
				</tr>
			</thead>
			<tbody>
				@php $i=1 @endphp
				@foreach($model as $value)
                    <?php
                        $check_out = "";
                        if($value->check_out != ""){
                            $check_out = date("d-m-Y H:i:s", strtotime($value->check_out));
                        }
                    ?>
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$value->code}}</td>
                        <td>{{$value->vehicle_no}}</td>
                        <td>{{date("d-m-Y H:i:s", strtotime($value->check_in))}}</td>
                        <td>{{$check_out}}</td>
                        <td>{{number_format($value->hours)}}</td>
                        <td>{{number_format($value->price)}}</td>
                        <td>{{number_format($value->total)}}</td>
                        <td>{{ucwords($value->user_name)}}</td>
                        <td>{{ucwords($value->up_user_name)}}</td>
                        <td>{{date("d-m-Y H:i:s", strtotime($value->created_at))}}</td>
                        <td>{{date("d-m-Y H:i:s", strtotime($value->updated_at))}}</td>
				    </tr>
				@endforeach
			</tbody>
		</table>

	</div>

</body>
</html>