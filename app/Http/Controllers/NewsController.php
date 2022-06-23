<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Auth\Access\AuthorizationException;
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
        $user = request()->user();
        return NewsResource::collection($user->news()->with('user')->paginate(100));
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

        return new NewsResource($news->load('user'));

    }

    /**
     * Display the specified resource.
     * @param News $news
     * @return NewsResource
     * @throws AuthorizationException
     */
    public function show(News $news)
    {
        $this->authorize('update', $news);
        return new NewsResource($news->load('user'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param NewsRequest $request
     * @param News $news
     * @return NewsResource
     * @throws AuthorizationException
     */
    public function update(NewsRequest $request, News $news)
    {
        $this->authorize('update', $news);

        $news->update($request->validationData());

        return new NewsResource($news->load('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News $news
     * @return NewsResource
     * @throws AuthorizationException
     */
    public function destroy(News $news)
    {
        $this->authorize('update', $news);

       $news->delete();
       return new NewsResource($news);
    }
}
