<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\NoteResource;
use App\Http\Resources\V1\NoteCollection;
use App\Filters\V1\NotesFilter;
use App\Http\Requests\V1\StoreNoteRequest;
use App\Http\Requests\V1\UpdateNoteRequest;
use App\Http\Requests\V1\DeleteNoteRequest;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new NotesFilter();
        $queryItems = $filter->transform($request);  //[['column', 'operator', 'value']]

        if (count($queryItems) == 0) {
            return new NoteCollection(Note::all());
        } else {
            $notes = Note::where($queryItems)->all();
            return new NoteCollection($notes->appends($request->query()));
        }

        // return new NoteCollection(Note::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNoteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoteRequest $request)
    {
        $note = new Note();
        $note->title = $request->input('title');
        $note->category = $request->input('category');
        $note->description = $request->input('description');
        $note->completed = $request->input('completed');
        $note->save();

        return response()->json([
            'message' => 'Note Created Successfully',
            'data' => new NoteResource($note),
        ], 200);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        return new NoteResource($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNoteRequest  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->update($request->all());
        return response()->json(['message' => 'Note updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteNoteRequest $request, Note $note)
    {
        $note->delete();
        return response()->json(['message' => 'Note deleted successfully'], 200);
    }
}
