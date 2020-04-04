<?php

namespace App\controller\api;

use App\system\controller\Controller;
use App\system\db\builder\DB;
use App\system\request\Request;
use App\system\Validator;


class NotesController extends Controller
{

    function addNote()
    {
        $request = new Request();

        Validator::execute($request, [
            'note' => 'required',
        ]);


        $insert = DB::table('demo_notes')->insert([
            "note" => $request->note,
            "status" => 'active',
        ]);
        return json([
            "message" => " Created Successfully"
        ]);
    }

    function getNotes()
    {
        $notes = DB::table('demo_notes')->orderBy('id', 'desc')->get();
        return json($notes);
    }


    function updateNote()
    {
        $request = new Request();
        $insert = DB::table('demo_notes')->update([
            "note" => $request->note,
            "status" => $request->status,
        ],
            [
                "id" => $request->id
            ]);

        return json([
            "message" => " Updated Successfully"
        ]);
    }


    function clearCompletedNote()
    {

        $insert = DB::table('demo_notes')->delete(
            [
                "status" => 'completed'
            ]);

        return json([
            "message" => "Cleared Successfully"
        ]);
    }


    function deleteNote()
    {
        $request = new Request();
        $insert = DB::table('demo_notes')->delete(
            [
                "id" => $request->id
            ]);

        return json([
            "message" => "Deleted Successfully"
        ]);
    }


}
