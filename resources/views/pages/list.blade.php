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
  <div class="func_list">
    <div class='title'>
      <button class="btn-map">マップ</button> 
      <h5 style="text-align: center;font-weight: bold;">ガソリンスタンド一覧 <!-- {{ session('idu') }} --> </h5>
      </div>
    
    <form class="searchlayout"  action="/tim123" method="get">
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><b>ガソリンスタンド名:</b></div>
            <div class="col-md-7 col-sm-7 col-7"><input class="namegas_search" type="text" name="gasname" id="gasname" autofocus></div>
          </div>
          <div class="row" style="margin-top: 10px;">
            <div class="col-md-5 col-sm-5 col-5"><b>種類:</b></div>
            <div class="col-md-7 col-sm-7 col-7">
              @foreach($gastype as $gasT)
                <td>
                  <input class="checkmark" type="checkbox"  name="gastype[]" 
                    value="{{$gasT->TypeCode}}"><b style="font-size: 17px;
    margin-left: 10px;
    margin-right: 15px;">{{$gasT->TypeText}}</b>
                  @if($loop->index %2 ===1)
                  <br>
                   @endif
                </td>
               @endforeach
             </div>
          </div>
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><b>地区:</b></div>
            <div class="col-md-7 col-sm-7 col-7"><select class="s_dist" name="dist" id="dist" value="">
                                                   <option value=""></option>
                                                  @foreach($district as $dst)
                                                   <option value="{{$dst->DistrictId}}">{{$dst->DistrictName}}</option>
                                                  @endforeach
                                                </select>
             </div>
          </div><br>
          <button type="submit">検索</button>
          </form>
          <button class="btn-add" type="button"  data-toggle="modal" data-target="#Modal_add">登録</button></div></div>
        

  <div class="list" id="showlist">
    <table class="table" id="listview">   
  <thead>
    <tr>
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
      
      <th scope="row"><a href="/feedback?id={{$gasl->GasStationId}}">{{$gasl->GasStationName}}</a></th>
      <td>{{$gasl->Gtype}}</td>
      <td>{{$gasl->DistrictName}}</td>
      <td>{{$gasl->Longitude}},&nbsp;{{$gasl->Latitude}}</td>
      <td>
      @if ($gasl->Rstatus == "Good")
          <i class="far fa-star" style="color: red;"></i>
      @elseif ($gasl->Rstatus == "Bad")
          <i class="far fa-star" style="color: gray;"></i>
      @else
          <i class="far fa-star" style="color: blue;"></i>
      @endif
    </td>
      <td><p onclick="show_editmodal({{$gasl->GasStationId}})"><i class="fas fa-edit" style="color: #309fe1;"></i></p></td>
      <td>
        <p onclick="show_del({{$gasl->GasStationId}})"><i class="far fa-trash-alt" style="color: red;"></i></p>
      </td>
    </tr>
  @endforeach
  

    
  </tbody>
</table>
</div>

