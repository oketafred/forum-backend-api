<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Reply;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    public function likeIt(Reply $reply)
    {
        $like_count = $reply->like()->where('user_id', '1')->count();
        if($like_count > 0) {
            return response()->json(['error' => 'Reply already liked']);
        }

        $reply->like()->create([
            // 'user_id' => auth()->id()
            'user_id' => '1'
        ]);
        return response()->json($reply, Response::HTTP_CREATED);
    }

    public function unLikeIt(Reply $reply)
    {
        // $reply->like()->where('user_id', auth()->id())->first()->delete();
        $reply->like()->where('user_id', '1')->first()->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
