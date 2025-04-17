<?php

namespace App\Http\Controllers\SuperUser;

use App\Models\HsnCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class SuperUserHsnController extends Controller
{
    public function index(): JsonResponse
    {
        $hsnCodes = HsnCode::all();
        return response()->json($hsnCodes);
    }

    public function show()
    {
        $hsns = HsnCode::orderBy('created_at', 'desc')->get();

        return view('superuser.hsn_codes.index', compact('hsns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hsn_code' => 'required|unique:hsn_codes,hsn_code,' . $request->hsn_id,
            'description' => 'required|string',
            'gst' => 'required|numeric|min:0|max:100',
        ]);

        HsnCode::updateOrCreate(
            ['id' => $request->hsn_id],
            [
                'hsn_code' => $request->hsn_code,
                'description' => $request->description,
                'gst' => $request->gst,
            ]
        );

        return redirect()->route('superuser.hsn.index')->with('success', 'HSN code saved successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hsn_code' => 'required|unique:hsn_codes,hsn_code,' . $id,
            'description' => 'required|string',
            'gst' => 'required|numeric|min:0|max:100',
        ]);

        $hsn = HsnCode::findOrFail($id);

        $hsn->update([
            'hsn_code' => $request->hsn_code,
            'description' => $request->description,
            'gst' => $request->gst,
        ]);

        return redirect()->route('superuser.hsn.index')->with('success', 'HSN code updated successfully.');
    }

    public function destroy($id)
    {
        $hsn = HsnCode::findOrFail($id);
        $hsn->delete();

        return redirect()->route('superuser.hsn.index')->with('success', 'HSN code deleted successfully.');
    }
}
