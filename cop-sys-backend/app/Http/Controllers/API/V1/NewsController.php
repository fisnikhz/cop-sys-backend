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

    /**
     * @OA\Post(
     *     path="/api/v1/news",
     *     summary="Add a new news",
     *     tags={"News"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="image", type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="News added successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/v1/news/{news}",
     *     summary="Update an existing news",
     *     tags={"News"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="news",
     *         in="path",
     *         required=true,
     *        
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="image", type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="News updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/v1/news/{news}",
     *     summary="Remove a news",
     *     tags={"News"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="news",
     *         in="path",
     *         required=true,
     *        
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="News deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News not found"
     *     )
     * )
     */

    public function removeNews(News $news): JsonResponse
    {
        $news->delete();

        return $this->respondWithSuccess(null, __('app.news.deleted'));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/news",
     *     summary="Get all news",
     *     tags={"News"},
     *     @OA\Response(
     *         response=200,
     *         description="News list retrieved successfully",
     *         
     *     )
     * )
     */

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


    /**
     * @OA\Get(
     *     path="/api/v1/news/{news}",
     *     summary="View a news",
     *     tags={"News"},
     *     @OA\Parameter(
     *         name="news",
     *         in="path",
     *         required=true,
     *       
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="News retrieved successfully",
     *         
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News not found"
     *     )
     * )
     */
    public function viewNews(News $news): JsonResponse
    {
        $news->increment('views');

        $news->refresh();

        return $this->respondWithSuccess(new NewsResource($news));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/news/top-viewed",
     *     summary="Get top viewed news",
     *     tags={"News"},
     *     @OA\Response(
     *         response=200,
     *         description="Top viewed news retrieved successfully",
     *         
     *     )
     * )
     */
    public function getTopViewedNews(): JsonResponse
    {
        $topNews = News::orderBy('views', 'desc')->take(3)->get();

        return $this->respondWithSuccess(NewsResource::collection($topNews));
    }
}
