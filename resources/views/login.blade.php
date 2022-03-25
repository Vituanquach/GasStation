<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="/login.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
    <div class="login">    
    <form id="login" method="post" action="/checkV">
        @csrf
        <p  style="text-align: center;margin-top: 12px;font-weight: bold;font-size: 15px;">ガソリンスタンド管理</p>
        <div style="margin-top: 20px;">
            <label style="font-size: 15px;">メール:</label>
            <input type="text" name="Uname" id="Uname" placeholder="" value="{{old('Uname')}}{{ session('user') }} " autofocus> 
            <p class="alert">{{ $errors->first('Uname') }}</p>  
        </div><br>
        <div style="margin-top: 0px;">
            <label style="font-size: 15px;">パスワード:</label>    
            <input type="Password" name="Pass" id="Pass" placeholder=""  value="">
            <p class="alert">{{ $errors->first('Pass') }}</p>
        </div>
        @if (session('status'))
            <div class="noti" role="alert">
                {{ session('status') }} 
            </div>
        @endif
         
        <br>
        <button>ログイン</button>    
    </form></div> 
  
        


     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
  integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
  crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

   
</body>

