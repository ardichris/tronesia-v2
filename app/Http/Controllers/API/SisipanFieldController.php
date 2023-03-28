<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SisipanField;


class SisipanFieldController extends Controller
{
    public function index(Request $request){
        $user = $request->user();
        $data = SisipanField::where('unit_id', $user->unit_id)
                                ->where('periode_id', $user->periode)
                                ->with('lingkupmateri')
                                ->get();
        $setting = [];
        foreach($data as $item) {
            $setting[$item['mapel']][$item['field']]=$item->lingkupmateri;
        }
        return response()->json(['status' => 'success', 'data' => $setting], 200);
    }

    public function store(Request $request) {
        $user = $request->user();
            foreach($request->field as $keymapel=>$itemmapel){
                foreach($itemmapel as $keyfield=>$itemfield){
                    $field = SisipanField::where('periode_id',$user->periode)
                                        ->where('unit_id', $user->unit_id)
                                        ->where('mapel', $keymapel)
                                        ->where('field', $keyfield)
                                        ->where('jenjang', 7);
                    $cek = $field->count();
                    if($itemfield!=[]){
                        if($field->count()==0){
                            SisipanField::create([
                                                'mapel' => $keymapel,
                                                'lingkupmateri_id' => $itemfield['id'],
                                                'jenjang' => 7,
                                                'field' => $keyfield,
                                                'periode_id' => $user->periode,
                                                'unit_id' => $user->unit_id
                                            ]);
                        } else {
                            $field->update([
                                            'lingkupmateri_id' => $itemfield['id'],
                                            ]);
                        }
                    } else {
                        $field->delete();
                    }
                }
            }

        return response()->json(['status' => 'success'], 200);

    }

}
