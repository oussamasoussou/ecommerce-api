<?php

namespace App\Http\Controllers\Categorie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Http\Response;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Categorie\CategorieResource;
use App\Http\Requests\Categorie\Categorie\IndexCategorieRequest;
use App\Http\Requests\Categorie\Categorie\StoreCategorieRequest;
use App\Http\Requests\Categorie\Categorie\UpdateCategorieRequest;

class CategorieController extends Controller
{
    use GeneralTrait;

    /**
     * @OA\Get(
     *     path="/api/categorie",
     *     tags={"Catégorie"},
     *     summary="Get all categorie.",
     *     description="Get all categorie.",
     * 
     *  @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         description="Mot-clé à rechercher pour for category",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found",
     *     )
     * )
     */
    public function index(IndexCategorieRequest $request)
    {
        try {
            $categorieQuery = Categorie::query();
            if ($request->has('keyword')) {
                $keyword = '%' . $request->input('keyword') . '%';
                $categorieQuery->where('name', 'like', $keyword);
            }
            $categories = $categorieQuery->orderBy('name', 'asc')->get();
            $categorie = CategorieResource::collection($categories);
            return $this->returnData($categorie, 200, 'Liste des categorie réaccordées avec succès');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *      path="/api/categorie",
     *      operationId="storeSousSousCategorie",
     *      tags={"Sous Sous Catégorie"},
     *      summary="Crée une nouvelle catégorie",
     *      description="Crée une nouvelle catégorie à partir des données fournies dans la requête.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Nom de la catégorie")
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found",
     *     )
     * )
     */


    public function store(StoreCategorieRequest $request)
    {
        try {
            $categorie = Categorie::create([
                'name' => $request->name,
            ]);
            $categorieQuery = Categorie::orderBy('id', 'desc')->get();
            $categorie = CategorieResource::collection($categorieQuery);
            return $this->returnData($categorie, 200, 'Liste des categorie réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *      path="/api/categorie/{id}",
     *      operationId="getSousSousCategorieById",
     *      tags={"Sous Sous Catégorie"},
     *      summary="Récupère une catégorie par son ID",
     *      description="Récupère une catégorie spécifiée par son ID.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la catégorie à récupérer",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found",
     *     )
     * )
     */

    public function show(string $id)
    {
        try {
            $categorie = Categorie::findOrFail($id);
            $categorie = new CategorieResource($categorie);
            return $this->returnData($categorie, 200, 'Categorie réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Put(
     *      path="/api/categorie/{id}",
     *      operationId="updateSousSousCategorie",
     *      tags={"Sous Sous Catégorie"},
     *      summary="Met à jour une catégorie",
     *      description="Met à jour une catégorie spécifiée par son ID avec les données fournies dans la requête.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la catégorie à mettre à jour",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="name", type="string", example="Nouveau nom de la catégorie")
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found",
     *     )
     * )
     */

    public function update(UpdateCategorieRequest $request, string $id)
    {
        try {
            $categorie = Categorie::findOrFail($id);

            $dataToUpdate = $request->only(['name']);
            $categorie->update($dataToUpdate);

            $categorieQuery = Categorie::orderBy('id', 'desc')->get();
            $categorie = CategorieResource::collection($categorieQuery);

            return $this->returnData($categorie, 200, 'Liste des categorie réaccordé avec succès');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/categorie/{id}",
     *      operationId="deleteSousSousCategorie",
     *      tags={"Sous Sous Catégorie"},
     *      summary="Supprime une catégorie",
     *      description="Supprime une catégorie spécifiée par son ID.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la catégorie à supprimer",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found",
     *     )
     * )
     */

    public function destroy(string $id)
    {
        try {
            $categorie = Categorie::findOrFail($id);
            $categorie->delete();
            $categorieQuery = Categorie::orderBy('id', 'desc')->get();
            $categorie = CategorieResource::collection($categorieQuery);
            return $this->returnData($categorie, 200, 'Liste des categorie réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }
}
