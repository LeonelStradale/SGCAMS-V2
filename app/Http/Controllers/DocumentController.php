<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::with('area')->latest()->paginate(10);

        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $areas = Area::all();

        return view("documents.create", compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'document' => 'required|file',
            'area_id' => 'required|exists:areas,id',
        ]);


        $data = $request->all();

        if ($document = $request->file('document')) {
            $destinationPath = 'docs/';
            $fileName = $request->name . '.' . $document->getClientOriginalExtension();
            $document->move($destinationPath, $fileName);
            $data['document'] = $fileName;
        }

        Document::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'El nuevo documento se registró correctamente.'
        ]);

        return redirect()->route('documents.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        $areas = Area::all();

        return view('documents.edit', compact('document', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'name' => 'required|string',
            'type_of_document' => 'required|string',
            'document' => 'required',
            'area_id' => 'required|exists:areas,id',
        ]);

        $input = $request->all();

        if ($file = $request->file('document')) {
            $destinationPath = 'docs/';
            $fileName = $request->name . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $input['document'] = "$fileName";

            if ($document->document) {
                $oldFilePath = public_path($destinationPath . $document->document);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
        }

        $document->update($input);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'El documento se actualizó correctamente.'
        ]);

        return redirect()->route('documents.show', $document->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $document->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'El documento se eliminó correctamente.'
        ]);

        return redirect()->route('documents.index');
    }
}