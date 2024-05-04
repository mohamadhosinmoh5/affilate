<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contract;
use App\Notif;
use App\ContractDetail;
use Hekmatinasser\Verta\Verta;
use Carbon\Carbon;
use Illuminate\Routing\Route;

class DashboardController extends Controller
{
    public function UpdateNotife()
    {
        $contract = Contract::withSum('statements','consultant_approved_amount')->get();

        return Route('dashboard');

    }

    public function totalState(Request $request,$id)
    {
        $json = [];
        $json['id'] = $id;
        return json_encode($json);
    }

    public function totalAdjust(Request $request)
    {
        
    }
}
