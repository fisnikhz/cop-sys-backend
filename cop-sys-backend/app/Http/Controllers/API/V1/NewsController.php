<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\API\V1\News\CreateNewsRequest;
use App\Http\Requests\API\V1\News\UpdateNewsRequest;
use App\Http\Resources\API\V1\NewsResource;
use App\Models\News;
use Illuminate\Http\JsonResponse;

class NewsController extends APIController
{
    public function addNews(CreateNewsRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->user_id;
        unset($data['image']);

        $newsData = News::create($data);

        if ($request->hasFile('image')) {
            $newsData->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        return $this->respondWithSuccess(new NewsResource($newsData));
    }

    public function updateNews(UpdateNewsRequest $request, News $news): JsonResponse
    {
        $data = $request->validated();
        unset($data['image']);

        $news->update($data);

        if ($request->hasFile('image')) {
            $news->clearMediaCollection('images');
            $news->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        return $this->respondWithSuccess(new NewsResource($news));
    }

    public function removeNews(News $news): JsonResponse
    {
        $news->delete();

        return $this->respondWithSuccess(null, __('app.news.deleted'));
    }

    public function allNews(): JsonResponse
    {
        $news = News::orderBy('created_at', 'desc')->paginate(12);

        return $this->respondWithSuccess(NewsResource::collection($news));
    }
//
//    public function getTopViewedNews(): JsonResponse
//    {
//        $topNews = News::orderBy('views', 'desc')->take(3)->get();
//
//        return $this->respondWithSuccess(NewsResource::collection($topNews));
//    }
//}
//        $news = News::orderBy('created_at', 'desc')->get();
//
//        $currentPage = LengthAwarePaginator::resolveCurrentPage();
//        $currentItems = $news->slice(($currentPage - 1) * $perPage, $perPage);
//        $paginator = new LengthAwarePaginator($currentItems, $news->count(), $perPage, $currentPage, [
//            'path' => LengthAwarePaginator::resolveCurrentPath(),
//        ]);
//
//        return $this->respondWithSuccess(
//            NewsResource::collection($paginator),
//            ['pagination' => $paginator]
//        );
//    }

    public function viewNews(News $news): JsonResponse
    {
        $news->increment('views');

        $news->refresh();

        return $this->respondWithSuccess(new NewsResource($news));
    }

    public function getTopViewedNews(): JsonResponse
    {
        $topNews = News::orderBy('views', 'desc')->take(3)->get();

        return $this->respondWithSuccess(NewsResource::collection($topNews));
    }
}
