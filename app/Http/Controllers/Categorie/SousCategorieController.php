<?php

namespace App\Http\Controllers\Categorie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Http\Response;
use App\Models\SousCategorie;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Categorie\SousCategorieResource;
use App\Http\Requests\Categorie\SousCategorie\IndexSousCategorieRequest;
use App\Http\Requests\Categorie\SousCategorie\StoreSousCategorieRequest;
use App\Http\Requests\Categorie\SousCategorie\UpdateSousCategorieRequest;

class SousCategorieController extends Controller
{
    use GeneralTrait;

    /**
     * @OA\Get(
     *     path="/api/sous-categorie",
     *     tags={"Sous Catégorie"},
     *     summary="Get all sous-categorie.",
     *     description="Get all sous-categorie.",
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
    public function index(IndexSousCategorieRequest $request)
    {
        try {
            $sousCategorieQuery = SousCategorie::query();
            if ($request->has('keyword')) {
                $keyword = '%' . $request->input('keyword') . '%';
                $sousCategorieQuery->where('name', 'like', $keyword);
            }
            $sousCategories = $sousCategorieQuery->orderBy('name', 'asc')->get();
            $sousCategorie = SousCategorieResource::collection($sousCategories);
            return $this->returnData($sousCategorie, 200, 'Liste des sous categorie réaccordées avec succès');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *      path="/api/sous-categorie",
     *      operationId="storeSousCategorie",
     *      tags={"Sous Catégorie"},
     *      summary="Crée une nouvelle sous-catégorie",
     *      description="Crée une nouvelle sous-catégorie à partir des données fournies dans la requête.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name", "sousSousCategorieId"},
     *              @OA\Property(property="name", type="string", example="Nom de la sous-catégorie"),
     *              @OA\Property(property="sousSousCategorieId", type="integer", example=1, description="ID de la sous-sous-catégorie parente")
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

    public function store(StoreSousCategorieRequest $request)
    {
        try {
            $sousCategorie = SousCategorie::create([
                'name' => $request->name,
                'sous_sous_categorie_id' => $request->sousSousCategorieId,
            ]);
            $sousCategorieQuery = SousCategorie::orderBy('id', 'desc')->get();
            $sousCategorie = SousCategorieResource::collection($sousCategorieQuery);
            return $this->returnData($sousCategorie, 200, 'Liste des sous categorie réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *      path="/api/sous-categorie/{id}",
     *      operationId="getSousCategorieById",
     *      tags={"Sous Catégorie"},
     *      summary="Récupère une sous-catégorie par son ID",
     *      description="Récupère une sous-catégorie spécifiée par son ID.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la sous-catégorie à récupérer",
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
            $sousCategorie = SousCategorie::findOrFail($id);
            $sousCategorie = new SousCategorieResource($sousCategorie);
            return $this->returnData($sousCategorie, 200, 'Sous categorie réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Put(
     *      path="/api/sous-categorie/{id}",
     *      operationId="updateSousCategorie",
     *      tags={"Sous Catégorie"},
     *      summary="Met à jour une sous-catégorie",
     *      description="Met à jour une sous-catégorie spécifiée par son ID avec les données fournies dans la requête.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la sous-catégorie à mettre à jour",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name", "sousSousCategorieId"},
     *              @OA\Property(property="name", type="string", example="Nouveau nom de la sous-catégorie"),
     *              @OA\Property(property="sousSousCategorieId", type="integer", example=1, description="ID de la sous-sous-catégorie parente")
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


    public function update(UpdateSousCategorieRequest $request, string $id)
    {
        try {
            $sousCategorie = SousCategorie::findOrFail($id);

            $dataToUpdate = $request->only(['name', 'sousSousCategorieId']);
            $sousCategorie->update($dataToUpdate);

            $sousCategorieQuery = SousCategorie::orderBy('id', 'desc')->get();
            $sousCategorie = SousCategorieResource::collection($sousCategorieQuery);

            return $this->returnData($sousCategorie, 200, 'Liste des sous categorie réaccordé avec succès');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }
    /**
     * @OA\Delete(
     *      path="/api/sous-categorie/{id}",
     *      operationId="deleteSousCategorie",
     *      tags={"Sous Catégorie"},
     *      summary="Supprime une sous-catégorie",
     *      description="Supprime une sous-catégorie spécifiée par son ID.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la sous-catégorie à supprimer",
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
            $sousCategorie = SousCategorie::findOrFail($id);
            $sousCategorie->delete();
            $sousCategorieQuery = SousCategorie::orderBy('id', 'desc')->get();
            $sousCategorie = SousCategorieResource::collection($sousCategorieQuery);
            return $this->returnData($sousCategorie, 200, 'Liste des sous sous categorie réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }
}
