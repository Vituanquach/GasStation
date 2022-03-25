<?php

namespace App\Http\Controllers;
use DB;
use App\Quotation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use DateTime;

use Session;
use validate;

class Gas_List extends Controller
{
    //show gaslist gui
    public function getgaslist()
    {	
      //get district table & gastype table show sreachform
    	// $district =DB::select("select * from M_District where 1");
      $district = DB::table('M_District')->get();
      $gastype = DB::table('GasType')->get();
      
      //get data gaslist show
      $gaslist = DB::table('GasStation')
      ->join('M_District','GasStation.District','=','M_District.DistrictID')
      -> join('GasStationGasType','GasStation.GasStationId', '=', 'GasStationGasType.GasStationId')
      -> join('GasType', 'GasStationGasType.GasType','=','GasType.TypeCode')
      ->join('RatingType', 'GasStation.Rating', '=', 'RatingType.TypeCode')
      ->select('GasStation.GasStationId','GasStation.GasStationName','M_District.DistrictName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText as Rstatus', DB::raw("STRING_AGG(GasType.TypeText,', ') as Gtype"))
      ->groupBy('GasStation.GasStationId', 'GasStation.GasStationName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText','M_District.DistrictName')
      ->get();
      
      //return data listshow to listgas view
        return view('pages.list',['gaslist'=>$gaslist,'district'=>$district,'gastype'=>$gastype]);
    }

    public function searchGas(Request $request)
    {	

    	//get data 
    	// $gastype =DB::select("select * from gastype where 1");
    	// $district =DB::select("select * from M_District where 1");
      $district = DB::table('M_District')->get();
      $gastype = DB::table('GasType')->get();
    	$key = $request->all();
      //search keyword
      $gasname = isset($key['gasname']) ?$key['gasname'] : "";
      $checked = $request->input('gastype');
      $type= isset($checked) ?$checked : "";
      $distid = isset($key['dist']) ?$key['dist'] : "";
      $data = DB::table('GasStation')
      ->join('M_District','GasStation.District','=','M_District.DistrictID')
      -> join('GasStationGasType','GasStation.GasStationId', '=', 'GasStationGasType.GasStationId')
      -> join('GasType', 'GasStationGasType.GasType','=','GasType.TypeCode')
      ->join('RatingType', 'GasStation.Rating', '=', 'RatingType.TypeCode')
      ->select('GasStation.GasStationId','GasStation.GasStationName','M_District.DistrictName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText as Rstatus', DB::raw("STRING_AGG(GasType.TypeText,',') as Gtype"))
      ->groupBy('GasStation.GasStationId', 'GasStation.GasStationName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText','M_District.DistrictName');
         //search 
        if($gasname != ""){
            if($checked != ""){
              if($distid !="")
                  { 
                    $note=" coten coloai codc";
                    $gaslist=$data->where('GasStation.GasStationName','like','%'.$gasname.'%')->whereIn('GasType.TypeCode', $checked)->where('M_District.DistrictID','=',$distid)->groupBy('GasStation.GasStationId', 'GasStation.GasStationName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText','M_District.DistrictName')->get();
                  }else{ 
                    $note="coten va coloai(ko co diachi)";
                    $gaslist=$data->where('GasStation.GasStationName','like','%'.$gasname.'%')->whereIn('GasType.TypeCode', $checked)->groupBy('GasStation.GasStationId', 'GasStation.GasStationName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText','M_District.DistrictName')->get();
                  }
              }else{
                if($distid != ""){ 
                    $note="coten codc(khong co loai";
                    $gaslist=$data->where('GasStation.GasStationName','like','%'.$gasname.'%')->where('M_District.DistrictID','=',$distid)->groupBy('GasStation.GasStationId', 'GasStation.GasStationName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText','M_District.DistrictName')->get();
                  }else{
                    $note = "chi co ten";
                    $gaslist = $data->where('GasStation.GasStationName','like','%'.$gasname.'%')->groupBy('GasStation.GasStationId', 'GasStation.GasStationName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText','M_District.DistrictName')->get();
                  }
              }
        }else{ 
            if($checked != ""){
              if($distid !=""){ 
                $note="coloai codc";
                $gaslist=$data->whereIn('gastype.TypeCode', $checked)->where('M_District.DistrictID','=',$distid)->groupBy('GasStation.GasStationId', 'GasStation.GasStationName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText','M_District.DistrictName')->get();
              }else{ 
                  $note=" co loai(ko diachi va ten)";
                  $gaslist=$data->whereIn('gastype.TypeCode', $checked)->groupBy('GasStation.GasStationId', 'GasStation.GasStationName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText','M_District.DistrictName')->get();
              }
            }else{
                if($distid != ""){ 
                  $note=" co diacchi(khong loai va ten)";
                  $gaslist = $data->where('M_District.DistrictID','=',$distid)->groupBy('GasStation.GasStationId', 'GasStation.GasStationName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText','M_District.DistrictName')->get();
                }else{
                  $note = "khong co gi";
                  $gaslist =$data->groupBy('GasStation.GasStationId', 'GasStation.GasStationName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText','M_District.DistrictName')->get();
                }
            }
        }
      //search typecheckbox array
    	return view('pages.list',['gaslist'=>$gaslist,'district'=>$district,'gastype'=>$gastype]);
    }

