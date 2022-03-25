</!DOCTYPE html>
<html>
<head>
	<title>List Gas Xang</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">

	<!-- <link rel="stylesheet" href="http://127.0.0.1:8000/app/resources/css/gas_list.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

	<style type="text/css">
		body  
{  
    margin: 0;  
    padding: 0;  
    background-color:white;  
    font-family: 'Arial';  
}  
.func_list{  
        width: 600px;  
        margin: auto; 
        margin-bottom: 15px; 
        padding: 20px;  
        background: #afafaf;  
        border-radius: 15px ;  
          
}  
h4{  
    text-align: center;  
    color: black;       
}  
label{  
	margin-top: 18px;
    margin-left: 20px;
    font-size: 17px;  
}  
button{  
    width: 120px;  
    height: 35px;  
    border: none;  
    border-radius: 8px;  
    padding-left: 7px;
    background-color: #309fe1;  
    margin-left: 208px;
    color: #FFF;
    font-weight:bold;
  
}  
.btn-map{
	position: absolute;
    width: 120px;
    height: 42px;
    margin-left: 450px;
    margin-top: -10px;
}
.btn-add{
	margin-left: 69px;
	margin-top: 10px;
    width: 165px;
    height: 42px;
}
a{  
   float: right;  
   background-color: black;  
}
.alert{
  color:red;
      margin-left: 110px;
    margin-bottom: -25px;
}  
.searchlayout{
    margin-left: 50px;
    margin-top: 35px;
}
.namegas{
	margin-left: 25px;
    width: 230;
}
.checkmark {
  height: 25px;
  width: 25px;
  background-color: #eee;
  margin-left: 15px;
}
.gastype{
	margin-top: 15px;
    float: right;
    margin-right: 142px;
}
.s_dist{
	margin-left: 145px;
    width: 230px;
    height: 28px;
}
span{
	font-weight: bold;
    font-size: 22px;
    padding-left: 20px;
}
.input_add{
    margin-left:  13px;width: 230;
  }
  .type_add {
    height: 25px;
    width: 25px;
    background-color: #eee;
    margin-left: 0px;

}
.type_long {
    margin-left:  87px;width: 230;}
    .type_lati {
    margin-left:  115px;width: 230;}
    .s_dist_add {
    margin-left: 131px;
    width: 230px;
    height: 28px;
}
	</style>
</head>
<body>
	<div class="func_list">
		<div class='title'>
			<button class="btn-map">マップ</button> 
			<h4>ガソリンスタンド一覧</h4>
			</div>
		
		<form class="searchlayout"  action="http://localhost/GasStation1/public/search" method="post">
			@csrf
	    <label><b>ガソリンスタンド名:</b></label>
	    <input class="namegas" type="text" name="gasname" id="gasname" ><br>

	    <div style="margin-bottom: -20px;">
	    	<label style="float: left;"><b>種類:</b></label>
	    	<div class="table" style="padding-top: 15px;padding-left: 193px;">
	    		<tr>
	    		@foreach($gastype as $gasT)
	    		<td>
	  		 	<input class="checkmark" type="checkbox"  name="gastype[]" 
	  		 	value="{{$gasT->TypeCode}}"><span>{{$gasT->TypeText}}</span> 
	  		 	</td>
	  			@endforeach
	  			</tr>
	    	</div>
	    </div>
	    <label><b>地区:</b></label>
	    	<select class="s_dist" name="dist" id="dist" value="">
	  		 <option value=""></option>
	  		@foreach($district as $dst)
	  		 <option value="{{$dst->DistrictName}}">{{$dst->DistrictName}}</option>
	  		@endforeach
	  	</select>
	    <br>
        <button type="submit">検索</button></form>
        <button class="btn-add" type="button"  data-toggle="modal" data-target="#Modal_add">登録</button></div></div>
        

	<div class="list">
		<table class="table"></div>		
  <thead>
  	<tr>
      <th scope="col">番号 </th>
      <th scope="col">ガソリンスタンド名</th>
      <th scope="col">種類</th>
      <th scope="col">地区</th>
      <th scope="col">Longitude,Latitude</th>
      <th scope="col">評価</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  	@foreach($gaslist as $gasl)
    <tr>
      <th scope="row">{{$gasl->GasStationId}}</th>
      <td>{{$gasl->GasStationName}}</td>
      <td>{{$gasl->Gtype}}</td>
      <td>{{$gasl->DistrictName}}</td>
      <td>{{$gasl->Longitude}},{{$gasl->Latitude}}</td>
      <td>
			@if ($gasl->TypeText == "Good")
			    <i class="far fa-star" style="color: red;"></i>
			@elseif ($gasl->TypeText == "Bad")
			    <i class="far fa-star" style="color: gray;"></i>
			@else
			    <i class="far fa-star" style="color: blue;"></i>
			@endif
	  </td>
   	  <td>
      	<i class="far fa-trash-alt" style="color: red;"></i>
      </td>
      <td><i class="fas fa-edit" style="color: #309fe1;"></i></td>
    </tr>
	@endforeach
    
  </tbody>
</table>




<!--  modal them-->
<div class="modal fade" id="Modal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="margin-left: 130px;" id="exampleModalLabel">ガソリンスタンド登録
</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
<label><b>ガソリンスタンド名:</b></label>
	    <input class="input_add" type="text" name="gasname_add" id="gasname_add" ><br>

	    <div style="margin-bottom: -20px;">
	    	<label style="float: left;"><b>種類:
</b></label>
	    	<div class="table" style="padding-top: 15px;padding-left: 193px;">
	    		<tr>
	    		@foreach($gastype as $gasT)
	    		<td>
	  		 	<input class="type_add" type="checkbox"  name="gastype_add[]" 
	  		 	value="{{$gasT->TypeCode}}"><span>{{$gasT->TypeText}}</span> 
	  		 	</td>
	  			@endforeach
	  			</tr>
	    	</div>
	    </div>
	    <label><b>longtitude:</b></label><input class="type_long" type="text" name="Longitude_add" id="Longitude_add" ><br>
	    <label><b>latitude</b></label><input class="type_lati" type="text" name="Latitude_add" id="Latitude_add" ><br>
	    <label><b>住所:</b></label>
	    	<select class="s_dist_add" name="dist_add" id="dist_add" value="">
	  		 <option value=""></option>
	  		@foreach($district as $dst)
	  		 <option value="{{$dst->DistrictName}}">{{$dst->DistrictName}}</option>
	  		@endforeach
	  	</select>
	  	<input class="namegas" type="text" name="address_add" id="address_add" ><br>
	    <br>
	    <label><b>thoi gian mo cua</b></label><input class="namegas" type="text" name="time_add" id="time_add" ><br>
	  <label><b>thoi gian mo cua</b></label>
    <input type="radio" aria-label="Radio button for following text input">
    <input type="radio" aria-label="Radio button for following text input">
    <input type="radio" aria-label="Radio button for following text input">
    


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">ADD</button>
      </div>
    </div>
  </div>
</div>
		<!-- load modal them-->
		<script type="text/javascript">
    		$('#myModal').on('shown.bs.modal', function () {
  			$('#myInput').trigger('focus')
			})
		</script>
	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>