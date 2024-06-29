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
            'document' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,csv',
            'area_id' => 'required|exists:areas,id',
        ]);


        $data = $request->all();

        if ($document = $request->file('document')) {
            $destinationPath = 'docs/';
            $fileName = $request->name . '.' . $document->getClientOriginalExtension();
            $document->move($destinationPath, $fileName);
            $data['document'] = $fileName;
        }

        $document = Document::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'El nuevo documento se registró correctamente.'
        ]);

        return redirect()->route('documents.show', $document->id);
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
            'document' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,csv',
            'area_id' => 'required|exists:areas,id',
        ]);

        $input = $request->all();
        $destinationPath = 'docs/';

        if ($file = $request->file('document')) {
            $fileName = $request->name . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $input['document'] = $fileName;

            if ($document->document) {
                $oldFilePath = public_path($destinationPath . $document->document);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
        } else if ($request->name != $document->name) {
            $oldFilePath = public_path($destinationPath . $document->document);
            $extension = pathinfo($oldFilePath, PATHINFO_EXTENSION);
            $newFileName = $request->name . '.' . $extension;
            $newFilePath = public_path($destinationPath . $newFileName);

            if (file_exists($oldFilePath)) {
                rename($oldFilePath, $newFilePath);
            }

            $input['document'] = $newFileName;
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
        $fileName = $document->document;

        $document->delete();

        $filePath = public_path('docs/' . $fileName);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'El documento se eliminó correctamente.'
        ]);

        return redirect()->route('documents.index');
    }

    public function searchDocuments(Request $request)
    {
        $search = $request->input('search');

        $documents = Document::where('name', 'LIKE', '%' . $search . '%')->get();
        
        if ($documents->isEmpty()) {
            session()->flash('swal', [
                'icon' => 'warning',
                'title' => '¡Atención!',
                'text' => 'La búsqueda que realizaste no coincide con nuestros registros.'
            ]);

            return redirect()->back();
        }

        return view('documents.search', compact('documents', 'search'));
    }

    public function searchAdminDocuments(Request $request)
    {
        $search = $request->input('search');

        $documents = Document::where('name', 'LIKE', '%' . $search . '%')->paginate(10);
        
        if ($documents->isEmpty()) {
            session()->flash('swal', [
                'icon' => 'warning',
                'title' => '¡Atención!',
                'text' => 'La búsqueda que realizaste no coincide con nuestros registros.'
            ]);

            return redirect()->back();
        }

        return view('documents.searchAdmin', compact('documents', 'search'));
    }
}