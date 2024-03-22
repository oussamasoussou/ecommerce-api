<?php

namespace App\Http\Controllers\Taille;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Taille;
use App\Traits\GeneralTrait;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Taille\TailleResource;
use App\Http\Requests\Taille\StoreTailleRequest;
use App\Http\Requests\Taille\UpdateTailleRequest;

class TailleController extends Controller
{
    use GeneralTrait;

    /**
     * @OA\Get(
     *      path="/api/tailles",
     *      operationId="getTailles",
     *      tags={"Taille"},
     *      summary="Récupérer la liste des tailles",
     *      description="Récupère la liste de toutes les tailles disponibles.",
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

    public function index()
    {
        try {
            $tailles = Taille::orderBy('prix', 'asc')->get();
            $taille = TailleResource::collection($tailles);
            return $this->returnData($taille, 200, 'Liste des taille réaccordées avec succès');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *      path="/api/tailles",
     *      operationId="createTaille",
     *      tags={"Taille"},
     *      summary="Créer une nouvelle taille",
     *      description="Crée une nouvelle taille avec les données fournies dans la requête.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"size"},
     *              @OA\Property(property="size", type="string", example="XL")
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

    public function store(StoreTailleRequest $request)
    {
        try {
            $taille = Taille::create([
                'size' => $request->size,
            ]);
            $tailleQuery = Taille::orderBy('id', 'desc')->get();
            $taille = TailleResource::collection($tailleQuery);
            return $this->returnData($taille, 200, 'Liste des taille réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *      path="/api/tailles/{id}",
     *      operationId="getTailleById",
     *      tags={"Taille"},
     *      summary="Récupérer une taille par ID",
     *      description="Récupère les détails d'une taille spécifiée par son ID.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la taille à récupérer",
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
            $taille = Taille::findOrFail($id);
            $taille = new TailleResource($taille);
            return $this->returnData($taille, 200, 'taille réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Put(
     *      path="/api/tailles/{id}",
     *      operationId="updateTaille",
     *      tags={"Taille"},
     *      summary="Mettre à jour une taille",
     *      description="Met à jour la taille spécifiée avec les données fournies dans la requête.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la taille à mettre à jour",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"size"},
     *              @OA\Property(property="size", type="string", example="XL")
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

    public function update(UpdateTailleRequest $request, string $id)
    {
        try {
            $taille = Taille::findOrFail($id);

            $dataToUpdate = $request->only(['size']);
            $taille->update($dataToUpdate);

            $tailleQuery = Taille::orderBy('id', 'desc')->get();
            $taille = TailleResource::collection($tailleQuery);

            return $this->returnData($taille, 200, 'Liste des taille réaccordé avec succès');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/tailles/{id}",
     *      operationId="deleteTaille",
     *      tags={"Taille"},
     *      summary="Supprimer une taille",
     *      description="Supprime la taille spécifiée.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la taille à supprimer",
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
            $taille = Taille::findOrFail($id);
            $taille->delete();
            $tailleQuery = Taille::orderBy('id', 'desc')->get();
            $taille = TailleResource::collection($tailleQuery);
            return $this->returnData($taille, 200, 'Liste des taille réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }
}
