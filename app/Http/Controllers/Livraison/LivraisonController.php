<?php

namespace App\Http\Controllers\Livraison;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Livraison;
use App\Traits\GeneralTrait;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Livraison\LivraisonResource;
use App\Http\Requests\Livraison\StoreLivraisonRequest;
use App\Http\Requests\Livraison\UpdateLivraisonRequest;

class LivraisonController extends Controller
{
    use GeneralTrait;

    /**
     * @OA\Get(
     *      path="/api/livraisons",
     *      operationId="getLivraisons",
     *      tags={"Livraison"},
     *      summary="Récupère la liste des livraisons",
     *      description="Récupère la liste de toutes les livraisons disponibles.",
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
    public function index(Request $request)
    {
        try {
            $livraisons = Livraison::orderBy('prix', 'asc')->get();
            $livraison = LivraisonResource::collection($livraisons);
            return $this->returnData($livraison, 200, 'Liste des livraison réaccordées avec succès');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *      path="/api/livraisons",
     *      operationId="createLivraison",
     *      tags={"Livraison"},
     *      summary="Crée une nouvelle livraison",
     *      description="Crée une nouvelle livraison avec les données fournies dans la requête.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"prix", "description1", "description2"},
     *              @OA\Property(property="prix", type="number", format="float", example=10.99),
     *              @OA\Property(property="description1", type="string", example="Description 1"),
     *              @OA\Property(property="description2", type="string", example="Description 2")
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

    public function store(Request $request)
    {
        try {
            $livraison = Livraison::create([
                'prix' => $request->prix,
                'description1' => $request->description1,
                'description2' => $request->description2,
            ]);
            $livraisonQuery = Livraison::orderBy('id', 'desc')->get();
            $livraison = LivraisonResource::collection($livraisonQuery);
            return $this->returnData($livraison, 200, 'Liste des livraison réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }
    /**
     * @OA\Get(
     *      path="/api/livraisons/{id}",
     *      operationId="getLivraisonById",
     *      tags={"Livraison"},
     *      summary="Obtient une livraison par son ID",
     *      description="Récupère les détails d'une livraison spécifiée par son ID.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la livraison à récupérer",
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
            $livraison = Livraison::findOrFail($id);
            $livraison = new LivraisonResource($livraison);
            return $this->returnData($livraison, 200, 'livraison réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }
    /**
     * @OA\Put(
     *      path="/api/livraisons/{id}",
     *      operationId="updateLivraison",
     *      tags={"Livraison"},
     *      summary="Met à jour une livraison",
     *      description="Met à jour une livraison spécifiée par son ID avec les données fournies dans la requête.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la livraison à mettre à jour",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"prix", "description1", "description2"},
     *              @OA\Property(property="prix", type="number", format="float", example=10.99),
     *              @OA\Property(property="description1", type="string", example="Description 1 mise à jour"),
     *              @OA\Property(property="description2", type="string", example="Description 2 mise à jour")
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

    public function update(Request $request, string $id)
    {
        try {
            $livraison = Livraison::findOrFail($id);

            $dataToUpdate = $request->only(['prix', 'description1', 'description2']);
            $livraison->update($dataToUpdate);

            $livraisonQuery = Livraison::orderBy('id', 'desc')->get();
            $livraison = LivraisonResource::collection($livraisonQuery);

            return $this->returnData($livraison, 200, 'Liste des livraison réaccordé avec succès');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/livraisons/{id}",
     *      operationId="delete-livraison",
     *      tags={"Livraison"},
     *      summary="Supprime une livraison",
     *      description="Supprime une livraison spécifiée par son ID.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la livraison à supprimer",
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
            $livraison = Livraison::findOrFail($id);
            $livraison->delete();
            $livraisonQuery = Livraison::orderBy('id', 'desc')->get();
            $livraison = LivraisonResource::collection($livraisonQuery);
            return $this->returnData($livraison, 200, 'Liste des livraison réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }
}
