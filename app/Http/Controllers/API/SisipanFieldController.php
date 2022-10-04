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
                                ->with('kompetensi')
                                ->get();
        $setting = [];
        foreach($data as $item) {
            //$setting[$item['mapel']]=[];
            $setting[$item['mapel']][$item['field']]=$item->kompetensi;
        }
        return response()->json(['status' => 'success', 'data' => $setting], 200);
    }

    public function store(Request $request) {
        $user = $request->user();
            foreach($request->field as $keymapel=>$itemmapel){
                foreach($itemmapel as $keyfield=>$itemfield){
                    if($itemfield!=[]){
                        $field = SisipanField::where('periode_id',$user->periode)
                                            ->where('unit_id', $user->unit_id)
                                            ->where('mapel', $keymapel)
                                            ->where('field', $keyfield)
                                            ->where('jenjang', 7);
                        $cek = $field->count();
                        if($field->count()==0){
                            SisipanField::create([
                                                'mapel' => $keymapel,
                                                'kompetensi_id' => $itemfield['id'],
                                                'jenjang' => 7,
                                                'field' => $keyfield,
                                                'periode_id' => $user->periode,
                                                'unit_id' => $user->unit_id
                                            ]);
                        } else {
                            $field->update([
                                            'kompetensi_id' => $itemfield['id'],
                                            ]);
                        }
                    }
                }
            }

        return response()->json(['status' => 'success'], 200);

    }

}
