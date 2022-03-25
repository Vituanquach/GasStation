</!DOCTYPE html>
<html>
<head>
  <title>List Gas Xang</title>


<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="/gaslist.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body>
  @if (session('idu'))

  <div class="func_fback">
  	<div class='title'>
      <h5>投稿の閲覧</h5></div>
      <div style="margin-bottom: -20px;">
      	 @foreach($gaslist as $gasl)
      	<div class="row infot">
		  <div class="col-md-4">ガソリンスタンド:</div>
		  <div class="col-md-8">{{$gasl->GasStationName}}</div>
		</div>
		<div class="row infot">
		  <div class="col-md-4">種類:</div>
		  <div class="col-md-8">{{$gasl->Gtype}}</div>
		</div>
		<div class="row infot">
		  <div class="col-md-4">住所:</div>
		  <div class="col-md-8">{{$gasl->Address}},{{$gasl->DistrictName}}</div>
		</div>
		<div class="row infot">
		  <div class="col-md-4">開館時間:</div>
		  <div class="col-md-8">{{$gasl->OpeningTime}}</div>
		</div>
		<div class="row infot">
		  <div class="col-md-4">評価:</div>
		  <div class="col-md-8">@if ($gasl->Rstatus == "Good")
          <i class="far fa-star" style="color: red;"></i>
      @elseif ($gasl->Rstatus == "Bad")
          <i class="far fa-star" style="color: gray;"></i>
      @else
          <i class="far fa-star" style="color: blue;"></i>
      @endif</div>
		</div>@endforeach
    </div>
    @if (count($feedback)>0)
    
    	@foreach($feedback as $fbk)
    	<textarea id="feedback" name="feedback" placeholder="" class="textarea_feedback"  disabled>{{$fbk->OpeningTime}}
{{$fbk->feedback}}	</textarea>
    	@endforeach
    @else
    <textarea id="feedback" name="feedback" placeholder="" class="textarea_feedback"  disabled>khong co feedback</textarea>@endif
    <form  action="/gaslist" method="get">
      <button type="submit"  class="btn btn-primary" style="float: right;
    margin-top: 8px;">戻る</button>
    </form>
     
     	
      
      	
		
		
	
  </div>
    
     
     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
  		integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
 		 crossorigin="anonymous"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!--  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    @endif
    
</body>
</html>