<!-- modal edit -->
<div class="modal  fade" id="edit_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="margin-left: 130px;" id="exampleModalLabel">ガソリンスタンド更新</h5>
        <input class="type_add " type="checkbox"  name="id_gas_edit" id="id_gas_edit"
            value="" hidden>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><label><b>ガソリンスタンド名:</b></label></div>
            <div class="col-md-7 col-sm-7 col-7"><input class="input_add" type="text" name="gasname_edit" id="gasname_edit" ></div>
          </div>
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><label><b>種類:</b></label></div>
              <div class="col-md-7 col-sm-7 col-7">
               @foreach($gastype as $gasT)
                <td>
                  <input class="checkmark_edit_add" type="checkbox" id="typgas_edit" name="gastype_edit" 
                  value="{{$gasT->TypeCode}}"><span>{{$gasT->TypeText}}</span>
                  @if($loop->index %2 ===1)
                  <br>
                   @endif
                </td>
               @endforeach
              </div>
          </div>
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><label><b>longtitude:</b></label></div>
            <div class="col-md-7 col-sm-7 col-7"><input class="input_add" type="text" name="Longitude_edit" id="Longitude_edit" ></div>
          </div>
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><label><b>latitude:</b></label></div>
            <div class="col-md-7 col-sm-7 col-7"><input class="input_add" type="text" name="Latitude_edit" id="Latitude_edit" ></div>
          </div>
          <div class="row" style="margin-bottom: 9px;">
            <div class="col-md-5 col-sm-5 col-5"><label><b>住所:</b></label></div>
            <div class="col-md-7 col-sm-7 col-7">
                                  <select class="input_add" style="height: 35px;" name="dist_edit" id="dist_edit" value="">
                                    <option value=""></option>
                                   @foreach($district as $dst)
                                    <option value="{{$dst->DistrictId}}">{{$dst->DistrictName}}</option>
                                    @endforeach
                                  </select><br>
                                  <input class="address_add" type="text" name="address_edit" id="address_edit" >
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><label><b>開館時間:</b></label></div>
            <div class="col-md-7 col-sm-7 col-7"><input class="input_add" type="text" name="time_edit" id="time_edit" ></div>
          </div>
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><label><b>評価:</b></label></div>
            <div class="col-md-7 col-sm-7 col-7">
              <form class="" name="rat_edit" id="rat_edit">
              <input type="radio" name="rat" id="rating_edit1"  aria-label="Radio button for following text input" class="radio_status" value="00001"><i class="far fa-star" style="color: red;"></i>
              <input type="radio" name="rat" id="rating_edit2"  aria-label="Radio button for following text input" class="radio_status" value="00002"><i class="far fa-star" style="color: blue;"></i>
              <input type="radio" name="rat"  id="rating_edit3"  aria-label="Radio button for following text input" class="radio_status" value="00003" ><i class="far fa-star" style="color: gray;"></i></form> 
            </div>
          </div>
        </div>
        
          
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">更新</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">戻る</button>
          </div>
      </div>
  </div>
</div>


<!-- modal delete -->
<div class="modal  fade" id="del_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="margin-left: 130px;" id="exampleModalLabel">ガソリンスタンド更新</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <label style="text-align: center;"><b>マッサージしますか？</b></label>
        </div>
        <div class="modal-footer">
            <button id="btn_del" type="button"  class="btn btn-primary">更新</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">戻る</button>
          </div>
      </div>
  </div>
</div>


<script type="text/javascript">
  function del($id){
      var id = $id;
      $.ajax({
              url: '/delete',
              type: "POST",
              dataType : 'json',
              data: {
                  id: id,
                  _token: '{{csrf_token()}}'
              },
              
              success: function(dataResult){
                alert('xoa thanh cong');
                window.location.reload();
              }
          });
  }
  function show_del($id){
      var id = $id;
      $('#btn_del').attr('onClick', 'del('+id+')');
      $('#del_modal').modal('show');
  }
  function show_editmodal($id) {
  var id = $id;
  $.ajax({
              url: '/loadedit',
              type: "POST",
              dataType : 'json',
              data: {
                  id: id,
                  _token: '{{csrf_token()}}'
              },
              
              success: function(dataResult){
                

                // console.log(dataResult[0]['Gtype']);

                if(dataResult[0]['Rstatus'] !=  "Good"){
                  if(dataResult[0]['Rstatus'] ==  "Mid"){
                    $("#rating_3").prop("checked", true);
                  }else{
                    $("#rating_2").prop("checked", true);
                  } 
                }else{
                  $("#rating_1").prop("checked", true);
                }
                $('#dist_edit').append('<option value="'+dataResult[0]['DistrictId']+'" selected>'+dataResult[0]['DistrictName']+'</option>');
                $("#gasname_edit").val(dataResult[0]['GasStationName']);
                $("#Longitude_edit").val(dataResult[0]['Longitude']);
                $("#Latitude_edit").val(dataResult[0]['Latitude']);
                $("#address_edit").val(dataResult[0]['Address']);
                $("#time_edit").val(dataResult[0]['OpeningTime']);
                $("#id_gas_edit").val(dataResult[0]['GasStationId']);
                
                  
                
                $('#edit_modal').modal('show');
                  
                  
                  
              }
          });


}
</script>



