<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PancasilaProjectCollection;
use App\PancasilaProject;
use App\PancasilaProjectElement;
use App\PancasilaElement;
use App\KelasAnggota;

class PancasilaProjectController extends Controller
{
    public function index(Request $request) {
        $user = $request->user();
        $pp = PancasilaProject::where('unit_id',$user->unit_id)
                              ->with('kelas')
                              ->paginate(20);

        return new PancasilaProjectCollection($pp);
    }
    public function store(Request $request) {
        $this->validate($request, [
            'pp_class' => 'required',
            'pp_theme' => 'required',
            'pp_name' => 'required',
            'pp_desc' => 'required',
            'pp_element' => 'required'
        ]);
        $user = $request->user();
        foreach($request->pp_class as $rowClass) {
            $project = PancasilaProject::create([
                            'pp_theme' => $request->pp_theme,
                            'pp_name' => $request->pp_name,
                            'pp_desc' => $request->pp_desc,
                            'kelas_id' => $rowClass['id'],
                            'unit_id' => $user->unit_id,
                            'periode_id' => $user->periode,
                            'creator_id' => $user->id,
                            'updater_id' => $user->id,
                        ]);
            if($project){
                foreach($request->pp_element as $rowPE){
                    $pppe = PancasilaProjectElement::create([
                                'pp_id' => $project->id,
                                'pe_id' => $rowPE['element']['id']
                            ]);
                }
            }
        }

        return response()->json(['status'=>'SUKSES'],200);
    }

    public function update(Request $request) {
        $this->validate($request, [
            'pp_theme' => 'required',
            'pp_name' => 'required',
            'pp_desc' => 'required',
            'pp_element' => 'required'
        ]);
        $user = $request->user();
        $project = PancasilaProject::where('id',$request->id)->update([
                        'pp_theme' => $request->pp_theme,
                        'pp_name' => $request->pp_name,
                        'pp_desc' => $request->pp_desc,
                        'updater_id' => $user->id,
                    ]);
        $ppe = PancasilaProjectElement::where('pp_id',$request->id)->delete();
        foreach($request->pp_element as $rowPE){
            $pppe = PancasilaProjectElement::create([
                        'pp_id' => $request->id,
                        'pe_id' => $rowPE['element']['id']
                    ]);
        }



        return response()->json(['status'=>'SUKSES'],200);
    }

    public function edit($id) {
        $pp = PancasilaProject::where('id',$id)->with(['pp_element','pp_element.element'])->first();
        $ppe = PancasilaProjectElement::where('pp_id',$id)->pluck('pe_id');
        $pp['pp_element'] = PancasilaElement::whereIn('id',$ppe)->get();
        return response()->json(['status'=>'success', 'data'=>$pp],200);
    }

    public function destroy($id) {
        $pp = PancasilaProject::find($id);
        $ppe = PancasilaProjectElement::where('pp_id',$id)->delete();
        $pp->delete();
        return response()->json(['status'=>'success'],200);
    }
}
