<?php

namespace App\Http\Controllers\Categorie;

use App\Http\Controllers\Controller;
use App\Http\Resources\Categorie\SousSousCategorieResource;
use App\Services\SousSousCategoriee;
use App\Traits\GeneralTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use App\Models\SousSousCategorie;
use App\Http\Requests\Categorie\SousSousCategorie\IndexSousSousCategorieRequest;
use App\Http\Requests\Categorie\SousSousCategorie\StoreSousSousCategorieRequest;
use App\Http\Requests\Categorie\SousSousCategorie\UpdateSousSousCategorieRequest;


class SousSouSCategotieController extends Controller
{
    use GeneralTrait;

    /**
     * @OA\Get(
     *     path="/api/sous-sous-categorie",
     *     tags={"Sous Sous Catégorie"},
     *     summary="Get-all-sous-sous-categorie.",
     *     description="Get all sous-sous-categorie.",
     * 
     *  @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         description="Mot-clé à rechercher pour for agents",
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
    public function index(IndexSousSousCategorieRequest $request, Builder $query)
    {
        try {
            $sousSousCategorieQuery = SousSousCategorie::query();
            if ($request->has('keyword')) {
                $keyword = '%' . $request->input('keyword') . '%';
                $sousSousCategorieQuery->where('name', 'like', $keyword);
            }
            $sousSousCategories = $sousSousCategorieQuery->orderBy('name', 'asc')->get();
            $sousSousCategorie = SousSousCategorieResource::collection($sousSousCategories);
            return $this->returnData($sousSousCategorie, 200, 'Liste des sous sous categorie réaccordées avec succès');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }
    /**
     * @OA\Post(
     *      path="/api/sous-sous-categorie",
     *      operationId="store-sous-sous-categorie",
     *      tags={"Sous Sous Catégorie"},
     *      summary="Crée une nouvelle sous-sous-catégorie",
     *      description="Crée une nouvelle sous-sous-catégorie à partir des données fournies dans la requête.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name", "sousCategorieId"},
     *              @OA\Property(property="name", type="string", example="Nom de la sous-sous-catégorie"),
     *              @OA\Property(property="sousCategorieId", type="integer", example=1, description="ID de la sous catégorie parente")

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

    public function store(StoreSousSousCategorieRequest $request)
    {
        try {
            $sousSousCategorie = SousSousCategorie::create([
                'name' => $request->name,
                'sous_categorie_id' => $request->sousCategorieId
            ]);
            $sousSousCategorieQuery = SousSousCategorie::orderBy('id', 'desc')->get();
            $sousSousCategorie = SousSousCategorieResource::collection($sousSousCategorieQuery);
            return $this->returnData($sousSousCategorie, 200, 'Liste des sous sous categorie réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *      path="/api/sous-sous-categorie/{id}",
     *      operationId="get-sous-sous-categorie-by-id",
     *      tags={"Sous Sous Catégorie"},
     *      summary="Récupère une sous-sous-catégorie par son ID",
     *      description="Récupère une sous-sous-catégorie spécifiée par son ID.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la sous-sous-catégorie à récupérer",
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
            $sousSousCategorie = SousSousCategorie::findOrFail($id);
            $sousSousCategorie = new SousSousCategorieResource($sousSousCategorie);
            return $this->returnData($sousSousCategorie, 200, 'Sous sous categorie réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Put(
     *      path="/api/sous-sous-categorie/{id}",
     *      operationId="update-sous-sous-categorie",
     *      tags={"Sous Sous Catégorie"},
     *      summary="Met à jour une sous-sous-catégorie",
     *      description="Met à jour une sous-sous-catégorie spécifiée par son ID avec les données fournies dans la requête.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la sous-sous-catégorie à mettre à jour",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Nom de la sous-sous-catégorie"),
     *              @OA\Property(property="sousCategorieId", type="integer", example=1, description="ID de la sous catégorie parente")

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

    public function update(UpdateSousSousCategorieRequest $request, string $id)
    {
        try {
            $sousSousCategorie = SousSousCategorie::findOrFail($id);

            $dataToUpdate = $request->only(['name', 'sousCategorieId']);
            $sousSousCategorie->update($dataToUpdate);

            $sousSousCategorieQuery = SousSousCategorie::orderBy('id', 'desc')->get();
            $sousSousCategorie = SousSousCategorieResource::collection($sousSousCategorieQuery);

            return $this->returnData($sousSousCategorie, 200, 'Liste des sous sous categorie réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/sous-sous-categorie/{id}",
     *      operationId="delete-sous-sous-categorie",
     *      tags={"Sous Sous Catégorie"},
     *      summary="Supprime une sous-sous-catégorie",
     *      description="Supprime une sous-sous-catégorie spécifiée par son ID.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la sous-sous-catégorie à supprimer",
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
            $sousSousCategorie = SousSousCategorie::findOrFail($id);
            $sousSousCategorie->delete();
            $sousSousCategorieQuery = SousSousCategorie::orderBy('id', 'desc')->get();
            $sousSousCategorie = SousSousCategorieResource::collection($sousSousCategorieQuery);
            return $this->returnData($sousSousCategorie, 200, 'Liste des sous sous categorie réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }
}