    public function gasadd(Request $request){
              $name = $request->name;
              $type = $request->checkgastype;
              $longitude = $request->longtitude;
              $latitude = $request->latitude;
              $district = $request->district;
              $address = $request->address;
              $timeopen = $request->timeopen;
              $rating = $request->rating;

              $datenow = new DateTime();
              $data = array('GasStationName' => $name,
                'Address' => $address,
                'District' =>  $district,
                'OpeningTime' => $timeopen,
                'Longitude' => $longitude,
                'Latitude' => $latitude,
                'Rating'  => $rating,
                'InsertedAt' => $datenow ,
                'InsertedBy'=> 1,
                'UpdatedAt' => $datenow,
                'UpdatedBy'=>1);
              
              //check type checked
               if(count($type)>1){
              //insert table GasStation and get id last insert to add gastype
              DB::table('GasStation')->insert($data);
              $idgas = DB::getPdo()->lastInsertId();
              for ($i=0; $i < count($type); $i++) {
                  //insert multiple gastype
                  $datagastype =  array('GasStationId' => $idgas ,'GasType' => $type[$i]); 
                  DB::table('GasStationGasType')->insert($datagastype);
                  }
              //get data new gaslist to replace old gaslist    
              $gaslist =  DB::table('GasStation')
              ->join('M_District','GasStation.District','=','M_District.DistrictID')
              -> join('GasStationGasType','GasStation.GasStationId', '=', 'GasStationGasType.GasStationId')
              -> join('GasType', 'GasStationGasType.GasType','=','GasType.TypeCode')
              ->join('RatingType', 'GasStation.Rating', '=', 'RatingType.TypeCode')
              ->select('GasStation.GasStationId','GasStation.GasStationName','M_District.DistrictName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText as Rstatus', DB::raw("STRING_AGG(GasType.TypeText,',') as Gtype"))
              ->groupBy('GasStation.GasStationId', 'GasStation.GasStationName','GasStation.Longitude','GasStation.Latitude','RatingType.TypeText','M_District.DistrictName')
              ->get();
                $showlist = '';
                $listfirst = '<table class="table" id="listview">   
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
                              </thead><tbody>';
              
                $listmid='';
                foreach ($gaslist as $gasl) {
                    $listmid1 = '<th scope="row">'.$gasl->GasStationName.'</th>
                                  <td>'.$gasl->Gtype.'</td>
                                  <td>'.$gasl->DistrictName.'</td>
                                  <td>'.$gasl->Longitude.','.$gasl->Latitude.'</td>
                                  <td>';
                    if ($gasl->Rstatus == "Good"){
                          $listmid2= '<i class="far fa-star" style="color: red;"></i>';
                    }elseif ($gasl->Rstatus == "Bad"){
                          $listmid2= '<i class="far fa-star" style="color: gray;"></i>';
                    }else{ 
                          $listmid2='<i class="far fa-star" style="color: blue;"></i>';
                    } 
                    $listmid3='</td>
                        <td><p onclick="show_editmodal('.$gasl->GasStationId.')"><i class="fas fa-edit" style="color: #309fe1;"></i></p></td>
                        <td>
                          <p onclick="show_del('.$gasl->GasStationId.')"><i class="far fa-trash-alt" style="color: red;"></i></p>
                        </td>
                      </tr>';
                               $listmid .= $listmid1.$listmid2.$listmid3; 
                   }
                
                  $listlast='</tbody></table>';
                  $showlist.=$listfirst.$listmid.$listlast;
          }else{
                $showlist = 2;
          }
          // return response()->json(array('showlist'=> $showlist), 200);
          return response()->json($showlist);
      
    }
    //get data modal edit
    public function load_edit(Request $request){

           $id = $request->id;

           $gaslist = DB::table('GasStation')
            ->join('M_District','GasStation.District','=','M_District.DistrictID')
            -> join('GasStationGasType','GasStation.GasStationId', '=', 'GasStationGasType.GasStationId')
            -> join('GasType', 'GasStationGasType.GasType','=','GasType.TypeCode')
            ->join('RatingType', 'GasStation.Rating', '=', 'RatingType.TypeCode')
            ->select('M_District.DistrictId','GasStation.Latitude','GasStation.Longitude','GasStation.GasStationId','GasStation.GasStationName','GasStation.Address','GasStation.OpeningTime','M_District.DistrictName','RatingType.TypeText as Rstatus',DB::raw("STRING_AGG(GasType.TypeText,', ') as Gtype"))->where('GasStation.GasStationId','=',$id)
            ->groupBy('GasStation.GasStationId', 'GasStation.GasStationName','RatingType.TypeText','M_District.DistrictName','GasStation.Address','GasStation.OpeningTime','GasStation.Latitude','GasStation.Longitude','M_District.DistrictId')
            ->get();


           return response()->json($gaslist);

    }
    //delete data modal
    public function deletegas(Request $request)
    {         
          $id = $request->id;
          DB::table('GasStationFeedback')->where('GasStationId', '=' ,$id)->delete();
          DB::table('GasStationGasType')->where('GasStationId', '=' ,$id)->delete();
          DB::table('GasStation')->where('GasStationId', '=' ,$id)->delete();
          $note = 10;
          return response()->json($note);
     }
    public function test()
    {         DB::table('GasStationGasType')->where('GasStationId', '=' ,'191')->delete();
            
    }
}
