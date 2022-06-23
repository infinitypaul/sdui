<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return NewsResource::collection(News::paginate(100));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsRequest $request
     * @return NewsResource
     */
    public function store(NewsRequest $request)
    {
        $news = new News();
        $news->title  =  $request->title;
        $news->content  =  $request->content;
        $news->user()->associate($request->user());
        $news->save();

        return new NewsResource($news);

    }

    /**
     * Display the specified resource.
     * @param News $news
     * @return NewsResource
     */
    public function show(News $news)
    {
        return new NewsResource($news);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param NewsRequest $request
     * @param News $news
     * @return NewsResource
     */
    public function update(NewsRequest $request, News $news)
    {
        $news->title = $request->title;
        $news->content = $request->content;
        $news->save();

        return new NewsResource($news);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News $news
     * @return NewsResource
     */
    public function destroy(News $news)
    {
       $news->delete();
       return new NewsResource($news);
    }
}