<!--  modal add-->
<div class="modal fade" id="Modal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="margin-left: 130px;" id="exampleModalLabel">ガソリンスタンド登録</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><label><b>ガソリンスタンド名:</b></label></div>
            <div class="col-md-7 col-sm-7 col-7"><input class="input_add" type="text" name="gasname_add" id="gasname_add"></div>
          </div>
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><label><b>種類:</b></label></div>
              <div class="col-md-7 col-sm-7 col-7">
               @foreach($gastype as $gasT)
                <td>
                  <input class="checkmark_edit_add" type="checkbox" id="typgas_add" name="gastype_add" 
                  value="{{$gasT->TypeCode}}"><span>{{$gasT->TypeText}}</span>
                  @if($loop->index %2 ===1)
                  <br>
                   @endif
                </td>
               @endforeach
              </div>
          </div>
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><label><b>longtitude:</b></label></div>
            <div class="col-md-7 col-sm-7 col-7"><input class="input_add" type="number" name="Longitude_add" id="Longitude_add" ></div>
          </div>
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><label><b>latitude:</b></label></div>
            <div class="col-md-7 col-sm-7 col-7"><input class="input_add" type="number" name="Latitude_add" id="Latitude_add" ></div>
          </div>
          <div class="row" style="margin-bottom: 9px;">
            <div class="col-md-5 col-sm-5 col-5"><label><b>住所:</b></label></div>
            <div class="col-md-7 col-sm-7 col-7"><select class="input_add" style="height: 35px;" name="dist_add" id="dist_add" value="">
                                   @foreach($district as $dst)
                                    <option value="{{$dst->DistrictId}}">{{$dst->DistrictName}}</option>
                                    @endforeach
                                  </select><br>
                                  <input class="address_add" type="text" name="address_add" id="address_add" >
            </div>
          </div>
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><label><b>開館時間:</b></label></div>
            <div class="col-md-7 col-sm-7 col-7"><input class="input_add" type="text" name="time_add" id="time_add" ></div>
          </div>
          <div class="row">
            <div class="col-md-5 col-sm-5 col-5"><label><b>評価:</b></label></div>
            <div class="col-md-7 col-sm-7 col-7">
              <form class="" name="rat_add" id="rat_add">
              <input type="radio" name="rat" id="rating1"  aria-label="Radio button for following text input" class="radio_status" value="00001"><i class="far fa-star" style="color: red;"></i>
              <input type="radio" name="rat" id="rating2"  aria-label="Radio button for following text input" class="radio_status" value="00002"><i class="far fa-star" style="color: blue;"></i>
              <input type="radio" name="rat"  id="rating3"  aria-label="Radio button for following text input" class="radio_status" value="00003" ><i class="far fa-star" style="color: gray;"></i></form> 
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="btn-addgas" >登録</button>
             <button type="button" class="btn btn-secondary" data-dismiss="modal">戻る</button>
         </div>
        </div>
  </div>
</div>

<script>
  
$(document).ready(function() {
   
    $('#btn-addgas').on('click', function() {
      var name = $('#gasname_add').val();
      var checkgastype = [];
      $.each($("input[name='gastype_add']:checked"), function(){            
          checkgastype.push($(this).val());
      });
      
      var longtitude =  $('#Longitude_add').val(); 
      var latitude  = $('#Latitude_add').val();
      var district = $('#dist_add').val();
      var address = $('#address_add').val();
      var timeopen = $('#time_add').val();
      
       var rating = $('input[name=rat]:checked', '#rat_add').val();


      if(name != "" ){
        /*  $("#butsave").attr("disabled", "disabled"); */
          $.ajax({
              url: '/gasadd',
              type: "POST",
              dataType : 'json',
              data: {
                  name: name,
                  checkgastype:checkgastype,
                  longtitude:longtitude, 
                  latitude:latitude, 
                  district:district, 
                  address:address,
                  timeopen:timeopen,
                  rating:rating,
                  _token: '{{csrf_token()}}'
              },
              
              success: function(dataResult){

                    alert('save success'); 
                    $('#Modal_add').modal('hide');
                    $("#listview").remove();
                    $("#showlist").html(dataResult);
                  // console.log(dataResult);
                  // var dataResult = JSON.parse(dataResult);
                  // if(dataResult=200){
                  //   alert('save success'); 
                  //   $('#Modal_add').modal('hide');
                  //   $("#listview").remove();
                  //   $("#showlist").html(dataResult);
                           
                  // }
                  // else{
                  //    alert("Error occured !");}
                  
                  
            }
          });
      }
      else{
          alert('Please fill all the field !');
      }
   });
});
</script>


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
