<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Response;

class FinderController extends Controller
{
    
    public function index()
    {
        return view('finder');
    }

    public function search(Request $request)
    {
        $get_data = Book::whereRaw("title LIKE '%".$request->title."%'")->orderBy('title', 'ASC')->get();

        $html = '<p>Hasil penelusuran dari : <b>'.$request->title.'</b></p>';
        $html .= '<table class="table table-hover table-bordered table-striped" width="100%">';
        $html .= '<tr>';
        $html .= '<th width="40%">Title</th>';
        $html .= '<th>Author</th>';
        $html .= '<th>Genre</th>';
        $html .= '<th>Vote Count</th>';
        $html .= '</tr>';
        foreach($get_data as $row){
            $html .= '<tr>';
            $html .= '<td>'.ucwords($row->title).'</td>';
            $html .= '<td>'.$row->author.'</td>';
            $html .= '<td>'.$row->genre.'</td>';
            $html .= '<td><button class="btn btn-lg btn-primary" onclick="addVote('.$row->id.')" type="button"><i class="fas fa-thumbs-up"></i> VOTE</button> &nbsp; <span id="count_'.$row->id.'">'.number_format($row->vote_count, 0).'</span></td>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        $response = array(
            'html' => $html,
        );

        return Response::json($response);
    }

    public function vote(Request $request)
    {
        $model = Book::find($request->id);
        $model->vote_count = $model->vote_count + 1;
        if($model->save()){
            $status = "Vote Success";
        }
        else{
            $status = "Vote Failed";
        }
        
        $response = array(
            'status' => $status,
            'total' => $model->vote_count,
        );

        return Response::json($response);
    
    }
}
