<?php

namespace App\controller\api;

use App\system\controller\Controller;
use App\system\request\Request;
use PluginMaster\DB\DB;


class NotesController extends Controller
{

    function addNote()
    {
        $request = new Request();

        $request->validate([
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
        $update = DB::table('demo_notes')
            ->where('id', $request->id)
            ->update([
                "note" => $request->note,
                "status" => $request->status,
            ]);

        return json([
            "message" => " Updated Successfully"
        ]);
    }


    function clearCompletedNote()
    {

        $insert = DB::table('demo_notes')
            ->where('status', 'completed')
            ->delete();

        return json([
            "message" => "Cleared Successfully"
        ]);
    }


    function deleteNote()
    {
        $request = new Request();
        $delete = DB::table('demo_notes')
            ->where("id", $request->id)
            ->delete();

        return json([
            "message" => "Deleted Successfully ssssssssssss",
            "delete" => $delete,
        ]);


    }


}
