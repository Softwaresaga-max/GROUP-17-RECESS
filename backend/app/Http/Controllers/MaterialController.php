<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('group')
            ->latest()
            ->get();

        return view('materials.index', compact('materials'));
    }

    public function download(Material $material)
{
    return Storage::disk('public')
        ->download($material->file_path);
}


    public function create()
    {
        $groups = Group::all();

        return view('materials.create', compact('groups'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'file' => 'required|mimes:pdf|max:20480',
            'group_id' => 'required|exists:groups,id',
        ]);


        $path = $request->file('file')
            ->store('materials','public');


        Material::create([
            'title' => $request->title,
            'file_path' => $path,
            'group_id' => $request->group_id,
            'user_id' => auth()->id(),
        ]);


        return redirect()
            ->route('materials.index')
            ->with('success','Material uploaded successfully');
    }


    // ✅ STUDENT MATERIALS PAGE
    public function studentMaterials()
{
    $user = auth()->user();

    $groupIds = $user->groups()->pluck('groups.id');


    $materials = Material::with('group')
        ->whereIn('group_id', $groupIds)
        ->latest()
        ->get();


    return view('student.materials', compact('materials'));
}
}