<?php

namespace App\Http\Controllers;
use DB;
use App\Quotation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Session;
use validate;

class Feedback_CTL extends Controller
{
    public function feedbackview(){
        $idgas = isset($_GET['id']) ? $_GET['id']: '';
        if($idgas != ''){
        $gaslist = DB::table('GasStation')
        ->join('M_District','GasStation.District','=','M_District.DistrictID')
        -> join('GasStationGasType','GasStation.GasStationId', '=', 'GasStationGasType.GasStationId')
        -> join('GasType', 'GasStationGasType.GasType','=','GasType.TypeCode')
        ->join('RatingType', 'GasStation.Rating', '=', 'RatingType.TypeCode')
        ->select('GasStation.GasStationId','GasStation.GasStationName','GasStation.Address','GasStation.OpeningTime','M_District.DistrictName','RatingType.TypeText as Rstatus',DB::raw("STRING_AGG(GasType.TypeText,', ') as Gtype"))->where('GasStation.GasStationId','=',$idgas)
        ->groupBy('GasStation.GasStationId', 'GasStation.GasStationName','RatingType.TypeText','M_District.DistrictName','GasStation.Address','GasStation.OpeningTime')
        ->get();
        $feedback = DB::table('GasStation')
        ->join('GasStationFeedback','GasStation.GasStationId','=','GasStationFeedback.GasStationId')
        ->select('GasStation.OpeningTime','GasStation.GasStationName','GasStationFeedback.feedback')->where('GasStation.GasStationId','=',$idgas)
        ->get();
        }else{
            $gaslist=1;$feedback='';
        }
       
        return view('pages/feedback',['gaslist'=>$gaslist,'feedback'=>$feedback]);
    }
     
} 